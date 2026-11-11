@extends('layouts.app')

@section('title', 'Kelola Antrean & Pendaftaran')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 font-bold text-hera-dark mb-1">Antrean & Pendaftaran Pasien</h1>
            <p class="text-xs text-muted mb-0">Kelola dan perbarui status antrean pemeriksaan pasien klinik.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-xs rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="widget-card p-4">
        <div class="table-responsive">
            <table id="tabel-antrean-admin" class="table table-hover align-middle text-xs w-100">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No. Antrean</th>
                        <th>Nama Pasien</th>
                        <th>Dokter Tujuan</th>
                        <th>Tgl Periksa</th>
                        <th>Keluhan</th>
                        <th>Status Antrean</th>
                        <th>Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-secondary font-mono px-2 py-1">{{ $item->no_antrean }}</span>
                            </td>
                            <td class="fw-bold text-hera-dark">
                                {{ $item->pasien->user->name ?? $item->pasien->nama_pasien ?? '-' }}
                            </td>
                            <td>{{ $item->dokter->nama_dokter ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d/m/Y') }}</td>
                            <td><span class="text-muted">{{ Str::limit($item->keluhan, 30) }}</span></td>
                            <td>
                                @if($item->status === 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status === 'dipanggil')
                                    <span class="badge bg-info text-dark">Dipanggil</span>
                                @elseif($item->status === 'sedang diperiksa')
                                    <span class="badge bg-primary">Sedang Diperiksa</span>
                                @elseif($item->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <form action="{{ route('admin.pendaftaran.updateStatus', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm text-xs py-1"
                                            onchange="this.form.submit()">
                                            <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>Menunggu
                                            </option>
                                            <option value="dipanggil" {{ $item->status == 'dipanggil' ? 'selected' : '' }}>
                                                Dipanggil</option>
                                            <option value="sedang diperiksa" {{ $item->status == 'sedang diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai
                                            </option>
                                            <option value="batal" {{ $item->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>

                                    <form action="{{ route('admin.pendaftaran.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus data antrean ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger py-1 px-2 text-xs">Hapus</button>
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
            $('#tabel-antrean-admin').DataTable({
                language: {
                    search: "Cari Antrean:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Belum ada pendaftaran antrean berobat.",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 data",
                    paginate: { next: "➔", previous: "⬅" }
                }
            });
        });
    </script>
@endpush