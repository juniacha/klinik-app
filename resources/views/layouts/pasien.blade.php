<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Pasien') - HERA Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body style="background-color: #F8FAF9;">

    <!-- TOP NAVBAR PASIEN -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand font-bold text-hera-dark" href="{{ route('pasien.dashboard') }}">
                <span class="text-hera-maroon">+</span> HERA KLINIK
            </a>
            <div class="collapse navbar-collapse" id="navPasien">
                <ul class="navbar-nav mx-auto font-semibold text-xs gap-3">
                    <li class="nav-item"><a class="nav-link text-dark" href="{{ route('pasien.dashboard') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="{{ route('pasien.booking.create') }}">Booking Dokter</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="{{ route('pasien.rekam-medis.index') }}">Riwayat Medis & Resep</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-xs font-bold text-hera-dark">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm text-xs rounded-3">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <main class="container py-4 min-vh-100">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm text-xs rounded-3 mb-4">
                ✨ {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-white border-top py-3 text-center text-xs text-muted">
        &copy; {{ date('Y') }} HERA Klinik Management System.
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>