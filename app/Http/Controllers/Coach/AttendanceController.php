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
     * Tampilkan form input absensi
     */
    public function create()
    {
        // Ambil murid aktif yang dilatih oleh coach ini
        $students = Student::where('coach_id', Auth::id())
            ->where('status', 'active')
            ->with(['location', 'package'])
            ->oldest('name')
            ->get();

        return view('coach.attendances.create', compact('students'));
    }

    /**
     * Simpan data absensi baru
     */
    public function store(Request $request)
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

                    // Pastikan murid memang dilatih oleh coach ini
                    if ($student->coach_id == $coachId) {
                        // 1. Simpan data absensi
                        Attendance::create([
                            'student_id' => $student->id,
                            'coach_id' => $coachId,
                            'location_id' => $student->location_id,
                            'date' => $request->date,
                        ]);

                        // 2. Kurangi kuota murid jika masih ada
                        if ($student->quota_left > 0) {
                            $student->decrement('quota_left');
                        }
                    }
                }
            });

            return redirect()->route('coach.students.index')
                ->with('success', 'Absensi berhasil disimpan dan kuota murid telah diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage())
                ->withInput();
        }
    }
}
