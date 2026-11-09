@extends('layouts.pasien')

@section('title', 'Beranda Pasien')

@section('content')
<!-- 1. HERO BANNER (Sesuai Referensi Astra Dent & CarePlus) -->
<div class="hero-banner p-4 p-md-5 mb-5 shadow-sm position-relative overflow-hidden">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="badge bg-white text-dark text-xs px-3 py-2 rounded-pill font-semibold mb-3">
                ✨ Hera Modern Health Care
            </span>
            <h1 class="display-6 font-bold text-white mb-3">
                Kesehatan Anda, <br><span style="color: #BA9796;">Prioritas Utama Kami</span>
            </h1>
            <p class="text-white-50 text-sm mb-4 max-w-xl">
                Nikmati kemudahan pendaftaran antrean berobat online, konsultasi dengan dokter spesialis berpengalaman, dan pantau rekam medis secara cepat.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('pasien.booking.create') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i> Booking Dokter
                </a>

                <a href="{{ route('pasien.riwayat') }}" class="btn btn-info">
                    <i class="fas fa-history"></i> Riwayat Berobat & Rekam Medis
                </a>
            </div>
        </div>
        <div class="col-lg-5 text-center d-none d-lg-block">
            <div class="p-4 bg-white/10 rounded-4 border border-white/10 backdrop-blur-md">
                <div class="text-white-50 text-xs text-uppercase font-bold mb-1">No. Rekam Medis Saya</div>
                <div class="h3 font-extrabold text-white mb-2">{{ $pasien->no_rm ?? 'RM-000001' }}</div>
                <div class="text-xs text-white-50">NIK: {{ $pasien->nik ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- 2. PILIHAN LAYANAN & POLIKLINIK (Sesuai Referensi CarePlus & GeneX) -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h5 font-bold text-hera-dark mb-1">Layanan Poliklinik</h2>
            <p class="text-xs text-muted mb-0">Pilih spesialisasi dokter sesuai kebutuhan pemeriksaan Anda</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card-service p-4 h-100">
                <div class="fs-2 mb-3">🩺</div>
                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Umum</h3>
                <p class="text-xs text-muted mb-3">Pemeriksaan kesehatan umum, diagnosis awal, dan konsultasi keluhan harian.</p>
                <a href="{{ route('pasien.pendaftaran.create') }}" class="text-xs font-bold text-hera-maroon text-decoration-none">Daftar Antrean ➔</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-service p-4 h-100">
                <div class="fs-2 mb-3">🦷</div>
                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Gigi & Mulut</h3>
                <p class="text-xs text-muted mb-3">Perawatan kesehatan gigi, pembersihan karang, pencabutan, dan estetika mulut.</p>
                <a href="{{ route('pasien.pendaftaran.create') }}" class="text-xs font-bold text-hera-maroon text-decoration-none">Daftar Antrean ➔</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-service p-4 h-100">
                <div class="fs-2 mb-3">👶</div>
                <h3 class="h6 font-bold text-hera-dark mb-1">Poli Anak (Pediatri)</h3>
                <p class="text-xs text-muted mb-3">Layanan kesehatan khusus bayi dan anak-anak serta imunisasi berkala.</p>
                <a href="{{ route('pasien.pendaftaran.create') }}" class="text-xs font-bold text-hera-maroon text-decoration-none">Daftar Antrean ➔</a>
            </div>
        </div>
    </div>
</div>

<!-- 3. RIWAYAT ANTREAN TERBARU -->
<div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff;">
    <h3 class="h6 font-bold text-hera-dark mb-3">Status Antrean Pendaftaran Anda</h3>
    <div class="table-responsive">
        <table class="table table-hover align-middle text-xs mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Antrean</th>
                    <th>Dokter Spesialis</th>
                    <th>Tanggal Periksa</th>
                    <th>Status Antrean</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPendaftaran ?? [] as $p)
                    <tr>
                        <td><span class="badge bg-secondary font-mono px-2 py-1">{{ $p->no_antrean }}</span></td>
                        <td class="fw-bold text-hera-dark">{{ $p->dokter->nama_dokter ?? 'dr. Klinik' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_periksa)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-warning text-dark font-semibold px-2 py-1 rounded-pill">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada antrean berobat aktif. Silakan buat janji dokter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection