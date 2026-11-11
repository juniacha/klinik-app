<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Models\Dokter;

class PendaftaranController extends Controller
{
    //Halaman Daftar Antrean & Pendaftaran
    public function index()
    {
        $pendaftaran = Pendaftaran::with(['pasien.user', 'dokter'])
            ->latest()
            ->get();

        if (view()->exists('admin.pendaftaran.index')) {
            return view('admin.pendaftaran.index', compact('pendaftaran'));
        }

        return view('pendaftaran.index', compact('pendaftaran'));
    }

    //Form Booking Antrean Mandiri Pasien
    public function createPasien(Request $request)
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();
        $selectedPoli = $request->query('poli');

        $dokter = null;
        if ($selectedPoli) {
            $keyword = str_replace(['Poli ', '& Mulut', '(Pediatri)', ' Kebidanan &'], '', $selectedPoli);
            $keyword = trim($keyword);

            $dokter = Dokter::where('spesialis', 'like', '%' . $keyword . '%')->first();

            if (!$dokter) {
                $dokter = Dokter::first();
            }
        }

        return view('pasien.pendaftaran.create', compact('pasien', 'dokter', 'selectedPoli'));
    }

    //Simpan Data Pendaftaran Antrean Pasien
    public function storePasien(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'tgl_periksa' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string',
        ], [
            'dokter_id.required' => 'Dokter penanggung jawab wajib ditentukan.',
            'tgl_periksa.required' => 'Tanggal periksa wajib diisi.',
            'keluhan.required' => 'Keluhan utama wajib diisi.',
        ]);

        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        $jumlahPendaftar = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->whereDate('tgl_periksa', $request->tgl_periksa)
            ->count();

        $noAntrean = 'ANT-' . str_pad($jumlahPendaftar + 1, 3, '0', STR_PAD_LEFT);

        Pendaftaran::create([
            'no_antrean' => $noAntrean,
            'pasien_id' => $pasien->id,
            'dokter_id' => $request->dokter_id,
            'tgl_periksa' => $request->tgl_periksa,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pasien.dashboard')->with('success', "Booking berhasil! Nomor Antrean Anda: {$noAntrean}");
    }

    //Update Status Antrean oleh Admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dipanggil,sedang diperiksa,selesai,batal',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', "Status antrean {$pendaftaran->no_antrean} berhasil diperbarui menjadi {$request->status}.");
    }
}