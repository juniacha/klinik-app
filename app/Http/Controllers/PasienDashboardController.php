<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienDashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Pasien
     */
    public function index()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        // Antrean aktif pasien hari ini
        $antreanAktif = Pendaftaran::with('dokter')
            ->where('pasien_id', $pasien->id ?? null)
            ->whereDate('tgl_periksa', now()->today())
            ->whereIn('status', ['menunggu', 'sudah hadir', 'dipanggil', 'sedang diperiksa'])
            ->first();

        // Riwayat pendaftaran/kunjungan pasien
        $riwayatPendaftaran = Pendaftaran::with('dokter')
            ->where('pasien_id', $pasien->id ?? null)
            ->latest()
            ->get();

        return view('pasien.dashboard', compact('pasien', 'antreanAktif', 'riwayatPendaftaran'));
    }

    /**
     * Menampilkan Halaman Profil Pasien (Mendukung route /pasien/profil)
     */
    public function profil()
    {
        $user = Auth::user();
        $pasien = $user->pasien ?? Pasien::where('user_id', $user->id)->first();

        return view('pasien.profil.edit', compact('user', 'pasien'));
    }

    /**
     * Alias method untuk edit profil (Mendukung route /pasien/profil/edit)
     */
    public function editProfil()
    {
        return $this->profil();
    }

    /**
     * Mengubah Informasi Pribadi Pasien
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.max' => 'NIK maksimal 16 digit.',
            'no_hp.max' => 'Nomor telepon maksimal 15 digit.',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        if ($user->pasien) {
            $user->pasien->update([
                'nik' => $request->nik,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        } else {
            Pasien::create([
                'user_id' => $user->id,
                'no_rm' => 'RM-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'nik' => $request->nik,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->back()->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Mengubah Kata Sandi Pasien
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah.');
    }
}