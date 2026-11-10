<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Dokter') - HERA Klinik</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">

    <style>
        body { background-color: #F8FAF9; }
        .navbar-dokter { background: #35445B; border-bottom: 3px solid #934D56; }
        .card-custom { background: #ffffff; border-radius: 16px; border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.04); }
        .badge-status { font-size: 11px; padding: 6px 12px; border-radius: 20px; font-weight: 700; }
    </style>
</head>
<body>

    <!-- TOP NAVBAR DOKTER -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-dokter sticky-top py-2.5">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('dokter.dashboard') }}">
                <span class="text-warning">👨‍⚕️</span> HERA KLINIK <span class="badge bg-danger text-xs font-normal">MODUL DOKTER</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navDokter">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navDokter">
                <ul class="navbar-nav mx-auto text-xs font-semibold gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('dokter.dashboard') }}">📋 Antrean Pemeriksaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('dokter.jadwal.index') }}">📅 Jadwal Praktik Saya</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block text-white">
                        <div class="fw-bold text-xs">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-white-50">Dokter Penanggung Jawab</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light rounded-3 text-xs fw-bold px-3">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm text-xs rounded-3 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm text-xs rounded-3 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')
</body>
</html>