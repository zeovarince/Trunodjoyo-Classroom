<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;

// 1. GUEST ONLY (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 2. AUTH ONLY (Wajib login)
Route::middleware('auth')->group(function () {
    
    // DASHBOARD
    Route::get('/', [ClassroomController::class, 'index'])->name('dashboard');

    // CRUD KELAS (Ini yang tadi bikin error)
    Route::post('/kelas', [ClassroomController::class, 'store'])->name('kelas.store'); // Create
    Route::put('/kelas/{id}', [ClassroomController::class, 'update'])->name('kelas.update'); // Update (Ini solusinya!)
    Route::delete('/kelas/{id}', [ClassroomController::class, 'destroy'])->name('kelas.destroy'); // Delete

    // Fitur Lainnya
    Route::get('/tugas', function () { return view('tugas'); });
    Route::get('/anggota', function () { return view('anggota_kelas'); });
    Route::get('/profile', function () { return view('profile', ['user' => Auth::user()]); });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Detail Kelas (Dynamic)
    Route::get('/kelas/{id}', function ($id) {
        return view('detail_kelas', ['id' => $id]);
    })->name('kelas.show');
});