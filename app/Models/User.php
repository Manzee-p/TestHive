<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     *
     */
    protected $fillable = [
        'name',
        'email',
        'kelas_id',
        'password',
        'isAdmin',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
