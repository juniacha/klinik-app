<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    // 3. Rekam Medis Pasien
    public function indexPasien()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        $riwayatMedis = collect();
        if ($pasien) {
            $riwayatMedis = RekamMedis::with(['dokter', 'pendaftaran'])
                ->where('pasien_id', $pasien->id)
                ->latest()
                ->get();
        }

        return view('pasien.rekam-medis.index', compact('pasien', 'riwayatMedis'));
    }
}