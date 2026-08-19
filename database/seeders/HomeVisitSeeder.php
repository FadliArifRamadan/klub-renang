<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\ClassCategory;
use App\Models\SwimmingClass;
use App\Models\Package;
use App\Models\PackageLocationPrice;
use App\Models\Schedule;
use App\Models\User;

class HomeVisitSeeder extends Seeder
{
    /**
     * Run the database seeds for Home Visit location, pricing, and schedules.
     */
    public function run(): void
    {
        return;
        // 1. Ensure Location Home Visit exists
        $homeVisit = Location::firstOrCreate(
            ['name' => 'Home Visit'],
            ['address' => 'Kolam Renang Pribadi']
        );

        // 2. Class Category Belajar
        $belajarCategory = ClassCategory::where('slug', 'belajar')->first();
        if (!$belajarCategory) {
            $belajarCategory = ClassCategory::create([
                'slug' => 'belajar',
                'name' => 'Kelas Belajar Renang'
            ]);
        }

        // 3. Swimming Classes for Belajar
        $classNames = ['Batita', 'Balita', 'Anak-anak', 'Dewasa'];
        $belajarClasses = SwimmingClass::where('class_category_id', $belajarCategory->id)
            ->whereIn('name', $classNames)
            ->get();

        // 4. Update Package Location Prices for Home Visit
        // Remove Home Visit prices for Regular packages (so only Private packages are available for Home Visit)
        $regularPackages = Package::whereHas('swimmingClass', function ($q) use ($belajarCategory) {
            $q->where('class_category_id', $belajarCategory->id);
        })->where('package_type', '!=', 'private')->get();

        foreach ($regularPackages as $regPkg) {
            PackageLocationPrice::where('package_id', $regPkg->id)
                ->where('location_id', $homeVisit->id)
                ->delete();
        }

        // Set Home Visit prices for Private packages to match Star Sport / Pacific:
        // Private 8 Sesi: 850.000
        // Private 4 Sesi: 425.000
        // Private Single: 110.000
        $privatePackages = Package::whereHas('swimmingClass', function ($q) use ($belajarCategory) {
            $q->where('class_category_id', $belajarCategory->id);
        })->where(function($query) {
            $query->where('package_type', 'private')
                  ->orWhere(function($sub) {
                      $sub->where('package_type', 'single_session')
                          ->where('name', 'LIKE', '%Private%');
                  });
        })->get();

        foreach ($privatePackages as $pkg) {
            $priceVal = 850000;
            if ($pkg->sessions == 4) {
                $priceVal = 425000;
            } elseif ($pkg->sessions == 1) {
                $priceVal = 110000;
            }

            PackageLocationPrice::updateOrCreate(
                [
                    'package_id' => $pkg->id,
                    'location_id' => $homeVisit->id,
                ],
                [
                    'price' => $priceVal,
                ]
            );
        }

        // 5. Delete old weekend schedules for Home Visit
        Schedule::where('location_id', $homeVisit->id)->delete();

        // 6. Create new Home Visit schedules: Senin s/d Jumat (0..4), Pagi (10:00-11:00) and Sore (16:00-17:00)
        $coaches = User::where('role', 'coach')->get();
        $coachCount = $coaches->count();
        $coachIndex = 0;

        $days = [0, 1, 2, 3, 4]; // Senin - Jumat
        $timeSlots = [
            ['start' => '10:00', 'end' => '11:00', 'notes' => 'Home Visit Sesi Pagi'],
            ['start' => '16:00', 'end' => '17:00', 'notes' => 'Home Visit Sesi Sore'],
        ];

        foreach ($belajarClasses as $classModel) {
            foreach ($days as $dayIndex) {
                foreach ($timeSlots as $slot) {
                    $assignedCoach = $coachCount > 0 ? $coaches[$coachIndex % $coachCount] : null;
                    $coachIndex++;

                    Schedule::create([
                        'swimming_class_id' => $classModel->id,
                        'location_id' => $homeVisit->id,
                        'day_of_week' => $dayIndex,
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                        'session_type' => 'swim',
                        'coach_id' => $assignedCoach ? $assignedCoach->id : null,
                        'is_active' => true,
                        'notes' => $slot['notes'] . ' (' . $classModel->name . ')',
                    ]);
                }
            }
        }
    }
}
