@extends('layouts.pasien')

@section('title', 'Profil Saya')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="h4 font-bold text-hera-dark mb-1">Profil Pasien</h1>
            <p class="text-xs text-muted mb-4">Lihat Nomor Rekam Medis (No. RM), perbarui informasi pribadi, dan ganti kata
                sandi akun Anda.</p>

            @if(session('success'))
                <div class="alert alert-success text-xs rounded-3 mb-4">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                <!-- EDIT DATA PRIBADI & NO RM -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Data Pribadi Pasien</h2>

                        <form action="{{ route('pasien.profil.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-xs font-bold text-muted">Nomor Rekam Medis (No. RM)</label>
                                <input type="text" class="form-control form-control-sm bg-light font-mono fw-bold"
                                    value="{{ $pasien->no_rm ?? 'RM-000001' }}" readonly style="color: #934D56;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-bold text-hera-dark">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-bold text-muted">Email (Username Login)</label>
                                <input type="email" class="form-control form-control-sm bg-light" value="{{ $user->email }}"
                                    readonly>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label text-xs font-bold text-hera-dark">NIK (16 Digit)</label>
                                    <input type="text" name="nik" class="form-control form-control-sm"
                                        value="{{ old('nik', $pasien->nik ?? '') }}" placeholder="NIK Pasien">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-xs font-bold text-hera-dark">No. Telepon / WA</label>
                                    <input type="text" name="no_hp" class="form-control form-control-sm"
                                        value="{{ old('no_hp', $pasien->no_hp ?? '') }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-xs font-bold text-hera-dark">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" class="form-control form-control-sm"
                                    placeholder="Tuliskan alamat lengkap Anda...">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                            </div>

                            <button type="submit" class="btn text-white font-bold text-xs py-2 px-4 rounded-3 shadow-sm"
                                style="background-color: #934D56;">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- UBAH KATA SANDI -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Ubah Kata Sandi</h2>

                        <form action="{{ route('pasien.profil.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-xs font-bold text-hera-dark">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password"
                                    class="form-control form-control-sm @error('current_password') is-invalid @enderror"
                                    required>
                                @error('current_password')
                                <div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-bold text-hera-dark">Kata Sandi Baru</label>
                                <input type="password" name="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter" required>
                                @error('password')
                                <div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-xs font-bold text-hera-dark">Konfirmasi Kata Sandi
                                    Baru</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-outline-secondary font-bold text-xs py-2 w-100 rounded-3">
                                Perbarui Kata Sandi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection