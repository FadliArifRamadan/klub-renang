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
            'date' => 'required|date_format:Y-m',
            'metrics' => 'required|array',
            'notes' => 'nullable|string|max:1000',
        ], [
            'student_id.required' => 'Silakan pilih murid.',
            'date.required' => 'Bulan penilaian wajib diisi.',
            'date.date_format' => 'Format bulan tidak valid.',
            'metrics.required' => 'Data penilaian wajib diisi.',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Keamanan: pastikan murid milik coach yang login
        if ($student->coach_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk mencatat perkembangan murid ini.');
        }

        // Simpan tanggal sebagai tanggal 1 di bulan yang dipilih
        $reportDate = $request->date . '-01';

        $metrics = $request->metrics;

        // Filter out empty metric values for Kondisi Fisik
        if (isset($metrics['Kondisi Fisik'])) {
            $metrics['Kondisi Fisik'] = collect($metrics['Kondisi Fisik'])->filter(function ($value) {
                return $value !== null && $value !== '';
            })->toArray();
            if (empty($metrics['Kondisi Fisik'])) {
                unset($metrics['Kondisi Fisik']);
            }
        }

        // Filter out empty metric values for Sistem Energi
        if (isset($metrics['Sistem Energi'])) {
            $metrics['Sistem Energi'] = collect($metrics['Sistem Energi'])->filter(function ($value) {
                return $value !== null && $value !== '';
            })->toArray();
            if (empty($metrics['Sistem Energi'])) {
                unset($metrics['Sistem Energi']);
            }
        }

        // Process Personal Best Time (now dynamic rows)
        if (isset($metrics['Personal Best Time'])) {
            $pbtRows = [];
            foreach ($metrics['Personal Best Time'] as $row) {
                if (is_array($row) && !empty($row['test_per_bulan'])) {
                    $pbtRows[] = [
                        'gaya' => $row['gaya'] ?? 'Gaya Bebas',
                        'jarak' => $row['jarak'] ?? '50m',
                        'test_per_bulan' => $row['test_per_bulan'],
                        'pbt_event' => !empty($row['pbt_event']) ? $row['pbt_event'] : null
                    ];
                }
            }
            if (!empty($pbtRows)) {
                $metrics['Personal Best Time'] = $pbtRows;
            } else {
                unset($metrics['Personal Best Time']);
            }
        }

        ProgressReport::create([
            'student_id' => $request->student_id,
            'coach_id' => Auth::id(),
            'report_type' => 'structured',
            'date' => $reportDate,
            'metrics' => $metrics,
            'notes' => $request->notes,
        ]);

        return redirect()->route('coach.progress.index')->with('success', 'Catatan perkembangan berhasil ditambahkan.');
    }
}
