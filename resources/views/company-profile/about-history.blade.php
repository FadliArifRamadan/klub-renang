@extends('layouts.company-profile', ['title' => 'Sejarah & Perjalanan - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-timeline"></i> Sejarah & Perjalanan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Perjalanan <span class="text-[#D3AF37]">Black Diamond</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Dari awal yang sederhana hingga menjadi salah satu klub renang terdepan dan terpercaya di Indonesia.
            </p>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">JEJAK LANGKAH KAMI</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Milestones Black Diamond</h2>
                <p class="text-slate-500 text-sm">Setiap tahap perjalanan dibentuk dengan kerja keras, dedikasi, dan komitmen tinggi.</p>
            </div>

            <div class="relative max-w-4xl mx-auto">
                <!-- Vertical Line: left-5 on mobile, center (left-1/2) on desktop -->
                <div class="absolute left-5 md:left-1/2 -translate-x-1/2 top-4 bottom-4 w-1 bg-gradient-to-b from-[#D3AF37] via-[#D3AF37]/50 to-[#D3AF37]/20 rounded-full"></div>

                <!-- Timeline Items -->
                <div class="space-y-10 md:space-y-16 relative">
                    <!-- Item 1 (2018) -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center group">
                        <!-- Icon Badge -->
                        <div class="absolute left-5 md:left-1/2 -translate-x-1/2 top-0 md:top-1/2 md:-translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#101828] text-[#D3AF37] border-2 border-[#D3AF37] flex items-center justify-center font-extrabold shrink-0 shadow-lg shadow-black/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-flag text-xs md:text-sm"></i>
                        </div>

                        <!-- Left Content (Desktop Left / Mobile Right) -->
                        <div class="pl-14 md:pl-0 md:w-1/2 md:pr-12 md:text-right w-full">
                            <div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                <span class="inline-block px-3 py-1 rounded-full bg-[#D3AF37]/15 text-[#D3AF37] text-xs font-black uppercase tracking-wider mb-2">2018</span>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800 mb-2">Berdirinya Black Diamond</h3>
                                <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Dimulai oleh sekelompok pelatih renang berpengalaman dengan satu kolam renang dan 20 murid pertama di Bandung.</p>
                            </div>
                        </div>

                        <!-- Empty Right Slot for Desktop -->
                        <div class="hidden md:block md:w-1/2"></div>
                    </div>

                    <!-- Item 2 (2020) -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center group">
                        <!-- Icon Badge -->
                        <div class="absolute left-5 md:left-1/2 -translate-x-1/2 top-0 md:top-1/2 md:-translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#101828] text-[#D3AF37] border-2 border-[#D3AF37] flex items-center justify-center font-extrabold shrink-0 shadow-lg shadow-black/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-trophy text-xs md:text-sm"></i>
                        </div>

                        <!-- Empty Left Slot for Desktop -->
                        <div class="hidden md:block md:w-1/2"></div>

                        <!-- Right Content (Desktop Right / Mobile Right) -->
                        <div class="pl-14 md:pl-12 md:w-1/2 w-full">
                            <div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                <span class="inline-block px-3 py-1 rounded-full bg-[#D3AF37]/15 text-[#D3AF37] text-xs font-black uppercase tracking-wider mb-2">2020</span>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800 mb-2">Ekspansi ke 3 Lokasi</h3>
                                <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Setelah dua tahun beroperasi, kami berhasil membuka 2 lokasi kolam renang baru dan merekrut 5 pelatih berlisensi tambahan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 (2022) -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center group">
                        <!-- Icon Badge -->
                        <div class="absolute left-5 md:left-1/2 -translate-x-1/2 top-0 md:top-1/2 md:-translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#101828] text-[#D3AF37] border-2 border-[#D3AF37] flex items-center justify-center font-extrabold shrink-0 shadow-lg shadow-black/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-laptop text-xs md:text-sm"></i>
                        </div>

                        <!-- Left Content (Desktop Left / Mobile Right) -->
                        <div class="pl-14 md:pl-0 md:w-1/2 md:pr-12 md:text-right w-full">
                            <div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                <span class="inline-block px-3 py-1 rounded-full bg-[#D3AF37]/15 text-[#D3AF37] text-xs font-black uppercase tracking-wider mb-2">2022</span>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800 mb-2">Digitalisasi Manajemen Klub</h3>
                                <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Peluncuran platform digital untuk pemantauan absensi, laporan perkembangan, dan manajemen pembayaran secara online.</p>
                            </div>
                        </div>

                        <!-- Empty Right Slot for Desktop -->
                        <div class="hidden md:block md:w-1/2"></div>
                    </div>

                    <!-- Item 4 (2024 - Sekarang) -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center group">
                        <!-- Icon Badge -->
                        <div class="absolute left-5 md:left-1/2 -translate-x-1/2 top-0 md:top-1/2 md:-translate-y-1/2 z-10 w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#101828] text-[#D3AF37] border-2 border-[#D3AF37] flex items-center justify-center font-extrabold shrink-0 shadow-lg shadow-black/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-star text-xs md:text-sm"></i>
                        </div>

                        <!-- Empty Left Slot for Desktop -->
                        <div class="hidden md:block md:w-1/2"></div>

                        <!-- Right Content (Desktop Right / Mobile Right) -->
                        <div class="pl-14 md:pl-12 md:w-1/2 w-full">
                            <div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                <span class="inline-block px-3 py-1 rounded-full bg-[#D3AF37]/15 text-[#D3AF37] text-xs font-black uppercase tracking-wider mb-2">2024 - Sekarang</span>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800 mb-2">500+ Murid & Terus Berkembang</h3>
                                <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Kini kami telah melayani lebih dari 500 murid aktif dengan 5+ kolam renang dan tim pelatih profesional yang terus bertumbuh.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-3xl mx-auto px-6 space-y-6 py-6 relative z-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-[#D3AF37] tracking-tight">Menjadi Bagian dari Sejarah Kami!</h2>
            <p class="text-slate-200 text-base mb-8 leading-relaxed font-medium">Daftarkan diri Anda atau anak Anda sekarang dan mulailah perjalanan renang yang luar biasa bersama Black Diamond.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl shadow-xl transition-all hover:-translate-y-1">
                    Daftar Sekarang
                </a>
                <a href="{{ route('contact') }}"
                    class="px-8 py-4 bg-[#101828]/80 hover:bg-[#101828] border-2 border-[#D3AF37]/60 text-[#D3AF37] font-extrabold rounded-2xl transition-all hover:-translate-y-1">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection
