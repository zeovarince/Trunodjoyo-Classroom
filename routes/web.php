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