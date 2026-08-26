@extends('layouts.company-profile', ['title' => 'Founders - Black Diamond Swimming Club'])

@section('content')
    <!-- Page Hero -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 bg-[#0B0F17] text-white overflow-hidden border-b border-[#D3AF37]/30">
        <div class="absolute inset-0 hero-pattern opacity-10"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#D3AF37]/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] text-xs font-extrabold uppercase tracking-wider mb-6">
                <i class="fa-solid fa-crown"></i> Founders
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight mb-6 text-white">
                Para <span class="text-[#D3AF37]">Pendiri</span> Kami
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8 font-normal">
                Mengenal lebih dekat para visioner di balik berdirinya Black Diamond Swimming Club yang berdedikasi untuk mengembangkan olahraga renang Indonesia.
            </p>
        </div>
    </section>

    <!-- Founders Section -->
    <section x-data="{ 
        showModal: false, 
        founder: { name: '', position: '', image: '', bio: '', social_media: {} },
        openModal(data) {
            this.founder = data;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = '';
        }
    }" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-xs font-extrabold text-[#D3AF37] uppercase tracking-widest block">PROFIL FOUNDERS</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kenalan Dengan Pendiri Kami</h2>
            <p class="text-slate-500 text-sm">Klik pada kartu profil untuk melihat informasi lebih lanjut tentang para pendiri.</p>
        </div>

        @if ($founders->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $founders->count() >= 4 ? '4' : $founders->count() }} gap-8 {{ $founders->count() < 4 ? 'max-w-4xl mx-auto' : '' }}">
                @foreach ($founders as $founder)
                    <div @click="openModal({
                            name: '{{ addslashes($founder->name) }}',
                            position: '{{ addslashes($founder->position) }}',
                            image: '{{ $founder->image ? asset('storage/' . $founder->image) : '' }}',
                            bio: {{ Js::from($founder->bio ?? 'Belum ada informasi bio.') }},
                            social_media: {{ Js::from($founder->social_media ?? []) }}
                        })"
                        class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                        <!-- Photo Container -->
                        <div class="relative h-72 bg-slate-100 overflow-hidden">
                            @if ($founder->image)
                                <img src="{{ asset('storage/' . $founder->image) }}" alt="Foto {{ $founder->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#101828]">
                                    <i class="fa-solid fa-crown text-[#D3AF37] text-7xl"></i>
                                </div>
                            @endif
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                        </div>

                        <!-- Details -->
                        <div class="p-6 text-left">
                            <h3 class="font-extrabold text-slate-800 text-base mb-1 truncate">{{ $founder->name }}</h3>
                            <p class="text-xs text-[#D3AF37] font-bold uppercase tracking-wider mb-2">{{ $founder->position }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200 shadow-sm">
                <i class="fa-solid fa-crown text-5xl mb-4 text-slate-300"></i>
                <p class="font-bold text-slate-500 text-lg mb-2">Daftar Founders Belum Tersedia</p>
                <p class="text-sm text-slate-400">Informasi tentang para pendiri akan segera ditampilkan.</p>
            </div>
        @endif

        <!-- Founder Details Modal -->
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
                    <template x-if="founder.image">
                        <img :src="founder.image" :alt="'Foto ' + founder.name" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!founder.image">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#101828] to-[#1a2744]">
                            <i class="fa-solid fa-crown text-[#D3AF37] text-7xl"></i>
                        </div>
                    </template>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h3 class="text-2xl font-extrabold mb-1" x-text="founder.name"></h3>
                        <p class="text-sm text-[#D3AF37] font-bold uppercase tracking-wider" x-text="founder.position"></p>
                    </div>
                </div>

                <!-- Modal Right (Details) -->
                <div class="p-6 sm:p-8 md:p-10 overflow-y-auto md:w-1/2 max-h-[80vh]">
                    <div class="space-y-8">
                        
                        <!-- Bio -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-quote-left text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-extrabold text-slate-800 mb-2">Tentang</h4>
                                <p class="text-sm text-slate-600 leading-relaxed" x-text="founder.bio"></p>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-share-nodes text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-extrabold text-slate-800 mb-3">Sosial Media</h4>
                                <div class="flex flex-wrap gap-3">
                                    <template x-if="founder.social_media.instagram">
                                        <a :href="founder.social_media.instagram.startsWith('http') ? founder.social_media.instagram : 'https://instagram.com/' + founder.social_media.instagram.replace('@', '')" 
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-purple-500/10 to-pink-500/10 text-pink-600 border border-pink-200 hover:from-purple-500/20 hover:to-pink-500/20 transition-colors">
                                            <i class="fa-brands fa-instagram"></i>
                                            <span x-text="founder.social_media.instagram"></span>
                                        </a>
                                    </template>
                                    <template x-if="founder.social_media.linkedin">
                                        <a :href="founder.social_media.linkedin.startsWith('http') ? founder.social_media.linkedin : 'https://linkedin.com/in/' + founder.social_media.linkedin" 
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 transition-colors">
                                            <i class="fa-brands fa-linkedin"></i>
                                            <span>LinkedIn</span>
                                        </a>
                                    </template>
                                    <template x-if="founder.social_media.tiktok">
                                        <a :href="founder.social_media.tiktok.startsWith('http') ? founder.social_media.tiktok : 'https://tiktok.com/@' + founder.social_media.tiktok.replace('@', '')" 
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-700 border border-slate-200 hover:bg-slate-200 transition-colors">
                                            <i class="fa-brands fa-tiktok"></i>
                                            <span x-text="founder.social_media.tiktok"></span>
                                        </a>
                                    </template>
                                    <template x-if="!founder.social_media.instagram && !founder.social_media.linkedin && !founder.social_media.tiktok">
                                        <p class="text-sm text-slate-400">Belum ada informasi sosial media.</p>
                                    </template>
                                </div>
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
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-[#D3AF37] tracking-tight">Bergabung Bersama Black Diamond!</h2>
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
