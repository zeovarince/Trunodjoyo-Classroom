<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Thread;
use App\Models\Lpp;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LppController extends Controller
{
    // ================== TAMPILKAN LPP ==================
    public function show($id)
    {
        $lpp = Lpp::findOrFail($id);
        $assignments = Assignment::where('lpp_id', $id)->get();
        $threads = Thread::where('lpp_id', $id)->latest()->get();
        $notifications = Notification::where('user_id', auth()->id())->latest()->get();

        return view('lpp.detail', compact('lpp', 'assignments', 'threads', 'notifications'));
    }

    // ================== BUAT MATERI BARU + UPLOAD ==================
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'dosen') abort(403);

        $request->validate([
            'classroom_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'file' => 'nullable|mimes:pdf|max:2048' // Maks 2MB
        ]);

        $lpp = new Lpp();
        $lpp->classroom_id = $request->classroom_id;
        $lpp->title = $request->title;
        $lpp->description = $request->description;

        if ($request->hasFile('file')) {
            $lpp->file_path = $request->file('file')->store('materi', 'public');
        }

        $lpp->save();

        // Notifikasi ke mahasiswa
        $users = User::where('role', 'mahasiswa')->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => 'Materi baru telah diupload: ' . $lpp->title
            ]);
        }

        return back()->with('success', 'Materi berhasil dibagikan!');
    }

    // ================== EDIT MATERI ==================
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'dosen') abort(403);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'nullable|mimes:pdf|max:2048'
        ]);

        $lpp = Lpp::findOrFail($id);
        $lpp->title = $request->title;
        $lpp->description = $request->description;

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($lpp->file_path) {
                Storage::disk('public')->delete($lpp->file_path);
            }
            // Simpan file baru
            $lpp->file_path = $request->file('file')->store('materi', 'public');
        }

        $lpp->save();

        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    // ================== HAPUS MATERI ==================
    public function destroy($id)
    {
        if (auth()->user()->role !== 'dosen') abort(403);

        $lpp = Lpp::findOrFail($id);
        
        // Hapus file fisik dari storage
        if ($lpp->file_path) {
            Storage::disk('public')->delete($lpp->file_path);
        }
        
        $lpp->delete();

        return back()->with('success', 'Materi berhasil dihapus!');
    }public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'lpp_id' => 'required'
    ]);

    $file = $request->file('file');
    $path = $file->store('uploads', 'public');

    $lpp = Lpp::findOrFail($request->lpp_id);

    // kalau mau simpan ke database, bisa tambah tabel submissions nanti

    return redirect('/kelas/' . $lpp->classroom_id)
        ->with('success', 'Tugas berhasil diupload!');
}
}