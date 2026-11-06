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
    
    <!-- Custom CSS Murni Klinik HERA -->
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body>

    <!-- Header Navbar HERA -->
    <header class="navbar-hera">
        HERA - Healthcare Electronic Registration & Administration
    </header>

    <!-- Main Container -->
    <div class="container-hera">
        <!-- Sidebar Menu Navigasi -->
        <aside class="sidebar-hera">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('obat.index') }}" class="{{ request()->is('obat*') ? 'active' : '' }}">Data Obat</a>
            <a href="#">Antrean & Pendaftaran</a>
            <a href="#">Rekam Medis</a>
            
            <hr class="my-3 text-secondary">
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-danger w-100 text-start p-0 ps-3 fw-semibold style-none" style="text-decoration: none;">
                    Logout
                </button>
            </form>
        </aside>

        <!-- Content Area -->
        <main class="content-hera">
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