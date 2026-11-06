<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\Obat;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung statistik untuk ringkasan Dashboard Admin
        $totalPasien   = Pasien::count();
        $totalDokter   = Dokter::count();
        $antreanHariIni = Pendaftaran::whereDate('tgl_periksa', date('Y-m-d'))->count();
        $obatHampirHabis = Obat::where('stok', '<', 10)->count();

        // Mengambil 5 antrean pendaftaran terbaru hari ini
        $antreanTerbaru = Pendaftaran::with(['pasien.user', 'dokter.user'])
            ->whereDate('tgl_periksa', date('Y-m-d'))
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'antreanHariIni',
            'obatHampirHabis',
            'antreanTerbaru'
        ));
    }
}