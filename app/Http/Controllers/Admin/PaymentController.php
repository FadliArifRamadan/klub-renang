<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use App\Notifications\PaymentApproved;
use App\Notifications\PaymentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar ajuan pembayaran masuk ke Admin
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Ambil data payment yang statusnya 'pending' beserta relasi student (eager loaded)
        $payments = Payment::where('status', 'pending')
            ->with(['student.coach', 'student.package'])
            ->latest()
            ->get();

        // Ambil daftar Coach (User dengan role coach) beserta jumlah murid aktif mereka
        $coaches = User::where('role', 'coach')
            ->withCount(['students' => function ($query) {
                $query->where('status', 'active');
            }])->get();

        return view('admin.payments.index', compact('payments', 'coaches'));
    }

    /**
     * Proses Verifikasi oleh Admin (Klik Setujui)
     */
    public function verify(Request $request, int $student_id)
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $student = Student::findOrFail($student_id);

        // Validasi input coach_id jika Admin memilih untuk mengganti Coach
        $request->validate([
            'coach_id' => 'required|exists:users,id'
        ]);

        // Cek kuota maksimal pelatih (maksimal 15 murid aktif secara keseluruhan)
        $max_students = 15;
        $chosen_coach = User::findOrFail($request->coach_id);

        $active_students_count = Student::where('coach_id', $request->coach_id)
            ->where('status', 'active')
            ->count();

        if ($active_students_count >= $max_students) {
            return redirect()->back()->with('error', "Gagal memverifikasi! Coach {$chosen_coach->name} sudah mencapai batas maksimal {$max_students} murid aktif.");
        }

        // Hitung batas waktu paket
        $package = $student->package;
        $activeMonths = $package ? $package->active_period_months : 1;
        $packageActivatedAt = now();
        $packageExpiresAt = now()->addMonths($activeMonths);

        // Bungkus dalam transaksi database untuk menjamin integritas data ganda
        DB::transaction(function () use ($student, $request, $package, $packageActivatedAt, $packageExpiresAt) {
            $student->update([
                'coach_id' => $request->coach_id,
                'status'   => 'active',
                'quota_left' => $package ? $package->sessions : 0,
                'registration_fee_paid' => true,
                'package_activated_at' => $packageActivatedAt,
                'package_expires_at' => $packageExpiresAt,
                'became_inactive_at' => null,
                'suspended_at' => null,
                'suspension_reason' => null,
            ]);

            // 2. Update status di tabel payments milik anak ini menjadi 'approved'
            $payment = Payment::where('student_id', $student->id)->latest()->first();
            if ($payment) {
                $payment->update(['status' => 'approved']);
            }
        });

        $chosen_coach = User::find($request->coach_id);

        // Kirim notifikasi ke pemilik akun (General atau Parent)
        $owner = User::find($student->user_id);
        if ($owner) {
            $owner->notify(new PaymentApproved($student->name, $chosen_coach->name ?? 'Admin'));
        }

        return redirect()->back()->with('success', "Pembayaran untuk {$student->name} berhasil diverifikasi dan Coach telah ditetapkan ke {$chosen_coach->name}.");
    }

    /**
     * Proses Penolakan oleh Admin (Klik Tolak)
     */
    public function reject(int $payment_id)
    {
        // Cari data berdasarkan ID Pembayaran
        $payment = Payment::findOrFail($payment_id);

        DB::transaction(function () use ($payment) {
            // 1. Update status di tabel payments menjadi 'rejected'
            $payment->update(['status' => 'rejected']);

            // 2. Ubah status anak di tabel students kembali ke 'pending'
            if ($payment->student) {
                $payment->student->update(['status' => 'pending']);
            }
        });

        // Kirim notifikasi ke pemilik akun (General atau Parent)
        $payment->load('student');
        if ($payment->student) {
            $owner = User::find($payment->student->user_id);
            if ($owner) {
                $owner->notify(new PaymentRejected($payment->student->name));
            }
        }

        return redirect()->back()->with('error', 'Pembayaran telah ditolak. Status ajuan kembali ditangguhkan.');
    }
}
