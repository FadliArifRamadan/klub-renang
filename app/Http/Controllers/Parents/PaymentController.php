<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar tagihan di halaman Parent
     */
    public function index()
    {
        // Ambil data anak milik parent yang sedang login beserta relasi payments (eager loaded)
        // Eager load package dan latestPayment untuk menghilangkan N+1 query
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $students = $user->children()
            ->with(['package', 'latestPayment'])
            ->latest()
            ->get();

        return view('parent.payments.index', compact('students'));
    }

    /**
     * Proses simulasikan klik "Konfirmasi Bayar" oleh Parent
     */
    public function checkout(Request $request, int $student_id)
    {
        $student = Student::findOrFail($student_id);

        // Validasi input file wajib berupa gambar dan maksimal 2MB
        $request->validate([
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek jika masih ada ajuan pending
        $pendingPayment = Payment::where('student_id', $student->id)->where('status', 'pending')->first();
        if ($pendingPayment) {
            return redirect()->back()->with('error', 'Konfirmasi pembayaran sebelumnya sedang dicek oleh Admin.');
        }

        // Proses upload file menggunakan Laravel Storage Abstraction (disk 'public')
        $imageName = 'bukti_transfer_default.jpg';
        if ($request->hasFile('receipt_image')) {
            $file = $request->file('receipt_image');
            $imageName = 'receipt_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Menyimpan di storage/app/public/receipts/
            $file->storeAs('receipts', $imageName, 'public');
        }

        // Simpan atau perbarui data ke tabel payments
        Payment::updateOrCreate(
            ['student_id' => $student->id],
            [
                'amount'       => $student->package->price ?? 0,
                'receipt_path' => $imageName,
                'status'       => 'pending'
            ]
        );

        return redirect()->back()->with('success', 'Bukti transaksi berhasil diunggah! Menunggu verifikasi Admin.');
    }
}
