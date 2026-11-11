@extends('layouts.dokter')

@section('title', 'Riwayat Medis Pasien')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-hera-dark mb-1">Riwayat Rekam Medis Pasien</h4>
            <p class="text-xs text-muted mb-0">Pasien: <strong>{{ $pasien->user->name ?? '-' }}</strong> (No. RM:
                {{ $pasien->no_rm ?? '-' }})
            </p>
        </div>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-3 text-xs">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Periksa</th>
                        <th>Dokter</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Tindakan & Resep Obat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatMedis as $index => $rm)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $rm->dokter->nama_dokter ?? '-' }}</td>
                            <td>{{ $rm->keluhan ?? '-' }}</td>
                            <td><span
                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 py-1">{{ $rm->diagnosa ?? '-' }}</span>
                            </td>
                            <td class="font-mono">{!! nl2br(e($rm->resep_obat ?? $rm->tindakan ?? '-')) !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat rekam medis untuk pasien ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection