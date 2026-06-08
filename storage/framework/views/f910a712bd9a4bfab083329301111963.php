<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section
        class="relative pt-32 pb-24 md:pt-48 md:pb-40 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-30"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500 rounded-full blur-[120px] opacity-30"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Container -->
                <div class="lg:col-span-7 space-y-6 text-left">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-medal"></i> Klub Renang Terbaik & Profesional
                    </span>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Wujudkan Potensi Terbaik Berenang Anda Bersama Kami
                    </h1>
                    <p class="text-slate-200 text-base sm:text-lg max-w-2xl leading-relaxed">
                        Kami menyediakan pelatihan berenang terstruktur bagi semua tingkatan usia dan kemampuan.
                        Didampingi oleh jajaran pelatih berpengalaman di kolam berstandar internasional.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="<?php echo e(route('packages')); ?>"
                            class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold rounded-2xl shadow-lg shadow-amber-500/20 transition-all hover:-translate-y-1">
                            Lihat Paket Program
                        </a>
                        <a href="<?php echo e(route('about')); ?>"
                            class="px-8 py-4 bg-white/10 hover:bg-white/15 border border-white/20 text-white font-extrabold rounded-2xl transition-all hover:-translate-y-1">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <!-- Graphic/Visual Container -->
                <div class="lg:col-span-5 hidden lg:flex justify-center relative">
                    <div
                        class="relative w-80 h-80 bg-blue-600/20 border border-white/15 rounded-3xl p-6 flex flex-col justify-between shadow-2xl backdrop-blur-sm">
                        <!-- Simulated Card Details -->
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                                <i class="fa-solid fa-water text-blue-300 text-xl"></i>
                            </div>
                            <span
                                class="text-xs bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-bold px-3 py-1 rounded-full uppercase">Pendaftaran
                                Buka</span>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs text-blue-300 font-bold uppercase tracking-widest">Black Diamond Club</p>
                            <h3 class="text-2xl font-extrabold">Jadilah Perenang yang Andal dan Percaya Diri</h3>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-400 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">
                                    A</div>
                                <div
                                    class="w-8 h-8 rounded-full bg-amber-400 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">
                                    B</div>
                                <div
                                    class="w-8 h-8 rounded-full bg-emerald-400 border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">
                                    C</div>
                            </div>
                            <span class="text-xs text-slate-300 font-medium">500+ Murid Telah Bergabung</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="relative -mt-12 max-w-5xl mx-auto px-4 z-20">
        <div
            class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center border border-slate-100">
            <div class="space-y-1">
                <p class="text-4xl font-extrabold text-blue-600"><?php echo e($totalCoaches); ?>+</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pelatih Berlisensi</p>
                <p class="text-xs text-slate-400">Instruktur profesional berstandar nasional</p>
            </div>
            <div class="space-y-1 border-y md:border-y-0 md:border-x border-slate-100 py-6 md:py-0">
                <p class="text-4xl font-extrabold text-blue-600"><?php echo e($totalLocations); ?>+</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pilihan Kolam Latihan</p>
                <p class="text-xs text-slate-400">Kolam renang tersebar di area strategis</p>
            </div>
            <div class="space-y-1">
                <p class="text-4xl font-extrabold text-blue-600">1-on-1 / Group</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pendekatan Personal</p>
                <p class="text-xs text-slate-400">Grup belajar kecil & perhatian maksimal</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">KEUNGGULAN KAMI</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Mengapa Memilih Black Diamond?
            </h2>
            <p class="text-slate-500 text-sm">Kami berkomitmen memberikan pengalaman belajar renang terbaik, teraman, dan
                paling menyenangkan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div
                class="bg-white p-8 rounded-3xl border border-slate-150 shadow-sm text-left hover:shadow-md transition duration-300">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 text-xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 text-lg mb-2">Mengutamakan Keamanan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Setiap sesi dibimbing oleh pelatih bersertifikat
                    keselamatan air, dilengkapi peralatan keselamatan lengkap.</p>
            </div>
            <div
                class="bg-white p-8 rounded-3xl border border-slate-150 shadow-sm text-left hover:shadow-md transition duration-300">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 text-xl">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 text-lg mb-2">Kurikulum Terstruktur</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Dari teknik dasar mengapung hingga gaya renang kompetisi,
                    kurikulum kami disesuaikan dengan kemampuan Anda.</p>
            </div>
            <div
                class="bg-white p-8 rounded-3xl border border-slate-150 shadow-sm text-left hover:shadow-md transition duration-300">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 text-xl">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 text-lg mb-2">Jadwal Fleksibel</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Berbagai pilihan hari latihan dan kolam renang yang dapat
                    Anda pilih sesuai kesibukan rutinitas Anda.</p>
            </div>
        </div>
    </section>

    <!-- Program Paket Teaser -->
    <?php if($packages->isNotEmpty()): ?>
        <section class="py-24 bg-slate-100 border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">PROGRAM KAMI</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Pilih Paket Program
                        Latihan Terbaik Anda</h2>
                    <p class="text-slate-500 text-sm">Paket latihan terstruktur yang disesuaikan dengan kebutuhan frekuensi
                        belajar renang Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <?php $__currentLoopData = $packages->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left">
                            <div>
                                <div class="flex justify-between items-start mb-6">
                                    <span
                                        class="bg-blue-50 border border-blue-150 text-blue-700 text-xs font-bold px-3.5 py-1 rounded-full uppercase">
                                        <?php echo e($package->sessions); ?>x Sesi
                                    </span>
                                    <span class="text-xs text-slate-400 font-semibold">Masa Aktif:
                                        <?php echo e($package->active_period_months); ?> Bln</span>
                                </div>
                                <h3 class="text-2xl font-extrabold text-slate-800 mb-2"><?php echo e($package->name); ?></h3>
                                <p class="text-slate-450 text-xs leading-relaxed mb-6">Sangat cocok untuk yang ingin belajar
                                    berenang secara konsisten dengan bimbingan pelatih profesional.</p>
                                <div class="mb-6 flex items-baseline gap-1">
                                    <span class="text-3xl font-extrabold text-slate-900">Rp
                                        <?php echo e(number_format($package->price, 0, ',', '.')); ?></span>
                                    <span class="text-slate-400 text-xs">/ Paket</span>
                                </div>
                            </div>
                            <a href="<?php echo e(route('packages')); ?>"
                                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-center text-sm shadow-md shadow-blue-500/10 transition-colors">
                                Lihat Detail Paket
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="text-center">
                    <a href="<?php echo e(route('packages')); ?>"
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-flex items-center gap-2">
                        Lihat Semua Paket <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>



    <!-- Registration Flow Section -->
    <section class="py-24 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">ALUR PENDAFTARAN</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Langkah Mudah Bergabung
                    Latihan</h2>
                <p class="text-slate-500 text-sm">Ikuti 4 langkah sederhana ini untuk memulai sesi latihan renang pertama
                    Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative mb-12">
                <!-- Step 1 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-blue-500/20 mb-4">
                        1
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-1">Daftar Akun</h3>
                    <p class="text-xs text-slate-500 max-w-[200px] leading-relaxed">Daftarkan diri Anda atau anak Anda di
                        menu registrasi.</p>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-blue-500/20 mb-4">
                        2
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-1">Pilih Paket & Lokasi</h3>
                    <p class="text-xs text-slate-500 max-w-[200px] leading-relaxed">Tentukan pilihan paket latihan dan
                        kolam renang terdekat.</p>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-blue-500/20 mb-4">
                        3
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-1">Upload Pembayaran</h3>
                    <p class="text-xs text-slate-500 max-w-[200px] leading-relaxed">Lakukan transfer biaya paket dan unggah
                        bukti transaksi Anda.</p>
                </div>
                <!-- Step 4 -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-lg shadow-blue-500/20 mb-4">
                        4
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-1">Mulai Latihan</h3>
                    <p class="text-xs text-slate-500 max-w-[200px] leading-relaxed">Admin memverifikasi pembayaran, coach
                        ditunjuk, dan latihan dimulai!</p>
                </div>
            </div>
            <div class="text-center">
                <a href="<?php echo e(route('register')); ?>"
                    class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-flex items-center gap-2">
                    Daftar Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-20 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white text-center mb-16">
        <div class="max-w-2xl mx-auto px-6 space-y-6 py-12">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Siap Berenang Bersama Kami?</h2>
            <p class="text-slate-300 text-sm mb-8 leading-relaxed">Bergabunglah dengan ratusan murid yang sudah merasakan
                manfaat latihan renang bersama Black Diamond Swimming Club.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo e(route('register')); ?>"
                    class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold rounded-2xl shadow-lg shadow-amber-500/20 transition-all hover:-translate-y-1">
                    Daftar Sekarang
                </a>
                <a href="<?php echo e(route('contact')); ?>"
                    class="px-8 py-4 bg-white/10 hover:bg-white/15 border border-white/20 text-white font-extrabold rounded-2xl transition-all hover:-translate-y-1">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-profile', ['title' => 'Black Diamond Swimming Club - Klub Renang Profesional'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/company-profile/home.blade.php ENDPATH**/ ?>