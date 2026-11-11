@extends('layouts.pasien')

@section('title', 'Beranda Pasien')

@section('content')
    <!-- BANNER INFORMASI PROFIL & REKAM MEDIS -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4"
        style="background: linear-gradient(135deg, #35445B 0%, #2A3649 100%); color: white;">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <span class="badge bg-white text-dark text-xs px-3 py-2 rounded-pill font-semibold mb-3">
                    Hera Modern Health Care
                </span>
                <h1 class="h3 font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-white-50 text-xs mb-0">Kelola jadwal kunjungan berobat dan cek riwayat kesehatan Anda dengan
                    mudah.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div
                    class="p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 d-inline-block text-start w-100">
                    <div class="text-white-50 text-xs font-bold text-uppercase">Nomor Rekam Medis</div>
                    <div class="fs-4 font-extrabold text-white">{{ $pasien->no_rm ?? 'RM-000001' }}</div>
                    <div class="text-xs text-white-50">NIK: {{ $pasien->nik ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATUS ANTREAN HARI INI -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h2 class="h6 font-bold text-hera-dark mb-3">Status Antrean Aktif Hari Ini</h2>
                @if($antreanAktif)
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary font-mono px-3 py-1 fs-6">{{ $antreanAktif->no_antrean }}</span>
                            <span class="badge bg-warning text-dark px-2.5 py-1">{{ ucfirst($antreanAktif->status) }}</span>
                        </div>
                        <p class="text-xs mb-1"><strong>Dokter:</strong> {{ $antreanAktif->dokter->nama_dokter ?? '-' }}</p>
                        <p class="text-xs mb-0"><strong>Keluhan:</strong> {{ $antreanAktif->keluhan }}</p>
                    </div>
                @else
                    <div class="text-center py-4 text-muted text-xs">
                        <p class="mb-2">Belum ada antrean berobat aktif untuk hari ini.</p>
                        <a href="{{ route('pasien.booking.create') }}" class="btn btn-sm text-white px-3 py-1.5 rounded-3"
                            style="background-color: #934D56;">
                            + Booking Dokter Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIWAYAT KUNJUNGAN TERAKHIR -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h2 class="h6 font-bold text-hera-dark mb-3">Riwayat Kunjungan Pendaftaran</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-xs mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Antrean</th>
                            <th>Dokter Tujuan</th>
                            <th>Tanggal Periksa</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPendaftaran as $p)
                            <tr>
                                <td><span class="badge bg-secondary font-mono">{{ $p->no_antrean }}</span></td>
                                <td class="fw-bold text-hera-dark">{{ $p->dokter->nama_dokter ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_periksa)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($p->keluhan, 30) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'batal' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat kunjungan pendaftaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection