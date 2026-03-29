<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LppController;
use App\Http\Controllers\ThreadController;

Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store');

// ================== ROOT ==================
Route::get('/', function () {
    return Auth::check() ? redirect('/kelas') : redirect('/login');
});

// ================== GUEST ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Halaman Tugas
    Route::get('/tugas', function () {
        $user = Auth::user();
        
        // 1. Ambil ID kelas DAN daftar kelas untuk Sidebar
        if ($user->role == 'dosen') {
            $classroomIds = $user->taughtClassrooms()->pluck('classrooms.id');
            $classrooms = \App\Models\Classroom::where('dosen_id', $user->id)->latest()->get();
        } else {
            $classroomIds = $user->joinedClassrooms()->pluck('classrooms.id');
            $classrooms = \App\Models\Classroom::latest()->get();
        }

        // 2. Ambil data tugas beserta status pengumpulan
        $assignments = \App\Models\Assignment::with(['lpp.classroom', 'submissions' => function($q) use ($user) {
            $q->where('student_id', $user->id); 
        }])
        ->whereHas('lpp', function($query) use ($classroomIds) {
            $query->whereIn('classroom_id', $classroomIds);
        })
        ->orderBy('deadline', 'asc')
        ->get();

        // 3. Pisahkan ke 3 kategori
        $ditugaskan = collect();
        $belumDiserahkan = collect();
        $selesai = collect();

        foreach ($assignments as $tugas) {
            $isPastDeadline = \Carbon\Carbon::parse($tugas->deadline)->isPast();
            $hasSubmitted = $tugas->submissions->isNotEmpty(); 

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
    Route::get('/kelas', [ClassroomController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [ClassroomController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [ClassroomController::class, 'store'])->name('kelas.store');
    Route::get('/kelas-join', [ClassroomController::class, 'join'])->name('kelas.join');
    Route::post('/kelas-join', [ClassroomController::class, 'storeJoin'])->name('kelas.storeJoin');
    Route::get('/kelas/{id}', [ClassroomController::class, 'show'])->name('kelas.show');
    Route::get('/kelas/{id}/edit', [ClassroomController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [ClassroomController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [ClassroomController::class, 'destroy'])->name('kelas.destroy');
});

    // Profile
    Route::get('/profile', function () {
        return view('profile');
    });

    // ================== LPP ==================
    Route::get('/lpp/{id}', [LppController::class, 'show'])->name('lpp.show');
    Route::post('/lpp/upload', [LppController::class, 'upload'])->name('lpp.upload');