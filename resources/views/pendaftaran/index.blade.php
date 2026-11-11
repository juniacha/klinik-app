@extends('layouts.app')

@section('title', 'Kelola Antrean & Pendaftaran')

@section('content')
    <!-- Header & Action Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: #35445B;">Daftar Antrean & Pendaftaran Pasien</h3>
            <p class="text-muted small mb-0">Kelola nomor antrean, verifikasi kehadiran, dan status pemeriksaan pasien.</p>
        </div>
        <a href="{{ route('pendaftaran.create') }}" class="btn text-white rounded-pill px-4 fw-semibold style-none"
            style="background-color: #35445B; font-size: 13px;">
            + Ambil Antrean Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabel Antrean Pasien -->
    <div class="widget-card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table id="table-pendaftaran" class="table table-hover align-middle mb-0" style="width:100%; font-size: 13px;">
                <thead class="table-light">
                    <tr>
                        <th width="12%">No. Antrean</th>
                        <th width="20%">Nama Pasien</th>
                        <th width="20%">Dokter Tujuan</th>
                        <th width="15%">Tgl Periksa</th>
                        <th width="15%">Kehadiran (Check-In)</th>
                        <th width="10%">Status</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftaran as $p)
                        <tr>
                            <td class="fw-bold" style="color: #934D56; font-size: 14px;">{{ $p->no_antrean }}</td>
                            <td>{{ $p->pasien->user->name ?? 'Pasien' }}</td>
                            <td>{{ $p->dokter->user->name ?? 'Dokter' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_periksa)->format('d-m-Y') }}</td>
                            <td>
                                @if ($p->is_hadir)
                                    <span class="badge bg-success rounded-pill px-3 py-1">Hadir</span>
                                @else
                                    <form action="{{ route('pendaftaran.checkIn', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-2 py-0 fw-semibold"
                                            style="font-size: 11px;">
                                            Konfirmasi Hadir
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($p->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($p->status == 'diperiksa')
                                    <span class="badge bg-info text-dark">Diperiksa</span>
                                @elseif ($p->status == 'pembayaran')
                                    <span class="badge badge-emergency">Kasir</span>
                                @else
                                    <span class="badge badge-aktif">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="{{ route('pendaftaran.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Batalkan antrean ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger btn-sm rounded-circle p-1 d-flex align-items-center justify-content-center"
                                            style="width: 26px; height: 26px;">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#table-pendaftaran').DataTable({
                "language": {
                    "search": "Cari Antrean:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data"
                }
            });
        });
    </script>
@endpush