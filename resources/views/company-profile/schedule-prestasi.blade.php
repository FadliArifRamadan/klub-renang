@extends('layouts.company-profile', ['title' => 'Jadwal Latihan Kelas Renang Prestasi - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-trophy"></i> Jadwal Atlet Prestasi
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Jadwal <span class="text-[#D3AF37]">Renang Prestasi</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Jadwal sesi pembinaan intensif atlet renang (Pra Junior, Junior, Senior, Finswimming) di kolam renang mitra.
            </p>
        </div>
    </section>

    <!-- Schedule Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        @endphp

        @if($prestasiCategory && $prestasiCategory->swimmingClasses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @foreach($prestasiCategory->swimmingClasses as $class)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-left flex flex-col justify-between hover:shadow-md transition-all">
                        <div>
                            <div class="bg-[#101828] border-b border-[#D3AF37]/30 text-[#D3AF37] px-6 py-5">
                                <h3 class="font-extrabold text-lg flex items-center justify-between">
                                    <span>Kelas {{ $class->name }}</span>
                                    <span class="text-xs bg-white/20 border border-white/30 text-white px-3 py-1 rounded-full font-semibold">
                                        Usia {{ $class->age_min }}{{ $class->age_max ? '-' . $class->age_max : '+' }} thn
                                    </span>
                                </h3>
                                <p class="text-xs text-[#D3AF37]/80 mt-1 font-semibold">{{ $class->description }}</p>
                            </div>
                            <div class="p-6 space-y-4">
                                @php
                                    $sortedSchedules = $class->schedules->sortBy('day_of_week');
                                @endphp
                                @if($sortedSchedules->isNotEmpty())
                                    @foreach($sortedSchedules as $sched)
                                        <div class="flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100/80 rounded-2xl border border-slate-200/80 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-bold text-sm shrink-0">
                                                    <i class="fa-solid fa-clock"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">
                                                        {{ $days[$sched->day_of_week] ?? 'Hari Lain' }}
                                                    </p>
                                                    <p class="text-xs text-slate-500 font-semibold">
                                                        {{ substr($sched->start_time, 0, 5) }} – {{ substr($sched->end_time, 0, 5) }} WIB
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block text-[10px] {{ $sched->session_type === 'dryland' ? 'bg-orange-100 border border-orange-200 text-orange-800' : 'bg-amber-100 border border-amber-200 text-amber-800' }} font-extrabold px-2.5 py-0.5 rounded-full mb-1">
                                                    {{ $sched->session_type === 'dryland' ? 'Dryland' : 'Sesi Swim' }}
                                                </span>
                                                <p class="text-[10px] text-slate-600 font-bold flex items-center gap-1 justify-end">
                                                    <i class="fa-solid fa-location-dot text-[#D3AF37]"></i> {{ $sched->location->name ?? 'Kolam Renang' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-6 text-slate-400">
                                        <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-slate-300"></i>
                                        <p class="text-xs font-semibold">Jadwal latihan atlet belum diatur.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm mb-12">
                <i class="fa-solid fa-calendar text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Jadwal Atlet Prestasi Belum Tersedia</p>
            </div>
        @endif

        <!-- Note Box -->
        <div class="max-w-4xl mx-auto bg-[#101828] border border-[#D3AF37]/30 rounded-3xl p-6 sm:p-8 flex items-start gap-5 text-white shadow-xl">
            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-lg">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div>
                <h4 class="font-extrabold text-[#D3AF37] text-base mb-1">Informasi Penting Schedule Atlet</h4>
                <p class="text-sm text-slate-200 leading-relaxed font-normal">
                    Jadwal di atas merupakan jadwal latihan atlet reguler. Sesi latihan tambahan menjelang kejuaraan akan diinformasikan oleh pelatih secara langsung.
                </p>
            </div>
        </div>
    </section>

    <!-- Floating CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#D3AF37] mb-3 tracking-tight">Siap Bergabung dengan Tim Atlet Prestasi?</h2>
            <p class="text-slate-200 text-sm mb-8 leading-relaxed font-medium">Daftar sekarang dan konsultasikan jadwal seleksi atlet dengan tim pelatih kami.</p>
            <a href="{{ route('register') }}"
                class="px-8 py-4 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl shadow-xl transition-all hover:-translate-y-1 inline-block">
                Daftar Atlet Prestasi
            </a>
        </div>
    </section>
@endsection
