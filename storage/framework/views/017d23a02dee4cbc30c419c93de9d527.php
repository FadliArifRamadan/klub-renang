<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Black Diamond Swimming Club - Company Profile</title>

    <!-- Fonts & Icons -->
    <link rel="icon" href="<?php echo e(asset('images/black_diamond_1.png')); ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles (Tailwind via Vite) -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 0), radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 0);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800 overflow-x-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Top Sticky Header -->
    <header
        class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <img src="<?php echo e(asset('images/black_diamond_1.png')); ?>" alt="Black Diamond Logo"
                        class="h-16 w-auto object-contain">
                </div>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#home"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Home</a>
                    <a href="#tentang"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Tentang
                        Kami</a>
                    <a href="#program"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Program
                        Paket</a>
                    <a href="#coaches"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Pelatih</a>
                    <a href="#lokasi"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Kolam
                        Latihan</a>
                </nav>

                <!-- Desktop Access Action Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard Admin
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                            class="text-sm font-bold text-slate-650 hover:text-blue-600 transition-colors px-4 py-2">
                            Masuk
                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="px-5 py-2.5 bg-blue-650 hover:bg-blue-700 text-black hover:text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }"
                                class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Slide-out Menu Panel -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white border-b border-slate-150 absolute top-20 left-0 w-full shadow-lg"
            style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a @click="mobileMenuOpen = false" href="#home"
                    class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl">Home</a>
                <a @click="mobileMenuOpen = false" href="#tentang"
                    class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl">Tentang
                    Kami</a>
                <a @click="mobileMenuOpen = false" href="#program"
                    class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl">Program
                    Paket</a>
                <a @click="mobileMenuOpen = false" href="#coaches"
                    class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl">Pelatih</a>
                <a @click="mobileMenuOpen = false" href="#lokasi"
                    class="block px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-xl">Kolam
                    Latihan</a>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-3 px-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="w-full text-center py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard Admin
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"
                            class="w-full text-center py-3 text-slate-700 font-bold border border-slate-200 rounded-xl hover:bg-slate-50">
                            Masuk
                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="w-full text-center py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">
                            Daftar Sekarang
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home"
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
                        <a href="#program"
                            class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-extrabold rounded-2xl shadow-lg shadow-amber-500/20 transition-all hover:-translate-y-1">
                            Lihat Paket Program
                        </a>
                        <a href="#tentang"
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

    <!-- Stats & Highlight Counter Section -->
    <section class="relative -mt-12 max-w-5xl mx-auto px-4 z-20">
        <div
            class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center border border-slate-100">
            <div class="space-y-1">
                <p class="text-4xl font-extrabold text-blue-600">100%</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pelatih Berlisensi</p>
                <p class="text-xs text-slate-400">Instruktur profesional berstandar nasional</p>
            </div>
            <div class="space-y-1 border-y md:border-y-0 md:border-x border-slate-100 py-6 md:py-0">
                <p class="text-4xl font-extrabold text-blue-600">5+</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pilihan Kolam Latihan</p>
                <p class="text-xs text-slate-400">Kolam renang tersebar di area strategis</p>
            </div>
            <div class="space-y-1">
                <p class="text-4xl font-extrabold text-blue-600">1-on-1</p>
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Pendekatan Personal</p>
                <p class="text-xs text-slate-400">Grup belajar kecil & perhatian maksimal</p>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left Grid: Text Description -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">TENTANG BLACK
                    DIAMOND</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Mengutamakan Keselamatan, Teknik yang Benar, dan Kenyamanan Berlatih
                </h2>
                <p class="text-slate-650 text-base sm:text-lg leading-relaxed">
                    Didirikan dengan visi melahirkan generasi perenang yang tangguh, aman, dan berprestasi. Black
                    Diamond Swimming Club menghadirkan kurikulum pengajaran berenang yang sistematis untuk segala umur,
                    mulai dari pengenalan air dasar (water safety) hingga teknik kompetisi bagi atlet muda.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0 border border-blue-100">
                            <i class="fa-solid fa-shield text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Prioritas Keamanan</h4>
                            <p class="text-xs text-slate-400 mt-1">Kami menerapkan protokol keamanan air tertinggi di
                                setiap sesi latihan.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center shrink-0 border border-blue-100">
                            <i class="fa-solid fa-award text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-800 text-sm">Kurikulum Teruji</h4>
                            <p class="text-xs text-slate-400 mt-1">Fokus pada penyempurnaan gaya dada, bebas, punggung,
                                dan kupu-kupu.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Grid: Highlights Accordion Box -->
            <div
                class="lg:col-span-5 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100/50 rounded-3xl p-8 space-y-6 text-left">
                <h3 class="text-xl font-extrabold text-slate-900">Mengapa Memilih Kami?</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-1 shrink-0"></i>
                        <span class="text-sm text-slate-700 font-medium">Bebas memilih jadwal latihan yang
                            fleksibel.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-1 shrink-0"></i>
                        <span class="text-sm text-slate-700 font-medium">Laporan perkembangan fisik murid dipantau
                            secara digital.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-1 shrink-0"></i>
                        <span class="text-sm text-slate-700 font-medium">Pembayaran mudah secara transfer dengan
                            verifikasi cepat.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-1 shrink-0"></i>
                        <span class="text-sm text-slate-700 font-medium">Kuota murid per pelatih dibatasi (Maks 5
                            murid).</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Program Paket Section -->
    <section id="program" class="py-24 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">PROGRAM KAMI</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Pilih Paket Program
                    Latihan Terbaik Anda</h2>
                <p class="text-slate-500 text-sm">Paket latihan terstruktur yang disesuaikan dengan kebutuhan frekuensi
                    belajar renang Anda.</p>
            </div>

            <!-- Packages Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative text-left">
                        <div>
                            <!-- Package Header -->
                            <div class="flex justify-between items-start mb-6">
                                <span
                                    class="bg-blue-50 border border-blue-150 text-blue-700 text-xs font-bold px-3.5 py-1 rounded-full uppercase">
                                    <?php echo e($package->sessions); ?>x Sesi
                                </span>
                                <span class="text-xs text-slate-400 font-semibold">Masa Aktif:
                                    <?php echo e($package->active_period_months); ?> Bln</span>
                            </div>

                            <h3 class="text-2xl font-extrabold text-slate-800 mb-2"><?php echo e($package->name); ?></h3>
                            <p class="text-slate-450 text-xs leading-relaxed mb-6">Sangat cocok untuk pemula yang ingin
                                belajar berenang dasar secara konsisten.</p>

                            <!-- Price Display -->
                            <div class="mb-6 flex items-baseline gap-1">
                                <span class="text-3xl font-extrabold text-slate-900">Rp
                                    <?php echo e(number_format($package->price, 0, ',', '.')); ?></span>
                                <span class="text-slate-400 text-xs">/ Paket</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="<?php echo e(route('register')); ?>"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-center text-sm shadow-md shadow-blue-500/10 transition-colors">
                            Daftar Sekarang
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div
                        class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-400 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-box text-4xl mb-3 text-slate-300"></i>
                        <p class="font-medium text-slate-650">Program Paket latihan belum tersedia saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Coach / Pelatih Section -->
    <section id="coaches" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">TIM INTRUKTUR
                KAMI</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kenalan Dengan Coach
                Profesional Kami</h2>
            <p class="text-slate-500 text-sm">Tim pelatih yang berdedikasi tinggi membantu Anda menguasai keahlian
                renang dengan sabar dan aman.</p>
        </div>

        <!-- Coaches Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden group hover:shadow-md transition-all duration-300">
                    <!-- Photo Cover Container -->
                    <div class="relative h-64 bg-slate-100 overflow-hidden">
                        <?php if($coach->image): ?>
                            <img src="<?php echo e(asset('storage/' . $coach->image)); ?>" alt="Foto <?php echo e($coach->name); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50/70">
                                <i class="fa-solid fa-user-tie text-slate-300 text-6xl"></i>
                            </div>
                        <?php endif; ?>
                        <!-- Hover Badge WA Contact -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <?php
                                $waPhone = preg_replace('/[^0-9]/', '', $coach->phone);
                                if (str_starts_with($waPhone, '0')) {
                                    $waPhone = '62' . substr($waPhone, 1);
                                }
                            ?>
                            <a href="https://wa.me/<?php echo e($waPhone); ?>" target="_blank"
                                class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold rounded-xl shadow-lg flex items-center justify-center gap-2 text-xs transition-colors">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Coach
                            </a>
                        </div>
                    </div>

                    <!-- Details Card -->
                    <div class="p-5 text-left">
                        <h3 class="font-extrabold text-slate-800 text-base mb-1 truncate"><?php echo e($coach->name); ?></h3>
                        <p class="text-xs text-blue-650 font-bold uppercase tracking-wider">Instruktur Renang</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div
                    class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-400 border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-user-tie text-4xl mb-3 text-slate-300"></i>
                    <p class="font-medium text-slate-650">Daftar Coach belum tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Tempat Latihan Section -->
    <section id="lokasi" class="py-24 bg-slate-100 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">LOKASI
                    LATIHAN</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Tempat & Kolam Latihan
                    Tersebar</h2>
                <p class="text-slate-500 text-sm">Pilih lokasi kolam renang mitra terdekat yang paling memudahkan Anda
                    berlatih.</p>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 text-left">
                        <!-- Location Image Cover -->
                        <div class="h-48 bg-slate-200 overflow-hidden relative">
                            <?php if($location->image): ?>
                                <img src="<?php echo e(asset('storage/' . $location->image)); ?>"
                                    alt="Foto <?php echo e($location->name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-blue-50/70">
                                    <i class="fa-solid fa-water text-blue-300 text-5xl"></i>
                                </div>
                            <?php endif; ?>
                            <div
                                class="absolute top-4 left-4 bg-slate-900/70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-amber-500"></i> Pool
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="p-6 space-y-3">
                            <h3 class="font-extrabold text-slate-800 text-lg leading-snug"><?php echo e($location->name); ?></h3>
                            <p class="text-xs text-slate-500 flex items-start gap-2 leading-relaxed">
                                <i class="fa-solid fa-map-pin text-slate-400 mt-0.5 shrink-0"></i>
                                <span><?php echo e($location->address); ?></span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div
                        class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-400 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-location-dot text-4xl mb-3 text-slate-300"></i>
                        <p class="font-medium text-slate-655">Lokasi kolam renang belum ditentukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-slate-900 text-white pt-16 pb-12 border-t border-slate-800 text-left">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Left Info Branding -->
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-3">
                    <div>
                        <img src="<?php echo e(asset('images/black_diamond_1.png')); ?>" alt="Black Diamond Logo"
                            class="w-auto h-16 object-contain">
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Klub renang terkemuka untuk melatih keterampilan, keamanan, dan kebugaran tubuh dalam air. Kami siap
                    melatih perenang sejati.
                </p>
            </div>

            <!-- Center Menu Links -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm tracking-wider uppercase text-slate-400">Navigasi Halaman</h4>
                <ul class="space-y-2.5 text-sm text-slate-300">
                    <li><a href="#home" class="hover:text-blue-400 transition-colors">Home</a></li>
                    <li><a href="#tentang" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#program" class="hover:text-blue-400 transition-colors">Program Paket</a></li>
                    <li><a href="#coaches" class="hover:text-blue-400 transition-colors">Pelatih</a></li>
                </ul>
            </div>

            <!-- Right Contact Support -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm tracking-wider uppercase text-slate-400">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-sm text-slate-300">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-450"></i>
                        <span>support@blackdiamond.club</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-slate-450"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-clock text-slate-450"></i>
                        <span>Setiap Hari (06:00 - 18:00 WIB)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; <?php echo e(date('Y')); ?> Black Diamond Swimming Club. Hak Cipta Dilindungi.</p>
            <p>Made with <i class="fa-solid fa-heart text-red-500"></i> in Indonesia</p>
        </div>
    </footer>

</body>

</html>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/welcome.blade.php ENDPATH**/ ?>