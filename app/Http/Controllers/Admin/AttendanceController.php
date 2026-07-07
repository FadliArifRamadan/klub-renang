<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Tampilkan riwayat absensi untuk Admin
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'location', 'coach']);

        // Filter pencarian berdasarkan nama coach atau nama murid
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('coach', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.attendances.index', compact('attendances'));
    }
}
