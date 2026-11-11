@extends('layouts.pasien')

@section('title', 'Rekam Medis Pasien')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 font-bold text-hera-dark mb-1">Riwayat Rekam Medis & Resep Obat</h1>
            <p class="text-xs text-muted mb-0">Catatan riwayat hasil pemeriksaan medis, diagnosa dokter, dan resep obat
                resmi.</p>
        </div>
        <a href="{{ route('pasien.dashboard') }}" class="btn btn-outline-secondary btn-sm text-xs rounded-3">← Beranda
            Pasien</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs w-100">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tgl Periksa</th>
                        <th>Dokter Spesialis</th>
                        <th>Keluhan Utama</th>
                        <th>Diagnosa Dokter</th>
                        <th>Tindakan & Resep Obat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatMedis as $index => $rm)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</td>
                            <td class="fw-bold text-hera-dark">{{ $rm->dokter->nama_dokter ?? '-' }}</td>
                            <td>{{ $rm->keluhan ?? '-' }}</td>
                            <td><span
                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1">{{ $rm->diagnosa ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="p-2 bg-light rounded border font-mono">
                                    {!! nl2br(e($rm->resep_obat ?? $rm->tindakan ?? 'Tidak ada resep khusus.')) !!}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat rekam medis terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection