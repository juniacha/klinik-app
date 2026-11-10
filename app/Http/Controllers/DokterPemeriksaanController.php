<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\RekamMedis;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterPemeriksaanController extends Controller
{
    /**
     * Dashboard Dokter: Menampilkan Daftar Pasien Hari Ini & Status Antrean
     */
    public function index()
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Profil dokter tidak ditemukan.');
        }

        // Daftar Antrean Pasien Hari Ini
        $antreanHariIni = Pendaftaran::with(['pasien.user'])
            ->where('dokter_id', $dokter->id)
            ->whereDate('tgl_periksa', now()->today())
            ->orderBy('id', 'asc')
            ->get();

        // Riwayat Kunjungan / Pemeriksaan Selesai
        $riwayatKunjungan = Pendaftaran::with(['pasien.user', 'rekamMedis'])
            ->where('dokter_id', $dokter->id)
            ->where('status', 'selesai')
            ->latest()
            ->take(10)
            ->get();

        return view('dokter.dashboard', compact('dokter', 'antreanHariIni', 'riwayatKunjungan'));
    }

    /**
     * Membuka Detail Pendaftaran & Form Pemeriksaan Pasien
     */
    public function periksa(Pendaftaran $pendaftaran)
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        // Ambil riwayat rekam medis pasien sebelumnya
        $riwayatSebelumnya = RekamMedis::with('dokter')
            ->where('pasien_id', $pendaftaran->pasien_id)
            ->latest()
            ->get();

        // Ambil daftar obat yang tersedia di stok klinik
        $obats = Obat::where('stok', '>', 0)->get();

        // Update status antrean menjadi 'sedang diperiksa'
        if ($pendaftaran->status === 'menunggu' || $pendaftaran->status === 'dipanggil') {
            $pendaftaran->update(['status' => 'sedang diperiksa']);
        }

        return view('dokter.pemeriksaan.create', compact('pendaftaran', 'riwayatSebelumnya', 'obats', 'dokter'));
    }

    /**
     * Menyimpan Hasil Pemeriksaan, Diagnosa, Tindakan, dan Resep Obat ke Rekam Medis
     */
    public function storePemeriksaan(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'keluhan'          => 'required|string',
            'diagnosa'         => 'required|string|max:255',
            'tindakan'         => 'required|string',
            'catatan_dokter'   => 'nullable|string',
            'resep_obat'       => 'nullable|array',
            'resep_obat.*.id'  => 'nullable|exists:obats,id',
            'dosis'            => 'nullable|array',
            'aturan_pakai'     => 'nullable|array',
        ], [
            'keluhan.required'  => 'Keluhan pasien wajib diisi.',
            'diagnosa.required' => 'Hasil diagnosa wajib diisi.',
            'tindakan.required' => 'Tindakan medis wajib diisi.',
        ]);

        // Menyusun rincian resep obat, dosis, dan aturan penggunaan
        $rincianResep = [];
        if ($request->has('resep_obat')) {
            foreach ($request->resep_obat as $index => $item) {
                if (!empty($item['id'])) {
                    $obatModel = Obat::find($item['id']);
                    $dosis = $request->dosis[$index] ?? '1x1';
                    $aturan = $request->aturan_pakai[$index] ?? 'Sesudah Makan';

                    if ($obatModel) {
                        $rincianResep[] = "- {$obatModel->nama_obat} | Dosis: {$dosis} | Aturan: {$aturan}";
                        
                        // Kelola/Kurangi stok obat jika ada
                        if ($obatModel->stok > 0) {
                            $obatModel->decrement('stok', 1);
                        }
                    }
                }
            }
        }

        $stringResepFormat = !empty($rincianResep) 
            ? implode("\n", $rincianResep) 
            : ($request->catatan_resep_manual ?? 'Tidak ada resep obat khusus.');

        // 1. Simpan ke Tabel Rekam Medis
        RekamMedis::create([
            'pendaftaran_id' => $pendaftaran->id,
            'pasien_id'      => $pendaftaran->pasien_id,
            'dokter_id'      => $pendaftaran->dokter_id,
            'keluhan'        => $request->keluhan,
            'diagnosa'       => $request->diagnosa,
            'tindakan'       => $request->tindakan,
            'resep_obat'     => $stringResepFormat,
            'catatan'        => $request->catatan_dokter,
        ]);

        // 2. Perbarui Keluhan di Pendaftaran & Status Antrean Selesai
        $pendaftaran->update([
            'keluhan' => $request->keluhan,
            'status'  => 'selesai'
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Pemeriksaan medis berhasil disimpan dan rekam medis telah diperbarui.');
    }

    /**
     * Melihat Riwayat Medis Lengkap Pasien Sesuai ID Pasien
     */
    public function riwayatMedisPasien(Pasien $pasien)
    {
        $riwayatMedis = RekamMedis::with(['dokter', 'pendaftaran'])
            ->where('pasien_id', $pasien->id)
            ->latest()
            ->get();

        return view('dokter.rekam-medis.show', compact('pasien', 'riwayatMedis'));
    }
}