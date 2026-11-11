@extends('layouts.app')

@section('title', 'Dashboard Overview')

    @section('content')
            <!-- Title & Action Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #35445B;">Dashboard Overview</h3>
                    <p class="text-muted small mb-0">Kelola operasional, antrean, dan rekam medis pasien klinik HERA.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pendaftaran.create') }}" class="btn text-white fw-semibold px-3 py-2 text-xs"
                        style="background-color: #35445B; border-radius: 10px;">
                        + Pendaftaran Baru
                    </a>
                </div>
            </div>

                        <!-- 4 Stat Cards Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="stat-card-donezo primary">
                                    <div class="stat-title">Total Pasien</div>
                                    <div class="stat-number">{{ $totalPasien }}</div>
                                    <small class="stat-sub">Terdaftar di sistem</small>
                                </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-donezo">
                            <div class="stat-title">Dokter Aktif</div>
                            <div class="stat-number" style="color: #35445B;">{{ $totalDokter }}</div>
                            <small class="text-muted">Siap berpraktik</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-donezo">
                            <div class="stat-title">Antrean Menunggu</div>
                            <div class="stat-number" style="color: #934D56;">{{ $antreanMenunggu }}</div>
                            <small class="text-muted">Hari ini ({{ $kunjunganHariIni }} total kunjungan)</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-donezo">
                            <div class="stat-title">Total Data Obat</div>
                            <div class="stat-number" style="color: #35445B;">{{ $totalObat }}</div>
                            <small class="text-muted">Inventaris farmasi</small>
                        </div>
                    </div>
            </div>

                    <!-- Widget Content Grid -->
                    <div class="row g-4">
                        <!-- Kolom Kiri: Bar Chart & Tabel Antrean Terbaru -->
                        <div class="col-lg-7">
                            <!-- Bar Chart Widget -->
                            <div class="widget-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0" style="color: #35445B;">Statistik Kunjungan Pasien</h6>
                                    <span class="badge bg-light text-muted border text-xs">Minggu Ini</span>
                                </div>
                                        <div class="d-flex justify-content-between align-items-end pt-3 px-3"
                                            style="height: 130px;">
                                            <div class="d-flex flex-column align-items-center gap-2">
                                                <div class="rounded-pill"
                                                    style="width: 26px; height: 45px; background: #CBD5E0;"></div>
                                                <span class="text-muted" style="font-size: 11px;">Min</span>
                                            </div>
                                                <div class="d-flex flex-column align-items-center gap-2">
                                                    <div class="rounded-pill"
                                                        style="width: 26px; height: 95px; background: #35445B;"></div>
                                                    <span class="text-muted" style="font-size: 11px;">Sen</span>
                                                </div>
                                                    <div class="d-flex flex-column align-items-center gap-2">
                                                        <div class="rounded-pill"
                                                            style="width: 26px; height: 65px; background: #CBD5E0;"></div>
                                                        <span class="text-muted" style="font-size: 11px;">Sel</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center gap-2">
                                                        <div class="rounded-pill"
                                                            style="width: 26px; height: 110px; background: #934D56;"></div>
                                                        <span class="text-muted" style="font-size: 11px;">Rab</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center gap-2">
                                                        <div class="rounded-pill"
                                                            style="width: 26px; height: 75px; background: #CBD5E0;"></div>
                                                        <span class="text-muted" style="font-size: 11px;">Kam</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center gap-2">
                                                        <div class="rounded-pill"
                                                            style="width: 26px; height: 85px; background: #35445B;"></div>
                                                        <span class="text-muted" style="font-size: 11px;">Jum</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center gap-2">
                                                        <div class="rounded-pill"
                                                            style="width: 26px; height: 50px; background: #CBD5E0;"></div>
                                                        <span class="text-muted" style="font-size: 11px;">Sab</span>
                                                    </div>
                                                </div>
                                            </div>

                                                            <!-- Tabel Antrean Terkini -->
                                                            <div class="widget-card">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                    <h6 class="fw-bold mb-0" style="color: #35445B;">Antrean
                                                                        Pasien Terbaru Hari Ini</h6>
                                                                    <a href="{{ route('admin.pendaftaran.index') }}"
                                                                        class="text-xs text-decoration-none fw-semibold"
                                                                        style="color: #35445B;">
                                                                        Lihat Semua →
                                                                    </a>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover align-middle mb-0"
                                                                        style="font-size: 13px;">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th width="18%">No. Antrean</th>
                                                                                <th>Pasien</th>
                                                                                <th>Dokter Tujuan</th>
                                                                                <th width="18%">Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($antreanTerbaru as $antrean)
                                                                                <tr>
                                                                                    <td class="fw-bold font-mono"
                                                                                        style="color: #934D56;">
                                                                                        {{ $antrean->no_antrean }}</td>
                                                                                    <td>
                                                                                        <span
                                                                                            class="fw-semibold text-hera-dark">{{ $antrean->pasien->user->name ?? $antrean->pasien->nama_pasien ?? 'Pasien' }}</span>
                                                                                    </td>
                                                                                    <td>{{ $antrean->dokter->nama_dokter ?? $antrean->dokter->user->name ?? 'Dokter' }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @if ($antrean->status == 'menunggu')
                                                                                            <span
                                                                                                class="badge bg-warning text-dark">Menunggu</span>
                                                                                        @elseif ($antrean->status == 'diperiksa')
                                                                                            <span
                                                                                                class="badge bg-info text-dark">Diperiksa</span>
                                                                                        @elseif ($antrean->status == 'pembayaran')
                                                                                            <span class="badge bg-primary">Kasir</span>
                                                                                        @elseif ($antrean->status == 'selesai')
                                                                                            <span
                                                                                                class="badge bg-success">Selesai</span>
                                                                                        @else
                                                                                            <span
                                                                                                class="badge bg-secondary">{{ ucfirst($antrean->status) }}</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="4"
                                                                                        class="text-center text-muted py-4">Belum
                                                                                        ada antrean masuk hari ini.</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Kolom Kanan: Waktu Operasional, Status Antrean & Akses Cepat -->
                                                        <div class="col-lg-5">
                                                            <!-- Waktu Operasional Box -->
                                                            <div class="time-tracker-box mb-4">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start mb-2">
                                                                    <small class="text-white-50 fw-bold">WAKTU OPERASIONAL
                                                                        KLINIK</small>
                                                                    <span
                                                                        class="badge bg-white text-dark text-xs px-2 py-1 rounded-pill">Aktif</span>
                                                                </div>
                                                                <h2 class="fw-bold mb-1 text-white">08:00 - 21:00 <span
                                                                        class="fs-6 fw-normal text-white-50">WIB</span></h2>
                                                                <p class="text-white-50 small mb-0">Senin - Sabtu | Pelayanan
                                                                    Poli & Farmasi</p>
                                                            </div>

                                                            <!-- Status Antrean Pasien Hari Ini -->
                                                            <div class="widget-card mb-4">
                                                                <h6 class="fw-bold mb-3" style="color: #35445B;">Status Antrean
                                                                    Hari Ini</h6>
                                                                <div class="d-flex flex-column gap-2">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center p-2 rounded bg-light">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <span class="badge bg-warning text-dark">●</span>
                                                                            <span class="text-xs fw-semibold">Menunggu
                                                                                Panggilan</span>
                                                                        </div>
                                                                            <span class="fw-bold text-xs">{{ $antreanMenunggu }}
                                                                                Pasien</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center p-2 rounded bg-light">
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <span class="badge bg-info text-dark">●</span>
                                                                                <span class="text-xs fw-semibold">Sedang
                                                                                    Diperiksa</span>
                                                                            </div>
                                                                            <span
                                                                                class="fw-bold text-xs">{{ $antreanDiperiksa }}
                                                                                Pasien</span>
                                                                        </div>
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center p-2 rounded bg-light">
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-2">
                                                                                        <span class="badge bg-success">●</span>
                                                                                        <span
                                                                                            class="text-xs fw-semibold">Selesai
                                                                                            Berobat</span>
                                                                                    </div>
                                                                                    <span
                                                                                        class="fw-bold text-xs">{{ $antreanSelesai }}
                                                                                        Pasien</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                                <!-- Menu Akses Cepat Admin -->
                                                                                <div class="widget-card">
                                                                                    <h6 class="fw-bold mb-3"
                                                                                        style="color: #35445B;">Akses Cepat
                                                                                        Pengelolaan</h6>
                                                                                    <div class="row g-2">
                                                                                        <div class="col-6">
                                                                                            <a href="{{ route('admin.pendaftaran.create') }}"
                                                                                                class="btn btn-outline-secondary btn-sm w-100 py-2 text-xs d-flex align-items-center justify-content-center gap-1 text-start"
                                                                                                style="border-radius: 10px;">
                                                                                                <span>📋</span> Antrean Baru
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <a href="{{ route('admin.pasien.create') }}"
                                                                                                class="btn btn-outline-secondary btn-sm w-100 py-2 text-xs d-flex align-items-center justify-content-center gap-1 text-start"
                                                                                                style="border-radius: 10px;">
                                                                                                <span>👤</span> Pasien Baru
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <a href="{{ route('admin.obat.create') }}"
                                                                                                class="btn btn-outline-secondary btn-sm w-100 py-2 text-xs d-flex align-items-center justify-content-center gap-1 text-start"
                                                                                                style="border-radius: 10px;">
                                                                                                <span>💊</span> Tambah Obat
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <a href="{{ route('admin.dokter.create') }}"
                                                                                                class="btn btn-outline-secondary btn-sm w-100 py-2 text-xs d-flex align-items-center justify-content-center gap-1 text-start"
                                                                                                style="border-radius: 10px;">
                                                                                                <span>👨‍⚕️</span> Tambah Dokter
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
    @endsection