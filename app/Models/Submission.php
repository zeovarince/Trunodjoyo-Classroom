<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'lpp_id',
        'user_id',
        'file_path',
        'link_url'
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

