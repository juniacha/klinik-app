<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Memanggil UserSeeder untuk mengisi data Admin, Dokter, dan Pasien Klinik HERA
        $this->call([
            UserSeeder::class,
        ]);
    }
}