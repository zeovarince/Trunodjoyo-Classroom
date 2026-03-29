<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 1. GUEST ONLY (Hanya bisa dibuka jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 2. AUTH ONLY (Wajib login untuk akses semua fitur ini)
Route::middleware('auth')->group(function () {
    
    // Dashboard Utama
    Route::get('/', function () {
        return view('dashboard');
    });

    // Fitur Tugas
    Route::get('/tugas', function () {
        return view('tugas');
    });

    Route::get('/tugas/detail', function () {
        return view('pengumpulan_tugas'); 
    });

    // Fitur Kelas & Anggota
    Route::get('/kelas/detail', function () {
        return view('detail_kelas'); 
    });

    Route::get('/anggota', function () {
        return view('anggota_kelas'); 
    });

    // FITUR PROFIL (Perbaikan: Mengirim data user aktif ke Blade)
    Route::get('/profile', function () {
        return view('profile', [
            'user' => auth()->user()
        ]);
    });

    // Route Logout (Ditaruh di dalam middleware auth agar lebih aman)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Dynamic (Taruh paling bawah agar tidak bentrok dengan rute statis)
    Route::get('/kelas/{id}', function ($id) {
        return view('detail_kelas', ['id' => $id]);
    });
});