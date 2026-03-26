<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    // aktif soft delete
    use SoftDeletes;

    // relasi ke model Lpp many to one
    public function lpp(){
        return $this->belongsTo(Lpp::class);
    }

    // relasi ke model Submission one to many
    public function submissions(){
        return $this->hasMany(Submission::class);
    }
}
