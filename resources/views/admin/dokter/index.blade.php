@extends('layouts.app')

@section('title', 'Data Master Dokter')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #35445B;">Data Master Dokter</h3>
        <p class="text-muted small mb-0">Kelola akun dokter, spesialisasi poli, dan jadwal praktik klinik HERA.</p>
    </div>
    <a href="{{ route('admin.dokter.create') }}" class="btn text-white rounded-pill px-4 fw-semibold style-none" style="background-color: #934D56;">
        + Tambah Dokter Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-xs rounded-3 mb-4" role="alert">
        ✨ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="widget-card p-4">
    <div class="table-responsive">
        <table id="tabel-dokter" class="table table-hover align-middle text-xs w-100">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Dokter</th>
                    <th>Spesialisasi</th>
                    <th>No. STR</th>
                    <th>Jadwal Praktik</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dokter as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold" style="color: #35445B;">{{ $d->nama_dokter }}</td>
                        <td><span class="badge bg-info text-dark px-2 py-1">{{ $d->spesialis }}</span></td>
                        <td>{{ $d->no_str ?? '-' }}</td>
                        <td>{{ $d->jadwal_praktik ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.dokter.edit', $d->id) }}" class="btn btn-sm btn-warning py-1 px-2 text-xs">Edit</a>
                                <form action="{{ route('admin.dokter.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus akun dokter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger py-1 px-2 text-xs">Hapus</button>
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
    $(document).ready(function() {
        $('#tabel-dokter').DataTable({
            language: {
                search: "Cari Dokter:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data dokter terdaftar.",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: { next: "➔", previous: "⬅" }
            }
        });
    });
</script>
@endpush