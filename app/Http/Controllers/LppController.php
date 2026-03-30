<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Thread;
use App\Models\Lpp;

class LppController extends Controller
{
    // ================== TAMPILKAN LPP ==================
    public function show($id)
    {
        // Ambil data LPP
        $lpp = Lpp::findOrFail($id);

        // Ambil semua tugas berdasarkan LPP
        $assignments = Assignment::where('lpp_id', $id)->get();

        // Ambil thread diskusi terbaru
        $threads = Thread::where('lpp_id', $id)
            ->latest()
            ->get();

        // Kirim ke view
        return view('lpp.detail', compact('lpp', 'assignments', 'threads'));
    }

    // ================== UPLOAD MATERI PDF ==================
   public function upload(Request $request)
{
    if (auth()->user()->role !== 'dosen') {
        abort(403);
    }

    $request->validate([
        'file' => 'required|mimes:pdf|max:2048'
    ]);

    $path = $request->file('file')->store('materi', 'public');

    $lpp = Lpp::findOrFail($request->lpp_id);
    $lpp->file_path = $path;
    $lpp->save();

    return back()->with('success', 'Materi berhasil diupload!');
}
}