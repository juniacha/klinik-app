@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="form-card">
    <h2 class="mb-4">Tambah Data Obat Baru</h2>

    <form action="{{ route('obat.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="kode_obat" class="form-label fw-semibold">Kode Obat</label>
            <input type="text" name="kode_obat" id="kode_obat" class="form-control @error('kode_obat') is-invalid @enderror" value="{{ old('kode_obat') }}" placeholder="Contoh: OBT-001">
            @error('kode_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nama_obat" class="form-label fw-semibold">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" class="form-control @error('nama_obat') is-invalid @enderror" value="{{ old('nama_obat') }}" placeholder="Contoh: Paracetamol 500mg">
            @error('nama_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="stok" class="form-label fw-semibold">Jumlah Stok</label>
            <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}">
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="harga" class="form-label fw-semibold">Harga Per Unit (Rp)</label>
            <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" placeholder="Contoh: 5000">
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white fw-bold" style="background-color: #5c3347;">Simpan Obat</button>
            <a href="{{ route('obat.index') }}" class="btn btn-secondary fw-semibold">Batal</a>
        </div>
    </form>
</div>
@endsection