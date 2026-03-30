<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Thread;
use App\Models\Lpp;
use App\Models\LppAttachment;
use App\Models\Classroom;
use App\Models\Notification;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LppController extends Controller
{
    // ================== TAMPILKAN LPP ==================
    public function show($id)
    {
        $lpp = Lpp::with(['submissions.user', 'attachments', 'classroom.students', 'classroom.dosen'])->findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role === 'dosen') {
            abort_unless($lpp->classroom->dosen_id === $user->id, 403);
        } else {
            abort_unless($user->joinedClassrooms()->where('classrooms.id', $lpp->classroom_id)->exists(), 403);
            if ($lpp->publish_at && $lpp->publish_at->isFuture()) {
                abort(403);
            }
        }

        $assignments = Assignment::where('lpp_id', $id)->get();
        $threads = Thread::with('user')->where('lpp_id', $id)->latest()->get();
        $notifications = Notification::where('user_id', $user->id)->latest()->get();
        $latestSubmissions = $lpp->submissions
            ->sortByDesc('created_at')
            ->groupBy('user_id')
            ->map(function ($items) {
                return $items->first();
            });
        $currentUserSubmission = $lpp->submissions()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('lpp.detail', compact('lpp', 'assignments', 'threads', 'notifications', 'latestSubmissions', 'currentUserSubmission'));
    }

    // ================== BUAT MATERI BARU + UPLOAD ==================
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'dosen') abort(403);

        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'type' => 'required|in:announcement,assignment',
            'topic' => 'nullable|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_at' => 'nullable|date',
            'deadline' => 'nullable|date',
            'max_points' => 'nullable|integer|min:1|max:1000',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:4096',
            'attachment_links.*' => 'nullable|url|max:2048',
        ]);

        if ($request->input('type') === 'assignment') {
            $request->validate([
                'deadline' => 'required|date',
                'max_points' => 'required|integer|min:1|max:1000',
            ]);
        }

        $classroom = Classroom::findOrFail($request->classroom_id);
        abort_unless($classroom->dosen_id === Auth::id(), 403);

        $publishAt = $this->parseLocalDateTimeToAppTimezone($request->input('publish_at'));
        $deadline = $this->parseLocalDateTimeToAppTimezone($request->input('deadline'));

        if ($publishAt && $deadline && $publishAt->gt($deadline)) {
            return back()->withErrors(['deadline' => 'Deadline tidak boleh lebih awal dari jadwal publish.'])->withInput();
        }

        $lpp = new Lpp();
        $lpp->classroom_id = $request->classroom_id;
        $lpp->type = $request->input('type', 'announcement');
        $lpp->topic = $request->topic;
        $lpp->publish_at = $publishAt;
        $lpp->title = $request->title;
        $lpp->description = $request->description;
        $lpp->deadline = $deadline;
        $lpp->max_points = $request->max_points;

        $lpp->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $storedPath = $file->store('materi', 'public');
                LppAttachment::create([
                    'lpp_id' => $lpp->id,
                    'attachment_type' => 'file',
                    'file_path' => $storedPath,
                ]);
            }
        }

        if ($request->filled('attachment_links')) {
            foreach ($request->attachment_links as $linkUrl) {
                if (!$linkUrl) {
                    continue;
                }

                LppAttachment::create([
                    'lpp_id' => $lpp->id,
                    'attachment_type' => 'link',
                    'link_url' => $linkUrl,
                ]);
            }
        }

        if ($lpp->type === 'assignment') {
            Assignment::updateOrCreate(
                ['lpp_id' => $lpp->id],
                [
                    'title' => $lpp->title,
                    'description' => $lpp->description,
                    'deadline' => $lpp->deadline,
                    'max_exp' => $lpp->max_points,
                ]
            );
        }

        $users = $lpp->classroom->students;
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => ($lpp->type === 'assignment' ? 'Tugas baru: ' : 'Pengumuman baru: ') . $lpp->title
            ]);
        }

        return back()->with('success', 'Posting berhasil dibagikan!');
    }

    // ================== EDIT MATERI ==================
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'dosen') abort(403);

        $request->validate([
            'type' => 'required|in:announcement,assignment',
            'topic' => 'nullable|string|max:120',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_at' => 'nullable|date',
            'deadline' => 'nullable|date',
            'max_points' => 'nullable|integer|min:1|max:1000',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:4096',
            'attachment_links.*' => 'nullable|url|max:2048',
        ]);

        if ($request->input('type') === 'assignment') {
            $request->validate([
                'deadline' => 'required|date',
                'max_points' => 'required|integer|min:1|max:1000',
            ]);
        }

        $publishAt = $this->parseLocalDateTimeToAppTimezone($request->input('publish_at'));
        $deadline = $this->parseLocalDateTimeToAppTimezone($request->input('deadline'));

        if ($publishAt && $deadline && $publishAt->gt($deadline)) {
            return back()->withErrors(['deadline' => 'Deadline tidak boleh lebih awal dari jadwal publish.'])->withInput();
        }

        $lpp = Lpp::findOrFail($id);
        abort_unless($lpp->classroom->dosen_id === Auth::id(), 403);

        $lpp->type = $request->type;
        $lpp->topic = $request->topic;
        $lpp->publish_at = $publishAt;
        $lpp->title = $request->title;
        $lpp->description = $request->description;
        $lpp->deadline = $deadline;
        $lpp->max_points = $request->max_points;

        $lpp->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $storedPath = $file->store('materi', 'public');
                LppAttachment::create([
                    'lpp_id' => $lpp->id,
                    'attachment_type' => 'file',
                    'file_path' => $storedPath,
                ]);
            }
        }

        if ($request->filled('attachment_links')) {
            foreach ($request->attachment_links as $linkUrl) {
                if (!$linkUrl) {
                    continue;
                }

                LppAttachment::create([
                    'lpp_id' => $lpp->id,
                    'attachment_type' => 'link',
                    'link_url' => $linkUrl,
                ]);
            }
        }

        if ($lpp->type === 'assignment') {
            Assignment::updateOrCreate(
                ['lpp_id' => $lpp->id],
                [
                    'title' => $lpp->title,
                    'description' => $lpp->description,
                    'deadline' => $lpp->deadline,
                    'max_exp' => $lpp->max_points,
                ]
            );
        } else {
            Assignment::where('lpp_id', $lpp->id)->delete();
        }

        return back()->with('success', 'Posting berhasil diperbarui!');
    }

    // ================== HAPUS MATERI ==================
    public function destroy($id)
    {
        if (Auth::user()->role !== 'dosen') abort(403);

        $lpp = Lpp::findOrFail($id);
        abort_unless($lpp->classroom->dosen_id === Auth::id(), 403);
        
        if ($lpp->file_path) {
            Storage::disk('public')->delete($lpp->file_path);
        }

        foreach ($lpp->attachments as $attachment) {
            if ($attachment->attachment_type === 'file' && $attachment->file_path) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }
        
        $lpp->delete();

        return back()->with('success', 'Posting berhasil dihapus!');
    }

    // ================== UPLOAD TUGAS MAHASISWA ==================
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'link_url' => 'nullable|url|max:2048',
            'lpp_id' => 'nullable|exists:lpps,id',
            'assignment_id' => 'nullable|exists:assignments,id'
        ]);

        if (!$request->hasFile('file') && !$request->filled('link_url')) {
            return back()->withErrors(['file' => 'Upload file atau isi link pengumpulan.'])->withInput();
        }

        if (!$request->filled('lpp_id') && !$request->filled('assignment_id')) {
            return back()->withErrors(['file' => 'Data tugas tidak valid.'])->withInput();
        }

        $assignmentId = $request->input('assignment_id');
        $lppId = $request->input('lpp_id');
        $assignment = null;
        $lpp = null;

        if ($assignmentId) {
            $assignment = Assignment::findOrFail($assignmentId);
            $lppId = $assignment->lpp_id;

            if (now()->gt($assignment->deadline)) {
                return back()->withErrors(['file' => 'Deadline pengumpulan sudah lewat.'])->withInput();
            }
        }

        if (!$assignmentId && $lppId) {
            $lpp = Lpp::findOrFail($lppId);
            if ($lpp->deadline && now()->gt($lpp->deadline)) {
                return back()->withErrors(['file' => 'Deadline pengumpulan sudah lewat.'])->withInput();
            }

            if (!$assignmentId) {
                $assignmentId = Assignment::where('lpp_id', $lppId)->value('id');
            }
        }

        $alreadySubmitted = Submission::where('user_id', Auth::id())
            ->where(function ($query) use ($assignmentId, $lppId) {
                if ($assignmentId) {
                    $query->where('assignment_id', $assignmentId);
                } else {
                    $query->whereNull('assignment_id')->where('lpp_id', $lppId);
                }
            })
            ->exists();

        if ($alreadySubmitted) {
            return back()->withErrors(['file' => 'Tugas sudah dikumpulkan. Klik unsubmit jika ingin kirim ulang.'])->withInput();
        }

        $path = $request->hasFile('file')
            ? $request->file('file')->store('submissions', 'public')
            : null;

        $earnedExp = $this->calculateSubmissionExp($assignment ?? null, $lpp ?? null);

        // Simpan sebagai riwayat versi, jangan overwrite data pengumpulan lama.
        $submission = Submission::create([
            'assignment_id' => $assignmentId,
            'lpp_id' => $lppId,
            'user_id' => Auth::id(),
            'file_path' => $path,
            'link_url' => $request->input('link_url'),
            'earned_exp' => $earnedExp,
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role === 'mahasiswa') {
            $user->exp = max(0, min(500, (int) $user->exp + (int) $submission->earned_exp));
            $user->save();
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    public function unsubmit($id)
    {
        $submission = Submission::with('lpp.classroom')->findOrFail($id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless($user->role !== 'dosen' && $submission->user_id === $user->id, 403);

        if ($user->role === 'mahasiswa') {
            $user->exp = max(0, (int) $user->exp - (int) $submission->earned_exp);
            $user->save();
        }

        $submission->delete();

        return back()->with('success', 'Pengumpulan dibatalkan. Silakan kirim ulang jika diperlukan.');
    }

    public function gradeSubmission(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|integer|min:0',
        ]);

        $submission = Submission::with('lpp.classroom', 'assignment')->findOrFail($id);

        $classroom = $submission->lpp?->classroom;
        abort_unless($classroom && $classroom->dosen_id === Auth::id(), 403);

        $maxPoints = $submission->assignment?->max_exp ?? $submission->lpp?->max_points ?? 100;
        if ((int) $request->grade > (int) $maxPoints) {
            return back()->withErrors(['grade' => 'Nilai tidak boleh melebihi poin maksimal (' . $maxPoints . ').']);
        }

        $submission->grade = (int) $request->grade;
        $submission->save();

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function downloadLppFile($id)
    {
        $lpp = Lpp::with('classroom')->findOrFail($id);
        $this->authorizeClassroomAccess($lpp->classroom_id);

        abort_if(!$lpp->file_path || !Storage::disk('public')->exists($lpp->file_path), 404);

        return response()->download(Storage::disk('public')->path($lpp->file_path));
    }

    public function previewLppFile($id)
    {
        $lpp = Lpp::with('classroom')->findOrFail($id);
        $this->authorizeClassroomAccess($lpp->classroom_id);

        abort_if(!$lpp->file_path || !Storage::disk('public')->exists($lpp->file_path), 404);

        return response()->file(Storage::disk('public')->path($lpp->file_path));
    }

    public function downloadAttachmentFile($id)
    {
        $attachment = LppAttachment::with('lpp.classroom')->findOrFail($id);
        $this->authorizeClassroomAccess($attachment->lpp->classroom_id);

        abort_if($attachment->attachment_type !== 'file' || !$attachment->file_path || !Storage::disk('public')->exists($attachment->file_path), 404);

        return response()->download(Storage::disk('public')->path($attachment->file_path));
    }

    public function previewAttachmentFile($id)
    {
        $attachment = LppAttachment::with('lpp.classroom')->findOrFail($id);
        $this->authorizeClassroomAccess($attachment->lpp->classroom_id);

        abort_if($attachment->attachment_type !== 'file' || !$attachment->file_path || !Storage::disk('public')->exists($attachment->file_path), 404);

        return response()->file(Storage::disk('public')->path($attachment->file_path));
    }

    public function downloadSubmissionFile($id)
    {
        $submission = Submission::with('lpp.classroom')->findOrFail($id);
        abort_if(!$submission->file_path || !Storage::disk('public')->exists($submission->file_path), 404);

        $user = Auth::user();
        if ($user->role === 'dosen') {
            abort_unless($submission->lpp && $submission->lpp->classroom->dosen_id === $user->id, 403);
        } else {
            abort_unless($submission->user_id === $user->id, 403);
        }

        return response()->download(Storage::disk('public')->path($submission->file_path));
    }

    public function previewSubmissionFile($id)
    {
        $submission = Submission::with('lpp.classroom')->findOrFail($id);
        abort_if(!$submission->file_path || !Storage::disk('public')->exists($submission->file_path), 404);

        $user = Auth::user();
        if ($user->role === 'dosen') {
            abort_unless($submission->lpp && $submission->lpp->classroom->dosen_id === $user->id, 403);
        } else {
            abort_unless($submission->user_id === $user->id, 403);
        }

        return response()->file(Storage::disk('public')->path($submission->file_path));
    }

    private function authorizeClassroomAccess(int $classroomId): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role === 'dosen') {
            abort_unless(Classroom::where('id', $classroomId)->where('dosen_id', $user->id)->exists(), 403);
            return;
        }

        abort_unless($user->joinedClassrooms()->where('classrooms.id', $classroomId)->exists(), 403);
    }

    private function parseLocalDateTimeToAppTimezone(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        $sourceTimezone = 'Asia/Jakarta';
        return Carbon::parse($value, $sourceTimezone)->setTimezone(config('app.timezone'));
    }

    private function calculateSubmissionExp(?Assignment $assignment, ?Lpp $lpp): int
    {
        if ($assignment && $assignment->deadline) {
            $deadline = Carbon::parse($assignment->deadline);
            $minutesLeft = now()->diffInMinutes($deadline, false);

            if ($minutesLeft <= 30) {
                return 10; // Pas deadline
            }
            if ($minutesLeft <= 360) {
                return 20; // Mepet deadline
            }

            return 30; // Jauh sebelum deadline
        }

        if ($lpp && $lpp->deadline) {
            $deadline = Carbon::parse($lpp->deadline);
            $minutesLeft = now()->diffInMinutes($deadline, false);

            if ($minutesLeft <= 30) {
                return 10;
            }
            if ($minutesLeft <= 360) {
                return 20;
            }

            return 30;
        }

        return 20;
    }
}