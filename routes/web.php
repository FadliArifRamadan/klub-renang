<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CompanyProfileController;

Route::get('/', [CompanyProfileController::class, 'home'])->name('welcome');
Route::get('/tentang-kami', [CompanyProfileController::class, 'about'])->name('about');
Route::get('/program-paket', [CompanyProfileController::class, 'packages'])->name('packages');
Route::get('/kolam-latihan', [CompanyProfileController::class, 'locations'])->name('locations');
Route::get('/jadwal-latihan', [CompanyProfileController::class, 'schedule'])->name('schedule');
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
        $role = $request->user()->role;
        return redirect()->route($role . '.dashboard');
    })->name('dashboard');

    // 1. KELOMPOK ROUTE ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
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
        Route::resource('coaches', \App\Http\Controllers\Admin\CoachController::class)->except(['create', 'show', 'edit']);
        Route::resource('swimming-classes', \App\Http\Controllers\Admin\SwimmingClassController::class)->except(['create', 'show', 'edit']);
        Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class)->except(['create', 'show', 'edit']);

        // Kelola Murid (RESTful URI & Nama Plural)
        Route::get('/students', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
        Route::post('/students/suspend/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'suspend'])->name('students.suspend');
        Route::post('/students/resume/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'resume'])->name('students.resume');

        // Kelola Verifikasi Pembayaran (Nama Plural RESTful)
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/approve/{student_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.approve');
        Route::post('/payments/reject/{payment_id}', [\App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
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

            // Ambil data murid yang dilatih oleh coach ini
            $students = \App\Models\Student::where('coach_id', $user->id)
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
        Route::get('/attendances', [\App\Http\Controllers\Coach\AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/attendances/create', [\App\Http\Controllers\Coach\AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/attendances', [\App\Http\Controllers\Coach\AttendanceController::class, 'store'])->name('attendances.store');

        // Catat & Pantau Perkembangan Murid
        Route::get('/progress', [\App\Http\Controllers\Coach\ProgressReportController::class, 'index'])->name('progress.index');
        Route::post('/progress', [\App\Http\Controllers\Coach\ProgressReportController::class, 'store'])->name('progress.store');
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
            $children = $user->children()->with(['progressReports' => function ($q) {
                $q->oldest('date');
            }, 'location', 'secondaryLocation', 'coach', 'package', 'swimmingClass.category', 'schedules.location'])->oldest('name')->get();

            // Ambil anak yang sesinya baru saja habis (inactive & quota habis)
            $expiredStudents = $user->children()
                ->where('status', 'inactive')
                ->where('quota_left', '<=', 0)
                ->with(['package', 'swimmingClass'])
                ->get();

            $packages = \App\Models\Package::with('locationPrices')->oldest()->get();
            $locations = \App\Models\Location::oldest()->get();

            return view('parent.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'children', 'expiredStudents', 'packages', 'locations'));
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
                ->with(['progressReports' => function ($q) {
                    $q->oldest('date');
                }, 'location', 'secondaryLocation', 'coach', 'package', 'swimmingClass.category', 'schedules.location'])
                ->first();

            // Ambil murid yang sesinya baru saja habis (inactive & quota habis)
            $expiredStudents = \App\Models\Student::where('user_id', $user->id)
                ->where('status', 'inactive')
                ->where('quota_left', '<=', 0)
                ->with(['package', 'swimmingClass'])
                ->get();

            $packages = \App\Models\Package::with('locationPrices')->oldest()->get();
            $locations = \App\Models\Location::oldest()->get();

            return view('general.dashboard', compact('totalStudents', 'totalCoaches', 'totalLocations', 'myStudent', 'expiredStudents', 'packages', 'locations'));
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
    });
});

require __DIR__ . '/auth.php';
