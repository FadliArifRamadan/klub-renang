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
    public function index(Request $request)
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $search = trim($request->input('search'));

        $query = Student::with(['coach', 'package', 'swimmingClass.category', 'latestPayment', 'schedules.location', 'user'])->oldest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('coach', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Ambil semua data murid beserta data coach (pelatih), paket, kelas, dan jadwalnya
        $students = $query->paginate(5)->withQueryString();

        // Ambil semua data Coach untuk modal alokasi pelatih
        $coaches = User::where('role', 'coach')->oldest('name')->get();

        return view('admin.students.index', compact('students', 'coaches', 'search'));
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

    /**
     * Menghapus data murid secara permanen
     */
    public function destroy(Student $student)
    {
        $studentName = $student->name;
        $student->delete();

        return redirect()->back()->with('success', "Data murid {$studentName} berhasil dihapus dari sistem.");
    }
}
