<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::latest()->get();
        return view('obat.index', compact('obat'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis'     => 'nullable|string|max:100',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'stok.required'      => 'Jumlah stok wajib diisi.',
            'harga.required'     => 'Harga obat wajib diisi.',
        ]);

        Obat::create([
            'kode_obat' => $request->kode_obat ?? ('OBT-' . rand(100, 999)),
            'nama_obat' => $request->nama_obat,
            'jenis'     => $request->jenis ?? 'Umum',
            'stok'      => $request->stok,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
        ]);

        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'jenis'     => $request->jenis ?? 'Umum',
            'stok'      => $request->stok,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil dihapus!');
    }
}