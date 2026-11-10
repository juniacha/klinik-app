@extends('layouts.dokter')

@section('title', 'Dashboard Antrean Dokter')

@section('content')
<div class="row g-4 mb-4">
    <!-- Informasi Dokter -->
    <div class="col-md-8">
        <div class="card-custom p-4 text-white" style="background: linear-gradient(135deg, #35445B 0%, #2A3649 100%);">
            <span class="badge bg-warning text-dark font-bold text-xs mb-2">Poli & Spesialis</span>
            <h1 class="h4 font-bold text-white mb-1">Selamat Datang, {{ Auth::user()->name }}</h1>
            <p class="text-white-50 text-xs mb-3">Spesialisasi: <strong>{{ $dokter->spesialis ?? 'Poli Umum' }}</strong> | STR: {{ $dokter->no_str ?? '-' }}</p>
            <div class="d-flex gap-2">
                <span class="badge bg-white text-dark text-xs px-3 py-2">Jadwal: {{ $dokter->jadwal_praktik ?? 'Senin - Jumat' }}</span>
                <span class="badge bg-success text-white text-xs px-3 py-2">Status: {{ $dokter->status_praktik ?? 'Tersedia' }}</span>
            </div>
        </div>
    </div>

    <!-- Live Counter Antrean -->
    <div class="col-md-4">
        <div class="card-custom p-4 text-center h-100 d-flex flex-column justify-content-center">
            <div class="text-xs text-muted font-bold text-uppercase mb-1">Total Antrean Pasien Hari Ini</div>
            <div class="h1 font-extrabold text-hera-maroon mb-0" style="color: #934D56;">{{ $antreanHariIni->count() }}</div>
            <div class="text-xs text-muted mt-1">
                Selesai: <strong>{{ $antreanHariIni->where('status', 'selesai')->count() }}</strong> Pasien
            </div>
        </div>
    </div>
</div>

<!-- TABEL ANTREAN PASIEN HARI INI -->
<div class="card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="h6 font-bold text-hera-dark mb-0">📋 Daftar Antrean Pemeriksaan Pasien Hari Ini</h3>
        <span class="text-xs text-muted">Tanggal: {{ date('d M Y') }}</span>
    </div>

    <div class="table-responsive">
        <table id="tabel-antrean-dokter" class="table table-hover align-middle text-xs w-100">
            <thead class="table-light">
                <tr>
                    <th>No. Antrean</th>
                    <th>Nama Pasien</th>
                    <th>No. RM</th>
                    <th>Keluhan Awal</th>
                    <th>Status Antrean</th>
                    <th>Aksi Pemeriksaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antreanHariIni as $a)
                    <tr>
                        <td><span class="badge bg-secondary font-mono px-2 py-1">{{ $a->no_antrean }}</span></td>
                        <td class="fw-bold text-hera-dark">{{ $a->pasien->user->name ?? $a->pasien->nama_pasien ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $a->pasien->no_rm ?? 'RM-000001' }}</span></td>
                        <td><span class="text-muted">{{ Str::limit($a->keluhan ?? 'Keluhan umum', 35) }}</span></td>
                        <td>
                            @if($a->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($a->status === 'sedang diperiksa')
                                <span class="badge bg-primary">Sedang Diperiksa</span>
                            @elseif($a->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($a->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('dokter.pemeriksaan.create', $a->id) }}" class="btn btn-sm btn-primary font-bold px-3 text-xs">
                                    🩺 Periksa Pasien
                                </a>
                                <a href="{{ route('dokter.rekam-medis.show', $a->pasien_id) }}" class="btn btn-sm btn-outline-info text-xs">
                                    📜 Riwayat
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada antrean pasien untuk hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tabel-antrean-dokter').DataTable({
            language: {
                search: "Cari Pasien:",
                lengthMenu: "Tampilkan _MENU_ data",
                paginate: { next: "➔", previous: "⬅" }
            }
        });
    });
</script>
@endpush