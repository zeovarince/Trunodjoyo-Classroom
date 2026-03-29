<?php

use Illuminate\Support\Facades\Route;

// 1. Default route diarahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// 1. GUEST ONLY (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 2. AUTH ONLY (Wajib login)
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