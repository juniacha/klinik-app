@extends('layouts.app')

@section('title', 'Tambah Pendaftaran Antrean')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="widget-card p-4 bg-white rounded-4 shadow-sm">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #35445B;">Tambah Pendaftaran Antrean Pasien</h4>
                        <p class="text-muted small mb-0">Input pendaftaran antrean berobat baru untuk pasien klinik.</p>
                    </div>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-outline-secondary rounded-3">
                        ← Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger text-xs mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
                    @csrf

                    <!-- Pilih Pasien -->
                    <div class="mb-3">
                        <label for="pasien_id" class="form-label text-xs fw-bold">Pilih Pasien</label>
                        <select name="pasien_id" id="pasien_id"
                            class="form-select form-select-sm text-xs @error('pasien_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pasien Terdaftar --</option>
                            @if(isset($pasien))
                                @foreach($pasien as $p)
                                    <option value="{{ $p->id }}" {{ old('pasien_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->user->name ?? $p->nama_pasien ?? 'Pasien #' . $p->id }} (No. RM:
                                        {{ $p->no_rm ?? '-' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('pasien_id')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pilih Dokter Tujuan -->
                    <div class="mb-3">
                        <label for="dokter_id" class="form-label text-xs fw-bold">Pilih Dokter Tujuan / Poliklinik</label>
                        <select name="dokter_id" id="dokter_id"
                            class="form-select form-select-sm text-xs @error('dokter_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Dokter Penanggung Jawab --</option>
                            @if(isset($dokter))
                                @foreach($dokter as $d)
                                    <option value="{{ $d->id }}" {{ old('dokter_id') == $d->id ? 'selected' : '' }}>
                                        {{ $d->nama_dokter }} - {{ $d->spesialis ?? 'Poli Umum' }}
                                        ({{ $d->jadwal_praktik ?? 'Senin - Jumat' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('dokter_id')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Periksa -->
                    <div class="mb-3">
                        <label for="tgl_periksa" class="form-label text-xs fw-bold">Tanggal Rencana Periksa</label>
                        <input type="date" name="tgl_periksa" id="tgl_periksa"
                            class="form-control form-control-sm @error('tgl_periksa') is-invalid @enderror"
                            value="{{ old('tgl_periksa', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                        @error('tgl_periksa')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keluhan Pasien -->
                    <div class="mb-4">
                        <label for="keluhan" class="form-label text-xs fw-bold">Keluhan Utama Pasien</label>
                        <textarea name="keluhan" id="keluhan" rows="4"
                            class="form-control form-control-sm @error('keluhan') is-invalid @enderror"
                            placeholder="Tuliskan keluhan atau gejala pasien..." required>{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white text-xs font-bold px-4 py-2 rounded-3 shadow-sm"
                            style="background-color: #934D56;">
                            Simpan & Generasi Antrean
                        </button>
                        <a href="{{ route('admin.pendaftaran.index') }}"
                            class="btn btn-secondary text-xs px-4 py-2 rounded-3">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection