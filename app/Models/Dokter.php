<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokters';

    // Wajib daftarkan semua kolom yang bisa di-insert via form
    protected $fillable = [
        'user_id',
        'nama_dokter',
        'spesialis',
        'no_str',
        'jadwal_praktik',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}