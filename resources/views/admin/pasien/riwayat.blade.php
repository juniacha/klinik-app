@extends('layouts.app')

@section('title', 'Riwayat Kunjungan Pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: #35445B;">📜 Riwayat Kunjungan Medis Pasien</h4>
        <p class="text-muted small mb-0">Pasien: <strong>{{ $pasien->user->name ?? '-' }}</strong> | No. RM: <strong>{{ $pasien->no_rm }}</strong></p>
    </div>
    <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali ke Data Pasien</a>
</div>

<div class="widget-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-xs">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>No. Antrean</th>
                    <th>Tgl Periksa</th>
                    <th>Dokter Spesialis</th>
                    <th>Keluhan Pasien</th>
                    <th>Diagnosa Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-secondary font-mono">{{ $r->no_antrean }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($r->tgl_periksa)->format('d/m/Y') }}</td>
                        <td>{{ $r->dokter->nama_dokter ?? '-' }} ({{ $r->dokter->spesialis ?? 'Poli Umum' }})</td>
                        <td>{{ $r->keluhan }}</td>
                        <td>
                            @if($r->rekamMedis)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                    {{ $r->rekamMedis->diagnosa }}
                                </span>
                            @else
                                <span class="text-muted">- Belum diperiksa -</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($r->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Pasien ini belum pernah melakukan kunjungan berobat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection