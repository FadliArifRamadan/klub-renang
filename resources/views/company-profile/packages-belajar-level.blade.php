@extends('layouts.company-profile', ['title' => 'Kelas Belajar Renang ' . $swimmingClass->name . ' - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-person-swimming"></i> Paket Belajar Renang
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Kelas Belajar <span class="text-[#D3AF37]">{{ $swimmingClass->name }}</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Program latihan khusus untuk usia {{ $swimmingClass->age_min }}{{ $swimmingClass->age_max ? '-' . $swimmingClass->age_max : '+' }} tahun dengan pilihan paket Reguler & Private.
            </p>
        </div>
    </section>

    <!-- Packages List Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        


        <div>
            <div class="border-b border-slate-200 pb-4 mb-8 text-left">
                <h2 class="text-2xl font-extrabold text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-[#D3AF37] rounded-full"></span>
                    Tingkat {{ $swimmingClass->name }} 
                    <span class="text-sm font-normal text-slate-500">
                        (Usia {{ $swimmingClass->age_min }}{{ $swimmingClass->age_max ? '-' . $swimmingClass->age_max : '+' }} tahun)
                    </span>
                </h2>
                <p class="text-slate-500 text-sm mt-1">{{ $swimmingClass->description }}</p>
            </div>
            
            @if($swimmingClass->packages->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($swimmingClass->packages as $package)
                        <div class="relative bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-left">
                            <div>
                                <div class="flex justify-between items-start mb-6">
                                    <span class="bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-bold px-3.5 py-1 rounded-full uppercase">
                                        {{ $package->sessions }}x Pertemuan
                                    </span>
                                    <span class="text-xs text-slate-400 font-semibold">
                                        Masa Aktif: {{ $package->active_period_months }} Bln
                                    </span>
                                </div>

                                <h3 class="text-xl font-extrabold text-slate-800 mb-2">{{ $package->name }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed mb-6">
                                    Program latihan {{ $package->package_type === 'private' ? 'Private (1-on-1)' : 'Reguler (Kelompok)' }} 
                                    dengan {{ $package->sessions }} sesi pertemuan selama {{ $package->active_period_months }} bulan.
                                </p>

                                <!-- Pricelist per Pool/Location -->
                                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-2.5 flex items-center justify-between">
                                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-[#D3AF37]"></i> Harga berdasarkan Kolam</span>
                                    </h4>
                                    <ul class="space-y-2">
                                        @foreach($package->locationPrices as $lp)
                                            @php
                                                $locNameLower = strtolower($lp->location->name);
                                                $isTicketIncluded = str_contains($locNameLower, 'wahidin') || str_contains($locNameLower, 'cipto');
                                            @endphp
                                            <li class="flex justify-between items-center text-xs font-semibold">
                                                <span class="text-slate-600 flex items-center gap-1.5">
                                                    <span>{{ $lp->location->name }}</span>
                                                    @if($isTicketIncluded)
                                                        <span class="text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-200 px-1.5 py-0.5 rounded font-extrabold flex items-center gap-1" title="Sudah termasuk tiket masuk kolam">
                                                            <i class="fa-solid fa-ticket text-[9px] text-emerald-600"></i> Inc. Tiket
                                                        </span>
                                                    @endif
                                                </span>
                                                <span class="text-slate-900 font-extrabold">Rp {{ number_format($lp->price, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <a href="{{ route('register') }}"
                                class="w-full py-3 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl text-center text-sm shadow-md transition-all duration-300">
                                Daftar Sekarang
                            </a>
                        </div>
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
                    <i class="fa-solid fa-box text-5xl mb-4 text-slate-300"></i>
                    <p class="font-bold text-slate-500 text-lg mb-2">Paket {{ $swimmingClass->name }} Belum Tersedia</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="py-20 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">KEUNGGULAN PROGRAM</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Yang Anda Dapatkan di Setiap Paket</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Pelatih Berlisensi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Didampingi oleh pelatih bersertifikat resmi yang berpengalaman di bidang olahraga akuatik.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Laporan Perkembangan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pantau kemajuan belajar renang murid secara digital melalui laporan perkembangan berkala.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Jadwal Fleksibel</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Bebas pilih hari latihan yang sesuai dengan kesibukan dan rutinitas harian Anda.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Multi Lokasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pilih kolam renang mitra terdekat dari berbagai pilihan lokasi yang tersebar di area strategis.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Keamanan Terjamin</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Setiap sesi latihan didukung protokol keselamatan air yang ketat dan peralatan standar.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mb-5 text-xl">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 mb-2">Pembayaran Mudah</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Proses pembayaran via transfer bank dan verifikasi oleh admin secara cepat dan transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#D3AF37] mb-3 tracking-tight">Ada Pertanyaan tentang Kelas {{ $swimmingClass->name }}?</h2>
            <p class="text-slate-200 text-sm mb-8 leading-relaxed font-medium">Hubungi kami langsung dan kami siap membantu Anda menemukan paket yang paling sesuai.</p>
            <a href="{{ route('contact') }}"
                class="px-8 py-4 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl shadow-xl transition-all hover:-translate-y-1 inline-block">
                Hubungi Kami
            </a>
        </div>
    </section>
@endsection
