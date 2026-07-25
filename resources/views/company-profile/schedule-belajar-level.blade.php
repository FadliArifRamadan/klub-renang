@extends('layouts.company-profile', ['title' => 'Jadwal Latihan Kelas Belajar Renang ' . $swimmingClass->name . ' - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-calendar-days"></i> Jadwal Latihan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Jadwal Kelas Belajar <span class="text-[#D3AF37]">{{ $swimmingClass->name }}</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Jadwal sesi latihan reguler khusus tingkat {{ $swimmingClass->name }} (Usia {{ $swimmingClass->age_min }}{{ $swimmingClass->age_max ? '-' . $swimmingClass->age_max : '+' }} Tahun).
            </p>
        </div>
    </section>

    <!-- Schedule Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $sortedSchedules = $swimmingClass->schedules->sortBy('day_of_week');
        @endphp

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden text-left hover:shadow-md transition-all">
                <div class="bg-[#101828] border-b border-[#D3AF37]/30 text-[#D3AF37] px-8 py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="font-extrabold text-2xl text-white">
                            Tingkat {{ $swimmingClass->name }}
                        </h3>
                        <p class="text-xs text-slate-300 mt-1 font-semibold">{{ $swimmingClass->description }}</p>
                    </div>
                    <span class="text-xs bg-[#D3AF37] text-[#101828] font-extrabold px-4 py-1.5 rounded-full shrink-0">
                        Usia {{ $swimmingClass->age_min }}{{ $swimmingClass->age_max ? '-' . $swimmingClass->age_max : '+' }} Tahun
                    </span>
                </div>

                <div class="p-8 space-y-4">
                    @if($sortedSchedules->isNotEmpty())
                        @foreach($sortedSchedules as $sched)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-slate-50 hover:bg-slate-100/80 rounded-2xl border border-slate-200/80 transition-colors gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-extrabold text-base shrink-0 shadow-sm">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-base font-extrabold text-slate-800">
                                            Hari {{ $days[$sched->day_of_week] ?? 'Hari Lain' }}
                                        </p>
                                        <p class="text-xs text-slate-500 font-bold mt-0.5">
                                            Sesi: {{ substr($sched->start_time, 0, 5) }} – {{ substr($sched->end_time, 0, 5) }} WIB
                                        </p>
                                    </div>
                                </div>
                                <div class="flex sm:flex-col items-center sm:items-end justify-between border-t sm:border-0 pt-3 sm:pt-0 border-slate-200">
                                    <span class="inline-block text-xs bg-amber-100 border border-amber-200 text-amber-800 font-extrabold px-3 py-1 rounded-full mb-1">
                                        {{ $sched->session_type === 'dryland' ? 'Dryland (Latihan Darat)' : 'Sesi Berenang' }}
                                    </span>
                                    <p class="text-xs text-slate-600 font-bold flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-[#D3AF37]"></i> {{ $sched->location->name ?? 'Kolam Renang' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-calendar-xmark text-4xl mb-3 text-slate-300"></i>
                            <p class="text-sm font-bold text-slate-500">Jadwal latihan reguler belum diatur untuk tingkat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Note Box -->
        <div class="max-w-4xl mx-auto mt-12 bg-[#101828] border border-[#D3AF37]/30 rounded-3xl p-6 sm:p-8 flex items-start gap-5 text-white shadow-xl">
            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0 text-lg">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div>
                <h4 class="font-extrabold text-[#D3AF37] text-base mb-1">Informasi Penting Schedule</h4>
                <p class="text-sm text-slate-200 leading-relaxed font-normal">
                    Jadwal di atas merupakan jadwal sesi reguler. Waktu latihan spesifik dan penetapan pelatih akan dikonfirmasi oleh admin setelah pendaftaran Anda diverifikasi.
                </p>
            </div>
        </div>
    </section>

    <!-- Floating CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#D3AF37] mb-3 tracking-tight">Siap Memulai Latihan Tingkat {{ $swimmingClass->name }}?</h2>
            <p class="text-slate-200 text-sm mb-8 leading-relaxed font-medium">Daftar sekarang dan tim kami akan mengonfirmasi jadwal sesi pertama Anda.</p>
            <a href="{{ route('register') }}"
                class="px-8 py-4 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-extrabold rounded-2xl shadow-xl transition-all hover:-translate-y-1 inline-block">
                Daftar & Mulai Latihan
            </a>
        </div>
    </section>
@endsection
