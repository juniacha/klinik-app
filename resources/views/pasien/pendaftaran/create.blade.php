@extends('layouts.pasien')

@section('title', 'Booking Dokter')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h1 class="h5 font-bold text-hera-dark mb-1">📝 Form Booking Dokter</h1>
            <p class="text-xs text-muted mb-4">Pilih dokter spesialis dan tentukan tanggal rencana kunjungan Anda.</p>

            @if(session('error'))
                <div class="alert alert-danger text-xs mb-3">{{ session('error') }}</div>
            @endif

            <form action="{{ route('pasien.booking.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-xs font-bold text-hera-dark">Nama Pasien</label>
                    <input type="text" class="form-control form-control-sm bg-light" value="{{ Auth::user()->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="dokter_id" class="form-label text-xs font-bold text-hera-dark">Pilih Dokter Tujuan</label>
                    <select name="dokter_id" id="dokter_id" class="form-select form-select-sm @error('dokter_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter & Spesialis --</option>
                        @foreach($dokter as $d)
                            <option value="{{ $d->id }}" {{ old('dokter_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->nama_dokter }} ({{ $d->spesialis ?? 'Poli Umum' }})
                            </option>
                        @endforeach
                    </select>
                    @error('dokter_id')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tgl_periksa" class="form-label text-xs font-bold text-hera-dark">Tanggal Rencana Periksa</label>
                    <input type="date" name="tgl_periksa" id="tgl_periksa" class="form-control form-control-sm @error('tgl_periksa') is-invalid @enderror" value="{{ old('tgl_periksa', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                    @error('tgl_periksa')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="keluhan" class="form-label text-xs font-bold text-hera-dark">Keluhan Utama</label>
                    <textarea name="keluhan" id="keluhan" rows="3" class="form-control form-control-sm @error('keluhan') is-invalid @enderror" placeholder="Tuliskan gejala atau keluhan singkat Anda..." required>{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback text-xs">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pasien.dashboard') }}" class="btn btn-outline-secondary btn-sm text-xs rounded-3">← Batal</a>
                    <button type="submit" class="btn btn-primary text-xs font-bold px-4 py-2 rounded-3 shadow-sm">
                        + Simpan & Ambil Antrean
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection