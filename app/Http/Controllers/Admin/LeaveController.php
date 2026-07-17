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
        $allCoaches = User::where('role', 'coach')->oldest()->get();

        // Ambil pemetaan coach ke kategori kelas yang mereka ajar (dari seluruh jadwal aktif)
        $coachCategoryMap = DB::table('schedules')
            ->join('swimming_classes', 'schedules.swimming_class_id', '=', 'swimming_classes.id')
            ->join('class_categories', 'swimming_classes.class_category_id', '=', 'class_categories.id')
            ->where('schedules.is_active', true)
            ->whereNotNull('schedules.coach_id')
            ->select('schedules.coach_id', 'class_categories.slug')
            ->get()
            ->groupBy('coach_id')
            ->map(function($items) {
                return $items->pluck('slug')->unique()->toArray();
            })
            ->toArray();

        // Cari pelatih pengganti yang direkomendasikan & bertugas di hari yang sama untuk setiap izin pending
        foreach ($leaves as $leave) {
            if ($leave->status === 'pending') {
                $leaveDate = $leave->leave_date;
                $carbonDayOfWeek = $leaveDate->dayOfWeek; // 0=Sunday, 1=Monday ...
                $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1; // Konversi ke Monday=0 ... Sunday=6

                // Ambil semua jadwal yang diampu oleh pelatih ini di hari tersebut
                $schedules = Schedule::where('coach_id', $leave->coach_id)
                    ->where('day_of_week', $dayOfWeek)
                    ->where('is_active', true)
                    ->get();

                $leave->schedules = $schedules;

                // Kategori jadwal yang ditinggalkan oleh pelatih ini di hari tersebut
                $leavingCategories = $schedules->map(function($s) {
                    return $s->swimmingClass->category->slug ?? null;
                })->filter()->unique()->toArray();

                // Cari pelatih lain yang terjadwal di lokasi, hari, dan jam yang sama
                $substitutes = collect();
                foreach ($schedules as $sched) {
                    $otherCoaches = Schedule::where('location_id', $sched->location_id)
                        ->where('day_of_week', $sched->day_of_week)
                        ->where('start_time', $sched->start_time)
                        ->where('end_time', $sched->end_time)
                        ->where('coach_id', '!=', $leave->coach_id)
                        ->whereNotNull('coach_id')
                        ->where('is_active', true)
                        ->with('coach')
                        ->get()
                        ->pluck('coach');

                    $substitutes = $substitutes->merge($otherCoaches);
                }

                // Filter rekomendasi: hanya pelatih yang mengajar kategori kelas yang sama
                $leave->recommended_coaches = $substitutes->filter(function($coach) use ($coachCategoryMap, $leavingCategories) {
                    $subCategories = $coachCategoryMap[$coach->id] ?? [];
                    return count(array_intersect($leavingCategories, $subCategories)) > 0;
                })->unique('id');

                // Cari pelatih lain yang bertugas di hari yang sama (tapi lokasi/jam boleh berbeda)
                $dayCoaches = Schedule::where('day_of_week', $dayOfWeek)
                    ->where('coach_id', '!=', $leave->coach_id)
                    ->whereNotNull('coach_id')
                    ->where('is_active', true)
                    ->with('coach')
                    ->get()
                    ->pluck('coach');

                // Filter pelatih hari yang sama: hanya pelatih yang mengajar kategori kelas yang sama
                $leave->day_coaches = $dayCoaches->filter(function($coach) use ($coachCategoryMap, $leavingCategories) {
                    $subCategories = $coachCategoryMap[$coach->id] ?? [];
                    return count(array_intersect($leavingCategories, $subCategories)) > 0;
                })->unique('id');
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

        // Kirim notifikasi ke coach yang izin
        $leave->load(['coach', 'substituteCoach']);
        if ($leave->coach) {
            $leave->coach->notify(new CoachLeaveApproved($leave));
        }

        $subtext = $request->substitute_coach_id ? ' dengan pelatih pengganti' : ' dan sesi latihan diliburkan';
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
