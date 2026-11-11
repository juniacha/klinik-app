<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'user_id',
        'no_rm',
        'nik',
        'tgl_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'pasien_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'pasien_id');
    }
}