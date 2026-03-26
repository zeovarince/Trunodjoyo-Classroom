<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;
    public function thread(){
        return $this->belongsTo(Thread::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
