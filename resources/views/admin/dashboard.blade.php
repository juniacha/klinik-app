<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - HERA Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body>

<div class="app-wrapper">
    <!-- SIDEBAR KIRI -->
    <aside class="sidebar-donezo">
        <div class="brand-section">
            <div class="brand-icon">+</div>
            <span class="fw-bold fs-5" style="color: #35445B;">HERA</span>
        </div>

        <div class="nav-label">MENU</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.pendaftaran.index') }}">Antrean & Pendaftaran</a></li>
            <li><a href="{{ route('admin.obat.index') }}">Data Obat</a></li>
            <li><a href="#">Data Dokter</a></li>
            <li><a href="#">Data Pasien</a></li>
        </ul>

        <div class="nav-label">GENERAL</div>
        <ul class="sidebar-menu">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 ps-3">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- MAIN DASHBOARD BOARD -->
    <main class="main-dashboard">
        <!-- Title & Action Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1" style="color: #35445B;">Dashboard Overview</h3>
                <p class="text-muted small mb-0">Kelola operasional, antrean, dan rekam medis pasien klinik HERA.</p>
            </div>
        </div>

        <!-- 4 Stat Cards Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card-donezo primary">
                    <div class="stat-title">Total Pasien</div>
                    <div class="stat-number">{{ $totalPasien }}</div>
                    <small class="stat-sub">↗️ Terdaftar di sistem</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-donezo">
                    <div class="stat-title">Dokter Aktif</div>
                    <div class="stat-number" style="color: #35445B;">{{ $totalDokter }}</div>
                    <small class="text-muted">↗️ Siap berpraktik</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-donezo">
                    <div class="stat-title">Antrean Hari Ini</div>
                    <div class="stat-number" style="color: #934D56;">{{ $antreanHariIni }}</div>
                    <small class="text-muted">↗️ Pasien rawat jalan</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-donezo">
                    <div class="stat-title">Stok Obat Kritis</div>
                    <div class="stat-number" style="color: #E53E3E;">{{ $obatHampirHabis }}</div>
                    <small class="text-muted">⚠️ Perlu diperbarui</small>
                </div>
            </div>
        </div>

        <!-- Widget Content Grid -->
        <div class="row g-3">
            <div class="col-md-7">
                <!-- Bar Chart Widget -->
                <div class="widget-card mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color: #35445B;">Statistik Kunjungan Pasien</h6>
                        <small class="text-muted fw-semibold">Minggu Ini</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-end pt-4 px-3" style="height: 140px;">
                        <div class="rounded-pill" style="width: 28px; height: 35%; background: #CBD5E0;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 80%; background: #35445B;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 50%; background: #CBD5E0;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 95%; background: #934D56;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 60%; background: #CBD5E0;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 75%; background: #35445B;"></div>
                        <div class="rounded-pill" style="width: 28px; height: 40%; background: #CBD5E0;"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted fw-bold small mt-3 px-3" style="font-size: 12px;">
                        <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                    </div>
                </div>

                <!-- Tabel Antrean Terkini -->
                <div class="widget-card">
                    <h6 class="fw-bold mb-3" style="color: #35445B;">Antrean Pasien Terbaru</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>No. Antrean</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($antreanTerbaru as $antrean)
                                    <tr>
                                        <td class="fw-bold" style="color: #934D56;">{{ $antrean->no_antrean }}</td>
                                        <td>{{ $antrean->pasien->user->name ?? 'Pasien' }}</td>
                                        <td>{{ $antrean->dokter->user->name ?? 'Dokter' }}</td>
                                        <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada antrean masuk hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <!-- Pengingat Dokter -->
                <div class="widget-card mb-3">
                    <small class="text-muted fw-bold d-block mb-1">PENGINGAT DOKTER</small>
                    <h6 class="fw-bold mb-1" style="color: #35445B;">Jadwal Praktik Poli Gigi</h6>
                    <p class="small text-muted mb-3" style="font-size: 12px;">Dr. Budi Santoso (14:00 - 17:00 WIB)</p>
                    <button class="btn btn-sm text-white w-100 rounded-pill fw-semibold" style="background: #35445B;">Mulai Praktik</button>
                </div>

                <!-- Waktu Operasional Box -->
                <div class="time-tracker-box">
                    <small class="text-white-50 d-block mb-1">WAKTU OPERASIONAL KLINIK</small>
                    <h2 class="fw-bold mb-3">08:00 - 21:00</h2>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light btn-sm rounded-circle px-3 fw-bold">▌▌</button>
                        <button class="btn btn-danger btn-sm rounded-circle px-3 fw-bold">■</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>