@extends('layouts.company-profile', ['title' => 'Kelas Renang Prestasi - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-trophy"></i> Program Atlet Prestasi
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Kelas <span class="text-[#D3AF37]">Renang Prestasi</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Pembinaan intensif atlet renang tingkat Pra Junior, Junior, Senior, dan Finswimming menuju jenjang kejuaraan.
            </p>
        </div>
    </section>

    <!-- Packages List Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($prestasiCategory && $prestasiCategory->swimmingClasses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                @foreach($prestasiCategory->swimmingClasses as $class)
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
                                            <i class="fa-solid fa-calendar-day text-[#D3AF37]"></i> Batasan Usia
                                        </span>
                                        <span class="font-bold text-slate-800">
                                            {{ $class->age_min }}{{ $class->age_max ? '-' . $class->age_max : '+' }} Tahun
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-person-swimming text-[#D3AF37]"></i> Sesi Latihan Air (Swim)
                                        </span>
                                        <span class="font-bold text-slate-800">
                                            {{ $package->swim_sessions }}x per Bulan
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-dumbbell text-[#D3AF37]"></i> Sesi Fisik (Dryland)
                                        </span>
                                        <span class="font-bold text-slate-800">
                                            {{ $package->dryland_sessions }}x per Bulan
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-650">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-users text-[#D3AF37]"></i> Kapasitas per Sesi
                                        </span>
                                        <span class="font-bold text-red-500">
                                            Maksimal 15 Murid / Sesi
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
                                class="w-full py-3 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl text-center text-sm shadow-md transition-all duration-300">
                                Daftar Atlet Prestasi
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>

            <!-- Ticket Info Banner -->
            <div class="mt-12 bg-[#101828] border border-[#D3AF37]/40 rounded-3xl p-6 text-white flex items-start gap-4 shadow-lg text-left max-w-4xl mx-auto">
                <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-base">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-[#D3AF37] text-base mb-1">Informasi Tiket Masuk Kolam Renang</h4>
                    <p class="text-xs text-slate-200 leading-relaxed font-normal">
                        Khusus untuk sesi latihan di kolam renang <strong class="text-white">Taman Wahidin</strong> dan <strong class="text-white">Cipto</strong>, biaya yang tertera <span class="text-[#D3AF37] font-bold">SUDAH TERMASUK (INCLUDE) TIKET MASUK KOLAM RENANG</span>. Untuk lokasi kolam renang lainnya, tiket masuk dibayarkan terpisah di gerbang kolam.
                    </p>
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-trophy text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Program Atlet Prestasi Belum Tersedia</p>
            </div>
        @endif
    </section>

    <!-- Keunggulan Section -->
    <section class="py-20 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">KEUNGGULAN PROGRAM ATLET</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Fasilitas Pembinaan Atlet Prestasi</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-stopwatch"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">PBT Tracking</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pencatatan rekor waktu terbaik (Personal Best Time) berkala di setiap gaya & jarak.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Dryland & Fitness</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Kombinasi latihan fisik darat untuk mengasah daya tahan dan kekuatan otot atlet.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Pengiriman Kejuaraan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pendampingan penuh dari tim pelatih saat mengikuti kejuaraan daerah maupun nasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#D3AF37] mb-3 tracking-tight">Ingin Menjadi Atlet Prestasi?</h2>
            <p class="text-slate-200 text-sm mb-8 leading-relaxed font-medium">Konsultasikan minat dan kesiapan putra/putri Anda dengan tim pelatih kami.</p>
            <a href="{{ route('contact') }}"
                class="px-8 py-4 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl shadow-xl transition-all hover:-translate-y-1 inline-block">
                Hubungi Kami
            </a>
        </div>
    </section>
@endsection
