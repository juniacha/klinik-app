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
        //Hitung Statistik Ringkasan Dashboard Admin
        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $kunjunganHariIni = Pendaftaran::whereDate('tgl_periksa', now()->today())->count();
        $antreanHariIni = Pendaftaran::whereDate('tgl_periksa', now()->today())
            ->where('status', 'menunggu')
            ->count();
        $antreanMenunggu = $antreanHariIni;
        $antreanDiperiksa = Pendaftaran::whereDate('tgl_periksa', now()->today())
            ->where('status', 'diperiksa')
            ->count();
        $antreanSelesai = Pendaftaran::whereDate('tgl_periksa', now()->today())
            ->where('status', 'selesai')
            ->count();

        //Hitung Total Seluruh Data Obat yang Terdaftar
        $totalObat = Obat::count();

        //Ambil Daftar Antrean Hari Ini
        $antreanTerbaru = Pendaftaran::with(['pasien.user', 'dokter.user'])
            ->whereDate('tgl_periksa', now()->today())
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'kunjunganHariIni',
            'antreanHariIni',
            'antreanMenunggu',
            'antreanDiperiksa',
            'antreanSelesai',
            'totalObat',
            'antreanTerbaru'
        ));
    }

    public function laporan(Request $request)
    {
        return redirect()->route('admin.pendaftaran.index');
    }
}