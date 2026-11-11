<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Pasien') - HERA Klinik</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">

    <style>
        body {
            background-color: #F8FAF9 !important;
        }

        .navbar-pasien {
            background: #ffffff;
            border-bottom: 1px solid #E2E8F0;
        }
    </style>
</head>

<body>

    <!-- TOP NAVBAR PASIEN -->
    <nav class="navbar navbar-expand-lg navbar-pasien sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-hera-dark"
                href="{{ route('pasien.dashboard') }}">
                <div class="brand-icon"
                    style="width: 36px; height: 36px; font-size: 18px; background: #35445B; color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    +</div>
                <span>HERA KLINIK</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPasien">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navPasien">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold text-xs gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active text-primary fw-bold' : 'text-hera-dark' }}"
                            href="{{ route('pasien.dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.booking.*') || request()->routeIs('pasien.pendaftaran.*') ? 'active text-primary fw-bold' : 'text-hera-dark' }}"
                            href="{{ route('pasien.booking.create') }}">Booking Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.rekam-medis.*') ? 'active text-primary fw-bold' : 'text-hera-dark' }}"
                            href="{{ route('pasien.rekam-medis.index') }}">Riwayat Medis & Resep</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.profil.*') ? 'active text-primary fw-bold' : 'text-hera-dark' }}"
                            href="{{ route('pasien.profil.edit') }}">Profil Saya</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('pasien.profil.edit') }}" class="text-end text-decoration-none d-none d-sm-block">
                        <div class="fw-bold text-xs text-hera-dark">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-muted">Pasien Terdaftar</div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 text-xs fw-bold px-3">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>