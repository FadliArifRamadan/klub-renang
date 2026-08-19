<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\ClassCategory;
use App\Models\SwimmingClass;
use App\Models\Package;
use App\Models\PackageLocationPrice;

class ClassAndPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        return;
        // 1. Seed Locations
        $locations = [
            'Taman Wahidin' => ['address' => 'Jl. Wahidin, Cirebon'],
            'Cipto' => ['address' => 'Jl. Dr. Cipto Mangunkusumo, Cirebon'],
            'Star Sport' => ['address' => 'Star Sport Hall, Cirebon'],
            'Tirta' => ['address' => 'Kolam Renang Tirta, Cirebon'],
            'Pacific' => ['address' => 'Pacific Sport Center, Cirebon'],
            'Home Visit' => ['address' => 'Kolam Renang Pribadi'],
        ];

        $locationModels = [];
        foreach ($locations as $name => $data) {
            $locationModels[$name] = Location::firstOrCreate(
                ['name' => $name],
                ['address' => $data['address']]
            );
        }

        // 2. Seed Class Categories
        $belajarCategory = ClassCategory::firstOrCreate(
            ['slug' => 'belajar'],
            ['name' => 'Kelas Belajar Renang']
        );

        $prestasiCategory = ClassCategory::firstOrCreate(
            ['slug' => 'prestasi'],
            ['name' => 'Kelas Renang Prestasi']
        );

        // 3. Seed Swimming Classes (Belajar Renang)
        $belajarClasses = [
            'Batita' => ['age_min' => 1, 'age_max' => 3],
            'Balita' => ['age_min' => 4, 'age_max' => 5],
            'Anak-anak' => ['age_min' => 6, 'age_max' => 12],
            'Dewasa' => ['age_min' => 13, 'age_max' => null],
        ];

        $belajarClassModels = [];
        foreach ($belajarClasses as $name => $ages) {
            $belajarClassModels[$name] = SwimmingClass::firstOrCreate(
                ['name' => $name, 'class_category_id' => $belajarCategory->id],
                [
                    'age_min' => $ages['age_min'],
                    'age_max' => $ages['age_max'],
                    'max_quota' => 15,
                    'description' => "Kelas Belajar Renang tingkat {$name} untuk usia {$ages['age_min']} sampai " . ($ages['age_max'] ?? 'ke atas') . " tahun."
                ]
            );
        }

        // 3b. Seed Swimming Classes (Renang Prestasi)
        $prestasiClasses = [
            'Pra Junior' => ['age_min' => 7, 'age_max' => 9],
            'Junior' => ['age_min' => 10, 'age_max' => 12],
            'Senior' => ['age_min' => 12, 'age_max' => null],
            'Finswimming' => ['age_min' => 12, 'age_max' => null],
        ];

        $prestasiClassModels = [];
        foreach ($prestasiClasses as $name => $ages) {
            $prestasiClassModels[$name] = SwimmingClass::firstOrCreate(
                ['name' => $name, 'class_category_id' => $prestasiCategory->id],
                [
                    'age_min' => $ages['age_min'],
                    'age_max' => $ages['age_max'],
                    'max_quota' => 15,
                    'description' => "Kelas Renang Prestasi tingkat {$name}."
                ]
            );
        }

        // 4. Seed Packages for Belajar Renang
        // Karena paket berlaku untuk kategori Belajar Renang (semua tingkat Batita/Balita/Anak-anak/Dewasa bisa memilih paket ini),
        // kita akan menduplikasi paket untuk masing-masing kelas belajar renang agar di database relasinya tepat.
        $belajarPackagesTemplate = [
            [
                'name_suffix' => 'Regular 8 Sesi',
                'package_type' => 'regular',
                'sessions' => 8,
                'active_period_months' => 2,
                'prices' => [
                    'Taman Wahidin' => 600000,
                    'Cipto' => 600000,
                    'Star Sport' => 450000,
                    'Tirta' => 450000,
                    'Pacific' => 450000,
                ]
            ],
            [
                'name_suffix' => 'Regular 4 Sesi',
                'package_type' => 'regular',
                'sessions' => 4,
                'active_period_months' => 1,
                'prices' => [
                    'Taman Wahidin' => 300000,
                    'Cipto' => 300000,
                    'Star Sport' => 225000,
                    'Tirta' => 225000,
                    'Pacific' => 225000,
                ]
            ],
            [
                'name_suffix' => 'Regular Single',
                'package_type' => 'single_session',
                'sessions' => 1,
                'active_period_months' => 1,
                'prices' => [
                    'Taman Wahidin' => 100000,
                    'Cipto' => 100000,
                    'Star Sport' => 80000,
                    'Tirta' => 80000,
                    'Pacific' => 80000,
                ]
            ],
            [
                'name_suffix' => 'Private 8 Sesi',
                'package_type' => 'private',
                'sessions' => 8,
                'active_period_months' => 2,
                'prices' => [
                    'Taman Wahidin' => 1000000,
                    'Cipto' => 1000000,
                    'Star Sport' => 850000,
                    'Tirta' => 850000,
                    'Pacific' => 850000,
                    'Home Visit' => 850000,
                ]
            ],
            [
                'name_suffix' => 'Private 4 Sesi',
                'package_type' => 'private',
                'sessions' => 4,
                'active_period_months' => 1,
                'prices' => [
                    'Taman Wahidin' => 500000,
                    'Cipto' => 500000,
                    'Star Sport' => 425000,
                    'Tirta' => 425000,
                    'Pacific' => 425000,
                    'Home Visit' => 425000,
                ]
            ],
            [
                'name_suffix' => 'Private Single',
                'package_type' => 'single_session',
                'sessions' => 1,
                'active_period_months' => 1,
                'prices' => [
                    'Taman Wahidin' => 130000,
                    'Cipto' => 130000,
                    'Star Sport' => 110000,
                    'Tirta' => 110000,
                    'Pacific' => 110000,
                    'Home Visit' => 110000,
                ]
            ],
        ];

        foreach ($belajarClassModels as $className => $classModel) {
            foreach ($belajarPackagesTemplate as $tpl) {
                $packageName = $className . ' - ' . $tpl['name_suffix'];
                $package = Package::firstOrCreate(
                    [
                        'name' => $packageName,
                        'swimming_class_id' => $classModel->id,
                        'package_type' => $tpl['package_type'],
                    ],
                    [
                        'sessions' => $tpl['sessions'],
                        'swim_sessions' => $tpl['sessions'],
                        'active_period_months' => $tpl['active_period_months'],
                        'is_location_based' => true,
                        'price' => null,
                    ]
                );

                // Seed location prices for this package
                foreach ($tpl['prices'] as $locName => $priceVal) {
                    if (isset($locationModels[$locName])) {
                        PackageLocationPrice::firstOrCreate([
                            'package_id' => $package->id,
                            'location_id' => $locationModels[$locName]->id,
                        ], [
                            'price' => $priceVal
                        ]);
                    }
                }
            }
        }

        // 5. Seed Packages for Renang Prestasi (Flat monthly rate, flat pricing)
        $prestasiPackagesTemplate = [
            'Pra Junior' => [
                'price' => 600000,
                'swim' => 16,
                'dryland' => 4,
            ],
            'Junior' => [
                'price' => 650000,
                'swim' => 24,
                'dryland' => 4,
            ],
            'Senior' => [
                'price' => 700000,
                'swim' => 36,
                'dryland' => 8,
            ],
            'Finswimming' => [
                'price' => 650000,
                'swim' => 28,
                'dryland' => 8,
            ],
        ];

        foreach ($prestasiClassModels as $className => $classModel) {
            if (isset($prestasiPackagesTemplate[$className])) {
                $tpl = $prestasiPackagesTemplate[$className];
                Package::firstOrCreate(
                    [
                        'name' => 'Prestasi ' . $className . ' (Bulanan)',
                        'swimming_class_id' => $classModel->id,
                        'package_type' => 'monthly_prestasi',
                    ],
                    [
                        'price' => $tpl['price'],
                        'sessions' => $tpl['swim'] + $tpl['dryland'],
                        'swim_sessions' => $tpl['swim'],
                        'dryland_sessions' => $tpl['dryland'],
                        'active_period_months' => 1,
                        'is_location_based' => false,
                    ]
                );
            }
        }

        // 6. Seed Schedules
        $tamanWahidin = $locationModels['Taman Wahidin'];
        $cipto = $locationModels['Cipto'];
        $starSport = $locationModels['Star Sport'];
        $tirta = $locationModels['Tirta'];
        $pacific = $locationModels['Pacific'];
        $homeVisit = $locationModels['Home Visit'];

        $scheduleData = [
            // Belajar - Batita
            ['class' => $belajarClassModels['Batita'], 'location' => $tamanWahidin, 'day' => 0, 'start' => '16:00', 'end' => '17:00', 'type' => 'swim', 'notes' => 'Sesi Kolam Dangkal'],
            ['class' => $belajarClassModels['Batita'], 'location' => $tamanWahidin, 'day' => 2, 'start' => '16:00', 'end' => '17:00', 'type' => 'swim', 'notes' => 'Sesi Kolam Dangkal'],
            ['class' => $belajarClassModels['Batita'], 'location' => $starSport, 'day' => 1, 'start' => '10:00', 'end' => '11:00', 'type' => 'swim', 'notes' => 'Sesi Kolam Dangkal'],
            ['class' => $belajarClassModels['Batita'], 'location' => $starSport, 'day' => 3, 'start' => '10:00', 'end' => '11:00', 'type' => 'swim', 'notes' => 'Sesi Kolam Dangkal'],
            ['class' => $belajarClassModels['Batita'], 'location' => $homeVisit, 'day' => 5, 'start' => '10:00', 'end' => '11:00', 'type' => 'swim', 'notes' => 'Home Visit Batita'],

            // Belajar - Balita
            ['class' => $belajarClassModels['Balita'], 'location' => $cipto, 'day' => 0, 'start' => '17:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Sesi Balita'],
            ['class' => $belajarClassModels['Balita'], 'location' => $cipto, 'day' => 2, 'start' => '17:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Sesi Balita'],
            ['class' => $belajarClassModels['Balita'], 'location' => $tirta, 'day' => 5, 'start' => '09:00', 'end' => '10:00', 'type' => 'swim', 'notes' => 'Sesi Akhir Pekan'],
            ['class' => $belajarClassModels['Balita'], 'location' => $tirta, 'day' => 6, 'start' => '09:00', 'end' => '10:00', 'type' => 'swim', 'notes' => 'Sesi Akhir Pekan'],
            ['class' => $belajarClassModels['Balita'], 'location' => $homeVisit, 'day' => 5, 'start' => '11:00', 'end' => '12:00', 'type' => 'swim', 'notes' => 'Home Visit Balita'],

            // Belajar - Anak-anak
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $tamanWahidin, 'day' => 1, 'start' => '16:00', 'end' => '17:30', 'type' => 'swim', 'notes' => 'Sesi Reguler'],
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $tamanWahidin, 'day' => 3, 'start' => '16:00', 'end' => '17:30', 'type' => 'swim', 'notes' => 'Sesi Reguler'],
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $pacific, 'day' => 5, 'start' => '15:00', 'end' => '16:30', 'type' => 'swim', 'notes' => 'Sesi Akhir Pekan'],
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $pacific, 'day' => 6, 'start' => '15:00', 'end' => '16:30', 'type' => 'swim', 'notes' => 'Sesi Akhir Pekan'],
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $homeVisit, 'day' => 6, 'start' => '09:00', 'end' => '10:30', 'type' => 'swim', 'notes' => 'Home Visit Anak-anak'],
            ['class' => $belajarClassModels['Anak-anak'], 'location' => $homeVisit, 'day' => 6, 'start' => '14:00', 'end' => '15:30', 'type' => 'swim', 'notes' => 'Home Visit Anak-anak'],

            // Belajar - Dewasa
            ['class' => $belajarClassModels['Dewasa'], 'location' => $cipto, 'day' => 4, 'start' => '19:00', 'end' => '20:30', 'type' => 'swim', 'notes' => 'Sesi Malam Dewasa'],
            ['class' => $belajarClassModels['Dewasa'], 'location' => $starSport, 'day' => 5, 'start' => '07:00', 'end' => '08:30', 'type' => 'swim', 'notes' => 'Sesi Pagi'],
            ['class' => $belajarClassModels['Dewasa'], 'location' => $starSport, 'day' => 6, 'start' => '07:00', 'end' => '08:30', 'type' => 'swim', 'notes' => 'Sesi Pagi'],
            ['class' => $belajarClassModels['Dewasa'], 'location' => $homeVisit, 'day' => 6, 'start' => '16:00', 'end' => '17:30', 'type' => 'swim', 'notes' => 'Home Visit Dewasa'],

            // Prestasi - Pra Junior (Senin, Rabu, Jumat swim di Taman Wahidin; Sabtu dryland)
            ['class' => $prestasiClassModels['Pra Junior'], 'location' => $tamanWahidin, 'day' => 0, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Pra Junior'], 'location' => $tamanWahidin, 'day' => 2, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Pra Junior'], 'location' => $tamanWahidin, 'day' => 4, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Pra Junior'], 'location' => $tamanWahidin, 'day' => 5, 'start' => '08:00', 'end' => '10:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],

            // Prestasi - Junior (Senin, Selasa, Rabu, Jumat, Sabtu swim di Cipto; Minggu dryland)
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 0, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 1, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 2, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 4, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 5, 'start' => '16:00', 'end' => '18:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Junior'], 'location' => $cipto, 'day' => 6, 'start' => '08:00', 'end' => '10:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],

            // Prestasi - Senior (Senin s.d. Sabtu swim; Selasa & Jumat dryland)
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 0, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 1, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 2, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 3, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 4, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 5, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 1, 'start' => '15:00', 'end' => '17:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],
            ['class' => $prestasiClassModels['Senior'], 'location' => $cipto, 'day' => 4, 'start' => '15:00', 'end' => '17:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],

            // Prestasi - Finswimming (Senin s.d. Sabtu swim; Rabu & Sabtu dryland)
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 0, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 1, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 2, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 3, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 4, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 5, 'start' => '18:00', 'end' => '20:00', 'type' => 'swim', 'notes' => 'Latihan Air'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 2, 'start' => '15:00', 'end' => '17:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],
            ['class' => $prestasiClassModels['Finswimming'], 'location' => $pacific, 'day' => 5, 'start' => '15:00', 'end' => '17:00', 'type' => 'dryland', 'notes' => 'Latihan Darat/Fisik'],
        ];

        // Ambil semua coach yang sudah dibuat di DatabaseSeeder
        $coaches = \App\Models\User::where('role', 'coach')->get();
        $coachCount = $coaches->count();

        foreach ($scheduleData as $index => $sd) {
            $assignedCoach = $coachCount > 0 ? $coaches[$index % $coachCount] : null;

            \App\Models\Schedule::updateOrCreate([
                'swimming_class_id' => $sd['class']->id,
                'location_id' => $sd['location']->id,
                'day_of_week' => $sd['day'],
                'start_time' => $sd['start'],
                'end_time' => $sd['end'],
                'session_type' => $sd['type'],
            ], [
                'is_active' => true,
                'notes' => $sd['notes'],
                'coach_id' => $assignedCoach ? $assignedCoach->id : null,
            ]);
        }
    }
}
