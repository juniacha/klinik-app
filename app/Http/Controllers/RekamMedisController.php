<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar riwayat rekam medis pasien yang sedang login
     */
    public function indexPasien()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        $riwayatMedis = collect();
        if ($pasien) {
            $riwayatMedis = RekamMedis::with(['dokter', 'pendaftaran'])
                ->where('pasien_id', $pasien->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pasien.rekam-medis.index', compact('pasien', 'riwayatMedis'));
    }
}