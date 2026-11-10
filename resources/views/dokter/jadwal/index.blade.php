@extends('layouts.dokter')

@section('title', 'Jadwal Praktik & Ketersediaan')

@section('content')
<div class="row g-4">
    <!-- KELOLA KETERSEDIAAN JADWAL -->
    <div class="col-md-4">
        <div class="card-custom p-4">
            <h3 class="h6 font-bold text-hera-dark mb-3">⚙️ Pengaturan Jadwal Praktik</h3>

            <form action="{{ route('dokter.jadwal.update-ketersediaan') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label text-xs font-bold text-hera-dark">Jadwal Praktik</label>
                    <input type="text" name="jadwal_praktik" class="form-control form-control-sm" value="{{ old('jadwal_praktik', $dokter->jadwal_praktik ?? 'Senin - Jumat (08.00 - 16.00 WIB)') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-xs font-bold text-hera-dark">Status Ketersediaan Dokter</label>
                    <select name="status_praktik" class="form-select form-select-sm text-xs" required>
                        <option value="Tersedia" {{ ($dokter->status_praktik ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia (Praktik Aktif)</option>
                        <option value="Libur / Berhalangan" {{ ($dokter->status_praktik ?? '') == 'Libur / Berhalangan' ? 'selected' : '' }}>Libur / Berhalangan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm text-xs font-bold w-100 py-2">
                    Simpan Perubahan Jadwal
                </button>
            </form>
        </div>
    </div>

    <!-- JADWAL PEMERIKSAAN PASIEN -->
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h3 class="h6 font-bold text-hera-dark mb-3">📅 Jadwal Pemeriksaan Pasien Mendatang</h3>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-xs mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Antrean</th>
                            <th>Tanggal Periksa</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalPemeriksaan as $j)
                            <tr>
                                <td><span class="badge bg-secondary font-mono py-1 px-2">{{ $j->no_antrean }}</span></td>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($j->tgl_periksa)->format('d M Y') }}</td>
                                <td>{{ $j->pasien->user->name ?? '-' }}</td>
                                <td>{{ Str::limit($j->keluhan, 30) }}</td>
                                <td><span class="badge bg-info text-dark">{{ ucfirst($j->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada jadwal pendaftaran pemeriksaan mendatang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection