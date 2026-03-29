<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * READ: Menampilkan daftar kelas di Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'dosen') {
            // Dosen hanya melihat kelas yang mereka buat sendiri
            $classrooms = Classroom::where('dosen_id', $user->id)
                ->latest()
                ->get();
        } else {
            // Mahasiswa melihat kelas yang mereka ikuti
            // Catatan: Jika kamu belum buat logic join, sementara ambil semua kelas
            $classrooms = Classroom::latest()->get();
        }

        return view('dashboard', compact('classrooms'));
    }

    /**
     * CREATE: Menyimpan kelas baru ke database
     */
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

        return redirect()->back()->with('success', 'Kelas berhasil dibuat!');
    }

    /**
     * UPDATE: Memperbarui data kelas (Nama/Seksi)
     */
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

        return redirect()->back()->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus kelas (Soft Delete)
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);

        // Validasi: Pastikan hanya dosen pemilik kelas yang bisa hapus
        if ($classroom->dosen_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $classroom->delete();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }
}