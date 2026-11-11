<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Obat;

class DokterPemeriksaanController extends Controller
{
    /**
     * Dashboard Dokter (Daftar Antrean Pasien Hari Ini)
     */
    public function index()
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        $antreanHariIni = Pendaftaran::with(['pasien.user'])
            ->whereDate('tgl_periksa', date('Y-m-d'))
            ->get();

        $riwayatKunjungan = Pendaftaran::with(['pasien.user'])
            ->where('status', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        return view('dokter.dashboard', compact('dokter', 'antreanHariIni', 'riwayatKunjungan'));
    }

    /**
     * Form Pemeriksaan Pasien (Input Diagnosa & Resep)
     */
    public function periksa($id)
    {
        $pendaftaran = Pendaftaran::with(['pasien.user', 'dokter'])->findOrFail($id);

        // Update status antrean menjadi 'sedang diperiksa'
        $pendaftaran->update(['status' => 'sedang diperiksa']);

        $obats = Obat::all();

        $riwayatSebelumnya = RekamMedis::with('dokter')
            ->where('pasien_id', $pendaftaran->pasien_id)
            ->latest()
            ->get();

        return view('dokter.pemeriksaan.create', compact('pendaftaran', 'obats', 'riwayatSebelumnya'));
    }

    /**
     * Simpan Hasil Pemeriksaan & Rekam Medis Pasien
     */
    public function storePemeriksaan(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        // Format rincian resep obat
        $rincianResep = [];
        if ($request->has('resep_obat') && is_array($request->resep_obat)) {
            foreach ($request->resep_obat as $key => $itemObat) {
                if (!empty($itemObat['id'])) {
                    $obatObj = Obat::find($itemObat['id']);
                    if ($obatObj) {
                        $dosis = $request->dosis[$key] ?? 'Secara teratur';
                        $aturan = $request->aturan_pakai[$key] ?? 'Sesudah makan';

                        // Kurangi stok obat jika tersedia
                        if ($obatObj->stok > 0) {
                            $obatObj->decrement('stok', 1);
                        }

                        $rincianResep[] = "- {$obatObj->nama_obat} | Dosis: {$dosis} | Aturan: {$aturan}";
                    }
                }
            }
        }

        $stringResepFormat = !empty($rincianResep)
            ? implode("\n", $rincianResep)
            : ($request->catatan_dokter ?? 'Tidak ada resep obat khusus.');

        // Simpan ke Rekam Medis (Tanpa menyisipkan kolom 'keluhan' di tabel rekam_medis)
        RekamMedis::create([
            'pendaftaran_id' => $pendaftaran->id,
            'pasien_id' => $pendaftaran->pasien_id,
            'dokter_id' => $pendaftaran->dokter_id ?? Auth::id(),
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'resep_obat' => $stringResepFormat,
            'catatan' => $request->catatan_dokter ?? null,
        ]);

        // Update keluhan di tabel pendaftarans jika ada perubahan
        if ($request->has('keluhan')) {
            $pendaftaran->update(['keluhan' => $request->keluhan]);
        }

        // Ubah status pendaftaran antrean menjadi 'selesai'
        $pendaftaran->update(['status' => 'selesai']);

        return redirect()->route('dokter.dashboard')
            ->with('success', "Pemeriksaan pasien antrean {$pendaftaran->no_antrean} berhasil disimpan dan status diperbarui menjadi Selesai.");
    }

    /**
     * Riwayat Rekam Medis Pasien Spesifik
     */
    public function riwayatMedisPasien($pasien_id)
    {
        $pasien = Pasien::with('user')->findOrFail($pasien_id);

        $riwayatMedis = RekamMedis::with(['dokter', 'pendaftaran'])
            ->where('pasien_id', $pasien_id)
            ->latest()
            ->get();

        return view('dokter.rekam-medis.show', compact('pasien', 'riwayatMedis'));
    }
}