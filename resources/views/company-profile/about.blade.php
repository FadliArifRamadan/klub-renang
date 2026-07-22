@extends('layouts.company-profile', ['title' => 'Tentang Kami - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-info-circle"></i> Profil Klub
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Tentang <span class="text-[#D3AF37]">Black Diamond</span> Swimming Club
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Klub renang profesional yang berkomitmen melahirkan generasi perenang tangguh, aman, dan berprestasi di
                Indonesia.
            </p>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Visi -->
            <div class="space-y-5">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-white">Visi Kami</h2>
                <p class="text-slate-300 leading-relaxed text-base">
                    Menjadi pusat pelatihan renang terdepan di Indonesia yang menghasilkan atlet berkarakter, berprestasi,
                    dan mencintai dunia olahraga air secara berkelanjutan.
                </p>
            </div>

            <!-- Misi -->
            <div class="space-y-5">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-white">Misi Kami</h2>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#D3AF37] mt-1 shrink-0"></i>
                        <span class="text-slate-300 leading-relaxed">Memberikan pelatihan renang yang terstruktur, aman, dan menyenangkan
                            bagi semua kalangan usia.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#D3AF37] mt-1 shrink-0"></i>
                        <span class="text-slate-300 leading-relaxed">Menghadirkan pelatih berlisensi dan berpengalaman yang berdedikasi
                            terhadap perkembangan setiap murid.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#D3AF37] mt-1 shrink-0"></i>
                        <span class="text-slate-300 leading-relaxed">Membangun lingkungan latihan yang positif, inklusif, dan mendukung
                            tumbuh kembang anak secara holistik.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#D3AF37] mt-1 shrink-0"></i>
                        <span class="text-slate-300 leading-relaxed">Memanfaatkan teknologi digital untuk pemantauan perkembangan murid
                            secara transparan dan efisien.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#D3AF37] mt-1 shrink-0"></i>
                        <span class="text-slate-300 leading-relaxed">Memperluas jangkauan fasilitas kolam renang berkualitas di berbagai
                            wilayah Indonesia.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section class="py-24 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">PERJALANAN KAMI</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Sejarah Black Diamond</h2>
                <p class="text-slate-500 text-sm">Dari awal yang sederhana hingga menjadi klub renang terpercaya.</p>
            </div>

            <div class="relative max-w-4xl mx-auto">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 -translate-x-0.5 top-0 bottom-0 w-0.5 bg-[#D3AF37]/30 hidden md:block"></div>

                <!-- Timeline Items -->
                <div class="space-y-12">
                    <!-- Item 1 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/2 md:text-right md:pr-12">
                            <span class="text-xs font-bold text-[#D3AF37] uppercase tracking-widest block mb-1">2018</span>
                            <h3 class="text-lg font-extrabold text-slate-800 mb-2">Berdirinya Black Diamond</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">Dimulai oleh sekelompok pelatih renang
                                berpengalaman dengan satu kolam renang dan 20 murid pertama di Bandung.</p>
                        </div>
                        <div
                            class="relative z-10 w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-extrabold shrink-0 shadow-sm">
                            <i class="fa-solid fa-flag text-sm"></i>
                        </div>
                        <div class="md:w-1/2 md:pl-12 hidden md:block"></div>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/2 md:pr-12 hidden md:block"></div>
                        <div
                            class="relative z-10 w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-extrabold shrink-0 shadow-sm">
                            <i class="fa-solid fa-trophy text-sm"></i>
                        </div>
                        <div class="md:w-1/2 md:pl-12">
                            <span class="text-xs font-bold text-[#D3AF37] uppercase tracking-widest block mb-1">2020</span>
                            <h3 class="text-lg font-extrabold text-slate-800 mb-2">Ekspansi ke 3 Lokasi</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">Setelah dua tahun beroperasi, kami berhasil
                                membuka 2 lokasi kolam renang baru dan merekrut 5 pelatih berlisensi tambahan.</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/2 md:text-right md:pr-12">
                            <span class="text-xs font-bold text-[#D3AF37] uppercase tracking-widest block mb-1">2022</span>
                            <h3 class="text-lg font-extrabold text-slate-800 mb-2">Digitalisasi Manajemen Klub</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">Peluncuran platform digital untuk pemantauan
                                absensi, laporan perkembangan, dan manajemen pembayaran secara online.</p>
                        </div>
                        <div
                            class="relative z-10 w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-extrabold shrink-0 shadow-sm">
                            <i class="fa-solid fa-laptop text-sm"></i>
                        </div>
                        <div class="md:w-1/2 md:pl-12 hidden md:block"></div>
                    </div>

                    <!-- Item 4 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/2 md:pr-12 hidden md:block"></div>
                        <div
                            class="relative z-10 w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center font-extrabold shrink-0 shadow-sm">
                            <i class="fa-solid fa-star text-sm"></i>
                        </div>
                        <div class="md:w-1/2 md:pl-12">
                            <span class="text-xs font-bold text-[#D3AF37] uppercase tracking-widest block mb-1">2024 -
                                Sekarang</span>
                            <h3 class="text-lg font-extrabold text-slate-800 mb-2">500+ Murid & Terus Berkembang</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">Kini kami telah melayani lebih dari 500 murid
                                aktif dengan 5+ kolam renang dan tim pelatih profesional yang terus bertumbuh.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai-Nilai Kami -->
    <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">NILAI-NILAI KAMI</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Landasan Kami Berlatih</h2>
            <p class="text-slate-500 text-sm">Nilai-nilai inti yang menjadi fondasi dalam setiap sesi latihan dan pelayanan
                kami.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div
                class="bg-white rounded-3xl border border-slate-200 p-8 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mx-auto mb-5 text-2xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-2">Keamanan</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Keselamatan murid adalah prioritas utama di setiap sesi
                    latihan.</p>
            </div>
            <div
                class="bg-white rounded-3xl border border-slate-200 p-8 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mx-auto mb-5 text-2xl">
                    <i class="fa-solid fa-medal"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-2">Profesionalisme</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Setiap pelatih kami berlisensi resmi dan terus
                    meningkatkan kompetensi.</p>
            </div>
            <div
                class="bg-white rounded-3xl border border-slate-200 p-8 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mx-auto mb-5 text-2xl">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-2">Dedikasi</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Kami sepenuh hati mendukung perkembangan setiap murid
                    tanpa terkecuali.</p>
            </div>
            <div
                class="bg-white rounded-3xl border border-slate-200 p-8 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div
                    class="w-14 h-14 rounded-2xl bg-[#101828] text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center mx-auto mb-5 text-2xl">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-2">Komunitas</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Membangun komunitas perenang yang saling mendukung dan
                    menginspirasi.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl border-y border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-3xl mx-auto px-6 space-y-6 py-10 relative z-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-[#D3AF37] tracking-tight">Siap Bergabung Bersama Kami?</h2>
            <p class="text-slate-200 text-base mb-8 leading-relaxed font-medium">Daftarkan diri Anda atau anak Anda sekarang dan mulailah
                perjalanan renang yang luar biasa bersama Black Diamond.</p>
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

    <!-- Tim Instruktur Section -->
    <section x-data="{ 
        showModal: false, 
        coach: { name: '', image: '', licenses: [], certificates: [], active: '' },
        openModal(data) {
            this.coach = data;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = '';
        }
    }" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">TIM INSTRUKTUR KAMI</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kenalan Dengan Coach Profesional
                Kami</h2>
            <p class="text-slate-500 text-sm">Tim pelatih yang berdedikasi tinggi membantu Anda menguasai keahlian renang
                dengan sabar, terstruktur, dan aman.</p>
        </div>

        @if ($coaches->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($coaches as $coach)
                    <div @click="openModal({
                            name: '{{ addslashes($coach->name) }}',
                            image: '{{ $coach->image ? asset('storage/' . $coach->image) : '' }}',
                            licenses: {{ Js::from($coach->licenses ?? []) }},
                            certificates: {{ Js::from($coach->certifications ?? []) }},
                            active: {{ Js::from($coach->experience ?? 'Belum ada informasi pengalaman') }}
                        })"
                        class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                        <!-- Photo Container -->
                        <div class="relative h-72 bg-slate-100 overflow-hidden">
                            @if ($coach->image)
                                <img src="{{ asset('storage/' . $coach->image) }}" alt="Foto {{ $coach->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-[#101828]">
                                    <i class="fa-solid fa-user-tie text-[#D3AF37] text-7xl"></i>
                                </div>
                            @endif
                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent">
                            </div>

                            <!-- Removed WhatsApp Badge -->
                        </div>

                        <!-- Details -->
                        <div class="p-6 text-left">
                            <h3 class="font-extrabold text-slate-800 text-base mb-1 truncate">{{ $coach->name }}</h3>
                            <p class="text-xs text-[#D3AF37] font-bold uppercase tracking-wider mb-2">Instruktur Renang
                                Profesional</p>
                            <!-- Removed Phone Number -->
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-user-tie text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Daftar Pelatih Belum Tersedia</p>
                <p class="text-sm text-slate-400">Kami sedang merekrut pelatih terbaik untuk bergabung bersama tim kami.
                </p>
            </div>
        @endif

        <!-- Coach Details Modal -->
        <div x-show="showModal" 
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <!-- Modal Overlay -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="closeModal()"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal Panel -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl mx-auto overflow-hidden transition-all flex flex-col md:flex-row">
                 
                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-white/50 hover:bg-white text-slate-800 backdrop-blur transition-colors shadow-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Modal Left (Photo) -->
                <div class="relative h-64 md:h-auto md:w-1/2 bg-slate-100 overflow-hidden shrink-0">
                    <template x-if="coach.image">
                        <img :src="coach.image" :alt="'Foto ' + coach.name" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!coach.image">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
                            <i class="fa-solid fa-user-tie text-blue-200 text-7xl"></i>
                        </div>
                    </template>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h3 class="text-2xl font-extrabold mb-1" x-text="coach.name"></h3>
                        <p class="text-sm text-[#D3AF37] font-bold uppercase tracking-wider">Instruktur Renang Profesional</p>
                    </div>
                </div>

                <!-- Modal Right (Details) -->
                <div class="p-6 sm:p-8 md:p-10 overflow-y-auto md:w-1/2 max-h-[80vh]">
                    <div class="space-y-8">
                        
                        <!-- Lisensi -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-id-card text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-extrabold text-slate-800 mb-2">Lisensi</h4>
                                <ul class="space-y-2">
                                    <template x-for="lic in coach.licenses">
                                        <li class="flex items-start gap-2">
                                            <i class="fa-solid fa-check text-[#D3AF37] mt-1 text-xs"></i>
                                            <span class="text-sm text-slate-600 leading-relaxed" x-text="lic"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Sertifikat -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-award text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-extrabold text-slate-800 mb-2">Sertifikasi Keahlian</h4>
                                <ul class="space-y-2">
                                    <template x-for="cert in coach.certificates">
                                        <li class="flex items-start gap-2">
                                            <i class="fa-solid fa-check text-[#D3AF37] mt-1 text-xs"></i>
                                            <span class="text-sm text-slate-600 leading-relaxed" x-text="cert"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- Aktif Melatih -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-person-swimming text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-extrabold text-slate-800 mb-1">Pengalaman & Status</h4>
                                <p class="text-sm text-slate-600 leading-relaxed" x-text="coach.active"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
