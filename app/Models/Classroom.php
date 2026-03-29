<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    // aktif soft delete
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'section',
        'code',
        'dosen_id',
    ];

    // Relasi ke model Lpp one to many
    public function lpps(){
        return $this->hasMany(Lpp::class);
    }
    public function dosen()
    {
        // Parameter kedua adalah nama foreign key di tabel classrooms
        return $this->belongsTo(User::class, 'dosen_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id');
    }
}
