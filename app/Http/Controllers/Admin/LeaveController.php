<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachLeave;
use App\Models\RescheduleQueue;
use App\Models\Schedule;
use App\Models\User;
use App\Notifications\CoachLeaveApproved;
use App\Notifications\CoachLeaveRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    /**
     * Tampilkan daftar pengajuan izin dari pelatih.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $query = CoachLeave::with(['coach', 'substituteCoach', 'schedule.swimmingClass.category', 'schedule.location'])
            ->orderBy('leave_date', 'desc');

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $leaves = $query->paginate(10)->withQueryString();

        // Ambil semua pelatih untuk pilihan manual
        $allCoaches = User::where('role', 'coach')->orderBy('name')->get();

        foreach ($leaves as $leave) {
            if ($leave->status === 'pending') {
                $leaveDate = $leave->leave_date;
                $carbonDayOfWeek = $leaveDate->dayOfWeek; // 0=Sunday, 1=Monday ...
                $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1; // 0=Monday ... 6=Sunday
                $dayName = \Carbon\Carbon::parse($leaveDate)->locale('id')->translatedFormat('l');

                if ($leave->schedule_id) {
                    $targetSchedule = Schedule::with('swimmingClass.category', 'location')->find($leave->schedule_id);
                    $leave->schedules = $targetSchedule ? collect([$targetSchedule]) : collect();
                    
                    if ($targetSchedule && $targetSchedule->swimmingClass) {
                        $targetClassId = $targetSchedule->swimming_class_id;
                        $leave->target_class_name = ($targetSchedule->swimmingClass->category->name ?? 'Kelas') . ' — ' . $targetSchedule->swimmingClass->name;
                        $leave->target_day_name = $dayName;
                        
                        // HANYA pelatih yang mengajar di NAMA KELAS SPESIFIK & HARI YANG SAMA (Same Class + Same Day)
                        $eligibleCoaches = User::where('role', 'coach')
                            ->where('id', '!=', $leave->coach_id)
                            ->whereHas('schedules', function ($q) use ($targetClassId, $dayOfWeek) {
                                $q->where('swimming_class_id', $targetClassId)
                                  ->where('day_of_week', $dayOfWeek)
                                  ->where('is_active', true);
                            })
                            ->orderBy('name')
                            ->get();

                        $leave->eligible_substitutes = $eligibleCoaches;
                    } else {
                        $leave->target_class_name = 'Semua Kelas Hari Ini';
                        $leave->target_day_name = $dayName;
                        $leave->eligible_substitutes = collect();
                    }
                } else {
                    $schedules = Schedule::where('coach_id', $leave->coach_id)
                        ->where('day_of_week', $dayOfWeek)
                        ->where('is_active', true)
                        ->with(['swimmingClass.category', 'location'])
                        ->get();

                    $leave->schedules = $schedules;
                    $leave->target_class_name = 'Semua Sesi Hari Ini';
                    $leave->target_day_name = $dayName;

                    $targetClassIds = $schedules->pluck('swimming_class_id')->filter()->unique()->toArray();

                    if (!empty($targetClassIds)) {
                        $eligibleCoaches = User::where('role', 'coach')
                            ->where('id', '!=', $leave->coach_id)
                            ->whereHas('schedules', function ($q) use ($targetClassIds, $dayOfWeek) {
                                $q->whereIn('swimming_class_id', $targetClassIds)
                                  ->where('day_of_week', $dayOfWeek)
                                  ->where('is_active', true);
                            })
                            ->orderBy('name')
                            ->get();

                        $leave->eligible_substitutes = $eligibleCoaches;
                    } else {
                        $leave->eligible_substitutes = collect();
                    }
                }
            }
        }

        return view('admin.leaves.index', compact('leaves', 'status', 'allCoaches'));
    }

    /**
     * Setujui pengajuan izin pelatih.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'substitute_coach_id' => 'nullable|exists:users,id',
        ]);

        $leave = CoachLeave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        if ($request->substitute_coach_id) {
            $subId = $request->substitute_coach_id;
            $subCoach = User::find($subId);
            $leaveDate = $leave->leave_date;
            $carbonDayOfWeek = $leaveDate->dayOfWeek;
            $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;
            $dayName = \Carbon\Carbon::parse($leaveDate)->locale('id')->translatedFormat('l');

            if ($leave->schedule_id) {
                $targetSchedule = Schedule::with('swimmingClass.category')->find($leave->schedule_id);
                if ($targetSchedule && $targetSchedule->swimmingClass) {
                    $targetClassId = $targetSchedule->swimming_class_id;
                    $targetClassName = ($targetSchedule->swimmingClass->category->name ?? 'Kelas') . ' (' . $targetSchedule->swimmingClass->name . ')';

                    // Pengecekan ketat: Pelatih pengganti HARUS mengajar swimming_class_id yang sama persis DI HARI YANG SAMA
                    $isTeachesClassOnSameDay = Schedule::where('coach_id', $subId)
                        ->where('swimming_class_id', $targetClassId)
                        ->where('day_of_week', $dayOfWeek)
                        ->where('is_active', true)
                        ->exists();

                    if (!$isTeachesClassOnSameDay) {
                        return redirect()->back()->with('error', "Pelatih pengganti ({$subCoach->name}) tidak memiliki jadwal mengajar di {$targetClassName} pada hari {$dayName}. Pelatih pengganti wajib bertugas di hari yang sama.");
                    }
                }
            } else {
                $schedules = Schedule::where('coach_id', $leave->coach_id)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_active', true)
                    ->get();

                $targetClassIds = $schedules->pluck('swimming_class_id')->filter()->unique()->toArray();

                $isTeachesClassOnSameDay = Schedule::where('coach_id', $subId)
                    ->whereIn('swimming_class_id', $targetClassIds)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_active', true)
                    ->exists();

                if (!$isTeachesClassOnSameDay && !empty($targetClassIds)) {
                    return redirect()->back()->with('error', "Pelatih pengganti ({$subCoach->name}) tidak memiliki jadwal mengajar di kelas yang sama pada hari {$dayName}.");
                }
            }
        }

        $leave->update([
            'status' => 'approved',
            'substitute_coach_id' => $request->substitute_coach_id ?: null,
        ]);

        // Jika tidak ada pelatih pengganti (Sesi diliburkan), masukkan murid pada jadwal spesifik ini ke Antrean Reschedule
        if (!$request->substitute_coach_id) {
            $leaveDate = $leave->leave_date;
            $carbonDayOfWeek = $leaveDate->dayOfWeek;
            $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;

            if ($leave->schedule_id) {
                $schedules = Schedule::with(['students', 'swimmingClass'])
                    ->where('id', $leave->schedule_id)
                    ->get();
            } else {
                $schedules = Schedule::with(['students', 'swimmingClass'])
                    ->where('coach_id', $leave->coach_id)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_active', true)
                    ->get();
            }

            foreach ($schedules as $sched) {
                foreach ($sched->students as $student) {
                    RescheduleQueue::firstOrCreate(
                        [
                            'coach_leave_id' => $leave->id,
                            'student_id' => $student->id,
                            'schedule_id' => $sched->id,
                            'original_date' => $leaveDate->format('Y-m-d'),
                        ],
                        [
                            'swimming_class_id' => $sched->swimming_class_id,
                            'status' => 'pending',
                        ]
                    );
                }
            }
        }

        // Kirim notifikasi email/sistem ke Pelatih
        if ($leave->coach) {
            $leave->coach->notify(new CoachLeaveApproved($leave));
        }

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Pengajuan izin pelatih berhasil disetujui.');
    }

    /**
     * Tolak pengajuan izin pelatih.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan izin wajib diisi.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $leave = CoachLeave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $leave->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Kirim notifikasi email/sistem ke Pelatih
        if ($leave->coach) {
            $leave->coach->notify(new CoachLeaveRejected($leave));
        }

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Pengajuan izin pelatih berhasil ditolak.');
    }
}
