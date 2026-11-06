<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name'     => 'Admin HERA',
            'email'    => 'admin@hera.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'no_hp'    => '081234567890',
        ]);

        // 2. Akun Dokter
        User::create([
            'name'     => 'Dr. Budi Santoso',
            'email'    => 'dokter@hera.com',
            'password' => Hash::make('password'),
            'role'     => 'dokter',
            'no_hp'    => '081298765432',
        ]);

        // 3. Akun Pasien
        User::create([
            'name'     => 'Siti Rahma',
            'email'    => 'pasien@hera.com',
            'password' => Hash::make('password'),
            'role'     => 'pasien',
            'no_hp'    => '081311223344',
        ]);
    }
}