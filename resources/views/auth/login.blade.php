<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HERA Klinik</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/hera.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #F0F3F7;">

<div class="container" style="max-width: 420px;">
    <div class="card border-0 shadow-sm p-4 rounded-4" style="background: #ffffff;">
        
        <!-- Header Branding -->
        <div class="text-center mb-4">
            <div class="brand-icon mx-auto mb-2" style="width: 48px; height: 48px; font-size: 24px;">+</div>
            <h1 class="h4 font-bold text-hera-dark mb-1">HERA KLINIK</h1>
            <p class="text-hera-muted text-xs mb-0">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger text-xs rounded-3 mb-3">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label text-xs font-bold text-hera-dark">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                @error('email')
                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-xs font-bold text-hera-dark">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" required placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label text-xs text-secondary">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-hera-primary w-100 font-bold text-xs py-2.5 rounded-3 shadow-sm">
                Masuk ke Akun
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>