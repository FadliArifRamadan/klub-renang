<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\Location;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // Jalankan pengecekan paket kedaluwarsa secara otomatis
        Student::checkAndExpirePackages();

        // Mengambil data anak beserta relasi tempat & paket kursusnya menggunakan Eloquent
        // Eager load relasi location, package, coach, dan latestPayment agar tidak terjadi N+1 query
        $students = Student::where('user_id', Auth::id())->with(['package', 'coach', 'location', 'latestPayment', 'swimmingClass.category'])->oldest()->get();

        return view('parent.students.index', compact('students'));
    }

    // 1. Menampilkan Form Pendaftaran Murid Baru
    public function create()
    {
        // Mengambil semua data master untuk dropdown interaktif
        $classCategories = ClassCategory::with(['swimmingClasses' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $locations = Location::oldest()->get();

        // Ambil semua paket beserta relasi harga per lokasi & kelas
        $packages = Package::with('locationPrices')->oldest()->get();

        // Ambil semua jadwal aktif beserta relasi lokasi, kelas & pelatih
        $schedules = Schedule::where('is_active', true)->with(['location', 'swimmingClass', 'coach'])->orderBy('day_of_week')->orderBy('start_time')->get();
        $schedules->each(function ($sched) {
            $sched->current_enrolled_count = $sched->getCurrentEnrolledCount();
            $sched->coach_name = $sched->coach->name ?? 'Belum Ditentukan';
            $sched->coach_gender = $sched->coach->gender ?? null;
        });

        // Mengambil user yang memiliki role 'coach' untuk preferensi pelatih
        $coaches = User::where('role', 'coach')->oldest()->get();

        return view('parent.students.create', compact(
            'classCategories',
            'locations',
            'packages',
            'schedules',
            'coaches'
        ));
    }

    // 2. Menyimpan Data Pendaftaran Anak ke Database
    public function store(Request $request)
    {
        $swimmingClass = \App\Models\SwimmingClass::with('category')->findOrFail($request->swimming_class_id);
        $isPrestasi = ($swimmingClass->category->slug ?? '') === 'prestasi';

        if ($isPrestasi) {
            $prestasiScheduleIds = Schedule::where('swimming_class_id', $swimmingClass->id)
                ->where('is_active', true)
                ->pluck('id')
                ->toArray();
            $request->merge(['schedule_ids' => $prestasiScheduleIds]);
        }

        $rules = [
            'name' => 'required|string|max:255|unique:students,name',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'coach_gender_preference' => 'nullable|in:any,L,P',
            'swimming_class_id' => 'required|exists:swimming_classes,id',
            'package_id' => 'required|exists:packages,id',
            'location_id' => 'required|exists:locations,id',
            'secondary_location_id' => 'nullable|exists:locations,id|different:location_id',
            'schedule_ids' => 'required|array|min:1',
            'schedule_ids.*' => 'exists:schedules,id',
            'coach_id' => 'nullable|exists:users,id',
        ];

        if ($isPrestasi) {
            $rules['family_card_image'] = 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:2048';
            $rules['student_image']     = 'required|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($rules, [
            'schedule_ids.required' => 'Jadwal latihan wajib dipilih.',
            'schedule_ids.array' => 'Format jadwal latihan tidak valid.',
            'schedule_ids.min' => 'Pilih minimal satu jadwal latihan.',
            'family_card_image.required' => 'Foto Kartu Keluarga wajib diunggah untuk Kelas Prestasi.',
            'student_image.required' => 'Foto Murid wajib diunggah untuk Kelas Prestasi.',
        ]);

        // AMBIL DATA PAKET UNTUK MENDAPATKAN JUMLAH SESI LATIHAN
        $package = Package::findOrFail($request->package_id);

        // Upload files
        $familyCardPath = null;
        $studentImagePath = null;
        if ($request->hasFile('family_card_image')) {
            $familyCardPath = $request->file('family_card_image')->store('documents', 'public');
        }
        if ($request->hasFile('student_image')) {
            $studentImagePath = $request->file('student_image')->store('students', 'public');
        }

        // Validasi Kapasitas Latihan (Skip untuk Prestasi jika alur khusus)
        if (!$isPrestasi) {
            // Memastikan bahwa jadwal yang dipilih oleh user benar-benar jadwal untuk kelas yang didaftarkan
            $invalidSchedules = Schedule::whereIn('id', $request->schedule_ids)
                ->where('swimming_class_id', '!=', $request->swimming_class_id)
                ->exists();

            if ($invalidSchedules) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['schedule_ids' => 'Jadwal yang dipilih tidak sesuai dengan kelas yang didaftarkan.']);
            }

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

            // Validasi kesamaan tarif harga lokasi untuk Paket Regular 8 Sesi
            if (count($request->schedule_ids) > 1 && $package && ($package->sessions == 8 || str_contains(strtolower($package->name), '8 sesi'))) {
                $selectedSchedules = Schedule::whereIn('id', $request->schedule_ids)->get();
                $locationPrices = [];
                foreach ($selectedSchedules as $sched) {
                    $locationPrices[] = $package->getPriceForLocation($sched->location_id);
                }
                if (count(array_unique($locationPrices)) > 1) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['schedule_ids' => 'Untuk Paket Regular 8 Sesi, seluruh lokasi latihan yang dipilih harus memiliki tarif harga paket yang sama.']);
                }
            }
        }

        $student = DB::transaction(function () use ($request, $package, $familyCardPath, $studentImagePath) {
            $student = Student::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'coach_gender_preference' => $request->get('coach_gender_preference', 'any'),
                'parent_phone' => Auth::user()->phone,
                'family_card_image' => $familyCardPath,
                'student_image' => $studentImagePath,
                'swimming_class_id' => $request->swimming_class_id,
                'location_id' => $request->location_id,
                'secondary_location_id' => $request->secondary_location_id,
                'package_id' => $request->package_id,
                'coach_id' => $request->coach_id,
                'quota_left' => $package->sessions,
                'registration_fee_paid' => false, // Pendaftaran baru selalu bayar biaya daftar
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
        $msg = "Halo Bapak/Ibu {$parent->name},\n\nPendaftaran anak Anda *{$student->name}* di Black Diamond Swim Academy berhasil disimpan dengan status *Pending*.\n\nSilakan lanjutkan proses dengan melakukan transfer pembayaran biaya pendaftaran/paket dan unggah buktinya melalui menu pembayaran di dashboard orang tua. Terima kasih! 🏊";
        \App\Services\WhatsappService::send($parent->phone, $msg);

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

        $swimmingClass = \App\Models\SwimmingClass::with('category')->find($request->swimming_class_id);
        $isPrestasi = ($swimmingClass->category->slug ?? '') === 'prestasi';

        if ($isPrestasi && $swimmingClass) {
            $prestasiScheduleIds = Schedule::where('swimming_class_id', $swimmingClass->id)
                ->where('is_active', true)
                ->pluck('id')
                ->toArray();
            $request->merge(['schedule_ids' => $prestasiScheduleIds]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'coach_gender_preference' => 'required|in:any,L,P',
            'family_card_image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'student_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        if ($request->schedule_ids && !$isPrestasi) {
            // Memastikan bahwa jadwal yang dipilih oleh user benar-benar jadwal untuk kelas yang didaftarkan
            $invalidSchedules = Schedule::whereIn('id', $request->schedule_ids)
                ->where('swimming_class_id', '!=', $request->swimming_class_id)
                ->exists();

            if ($invalidSchedules) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['schedule_ids' => 'Jadwal yang dipilih tidak sesuai dengan kelas yang didaftarkan.']);
            }
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

            // Validasi kesamaan tarif harga lokasi untuk Paket Regular 8 Sesi
            if (count($request->schedule_ids) > 1 && $package && ($package->sessions == 8 || str_contains(strtolower($package->name), '8 sesi'))) {
                $selectedSchedules = Schedule::whereIn('id', $request->schedule_ids)->get();
                $locationPrices = [];
                foreach ($selectedSchedules as $sched) {
                    $locationPrices[] = $package->getPriceForLocation($sched->location_id);
                }
                if (count(array_unique($locationPrices)) > 1) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['schedule_ids' => 'Untuk Paket Regular 8 Sesi, seluruh lokasi latihan yang dipilih harus memiliki tarif harga paket yang sama.']);
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
            $updateData = [
                'name' => $request->name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'coach_gender_preference' => $request->coach_gender_preference ?? 'any',
                'swimming_class_id' => $request->swimming_class_id,
                'location_id' => $request->location_id,
                'secondary_location_id' => $request->secondary_location_id,
                'package_id' => $request->package_id,
                'status' => 'pending',
            ];

            if ($request->hasFile('family_card_image')) {
                $file = $request->file('family_card_image');
                $filename = 'kk_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('family_cards', $filename, 'public');
                $updateData['family_card_image'] = $filename;
            }

            if ($request->hasFile('student_image')) {
                $file = $request->file('student_image');
                $filename = 'student_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('student_images', $filename, 'public');
                $updateData['student_image'] = $filename;
            }

            $student->update($updateData);

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
                'student_name' => $student->name,
                'user_name' => Auth::user()->name,
                'package_name' => $package->name ?? '-',
                'payment_type' => $package->package_type === 'monthly_prestasi' ? 'monthly_prestasi' : 'package',
                'amount' => $amount,
                'receipt_path' => $imageName,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('parent.dashboard')->with('success', 'Pendaftaran ulang untuk ' . $student->name . ' berhasil diajukan! Menunggu verifikasi Admin.');
    }
}
