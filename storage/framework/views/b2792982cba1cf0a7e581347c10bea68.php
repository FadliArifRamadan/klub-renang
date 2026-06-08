<?php $__env->startSection('content'); ?>
    <!-- Page Hero -->
    <section
        class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-calendar-days"></i> Jadwal Latihan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                Jadwal Latihan Renang
            </h1>
            <p class="text-slate-200 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                Pilih jadwal latihan yang paling sesuai dengan kesibukan Anda. Tersedia sesi pagi dan sore dari Senin hingga
                Minggu.
            </p>
        </div>
    </section>

    <!-- Schedule Table Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">JADWAL MINGGUAN</span>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Jadwal Sesi Latihan Reguler</h2>
            <p class="text-slate-500 text-sm">Semua sesi berlangsung di kolam renang mitra yang tersedia. Jadwal dapat
                berubah menyesuaikan kondisi kolam.</p>
        </div>

        <!-- Schedule Cards - Desktop Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <!-- Senin & Kamis -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-calendar-day text-blue-200"></i>
                    <h3 class="font-extrabold text-sm uppercase tracking-wider">Senin & Kamis</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Pagi</p>
                                <p class="text-xs text-slate-400">06:00 – 07:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fa-solid fa-cloud-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Siang</p>
                                <p class="text-xs text-slate-400">10:00 – 11:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-moon text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Sore</p>
                                <p class="text-xs text-slate-400">16:00 – 17:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                </div>
            </div>

            <!-- Selasa & Jumat -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-calendar-day text-indigo-200"></i>
                    <h3 class="font-extrabold text-sm uppercase tracking-wider">Selasa & Jumat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Pagi</p>
                                <p class="text-xs text-slate-400">06:00 – 07:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fa-solid fa-cloud-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Siang</p>
                                <p class="text-xs text-slate-400">10:00 – 11:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-moon text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Sore</p>
                                <p class="text-xs text-slate-400">16:00 – 17:30 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                </div>
            </div>

            <!-- Rabu & Sabtu -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-calendar-day text-emerald-200"></i>
                    <h3 class="font-extrabold text-sm uppercase tracking-wider">Rabu & Sabtu</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Pagi</p>
                                <p class="text-xs text-slate-400">06:00 – 08:00 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-moon text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Sore</p>
                                <p class="text-xs text-slate-400">15:00 – 17:00 WIB</p>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-emerald-100 text-emerald-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                    </div>
                </div>
            </div>

            <!-- Minggu -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-4 flex items-center gap-3">
                    <i class="fa-solid fa-calendar-day text-amber-200"></i>
                    <h3 class="font-extrabold text-sm uppercase tracking-wider">Minggu (Opsional)</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-sun text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Pagi</p>
                                <p class="text-xs text-slate-400">07:00 – 09:00 WIB</p>
                            </div>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full">Request</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-moon text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Sesi Sore</p>
                                <p class="text-xs text-slate-400">15:00 – 17:00 WIB</p>
                            </div>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full">Request</span>
                    </div>
                    <p class="text-xs text-slate-400 italic px-1">* Sesi Minggu tersedia berdasarkan permintaan dan
                        konfirmasi dengan pelatih.</p>
                </div>
            </div>
        </div>

        <!-- Note Box -->
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div>
                <h4 class="font-extrabold text-slate-800 mb-1">Informasi Penting</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Jadwal di atas merupakan jadwal reguler yang tersedia. Waktu latihan spesifik akan dikonfirmasi oleh
                    pelatih yang ditugaskan setelah pendaftaran Anda diverifikasi.
                    Silakan hubungi kami jika Anda membutuhkan penyesuaian jadwal.
                </p>
            </div>
        </div>
    </section>

    <!-- Lokasi per Jadwal Section -->
    <?php if($locations->isNotEmpty()): ?>
        <section class="py-20 bg-slate-100 border-y border-slate-200 mb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4 mt-8">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">LOKASI
                        LATIHAN</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kolam Renang yang Tersedia</h2>
                    <p class="text-slate-500 text-sm">Semua lokasi berikut tersedia untuk dijadikan tempat latihan Anda.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="bg-white rounded-2xl border border-slate-200 p-5 flex items-start gap-4 shadow-sm hover:shadow-md transition-all">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-water text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-sm mb-0.5"><?php echo e($location->name); ?></h3>
                                <p class="text-xs text-slate-400 leading-relaxed"><?php echo e($location->address); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CTA -->
    <section class="py-20 text-center bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white mb-16">
        <div class="max-w-xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Siap Memulai Latihan?</h2>
            <p class="text-white text-sm mb-8">Daftar sekarang dan tim kami akan menghubungi Anda untuk konfirmasi
                jadwal latihan pertama.</p>
            <a href="<?php echo e(route('register')); ?>"
                class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-block">
                Daftar & Mulai Latihan
            </a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-profile', ['title' => 'Jadwal Latihan - Black Diamond Swimming Club'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/company-profile/schedule.blade.php ENDPATH**/ ?>