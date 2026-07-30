<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\CoachLeave;
use App\Models\Schedule;
use App\Models\User;
use App\Notifications\CoachLeaveSubmitted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Tampilkan riwayat izin pelatih.
     */
    public function index()
    {
        $leaves = CoachLeave::where('coach_id', Auth::id())
            ->with(['substituteCoach', 'schedule.swimmingClass.category', 'schedule.location'])
            ->orderBy('leave_date', 'desc')
            ->paginate(10);

        return view('coach.leaves.index', compact('leaves'));
    }

    /**
     * Endpoint API JSON untuk mengambil jadwal mengajar coach di tanggal tertentu.
     */
    public function getSchedulesByDate(Request $request)
    {
        $dateStr = $request->query('date');
        if (!$dateStr) {
            return response()->json([]);
        }

        try {
            $date = Carbon::parse($dateStr);
            $carbonDay = $date->dayOfWeek; // 0=Sunday, 1=Monday...
            $dayOfWeek = $carbonDay === 0 ? 6 : $carbonDay - 1; // 0=Monday ... 6=Sunday

            $schedules = Schedule::where('coach_id', Auth::id())
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', true)
                ->with(['swimmingClass.category', 'location'])
                ->get()
                ->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'class_name' => $s->swimmingClass->name ?? 'Kelas Renang',
                        'category' => $s->swimmingClass->category->name ?? 'Regular',
                        'location' => $s->location->name ?? 'Kolam',
                        'time_range' => $s->time_range,
                    ];
                });

            return response()->json($schedules);
        } catch (\Exception $e) {
            return response()->json([], 400);
        }
    }

    /**
     * Simpan pengajuan izin baru (bisa per-sesi/jadwal atau semua sesi).
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_date' => 'required|date|after_or_equal:today',
            'schedules' => 'required|array|min:1',
            'schedules.*' => 'required',
            'reason' => 'required|string|max:1000',
        ], [
            'leave_date.required' => 'Tanggal izin wajib diisi.',
            'leave_date.date' => 'Format tanggal tidak valid.',
            'leave_date.after_or_equal' => 'Tanggal izin minimal hari ini.',
            'schedules.required' => 'Silakan pilih sesi/jadwal latihan yang ingin diizinkan.',
            'schedules.min' => 'Pilih minimal satu sesi latihan.',
            'reason.required' => 'Alasan izin wajib diisi.',
            'reason.max' => 'Alasan izin maksimal 1000 karakter.',
        ]);

        $leaveDate = $request->leave_date;
        $rawSchedules = $request->schedules; // array of schedule_id or ['all'] or mix
        $reason = $request->reason;
        $createdCount = 0;

        // Jika ada ID jadwal spesifik (numeric), utamakan ID tersebut dan abaikan fallback 'all'
        $numericScheduleIds = array_values(array_filter($rawSchedules, function($val) {
            return is_numeric($val);
        }));

        $selectedSchedules = count($numericScheduleIds) > 0 ? $numericScheduleIds : $rawSchedules;

        foreach ($selectedSchedules as $schedId) {
            $targetScheduleId = ($schedId === 'all' || $schedId === '') ? null : $schedId;

            // Cek jika sudah mengajukan izin untuk sesi & tanggal tersebut
            $exists = CoachLeave::where('coach_id', Auth::id())
                ->where('leave_date', $leaveDate)
                ->where('schedule_id', $targetScheduleId)
                ->exists();

            if (!$exists) {
                $leave = CoachLeave::create([
                    'coach_id' => Auth::id(),
                    'schedule_id' => $targetScheduleId,
                    'leave_date' => $leaveDate,
                    'reason' => $reason,
                    'status' => 'pending',
                ]);

                // Kirim notifikasi ke Admin Operasional
                $admins = User::whereIn('role', ['admin_operasional', 'admin_finance', 'admin'])->get();
                foreach ($admins as $admin) {
                    $admin->notify(new CoachLeaveSubmitted($leave, Auth::user()->name));
                }

                $createdCount++;
            }
        }

        if ($createdCount === 0) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengajukan izin untuk sesi/jadwal pada tanggal tersebut.')
                ->withInput();
        }

        return redirect()->route('coach.leaves.index')
            ->with('success', 'Pengajuan izin berhasil dikirim! Menunggu persetujuan admin.');
    }
}
