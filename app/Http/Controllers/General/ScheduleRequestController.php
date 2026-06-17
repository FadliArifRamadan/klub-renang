<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ScheduleChangeRequest;
use App\Models\User;
use App\Notifications\ScheduleRequestSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ScheduleRequestController extends Controller
{
    /**
     * Simpan pengajuan pindah jadwal baru (dari General)
     */
    public function store(Request $request, Student $student)
    {
        // Validasi kepemilikan murid
        if ($student->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Cek apakah ada request pending
        $exists = ScheduleChangeRequest::where('student_id', $student->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pengajuan pindah jadwal yang sedang ditinjau.');
        }

        // Validasi input
        $request->validate([
            'schedule_ids'   => 'required|array|min:1',
            'schedule_ids.*' => 'required|integer|exists:schedules,id',
            'reason'         => 'required|string|max:1000',
        ]);

        // Simpan request
        ScheduleChangeRequest::create([
            'student_id'       => $student->id,
            'user_id'          => auth()->id(),
            'old_schedule_ids' => $student->schedules->pluck('id')->toArray(),
            'new_schedule_ids' => $request->schedule_ids,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        // Kirim notifikasi ke Admin
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new ScheduleRequestSubmitted($student->name, auth()->user()->name));

        return redirect()->route('general.dashboard')->with('success', 'Pengajuan pindah jadwal berhasil dikirim! Menunggu persetujuan Admin.');
    }
}
