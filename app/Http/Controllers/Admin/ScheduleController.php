<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SwimmingClass;
use App\Models\Location;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // 1. Tampilkan Semua Jadwal & Form Tambah/Edit
    public function index(Request $request)
    {
        $locationId = $request->get('location_id');
        $coachName = $request->get('coach_name');
        
        $query = Schedule::with(['swimmingClass.category', 'location', 'coach'])
            ->orderBy('day_of_week')
            ->orderBy('start_time');
            
        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        if ($coachName) {
            $query->whereHas('coach', function($q) use ($coachName) {
                $q->where('name', 'like', '%' . $coachName . '%');
            });
        }
        
        $schedules = $query->paginate(5)->withQueryString();
        $swimmingClasses = SwimmingClass::where('is_active', true)->get();
        $locations = Location::all();
        $coaches = \App\Models\User::where('role', 'coach')->oldest()->get();

        return view('admin.schedules.index', compact('schedules', 'swimmingClasses', 'locations', 'locationId', 'coaches'));
    }

    // 2. Simpan Jadwal Baru
    public function store(Request $request)
    {
        $request->validate([
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'location_id' => 'required|exists:locations,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'session_type' => 'required|in:swim,dryland',
            'coach_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string|max:255',
        ]);

        Schedule::create([
            'swimming_class_id' => $request->swimming_class_id,
            'location_id' => $request->location_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'session_type' => $request->session_type,
            'coach_id' => $request->coach_id,
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal latihan berhasil ditambahkan!');
    }

    // 3. Simpan Perubahan Jadwal (Update)
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'location_id' => 'required|exists:locations,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'session_type' => 'required|in:swim,dryland',
            'coach_id' => 'nullable|exists:users,id',
            'is_active' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ]);

        // Clean time formats (to remove seconds if they are present in request)
        $schedule->update([
            'swimming_class_id' => $request->swimming_class_id,
            'location_id' => $request->location_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'session_type' => $request->session_type,
            'coach_id' => $request->coach_id,
            'is_active' => $request->is_active,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal latihan berhasil diperbarui!');
    }

    // 4. Hapus Jadwal
    public function destroy(Schedule $schedule)
    {
        // Cek apakah ada murid terdaftar di jadwal ini
        if ($schedule->students()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Jadwal ini masih memiliki murid yang terdaftar.');
        }

        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal latihan berhasil dihapus!');
    }
}
