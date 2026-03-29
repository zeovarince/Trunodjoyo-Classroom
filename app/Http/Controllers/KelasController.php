<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('user_id', Auth::id())->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kelas::create([
            'nama'    => $request->nama,
            'kode'    => strtoupper(Str::random(6)), // kode otomatis
            'role'    => 'dosen',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat!');
    }

    public function edit($id)
    {
        $kelas = Kelas::where('user_id', Auth::id())->findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kelas = Kelas::where('user_id', Auth::id())->findOrFail($id);
        $kelas->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::where('user_id', Auth::id())->findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    // Mahasiswa
    public function join()
    {
        return view('kelas.join'); // form input kode kelas
    }

    public function storeJoin(Request $request)
    {
        // REVISI: Mengubah pencarian kode dari tabel 'kelas' menjadi tabel 'classrooms'
        $request->validate([
            'kode' => 'required|string|exists:classrooms,kode',
        ]);

        // Cari kelas berdasarkan kode
        $kelas = Kelas::where('kode', $request->kode)->firstOrFail();

        // Attach ke pivot user_kelas (pastikan relasi sudah ada di model User)
        $request->user()->kelas()->attach($kelas->id);

        return redirect()->route('dashboard')->with('success', 'Berhasil join kelas!');
    }
}