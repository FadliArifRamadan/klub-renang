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
        $students = Student::where('coach_id', Auth::id())
            ->where('status', 'active')
            ->whereHas('swimmingClass.category', function ($q) {
                $q->where('slug', 'belajar');
            })
            ->with(['location', 'package', 'schedules', 'attendances'])
            ->oldest('name')
            ->get();

        return view('coach.attendances.belajar.create', compact('students'));
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

        $coachId = Auth::id();

        try {
            DB::transaction(function () use ($request, $coachId) {
                foreach ($request->student_ids as $studentId) {
                    $student = Student::findOrFail($studentId);

                    if ($student->coach_id == $coachId) {
                        Attendance::create([
                            'student_id' => $student->id,
                            'coach_id' => $coachId,
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
        $students = Student::where('coach_id', Auth::id())
            ->where('status', 'active')
            ->whereHas('swimmingClass.category', function ($q) {
                $q->where('slug', 'prestasi');
            })
            ->with(['location', 'package', 'schedules', 'attendances'])
            ->oldest('name')
            ->get();

        return view('coach.attendances.prestasi.create', compact('students'));
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

        $coachId = Auth::id();

        try {
            DB::transaction(function () use ($request, $coachId) {
                foreach ($request->student_ids as $studentId) {
                    $student = Student::findOrFail($studentId);

                    if ($student->coach_id == $coachId) {
                        $sessionType = $request->session_type;
                        if ($sessionType === 'swim' && $student->swim_sessions_left <= 0) {
                            throw new \Exception("Kuota sesi berenang untuk {$student->name} sudah habis.");
                        } elseif ($sessionType === 'dryland' && $student->dryland_sessions_left <= 0) {
                            throw new \Exception("Kuota sesi latihan darat untuk {$student->name} sudah habis.");
                        }

                        Attendance::create([
                            'student_id' => $student->id,
                            'coach_id' => $coachId,
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
