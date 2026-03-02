<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dummy Admin
        User::create([
            'name' => 'Admin Kebersihan',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Dummy Petugas
        \App\Models\Anggota::create([
            'nama' => 'Asep Surasep',
            'qr_code_token' => 'QR-ASEP-001',
            'status_aktif' => true,
        ]);

        \App\Models\Anggota::create([
            'nama' => 'Budi Sudarsono',
            'qr_code_token' => 'QR-BUDI-002',
            'status_aktif' => true,
        ]);
    }
}
