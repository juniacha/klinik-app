@extends('layouts.dokter')

@section('title', 'Form Pemeriksaan Medis')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 font-bold text-hera-dark mb-1">Form Pemeriksaan Medis Pasien</h1>
            <p class="text-xs text-muted mb-0">No. Antrean: <strong>{{ $pendaftaran->no_antrean }}</strong> | Pasien:
                <strong>{{ $pendaftaran->pasien->user->name ?? $pendaftaran->pasien->nama_pasien ?? '-' }}</strong></p>
        </div>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-3 text-xs">← Kembali ke
            Antrean</a>
    </div>

    <div class="row g-4">
        <!-- FORM INPUT DOKTER -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <form action="{{ route('dokter.pemeriksaan.store', $pendaftaran->id) }}" method="POST">
                    @csrf

                    <!-- Informasi Ringkas Pasien -->
                    <div class="p-3 bg-light rounded-3 mb-4 border text-xs">
                        <div class="row g-2">
                            <div class="col-md-4"><strong>No. Rekam Medis:</strong>
                                {{ $pendaftaran->pasien->no_rm ?? 'RM-000001' }}</div>
                            <div class="col-md-4"><strong>NIK:</strong> {{ $pendaftaran->pasien->nik ?? '-' }}</div>
                            <div class="col-md-4"><strong>Tgl Periksa:</strong>
                                {{ \Carbon\Carbon::parse($pendaftaran->tgl_periksa)->format('d M Y') }}</div>
                        </div>
                    </div>

                    <!-- Keluhan Pasien -->
                    <div class="mb-3">
                        <label for="keluhan" class="form-label text-xs font-bold text-hera-dark">Keluhan Pasien</label>
                        <textarea name="keluhan" id="keluhan" rows="2"
                            class="form-control form-control-sm @error('keluhan') is-invalid @enderror"
                            required>{{ old('keluhan', $pendaftaran->keluhan) }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hasil Diagnosa -->
                    <div class="mb-3">
                        <label for="diagnosa" class="form-label text-xs font-bold text-hera-dark">Hasil Diagnosa
                            Dokter</label>
                        <input type="text" name="diagnosa" id="diagnosa"
                            class="form-control form-control-sm @error('diagnosa') is-invalid @enderror"
                            placeholder="Contoh: Febris / ISPA" value="{{ old('diagnosa') }}" required>
                        @error('diagnosa')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tindakan Medis -->
                    <div class="mb-4">
                        <label for="tindakan" class="form-label text-xs font-bold text-hera-dark">Tindakan Medis /
                            Perawatan</label>
                        <textarea name="tindakan" id="tindakan" rows="2"
                            class="form-control form-control-sm @error('tindakan') is-invalid @enderror"
                            placeholder="Contoh: Pemberian obat oral, istirahat cukup, kompres hangat"
                            required>{{ old('tindakan') }}</textarea>
                        @error('tindakan')
                            <div class="invalid-feedback text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Modul Resep Obat & Dosis -->
                    <div class="border-top pt-3 mb-4">
                        <h2 class="h6 font-bold text-hera-dark mb-3">Resep Obat, Dosis & Aturan Penggunaan</h2>

                        <div id="container-resep">
                            <div class="row g-2 mb-2 item-resep">
                                <div class="col-md-5">
                                    <select name="resep_obat[0][id]" class="form-select form-select-sm text-xs">
                                        <option value="">-- Pilih Obat --</option>
                                        @if(isset($obats))
                                            @foreach($obats as $o)
                                                <option value="{{ $o->id }}">{{ $o->nama_obat }} (Stok: {{ $o->stok }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="dosis[0]" class="form-control form-control-sm text-xs"
                                        placeholder="Dosis (3x1 tablet)">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="aturan_pakai[0]" class="form-control form-control-sm text-xs"
                                        placeholder="Aturan (Sesudah makan)">
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btn-tambah-obat" class="btn btn-sm btn-outline-secondary text-xs mt-2">+
                            Tambah Obat Lain</button>
                    </div>

                    <!-- Catatan Dokter -->
                    <div class="mb-4">
                        <label for="catatan_dokter" class="form-label text-xs font-bold text-hera-dark">Catatan Tambahan
                            Dokter (Opsional)</label>
                        <textarea name="catatan_dokter" id="catatan_dokter" rows="2" class="form-control form-control-sm"
                            placeholder="Catatan kontrol kembali atau saran pantangan..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dokter.dashboard') }}" class="btn btn-outline-secondary btn-sm text-xs">Batal</a>
                        <button type="submit" class="btn text-white font-bold text-xs px-4 py-2 shadow-sm"
                            style="background-color: #934D56;">
                            Simpan Rekam Medis & Selesaikan Pemeriksaan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PANEL RIWAYAT REKAM MEDIS SEBELUMNYA -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h2 class="h6 font-bold text-hera-dark mb-3 border-bottom pb-2">Diagnosis & Riwayat Medis Sebelumnya</h2>

                <div class="space-y-3" style="max-height: 480px; overflow-y: auto;">
                    @if(isset($riwayatSebelumnya) && count($riwayatSebelumnya) > 0)
                        @foreach($riwayatSebelumnya as $rm)
                            <div class="p-3 bg-light rounded-3 border text-xs mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span
                                        class="fw-bold text-hera-dark">{{ \Carbon\Carbon::parse($rm->created_at)->format('d M Y') }}</span>
                                    <span class="badge bg-secondary">{{ $rm->dokter->nama_dokter ?? 'dr. Klinik' }}</span>
                                </div>
                                <div class="text-danger fw-bold mb-1">Diagnosa: {{ $rm->diagnosa }}</div>
                                <div class="text-muted mb-2">Tindakan: {{ $rm->tindakan }}</div>
                                <div class="p-2 bg-white rounded border font-mono text-hera-maroon">
                                    <strong>Resep:</strong><br>{!! nl2br(e($rm->resep_obat)) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4 text-xs">Belum ada riwayat rekam medis sebelumnya untuk pasien
                            ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let indexObat = 1;
        $('#btn-tambah-obat').click(function () {
            let html = `
                <div class="row g-2 mb-2 item-resep">
                    <div class="col-md-5">
                        <select name="resep_obat[${indexObat}][id]" class="form-select form-select-sm text-xs">
                            <option value="">-- Pilih Obat --</option>
                            @if(isset($obats))
                                @foreach($obats as $o)
                                    <option value="{{ $o->id }}">{{ $o->nama_obat }} (Stok: {{ $o->stok }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="dosis[${indexObat}]" class="form-control form-control-sm text-xs" placeholder="Dosis (3x1 tablet)">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="aturan_pakai[${indexObat}]" class="form-control form-control-sm text-xs" placeholder="Aturan (Sesudah makan)">
                    </div>
                </div>
            `;
            $('#container-resep').append(html);
            indexObat++;
        });
    </script>
@endpush