<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpp extends Model
{

    // relasi ke model Classroom many to one
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    // relasi ke model Assignment one to many
    public function assigments(){
        return $this->hasMany(Assignment::class);
    }   
}
