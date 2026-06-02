<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Package;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Show the registration form for a General user.
     */
    public function create()
    {
        // If the user already has a registration, silently redirect to dashboard
        if (Student::where('user_id', Auth::id())->exists()) {
            return redirect()->route('general.dashboard')->with('error', 'Anda sudah terdaftar paket.');
        }

        $locations = Location::oldest()->get();
        $packages   = Package::oldest()->get();
        $coaches    = User::where('role', 'coach')->oldest()->get();

        return view('general.students.create', compact('locations', 'packages', 'coaches'));
    }

    /**
     * Show the list of courses registered by the General user.
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $students = Student::where('user_id', Auth::id())
            ->with(['package', 'coach', 'location', 'latestPayment'])
            ->oldest()
            ->get();

        return view('general.students.index', compact('students'));
    }

    /**
     * Store the registration for a General user.
     */
    public function store(Request $request)
    {
        // Ensure the user has not registered before; if so, silent redirect
        if (Student::where('user_id', Auth::id())->exists()) {
            return redirect()->route('general.dashboard')->with('error', 'Anda sudah terdaftar paket.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'birth_date'  => 'required|date',
            'gender'      => 'required|in:L,P',
            'location_id' => 'required|exists:locations,id',
            'package_id'  => 'required|exists:packages,id',
            'coach_id'    => 'nullable|exists:users,id',
        ]);

        $package = Package::findOrFail($request->package_id);

        Student::create([
            'user_id'      => Auth::id(),
            'name'         => $request->name,
            'birth_date'   => $request->birth_date,
            'gender'       => $request->gender,
            'location_id'  => $request->location_id,
            'package_id'   => $request->package_id,
            'coach_id'     => $request->coach_id,
            'quota_left'   => $package->sessions,
            'status'       => 'pending',
        ]);

        return redirect()->route('general.dashboard')
            ->with('success', 'Pendaftaran paket berhasil!');
    }
}
