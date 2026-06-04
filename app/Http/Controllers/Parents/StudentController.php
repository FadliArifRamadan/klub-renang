<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Package;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Mengambil data anak beserta relasi tempat & paket kursusnya menggunakan Eloquent
        // Eager load relasi location, package, coach, dan latestPayment agar tidak terjadi N+1 query
        $students = Student::where('user_id', Auth::id())->with(['package', 'coach', 'location', 'latestPayment'])->oldest()->get();

        return view('parent.students.index', compact('students'));
    }

    // 1. Menampilkan Form Pendaftaran Murid Baru
    public function create()
    {
        // Mengambil semua data master kolam dan paket untuk dropdown
        $locations = Location::oldest()->get();
        $packages = Package::oldest()->get();

        // Mengambil user yang memiliki role 'coach' untuk preferensi pelatih
        $coaches = User::where('role', 'coach')->oldest()->get();

        return view('parent.students.create', compact('locations', 'packages', 'coaches'));
    }

    // 2. Menyimpan Data Pendaftaran Anak ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'location_id' => 'required|exists:locations,id',
            'package_id' => 'required|exists:packages,id',
            'coach_id' => 'nullable|exists:users,id',
        ]);

        // AMBIL DATA PAKET UNTUK MENDAPATKAN JUMLAH SESI LATIHAN
        $package = Package::findOrFail($request->package_id);

        Student::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'location_id' => $request->location_id,
            'package_id' => $request->package_id,
            'coach_id' => $request->coach_id,
            'quota_left' => $package->sessions, // Otomatis terisi sesuai jumlah sesi dari paket yang dipilih!
            'status' => 'pending',
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Pendaftaran anak berhasil disimpan! Silakan cek menu pembayaran.');
    }

    /**
     * Memproses pendaftaran ulang (perpanjangan paket) untuk anak.
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

        return redirect()->route('parent.dashboard')->with('success', 'Pendaftaran ulang untuk ' . $student->name . ' berhasil diajukan! Menunggu verifikasi Admin.');
    }
}
