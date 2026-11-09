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
        // 1. Hitung Statistik Ringkasan Dashboard Admin
        $totalPasien      = Pasien::count();
        $totalDokter      = Dokter::count();
        $kunjunganHariIni = Pendaftaran::whereDate('tgl_periksa', now()->today())->count();
        $antreanHariIni   = Pendaftaran::whereDate('tgl_periksa', now()->today())
                                       ->where('status', 'menunggu')
                                       ->count();
                                       
        // 2. Hitung Stok Obat Kritis (Hampir Habis)
        $obatHampirHabis  = Obat::where('stok', '<=', 10)->count();

        // 3. Ambil Daftar Antrean Hari Ini
        $antreanTerbaru   = Pendaftaran::with(['pasien', 'dokter'])
                                       ->whereDate('tgl_periksa', now()->today())
                                       ->latest()
                                       ->take(5)
                                       ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'kunjunganHariIni',
            'antreanHariIni',
            'obatHampirHabis',
            'antreanTerbaru'
        ));
    }
}