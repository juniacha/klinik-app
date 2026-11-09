<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - HERA Klinik</title>

    <!-- Bootstrap 5 CSS & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Custom CSS Klinik HERA -->
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body>

<div class="app-wrapper">
    <!-- SIDEBAR KIRI (Sesuai Layout Acuan Admin HERA) -->
    <aside class="sidebar-donezo">
        <div class="brand-section">
            <div class="brand-icon">+</div>
            <span class="fw-bold fs-5" style="color: #35445B;">HERA</span>
        </div>

        <!-- MENU SIDEBAR ADMIN -->
        <div class="nav-label">MENU</div>
        <ul class="sidebar-menu">
            <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="{{ request()->is('*pendaftaran*') ? 'active' : '' }}">
                <a href="{{ route('admin.pendaftaran.index') }}">Antrean & Pendaftaran</a>
            </li>
            <li class="{{ request()->is('*obat*') ? 'active' : '' }}">
                <a href="{{ route('admin.obat.index') }}">Data Obat</a>
            </li>
            <li class="{{ request()->is('*dokter*') ? 'active' : '' }}">
                <a href="{{ route('admin.dokter.index') }}">Data Dokter</a>
            </li>
            <li class="{{ request()->is('*pasien*') ? 'active' : '' }}">
                <a href="{{ route('admin.pasien.index') }}">Data Pasien</a>
            </li>
        </ul>

        <div class="nav-label">GENERAL</div>
        <ul class="sidebar-menu">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 ps-3 fw-bold style-none">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- PAPAN KONTEN UTAMA -->
    <main class="main-dashboard">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

@stack('scripts')
</body>
</html>