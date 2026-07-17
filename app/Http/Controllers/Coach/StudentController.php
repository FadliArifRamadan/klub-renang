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

        $today = date('Y-m-d');
        // Cari coach mana saja yang sedang diwakili hari ini
        $substituteCoachIds = \App\Models\CoachLeave::where('status', 'approved')
            ->where('leave_date', $today)
            ->where('substitute_coach_id', Auth::id())
            ->pluck('coach_id')
            ->toArray();

        $coachIds = array_merge([Auth::id()], $substituteCoachIds);

        // Filter murid berdasarkan coach_id = user yang login atau ada jadwalnya
        // Eager load relasi package, location, dan latestPayment untuk menghindari N+1 query
        $students = Student::where(function($query) use ($coachIds) {
                $query->whereIn('coach_id', $coachIds)
                    ->orWhereHas('schedules', function($q) use ($coachIds) {
                        $q->whereIn('coach_id', $coachIds);
                    });
            })
            ->with(['package', 'location', 'latestPayment'])
            ->oldest()
            ->paginate(5);

        return view('coach.students.index', compact('students', 'coachIds'));
    }
}
