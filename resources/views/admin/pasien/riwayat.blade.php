@extends('layouts.app')

@section('title', 'Riwayat Kunjungan Pasien')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #35445B;">Riwayat Kunjungan Medis Pasien</h4>
            <p class="text-muted small mb-0">Pasien: <strong>{{ $pasien->user->name ?? '-' }}</strong> | No. RM:
                <strong>{{ $pasien->no_rm }}</strong>
            </p>
        </div>
        <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali ke Data Pasien</a>
    </div>

    <div class="widget-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-xs">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>No. Antrean</th>
                        <th>Tgl Periksa</th>
                        <th>Dokter Spesialis</th>
                        <th>Keluhan Pasien</th>
                        <th>Diagnosa & Tindakan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-secondary font-mono">{{ $r->no_antrean }}</span></td>
                            <td>{{ $r->tgl_periksa ? \Carbon\Carbon::parse($r->tgl_periksa)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="fw-bold" style="color: #35445B;">
                                    {{ $r->dokter->nama_dokter ?? $r->dokter->user->name ?? '-' }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ $r->dokter->spesialis ?? 'Poli Umum' }}
                                </div>
                            </td>
                            <td>{{ $r->keluhan ?? '-' }}</td>
                            <td>
                                @if($r->rekamMedis)
                                    <div class="mb-1">
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                            Diagnosa: {{ $r->rekamMedis->diagnosa }}
                                        </span>
                                    </div>
                                    @if($r->rekamMedis->tindakan)
                                        <div class="text-muted mb-1" style="font-size: 11px;">
                                            <strong>Tindakan:</strong> {{ $r->rekamMedis->tindakan }}
                                        </div>
                                    @endif
                                    @if($r->rekamMedis->resep_obat)
                                        <div class="text-muted font-mono" style="font-size: 11px;">
                                            <strong>Resep:</strong> {!! nl2br(e($r->rekamMedis->resep_obat)) !!}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">- Belum diperiksa -</span>
                                @endif
                            </td>
                            <td>
                                @if ($r->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($r->status == 'diperiksa')
                                    <span class="badge bg-info text-dark">Diperiksa</span>
                                @elseif ($r->status == 'pembayaran')
                                    <span class="badge bg-primary">Kasir</span>
                                @elseif ($r->status == 'batal')
                                    <span class="badge bg-danger">Batal</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Pasien ini belum pernah melakukan kunjungan
                                berobat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection