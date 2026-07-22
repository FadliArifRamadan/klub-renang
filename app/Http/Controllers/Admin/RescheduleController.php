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

        // Ambil semua jadwal aktif untuk dropdown opsi reschedule
        $availableSchedules = Schedule::with(['swimmingClass.category', 'location', 'coach'])
            ->where('is_active', true)
            ->get();

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

        // Pastikan kategori kelas baru cocok dengan kategori kelas asal murid (Belajar vs Prestasi)
        $origCategory = $item->swimmingClass->category->slug ?? null;
        $newCategory = $newSchedule->swimmingClass->category->slug ?? null;

        if ($origCategory && $newCategory && $origCategory !== $newCategory) {
            return redirect()->back()->with('error', 'Kategori kelas tidak cocok! Murid kategori ' . ucfirst($origCategory) . ' tidak bisa dipindahkan ke jadwal kategori ' . ucfirst($newCategory) . '.');
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
                'schedule_id' => $request->rescheduled_schedule_id,
                'coach_id' => $newSchedule->coach_id,
                'status' => 'scheduled',
                'notes' => 'Sesi Reschedule Pengganti (' . $item->original_date->format('d/m/Y') . ') - ' . ($request->notes ?? 'Dijadwalkan oleh Admin'),
            ]
        );

        return redirect()->route('admin.reschedule.index')->with('success', 'Jadwal pengganti untuk ' . $item->student->name . ' berhasil disimpan!');
    }
}
