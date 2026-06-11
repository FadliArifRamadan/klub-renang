<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\ProgressReport;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressReportController extends Controller
{
    /**
     * Tampilkan halaman catat perkembangan & grafik
     */
    public function index()
    {
        // Mengambil murid aktif coach yang sedang login beserta relasi perkembangan terurut tanggal, kelas, kategori, dan lokasi
        $students = Student::where('coach_id', Auth::id())
            ->where('status', 'active')
            ->with(['progressReports' => function ($query) {
                $query->oldest('date');
            }, 'swimmingClass.category', 'location'])
            ->oldest('name')
            ->get();

        return view('coach.progress.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date|before_or_equal:today',
        ], [
            'student_id.required' => 'Silakan pilih murid.',
            'date.required' => 'Tanggal pengambilan data wajib diisi.',
            'date.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
        ]);

        $student = Student::with('swimmingClass.category')->findOrFail($request->student_id);

        // Keamanan: pastikan murid milik coach yang login
        if ($student->coach_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk mencatat perkembangan murid ini.');
        }

        $classCategory = $student->swimmingClass ? $student->swimmingClass->category : null;
        $isPrestasi = $classCategory && $classCategory->slug === 'prestasi';

        if ($isPrestasi) {
            $request->validate([
                'strength' => 'required|integer|between:1,100',
                'endurance' => 'required|integer|between:1,100',
                'flexibility' => 'required|integer|between:1,100',
                'speed' => 'required|integer|between:1,100',
                'agility' => 'required|integer|between:1,100',
                'notes' => 'nullable|string|max:500',
            ], [
                'strength.required' => 'Nilai kekuatan harus diisi.',
                'strength.between' => 'Kekuatan harus di antara 1 - 100.',
                'endurance.required' => 'Nilai daya tahan harus diisi.',
                'endurance.between' => 'Daya tahan harus di antara 1 - 100.',
                'flexibility.required' => 'Nilai kelenturan harus diisi.',
                'flexibility.between' => 'Kelenturan harus di antara 1 - 100.',
                'speed.required' => 'Nilai kecepatan harus diisi.',
                'speed.between' => 'Kecepatan harus di antara 1 - 100.',
                'agility.required' => 'Nilai kelincahan harus diisi.',
                'agility.between' => 'Kelincahan harus di antara 1 - 100.',
            ]);

            ProgressReport::create([
                'student_id' => $request->student_id,
                'coach_id' => Auth::id(),
                'report_type' => 'structured',
                'date' => $request->date,
                'strength' => $request->strength,
                'endurance' => $request->endurance,
                'flexibility' => $request->flexibility,
                'speed' => $request->speed,
                'agility' => $request->agility,
                'notes' => $request->notes,
            ]);
        } else {
            // Kelas Belajar: free-text progress notes
            $request->validate([
                'notes' => 'required|string|max:500',
            ], [
                'notes.required' => 'Catatan perkembangan (free-text) wajib diisi untuk Kelas Belajar.',
            ]);

            ProgressReport::create([
                'student_id' => $request->student_id,
                'coach_id' => Auth::id(),
                'report_type' => 'freetext',
                'date' => $request->date,
                'strength' => null,
                'endurance' => null,
                'flexibility' => null,
                'speed' => null,
                'agility' => null,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('coach.progress.index')
            ->with('success', 'Catatan perkembangan ' . $student->name . ' berhasil disimpan!');
    }
}
