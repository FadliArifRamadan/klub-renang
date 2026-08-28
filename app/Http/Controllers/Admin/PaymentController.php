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
     * Menampilkan daftar ajuan pembayaran masuk dan riwayat transaksi ke Admin Finance
     */
    public function index(Request $request)
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $activeTab = $request->get('tab', 'pending');

        // 1. Data Payment Pending (Menunggu Verifikasi)
        $pendingPayments = Payment::where('status', 'pending')
            ->with(['student.user', 'student.coach', 'student.package', 'student.schedules.location'])
            ->oldest()
            ->paginate(15, ['*'], 'pending_page');

        // 2. Data Riwayat Payment (History: Approved & Rejected)
        $historyQuery = Payment::whereIn('status', ['approved', 'rejected'])
            ->with(['student.user', 'student.coach', 'student.package', 'student.schedules.location']);

        if ($request->filled('search')) {
            $search = $request->search;
            $historyQuery->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($uq) use ($search) {
                                $uq->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($request->filled('history_status')) {
            $historyQuery->where('status', $request->history_status);
        }

        if ($request->filled('month')) {
            $historyQuery->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $historyQuery->whereYear('created_at', $request->year);
        }

        $historyPayments = $historyQuery->latest('updated_at')->paginate(15, ['*'], 'history_page');

        // Ambil daftar Coach
        $coaches = User::where('role', 'coach')->oldest('name')->get();

        return view('admin.payments.index', compact('pendingPayments', 'historyPayments', 'coaches', 'activeTab'));
    }

    /**
     * Proses Verifikasi oleh Admin (Klik Setujui)
     */
    public function verify(Request $request, int $student_id)
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $student = Student::findOrFail($student_id);
        $package = $student->package;

        // Bungkus dalam transaksi database untuk menjamin integritas data ganda
        DB::transaction(function () use ($student, $package) {
            $student->update([
                'status'   => 'pending_activation',
                'quota_left' => $package ? $package->sessions : 0,
                'registration_fee_paid' => true,
                'package_activated_at' => null,
                'package_expires_at' => null,
                'became_inactive_at' => null,
                'suspended_at' => null,
                'suspension_reason' => null,
            ]);

            // Update status di tabel payments milik anak ini menjadi 'approved'
            $payment = Payment::where('student_id', $student->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($payment) {
                $payment->update(['status' => 'approved']);
            }
        });

        $chosen_coach = User::find($student->coach_id);

        // Kirim notifikasi ke pemilik akun (General atau Parent)
        $owner = User::find($student->user_id);
        if ($owner) {
            $owner->notify(new PaymentApproved($student->name, $chosen_coach->name ?? 'Admin'));
            if ($owner->phone) {
                $msg = "Halo Bapak/Ibu {$owner->name},\n\nPembayaran untuk murid *{$student->name}* telah berhasil diverifikasi oleh Admin Finance.\n\nStatus murid saat ini: *Menunggu Konfirmasi Tanggal Mulai Latihan* oleh Admin Operasional. Terima kasih! 🏊";
                \App\Services\WhatsappService::send($owner->phone, $msg);
            }
        }

        // Kirim notifikasi ke Admin Operasional
        $opsAdmins = User::whereIn('role', ['admin_operasional', 'admin'])->get();
        foreach ($opsAdmins as $ops) {
            $ops->notify(new \App\Notifications\PaymentApproved($student->name, $chosen_coach->name ?? 'Admin'));
        }

        return redirect()->back()->with('success', "Pembayaran untuk {$student->name} berhasil diverifikasi. Status murid kini Menunggu Aktivasi Tanggal Latihan oleh Admin Operasional.");
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
