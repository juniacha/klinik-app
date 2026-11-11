@extends('layouts.pasien')

@section('title', 'Profil Saya')

@section('content')
    <div class="container py-3" style="max-width: 900px;">
        <h1 class="h4 font-bold text-hera-dark mb-1">Profil Pasien</h1>
        <p class="text-xs text-muted mb-4">Kelola informasi pribadi dan keamanan kata sandi akun Anda.</p>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm text-xs rounded-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- FORM EDIT INFORMASI PRIBADI -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Informasi Pribadi</h2>

                    <form action="{{ route('pasien.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-xs font-bold text-muted">Nomor Rekam Medis (RM)</label>
                            <input type="text" class="form-control form-control-sm bg-light font-bold"
                                value="{{ $pasien->no_rm ?? 'RM-000001' }}" readonly style="color: #934D56;">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label text-xs font-bold text-hera-dark">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-xs font-bold text-muted">Alamat Email (Akun
                                Login)</label>
                            <input type="email" id="email" class="form-control form-control-sm bg-light"
                                value="{{ $user->email }}" readonly>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="nik" class="form-label text-xs font-bold text-hera-dark">NIK</label>
                                <input type="text" name="nik" id="nik" class="form-control form-control-sm"
                                    value="{{ old('nik', $pasien->nik ?? '') }}" placeholder="16 digit NIK">
                            </div>
                            <div class="col-6">
                                <label for="no_hp" class="form-label text-xs font-bold text-hera-dark">No. Telepon /
                                    WA</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control form-control-sm"
                                    value="{{ old('no_hp', $pasien->no_hp ?? '') }}" placeholder="0812xxxx">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label text-xs font-bold text-hera-dark">Alamat Tempat
                                Tinggal</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control form-control-sm"
                                placeholder="Tuliskan alamat lengkap Anda...">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                        </div>

                        <button type="submit" class="btn text-white font-bold text-xs py-2 px-4 rounded-3 shadow-sm"
                            style="background-color: #934D56;">
                            Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- FORM UBAH KATA SANDI -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Ubah Kata Sandi</h2>

                    <form action="{{ route('pasien.profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label text-xs font-bold text-hera-dark">Kata Sandi
                                Saat Ini</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control form-control-sm @error('current_password') is-invalid @enderror"
                                required>
                            @error('current_password')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-xs font-bold text-hera-dark">Kata Sandi
                                Baru</label>
                            <input type="password" name="password" id="password"
                                class="form-control form-control-sm @error('password') is-invalid @enderror" required
                                placeholder="Min. 8 karakter">
                            @error('password')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="form-label text-xs font-bold text-hera-dark">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control form-control-sm" required>
                        </div>

                        <button type="submit" class="btn btn-outline-secondary font-bold text-xs py-2 w-100 rounded-3">
                            Perbarui Kata Sandi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection