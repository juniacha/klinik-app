@extends('layouts.app')

@section('title', 'Kelola Antrean & Pendaftaran')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Antrean & Pendaftaran Pasien</h2>
        <a href="{{ route('pendaftaran.create') }}" class="btn text-white fw-semibold" style="background-color: #35445B;">+ Ambil Antrean Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive mt-3">
        <table id="table-pendaftaran" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No. Antrean</th>
                    <th>Nama Pasien</th>
                    <th>Dokter Tujuan</th>
                    <th>Tgl Periksa</th>
                    <th>Kehadiran (Check-In)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendaftaran as $p)
                    <tr>
                        <td class="fw-bold" style="color: #934D56; font-size: 16px;">{{ $p->no_antrean }}</td>
                        <td>{{ $p->pasien->user->name ?? 'Pasien' }}</td>
                        <td>{{ $p->dokter->user->name ?? 'Dokter' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_periksa)->format('d-m-Y') }}</td>
                        <td>
                            @if ($p->is_hadir)
                                <span class="badge bg-success">📍 Hadir di Klinik</span>
                            @else
                                <form action="{{ route('pendaftaran.checkIn', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">Konfirmasi Hadir</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if ($p->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif ($p->status == 'diperiksa')
                                <span class="badge bg-info text-dark">Sedang Diperiksa</span>
                            @elseif ($p->status == 'pembayaran')
                                <span class="badge bg-primary">Menunggu Pembayaran</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if ($p->status == 'menunggu')
                                    <form action="{{ route('pendaftaran.lewati', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm fw-semibold" title="Lewati jika 3x dipanggil belum menyahut">Lewati (Kelempar)</button>
                                    </form>
                                @endif
                                <form action="{{ route('pendaftaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Batalkan pendaftaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm fw-semibold">Batal</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-pendaftaran').DataTable();
    });
</script>
@endpush
@endsection