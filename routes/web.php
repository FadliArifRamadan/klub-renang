<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CompanyProfileController;

Route::get('/', [CompanyProfileController::class, 'home'])->name('welcome');

Route::get('/tentang-kami', function () {
    return redirect()->route('about.vision-mission');
})->name('about');

Route::get('/tentang-kami/visi-misi', [CompanyProfileController::class, 'aboutVisionMission'])->name('about.vision-mission');
Route::get('/tentang-kami/sejarah', [CompanyProfileController::class, 'aboutHistory'])->name('about.history');
Route::get('/tentang-kami/tim-pelatih', [CompanyProfileController::class, 'aboutCoaches'])->name('about.coaches');
Route::get('/program-paket', function () {
    return redirect()->route('packages.belajar.level', 'batita');
})->name('packages');

Route::get('/program-paket/belajar', function () {
    return redirect()->route('packages.belajar.level', 'batita');
})->name('packages.belajar');

Route::get('/program-paket/belajar/{slug}', [CompanyProfileController::class, 'packagesBelajarLevel'])->name('packages.belajar.level');
Route::get('/program-paket/prestasi', [CompanyProfileController::class, 'packagesPrestasi'])->name('packages.prestasi');
Route::get('/kolam-latihan', [CompanyProfileController::class, 'locations'])->name('locations');

Route::get('/jadwal-latihan', function () {
    return redirect()->route('schedule.belajar.level', 'batita');
})->name('schedule');

Route::get('/jadwal-latihan/belajar', function () {
    return redirect()->route('schedule.belajar.level', 'batita');
})->name('schedule.belajar');

Route::get('/jadwal-latihan/belajar/{slug}', [CompanyProfileController::class, 'scheduleBelajarLevel'])->name('schedule.belajar.level');
Route::get('/jadwal-latihan/prestasi', [CompanyProfileController::class, 'schedulePrestasi'])->name('schedule.prestasi');
Route::get('/kontak-kami', [CompanyProfileController::class, 'contact'])->name('contact');

