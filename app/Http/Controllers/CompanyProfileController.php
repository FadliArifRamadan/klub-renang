<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Package;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Tampilkan Halaman Utama (Home)
     */
    public function home()
    {
        $totalStudents = Student::count();
        $totalCoaches  = User::where('role', 'coach')->count();
        $totalLocations = Location::count();
        $packages = Package::oldest()->get();
        $locations = Location::oldest()->get();

        return view('company-profile.home', compact('totalStudents', 'totalCoaches', 'totalLocations', 'packages', 'locations'));
    }

    /**
     * Tampilkan Halaman Visi & Misi
     */
    public function aboutVisionMission()
    {
        return view('company-profile.about-vision-mission');
    }

    /**
     * Tampilkan Halaman Sejarah & Perjalanan
     */
    public function aboutHistory()
    {
        return view('company-profile.about-history');
    }

    /**
     * Tampilkan Halaman Tim Instruktur / Pelatih
     */
    public function aboutCoaches()
    {
        $coaches = User::where('role', 'coach')->oldest()->get();
        return view('company-profile.about-coaches', compact('coaches'));
    }

    /**
     * Tampilkan Halaman Paket Belajar Renang per Tingkatan (Batita, Balita, Anak-anak, Dewasa)
     */
    public function packagesBelajarLevel($slug = 'batita')
    {
        $allBelajarClasses = \App\Models\SwimmingClass::with(['packages.locationPrices.location', 'category'])
            ->whereHas('category', function ($q) {
                $q->where('slug', 'belajar');
            })->oldest()->get();

        $swimmingClass = $allBelajarClasses->first(function ($c) use ($slug) {
            return \Illuminate\Support\Str::slug($c->name) === \Illuminate\Support\Str::slug($slug);
        });

        if (!$swimmingClass) {
            $levelMap = [
                'batita'    => ['name' => 'Batita', 'min' => 1, 'max' => 3],
                'balita'    => ['name' => 'Balita', 'min' => 4, 'max' => 5],
                'anak-anak' => ['name' => 'Anak-anak', 'min' => 6, 'max' => 12],
                'dewasa'    => ['name' => 'Dewasa', 'min' => 13, 'max' => null],
            ];
            $slugLower = strtolower($slug);
            $info = $levelMap[$slugLower] ?? ['name' => ucfirst($slug), 'min' => 1, 'max' => null];

            $swimmingClass = new \App\Models\SwimmingClass([
                'name' => $info['name'],
                'age_min' => $info['min'],
                'age_max' => $info['max'],
                'description' => "Kelas Belajar Renang tingkat {$info['name']}.",
            ]);
            $swimmingClass->setRelation('packages', collect());
        }

        return view('company-profile.packages-belajar-level', compact('swimmingClass', 'allBelajarClasses'));
    }

    /**
     * Tampilkan Halaman Paket Renang Prestasi
     */
    public function packagesPrestasi()
    {
        $prestasiCategory = \App\Models\ClassCategory::with(['swimmingClasses.packages'])
            ->where('slug', 'prestasi')
            ->first();
        return view('company-profile.packages-prestasi', compact('prestasiCategory'));
    }

    /**
     * Tampilkan Halaman Kolam Latihan (Locations)
     */
    public function locations()
    {
        $locations = Location::oldest()->get();
        return view('company-profile.locations', compact('locations'));
    }

    /**
     * Tampilkan Halaman Jadwal Belajar Renang per Tingkatan (Batita, Balita, Anak-anak, Dewasa)
     */
    public function scheduleBelajarLevel($slug = 'batita')
    {
        $locations = Location::oldest()->get();
        $allBelajarClasses = \App\Models\SwimmingClass::whereHas('category', function ($q) {
            $q->where('slug', 'belajar');
        })->oldest()->get();

        $swimmingClass = \App\Models\SwimmingClass::with(['schedules.location', 'category'])
            ->get()
            ->first(function ($c) use ($slug) {
                return \Illuminate\Support\Str::slug($c->name) === \Illuminate\Support\Str::slug($slug);
            });

        if (!$swimmingClass) {
            $levelMap = [
                'batita'    => ['name' => 'Batita', 'min' => 1, 'max' => 3],
                'balita'    => ['name' => 'Balita', 'min' => 4, 'max' => 5],
                'anak-anak' => ['name' => 'Anak-anak', 'min' => 6, 'max' => 12],
                'dewasa'    => ['name' => 'Dewasa', 'min' => 13, 'max' => null],
            ];
            $slugLower = strtolower($slug);
            $info = $levelMap[$slugLower] ?? ['name' => ucfirst($slug), 'min' => 1, 'max' => null];

            $swimmingClass = new \App\Models\SwimmingClass([
                'name' => $info['name'],
                'age_min' => $info['min'],
                'age_max' => $info['max'],
                'description' => "Kelas Belajar Renang tingkat {$info['name']}.",
            ]);
            $swimmingClass->setRelation('schedules', collect());
        }

        return view('company-profile.schedule-belajar-level', compact('swimmingClass', 'allBelajarClasses', 'locations'));
    }

    /**
     * Tampilkan Halaman Jadwal Renang Prestasi
     */
    public function schedulePrestasi()
    {
        $locations = Location::oldest()->get();
        $prestasiCategory = \App\Models\ClassCategory::with(['swimmingClasses.schedules.location'])
            ->where('slug', 'prestasi')
            ->first();

        return view('company-profile.schedule-prestasi', compact('prestasiCategory', 'locations'));
    }

    /**
     * Tampilkan Halaman Kontak Kami (Contact Us)
     */
    public function contact()
    {
        $locations = Location::oldest()->get();
        return view('company-profile.contact', compact('locations'));
    }
}
