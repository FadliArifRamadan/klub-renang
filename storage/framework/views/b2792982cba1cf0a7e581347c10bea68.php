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

        <!-- Dynamic Schedules Area -->
        <div x-data="{ activeTab: 'belajar' }">
            <!-- Tabs Header -->
            <div class="flex justify-center mb-16">
                <div class="inline-flex p-1.5 bg-slate-200/60 backdrop-blur rounded-2xl border border-slate-200">
                    <button @click="activeTab = 'belajar'"
                        :class="activeTab === 'belajar' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:text-blue-650'"
                        class="px-6 py-2.5 rounded-xl text-sm font-extrabold transition-all duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-person-swimming"></i> Kelas Belajar Renang
                    </button>
                    <button @click="activeTab = 'prestasi'"
                        :class="activeTab === 'prestasi' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:text-blue-655'"
                        class="px-6 py-2.5 rounded-xl text-sm font-extrabold transition-all duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-trophy"></i> Kelas Renang Prestasi
                    </button>
                </div>
            </div>

            <!-- Tab Belajar -->
            <div x-show="activeTab === 'belajar'" x-transition class="space-y-12">
                <?php
                    $belajarCat = $classCategories->firstWhere('slug', 'belajar');
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                ?>
                <?php if($belajarCat && $belajarCat->swimmingClasses->isNotEmpty()): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <?php $__currentLoopData = $belajarCat->swimmingClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-left flex flex-col justify-between hover:shadow-md transition-all">
                                <div>
                                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-5">
                                        <h3 class="font-extrabold text-lg flex items-center justify-between">
                                            <span>Kelas <?php echo e($class->name); ?></span>
                                            <span class="text-xs bg-white/20 border border-white/30 text-white px-3 py-1 rounded-full font-semibold">
                                                Usia <?php echo e($class->age_min); ?><?php echo e($class->age_max ? '-' . $class->age_max : '+'); ?> thn
                                            </span>
                                        </h3>
                                        <p class="text-xs text-blue-100 mt-1 font-semibold"><?php echo e($class->description); ?></p>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <?php
                                            $sortedSchedules = $class->schedules->sortBy('day_of_week');
                                        ?>
                                        <?php if($sortedSchedules->isNotEmpty()): ?>
                                            <?php $__currentLoopData = $sortedSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center justify-between p-4 bg-slate-55/40 hover:bg-slate-50 rounded-2xl border border-slate-100 transition-colors">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                                            <i class="fa-solid fa-clock"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-800">
                                                                <?php echo e($days[$sched->day_of_week] ?? 'Hari Lain'); ?>

                                                            </p>
                                                            <p class="text-xs text-slate-500 font-semibold">
                                                                <?php echo e(substr($sched->start_time, 0, 5)); ?> – <?php echo e(substr($sched->end_time, 0, 5)); ?> WIB
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="inline-block text-[10px] bg-cyan-50 border border-cyan-100 text-cyan-700 font-bold px-2 py-0.5 rounded-full mb-1">
                                                            <?php echo e($sched->session_type === 'dryland' ? 'Dryland' : 'Berenang'); ?>

                                                        </span>
                                                        <p class="text-[10px] text-slate-450 font-bold flex items-center gap-1 justify-end">
                                                            <i class="fa-solid fa-location-dot"></i> <?php echo e($sched->location->name ?? 'Kolam Renang'); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="text-center py-6 text-slate-400">
                                                <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-slate-300"></i>
                                                <p class="text-xs font-semibold">Jadwal latihan belum diatur.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm mb-12">
                        <i class="fa-solid fa-calendar text-5xl mb-4 text-slate-300"></i>
                        <p class="font-bold text-slate-500 text-lg mb-2">Jadwal Belajar Renang Belum Tersedia</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tab Prestasi -->
            <div x-show="activeTab === 'prestasi'" x-transition class="space-y-12" style="display: none;">
                <?php
                    $prestasiCat = $classCategories->firstWhere('slug', 'prestasi');
                ?>
                <?php if($prestasiCat && $prestasiCat->swimmingClasses->isNotEmpty()): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <?php $__currentLoopData = $prestasiCat->swimmingClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-left flex flex-col justify-between hover:shadow-md transition-all">
                                <div>
                                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-5">
                                        <h3 class="font-extrabold text-lg flex items-center justify-between">
                                            <span>Kelas <?php echo e($class->name); ?></span>
                                            <span class="text-xs bg-white/20 border border-white/30 text-white px-3 py-1 rounded-full font-semibold">
                                                Usia <?php echo e($class->age_min); ?><?php echo e($class->age_max ? '-' . $class->age_max : '+'); ?> thn
                                            </span>
                                        </h3>
                                        <p class="text-xs text-indigo-100 mt-1 font-semibold"><?php echo e($class->description); ?></p>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <?php
                                            $sortedSchedules = $class->schedules->sortBy('day_of_week');
                                        ?>
                                        <?php if($sortedSchedules->isNotEmpty()): ?>
                                            <?php $__currentLoopData = $sortedSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center justify-between p-4 bg-slate-55/40 hover:bg-slate-50 rounded-2xl border border-slate-100 transition-colors">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-650 flex items-center justify-center font-bold text-sm">
                                                            <i class="fa-solid fa-clock"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-800">
                                                                <?php echo e($days[$sched->day_of_week] ?? 'Hari Lain'); ?>

                                                            </p>
                                                            <p class="text-xs text-slate-500 font-semibold">
                                                                <?php echo e(substr($sched->start_time, 0, 5)); ?> – <?php echo e(substr($sched->end_time, 0, 5)); ?> WIB
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="inline-block text-[10px] <?php echo e($sched->session_type === 'dryland' ? 'bg-orange-55 border border-orange-100 text-orange-700' : 'bg-cyan-55 border border-cyan-100 text-cyan-700'); ?> font-bold px-2 py-0.5 rounded-full mb-1">
                                                            <?php echo e($sched->session_type === 'dryland' ? 'Dryland' : 'Berenang'); ?>

                                                        </span>
                                                        <p class="text-[10px] text-slate-450 font-bold flex items-center gap-1 justify-end">
                                                            <i class="fa-solid fa-location-dot"></i> <?php echo e($sched->location->name ?? 'Kolam Renang'); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="text-center py-6 text-slate-400">
                                                <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-slate-300"></i>
                                                <p class="text-xs font-semibold">Jadwal latihan belum diatur.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm mb-12">
                        <i class="fa-solid fa-calendar text-5xl mb-4 text-slate-300"></i>
                        <p class="font-bold text-slate-500 text-lg mb-2">Jadwal Prestasi Belum Tersedia</p>
                    </div>
                <?php endif; ?>
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