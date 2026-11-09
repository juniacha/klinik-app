<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan daftar antrean & pendaftaran untuk Admin
     */
    public function index()
    {
        $pendaftaran = Pendaftaran::with(['pasien.user', 'dokter'])
            ->orderBy('tgl_periksa', 'desc')
            ->get();

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Form Booking Antrean Mandiri oleh Pasien
     */
    public function createPasien()
    {
        $dokter = Dokter::all();
        $pasien = auth()->user()->pasien;
        return view('pasien.pendaftaran.create', compact('dokter', 'pasien'));
    }

    /**
     * Simpan Booking Antrean Mandiri oleh Pasien
     */
    public function storePasien(Request $request)
    {
        $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'tgl_periksa' => 'required|date|after_or_equal:today',
            'keluhan'     => 'required|string',
        ]);

        $pasien = auth()->user()->pasien;

        $count = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->whereDate('tgl_periksa', $request->tgl_periksa)
            ->count();

        $noAntrean = 'ANT-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        Pendaftaran::create([
            'no_antrean'  => $noAntrean,
            'pasien_id'   => $pasien->id,
            'dokter_id'   => $request->dokter_id,
            'tgl_periksa' => $request->tgl_periksa,
            'keluhan'     => $request->keluhan,
            'status'      => 'menunggu',
        ]);

        return redirect()->route('pasien.dashboard')->with('success', "Booking berhasil! No. Antrean Anda: {$noAntrean}");
    }

    /**
     * Update Status Antrean oleh Admin (menunggu, dipanggil, selesai)
     */
    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dipanggil,sedang diperiksa,selesai,batal',
        ]);

        $pendaftaran->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status antrean berhasil diperbarui.');
    }

    /**
     * Hapus Data Antrean oleh Admin
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        return redirect()->back()->with('success', 'Data antrean berhasil dihapus.');
    }
}