<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        // Get the student record belonging to this general user
        $student = Student::where('user_id', Auth::id())->first();

        $attendances = collect();
        if ($student) {
            $attendances = Attendance::where('student_id', $student->id)
                ->with(['student.swimmingClass.category', 'student.package', 'coach', 'location'])
                ->orderBy('date')
                ->orderBy('created_at')
                ->paginate(10)
                ->withQueryString();

            foreach ($attendances as $att) {
                $att->session_count = Attendance::where('student_id', $att->student_id)
                    ->where(function ($q) use ($att) {
                        $q->where('date', '<', $att->date)
                          ->orWhere(function ($q2) use ($att) {
                              $q2->where('date', $att->date)
                                 ->where('id', '<=', $att->id);
                          });
                    })
                    ->count();
            }
        }

        return view('general.attendances.index', compact('attendances'));
    }
}
