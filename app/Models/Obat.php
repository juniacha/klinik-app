<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Menghubungkan eksplisit ke tabel 'obats'
    protected $table = 'obats';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'jenis',
        'stok',
        'harga',
    ];
}