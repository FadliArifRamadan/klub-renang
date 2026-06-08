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
     * Tampilkan Halaman Tentang Kami (About Us)
     */
    public function about()
    {
        $coaches = User::where('role', 'coach')->oldest()->get();
        return view('company-profile.about', compact('coaches'));
    }

    /**
     * Tampilkan Halaman Program Paket (Packages)
     */
    public function packages()
    {
        $packages = Package::oldest()->get();
        return view('company-profile.packages', compact('packages'));
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
     * Tampilkan Halaman Jadwal Latihan (Schedule)
     */
    public function schedule()
    {
        $locations = Location::oldest()->get();
        return view('company-profile.schedule', compact('locations'));
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
