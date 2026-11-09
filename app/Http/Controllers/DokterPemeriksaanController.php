<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterPemeriksaanController extends Controller
{
    // Dashboard Antrean Pasien Milik Dokter Login
    public function index()
    {
        $dokter = Auth::user()->dokter;
        $antrean = Pendaftaran::with('pasien.user')
            ->where('dokter_id', $dokter->id)
            ->whereDate('tgl_periksa', now()->today())
            ->orderBy('id', 'asc')->get();

        return view('dokter.dashboard', compact('dokter', 'antrean'));
    }

    // Form Pemeriksaan Medis (Alur Step 5)
    public function periksa(Pendaftaran $pendaftaran)
    {
        $obats = Obat::where('stok', '>', 0)->get();
        return view('dokter.pemeriksaan.create', compact('pendaftaran', 'obats'));
    }

    // Simpan Rekam Medis & Resep Obat (Alur Step 6)
    public function storePemeriksaan(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'diagnosa'   => 'required|string',
            'tindakan'   => 'required|string',
            'resep_obat' => 'nullable|string',
        ]);

        // 1. Simpan Rekam Medis
        RekamMedis::create([
            'pendaftaran_id' => $pendaftaran->id,
            'pasien_id'      => $pendaftaran->pasien_id,
            'dokter_id'      => $pendaftaran->dokter_id,
            'diagnosa'       => $request->diagnosa,
            'tindakan'       => $request->tindakan,
            'resep_obat'     => $request->resep_obat,
        ]);

        // 2. Ubah Status Pendaftaran Menjadi Selesai
        $pendaftaran->update(['status' => 'selesai']);

        return redirect()->route('dokter.dashboard')->with('success', 'Pemeriksaan selesai & rekam medis berhasil disimpan.');
    }
}