<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelasController;
use Illuminate\Support\Facades\Route;

// 1. Default route diarahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// -----------------------------------------------------------------------------
// 2. ROUTE MILIK TEMANMU (Sekarang dikunci, wajib login agar bisa masuk)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/tugas', function () {
        return view('tugas');
    })->name('tugas');

    Route::get('/detail-kelas', function () {
        return view('detail_kelas');
    })->name('detail_kelas');

    Route::get('/anggota-kelas', function () {
        return view('anggota_kelas');
    })->name('anggota_kelas');

    Route::get('/pengumpulan-tugas', function () {
        return view('pengumpulan_tugas');
    })->name('pengumpulan_tugas');
});

// -----------------------------------------------------------------------------
// 3. ROUTE PROFILE (Bawaan sistem Auth milikmu)
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -----------------------------------------------------------------------------
// 4. ROUTE CRUD KELAS (Bagianmu)
// -----------------------------------------------------------------------------
// ⚠️ CATATAN: Sementara aku hilangkan 'role:dosen,admin' agar tidak error 
// jika middleware Role belum dipindahkan ke laptop temanmu.
Route::middleware(['auth'])->group(function () {
    // Dosen / Admin
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Mahasiswa
    Route::get('/kelas-join', [KelasController::class, 'join'])->name('kelas.join');
    Route::post('/kelas-join', [KelasController::class, 'storeJoin'])->name('kelas.storeJoin');
});

// 5. Memanggil route Auth Breeze
require __DIR__.'/auth.php';