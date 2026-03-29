<?php

use Illuminate\Support\Facades\Route;

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
    return view('pengumpulan_tugas'); // Pastikan nama file view-nya BENAR
});

// Route untuk halaman Forum (Detail Kelas)
Route::get('/kelas/detail', function () {
    return view('detail_kelas'); 
});

// Route untuk halaman Anggota
Route::get('/anggota', function () {
    return view('anggota_kelas'); 
});