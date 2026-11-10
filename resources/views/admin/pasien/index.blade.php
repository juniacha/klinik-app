@extends('layouts.app')

@section('title', 'Data Master Pasien')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #35445B;">Data Master Pasien</h3>
        <p class="text-muted small mb-0">Kelola informasi pasien terdaftar dan riwayat rekam medis klinik HERA.</p>
    </div>
    <a href="{{ route('admin.pasien.create') }}" class="btn text-white rounded-pill px-4 fw-semibold style-none" style="background-color: #934D56;">
        + Tambah Pasien Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-xs rounded-3 mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="widget-card p-4">
    <div class="table-responsive">
        <table id="tabel-pasien" class="table table-hover align-middle text-xs w-100">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>NIK</th>
                    <th>No. HP</th>
                    <th>Gender</th>
                    <th>Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasien as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary font-mono">{{ $p->no_rm }}</span></td>
                        <td class="fw-bold" style="color: #35445B;">{{ $p->user->name ?? '-' }}</td>
                        <td>{{ $p->nik ?? '-' }}</td>
                        <td>{{ $p->no_hp ?? '-' }}</td>
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.pasien.riwayat', $p->id) }}" class="btn btn-sm btn-info text-white py-1 px-2 text-xs">Riwayat</a>
                                <a href="{{ route('admin.pasien.edit', $p->id) }}" class="btn btn-sm btn-warning py-1 px-2 text-xs">Edit</a>
                                <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pasien ini?')">
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
        $('#tabel-pasien').DataTable({
            language: {
                search: "Cari Pasien:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data pasien terdaftar.",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: { next: "➔", previous: "⬅" }
            }
        });
    });
</script>
@endpush