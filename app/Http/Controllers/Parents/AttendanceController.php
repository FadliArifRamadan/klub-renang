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
            ->with(['student', 'coach', 'location'])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('parent.attendances.index', compact('attendances'));
    }
}
