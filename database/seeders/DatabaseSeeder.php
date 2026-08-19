<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\ClassAndPackageSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Suntik Akun Admin Finance & Admin Operasional
        User::firstOrCreate(
            ['username' => 'adminfinance'],
            [
                'name' => 'Admin Finance',
                'phone' => '081234567891',
                'role' => 'admin_finance',
                'password' => Hash::make('password123'),
            ]
        );

        User::firstOrCreate(
            ['username' => 'adminoperasional'],
            [
                'name' => 'Admin Operasional',
                'phone' => '081234567892',
                'role' => 'admin_operasional',
                'password' => Hash::make('password123'),
            ]
        );



        // 2. Suntik Kategori Dasar (Belajar & Prestasi)
        \App\Models\ClassCategory::firstOrCreate(
            ['slug' => 'belajar'],
            ['name' => 'Kelas Belajar Renang']
        );

        \App\Models\ClassCategory::firstOrCreate(
            ['slug' => 'prestasi'],
            ['name' => 'Kelas Renang Prestasi']
        );
    }
}
