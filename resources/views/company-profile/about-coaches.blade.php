@extends('layouts.company-profile', ['title' => 'Tim Instruktur - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-user-tie"></i> Tim Instruktur
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Pelatih <span class="text-[#D3AF37]">Profesional</span> Kami
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Tim pelatih berlisensi yang berdedikasi tinggi membantu Anda menguasai keahlian renang dengan terstruktur, sabar, dan aman.
            </p>
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
            <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">PROFIL INSTRUKTUR</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kenalan Dengan Coach Kami</h2>
            <p class="text-slate-500 text-sm">Klik pada kartu profil pelatih untuk melihat rincian lisensi dan sertifikasi keahlian.</p>
        </div>

        @if ($coaches->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($coaches as $coach)
                    <div @click="openModal({
                            name: '{{ addslashes($coach->name) }}',
                            image: '{{ $coach->image ? asset('storage/' . $coach->image) : '' }}',
                            licenses: {{ Js::from(collect($coach->licenses ?? [])->map(function ($lic) {
                                if (is_string($lic)) return ['name' => $lic, 'file' => null];
                                return $lic;
                            })->values()) }},
                            certificates: {{ Js::from(collect($coach->certifications ?? [])->map(function ($cert) {
                                if (is_string($cert)) return ['name' => $cert, 'file' => null];
                                return $cert;
                            })->values()) }},
                            active: {{ Js::from($coach->experience ?? 'Belum ada informasi pengalaman') }}
                        })"
                        class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                        <!-- Photo Container -->
                        <div class="relative h-72 bg-slate-100 overflow-hidden">
                            @if ($coach->image)
                                <img src="{{ asset('storage/' . $coach->image) }}" alt="Foto {{ $coach->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#101828]">
                                    <i class="fa-solid fa-user-tie text-[#D3AF37] text-7xl"></i>
                                </div>
                            @endif
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                        </div>

                        <!-- Details -->
                        <div class="p-6 text-left">
                            <h3 class="font-extrabold text-slate-800 text-base mb-1 truncate">{{ $coach->name }}</h3>
                            <p class="text-xs text-[#D3AF37] font-bold uppercase tracking-wider mb-2">Instruktur Renang Profesional</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-user-tie text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Daftar Pelatih Belum Tersedia</p>
                <p class="text-sm text-slate-400">Kami sedang merekrut pelatih terbaik untuk bergabung bersama tim kami.</p>
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
                                            <div class="flex-1">
                                                <span class="text-sm text-slate-600 leading-relaxed" x-text="lic.name"></span>
                                                <template x-if="lic.file">
                                                    <a :href="'/storage/' + lic.file" target="_blank"
                                                       class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 hover:bg-[#D3AF37]/25 transition-colors">
                                                        <i class="fa-solid fa-file-arrow-down text-[9px]"></i> Lihat Dokumen
                                                    </a>
                                                </template>
                                            </div>
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
                                            <div class="flex-1">
                                                <span class="text-sm text-slate-600 leading-relaxed" x-text="cert.name"></span>
                                                <template x-if="cert.file">
                                                    <a :href="'/storage/' + cert.file" target="_blank"
                                                       class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 hover:bg-[#D3AF37]/25 transition-colors">
                                                        <i class="fa-solid fa-file-arrow-down text-[9px]"></i> Lihat Dokumen
                                                    </a>
                                                </template>
                                            </div>
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

    <!-- CTA Section -->
    <section class="py-16 my-16 md:my-24 max-w-7xl mx-4 sm:mx-6 lg:mx-auto bg-gradient-to-r from-[#0B0F17] via-[#1E1A0E] to-[#D3AF37] text-white text-center shadow-2xl rounded-3xl border border-[#D3AF37]/40 relative overflow-hidden">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="max-w-3xl mx-auto px-6 space-y-6 py-6 relative z-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-[#D3AF37] tracking-tight">Berlatih Bersama Pelatih Terbaik!</h2>
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
