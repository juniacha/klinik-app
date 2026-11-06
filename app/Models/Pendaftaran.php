<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang benar sesuai yang ada di hera_db
    protected $table = 'pendaftaran';

    protected $fillable = [
        'no_antrean',
        'pasien_id',
        'dokter_id',
        'tgl_periksa',
        'status',
        'is_hadir',
        'jumlah_panggilan',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}