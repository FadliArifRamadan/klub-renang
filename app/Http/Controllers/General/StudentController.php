<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\Location;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\SwimmingClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $classCategories = ClassCategory::with(['swimmingClasses' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $locations = Location::oldest()->get();
        $packages = Package::with('locationPrices')->oldest()->get();
        $schedules = Schedule::where('is_active', true)->with(['location', 'swimmingClass', 'coach'])->orderBy('day_of_week')->orderBy('start_time')->get();
        $schedules->each(function ($sched) {
            $sched->current_enrolled_count = $sched->getCurrentEnrolledCount();
            $sched->coach_name = $sched->coach->name ?? 'Belum Ditentukan';
        });
        $coaches = User::where('role', 'coach')->oldest()->get();

        return view('general.students.create', compact(
            'classCategories',
            'locations',
            'packages',
            'schedules',
            'coaches'
        ));
    }

    /**
     * Show the list of courses registered by the General user.
     */
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        $students = Student::where('user_id', Auth::id())
            ->with(['package', 'coach', 'location', 'latestPayment', 'swimmingClass.category'])
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
            'name' => 'required|string|max:255|unique:students,name',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'package_id' => 'required|exists:packages,id',
            'location_id' => 'required|exists:locations,id',
            'secondary_location_id' => 'nullable|exists:locations,id|different:location_id',
            'schedule_ids' => 'required|array|min:1',
            'schedule_ids.*' => 'exists:schedules,id',
            'coach_id' => 'nullable|exists:users,id',
        ], [
            'schedule_ids.required' => 'Jadwal latihan wajib dipilih.',
            'schedule_ids.array' => 'Format jadwal latihan tidak valid.',
            'schedule_ids.min' => 'Pilih minimal satu jadwal latihan.',
        ]);

        $package = Package::findOrFail($request->package_id);

        // Validasi Kapasitas Latihan
        foreach ($request->schedule_ids as $scheduleId) {
            $schedule = Schedule::findOrFail($scheduleId);
            $currentEnrolled = $schedule->getCurrentEnrolledCount();
            $limit = $schedule->getCapacityLimitForPackage($package);

            if ($currentEnrolled >= $limit) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['schedule_ids' => 'Jadwal latihan ' . $schedule->day_name . ' ' . $schedule->time_range . ' di ' . $schedule->location->name . ' sudah penuh (Maksimal ' . $limit . ' murid).']);
            }
        }

        $student = DB::transaction(function () use ($request, $package) {
            $student = Student::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'swimming_class_id' => $request->swimming_class_id,
                'location_id' => $request->location_id,
                'secondary_location_id' => $request->secondary_location_id,
                'package_id' => $request->package_id,
                'coach_id' => $request->coach_id,
                'quota_left' => $package->sessions,
                'registration_fee_paid' => false, // Belum pernah bayar pendaftaran
                'status' => 'pending',
            ]);

            // Attach jadwal yang dipilih
            if ($request->schedule_ids) {
                $student->schedules()->attach($request->schedule_ids, ['enrolled_at' => now()]);
            }

            return $student;
        });

        // Kirim WA Konfirmasi Pendaftaran ke Orang Tua
        $parent = Auth::user();
        $msg = "Halo Bapak/Ibu {$parent->name},\n\nPendaftaran diri Anda/anak Anda *{$student->name}* di Black Diamond Swim Academy berhasil disimpan dengan status *Pending*.\n\nSilakan lanjutkan proses dengan melakukan transfer pembayaran biaya pendaftaran/paket dan unggah buktinya melalui menu pembayaran di dashboard orang tua. Terima kasih! 🏊";
        \App\Services\WhatsappService::send($parent->phone, $msg);

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
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'location_id' => 'required|exists:locations,id',
            'secondary_location_id' => 'nullable|exists:locations,id|different:location_id',
            'package_id' => 'required|exists:packages,id',
            'schedule_ids' => 'nullable|array',
            'schedule_ids.*' => 'exists:schedules,id',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'receipt_image.required' => 'Bukti transfer wajib diunggah untuk pendaftaran ulang.',
            'receipt_image.image' => 'Bukti transfer harus berupa gambar.',
        ]);

        $package = Package::findOrFail($request->package_id);

        // Validasi Kapasitas Latihan
        if ($request->schedule_ids) {
            foreach ($request->schedule_ids as $scheduleId) {
                $schedule = Schedule::findOrFail($scheduleId);
                // Hitung murid lain di jadwal ini
                $currentEnrolled = $schedule->students()
                    ->whereIn('students.status', ['active', 'pending'])
                    ->where('students.id', '!=', $student->id)
                    ->count();

                $limit = $schedule->getCapacityLimitForPackage($package);

                if ($currentEnrolled >= $limit) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['schedule_ids' => 'Jadwal latihan ' . $schedule->day_name . ' ' . $schedule->time_range . ' di ' . $schedule->location->name . ' sudah penuh (Maksimal ' . $limit . ' murid).']);
                }
            }
        }

        // Upload bukti transfer
        $imageName = 'receipt_default.jpg';
        if ($request->hasFile('receipt_image')) {
            $file = $request->file('receipt_image');
            $imageName = 'receipt_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('receipts', $imageName, 'public');
        }

        DB::transaction(function () use ($student, $request, $package, $imageName) {
            // 1. Update data murid dan ubah status ke pending
            $student->update([
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'swimming_class_id' => $request->swimming_class_id,
                'location_id' => $request->location_id,
                'secondary_location_id' => $request->secondary_location_id,
                'package_id' => $request->package_id,
                'status' => 'pending',
            ]);

            // Sync jadwal
            if ($request->schedule_ids) {
                $student->schedules()->sync(
                    collect($request->schedule_ids)->mapWithKeys(fn($id) => [$id => ['enrolled_at' => now()]])->toArray()
                );
            }

            // 2. Terapkan aturan 3 bulan: jika inactive > 3 bulan, kenakan biaya daftar lagi
            if ($student->shouldPayRegistrationFee()) {
                $student->update(['registration_fee_paid' => false]);
            }

            // 3. Hitung total tagihan termasuk biaya registrasi jika perlu
            $amount = $student->calculateTotalBillingAmount();

            // 3. Simpan data ke tabel payments
            Payment::create([
                'student_id' => $student->id,
                'payment_type' => $package->package_type === 'monthly_prestasi' ? 'monthly_prestasi' : 'package',
                'amount' => $amount,
                'receipt_path' => $imageName,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('general.dashboard')->with('success', 'Pendaftaran ulang paket Anda berhasil diajukan! Menunggu verifikasi Admin.');
    }
}
