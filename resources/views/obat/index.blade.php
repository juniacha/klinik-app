@extends('layouts.app')
@section('title', 'Data Master Obat')

@section('conten')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Master Obat</h2>
        <a href="{{ route('obat.create') }}" class="btn text-white fw-semibold" style="background-color: #5c3347;">+ Tambah Obat Baru</a>
    </div>

    @if(session('succes'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif 

    <div class="table-responsive mt-3">
        <table id="table-obat" class="table-striped table-bordered" style="width:100%">
            <thead>
                <tr style="background-color: #5c3347; color: white;">
                    <th>No</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $obat as $o )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold" style="color: #611e13;">{{ $o->kode_obat }}</td>
                        <td>{{ $o -> nama_obat }}</td>
                        <td>
                            @if ($o->stok < 10)
                                <span class="badge bg-danger">{{ $o->stok }} (Hampir Habis) </span>
                            @else
                                <span class="badge bg-success">{{ $o->stok }}</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($o->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="action-button">
                                <a href="{{ route('obat.edit', $o->id) }}" class="btn btn-warning btn-sm fw-semibold">Edit</a>
                                <form action="{{ route('obat.destroy', $o->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm fw-semibold">Hapus</button>
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
    $(dokumen).ready(function () {
        $('#table-obat').DataTable();
    });
</script>
@endpush
@endsection