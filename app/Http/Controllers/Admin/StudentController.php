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
        $coaches = User::where('role', 'coach')->oldest('name')->get();

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
        $student->resume();

        return redirect()->back()->with('success', "Paket latihan {$student->name} berhasil diaktifkan kembali.");
    }
}
