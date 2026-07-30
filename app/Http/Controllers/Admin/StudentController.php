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
     * Mengaktifkan paket murid dan menetapkan tanggal mulai latihan (oleh Admin Operasional)
     */
    public function activate(Request $request, Student $student)
    {
        $request->validate([
            'activation_date' => 'required|date',
        ], [
            'activation_date.required' => 'Tanggal mulai latihan wajib diisi.',
            'activation_date.date' => 'Format tanggal mulai latihan tidak valid.',
        ]);

        // Cek apakah pembayaran sudah diverifikasi oleh Admin Finance
        $latestPayment = $student->latestPayment;
        if ($student->status === 'pending' || ($latestPayment && $latestPayment->status !== 'approved')) {
            return redirect()->back()->with('error', "Paket latihan {$student->name} belum bisa diaktifkan karena pembayaran belum diverifikasi oleh Admin Finance.");
        }

        $activationDate = \Carbon\Carbon::parse($request->activation_date)->startOfDay();
        $package = $student->package;
        $isSingleSession = $package && ($package->package_type === 'single_session' || $package->sessions == 1 || ($package->active_period_months ?? 1) == 0);

        if ($isSingleSession) {
            $expiresAt = null;
        } else {
            $activeMonths = $package ? ($package->active_period_months ?? 1) : 1;
            $expiresAt = (clone $activationDate)->addMonths($activeMonths)->endOfDay();
        }

        $student->update([
            'status' => 'active',
            'package_activated_at' => $activationDate,
            'package_expires_at' => $expiresAt,
            'became_inactive_at' => null,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);

        // Kirim Notifikasi Sistem & WA ke Orang Tua / Pemilik Akun Murid
        $parent = $student->user;
        if ($parent) {
            $startDateStr = $activationDate->translatedFormat('d F Y');
            $endDateStr   = $expiresAt ? $expiresAt->translatedFormat('d F Y') : 'Sekali Pertemuan';
            
            // Database & WA Notification
            $parent->notify(new \App\Notifications\StudentActivated(
                $student->name,
                $startDateStr,
                $endDateStr
            ));
        }

        return redirect()->back()->with('success', "Paket latihan {$student->name} berhasil diaktifkan mulai tanggal " . $activationDate->format('d/m/Y') . ".");
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
