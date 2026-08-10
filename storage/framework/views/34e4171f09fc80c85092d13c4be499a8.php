<?php $__env->startSection('content'); ?>
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-envelope"></i> Kontak & Dukungan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Hubungi <span class="text-[#D3AF37]">Kami</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Ada pertanyaan, saran, atau ingin mendaftar? Tim kami siap membantu Anda setiap hari dari pukul 06:00 hingga
                18:00 WIB.
            </p>
        </div>
    </section>

    <!-- Contact Info + Form Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            <!-- Left: Contact Info -->
            <div class="space-y-8">
                <div>
                    <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block mb-3">INFORMASI
                        KONTAK</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Cara Menghubungi Kami</h2>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">
                        Silakan hubungi kami melalui berbagai saluran komunikasi di bawah ini. Kami berkomitmen untuk
                        merespons setiap pertanyaan Anda dalam waktu 1x24 jam.
                    </p>
                </div>

                <!-- Contact Cards -->
                <div class="space-y-4 mb-16">
                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-xl shadow-sm">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">WhatsApp</p>
                            <a href="https://wa.me/6281234567890" target="_blank"
                                class="font-extrabold text-slate-800 hover:text-[#D3AF37] transition-colors">
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-xl shadow-sm">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Email</p>
                            <a href="mailto:support@blackdiamond.club"
                                class="font-extrabold text-slate-800 hover:text-[#D3AF37] transition-colors">
                                support@blackdiamond.club
                            </a>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-all">
                        <div
                            class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-xl shadow-sm">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Jam Operasional
                            </p>
                            <p class="font-extrabold text-slate-800">Setiap Hari: 06:00 – 18:00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Locations -->
                <?php if($locations->isNotEmpty()): ?>
                    <div class="mb-16">
                        <h3 class="font-extrabold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-[#D3AF37]"></i> Lokasi Kolam Latihan
                        </h3>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div
                                    class="bg-white rounded-2xl border border-slate-200 p-4 flex items-start gap-3 shadow-sm">
                                    <div
                                        class="w-8 h-8 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-sm">
                                        <i class="fa-solid fa-water"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm"><?php echo e($location->name); ?></p>
                                        <p class="text-xs text-slate-400 mt-0.5"><?php echo e($location->address); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Social Media -->
                <div>
                    <h3 class="font-extrabold text-slate-800 mb-4">Ikuti Kami di Media Sosial</h3>
                    <div class="flex gap-3 items-center">
                        <a href="#" style="width: 44px; height: 44px; aspect-ratio: 1/1;"
                            class="shrink-0 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center hover:bg-[#D3AF37] hover:text-[#101828] transition-all shadow-sm">
                            <i class="fa-brands fa-instagram text-xl"></i>
                        </a>

                        <a href="#" style="width: 44px; height: 44px; aspect-ratio: 1/1;"
                            class="shrink-0 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center hover:bg-[#D3AF37] hover:text-[#101828] transition-all shadow-sm">
                            <i class="fa-brands fa-facebook text-lg"></i>
                        </a>

                        <a href="https://wa.me/6281234567890" target="_blank"
                            style="width: 44px; height: 44px; aspect-ratio: 1/1;"
                            class="shrink-0 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center hover:bg-[#D3AF37] hover:text-[#101828] transition-all shadow-sm">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>

                        <a href="#" style="width: 44px; height: 44px; aspect-ratio: 1/1;"
                            class="shrink-0 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center hover:bg-[#D3AF37] hover:text-[#101828] transition-all shadow-sm">
                            <i class="fa-brands fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Actions / FAQ -->
            <div class="space-y-6">
                <!-- Quick Actions Card -->
                <div
                    class="bg-gradient-to-br from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center rounded-3xl p-8 shadow-2xl border border-[#D3AF37]/40 mb-16 relative overflow-hidden">
                    <div class="absolute inset-0 hero-pattern opacity-10"></div>
                    <div class="relative z-10 space-y-4">
                        <h3 class="font-extrabold text-2xl mb-2 text-[#D3AF37]">Siap Bergabung?</h3>
                        <p class="text-slate-200 text-sm mb-6 font-medium">Daftarkan diri atau anak Anda sekarang dan mulai perjalanan renang
                            yang luar biasa.</p>
                        <div class="space-y-3">
                            <a href="<?php echo e(route('register')); ?>"
                                class="w-full py-3.5 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 text-sm shadow-md">
                                <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank"
                                class="w-full py-3.5 bg-[#101828]/80 hover:bg-[#101828] border border-[#D3AF37]/60 text-[#D3AF37] font-extrabold rounded-2xl flex items-center justify-center gap-2 transition-all text-sm">
                                <i class="fa-brands fa-whatsapp"></i> Chat via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                    <h3 class="font-extrabold text-slate-800 text-lg mb-6">Pertanyaan yang Sering Diajukan</h3>
                    <div class="space-y-4" x-data="{ open: null }">
                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <button @click="open = open === 1 ? null : 1"
                                class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-800 text-sm hover:bg-slate-50 transition-colors">
                                <span>Berapa biaya pendaftaran?</span>
                                <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
                                    :class="{ 'rotate-180': open === 1 }"></i>
                            </button>
                            <div x-show="open === 1" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2" class="px-4 pb-4" style="display: none;">
                                <p class="text-sm text-slate-500 leading-relaxed">Biaya bergantung pada paket latihan yang
                                    dipilih. Lihat halaman <a href="<?php echo e(route('packages')); ?>"
                                        class="text-[#D3AF37] font-bold hover:underline">Program Paket</a> untuk detail
                                    lengkap harga setiap paket.</p>
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <button @click="open = open === 2 ? null : 2"
                                class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-800 text-sm hover:bg-slate-50 transition-colors">
                                <span>Apakah ada kelas untuk pemula?</span>
                                <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
                                    :class="{ 'rotate-180': open === 2 }"></i>
                            </button>
                            <div x-show="open === 2" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2" class="px-4 pb-4"
                                style="display: none;">
                                <p class="text-sm text-slate-500 leading-relaxed">Ya! Kami menerima murid dari semua
                                    tingkatan kemampuan, termasuk pemula yang sama sekali belum bisa berenang. Pelatih kami
                                    akan menyesuaikan materi dengan kemampuan setiap murid.</p>
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <button @click="open = open === 3 ? null : 3"
                                class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-800 text-sm hover:bg-slate-50 transition-colors">
                                <span>Berapa usia minimum murid?</span>
                                <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
                                    :class="{ 'rotate-180': open === 3 }"></i>
                            </button>
                            <div x-show="open === 3" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2" class="px-4 pb-4"
                                style="display: none;">
                                <p class="text-sm text-slate-500 leading-relaxed">Kami menerima murid mulai dari usia 4
                                    tahun. Untuk anak di bawah 7 tahun, disarankan didampingi oleh orang tua selama sesi
                                    pertama.</p>
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <button @click="open = open === 4 ? null : 4"
                                class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-800 text-sm hover:bg-slate-50 transition-colors">
                                <span>Bagaimana cara pembayaran?</span>
                                <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300"
                                    :class="{ 'rotate-180': open === 4 }"></i>
                            </button>
                            <div x-show="open === 4" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2" class="px-4 pb-4"
                                style="display: none;">
                                <p class="text-sm text-slate-500 leading-relaxed">Pembayaran dilakukan melalui transfer
                                    bank setelah pendaftaran. Anda perlu mengunggah bukti transfer di portal akun Anda, dan
                                    admin akan memverifikasi dalam 1x24 jam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-profile', ['title' => 'Kontak Kami - Black Diamond Swimming Club'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/company-profile/contact.blade.php ENDPATH**/ ?>