@extends('layouts.app')

@section('title', 'Form Pendaftaran Antrean')

@section('content')
<div class="form-card">
    <h2 class="mb-4">Form Ambil Nomor Antrean Pasien</h2>

    @if (session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pendaftaran.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="pasien_id" class="form-label fw-semibold">Pilih Pasien</label>
            <select name="pasien_id" id="pasien_id" class="form-select @error('pasien_id') is-invalid @enderror">
                <option value="">-- Pilih Pasien --</option>
                @foreach ($pasien as $ps)
                    <option value="{{ $ps->id }}" {{ old('pasien_id') == $ps->id ? 'selected' : '' }}>
                        {{ $ps->user->name }} (No. RM: {{ $ps->no_rm }})
                    </option>
                @endforeach
            </select>
            @error('pasien_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="dokter_id" class="form-label fw-semibold">Pilih Dokter & Spesialisasi</label>
            <select name="dokter_id" id="dokter_id" class="form-select @error('dokter_id') is-invalid @enderror">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokter as $dk)
                    <option value="{{ $dk->id }}" {{ old('dokter_id') == $dk->id ? 'selected' : '' }}>
                        {{ $dk->user->name }} - {{ $dk->spesialisasi }}
                    </option>
                @endforeach
            </select>
            @error('dokter_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="tgl_periksa" class="form-label fw-semibold">Tanggal Pemeriksaan</label>
            <input type="date" name="tgl_periksa" id="tgl_periksa" class="form-control @error('tgl_periksa') is-invalid @enderror" value="{{ old('tgl_periksa', date('Y-m-d')) }}">
            @error('tgl_periksa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn text-white fw-bold" style="background-color: #35445B;">Daftar Antrean</button>
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary fw-semibold">Batal</a>
        </div>
    </form>
</div>
@endsection