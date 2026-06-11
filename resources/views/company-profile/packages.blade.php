@extends('layouts.company-profile', ['title' => 'Program Paket - Black Diamond Swimming Club'])

@section('content')
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
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'belajar' }">
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
        <div x-show="activeTab === 'belajar'" x-transition class="space-y-16">
            @php
                $belajarCat = $classCategories->firstWhere('slug', 'belajar');
            @endphp
            @if($belajarCat && $belajarCat->swimmingClasses->isNotEmpty())
                @foreach($belajarCat->swimmingClasses as $class)
                    <div>
                        <div class="border-b border-slate-200 pb-4 mb-8 text-left">
                            <h2 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2">
                                <span class="w-2.5 h-6 bg-blue-600 rounded-full"></span>
                                Tingkat {{ $class->name }} 
                                <span class="text-sm font-normal text-slate-500">
                                    (Usia {{ $class->age_min }}{{ $class->age_max ? '-' . $class->age_max : '+' }} tahun)
                                </span>
                            </h2>
                            <p class="text-slate-500 text-sm mt-1">{{ $class->description }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($class->packages as $pkgIndex => $package)
                                <div class="relative bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-left">
                                    <div>
                                        <div class="flex justify-between items-start mb-6">
                                            <span class="bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold px-3.5 py-1 rounded-full uppercase">
                                                {{ $package->sessions }}x Pertemuan
                                            </span>
                                            <span class="text-xs text-slate-450 font-semibold">
                                                Masa Aktif: {{ $package->active_period_months }} Bln
                                            </span>
                                        </div>

                                        <h3 class="text-xl font-extrabold text-slate-850 mb-2">{{ $package->name }}</h3>
                                        <p class="text-slate-450 text-sm leading-relaxed mb-6">
                                            Program latihan {{ $package->package_type === 'private' ? 'Private (1-on-1)' : 'Reguler (Kelompok)' }} 
                                            dengan {{ $package->sessions }} sesi pertemuan selama {{ $package->active_period_months }} bulan.
                                        </p>

                                        <!-- Pricelist per Pool/Location -->
                                        <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100">
                                            <h4 class="text-xs font-bold text-slate-450 uppercase mb-2.5 flex items-center gap-1.5">
                                                <i class="fa-solid fa-location-dot text-blue-500"></i> Harga berdasarkan Kolam
                                            </h4>
                                            <ul class="space-y-1.5">
                                                @foreach($package->locationPrices as $lp)
                                                    <li class="flex justify-between items-center text-xs font-semibold">
                                                        <span class="text-slate-500">{{ $lp->location->name }}</span>
                                                        <span class="text-slate-700 font-bold">Rp {{ number_format($lp->price, 0, ',', '.') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <a href="{{ route('register') }}"
                                        class="w-full py-3 bg-slate-105 hover:bg-blue-600 text-slate-700 hover:text-white font-extrabold rounded-2xl text-center text-sm transition-all duration-300">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-box text-5xl mb-4 text-slate-300"></i>
                    <p class="font-bold text-slate-500 text-lg mb-2">Paket Belajar Renang Belum Tersedia</p>
                </div>
            @endif
        </div>

        <!-- Tab Prestasi -->
        <div x-show="activeTab === 'prestasi'" x-transition class="space-y-16" style="display: none;">
            @php
                $prestasiCat = $classCategories->firstWhere('slug', 'prestasi');
            @endphp
            @if($prestasiCat && $prestasiCat->swimmingClasses->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                    @foreach($prestasiCat->swimmingClasses as $class)
                        @foreach($class->packages as $package)
                            <div class="relative bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-left">
                                <div>
                                    <div class="flex justify-between items-start mb-6">
                                        <span class="bg-amber-50 border border-amber-100 text-amber-700 text-xs font-bold px-3.5 py-1 rounded-full uppercase flex items-center gap-1">
                                            <i class="fa-solid fa-trophy"></i> Kelas Prestasi
                                        </span>
                                        <span class="text-xs text-slate-400 font-semibold">Penagihan: Bulanan</span>
                                    </div>

                                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">{{ $class->name }}</h3>
                                    <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $class->description }}</p>

                                    <!-- Details -->
                                    <div class="space-y-3 mb-8 border-t border-slate-100 pt-6">
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-day text-blue-500"></i> Batasan Usia
                                            </span>
                                            <span class="font-bold text-slate-800">
                                                {{ $class->age_min }}{{ $class->age_max ? '-' . $class->age_max : '+' }} Tahun
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-person-swimming text-blue-500"></i> Sesi Latihan Air (Swim)
                                            </span>
                                            <span class="font-bold text-slate-800">
                                                {{ $package->swim_sessions }}x per Bulan
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-dumbbell text-blue-500"></i> Sesi Fisik (Dryland)
                                            </span>
                                            <span class="font-bold text-slate-800">
                                                {{ $package->dryland_sessions }}x per Bulan
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-users text-blue-500"></i> Batas Kuota Kelas
                                            </span>
                                            <span class="font-bold text-red-500">
                                                Maksimal {{ $class->max_quota }} Murid
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Price Display -->
                                    <div class="mb-8 border-t border-slate-100 pt-6">
                                        <p class="text-xs text-slate-400 mb-1">Iuran Bulanan</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-extrabold text-slate-900">Rp
                                                {{ number_format($package->price, 0, ',', '.') }}</span>
                                            <span class="text-slate-400 text-xs">/ Bulan</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('register') }}"
                                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-center text-sm shadow-md transition-all duration-300">
                                    Daftar Atlet Prestasi
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-trophy text-5xl mb-4 text-slate-300"></i>
                    <p class="font-bold text-slate-500 text-lg mb-2">Program Atlet Prestasi Belum Tersedia</p>
                </div>
            @endif
        </div>
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
            <a href="{{ route('contact') }}"
                class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1 inline-block">
                Hubungi Kami
            </a>
        </div>
    </section>
@endsection
