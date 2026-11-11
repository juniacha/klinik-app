<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterJadwalController extends Controller
{

    //Melihat Jadwal Praktik Dokter & Ketersediaan Jam Layanan
    public function index()
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        // Jadwal Pemeriksaan Hari Ini & Akan Datang
        $jadwalPemeriksaan = Pendaftaran::with('pasien.user')
            ->where('dokter_id', $dokter->id ?? null)
            ->whereDate('tgl_periksa', '>=', now()->today())
            ->orderBy('tgl_periksa', 'asc')
            ->get();

        return view('dokter.jadwal.index', compact('dokter', 'jadwalPemeriksaan'));
    }

    //Mengelola Status Ketersediaan Praktik Dokter
    public function updateKetersediaan(Request $request)
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        $request->validate([
            'jadwal_praktik' => 'required|string|max:255',
            'status_praktik' => 'required|in:Tersedia,Libur / Berhalangan',
        ]);

        $dokter->update([
            'jadwal_praktik' => $request->jadwal_praktik,
            'status_praktik' => $request->status_praktik,
        ]);

        return redirect()->back()->with('success', 'Status ketersediaan jadwal praktik berhasil diperbarui.');
    }
}