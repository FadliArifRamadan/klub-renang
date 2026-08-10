<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Tampilkan riwayat absensi untuk Admin (Kelas Belajar)
     */
    public function belajar(Request $request)
    {
        $query = Attendance::whereHas('student.swimmingClass.category', function ($q) {
            $q->where('slug', 'belajar');
        })->with(['student.package', 'location', 'coach']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('coach', function($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                })->orWhereHas('student', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $attendances = $query->orderBy('date')
            ->orderBy('created_at')
            ->paginate(5)
            ->withQueryString();

        return view('admin.attendances.belajar', compact('attendances'));
    }

    /**
     * Tampilkan riwayat absensi untuk Admin (Kelas Prestasi)
     */
    public function prestasi(Request $request)
    {
        $query = Attendance::whereHas('student.swimmingClass.category', function ($q) {
            $q->where('slug', 'prestasi');
        })->with(['student', 'location', 'coach']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('coach', function($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                })->orWhereHas('student', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });
            });
        }

        $attendances = $query->orderBy('date')
            ->orderBy('created_at')
            ->paginate(5)
            ->withQueryString();

        // Hitung ini sesi ke-berapa untuk atlet tersebut
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

        return view('admin.attendances.prestasi', compact('attendances'));
    }
}
