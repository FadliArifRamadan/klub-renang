<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar murid yang dilatih oleh coach yang sedang login.
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Filter murid berdasarkan coach_id = user yang login
        // Eager load relasi package, location, dan latestPayment untuk menghindari N+1 query
        $students = Student::where('coach_id', Auth::id())
            ->with(['package', 'location', 'latestPayment'])
            ->oldest('name')
            ->get();

        return view('coach.students.index', compact('students'));
    }
}
