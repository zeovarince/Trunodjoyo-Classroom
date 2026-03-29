<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    // aktif soft delete
    use SoftDeletes;

    // Relasi ke model Lpp one to many
    public function lpps(){
        return $this->hasMany(Lpp::class);
    }
}