<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Package;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Show the registration form for a General user.
     */
    public function create()
    {
        // If the user already has a registration, silently redirect to dashboard
        if (Student::where('user_id', Auth::id())->exists()) {
            return redirect()->route('general.dashboard')->with('error', 'Anda sudah terdaftar paket.');
        }

        $locations = Location::oldest()->get();
        $packages   = Package::oldest()->get();
        $coaches    = User::where('role', 'coach')->oldest()->get();

        return view('general.students.create', compact('locations', 'packages', 'coaches'));
    }

    /**
     * Show the list of courses registered by the General user.
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $students = Student::where('user_id', Auth::id())
            ->with(['package', 'coach', 'location', 'latestPayment'])
            ->oldest()
            ->get();

        return view('general.students.index', compact('students'));
    }

    /**
     * Store the registration for a General user.
     */
    public function store(Request $request)
    {
        // Ensure the user has not registered before; if so, silent redirect
        if (Student::where('user_id', Auth::id())->exists()) {
            return redirect()->route('general.dashboard')->with('error', 'Anda sudah terdaftar paket.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'birth_date'  => 'required|date',
            'gender'      => 'required|in:L,P',
            'location_id' => 'required|exists:locations,id',
            'package_id'  => 'required|exists:packages,id',
            'coach_id'    => 'nullable|exists:users,id',
        ]);

        $package = Package::findOrFail($request->package_id);

        Student::create([
            'user_id'      => Auth::id(),
            'name'         => $request->name,
            'birth_date'   => $request->birth_date,
            'gender'       => $request->gender,
            'location_id'  => $request->location_id,
            'package_id'   => $request->package_id,
            'coach_id'     => $request->coach_id,
            'quota_left'   => $package->sessions,
            'status'       => 'pending',
        ]);

        return redirect()->route('general.dashboard')
            ->with('success', 'Pendaftaran paket berhasil!');
    }

    /**
     * Memproses pendaftaran ulang (perpanjangan paket) untuk General user.
     */
    public function renew(Request $request, Student $student)
    {
        // Pastikan student ini milik user yang sedang login
        if ($student->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'location_id' => 'required|exists:locations,id',
            'package_id' => 'required|exists:packages,id',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'receipt_image.required' => 'Bukti transfer wajib diunggah untuk pendaftaran ulang.',
            'receipt_image.image' => 'Bukti transfer harus berupa gambar.',
        ]);

        $package = Package::findOrFail($request->package_id);

        // Upload bukti transfer
        $imageName = 'receipt_default.jpg';
        if ($request->hasFile('receipt_image')) {
            $file = $request->file('receipt_image');
            $imageName = 'receipt_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('receipts', $imageName, 'public');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($student, $request, $package, $imageName) {
            // 1. Update data murid dan ubah status ke pending
            $student->update([
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'location_id' => $request->location_id,
                'package_id' => $request->package_id,
                'status' => 'pending',
            ]);

            // 2. Simpan atau perbarui data ke tabel payments
            \App\Models\Payment::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'amount'       => $package->price ?? 0,
                    'receipt_path' => $imageName,
                    'status'       => 'pending'
                ]
            );
        });

        return redirect()->route('general.dashboard')->with('success', 'Pendaftaran ulang paket Anda berhasil diajukan! Menunggu verifikasi Admin.');
    }
}
