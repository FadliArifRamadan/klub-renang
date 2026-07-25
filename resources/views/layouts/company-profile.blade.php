<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Black Diamond Swimming Club' }}</title>

    <!-- Fonts & Icons -->
    <link rel="icon" href="{{ asset('images/black_diamond_1.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles (Tailwind via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 0), radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 0);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }

        /* Floating WhatsApp Button Style */
        .float-wa {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 24px;
            right: 24px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: pulse-wa 2s infinite;
        }

        .float-wa:hover {
            background-color: #128c7e;
            transform: scale(1.15) rotate(10deg);
            box-shadow: 0 8px 25px rgba(18, 140, 126, 0.6);
            color: #fff;
        }

        @keyframes pulse-wa {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        @media (max-width: 640px) {
            .float-wa {
                width: 50px;
                height: 50px;
                bottom: 16px;
                right: 16px;
                font-size: 26px;
            }
        }
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800 overflow-x-hidden" x-data="{ mobileMenuOpen: false }">

    <!-- Top Sticky Header -->
    <header
        class="fixed top-0 left-0 w-full z-50 bg-[#D3AF37] shadow-md border-b border-[#101828]/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/black_diamond_1.png') }}" alt="Black Diamond Logo"
                            class="h-16 w-auto object-contain">
                    </a>
                </div>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('welcome') }}"
                        class="text-sm font-bold transition-colors {{ request()->routeIs('welcome') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">Home</a>
                    <!-- Dropdown Tentang Kami -->
                    <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                        <button type="button" class="flex items-center gap-1.5 text-sm font-bold transition-colors py-2 {{ request()->routeIs('about*') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">
                            <span>Tentang Kami</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full pt-2 w-60 z-50"
                            style="display: none;">
                            <div class="bg-[#101828] border border-[#D3AF37]/40 shadow-2xl rounded-2xl p-2 text-white overflow-hidden">
                                <a href="{{ route('about.vision-mission') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors {{ request()->routeIs('about.vision-mission') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                    <i class="fa-solid fa-bullseye text-[#D3AF37] w-5 text-center {{ request()->routeIs('about.vision-mission') ? 'text-[#101828]' : '' }}"></i>
                                    <span>Visi & Misi</span>
                                </a>
                                <a href="{{ route('about.history') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors {{ request()->routeIs('about.history') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                    <i class="fa-solid fa-timeline text-[#D3AF37] w-5 text-center {{ request()->routeIs('about.history') ? 'text-[#101828]' : '' }}"></i>
                                    <span>Sejarah & Perjalanan</span>
                                </a>
                                <a href="{{ route('about.coaches') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors {{ request()->routeIs('about.coaches') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                    <i class="fa-solid fa-user-tie text-[#D3AF37] w-5 text-center {{ request()->routeIs('about.coaches') ? 'text-[#101828]' : '' }}"></i>
                                    <span>Tim Instruktur</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Dropdown Program Paket -->
                    <div x-data="{ open: false, subOpen: false }" @mouseenter="open = true" @mouseleave="open = false; subOpen = false" class="relative">
                        <button type="button" class="flex items-center gap-1.5 text-sm font-bold transition-colors py-2 {{ request()->routeIs('packages*') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">
                            <span>Program Paket</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full pt-2 w-64 z-50"
                            style="display: none;">
                            <div class="bg-[#101828] border border-[#D3AF37]/40 shadow-2xl rounded-2xl p-2 text-white relative">
                                <!-- Nested Submenu Trigger for Kelas Belajar -->
                                <div class="relative" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <div class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-bold transition-colors cursor-pointer {{ request()->routeIs('packages.belajar*') ? 'bg-[#D3AF37]/20 text-[#D3AF37]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                        <div class="flex items-center gap-3">
                                            <i class="fa-solid fa-person-swimming text-[#D3AF37] w-5 text-center"></i>
                                            <span>Kelas Belajar Renang</span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-xs opacity-75"></i>
                                    </div>

                                    <!-- Flyout Submenu for Class Levels -->
                                    <div x-show="subOpen"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 translate-x-2"
                                        x-transition:enter-end="opacity-100 translate-x-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100 translate-x-0"
                                        x-transition:leave-end="opacity-0 translate-x-2"
                                        class="absolute left-full top-0 pl-2 w-56 z-50"
                                        style="display: none;">
                                        <div class="bg-[#101828] border border-[#D3AF37]/40 shadow-2xl rounded-2xl p-2 text-white space-y-1">
                                            <a href="{{ route('packages.belajar.level', 'batita') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('program-paket/belajar/batita') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-baby text-[#D3AF37] w-4 text-center {{ request()->is('program-paket/belajar/batita') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Batita (1-3 Thn)</span>
                                            </a>
                                            <a href="{{ route('packages.belajar.level', 'balita') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('program-paket/belajar/balita') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-child text-[#D3AF37] w-4 text-center {{ request()->is('program-paket/belajar/balita') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Balita (4-5 Thn)</span>
                                            </a>
                                            <a href="{{ route('packages.belajar.level', 'anak-anak') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('program-paket/belajar/anak-anak') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-child-reaching text-[#D3AF37] w-4 text-center {{ request()->is('program-paket/belajar/anak-anak') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Anak (6-12 Thn)</span>
                                            </a>
                                            <a href="{{ route('packages.belajar.level', 'dewasa') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('program-paket/belajar/dewasa') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-user text-[#D3AF37] w-4 text-center {{ request()->is('program-paket/belajar/dewasa') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Dewasa (13+ Thn)</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('packages.prestasi') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors {{ request()->routeIs('packages.prestasi') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                    <i class="fa-solid fa-trophy text-[#D3AF37] w-5 text-center {{ request()->routeIs('packages.prestasi') ? 'text-[#101828]' : '' }}"></i>
                                    <span>Kelas Renang Prestasi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('locations') }}"
                        class="text-sm font-bold transition-colors {{ request()->routeIs('locations') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">Kolam
                        Latihan</a>
                    <!-- Dropdown Jadwal Latihan -->
                    <div x-data="{ open: false, subOpen: false }" @mouseenter="open = true" @mouseleave="open = false; subOpen = false" class="relative">
                        <button type="button" class="flex items-center gap-1.5 text-sm font-bold transition-colors py-2 {{ request()->routeIs('schedule*') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">
                            <span>Jadwal Latihan</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full pt-2 w-64 z-50"
                            style="display: none;">
                            <div class="bg-[#101828] border border-[#D3AF37]/40 shadow-2xl rounded-2xl p-2 text-white relative">
                                <!-- Nested Submenu Trigger for Kelas Belajar -->
                                <div class="relative" @mouseenter="subOpen = true" @mouseleave="subOpen = false">
                                    <div class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-bold transition-colors cursor-pointer {{ request()->routeIs('schedule.belajar*') ? 'bg-[#D3AF37]/20 text-[#D3AF37]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                        <div class="flex items-center gap-3">
                                            <i class="fa-solid fa-person-swimming text-[#D3AF37] w-5 text-center"></i>
                                            <span>Kelas Belajar Renang</span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-xs opacity-75"></i>
                                    </div>

                                    <!-- Flyout Submenu for Class Levels -->
                                    <div x-show="subOpen"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 translate-x-2"
                                        x-transition:enter-end="opacity-100 translate-x-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100 translate-x-0"
                                        x-transition:leave-end="opacity-0 translate-x-2"
                                        class="absolute left-full top-0 pl-2 w-56 z-50"
                                        style="display: none;">
                                        <div class="bg-[#101828] border border-[#D3AF37]/40 shadow-2xl rounded-2xl p-2 text-white space-y-1">
                                            <a href="{{ route('schedule.belajar.level', 'batita') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('jadwal-latihan/belajar/batita') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-baby text-[#D3AF37] w-4 text-center {{ request()->is('jadwal-latihan/belajar/batita') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Batita (1-3 Thn)</span>
                                            </a>
                                            <a href="{{ route('schedule.belajar.level', 'balita') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('jadwal-latihan/belajar/balita') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-child text-[#D3AF37] w-4 text-center {{ request()->is('jadwal-latihan/belajar/balita') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Balita (4-5 Thn)</span>
                                            </a>
                                            <a href="{{ route('schedule.belajar.level', 'anak-anak') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('jadwal-latihan/belajar/anak-anak') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-child-reaching text-[#D3AF37] w-4 text-center {{ request()->is('jadwal-latihan/belajar/anak-anak') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Anak (6-12 Thn)</span>
                                            </a>
                                            <a href="{{ route('schedule.belajar.level', 'dewasa') }}"
                                                class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ request()->is('jadwal-latihan/belajar/dewasa') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                                <i class="fa-solid fa-user text-[#D3AF37] w-4 text-center {{ request()->is('jadwal-latihan/belajar/dewasa') ? 'text-[#101828]' : '' }}"></i>
                                                <span>Tingkat Dewasa (13+ Thn)</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('schedule.prestasi') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold transition-colors {{ request()->routeIs('schedule.prestasi') ? 'bg-[#D3AF37] text-[#101828]' : 'text-slate-200 hover:bg-[#D3AF37]/20 hover:text-[#D3AF37]' }}">
                                    <i class="fa-solid fa-trophy text-[#D3AF37] w-5 text-center {{ request()->routeIs('schedule.prestasi') ? 'text-[#101828]' : '' }}"></i>
                                    <span>Kelas Renang Prestasi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}"
                        class="text-sm font-bold transition-colors {{ request()->routeIs('contact') ? 'text-[#101828] underline underline-offset-4 decoration-2 font-extrabold' : 'text-[#101828]/80 hover:text-[#101828]' }}">Kontak
                        Kami</a>
                </nav>

                <!-- Desktop Access Action Buttons -->
                <div class="hidden lg:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-[#101828] hover:bg-black text-[#D3AF37] text-sm font-extrabold rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Portal Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold text-[#101828] hover:text-black transition-colors px-4 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-[#101828] hover:bg-black text-[#D3AF37] text-sm font-extrabold rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2.5 rounded-xl text-[#101828] hover:bg-black/10 transition-colors">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }"
                                class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Slide-out Menu Panel -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="lg:hidden bg-[#D3AF37] border-b border-[#101828]/20 absolute top-20 left-0 w-full shadow-lg"
            style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a @click="mobileMenuOpen = false" href="{{ route('welcome') }}"
                    class="block px-4 py-3 text-base font-bold rounded-xl {{ request()->routeIs('welcome') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">Home</a>
                <div x-data="{ open: {{ request()->routeIs('about*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-base font-bold rounded-xl text-[#101828] hover:bg-black/10">
                        <span>Tentang Kami</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" class="pl-4 pr-2 py-1 space-y-1">
                        <a @click="mobileMenuOpen = false" href="{{ route('about.vision-mission') }}"
                            class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('about.vision-mission') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                            <i class="fa-solid fa-bullseye mr-2"></i> Visi & Misi
                        </a>
                        <a @click="mobileMenuOpen = false" href="{{ route('about.history') }}"
                            class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('about.history') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                            <i class="fa-solid fa-timeline mr-2"></i> Sejarah & Perjalanan
                        </a>
                        <a @click="mobileMenuOpen = false" href="{{ route('about.coaches') }}"
                            class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('about.coaches') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                            <i class="fa-solid fa-user-tie mr-2"></i> Tim Instruktur
                        </a>
                    </div>
                </div>
                <div x-data="{ open: {{ request()->routeIs('packages*') ? 'true' : 'false' }}, subOpen: true }">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-base font-bold rounded-xl text-[#101828] hover:bg-black/10">
                        <span>Program Paket</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" class="pl-4 pr-2 py-1 space-y-1">
                        <!-- Sub-accordion for Kelas Belajar -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between px-4 py-2.5 text-sm font-bold text-[#101828] rounded-xl hover:bg-black/10">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-person-swimming"></i> Kelas Belajar Renang
                                </span>
                                <button @click="subOpen = !subOpen" type="button" class="p-1 text-slate-700">
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': subOpen }"></i>
                                </button>
                            </div>
                            <div x-show="subOpen" class="pl-6 space-y-1">
                                <a @click="mobileMenuOpen = false" href="{{ route('packages.belajar.level', 'batita') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('program-paket/belajar/batita') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Batita (1-3 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('packages.belajar.level', 'balita') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('program-paket/belajar/balita') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Balita (4-5 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('packages.belajar.level', 'anak-anak') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('program-paket/belajar/anak-anak') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Anak (6-12 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('packages.belajar.level', 'dewasa') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('program-paket/belajar/dewasa') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                                    • Tingkat Dewasa (13+ Thn)
                                </a>
                            </div>
                        </div>

                        <a @click="mobileMenuOpen = false" href="{{ route('packages.prestasi') }}"
                            class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('packages.prestasi') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                            <i class="fa-solid fa-trophy mr-2"></i> Kelas Renang Prestasi
                        </a>
                    </div>
                </div>
                <a @click="mobileMenuOpen = false" href="{{ route('locations') }}"
                    class="block px-4 py-3 text-base font-bold rounded-xl {{ request()->routeIs('locations') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">Kolam
                    Latihan</a>
                <div x-data="{ open: {{ request()->routeIs('schedule*') ? 'true' : 'false' }}, subOpen: true }">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-base font-bold rounded-xl text-[#101828] hover:bg-black/10">
                        <span>Jadwal Latihan</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" class="pl-4 pr-2 py-1 space-y-1">
                        <!-- Sub-accordion for Kelas Belajar -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between px-4 py-2.5 text-sm font-bold text-[#101828] rounded-xl hover:bg-black/10">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-person-swimming"></i> Kelas Belajar Renang
                                </span>
                                <button @click="subOpen = !subOpen" type="button" class="p-1 text-slate-700">
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': subOpen }"></i>
                                </button>
                            </div>
                            <div x-show="subOpen" class="pl-6 space-y-1">
                                <a @click="mobileMenuOpen = false" href="{{ route('schedule.belajar.level', 'batita') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('jadwal-latihan/belajar/batita') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Batita (1-3 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('schedule.belajar.level', 'balita') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('jadwal-latihan/belajar/balita') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Balita (4-5 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('schedule.belajar.level', 'anak-anak') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('jadwal-latihan/belajar/anak-anak') ? 'bg-[#101828] text-[#D3AF37]' : 'text-slate-800 hover:bg-black/10' }}">
                                    • Tingkat Anak (6-12 Thn)
                                </a>
                                <a @click="mobileMenuOpen = false" href="{{ route('schedule.belajar.level', 'dewasa') }}"
                                    class="block px-3 py-2 text-xs font-bold rounded-lg {{ request()->is('jadwal-latihan/belajar/dewasa') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                                    • Tingkat Dewasa (13+ Thn)
                                </a>
                            </div>
                        </div>

                        <a @click="mobileMenuOpen = false" href="{{ route('schedule.prestasi') }}"
                            class="block px-4 py-2.5 text-sm font-bold rounded-xl {{ request()->routeIs('schedule.prestasi') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">
                            <i class="fa-solid fa-trophy mr-2"></i> Kelas Renang Prestasi
                        </a>
                    </div>
                </div>
                <a @click="mobileMenuOpen = false" href="{{ route('contact') }}"
                    class="block px-4 py-3 text-base font-bold rounded-xl {{ request()->routeIs('contact') ? 'bg-[#101828] text-[#D3AF37]' : 'text-[#101828] hover:bg-black/10' }}">Kontak
                    Kami</a>

                <div class="pt-4 border-t border-[#101828]/20 flex flex-col gap-3 px-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="w-full text-center py-3 bg-[#101828] text-[#D3AF37] font-extrabold rounded-xl shadow-md">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Portal Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full text-center py-3 text-[#101828] font-bold border border-[#101828] rounded-xl hover:bg-black/10">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full text-center py-3 bg-[#101828] text-[#D3AF37] font-extrabold rounded-xl shadow-md">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-[#D3AF37] text-[#101828] pt-16 pb-12 border-t border-[#101828]/10 text-left">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Left Info Branding -->
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/black_diamond_1.png') }}" alt="Black Diamond Logo"
                            class="w-auto h-16 object-contain">
                    </a>
                </div>
                <p class="text-sm text-[#101828]/90 font-medium leading-relaxed max-w-sm">
                    Klub renang terkemuka untuk melatih keterampilan, keamanan, dan kebugaran tubuh dalam air. Kami siap
                    melatih perenang sejati.
                </p>
            </div>

            <!-- Center Menu Links -->
            <div class="space-y-4">
                <h4 class="font-extrabold text-sm tracking-wider uppercase text-[#101828]">Navigasi Halaman</h4>
                <ul class="space-y-2.5 text-sm text-[#101828]/90 font-bold">
                    <li><a href="{{ route('welcome') }}" class="hover:text-black hover:underline transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-black hover:underline transition-colors">Tentang Kami</a>
                    </li>
                    <li><a href="{{ route('packages') }}" class="hover:text-black hover:underline transition-colors">Program
                            Paket</a></li>
                    <li><a href="{{ route('locations') }}" class="hover:text-black hover:underline transition-colors">Kolam
                            Latihan</a></li>
                    <li><a href="{{ route('schedule') }}" class="hover:text-black hover:underline transition-colors">Jadwal
                            Latihan</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-black hover:underline transition-colors">Kontak
                            Kami</a></li>
                </ul>
            </div>

            <!-- Right Contact Support -->
            <div class="space-y-4">
                <h4 class="font-extrabold text-sm tracking-wider uppercase text-[#101828]">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-sm text-[#101828]/90 font-bold">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-[#101828]"></i>
                        <span>support@blackdiamond.club</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-[#101828]"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-clock text-[#101828]"></i>
                        <span>Setiap Hari (06:00 - 18:00 WIB)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-[#101828]/20 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-[#101828]/80 font-bold">
            <p>&copy; {{ date('Y') }} Black Diamond Swimming Club. Hak Cipta Dilindungi.</p>
            <p>Made with <i class="fa-solid fa-heart text-rose-600"></i> in Indonesia</p>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a class="float-wa"
        href="https://api.whatsapp.com/send/?phone=6287881203283&amp;text=Halo+Admin+Black+Diamond+Swimming+Club%2C+saya+ingin+tanya-tanya+mengenai+paket+dan+jadwal+latihan+renang.&amp;type=phone_number&amp;app_absent=0"
        target="_blank" title="Hubungi CS Black Diamond via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>

</html>
