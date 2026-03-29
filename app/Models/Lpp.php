<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpp extends Model
{
    protected $table = 'lpps'; 

    protected $fillable = [
        'classroom_id',
        'title',
        'description',
        'file_path'
    ];

    // relasi ke Classroom (many to one)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // relasi ke Assignment (one to many)
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}