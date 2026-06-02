<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Package;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Mengambil data anak beserta relasi tempat & paket kursusnya menggunakan Eloquent
        // Eager load relasi location, package, coach, dan latestPayment agar tidak terjadi N+1 query
        $students = Student::where('user_id', Auth::id())->with(['package', 'coach', 'location', 'latestPayment'])->oldest()->get();

        return view('parent.students.index', compact('students'));
    }

    // 1. Menampilkan Form Pendaftaran Murid Baru
    public function create()
    {
        // Mengambil semua data master kolam dan paket untuk dropdown
        $locations = Location::oldest()->get();
        $packages = Package::oldest()->get();

        // Mengambil user yang memiliki role 'coach' untuk preferensi pelatih
        $coaches = User::where('role', 'coach')->oldest()->get();

        return view('parent.students.create', compact('locations', 'packages', 'coaches'));
    }

    // 2. Menyimpan Data Pendaftaran Anak ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'location_id' => 'required|exists:locations,id',
            'package_id' => 'required|exists:packages,id',
            'coach_id' => 'nullable|exists:users,id',
        ]);

        // AMBIL DATA PAKET UNTUK MENDAPATKAN JUMLAH SESI LATIHAN
        $package = Package::findOrFail($request->package_id);

        Student::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'location_id' => $request->location_id,
            'package_id' => $request->package_id,
            'coach_id' => $request->coach_id,
            'quota_left' => $package->sessions, // Otomatis terisi sesuai jumlah sesi dari paket yang dipilih!
            'status' => 'pending',
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Pendaftaran anak berhasil disimpan! Silakan cek menu pembayaran.');
    }
}
