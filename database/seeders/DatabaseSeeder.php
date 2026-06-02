<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Mimin Admin Klub',
            'username' => 'admin', // Username untuk login
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password123'), // Password-nya
        ]);

        // 2. Suntik Akun Coach Uji Coba
        User::create([
            'name' => 'Coach Budi Renang',
            'username' => 'coachbudi', // Username untuk login
            'phone' => '089876543210',
            'role' => 'coach',
            'password' => Hash::make('password123'), // Password-nya
        ]);
    }
}
