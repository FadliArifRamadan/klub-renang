<?php $__env->startSection('content'); ?>
    <!-- Page Hero -->
    <section
        class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500 rounded-full blur-[120px] opacity-20"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-box"></i> Paket Latihan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                Pilih Program Paket Terbaik Anda
            </h1>
            <p class="text-slate-200 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                Paket latihan terstruktur yang dirancang untuk memenuhi setiap kebutuhan dan frekuensi belajar renang Anda.
            </p>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($packages->isNotEmpty()): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="relative bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-left
                        <?php echo e($index === 1 ? 'ring-2 ring-blue-500 shadow-blue-100' : ''); ?>">

                        <?php if($index === 1): ?>
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <span
                                    class="bg-blue-600 text-white text-xs font-extrabold px-4 py-1.5 rounded-full shadow-md uppercase tracking-wider">
                                    ⭐ Paling Populer
                                </span>
                            </div>
                        <?php endif; ?>

                        <div>
                            <!-- Package Header -->
                            <div class="flex justify-between items-start mb-6 mt-2">
                                <span
                                    class="bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold px-3.5 py-1 rounded-full uppercase">
                                    <?php echo e($package->sessions); ?>x Sesi
                                </span>
                                <span class="text-xs text-slate-400 font-semibold">Masa Aktif:
                                    <?php echo e($package->active_period_months); ?> Bln</span>
                            </div>

                            <h2 class="text-2xl font-extrabold text-slate-800 mb-3"><?php echo e($package->name); ?></h2>
                            <p class="text-slate-450 text-sm leading-relaxed mb-6">
                                Paket latihan renang dengan <?php echo e($package->sessions); ?> sesi pertemuan selama masa aktif
                                <?php echo e($package->active_period_months); ?> bulan.
                                Cocok untuk Anda yang ingin belajar renang secara konsisten dengan bimbingan pelatih
                                profesional.
                            </p>

                            <!-- Features List -->
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                    <span class="text-sm text-slate-600"><?php echo e($package->sessions); ?> sesi pertemuan
                                        termasuk</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                    <span class="text-sm text-slate-600">Masa aktif <?php echo e($package->active_period_months); ?>

                                        bulan</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                    <span class="text-sm text-slate-600">Pelatih bersertifikat & profesional</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                    <span class="text-sm text-slate-600">Laporan perkembangan digital</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-check text-emerald-500 shrink-0"></i>
                                    <span class="text-sm text-slate-600">Pilihan kolam renang fleksibel</span>
                                </li>
                            </ul>

                            <!-- Price Display -->
                            <div class="mb-8 border-t border-slate-100 pt-6">
                                <p class="text-xs text-slate-400 mb-1">Harga Paket</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-extrabold text-slate-900">Rp
                                        <?php echo e(number_format($package->price, 0, ',', '.')); ?></span>
                                    <span class="text-slate-400 text-xs">/ Paket</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="<?php echo e(route('register')); ?>"
                            class="w-full py-3 <?php echo e($index === 1 ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 hover:bg-blue-600 text-slate-700 hover:text-white'); ?> font-extrabold rounded-2xl text-center text-sm transition-all duration-300">
                            Daftar Sekarang
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-box text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Program Paket Belum Tersedia</p>
                <p class="text-sm text-slate-400">Kami sedang menyiapkan paket latihan terbaik untuk Anda. Pantau terus!</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Mengapa Paket Kami Section -->
    <section class="py-20 bg-slate-100 border-y border-slate-200 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4 mt-8">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">KEUNGGULAN PROGRAM</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Yang Anda Dapatkan di Setiap Paket</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Pelatih Berlisensi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Didampingi oleh pelatih bersertifikat resmi yang
                        berpengalaman di bidang olahraga akuatik.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Laporan Perkembangan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pantau kemajuan belajar renang murid secara digital
                        melalui laporan perkembangan berkala.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Jadwal Fleksibel</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Bebas pilih hari latihan yang sesuai dengan kesibukan
                        dan rutinitas harian Anda.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Multi Lokasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pilih kolam renang mitra terdekat dari berbagai
                        pilihan lokasi yang tersebar di area strategis.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Keamanan Terjamin</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Setiap sesi latihan didukung protokol keselamatan air
                        yang ketat dan peralatan standar.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Pembayaran Mudah</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Proses pembayaran via transfer bank dan verifikasi
                        oleh admin secara cepat dan transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 text-center bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white mb-16">
        <div class="max-w-xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Ada Pertanyaan tentang Paket?</h2>
            <p class="text-white text-sm mb-8">Hubungi kami langsung dan kami siap membantu Anda menemukan paket yang
                paling sesuai.</p>
            <a href="<?php echo e(route('contact')); ?>"
                class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-block">
                Hubungi Kami
            </a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-profile', ['title' => 'Program Paket - Black Diamond Swimming Club'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/company-profile/packages.blade.php ENDPATH**/ ?>