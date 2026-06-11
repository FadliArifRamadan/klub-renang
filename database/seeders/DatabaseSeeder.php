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
        // 1. Suntik Akun Admin Utama
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Mimin Admin Klub',
                'phone' => '081234567890',
                'role' => 'admin',
                'password' => Hash::make('password123'), // Password-nya
            ]
        );

        // 2. Suntik Akun Coach Uji Coba
        User::firstOrCreate(
            ['username' => 'coachbudi'],
            [
                'name' => 'Coach Budi Renang',
                'phone' => '089876543210',
                'role' => 'coach',
                'password' => Hash::make('password123'), // Password-nya
            ]
        );

        // 3. Suntik Kategori, Kelas, Lokasi, dan Paket
        $this->call(ClassAndPackageSeeder::class);
    }
}
