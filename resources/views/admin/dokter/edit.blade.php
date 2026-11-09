@extends('layouts.app')

@section('title', 'Edit Data Dokter')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="widget-card p-4">
            <h4 class="fw-bold mb-3" style="color: #35445B;">✏️ Edit Data Dokter</h4>

            <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Nama Dokter & Gelar</label>
                    <input type="text" name="nama_dokter" class="form-control form-control-sm @error('nama_dokter') is-invalid @enderror" value="{{ old('nama_dokter', $dokter->nama_dokter) }}" required>
                    @error('nama_dokter')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">Spesialisasi Poli</label>
                        <input type="text" name="spesialis" class="form-control form-control-sm @error('spesialis') is-invalid @enderror" value="{{ old('spesialis', $dokter->spesialis) }}" required>
                        @error('spesialis')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">No. STR</label>
                        <input type="text" name="no_str" class="form-control form-control-sm" value="{{ old('no_str', $dokter->no_str) }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-xs fw-bold">Jadwal Praktik Dokter</label>
                    <input type="text" name="jadwal_praktik" class="form-control form-control-sm @error('jadwal_praktik') is-invalid @enderror" value="{{ old('jadwal_praktik', $dokter->jadwal_praktik) }}" required>
                    @error('jadwal_praktik')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dokter.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #934D56;">Perbarui Data Dokter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection