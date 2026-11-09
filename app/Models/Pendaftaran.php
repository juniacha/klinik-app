<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // Arahkan ke nama tabel jamak yang ada di migration
    protected $table = 'pendaftarans';

    protected $fillable = [
        'no_antrean',
        'pasien_id',
        'dokter_id',
        'tgl_periksa',
        'status',
        'is_hadir',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}