@extends('layouts.app')

@section('title', 'Data Master Obat')

@section('content')
<!-- Header & Action Button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #35445B;">Data Master Obat</h3>
        <p class="text-muted small mb-0">Kelola inventaris stok obat, kategori, dan harga satuan farmasi klinik HERA.</p>
    </div>
    <a href="{{ route('admin.obat.create') }}" class="btn text-white rounded-pill px-4 fw-semibold style-none" style="background-color: #934D56;">
        + Tambah Obat Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Tabel Data Obat -->
<div class="widget-card border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table id="table-obat" class="table table-hover align-middle mb-0" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Obat</th>
                    <th width="35%">Nama Obat</th>
                    <th width="15%">Stok</th>
                    <th width="15%">Harga Satuan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($obat as $o)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold" style="color: #35445B;">{{ $o->kode_obat }}</td>
                        <td>{{ $o->nama_obat }}</td>
                        <td>
                            @if ($o->stok < 10)
                                <span class="badge badge-emergency">Kritis ({{ $o->stok }})</span>
                            @else
                                <span class="badge badge-aktif">{{ $o->stok }} Pcs</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('obat.edit', $o->id) }}" class="btn btn-warning btn-sm text-dark fw-bold px-2 py-1" style="font-size: 11px;">Edit</a>
                                <form action="{{ route('obat.destroy', $o->id) }}" method="POST" onsubmit="return confirm('Hapus obat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm text-white fw-bold px-2 py-1" style="font-size: 11px;">Hapus</button>
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
        $('#table-obat').DataTable({
            "language": {
                "search": "Cari Obat:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data"
            }
        });
    });
</script>
@endpush