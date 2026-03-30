<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    // menampilkan daftar kelas yang dibuat dosen atau diikuti mahasiswa
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role == 'dosen') {
            $classrooms = Classroom::where('dosen_id', $user->id)
                ->withCount('students')
                ->latest()
                ->get();
        } else {
            $classrooms = $user->joinedClassrooms()
            ->withCount('students')
            ->latest()
            ->get();
    }
        return view('dashboard', compact('classrooms'));
    }
    // Menampilkan form untuk membuat kelas baru (Dosen)
    public function create()
    {
        return view('kelas.create');
    }
    // Proses menyimpan kelas baru ke database (Dosen)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
        ]);

        Classroom::create([
            'dosen_id' => Auth::id(),
            'name' => $request->name,
            'section' => $request->section,
            'code' => strtoupper(Str::random(6)), // Generate kode unik 6 digit
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat!');
    }

    public function show($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $classroom = Classroom::with(['dosen', 'students'])->findOrFail($id);

        if ($user->role === 'dosen') {
            abort_unless($classroom->dosen_id === $user->id, 403);
        } else {
            abort_unless($user->joinedClassrooms()->where('classrooms.id', $classroom->id)->exists(), 403);
        }

        // Ambil semua kelas agar Sidebar tidak kosong
        if ($user->role == 'dosen') {
            $classrooms = Classroom::where('dosen_id', $user->id)->latest()->get();
        } else {
            $classrooms = $user->joinedClassrooms()->latest()->get();
        }

        $forumPostsQuery = $classroom->lpps()->with(['attachments', 'submissions', 'assignments'])->latest();
        if ($user->role !== 'dosen') {
            $forumPostsQuery->visibleForStudent();
        }
        $forumPosts = $forumPostsQuery->get();

        $tasksQuery = $classroom->lpps()
            ->with(['attachments', 'submissions', 'assignments'])
            ->where('type', 'assignment')
            ->orderBy('deadline', 'asc');
        if ($user->role !== 'dosen') {
            $tasksQuery->visibleForStudent();
        }
        $tasks = $tasksQuery->get();
        $tasksByTopic = $tasks->groupBy(function ($task) {
            return $task->topic ?: 'Tanpa Topik';
        });

        $tab = request('tab', 'forum');
        if (!in_array($tab, ['forum', 'tugas', 'orang'])) {
            $tab = 'forum';
        }

        return view('detail_kelas', compact('classroom', 'classrooms', 'forumPosts', 'tasksByTopic', 'tab'));
    }
    // Menampilkan form untuk mengedit kelas (Dosen)
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);

        // Pastikan hanya dosen pemilik kelas yang bisa akses halaman edit
        if ($classroom->dosen_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        // Pastikan kamu punya file view: resources/views/kelas/edit.blade.php
        return view('kelas.edit', compact('classroom'));
    }

    // Proses update kelas di database (Dosen)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
        ]);

        $classroom = Classroom::findOrFail($id);

        // Validasi: Pastikan hanya dosen pemilik kelas yang bisa edit
        if ($classroom->dosen_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $classroom->update([
            'name' => $request->name,
            'section' => $request->section,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    // DELETE: Menghapus kelas (Dosen)
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);

        // Validasi: Pastikan hanya dosen pemilik kelas yang bisa hapus
        if ($classroom->dosen_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $classroom->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    // Menampilkan form untuk mahasiswa bergabung ke kelas menggunakan kode unik
    public function join()
    {
        // Pastikan kamu punya file view: resources/views/kelas/join.blade.php
        return view('kelas.join');
    }

    // Proses mahasiswa bergabung ke kelas menggunakan kode unik
    public function storeJoin(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $classroom = Classroom::where('code', $request->code)->first();

        if (!$classroom) {
            return redirect()->back()->with('error', 'Kode kelas tidak valid atau tidak ditemukan!');
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->joinedClassrooms()->where('classroom_id', $classroom->id)->exists()) {
            return redirect()->back()->with('error', 'Kamu sudah bergabung di kelas ini!');
        }

        $user->joinedClassrooms()->attach($classroom->id);
        return redirect()->route('kelas.index')->with('success', 'Berhasil bergabung ke kelas!');
    }
}
