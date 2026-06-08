<?php $__env->startSection('content'); ?>
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-30"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-user-tie"></i> Tim Instruktur
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                Tim Pelatih Profesional Kami
            </h1>
            <p class="text-slate-200 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Berkenalan dengan instruktur renang berpengalaman dan berlisensi yang siap membimbing Anda mencapai potensi terbaik.
            </p>
        </div>
    </section>

    <!-- Coaches Grid -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if($coaches->isNotEmpty()): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                        <!-- Photo Container -->
                        <div class="relative h-72 bg-slate-100 overflow-hidden">
                            <?php if($coach->image): ?>
                                <img src="<?php echo e(asset('storage/' . $coach->image)); ?>" alt="Foto <?php echo e($coach->name); ?>"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
                                    <i class="fa-solid fa-user-tie text-blue-200 text-7xl"></i>
                                </div>
                            <?php endif; ?>
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/10 to-transparent"></div>

                            <!-- WhatsApp Contact Badge -->
                            <?php
                                $waPhone = preg_replace('/[^0-9]/', '', $coach->phone ?? '');
                                if (str_starts_with($waPhone, '0')) {
                                    $waPhone = '62' . substr($waPhone, 1);
                                }
                            ?>
                            <?php if($coach->phone): ?>
                            <div class="absolute bottom-4 left-4 right-4">
                                <a href="https://wa.me/<?php echo e($waPhone); ?>" target="_blank"
                                    class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold rounded-xl shadow-lg flex items-center justify-center gap-2 text-xs transition-all opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 duration-300">
                                    <i class="fa-brands fa-whatsapp text-base"></i> Hubungi via WhatsApp
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Details -->
                        <div class="p-6 text-left">
                            <h2 class="font-extrabold text-slate-800 text-base mb-1 truncate"><?php echo e($coach->name); ?></h2>
                            <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-3">Instruktur Renang Profesional</p>
                            <?php if($coach->phone): ?>
                            <p class="text-xs text-slate-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-phone"></i>
                                <span><?php echo e($coach->phone); ?></span>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-user-tie text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Daftar Pelatih Belum Tersedia</p>
                <p class="text-sm text-slate-400">Kami sedang merekrut pelatih terbaik untuk bergabung bersama tim kami.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Standar Pelatih Section -->
    <section class="py-20 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">STANDAR KAMI</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kriteria Pelatih Black Diamond</h2>
                <p class="text-slate-500 text-sm">Setiap pelatih kami memenuhi standar kualifikasi yang ketat sebelum bergabung.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600 mb-2">✓</div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">Berlisensi Resmi</h3>
                    <p class="text-xs text-slate-500">Memiliki sertifikasi pelatih renang yang diakui secara nasional.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600 mb-2">✓</div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">Berpengalaman</h3>
                    <p class="text-xs text-slate-500">Minimal 2 tahun pengalaman melatih renang berbagai kelompok usia.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600 mb-2">✓</div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">First Aid Certified</h3>
                    <p class="text-xs text-slate-500">Tersertifikasi pertolongan pertama dan keselamatan di dalam air.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600 mb-2">✓</div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">Komunikatif</h3>
                    <p class="text-xs text-slate-500">Mampu berkomunikasi dengan baik kepada murid dan orang tua.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Join as Coach -->
    <section class="py-20 text-center">
        <div class="max-w-xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">Ingin Bergabung Sebagai Pelatih?</h2>
            <p class="text-slate-500 text-sm mb-8">Jika Anda adalah instruktur renang yang berpengalaman dan berlisensi, kami ingin mendengar dari Anda.</p>
            <a href="<?php echo e(route('contact')); ?>"
                class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-block">
                Hubungi Kami
            </a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-profile', ['title' => 'Pelatih - Black Diamond Swimming Club'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/company-profile/coaches.blade.php ENDPATH**/ ?>