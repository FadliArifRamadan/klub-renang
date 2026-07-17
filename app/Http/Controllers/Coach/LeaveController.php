<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\CoachLeave;
use App\Models\User;
use App\Notifications\CoachLeaveSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Tampilkan riwayat izin pelatih.
     */
    public function index()
    {
        $leaves = CoachLeave::where('coach_id', Auth::id())
            ->with('substituteCoach')
            ->orderBy('leave_date', 'desc')
            ->paginate(5);

        return view('coach.leaves.index', compact('leaves'));
    }

    /**
     * Simpan pengajuan izin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_date' => 'required|date|after_or_equal:today',
            'reason' => 'required|string|max:1000',
        ], [
            'leave_date.required' => 'Tanggal izin wajib diisi.',
            'leave_date.date' => 'Format tanggal tidak valid.',
            'leave_date.after_or_equal' => 'Tanggal izin minimal hari ini.',
            'reason.required' => 'Alasan izin wajib diisi.',
            'reason.max' => 'Alasan izin maksimal 1000 karakter.',
        ]);

        // Cek jika sudah mengajukan izin di tanggal tersebut
        $exists = CoachLeave::where('coach_id', Auth::id())
            ->where('leave_date', $request->leave_date)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengajukan izin untuk tanggal tersebut.')
                ->withInput();
        }

        $leave = CoachLeave::create([
            'coach_id' => Auth::id(),
            'leave_date' => $request->leave_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Kirim notifikasi ke semua Admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CoachLeaveSubmitted($leave, Auth::user()->name));
        }

        return redirect()->route('coach.leaves.index')
            ->with('success', 'Pengajuan izin berhasil dikirim! Menunggu persetujuan admin.');
    }
}
