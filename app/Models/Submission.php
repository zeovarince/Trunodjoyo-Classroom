<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id',
        'lpp_id',
        'user_id',
        'file_path'
    ];

    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }

    public function lpp(){
        return $this->belongsTo(Lpp::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

