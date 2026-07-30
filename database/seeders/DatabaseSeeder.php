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



        // 2. Suntik Akun Coach Uji Coba (20 Coach)
        $coachData = [
            ['username' => 'coachbudi', 'name' => 'Coach Budi Renang'],
            ['username' => 'coachiruka', 'name' => 'Coach Budi Iruka'],
            ['username' => 'coachkabuto', 'name' => 'Coach Kabuto Renang'],
            ['username' => 'coachnaruto', 'name' => 'Coach Naruto Renang'],
            ['username' => 'coachsasuke', 'name' => 'Coach Sasuke Renang'],
            ['username' => 'coachneiji', 'name' => 'Coach Neiji Renang'],
            ['username' => 'coachkiba', 'name' => 'Coach Kiba Renang'],
            ['username' => 'coachkakashi', 'name' => 'Coach Kakashi Renang'],
            ['username' => 'coachjiraiya', 'name' => 'Coach Jiraiya Renang'],
            ['username' => 'coachtsunade', 'name' => 'Coach Tsunade Renang'],
            ['username' => 'coachorochimaru', 'name' => 'Coach Orochimaru Renang'],
            ['username' => 'coachgaara', 'name' => 'Coach Gaara Renang'],
            ['username' => 'coachshikamaru', 'name' => 'Coach Shikamaru Renang'],
            ['username' => 'coachchoji', 'name' => 'Coach Choji Renang'],
            ['username' => 'coachino', 'name' => 'Coach Ino Renang'],
            ['username' => 'coachasuma', 'name' => 'Coach Asuma Renang'],
            ['username' => 'coachguy', 'name' => 'Coach Guy Renang'],
            ['username' => 'coachlee', 'name' => 'Coach Lee Renang'],
            ['username' => 'coachtenten', 'name' => 'Coach Tenten Renang'],
            ['username' => 'coachhinata', 'name' => 'Coach Hinata Renang'],
        ];

        foreach ($coachData as $coach) {
            User::firstOrCreate(
                ['username' => $coach['username']],
                [
                    'name' => $coach['name'],
                    'phone' => '089876543210',
                    'role' => 'coach',
                    'password' => Hash::make('password123'),
                ]
            );
        }

        // 3. Suntik Kategori, Kelas, Lokasi, dan Paket
        $this->call(ClassAndPackageSeeder::class);
    }
}
