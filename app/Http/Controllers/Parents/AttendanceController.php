<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        // Get all student IDs belonging to this parent
        $studentIds = Auth::user()->children()->pluck('id');

        $attendances = Attendance::whereIn('student_id', $studentIds)
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

        return view('parent.attendances.index', compact('attendances'));
    }
}