// Route khusus yang sudah LOGIN
Route::middleware('auth')->group(function () {

    // Halaman Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Notifikasi (bisa diakses semua role)
    Route::post('/notifications/{id}/read', function (string $id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $link = $notification->data['link'] ?? null;
        return $link ? redirect($link) : redirect()->back();
    })->name('notifications.read');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    })->name('notifications.read-all');

    // Jembatan Rute /dashboard Sentral berdasarkan Role
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route($user->role . '.dashboard');
    })->name('dashboard');

    // 1. KELOMPOK ROUTE ADMIN (Finance & Operasional)
    Route::middleware('role:admin,admin_finance,admin_operasional')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            // Jalankan pengecekan paket kedaluwarsa secara otomatis
            \App\Models\Student::checkAndExpirePackages();

            $totalStudents = \App\Models\Student::count();
            $totalCoaches = \App\Models\User::where('role', 'coach')->count();
            $totalLocations = \App\Models\Location::count();
            $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();

            // Ambil data murid beserta data coach dan progress report terurut tanggal
            $students = \App\Models\Student::with(['progressReports' => function ($query) {
                $query->oldest('date');
            }, 'location', 'coach', 'package'])->oldest('name')->get();

            return view('admin.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'pendingPayments', 'students'));
        })->name('dashboard');

        // Menggunakan Resource routes / RESTful convention
        Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class)->except(['create', 'show', 'edit']);
        Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class)->except(['create', 'show', 'edit']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'show', 'edit']);
        Route::resource('swimming-classes', \App\Http\Controllers\Admin\SwimmingClassController::class)->except(['create', 'show', 'edit']);
        Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class)->except(['create', 'show', 'edit']);

        // Kelola Izin Pelatih
        Route::get('/leaves', [\App\Http\Controllers\Admin\LeaveController::class, 'index'])->name('leaves.index');
        Route::post('/leaves/approve/{id}', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('/leaves/reject/{id}', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])->name('leaves.reject');

        // Kelola Reschedule Murid
        Route::get('/reschedule', [\App\Http\Controllers\Admin\RescheduleController::class, 'index'])->name('reschedule.index');
        Route::post('/reschedule/{id}', [\App\Http\Controllers\Admin\RescheduleController::class, 'process'])->name('reschedule.process');

        // Kelola Murid (RESTful URI & Nama Plural)
        Route::get('/students', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
        Route::post('/students/activate/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'activate'])->name('students.activate');
        Route::post('/students/suspend/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'suspend'])->name('students.suspend');
        Route::post('/students/resume/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'resume'])->name('students.resume');
        Route::delete('/students/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('students.destroy');

        // Kelola Verifikasi Pembayaran (Nama Plural RESTful)
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/approve/{student_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.approve');
        Route::post('/payments/reject/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');

        // Pengajuan Pindah Jadwal Murid
        Route::get('/schedule-requests', [\App\Http\Controllers\Admin\ScheduleRequestController::class, 'index'])->name('schedule-requests.index');
        Route::post('/schedule-requests/approve/{id}', [\App\Http\Controllers\Admin\ScheduleRequestController::class, 'approve'])->name('schedule-requests.approve');
        Route::post('/schedule-requests/reject/{id}', [\App\Http\Controllers\Admin\ScheduleRequestController::class, 'reject'])->name('schedule-requests.reject');

        // Riwayat Absensi Seluruh Coach
        Route::get('/attendances/belajar', [\App\Http\Controllers\Admin\AttendanceController::class, 'belajar'])->name('attendances.belajar');
        Route::get('/attendances/prestasi', [\App\Http\Controllers\Admin\AttendanceController::class, 'prestasi'])->name('attendances.prestasi');
    });

    // 2. KELOMPOK ROUTE COACH
    Route::middleware('role:coach')->prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            // Jalankan pengecekan paket kedaluwarsa secara otomatis
            \App\Models\Student::checkAndExpirePackages();

            $user = $request->user();

            $totalStudents = \App\Models\Student::count();
            $totalCoaches = \App\Models\User::where('role', 'coach')->count();
            $totalLocations = \App\Models\Location::count();

            // Ambil data murid yang dilatih oleh coach ini (sebagai pelatih utama maupun pendamping di jadwal)
            $students = \App\Models\Student::where(function($query) use ($user) {
                    $query->where('coach_id', $user->id)
                        ->orWhereHas('schedules', function($q) use ($user) {
                            $q->where('coach_id', $user->id);
                        });
                })
                ->where('status', 'active')
                ->with(['progressReports' => function ($query) {
                    $query->oldest('date');
                }, 'location', 'coach', 'package'])
                ->oldest('name')
                ->get();

            return view('coach.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'students'));
        })->name('dashboard');

        // Data murid yang dilatih oleh coach ini
        Route::get('/students', [\App\Http\Controllers\Coach\StudentController::class, 'index'])->name('students.index');

        // Absensi Murid
        Route::get('/attendances/belajar', [\App\Http\Controllers\Coach\AttendanceController::class, 'belajarIndex'])->name('attendances.belajar.index');
        Route::get('/attendances/belajar/create', [\App\Http\Controllers\Coach\AttendanceController::class, 'createBelajar'])->name('attendances.belajar.create');
        Route::post('/attendances/belajar', [\App\Http\Controllers\Coach\AttendanceController::class, 'storeBelajar'])->name('attendances.belajar.store');

        Route::get('/attendances/prestasi', [\App\Http\Controllers\Coach\AttendanceController::class, 'prestasiIndex'])->name('attendances.prestasi.index');
        Route::get('/attendances/prestasi/create', [\App\Http\Controllers\Coach\AttendanceController::class, 'createPrestasi'])->name('attendances.prestasi.create');
        Route::post('/attendances/prestasi', [\App\Http\Controllers\Coach\AttendanceController::class, 'storePrestasi'])->name('attendances.prestasi.store');

        // Catat & Pantau Perkembangan Murid
        Route::get('/progress', [\App\Http\Controllers\Coach\ProgressReportController::class, 'index'])->name('progress.index');
        Route::post('/progress', [\App\Http\Controllers\Coach\ProgressReportController::class, 'store'])->name('progress.store');

        // Izin Latihan Pelatih
        Route::get('/leaves', [\App\Http\Controllers\Coach\LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/leaves/schedules-by-date', [\App\Http\Controllers\Coach\LeaveController::class, 'getSchedulesByDate'])->name('leaves.schedules-by-date');
        Route::post('/leaves', [\App\Http\Controllers\Coach\LeaveController::class, 'store'])->name('leaves.store');
    });

    // 3. KELOMPOK ROUTE PARENT (ORANG TUA)
    Route::middleware('role:parent')->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            // Jalankan pengecekan paket kedaluwarsa secara otomatis
            \App\Models\Student::checkAndExpirePackages();

            $user = $request->user();

            $totalStudents = \App\Models\Student::count();
            $totalCoaches  = \App\Models\User::where('role', 'coach')->count();
            $totalLocations = \App\Models\Location::count();

            // Ambil data anak dari parent ini, beserta progress reports-nya
            $children = $user->children()->with([
                'progressReports' => function ($q) { $q->oldest('date'); },
                'location',
                'secondaryLocation',
                'coach',
                'package',
                'swimmingClass.category',
                'schedules.location',
                'scheduleChangeRequests' => function ($q) { $q->latest(); }
            ])->oldest('name')->get();

            // Ambil anak yang sesinya baru saja habis (inactive & quota habis)
            $expiredStudents = $user->children()
                ->where('status', 'inactive')
                ->where('quota_left', '<=', 0)
                ->with(['package', 'swimmingClass'])
                ->get();

            $packages = \App\Models\Package::with('locationPrices')->oldest()->get();
            $locations = \App\Models\Location::oldest()->get();
            $schedules = \App\Models\Schedule::with(['location', 'coach'])->where('is_active', true)->get();
            $schedules->each(function ($sched) {
                $sched->current_enrolled_count = $sched->getCurrentEnrolledCount();
                $sched->coach_name = $sched->coach->name ?? 'Belum Ditentukan';
            });

            $activeLeaves = \App\Models\CoachLeave::where('status', 'approved')
                ->where('leave_date', '>=', now()->startOfDay())
                ->with(['coach', 'substituteCoach'])
                ->get();

            $rescheduleQueues = \App\Models\RescheduleQueue::whereIn('student_id', $children->pluck('id'))
                ->with([
                    'student',
                    'schedule.swimmingClass',
                    'schedule.location',
                    'schedule.coach',
                    'coachLeave.coach',
                    'rescheduledSchedule.location',
                    'rescheduledSchedule.coach'
                ])
                ->latest()
                ->get();

            return view('parent.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'children', 'expiredStudents', 'packages', 'locations', 'schedules', 'activeLeaves', 'rescheduleQueues'));
        })->name('dashboard');

        // Rute untuk melihat daftar anak (RESTful URI)
        Route::get('/students', [\App\Http\Controllers\Parents\StudentController::class, 'index'])->name('students.index');

        // Rute untuk form pendaftaran anak (RESTful URI)
        Route::get('/students/create', [\App\Http\Controllers\Parents\StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [\App\Http\Controllers\Parents\StudentController::class, 'store'])->name('students.store');
        Route::post('/students/renew/{student}', [\App\Http\Controllers\Parents\StudentController::class, 'renew'])->name('students.renew');

        // Rute pembayaran parent (Nama Plural RESTful)
        Route::get('/payments', [\App\Http\Controllers\Parents\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/checkout/{student_id}', [\App\Http\Controllers\Parents\PaymentController::class, 'checkout'])->name('payments.checkout');

        // Riwayat Absensi Anak
        Route::get('/attendances', [\App\Http\Controllers\Parents\AttendanceController::class, 'index'])->name('attendances.index');

        // Pengajuan Pindah Jadwal Anak
        Route::post('/schedule-requests/store/{student}', [\App\Http\Controllers\Parents\ScheduleRequestController::class, 'store'])->name('schedule-requests.store');
    });

    // 4. KELOMPOK ROUTE GENERAL (UMUM)
    Route::middleware('role:general')->prefix('general')->name('general.')->group(function () {
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            // Jalankan pengecekan paket kedaluwarsa secara otomatis
            \App\Models\Student::checkAndExpirePackages();

            $user = $request->user();

            $totalStudents  = \App\Models\Student::count();
            $totalCoaches   = \App\Models\User::where('role', 'coach')->count();
            $totalLocations = \App\Models\Location::count();

            // Ambil data murid milik akun general ini (hanya 1), beserta progress reports-nya
            $myStudent = \App\Models\Student::where('user_id', $user->id)
                ->with([
                    'progressReports' => function ($q) { $q->oldest('date'); },
                    'location',
                    'secondaryLocation',
                    'coach',
                    'package',
                    'swimmingClass.category',
                    'schedules.location',
                    'scheduleChangeRequests' => function ($q) { $q->latest(); }
                ])->first();

            // Ambil murid yang sesinya baru saja habis (inactive & quota habis)
            $expiredStudents = \App\Models\Student::where('user_id', $user->id)
                ->where('status', 'inactive')
                ->where('quota_left', '<=', 0)
                ->with(['package', 'swimmingClass'])
                ->get();

            $packages = \App\Models\Package::with('locationPrices')->oldest()->get();
            $locations = \App\Models\Location::oldest()->get();
            $schedules = \App\Models\Schedule::with(['location', 'coach'])
                ->where('is_active', true)
                ->when($myStudent, function ($q) use ($myStudent) {
                    return $q->where('swimming_class_id', $myStudent->swimming_class_id);
                })
                ->get();
            $schedules->each(function ($sched) {
                $sched->current_enrolled_count = $sched->getCurrentEnrolledCount();
                $sched->coach_name = $sched->coach->name ?? 'Belum Ditentukan';
            });

            $activeLeaves = \App\Models\CoachLeave::where('status', 'approved')
                ->where('leave_date', '>=', now()->startOfDay())
                ->with(['coach', 'substituteCoach'])
                ->get();

            $rescheduleQueues = $myStudent
                ? \App\Models\RescheduleQueue::where('student_id', $myStudent->id)
                    ->with([
                        'student',
                        'schedule.swimmingClass',
                        'schedule.location',
                        'schedule.coach',
                        'coachLeave.coach',
                        'rescheduledSchedule.location',
                        'rescheduledSchedule.coach'
                    ])
                    ->latest()
                    ->get()
                : collect();

            return view('general.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'myStudent', 'expiredStudents', 'packages', 'locations', 'schedules', 'activeLeaves', 'rescheduleQueues'));
        })->name('dashboard');
        Route::get('/students', [\App\Http\Controllers\General\StudentController::class, 'index'])->name('students.index');
        // Routes for General user to register a package (single registration)
        Route::get('/students/create', [\App\Http\Controllers\General\StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [\App\Http\Controllers\General\StudentController::class, 'store'])->name('students.store');
        Route::post('/students/renew/{student}', [\App\Http\Controllers\General\StudentController::class, 'renew'])->name('students.renew');

        // Rute pembayaran general (Nama Plural RESTful)
        Route::get('/payments', [\App\Http\Controllers\General\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/checkout/{student_id}', [\App\Http\Controllers\General\PaymentController::class, 'checkout'])->name('payments.checkout');

        // Riwayat Absensi
        Route::get('/attendances', [\App\Http\Controllers\General\AttendanceController::class, 'index'])->name('attendances.index');

        // Pengajuan Pindah Jadwal Mandiri
        Route::post('/schedule-requests/store/{student}', [\App\Http\Controllers\General\ScheduleRequestController::class, 'store'])->name('schedule-requests.store');
    });
});

require __DIR__ . '/auth.php';
