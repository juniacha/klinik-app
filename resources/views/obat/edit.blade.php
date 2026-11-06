@extends('layouts.app')

@section('title', 'Edit Data Obat')

@section('content')
<div class="form-card">
    <h2 class="mb-4">Edit Data Obat</h2>

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="kode_obat" class="form-label fw-semibold">Kode Obat</label>
            <input type="text" name="kode_obat" id="kode_obat" class="form-control @error('kode_obat') is-invalid @enderror" value="{{ old('kode_obat', $obat->kode_obat) }}">
            @error('kode_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nama_obat" class="form-label fw-semibold">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" class="form-control @error('nama_obat') is-invalid @enderror" value="{{ old('nama_obat', $obat->nama_obat) }}">
            @error('nama_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="stok" class="form-label fw-semibold">Jumlah Stok</label>
            <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $obat->stok) }}">
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="harga" class="form-label fw-semibold">Harga Per Unit (Rp)</label>
            <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $obat->harga) }}">
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white fw-bold" style="background-color: #5c3347;">Perbarui Data</button>
            <a href="{{ route('obat.index') }}" class="btn btn-secondary fw-semibold">Batal</a>
        </div>
    </form>
</div>
@endsection