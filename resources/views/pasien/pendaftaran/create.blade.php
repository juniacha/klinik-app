@extends('layouts.pasien')

@section('title', 'Booking Dokter')

@section('content')
    <div class="container py-3">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h4 font-bold text-hera-dark mb-1">Pendaftaran Pemeriksaan Dokter</h1>
                <p class="text-xs text-muted mb-0">Pilih poliklinik tujuan Anda dan lengkapi form booking.</p>
            </div>
            <a href="{{ route('pasien.dashboard') }}" class="btn btn-outline-secondary btn-sm text-xs rounded-3">
                ← Kembali ke Beranda
            </a>
        </div>

        @if(empty($selectedPoli))
            <div class="mb-5">
                <h2 class="h6 font-bold text-hera-dark mb-3">Pilih Poliklinik Tujuan</h2>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <a href="{{ route('pasien.booking.create', ['poli' => 'Poli Umum']) }}" class="text-decoration-none">
                            <div class="card card-poli border-0 shadow-sm rounded-4 p-4 text-center h-100">
                                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Umum</h3>
                                <p class="text-xs text-muted mb-0">Pemeriksaan umum dan konsultasi kesehatan harian.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-4">
                        <a href="{{ route('pasien.booking.create', ['poli' => 'Poli Gigi']) }}" class="text-decoration-none">
                            <div class="card card-poli border-0 shadow-sm rounded-4 p-4 text-center h-100">
                                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Gigi & Mulut</h3>
                                <p class="text-xs text-muted mb-0">Perawatan gigi, scaling, penambalan & ekstraksi.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-4">
                        <a href="{{ route('pasien.booking.create', ['poli' => 'Poli Anak']) }}" class="text-decoration-none">
                            <div class="card card-poli border-0 shadow-sm rounded-4 p-4 text-center h-100">
                                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Anak (Pediatri)</h3>
                                <p class="text-xs text-muted mb-0">Konsultasi kesehatan anak & imunisasi berkala.</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-4">
                        <a href="{{ route('pasien.booking.create', ['poli' => 'Poli Penyakit Dalam']) }}"
                            class="text-decoration-none">
                            <div class="card card-poli border-0 shadow-sm rounded-4 p-4 text-center h-100">
                                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Penyakit Dalam</h3>
                                <p class="text-xs text-muted mb-0">Pemeriksaan organ dalam, gula darah & hipertensi.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        @else
            <!-- FORM BOOKING -->
            <form action="{{ route('pasien.booking.store') }}" method="POST">
                @csrf

                <!-- INPUT HIDDEN DOKTER ID -->
                <input type="hidden" name="dokter_id" value="{{ $dokter->id ?? '' }}">

                <!-- BADGE POLI TERPILIH -->
                <div class="d-flex align-items-center justify-content-between mb-3 bg-white p-3 rounded-4 shadow-sm border">
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <span class="text-xs text-muted d-block">Poliklinik Terpilih:</span>
                            <strong class="text-hera-dark fs-6">{{ $selectedPoli }}</strong>
                        </div>
                    </div>
                    <a href="{{ route('pasien.booking.create') }}" class="btn btn-outline-secondary btn-sm text-xs rounded-3">
                        Ganti Poli
                    </a>
                </div>

                <div class="row g-4">
                    <!-- DATA PASIEN, TANGGAL & KELUHAN -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Data Pasien & Rencana Kunjungan
                            </h2>

                            <div class="p-3 rounded-3 mb-3 bg-light border text-xs">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-muted d-block">Nama Pasien:</span>
                                        <strong class="text-hera-dark">{{ Auth::user()->name }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">No. Rekam Medis:</span>
                                        <strong style="color: #934D56;">{{ $pasien->no_rm ?? 'RM-000001' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_periksa" class="form-label text-xs font-bold text-hera-dark">Tanggal Rencana
                                    Periksa</label>
                                <input type="date" name="tgl_periksa" id="tgl_periksa"
                                    class="form-control form-control-sm @error('tgl_periksa') is-invalid @enderror"
                                    value="{{ old('tgl_periksa', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                @error('tgl_periksa')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keluhan" class="form-label text-xs font-bold text-hera-dark">Keluhan Utama / Gejala
                                    Singkat</label>
                                <textarea name="keluhan" id="keluhan" rows="4"
                                    class="form-control form-control-sm @error('keluhan') is-invalid @enderror"
                                    placeholder="Tuliskan gejala atau keluhan singkat yang Anda rasakan..."
                                    required>{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div
                            class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Dokter Penanggung Jawab
                                </h2>

                                <div class="p-4 rounded-4 border text-center" style="background-color: #F8FAF9;">
                                    <div class="brand-icon mx-auto mb-3"
                                        style="width: 56px; height: 56px; font-size: 26px; background: #35445B; color: #fff; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                                        👨‍⚕️
                                    </div>

                                    <h3 class="h6 font-bold text-hera-dark mb-1">
                                        {{ $dokter->nama_dokter ?? 'dr. Dokter Klinik' }}
                                    </h3>

                                    <span class="badge mb-3 px-3 py-1.5 rounded-pill"
                                        style="background-color: #BA9796; color: #fff;">
                                        {{ $dokter->spesialis ?? $selectedPoli }}
                                    </span>

                                    <hr class="my-3 text-muted">

                                    <div class="text-start text-xs space-y-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Jadwal Praktik:</span>
                                            <strong
                                                class="text-hera-dark">{{ $dokter->jadwal_praktik ?? 'Senin - Jumat (08.00 - 15.00 WIB)' }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Status Praktik:</span>
                                            <span class="badge bg-success text-white">Tersedia</span>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-xs text-muted text-center mt-3 mb-0">
                                    Dokter disesuaikan secara otomatis dari database untuk spesialisasi
                                    <strong>{{ $selectedPoli }}</strong>.
                                </p>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn text-white w-100 font-bold text-xs py-3 rounded-3 shadow-sm"
                                    style="background-color: #934D56;">
                                    + Simpan & Ambil Nomor Antrean
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <style>
        .card-poli {
            transition: all 0.25s ease;
            border: 2px solid transparent !important;
        }

        .card-poli:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(53, 68, 91, 0.1) !important;
            border-color: #934D56 !important;
        }
    </style>
@endsection