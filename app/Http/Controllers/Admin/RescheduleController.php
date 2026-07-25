<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\RescheduleQueue;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RescheduleController extends Controller
{
    /**
     * Tampilkan daftar antrean reschedule murid akibat coach izin tanpa pengganti.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');
        $category = $request->input('category', 'all');

        $query = RescheduleQueue::with([
            'student.user',
            'coachLeave.coach',
            'schedule.location',
            'swimmingClass.category',
            'rescheduledSchedule.coach',
            'rescheduledSchedule.location',
            'rescheduledByAdmin'
        ])->orderBy('id', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($category !== 'all') {
            $query->whereHas('swimmingClass.category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $queues = $query->paginate(10)->withQueryString();

        // Ambil semua jadwal aktif dengan appended accessors, kuota terisi, & batas kuota
        $availableSchedules = Schedule::with(['swimmingClass.category', 'location', 'coach'])
            ->where('is_active', true)
            ->get()
            ->each(function ($sched) {
                $sched->append(['day_name', 'time_range']);
                $sched->current_enrolled_count = $sched->getCurrentEnrolledCount();
                $sched->capacity_limit = $sched->swimmingClass->quota ?? 4;
            });

        return view('admin.reschedule.index', compact('queues', 'status', 'category', 'availableSchedules'));
    }

    /**
     * Proses penjadwalan ulang (Reschedule) untuk murid tertentu.
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'rescheduled_date' => 'required|date',
            'rescheduled_schedule_id' => 'required|exists:schedules,id',
            'notes' => 'nullable|string|max:500',
        ], [
            'rescheduled_date.required' => 'Tanggal pengganti wajib diisi.',
            'rescheduled_date.date' => 'Format tanggal pengganti tidak valid.',
            'rescheduled_schedule_id.required' => 'Jadwal sesi pengganti wajib dipilih.',
            'rescheduled_schedule_id.exists' => 'Jadwal sesi pengganti tidak ditemukan.',
        ]);

        $item = RescheduleQueue::with(['student', 'swimmingClass.category'])->findOrFail($id);

        $newSchedule = Schedule::with('swimmingClass.category')->findOrFail($request->rescheduled_schedule_id);

        // Proteksi 1: Tidak boleh memilih jadwal asal yang sedang diliburkan
        if ($item->schedule_id && $item->schedule_id == $newSchedule->id) {
            return redirect()->back()->with('error', 'Gagal: Anda tidak bisa memilih jadwal yang sedang diliburkan sebagai jadwal pengganti.');
        }

        // Proteksi 2: Pastikan nama kelas dan kategori jadwal baru cocok persis dengan kelas asal murid (swimming_class_id)
        if ($item->swimming_class_id && $item->swimming_class_id != $newSchedule->swimming_class_id) {
            $origClassName = ($item->swimmingClass->category->name ?? 'Kelas') . ' — ' . ($item->swimmingClass->name ?? '');
            $newClassName = ($newSchedule->swimmingClass->category->name ?? 'Kelas') . ' — ' . ($newSchedule->swimmingClass->name ?? '');
            return redirect()->back()->with('error', "Jadwal pengganti tidak cocok! Murid terdaftar di '{$origClassName}', tidak dapat di-reschedule ke '{$newClassName}'.");
        }

        // Update record reschedule queue
        $item->update([
            'status' => 'rescheduled',
            'rescheduled_date' => $request->rescheduled_date,
            'rescheduled_schedule_id' => $request->rescheduled_schedule_id,
            'rescheduled_by' => Auth::id(),
            'notes' => $request->notes,
        ]);

        // Buat record absensi/jadwal baru untuk sesi pengganti (agar muncul di daftar presensi coach)
        Attendance::updateOrCreate(
            [
                'student_id' => $item->student_id,
                'date' => $request->rescheduled_date,
            ],
            [
                'coach_id' => $newSchedule->coach_id ?? Auth::id(),
                'location_id' => $newSchedule->location_id ?? $item->student->location_id,
                'session_type' => $newSchedule->session_type ?? 'swim',
            ]
        );

        return redirect()->route('admin.reschedule.index')->with('success', 'Jadwal pengganti untuk ' . $item->student->name . ' berhasil disimpan!');
    }
}
