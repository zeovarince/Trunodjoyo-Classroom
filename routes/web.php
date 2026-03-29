<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route Autentikasi (Hanya untuk guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang membutuhkan Auth (Hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/tugas', function () {
        return view('tugas');
    });

    Route::get('/kelas/{id}', function ($id) {
        return view('detail_kelas');
    });

    Route::get('/profile', function () {
        return view('profile');
    });

    Route::get('/tugas/detail', function () {
        return view('pengumpulan_tugas'); 
    });

    Route::get('/kelas/detail', function () {
        return view('detail_kelas'); 
    });

    Route::get('/anggota', function () {
        return view('anggota_kelas'); 
    });
});