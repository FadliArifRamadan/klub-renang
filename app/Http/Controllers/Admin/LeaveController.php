<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachLeave;
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

        $query = CoachLeave::with(['coach', 'substituteCoach'])
            ->orderBy('leave_date', 'desc');

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $leaves = $query->paginate(5)->withQueryString();

        // Ambil semua pelatih untuk pilihan manual
        $allCoaches = User::where('role', 'coach')->orderBy('name')->get();

        // Ambil pemetaan coach ke kategori kelas yang mereka ajar (dari seluruh jadwal aktif)
        $coachCategoryMap = DB::table('schedules')
            ->join('swimming_classes', 'schedules.swimming_class_id', '=', 'swimming_classes.id')
            ->join('class_categories', 'swimming_classes.class_category_id', '=', 'class_categories.id')
            ->where('schedules.is_active', true)
            ->whereNotNull('schedules.coach_id')
            ->select('schedules.coach_id', 'class_categories.slug')
            ->get();

        foreach ($leaves as $leave) {
            if ($leave->status === 'pending') {
                $leaveDate = $leave->leave_date;
                $carbonDayOfWeek = $leaveDate->dayOfWeek; // 0=Sunday, 1=Monday ...
                $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1; // 0=Monday ... 6=Sunday

                $schedules = Schedule::where('coach_id', $leave->coach_id)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_active', true)
                    ->with('swimmingClass.category')
                    ->get();

                $leave->schedules = $schedules;

                $leavingCategories = $schedules->map(function($s) {
                    return $s->swimmingClass->category->slug ?? null;
                })->filter()->unique()->toArray();

                $substitutes = User::where('role', 'coach')
                    ->where('id', '!=', $leave->coach_id)
                    ->orderBy('name')
                    ->get();

                $coachCategoryMap = [];
                foreach ($substitutes as $coach) {
                    $cats = Schedule::where('coach_id', $coach->id)
                        ->where('is_active', true)
                        ->join('swimming_classes', 'schedules.swimming_class_id', '=', 'swimming_classes.id')
                        ->join('class_categories', 'swimming_classes.class_category_id', '=', 'class_categories.id')
                        ->pluck('class_categories.slug')
                        ->unique()
                        ->toArray();

                    $coachCategoryMap[$coach->id] = $cats;
                }

                $leave->recommended_coaches = $substitutes->filter(function($coach) use ($coachCategoryMap, $leavingCategories) {
                    $cCats = $coachCategoryMap[$coach->id] ?? [];
                    return count(array_intersect($leavingCategories, $cCats)) > 0;
                });

                $dayCoaches = User::where('role', 'coach')
                    ->where('id', '!=', $leave->coach_id)
                    ->whereHas('schedules', function($q) use ($dayOfWeek) {
                        $q->where('day_of_week', $dayOfWeek)->where('is_active', true);
                    })->get();

                $leave->day_coaches = $dayCoaches->filter(function($coach) use ($coachCategoryMap, $leavingCategories) {
                    $cCats = $coachCategoryMap[$coach->id] ?? [];
                    return count(array_intersect($leavingCategories, $cCats)) > 0;
                });
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
            
            // Dapatkan hari latihan (Monday=0 ... Sunday=6)
            $leaveDate = $leave->leave_date;
            $carbonDayOfWeek = $leaveDate->dayOfWeek;
            $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;

            $schedules = Schedule::where('coach_id', $leave->coach_id)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', true)
                ->get();

            $leavingCategories = $schedules->map(function($s) {
                return $s->swimmingClass->category->slug ?? null;
            })->filter()->unique()->toArray();

            // Kategori kelas yang diampu oleh pelatih pengganti (dari seluruh jadwal aktifnya)
            $subCategories = Schedule::where('coach_id', $subId)
                ->where('is_active', true)
                ->join('swimming_classes', 'schedules.swimming_class_id', '=', 'swimming_classes.id')
                ->join('class_categories', 'swimming_classes.class_category_id', '=', 'class_categories.id')
                ->pluck('class_categories.slug')
                ->unique()
                ->toArray();

            $hasMatch = count(array_intersect($leavingCategories, $subCategories)) > 0;
            if (!$hasMatch && count($leavingCategories) > 0) {
                return redirect()->back()->with('error', 'Pelatih pengganti yang dipilih tidak mengajar kategori kelas yang sama (Belajar/Prestasi) dengan jadwal pelatih yang izin.');
            }
        }

        $leave->update([
            'status' => 'approved',
            'substitute_coach_id' => $request->substitute_coach_id ?: null,
        ]);

        // Jika tidak ada pelatih pengganti (Sesi diliburkan), masukkan semua murid pada jadwal pelatih ini ke Antrean Reschedule
        if (!$request->substitute_coach_id) {
            $leaveDate = $leave->leave_date;
            $carbonDayOfWeek = $leaveDate->dayOfWeek;
            $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;

            $schedules = Schedule::with(['students', 'swimmingClass'])
                ->where('coach_id', $leave->coach_id)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', true)
                ->get();

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

        // Kirim notifikasi ke coach yang izin
        $leave->load(['coach', 'substituteCoach']);
        if ($leave->coach) {
            $leave->coach->notify(new CoachLeaveApproved($leave));
        }

        $subtext = $request->substitute_coach_id ? ' dengan pelatih pengganti' : ' dan sesi latihan diliburkan (masuk antrean reschedule)';
        return redirect()->route('admin.leaves.index')->with('success', 'Izin pelatih berhasil disetujui' . $subtext . '!');
    }

    /**
     * Tolak pengajuan izin pelatih.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        $leave = CoachLeave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $leave->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Kirim notifikasi ke coach yang izin
        $leave->load('coach');
        if ($leave->coach) {
            $leave->coach->notify(new CoachLeaveRejected($leave));
        }

        return redirect()->route('admin.leaves.index')->with('success', 'Izin pelatih telah ditolak!');
    }
}
