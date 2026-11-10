@extends('layouts.app')

@section('title', 'Edit Data Obat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="widget-card p-4 bg-white rounded-4 shadow-sm">
            <h4 class="fw-bold mb-3" style="color: #35445B;">Edit Data Obat</h4>

            <form action="{{ route('admin.obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control form-control-sm" value="{{ old('kode_obat', $obat->kode_obat) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control form-control-sm" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                </div>

                <!-- DROPDOWN KATEGORI / JENIS OBAT EDIT -->
                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Kategori / Jenis Obat</label>
                    <select name="jenis" class="form-select form-select-sm">
                        <option value="">-- Pilih Jenis Obat --</option>
                        <option value="Tablet / Kaplet" {{ old('jenis', $obat->jenis) == 'Tablet / Kaplet' ? 'selected' : '' }}>Tablet / Kaplet</option>
                        <option value="Sirup" {{ old('jenis', $obat->jenis) == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="Kapsul" {{ old('jenis', $obat->jenis) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="Salep / Krim" {{ old('jenis', $obat->jenis) == 'Salep / Krim' ? 'selected' : '' }}>Salep / Krim</option>
                        <option value="Injeksi" {{ old('jenis', $obat->jenis) == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                        <option value="Tetes" {{ old('jenis', $obat->jenis) == 'Tetes' ? 'selected' : '' }}>Tetes (Mata/Telinga)</option>
                        <option value="Umum" {{ old('jenis', $obat->jenis) == 'Umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Jumlah Stok</label>
                    <input type="number" name="stok" class="form-control form-control-sm" value="{{ old('stok', $obat->stok) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-xs fw-bold">Harga Per Unit (Rp)</label>
                    <input type="number" name="harga" class="form-control form-control-sm" value="{{ old('harga', $obat->harga) }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white text-xs font-bold px-4 py-2 rounded-3 shadow-sm" style="background-color: #934D56;">
                        Perbarui Obat
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