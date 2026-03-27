<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // aktif soft delete
    use SoftDeletes;

    // relasi ke model Submission one to many
    public function submissions(){
    // karena di tabel submission nama foreign key nya student_id, maka kita tambahkan parameter kedua di method hasMany nya
        return $this->hasMany(Submission::class, 'student_id');
    }
    // relasi ke model Classroom one to many Satu dosen bisa membuat dan mengajar banyak kelas.
    public function taughtClassrooms(){
        // karena di tabel classroom nama foreign key nya dosen_id, maka kita tambahkan parameter kedua di method hasMany nya
        return $this->hasMany(Classroom::class, 'dosen_id');
    }
    // relasi ke model Classroom many to many Satu mahasiswa bisa bergabung dengan banyak kelas, dan satu kelas bisa memiliki banyak mahasiswa yang bergabung.
    public function joinedClassrooms(){
        // relasi many to many dengan model Classroom melalui tabel pivot classroom_user
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id');
    }

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
}
