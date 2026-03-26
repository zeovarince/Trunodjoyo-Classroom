<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    // aktif soft delete
    use SoftDeletes;
    
    public function lpp(){
        return $this->belongsTo(Lpp::class);
    }
    // relasi ke model User many to one
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reply(){
        return $this->hasMany(Reply::class);
    }
}
