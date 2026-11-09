<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::with('user')->latest()->get();
        return view('admin.dokter.index', compact('dokter'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter'    => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'spesialis'      => 'required|string|max:100',
            'no_str'         => 'nullable|string|max:50',
            'jadwal_praktik' => 'required|string|max:255',
        ]);

        // 1. Buat Akun User Dokter
        $user = User::create([
            'name'     => $request->nama_dokter,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'dokter',
        ]);

        // 2. Buat Profil Dokter
        Dokter::create([
            'user_id'        => $user->id,
            'nama_dokter'    => $request->nama_dokter,
            'spesialis'      => $request->spesialis,
            'no_str'         => $request->no_str,
            'jadwal_praktik' => $request->jadwal_praktik,
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Akun dokter berhasil ditambahkan.');
    }

    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama_dokter'    => 'required|string|max:255',
            'spesialis'      => 'required|string|max:100',
            'no_str'         => 'nullable|string|max:50',
            'jadwal_praktik' => 'required|string|max:255',
        ]);

        $dokter->update([
            'nama_dokter'    => $request->nama_dokter,
            'spesialis'      => $request->spesialis,
            'no_str'         => $request->no_str,
            'jadwal_praktik' => $request->jadwal_praktik,
        ]);

        if ($dokter->user) {
            $dokter->user->update(['name' => $request->nama_dokter]);
        }

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Dokter $dokter)
    {
        if ($dokter->user) {
            $dokter->user->delete();
        } else {
            $dokter->delete();
        }

        return redirect()->route('admin.dokter.index')->with('success', 'Akun dokter berhasil dihapus.');
    }
}