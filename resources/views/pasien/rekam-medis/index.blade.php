@extends('layouts.pasien')

@section('title', 'Riwayat Rekam Medis')

@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff;">
    <h1 class="h4 font-bold text-hera-dark mb-1">📜 Riwayat Rekam Medis & Resep Saya</h1>
    <p class="text-xs text-muted mb-4">Hasil diagnosa dan resep obat resmi yang diterbitkan oleh dokter penanggung jawab.</p>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-xs">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal Periksa</th>
                    <th>Dokter Spesialis</th>
                    <th>Diagnosa Dokter</th>
                    <th>Tindakan Medis</th>
                    <th>Resep Obat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatMedis as $index => $rm)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="fw-bold">{{ \Carbon\Carbon::parse($rm->created_at)->format('d M Y') }}</span></td>
                        <td>{{ $rm->dokter->nama_dokter }} ({{ $rm->dokter->spesialis }})</td>
                        <td>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1">
                                {{ $rm->diagnosa }}
                            </span>
                        </td>
                        <td>{{ $rm->tindakan }}</td>
                        <td class="font-mono text-hera-maroon">{!! nl2br(e($rm->resep_obat ?? 'Tidak ada resep obat.')) !!}</td>
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