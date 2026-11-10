@extends('layouts.app')

@section('title', 'Data Master Obat')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #35445B;">Data Master Obat</h3>
        <p class="text-muted small mb-0">Kelola stok dan daftar harga obat Klinik HERA.</p>
    </div>
    <a href="{{ route('admin.obat.create') }}" class="btn text-white rounded-pill px-4 fw-semibold style-none" style="background-color: #934D56;">
        + Tambah Obat Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success text-xs rounded-3 mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="widget-card p-4 bg-white rounded-4 shadow-sm">
    <div class="table-responsive">
        <table id="tabel-obat" class="table table-hover align-middle text-xs w-100">
            <thead class="table-light">
                <tr>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th>Harga Satuan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($obat as $o)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary font-mono">{{ $o->kode_obat ?? '-' }}</span></td>
                        <td class="fw-bold" style="color: #35445B;">{{ $o->nama_obat }}</td>
                        <td>{{ $o->jenis ?? 'Umum' }}</td>
                        <td>
                            @if($o->stok <= 10)
                                <span class="badge bg-danger">{{ $o->stok }} (Hampir Habis)</span>
                            @else
                                <span class="badge bg-success">{{ $o->stok }}</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.obat.edit', $o->id) }}" class="btn btn-sm btn-warning py-1 px-2 text-xs">Edit</a>
                                <form action="{{ route('admin.obat.destroy', $o->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data obat ini?')">
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
        $('#tabel-obat').DataTable({
            language: {
                search: "Cari Obat:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data obat terdaftar.",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: { next: "➔", previous: "⬅" }
            }
        });
    });
</script>
@endpush