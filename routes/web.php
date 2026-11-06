<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;

// Redirect Halaman Utama ke Dashboard Admin Klinik HERA
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Route Logout (Memperbaiki error Route [logout] not defined)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard Admin Klinik HERA
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Modul CRUD Klinik HERA
Route::resource('obat', ObatController::class);
Route::resource('pendaftaran', PendaftaranController::class);
Route::post('pendaftaran/{id}/check-in', [PendaftaranController::class, 'checkIn'])->name('pendaftaran.checkIn');
Route::post('pendaftaran/{id}/lewati', [PendaftaranController::class, 'lewatiAntrean'])->name('pendaftaran.lewati');