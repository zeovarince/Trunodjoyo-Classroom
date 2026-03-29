<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    // Daftarkan kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        'dosen_id',
        'name',
        'section',
        'code'
    ];

    // Relasi ke Dosen (User)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relasi ke Lpp
    public function lpps()
    {
        return $this->hasMany(Lpp::class);
    }
}