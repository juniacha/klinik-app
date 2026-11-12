# HERA Klinik App - Sistem Informasi Klinik Sederhana

Aplikasi berbasis web untuk manajemen operasional klinik yang dibangun menggunakan framework **Laravel** (Arsitektur MVC, Blade Template, Bootstrap 5, DataTables, dan MySQL) untuk memenuhi tugas UTS Pemrograman Web Tingkat Mahir.

## Fitur & Pembagian Peran (Role)
* **Admin:** Mengelola Master Data Obat, Dokter, dan Pasien (CRUD + DataTables), serta memverifikasi dan memperbarui status antrean pendaftaran.
* **Dokter:** Melihat jadwal antrean pemeriksaan hari ini, menginput hasil pemeriksaan medis (keluhan, diagnosa, tindakan medis), menulis resep obat, serta mengatur jadwal praktik.
* **Pasien:** Melakukan registrasi mandiri dengan penerbitan Nomor Rekam Medis (`RM-XXXXXX`) otomatis, booking dokter berdasarkan Poliklinik dengan nomor antrean otomatis (`ANT-001`), melihat riwayat rekam medis beserta resep obat, dan mengelola profil.

## Cara Instalasi & Menjalankan Aplikasi

1. **Clone Repository**
   * `git clone https://github.com/juniacha/klinik-app.git`
   * `cd klinik-app`

2. **Install Dependensi PHP**
   * `composer install`

3. **Konfigurasi Environment**
   * Salin file `.env.example` menjadi `.env`: `cp .env.example .env`
   * Buat database kosong baru di MySQL / phpMyAdmin dengan nama `hera_db` (sesuaikan dengan `DB_DATABASE` pada file `.env`).
   * Generate Application Key: `php artisan key:generate`

4. **Migrasi Database & Seeder Akun Demo**
   * `php artisan migrate:fresh --seed`

5. **Jalankan Server Lokal**
   * `php artisan serve`
   * Buka browser dan akses `http://127.0.0.1:8000`

## Akun Demo (Default Seeder)
* **Admin:** `admin@hera.com` | Password: `password`
* **Dokter:** `dokter@hera.com` | Password: `password`
* **Pasien:** `pasien@hera.com` | Password: `password`
