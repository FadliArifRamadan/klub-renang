<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Tampilkan riwayat absensi murid (Belajar)
     */
    public function belajarIndex()
    {
        $attendances = Attendance::where('coach_id', Auth::id())
            ->whereHas('student.swimmingClass.category', function ($q) {
                $q->where('slug', 'belajar');
            })
            ->with(['student.package', 'location'])
            ->orderBy('date')
            ->orderBy('created_at')
            ->paginate(5);

        return view('coach.attendances.belajar.index', compact('attendances'));
    }

    /**
     * Tampilkan form input absensi (Belajar)
     */
    public function createBelajar()
    {
        $today = date('Y-m-d');
        // Cari coach mana saja yang sedang diwakili hari ini
        $substituteCoachIds = \App\Models\CoachLeave::where('status', 'approved')
            ->where('leave_date', $today)
            ->where('substitute_coach_id', Auth::id())
            ->pluck('coach_id')
            ->toArray();

        $coachIds = array_merge([Auth::id()], $substituteCoachIds);

        $students = Student::where(function($query) use ($coachIds) {
                $query->whereIn('coach_id', $coachIds)
                    ->orWhereHas('schedules', function($q) use ($coachIds) {
                        $q->whereIn('coach_id', $coachIds);
                    });
            })
            ->where('status', 'active')
            ->whereHas('swimmingClass.category', function ($q) {
                $q->where('slug', 'belajar');
            })
            ->with(['location', 'package', 'schedules', 'attendances'])
            ->oldest('name')
            ->get();

        return view('coach.attendances.belajar.create', compact('students', 'coachIds'));
    }

    /**
     * Simpan data absensi baru (Belajar)
     */
    public function storeBelajar(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
        ], [
            'date.required' => 'Tanggal latihan wajib diisi.',
            'date.before_or_equal' => 'Tanggal latihan tidak boleh melebihi hari ini.',
            'student_ids.required' => 'Silakan pilih minimal satu murid untuk absen.',
        ]);

        $authCoachId = Auth::id();
        $date = $request->date;

        // Cari coach mana saja yang diwakili pada tanggal terpilih
        $substituteCoachIds = \App\Models\CoachLeave::where('status', 'approved')
            ->where('leave_date', $date)
            ->where('substitute_coach_id', $authCoachId)
            ->pluck('coach_id')
            ->toArray();

        $allowedCoachIds = array_merge([$authCoachId], $substituteCoachIds);

        try {
            DB::transaction(function () use ($request, $authCoachId, $allowedCoachIds) {
                // Konversi hari terpilih (Monday=0 ... Sunday=6)
                $carbonDayOfWeek = \Carbon\Carbon::parse($request->date)->dayOfWeek;
                $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;

                foreach ($request->student_ids as $studentId) {
                    $student = Student::findOrFail($studentId);

                    // Validasi: Harus memiliki jadwal di hari terpilih yang diajar oleh salah satu pelatih yang diizinkan (utama/pendamping/pengganti)
                    $isAllowed = $student->schedules()
                        ->whereIn('coach_id', $allowedCoachIds)
                        ->where('day_of_week', $dayOfWeek)
                        ->exists();

                    if ($isAllowed) {
                        Attendance::create([
                            'student_id' => $student->id,
                            'coach_id' => $authCoachId, // Catat coach pengganti yang mengajar
                            'location_id' => $student->location_id,
                            'session_type' => 'swim', // Default untuk kelas belajar
                            'date' => $request->date,
                        ]);

                        if ($student->quota_left > 0) {
                            $student->decrement('quota_left');

                            $student->refresh();
                            if ($student->quota_left <= 0) {
                                $student->update([
                                    'status' => 'inactive',
                                    'became_inactive_at' => now(),
                                ]);
                            }
                        }
                    }
                }
            });

            return redirect()->route('coach.students.index')
                ->with('success', 'Absensi Kelas Belajar berhasil disimpan dan kuota murid telah diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan riwayat absensi murid (Prestasi)
     */
    public function prestasiIndex()
    {
        $attendances = Attendance::where('coach_id', Auth::id())
            ->whereHas('student.swimmingClass.category', function ($q) {
                $q->where('slug', 'prestasi');
            })
            ->with(['student', 'location'])
            ->orderBy('date')
            ->orderBy('created_at')
            ->paginate(5);
            
        // Hitung sesi ke-n
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

        return view('coach.attendances.prestasi.index', compact('attendances'));
    }

    /**
     * Tampilkan form input absensi (Prestasi)
     */
    public function createPrestasi()
    {
        $today = date('Y-m-d');
        // Cari coach mana saja yang sedang diwakili hari ini
        $substituteCoachIds = \App\Models\CoachLeave::where('status', 'approved')
            ->where('leave_date', $today)
            ->where('substitute_coach_id', Auth::id())
            ->pluck('coach_id')
            ->toArray();

        $coachIds = array_merge([Auth::id()], $substituteCoachIds);

        $students = Student::where(function($query) use ($coachIds) {
                $query->whereIn('coach_id', $coachIds)
                    ->orWhereHas('schedules', function($q) use ($coachIds) {
                        $q->whereIn('coach_id', $coachIds);
                    });
            })
            ->where('status', 'active')
            ->whereHas('swimmingClass.category', function ($q) {
                $q->where('slug', 'prestasi');
            })
            ->with(['location', 'package', 'schedules', 'attendances'])
            ->oldest('name')
            ->get();

        return view('coach.attendances.prestasi.create', compact('students', 'coachIds'));
    }

    /**
     * Simpan data absensi baru (Prestasi)
     */
    public function storePrestasi(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'session_type' => 'required|in:swim,dryland',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
        ], [
            'date.required' => 'Tanggal latihan wajib diisi.',
            'date.before_or_equal' => 'Tanggal latihan tidak boleh melebihi hari ini.',
            'session_type.required' => 'Jenis sesi latihan wajib dipilih.',
            'student_ids.required' => 'Silakan pilih minimal satu atlet untuk absen.',
        ]);

        $authCoachId = Auth::id();
        $date = $request->date;

        // Cari coach mana saja yang diwakili pada tanggal terpilih
        $substituteCoachIds = \App\Models\CoachLeave::where('status', 'approved')
            ->where('leave_date', $date)
            ->where('substitute_coach_id', $authCoachId)
            ->pluck('coach_id')
            ->toArray();

        $allowedCoachIds = array_merge([$authCoachId], $substituteCoachIds);

        try {
            DB::transaction(function () use ($request, $authCoachId, $allowedCoachIds) {
                // Konversi hari terpilih (Monday=0 ... Sunday=6)
                $carbonDayOfWeek = \Carbon\Carbon::parse($request->date)->dayOfWeek;
                $dayOfWeek = $carbonDayOfWeek === 0 ? 6 : $carbonDayOfWeek - 1;

                foreach ($request->student_ids as $studentId) {
                    $student = Student::findOrFail($studentId);

                    // Validasi: Harus memiliki jadwal di hari terpilih yang diajar oleh salah satu pelatih yang diizinkan (utama/pendamping/pengganti)
                    $isAllowed = $student->schedules()
                        ->whereIn('coach_id', $allowedCoachIds)
                        ->where('day_of_week', $dayOfWeek)
                        ->exists();

                    if ($isAllowed) {
                        $sessionType = $request->session_type;
                        if ($sessionType === 'swim' && $student->swim_sessions_left <= 0) {
                            throw new \Exception("Kuota sesi berenang untuk {$student->name} sudah habis.");
                        } elseif ($sessionType === 'dryland' && $student->dryland_sessions_left <= 0) {
                            throw new \Exception("Kuota sesi latihan darat untuk {$student->name} sudah habis.");
                        }

                        Attendance::create([
                            'student_id' => $student->id,
                            'coach_id' => $authCoachId, // Catat coach pengganti yang mengajar
                            'location_id' => $student->location_id,
                            'session_type' => $request->session_type,
                            'date' => $request->date,
                        ]);

                        if ($student->quota_left > 0) {
                            $student->decrement('quota_left');

                            $student->refresh();
                            if ($student->quota_left <= 0) {
                                $student->update([
                                    'status' => 'inactive',
                                    'became_inactive_at' => now(),
                                ]);
                            }
                        }
                    }
                }
            });

            return redirect()->route('coach.students.index')
                ->with('success', 'Absensi Kelas Prestasi berhasil disimpan dan kuota atlet telah diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
