<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Pendaftaran;

class PasienDashboardController extends Controller
{
    /**
     * Menampilkan Beranda / Dashboard khusus Pasien
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data pasien berdasarkan relasi user_id
        $pasien = Pasien::where('user_id', $user->id)->first();

        // Ambil data antrean aktif pasien untuk hari ini
        $antreanAktif = null;
        if ($pasien) {
            $antreanAktif = Pendaftaran::with(['dokter.user', 'dokter'])
                ->where('pasien_id', $pasien->id)
                ->whereDate('tgl_periksa', now()->today())
                ->whereIn('status', ['menunggu', 'sudah hadir', 'dipanggil', 'sedang diperiksa'])
                ->first();
        }

        // Riwayat 5 Pendaftaran Terakhir Pasien
        $riwayatPendaftaran = $pasien 
            ? Pendaftaran::with('dokter')->where('pasien_id', $pasien->id)->latest()->take(5)->get()
            : collect();

        return view('pasien.dashboard', compact('pasien', 'antreanAktif', 'riwayatPendaftaran'));
    }
}