<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
        return view('obat.index', compact('obat'));
    }

    public function create()
    {
        return view('obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_obat' => 'required|string|max:20|unique:obat,kode_obat',
            'nama_obat' => 'required|string|max:100',
            'stok'      => 'required|integer|min:0',
            'harga'     => 'required|numeric|min:0',
        ], [
            'kode_obat.required' => 'Kode obat wajib diisi.',
            'kode_obat.unique' => 'Kode obat sudah terdaftar di sistem.', 
            'nama_obat.required' => 'Nama obat wajib diisi',
            'stok.min' => 'Stok minimal bernilai 0.',
            'harga.min' => 'Harga minimal bernilai 0.',
        ]);

        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function edit(Obat $obat)
    {
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'kode_obat' => 'required|string|max:20|unique:obat,kode_obat,'. $obat->id,
            'nama_obat' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ], [
            'srok.min' => 'Stok minimal bernilai 0.',
            'harga.min' => 'Harga minimal bernilai 0.',
        ]);

        $obat->update($validated);
        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obat.index')->with('succuss', 'Data obat berhasil dihapus!');
    }
}
