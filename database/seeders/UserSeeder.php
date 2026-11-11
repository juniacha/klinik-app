<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@hera.com'],
            [
                'name' => 'Admin HERA',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081234567890',
            ]
        );

        //Akun Dokter
        $userDokter = User::firstOrCreate(
            ['email' => 'dokter@hera.com'],
            [
                'name' => 'Dr. Budi Santoso, Sp.PD',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'no_hp' => '081298765432',
            ]
        );

        Dokter::firstOrCreate(
            ['user_id' => $userDokter->id],
            [
                'nama_dokter' => 'Dr. Budi Santoso, Sp.PD',
                'spesialis' => 'Poli Penyakit Dalam',
            ]
        );

        //Akun Pasien
        $userPasien = User::firstOrCreate(
            ['email' => 'pasien@hera.com'],
            [
                'name' => 'Siti Rahma',
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'no_hp' => '081311223344',
            ]
        );

        Pasien::firstOrCreate(
            ['user_id' => $userPasien->id],
            [
                'no_rm' => 'RM-000001',
                'nik' => '3171012345678901',
            ]
        );
    }
}