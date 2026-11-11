<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::with('user')->latest()->get();
        return view('admin.pasien.index', compact('pasien'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nik' => 'nullable|string|max:16',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien',
            'no_hp' => $request->no_hp,
        ]);

        $noRm = 'RM-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);

        Pasien::create([
            'user_id' => $user->id,
            'no_rm' => $noRm,
            'nik' => $request->nik,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pasien.index')->with('success', "Pasien berhasil ditambahkan. No. RM: {$noRm}");
    }

    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $pasien->update([
            'nik' => $request->nik,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        if ($pasien->user) {
            $pasien->user->update([
                'name' => $request->nama,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        if ($pasien->user) {
            $pasien->user->delete();
        } else {
            $pasien->delete();
        }

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function riwayat(Pasien $pasien)
    {
        $pasien->load('user');
        $riwayat = Pendaftaran::with(['dokter.user', 'rekamMedis'])
            ->where('pasien_id', $pasien->id)
            ->latest()
            ->get();

        return view('admin.pasien.riwayat', compact('pasien', 'riwayat'));
    }
}