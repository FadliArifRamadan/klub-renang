<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduleChangeRequest;
use App\Notifications\ScheduleRequestApproved;
use App\Notifications\ScheduleRequestRejected;
use Illuminate\Http\Request;

class ScheduleRequestController extends Controller
{
    /**
     * Tampilkan daftar pengajuan pindah jadwal
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $query = ScheduleChangeRequest::with([
            'student.swimmingClass',
            'student.location',
            'student.secondaryLocation',
            'user',
            'processor'
        ]);

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $requests = $query->oldest()->paginate(5)->withQueryString();

        return view('admin.schedule-requests.index', compact('requests', 'status'));
    }

    /**
     * Setujui pengajuan pindah jadwal
     */
    public function approve(Request $request, $id)
    {
        $scheduleRequest = ScheduleChangeRequest::findOrFail($id);

        if ($scheduleRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $student = $scheduleRequest->student;
        $package = $student->package;

        // Validasi Kapasitas pada Jadwal Baru
        foreach ($scheduleRequest->new_schedule_ids as $scheduleId) {
            $schedule = \App\Models\Schedule::findOrFail($scheduleId);
            $currentEnrolled = $schedule->students()
                ->whereIn('students.status', ['active', 'pending'])
                ->where('students.id', '!=', $student->id)
                ->count();

            $limit = $schedule->getCapacityLimitForPackage($package);

            if ($currentEnrolled >= $limit) {
                return redirect()->back()->with('error', 'Gagal menyetujui! Jadwal latihan ' . $schedule->day_name . ' ' . $schedule->time_range . ' di ' . $schedule->location->name . ' sudah penuh (Maksimal ' . $limit . ' murid).');
            }
        }

        // Lakukan sinkronisasi jadwal baru pada pivot table student_schedules
        $student->schedules()->sync($scheduleRequest->new_schedule_ids);

        // Update lokasi otomatis berdasarkan jadwal baru yang dipilih
        // Ambil lokasi-lokasi unik dari jadwal-jadwal baru
        $newLocations = \App\Models\Schedule::whereIn('id', $scheduleRequest->new_schedule_ids)
            ->pluck('location_id')
            ->unique()
            ->values();

        if ($newLocations->isNotEmpty()) {
            $locationUpdates = [];
            $locationUpdates['location_id'] = $newLocations->first();
            
            // Jika ada lebih dari satu lokasi jadwal yang dipilih, set lokasi kedua
            if ($newLocations->count() > 1) {
                $locationUpdates['secondary_location_id'] = $newLocations->get(1);
            } else {
                $locationUpdates['secondary_location_id'] = null; // Kosongkan lokasi kedua
            }
            
            $student->update($locationUpdates);
        }

        // Update status pengajuan
        $scheduleRequest->update([
            'status'       => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        // Kirim notifikasi ke pembuat pengajuan
        $scheduleRequest->user->notify(new ScheduleRequestApproved($student->name));

        return redirect()->back()->with('success', 'Pengajuan pindah jadwal berhasil disetujui!');
    }

    /**
     * Tolak pengajuan pindah jadwal
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $scheduleRequest = ScheduleChangeRequest::findOrFail($id);

        if ($scheduleRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        // Update status pengajuan
        $scheduleRequest->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'processed_by'     => auth()->id(),
            'processed_at'     => now(),
        ]);

        // Kirim notifikasi ke pembuat pengajuan
        $scheduleRequest->user->notify(new ScheduleRequestRejected($scheduleRequest->student->name, $request->rejection_reason));

        return redirect()->back()->with('success', 'Pengajuan pindah jadwal berhasil ditolak.');
    }
}
