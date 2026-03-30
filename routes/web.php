<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LppController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ProfileController;
use App\Models\Assignment;
use App\Models\Submission;

// ================== ROOT ==================
Route::get('/', function () {
    return Auth::check() ? redirect('/kelas') : redirect('/login');
});

// ================== GUEST (Belum Login) ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ================== AUTHENTICATED ROUTES (Sudah Login) ==================
Route::middleware('auth')->group(function () {
    
    // Logout & Profile
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/avatar/{id}', [ProfileController::class, 'avatar'])->name('profile.avatar');

    // ================== LPP & THREAD ==================
    Route::post('/lpp', [LppController::class, 'store'])->name('lpp.store');
    Route::put('/lpp/{id}', [LppController::class, 'update'])->name('lpp.update');
    Route::delete('/lpp/{id}', [LppController::class, 'destroy'])->name('lpp.destroy');
    Route::get('/lpp/{id}/file', [LppController::class, 'downloadLppFile'])->name('lpp.file');
    Route::get('/lpp/{id}/file/preview', [LppController::class, 'previewLppFile'])->name('lpp.file.preview');
    Route::get('/lpp/attachment/{id}/file', [LppController::class, 'downloadAttachmentFile'])->name('lpp.attachment.file');
    Route::get('/lpp/attachment/{id}/file/preview', [LppController::class, 'previewAttachmentFile'])->name('lpp.attachment.file.preview');
    Route::get('/lpp/{id}', [LppController::class, 'show'])->name('lpp.show');
    
    Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store');
    Route::post('/submissions/{id}/grade', [LppController::class, 'gradeSubmission'])->name('submissions.grade');
    Route::post('/submissions/{id}/unsubmit', [LppController::class, 'unsubmit'])->name('submissions.unsubmit');
    Route::get('/submissions/{id}/file', [LppController::class, 'downloadSubmissionFile'])->name('submissions.file');
    Route::get('/submissions/{id}/file/preview', [LppController::class, 'previewSubmissionFile'])->name('submissions.file.preview');

    // ================== HALAMAN TUGAS ==================
    Route::get('/tugas', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->role == 'dosen') {
            $classroomIds = $user->taughtClassrooms()->pluck('classrooms.id');
            $classrooms = \App\Models\Classroom::where('dosen_id', $user->id)->latest()->get();
        } else {
            $classroomIds = $user->joinedClassrooms()->pluck('classrooms.id');
            $classrooms = $user->joinedClassrooms()->latest()->get();
        }

        $assignments = \App\Models\Assignment::with(['lpp.classroom', 'submissions' => function($q) use ($user) {
            $q->where('user_id', $user->id);
        }])
        ->whereHas('lpp', function($query) use ($classroomIds) {
            $query->whereIn('classroom_id', $classroomIds);
        })
        ->orderBy('deadline', 'asc')
        ->get();

        // Fallback agar data submission lama (hanya lpp_id) tetap terbaca sebagai sudah dikumpulkan.
        $submittedAssignmentIds = Submission::where('user_id', $user->id)
            ->whereNotNull('assignment_id')
            ->pluck('assignment_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $submittedLppIds = Submission::where('user_id', $user->id)
            ->whereNull('assignment_id')
            ->whereNotNull('lpp_id')
            ->pluck('lpp_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $ditugaskan = collect();
        $belumDiserahkan = collect();
        $selesai = collect();

        foreach ($assignments as $tugas) {
            $isPastDeadline = \Carbon\Carbon::parse($tugas->deadline)->isPast();
            $hasSubmitted = $tugas->submissions->isNotEmpty()
                || in_array((int) $tugas->id, $submittedAssignmentIds, true)
                || in_array((int) $tugas->lpp_id, $submittedLppIds, true);

            if ($hasSubmitted) {
                $selesai->push($tugas);
            } elseif ($isPastDeadline) {
                $belumDiserahkan->push($tugas); 
            } else {
                $ditugaskan->push($tugas); 
            }
        }
        return view('tugas', compact('ditugaskan', 'belumDiserahkan', 'selesai', 'classrooms')); 
    })->name('tugas');

    Route::get('/tugas/{id}', function ($id) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $assignment = Assignment::with(['lpp.classroom', 'lpp.attachments'])->findOrFail($id);

        if ($user->role === 'dosen') {
            $isAllowed = $user->taughtClassrooms()->where('classrooms.id', $assignment->lpp->classroom_id)->exists();
        } else {
            $isAllowed = $user->joinedClassrooms()->where('classrooms.id', $assignment->lpp->classroom_id)->exists();
        }

        abort_unless($isAllowed, 403);

        $submissionHistory = Submission::where('user_id', $user->id)
            ->where(function ($query) use ($assignment) {
                $query->where('assignment_id', $assignment->id)
                    ->orWhere(function ($subQuery) use ($assignment) {
                        $subQuery->whereNull('assignment_id')
                            ->where('lpp_id', $assignment->lpp_id);
                    });
            })
            ->latest()
            ->get();

        $submission = $submissionHistory->first();

        return view('pengumpulan_tugas', compact('assignment', 'submission', 'submissionHistory'));
    })->name('tugas.detail');
    
    // ================== KELAS ==================
    Route::get('/kelas', [ClassroomController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [ClassroomController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [ClassroomController::class, 'store'])->name('kelas.store');
    Route::get('/kelas-join', [ClassroomController::class, 'join'])->name('kelas.join');
    Route::post('/kelas-join', [ClassroomController::class, 'storeJoin'])->name('kelas.storeJoin');
    Route::get('/kelas/{id}', [ClassroomController::class, 'show'])->name('kelas.show');
    Route::get('/kelas/{id}/edit', [ClassroomController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [ClassroomController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [ClassroomController::class, 'destroy'])->name('kelas.destroy');
    Route::post('/lpp/upload', [LppController::class, 'upload'])->name('lpp.upload');
    Route::get('/lpp/{id}', [LppController::class, 'show'])->name('lpp.show');
});