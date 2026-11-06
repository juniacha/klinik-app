@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="color: #35445B; font-weight: 700; margin: 0;">Dashboard Overview</h2>
            <p class="text-muted mb-0">Selamat datang di Panel Administrasi Klinik HERA</p>
        </div>
        <span class="badge badge-aktif px-3 py-2">
            📅 {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
        </span>
    </div>

    <!-- Ringkasan Statistik (Card Grid) -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0" style="border-left: 5px solid #35445B !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-semibold">TOTAL PASIEN</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: #35445B;">{{ $totalPasien }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #F9F6F0;">
                        👤
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0" style="border-left: 5px solid #A3A57E !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-semibold">DOKTER AKTIF</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: #35445B;">{{ $totalDokter }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #F9F6F0;">
                        👨‍⚕️
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0" style="border-left: 5px solid #934D56 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-semibold">ANTREAN HARI INI</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: #934D56;">{{ $antreanHariIni }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #F9F6F0;">
                        📋
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm border-0" style="border-left: 5px solid #BA9796 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-semibold">STOK OBAT KRITIS</small>
                        <h3 class="fw-bold mb-0 mt-1" style="color: #35445B;">{{ $obatHampirHabis }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #F9F6F0;">
                        💊
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Antrean Pasien Hari Ini -->
    <div class="card p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 style="color: #35445B; font-weight: 700; margin: 0;">Antrean Pasien Hari Ini</h4>
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm text-white fw-semibold" style="background-color: #35445B; border-radius: 20px;">
                Lihat Semua Antrean &rarr;
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Dokter Tujuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($antreanTerbaru as $antrean)
                        <tr>
                            <td class="fw-bold" style="color: #934D56;">{{ $antrean->no_antrean }}</td>
                            <td>{{ $antrean->pasien->user->name ?? 'Pasien' }}</td>
                            <td>{{ $antrean->dokter->user->name ?? 'Dokter' }}</td>
                            <td>
                                @if($antrean->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($antrean->status == 'diperiksa')
                                    <span class="badge bg-info text-dark">Diperiksa</span>
                                @elseif($antrean->status == 'pembayaran')
                                    <span class="badge badge-emergency">Kasir</span>
                                @else
                                    <span class="badge badge-aktif">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">Belum ada antrean pendaftaran untuk hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection