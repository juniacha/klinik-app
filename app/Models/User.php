<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke Pasien (Jika role = pasien)
    public function pasien()
    {
        return $this->hasOne(Pasien::class);
    }

    // Relasi ke Dokter (Jika role = dokter)
    public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }
}