@extends('layouts.app')

@section('title', 'Tambah Pasien Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="widget-card p-4">
            <h4 class="fw-bold mb-3" style="color: #35445B;">+ Tambah Data Pasien Baru</h4>

            <form action="{{ route('admin.pasien.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-xs fw-bold">Nama Lengkap Pasien</label>
                    <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                    @error('nama')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">Email Login Pasien</label>
                        <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">Password Login</label>
                        <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback text-xs">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">NIK (16 Digit)</label>
                        <input type="text" name="nik" class="form-control form-control-sm" value="{{ old('nik') }}" maxlength="16">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control form-control-sm" value="{{ old('no_hp') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control form-control-sm" value="{{ old('tgl_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select form-select-sm">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-xs fw-bold">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" class="form-control form-control-sm">{{ old('alamat') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.pasien.index') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm text-white px-4" style="background-color: #934D56;">Simpan Data Pasien</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection