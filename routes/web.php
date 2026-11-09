<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DokterPemeriksaanController;
use App\Http\Controllers\PasienDashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;

// Mengarahkan halaman utama (/) langsung ke Form Login
Route::get('/', function () {
    return redirect()->route('login');
})->name('landing');

// 2. Autentikasi (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (Must be Authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Dynamic Redirect Dashboard Berdasarkan Role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'dokter') return redirect()->route('dokter.dashboard');
    return redirect()->route('pasien.dashboard');
})->middleware('auth')->name('dashboard');

// 4. Protected Routes (Harus Login)
Route::middleware(['auth'])->group(function () {

    // =========================================================================
    // ROLE: PASIEN
    // =========================================================================
    Route::middleware(['role:pasien'])->prefix('pasien')->as('pasien.')->group(function () {
        Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');
        
        // Pendaftaran / Booking Antrean Dokter
        Route::get('/booking', [PendaftaranController::class, 'createPasien'])->name('booking.create');
        Route::get('/pendaftaran/buat', [PendaftaranController::class, 'createPasien'])->name('pendaftaran.create');
        Route::post('/booking', [PendaftaranController::class, 'storePasien'])->name('booking.store');
        Route::post('/pendaftaran/simpan', [PendaftaranController::class, 'storePasien'])->name('pendaftaran.store');
        
        // Rekam Medis & Riwayat Berobat
        Route::get('/rekam-medis', [RekamMedisController::class, 'indexPasien'])->name('rekam-medis.index');
        Route::get('/riwayat', [RekamMedisController::class, 'indexPasien'])->name('riwayat');
        
        // Profil Pasien
        Route::get('/profil', [PasienDashboardController::class, 'editProfil'])->name('profil.edit');
        Route::post('/profil', [PasienDashboardController::class, 'updateProfil'])->name('profil.update');
    });

    // =========================================================================
    // ROLE: DOKTER
    // =========================================================================
    Route::middleware(['role:dokter'])->prefix('dokter')->as('dokter.')->group(function () {
        Route::get('/dashboard', [DokterPemeriksaanController::class, 'index'])->name('dashboard');
        Route::get('/pemeriksaan/{pendaftaran}', [DokterPemeriksaanController::class, 'periksa'])->name('pemeriksaan.create');
        Route::post('/pemeriksaan/{pendaftaran}', [DokterPemeriksaanController::class, 'storePemeriksaan'])->name('pemeriksaan.store');
        Route::get('/rekam-medis-pasien', [RekamMedisController::class, 'indexDokter'])->name('rekam-medis.index');
    });

    // =========================================================================
    // ROLE: ADMIN
    // =========================================================================
    Route::middleware(['role:admin'])->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Master Data Resources (CRUD)
        Route::resource('obat', ObatController::class);
        Route::resource('pendaftaran', PendaftaranController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('pasien', PasienController::class);
        
        // Fitur Tambahan Admin
        Route::patch('/pendaftaran/{pendaftaran}/status', [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.updateStatus');
        Route::get('/pasien/{pasien}/riwayat', [PasienController::class, 'riwayat'])->name('pasien.riwayat');
        Route::get('/laporan', [AdminDashboardController::class, 'laporan'])->name('laporan');
    });

    // =========================================================================
    // ALIAS ROUTE GLOBAL (MENCEGAH ROUTE NOT FOUND DARI SHORTHAND NAME VIEW)
    // =========================================================================
    Route::middleware(['role:admin'])->group(function () {
        // Pendaftaran
        Route::get('/admin-pendaftaran-list', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/admin-pendaftaran-create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
        
        // Obat
        Route::get('/admin-obat-list', [ObatController::class, 'index'])->name('obat.index');
        Route::get('/admin-obat-create', [ObatController::class, 'create'])->name('obat.create');
        Route::post('/admin-obat-store', [ObatController::class, 'store'])->name('obat.store');

        // Dokter & Pasien
        Route::get('/admin-dokter-list', [DokterController::class, 'index'])->name('dokter.index');
        Route::get('/admin-pasien-list', [PasienController::class, 'index'])->name('pasien.index');
    });
});