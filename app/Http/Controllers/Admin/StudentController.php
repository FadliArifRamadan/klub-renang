<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Menampilkan semua data murid yang mendaftar di sisi Admin
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Ambil semua data murid beserta data coach (pelatih), paket, kelas, dan jadwalnya
        $students = Student::with(['coach', 'package', 'swimmingClass.category', 'latestPayment', 'schedules.location'])->oldest()->paginate(5);

        // Ambil semua data Coach untuk modal alokasi pelatih
        $coaches = User::where('role', 'coach')
            ->withCount(['students' => function ($query) {
                $query->where('status', 'active');
            }])->get();

        return view('admin.students.index', compact('students', 'coaches'));
    }

    /**
     * Membekukan sementara paket murid (karena sakit / ijin)
     */
    public function suspend(Request $request, Student $student)
    {
        $request->validate([
            'reason' => 'required|in:ijin,sakit'
        ], [
            'reason.required' => 'Alasan pemberhentian sementara wajib dipilih.',
            'reason.in' => 'Alasan pemberhentian sementara tidak valid.'
        ]);

        $student->suspend($request->reason);

        $reasonText = $request->reason === 'sakit' ? 'Sakit' : 'Ijin';

        return redirect()->back()->with('success', "Paket latihan {$student->name} berhasil diberhentikan sementara dengan alasan {$reasonText}.");
    }

    /**
     * Mengaktifkan kembali paket murid, memperpanjang masa aktif, dan mengalokasikan Coach baru
     */
    public function resume(Request $request, Student $student)
    {
        $request->validate([
            'coach_id' => 'required|exists:users,id'
        ], [
            'coach_id.required' => 'Pelatih wajib dipilih untuk mengaktifkan kembali murid.',
            'coach_id.exists' => 'Pelatih yang dipilih tidak valid.'
        ]);

        // Cek kuota maksimal pelatih (maksimal 15 murid aktif secara keseluruhan)
        $max_students = 15;
        $coach = User::findOrFail($request->coach_id);

        $active_students_count = Student::where('coach_id', $request->coach_id)
            ->where('status', 'active')
            ->count();

        if ($active_students_count >= $max_students) {
            return redirect()->back()->with('error', "Gagal mengaktifkan kembali! Coach {$coach->name} sudah mencapai batas maksimal {$max_students} murid aktif.");
        }

        $student->resume($request->coach_id);

        $coachName = User::find($request->coach_id)->name;
        return redirect()->back()->with('success', "Paket latihan {$student->name} berhasil diaktifkan kembali dan Coach ditugaskan ke {$coachName}.");
    }
}
