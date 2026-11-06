<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        // Mengambil semua data pendaftaran beserta relasi pasien dan dokter
        $pendaftaran = Pendaftaran::with(['pasien.user', 'dokter.user'])->latest()->get();
        return view('pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        $pasien = Pasien::with('user')->get();
        $dokter = Dokter::with('user')->get();
        return view('pendaftaran.create', compact('pasien', 'dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id'   => 'required|exists:pasien,id',
            'dokter_id'   => 'required|exists:dokter,id',
            'tgl_periksa' => 'required|date|after_or_equal:today',
        ], [
            'pasien_id.required'   => 'Pilih pasien yang akan didaftarkan.',
            'dokter_id.required'   => 'Pilih dokter tujuan.',
            'tgl_periksa.required' => 'Tanggal pemeriksaan wajib diisi.',
            'tgl_periksa.after_or_equal' => 'Tanggal pemeriksaan tidak boleh tanggal yang sudah lewat.',
        ]);

        // Cek Kuota Harian Dokter (Maksimal 20 Pasien/Hari)
        $jumlahPendaftar = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->count();

        if ($jumlahPendaftar >= 20) {
            return redirect()->back()->withInput()->with('error', 'Mohon maaf, kuota pendaftaran untuk dokter ini sudah penuh (Maksimal 20 pasien per hari).');
        }

        // Generasi Nomor Antrean Otomatis (Contoh: ANT-001)
        $noUrut = $jumlahPendaftar + 1;
        $noAntrean = 'ANT-' . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        Pendaftaran::create([
            'no_antrean'  => $noAntrean,
            'pasien_id'   => $request->pasien_id,
            'dokter_id'   => $request->dokter_id,
            'tgl_periksa' => $request->tgl_periksa,
            'status'      => 'menunggu',
        ]);

        return redirect()->route('pendaftaran.index')->with('success', "Pendaftaran berhasil! Nomor Antrean Anda: {$noAntrean}");
    }

    // Fitur Self Check-In Pasien di Lokasi Klinik
    public function checkIn($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['is_hadir' => true]);

        return redirect()->back()->with('success', 'Konfirmasi kehadiran berhasil! Pasien siap dipanggil oleh Dokter.');
    }

    // Fitur Sistem Kelempar (Missed Call Penalty jika dipanggil 3x belum hadir)
    public function lewatiAntrean($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->touch(); // Memperbarui updated_at agar posisinya tergeser ke paling bawah
        $pendaftaran->increment('jumlah_panggilan');

        return redirect()->back()->with('warning', 'Pasien dilewati dan dipindahkan ke urutan antrean paling belakang.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil dihapus!');
    }
}