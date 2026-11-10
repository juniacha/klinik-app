@extends('layouts.app')

@section('title', 'Tambah Obat Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="widget-card p-4 bg-white rounded-4 shadow-sm">
            <h4 class="fw-bold mb-3" style="color: #35445B;">Tambah Data Obat Baru</h4>

            @if ($errors->any())
                <div class="alert alert-danger text-xs mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.obat.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control form-control-sm" value="{{ old('kode_obat', 'OBT-' . rand(100, 999)) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control form-control-sm @error('nama_obat') is-invalid @enderror" value="{{ old('nama_obat') }}" required placeholder="Contoh: Parasetamol 500mg">
                    @error('nama_obat')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <!-- DROPDOWN KATEGORI / JENIS OBAT -->
                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Kategori / Jenis Obat</label>
                    <select name="jenis" class="form-select form-select-sm @error('jenis') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Obat --</option>
                        <option value="Tablet / Kaplet" {{ old('jenis') == 'Tablet / Kaplet' ? 'selected' : '' }}>Tablet / Kaplet</option>
                        <option value="Sirup" {{ old('jenis') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="Kapsul" {{ old('jenis') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="Salep / Krim" {{ old('jenis') == 'Salep / Krim' ? 'selected' : '' }}>Salep / Krim</option>
                        <option value="Injeksi" {{ old('jenis') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                        <option value="Tetes" {{ old('jenis') == 'Tetes' ? 'selected' : '' }}>Tetes (Mata/Telinga)</option>
                        <option value="Umum" {{ old('jenis') == 'Umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    @error('jenis')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Jumlah Stok</label>
                    <input type="number" name="stok" class="form-control form-control-sm @error('stok') is-invalid @enderror" value="{{ old('stok') }}" required placeholder="100">
                    @error('stok')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-xs fw-bold">Harga Per Unit (Rp)</label>
                    <input type="number" name="harga" class="form-control form-control-sm @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required placeholder="5000">
                    @error('harga')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white text-xs font-bold px-4 py-2 rounded-3 shadow-sm" style="background-color: #934D56;">
                        Simpan Obat
                    </button>
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary text-xs px-4 py-2 rounded-3">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection