<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - HERA Klinik</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Custom CSS Klinik HERA -->
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body>

    <!-- Floating Pill Navbar (Modern Clinic Style) -->
    <div class="navbar-hera-wrapper">
        <nav class="navbar-hera">
            <!-- Brand & Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-hera">
                <div class="logo-icon">+</div>
                <span class="brand-title">HERA CLINIC</span>
            </a>

            <!-- Menu Navigasi Utama -->
            <ul class="navbar-menu-hera">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('obat.index') }}" class="{{ request()->is('obat*') ? 'active' : '' }}">Data Obat</a></li>
                <li><a href="{{ route('pendaftaran.index') }}" class="{{ request()->is('pendaftaran*') ? 'active' : '' }}">Antrean & Pendaftaran</a></li>
                <li><a href="#">Rekam Medis</a></li>
            </ul>

            <!-- Button Logout -->
            <div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm text-white fw-bold px-3 py-2" style="background-color: #934D56; border-radius: 20px;">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- Container Konten Utama -->
    <main class="hera-main-container">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    @stack('scripts')
</body>
</html>