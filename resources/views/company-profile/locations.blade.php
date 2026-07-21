@extends('layouts.company-profile', ['title' => 'Kolam Latihan - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section
        class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#D3AF37] text-[#101828] overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-15"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-amber-300 rounded-full blur-[120px] opacity-40"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#101828] border border-[#101828]/20 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-water"></i> Kolam Renang Mitra
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-[#101828]">
                Lokasi & Kolam Latihan
            </h1>
            <p class="text-[#101828]/90 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-medium">
                Tersedia berbagai pilihan kolam renang mitra kami yang tersebar di area strategis, siap mendukung sesi
                latihan Anda.
            </p>
        </div>
    </section>

    <!-- Locations Grid -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($locations->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($locations as $location)
                    <div
                        class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-left group">
                        <!-- Location Image -->
                        <div class="h-52 bg-slate-200 overflow-hidden relative">
                            @if ($location->image)
                                <img src="{{ asset('storage/' . $location->image) }}" alt="Foto {{ $location->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-cyan-100">
                                    <i class="fa-solid fa-water text-blue-200 text-6xl"></i>
                                </div>
                            @endif
                            <!-- Badge Overlay -->
                            <div
                                class="absolute top-4 left-4 bg-slate-900/70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-amber-400"></i> Kolam Renang
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="p-6 space-y-3">
                            <h2 class="font-extrabold text-slate-800 text-lg leading-snug">{{ $location->name }}</h2>
                            <p class="text-xs text-slate-500 flex items-start gap-2 leading-relaxed">
                                <i class="fa-solid fa-map-pin text-[#D3AF37] mt-0.5 shrink-0"></i>
                                <span>{{ $location->address }}</span>
                            </p>
                            @if ($location->phone ?? null)
                                <p class="text-xs text-slate-500 flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-[#D3AF37] shrink-0"></i>
                                    <span>{{ $location->phone }}</span>
                                </p>
                            @endif

                            <div class="pt-3 border-t border-slate-100">
                                <a href="{{ route('register') }}"
                                    class="w-full py-2.5 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-bold rounded-xl flex items-center justify-center gap-2 text-xs transition-all duration-300 shadow-sm">
                                    <i class="fa-solid fa-person-swimming"></i> Daftar di Lokasi Ini
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-location-dot text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Lokasi Belum Tersedia</p>
                <p class="text-sm text-slate-400">Kami sedang menyiapkan kolam renang mitra baru di area Anda.</p>
            </div>
        @endif
    </section>

    <!-- Fasilitas Section -->
    <section class="py-20 bg-slate-100 border-y border-slate-200 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4 mt-8">
                <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">FASILITAS</span>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Standar Fasilitas Kolam Mitra Kami</h2>
                <p class="text-slate-500 text-sm">Setiap kolam renang mitra dipilih berdasarkan standar kualitas dan
                    keamanan yang ketat.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-droplet"></i></div>
                    <p class="text-xs font-bold text-slate-700">Air Bersih & Terawat</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-ruler"></i></div>
                    <p class="text-xs font-bold text-slate-700">Kolam Berstandar</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-child-reaching"></i></div>
                    <p class="text-xs font-bold text-slate-700">Area Anak-Anak</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-restroom"></i></div>
                    <p class="text-xs font-bold text-slate-700">Ruang Ganti Bersih</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-shield-halved"></i></div>
                    <p class="text-xs font-bold text-slate-700">Perlengkapan Safety</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 text-center border border-slate-200 shadow-sm hover:shadow-md transition-all">
                    <div class="text-2xl text-[#D3AF37] mb-3"><i class="fa-solid fa-car"></i></div>
                    <p class="text-xs font-bold text-slate-700">Area Parkir</p>
                </div>
            </div>
        </div>
    </section>
@endsection
