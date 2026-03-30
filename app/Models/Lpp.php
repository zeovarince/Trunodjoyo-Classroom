<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Lpp extends Model
{
    protected $table = 'lpps'; 

    protected $fillable = [
        'classroom_id',
        'type',
        'topic',
        'publish_at',
        'title',
        'description',
        'deadline',
        'max_points',
        'file_path'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'deadline' => 'datetime',
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

    public function submissions()
{
    return $this->hasMany(Submission::class);
}

    public function attachments()
    {
        return $this->hasMany(LppAttachment::class);
    }

    public function scopeVisibleForStudent(Builder $query): Builder
    {
        return $query->where(function (Builder $builder) {
            $builder->whereNull('publish_at')
                ->orWhere('publish_at', '<=', now());
        });
    }
}