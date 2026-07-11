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
                ->paginate(5);
        }

        return view('general.attendances.index', compact('attendances'));
    }
}
