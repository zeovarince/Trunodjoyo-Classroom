<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    // relasi ke model Assignment many to one
    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
