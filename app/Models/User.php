<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'npm',
        'role',
        'exp',
        'avatar',
        'fakultas',
        'prodi',   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -------------------------------------------------------------------------
    // RELASI DATABASE
    // -------------------------------------------------------------------------

    // Relasi ke model Submission (One to Many)
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    // Relasi ke model Classroom (One to Many) - Sebagai Dosen
    public function taughtClassrooms()
    {
        return $this->hasMany(Classroom::class, 'dosen_id');
    }

    // Relasi ke model Classroom (Many to Many) - Sebagai Mahasiswa yang Join
    public function joinedClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id');
    }
}