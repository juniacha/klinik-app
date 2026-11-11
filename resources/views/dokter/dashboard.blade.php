@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('content')
    <style>
        /* Styling Sentuhan Sage Green & Panel Profil Kanan */
        .bg-sage {
            background-color: #889B83 !important;
        }

        .text-sage {
            color: #5C6F57 !important;
        }

        .border-sage {
            border-color: #A3A57E !important;
        }

        .card-profile-dokter {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #889B83 0%, #A3A57E 100%);
            color: white;
            font-size: 36px;
            font-weight: 800;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 6px 16px rgba(136, 155, 131, 0.3);
        }
    </style>

    <div class="row g-4">
        <div class="col-lg-8 col-xl-9">

            <!-- 1. WELCOME BANNER DOKTER (Sage Green Gradient) -->
            <div class="card-custom p-4 p-md-5 text-white mb-4 position-relative overflow-hidden"
                style="background: linear-gradient(135deg, #5C6F57 0%, #889B83 100%); border-radius: 20px;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-white text-dark font-bold text-xs px-3 py-1.5 rounded-pill mb-2">
                            Modul Pelayanan Medis
                        </span>
                        <h1 class="h3 font-bold text-white mb-1">
                            Selamat Datang, {{ $dokter->nama_dokter ?? Auth::user()->name }} 
                        </h1>
                        <p class="text-white-50 text-xs mb-0">
                            Kelola antrean pasien hari ini, lakukan pemeriksaan medis, isi diagnosis, serta berikan resep
                            obat terstruktur.
                        </p>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                    </div>
                </div>
            </div>

            <!-- 2. RINGKASAN STATISTIK PASIEN HARI INI -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-sm-3">
                    <div class="card-custom p-3 text-center">
                        <div class="text-[10px] text-uppercase font-bold text-muted mb-1">Total Antrean</div>
                        <div class="h3 font-extrabold text-hera-dark mb-0">{{ $antreanHariIni->count() }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="card-custom p-3 text-center">
                        <div class="text-[10px] text-uppercase font-bold text-muted mb-1">Menunggu</div>
                        <div class="h3 font-extrabold text-warning mb-0">
                            {{ $antreanHariIni->where('status', 'menunggu')->count() }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="card-custom p-3 text-center">
                        <div class="text-[10px] text-uppercase font-bold text-muted mb-1">Diperiksa</div>
                        <div class="h3 font-extrabold text-primary mb-0">
                            {{ $antreanHariIni->where('status', 'sedang diperiksa')->count() }}
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="card-custom p-3 text-center">
                        <div class="text-[10px] text-uppercase font-bold text-muted mb-1">Selesai</div>
                        <div class="h3 font-extrabold text-success mb-0">
                            {{ $antreanHariIni->where('status', 'selesai')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. TABEL DAFTAR ANTREAN PASIEN HARI INI -->
            <div class="card-custom p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3 class="h6 font-bold text-hera-dark mb-0">Daftar Pasien Hari Ini</h3>
                        <span class="text-xs text-muted">Tanggal: {{ date('d M Y') }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tabel-antrean-dokter" class="table table-hover align-middle text-xs w-100">
                        <thead class="table-light">
                            <tr>
                                <th>No. Antrean</th>
                                <th>Nama Pasien</th>
                                <th>No. RM</th>
                                <th>Keluhan Awal</th>
                                <th>Status Antrean</th>
                                <th>Aksi Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($antreanHariIni as $a)
                                <tr>
                                    <td><span class="badge bg-secondary font-mono px-2 py-1">{{ $a->no_antrean }}</span></td>
                                    <td class="fw-bold text-hera-dark">
                                        {{ $a->pasien->user->name ?? $a->pasien->nama_pasien ?? '-' }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $a->pasien->no_rm ?? 'RM-000001' }}</span>
                                    </td>
                                    <td><span class="text-muted">{{ Str::limit($a->keluhan ?? 'Pemeriksaan rutin', 30) }}</span>
                                    </td>
                                    <td>
                                        @if($a->status === 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($a->status === 'sedang diperiksa')
                                            <span class="badge bg-primary">Sedang Diperiksa</span>
                                        @elseif($a->status === 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($a->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('dokter.pemeriksaan.create', $a->id) }}"
                                                class="btn btn-sm btn-primary font-bold px-3 text-xs">
                                                Periksa Pasien
                                            </a>
                                            <!-- PERBAIKAN: dokter.pasien.rekam-medis -->
                                            <a href="{{ route('dokter.pasien.rekam-medis', $a->pasien_id) }}"
                                                class="btn btn-sm btn-outline-info text-xs">
                                                Riwayat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-4 col-xl-3">

            <!-- CARD 1: MY PROFILE DOKTER -->
            <div class="card-profile-dokter p-4 mb-4 text-center">
                <div class="text-xs font-bold text-muted text-uppercase tracking-wider mb-3">My Profile</div>

                <div class="avatar-circle">
                    👨‍⚕️
                </div>

                <h2 class="h6 font-bold text-hera-dark mb-1">{{ $dokter->nama_dokter ?? Auth::user()->name }}</h2>
                <p class="text-xs text-muted mb-2">{{ $dokter->spesialis ?? 'Poli Umum' }}</p>
                <div class="badge bg-light text-dark border font-mono text-[11px] mb-3">
                    STR: {{ $dokter->no_str ?? '1234567890' }}
                </div>

                <hr class="my-3 border-slate-200">

                <!-- Detail Ketersediaan & Jadwal -->
                <div class="text-start space-y-2 text-xs">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Status Praktik:</span>
                        @if(($dokter->status_praktik ?? 'Tersedia') === 'Tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-danger">Berhalangan</span>
                        @endif
                    </div>

                    <div class="mb-2">
                        <span class="text-muted d-block mb-1">Jadwal Praktik:</span>
                        <span class="fw-bold text-hera-dark d-block bg-light p-2 rounded-3 border">
                            {{ $dokter->jadwal_praktik ?? 'Senin - Jumat (08.00 - 16.00 WIB)' }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('dokter.jadwal.index') }}"
                    class="btn btn-outline-secondary btn-sm w-100 text-xs mt-3 font-semibold">
                    Pengaturan Jadwal
                </a>
            </div>

            <!-- CARD 2: PASIEN TERAKHIR / RIWAYAT KUNJUNGAN SELESAI -->
            <div class="card-profile-dokter p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-xs font-bold text-muted text-uppercase tracking-wider">Pasien Terakhir</span>
                    <span class="badge bg-success text-white text-[10px]">Selesai</span>
                </div>

                <div class="space-y-3">
                    @forelse($riwayatKunjungan ?? [] as $rk)
                        <div
                            class="p-2.5 bg-light rounded-3 border d-flex justify-content-between align-items-center mb-2 text-xs">
                            <div>
                                <div class="fw-bold text-hera-dark">
                                    {{ $rk->pasien->user->name ?? $rk->pasien->nama_pasien ?? 'Pasien' }}</div>
                                <div class="text-[10px] text-muted">
                                    {{ \Carbon\Carbon::parse($rk->updated_at)->format('H:i WIB') }}</div>
                            </div>
                            <!-- PERBAIKAN: dokter.pasien.rekam-medis -->
                            <a href="{{ route('dokter.pasien.rekam-medis', $rk->pasien_id) }}"
                                class="btn btn-xs btn-outline-primary py-0.5 px-2 text-[10px]">
                                Detail
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-muted text-xs py-3">Belum ada pasien selesai hari ini.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tabel-antrean-dokter').DataTable({
                language: {
                    search: "Cari Pasien:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    zeroRecords: "Belum ada antrean pasien untuk hari ini.",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data antrean",
                    paginate: { next: "➔", previous: "⬅" }
                }
            });
        });
    </script>
@endpush