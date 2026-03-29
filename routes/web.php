<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
Route::get('/', function () {
    return Auth::check() ? redirect('/kelas') : redirect('/login');
});

// guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// authenticated routes
Route::middleware('auth')->group(function () {
    // Route Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/kelas', [ClassroomController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/create', [ClassroomController::class, 'create'])->name('kelas.create');
    Route::post('/kelas', [ClassroomController::class, 'store'])->name('kelas.store');
    
    // INI ROUTE BARUNYA:
    Route::get('/kelas/{id}', [ClassroomController::class, 'show'])->name('kelas.show'); 
    
    Route::get('/kelas/{id}/edit', [ClassroomController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{id}', [ClassroomController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{id}', [ClassroomController::class, 'destroy'])->name('kelas.destroy');
    
});