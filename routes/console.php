<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Student;
use App\Models\Package;
use App\Models\SwimmingClass;
use App\Models\ClassCategory;

Schedule::call(function () {
    Student::checkAndExpirePackages();
})->daily();

Artisan::command('app:migrate-legacy-data', function () {
    $this->info('Starting legacy data migration...');

    $belajarCategory = ClassCategory::where('slug', 'belajar')->first();
    $prestasiCategory = ClassCategory::where('slug', 'prestasi')->first();

    if (!$belajarCategory || !$prestasiCategory) {
        $this->error('Please run ClassAndPackageSeeder first to seed categories and classes!');
        return;
    }

    $students = Student::whereNull('swimming_class_id')->get();
    $this->info("Found {$students->count()} legacy students without swimming_class_id.");

    foreach ($students as $student) {
        $age = $student->birth_date ? $student->birth_date->age : null;
        $oldPackage = Package::find($student->package_id);
        $categorySlug = 'belajar';

        if ($oldPackage) {
            $nameLower = strtolower($oldPackage->name);
            if (str_contains($nameLower, 'junior') || str_contains($nameLower, 'fin swimming') || str_contains($nameLower, 'prestasi')) {
                $categorySlug = 'prestasi';
            }
        }

        $swimmingClass = null;
        if ($categorySlug === 'prestasi') {
            if ($oldPackage) {
                $nameLower = strtolower($oldPackage->name);
                if (str_contains($nameLower, 'pra junior')) {
                    $swimmingClass = SwimmingClass::where('class_category_id', $prestasiCategory->id)->where('name', 'Pra Junior')->first();
                } elseif (str_contains($nameLower, 'fin swimming')) {
                    $swimmingClass = SwimmingClass::where('class_category_id', $prestasiCategory->id)->where('name', 'Finswimming')->first();
                } else {
                    $swimmingClass = SwimmingClass::where('class_category_id', $prestasiCategory->id)->where('name', 'Junior')->first();
                }
            }
            if (!$swimmingClass) {
                $swimmingClass = SwimmingClass::where('class_category_id', $prestasiCategory->id)->where('name', 'Junior')->first();
            }
        } else {
            if ($age !== null) {
                if ($age >= 1 && $age <= 3) {
                    $swimmingClass = SwimmingClass::where('class_category_id', $belajarCategory->id)->where('name', 'Batita')->first();
                } elseif ($age >= 4 && $age <= 5) {
                    $swimmingClass = SwimmingClass::where('class_category_id', $belajarCategory->id)->where('name', 'Balita')->first();
                } elseif ($age >= 6 && $age <= 12) {
                    $swimmingClass = SwimmingClass::where('class_category_id', $belajarCategory->id)->where('name', 'Anak-anak')->first();
                } else {
                    $swimmingClass = SwimmingClass::where('class_category_id', $belajarCategory->id)->where('name', 'Dewasa')->first();
                }
            } else {
                $swimmingClass = SwimmingClass::where('class_category_id', $belajarCategory->id)->where('name', 'Anak-anak')->first();
            }
        }

        if ($swimmingClass) {
            $student->swimming_class_id = $swimmingClass->id;

            if ($oldPackage) {
                $packageType = 'regular';
                if (str_contains(strtolower($oldPackage->name), 'private')) {
                    $packageType = 'private';
                } elseif ($categorySlug === 'prestasi') {
                    $packageType = 'monthly_prestasi';
                }

                $newPackage = Package::where('swimming_class_id', $swimmingClass->id)
                    ->where('package_type', $packageType)
                    ->where('sessions', $oldPackage->sessions)
                    ->first();

                if (!$newPackage && $categorySlug === 'prestasi') {
                    $newPackage = Package::where('swimming_class_id', $swimmingClass->id)
                        ->where('package_type', 'monthly_prestasi')
                        ->first();
                }

                if ($newPackage) {
                    $student->package_id = $newPackage->id;
                }
            }

            $student->save();
            $this->info("Migrated student '{$student->name}' (Age: {$age}) to Class '{$swimmingClass->name}' and Package ID '{$student->package_id}'.");
        } else {
            $this->error("Could not find matching class for student '{$student->name}' (Age: {$age})");
        }
    }

    $this->info('Migration completed successfully!');
})->purpose('Migrate legacy students and packages to the new swimming classes structure');
