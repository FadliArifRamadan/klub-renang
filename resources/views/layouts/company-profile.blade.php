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
        class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all duration-300">
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
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('welcome') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Home</a>
                    <a href="{{ route('about') }}"
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('about') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Tentang Kami</a>
                    <a href="{{ route('packages') }}"
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('packages') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Program Paket</a>
                    <a href="{{ route('locations') }}"
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('locations') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Kolam Latihan</a>
                    <a href="{{ route('schedule') }}"
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('schedule') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Jadwal Latihan</a>
                    <a href="{{ route('contact') }}"
                        class="text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'text-blue-600' : 'text-slate-650 hover:text-blue-600' }}">Kontak Kami</a>
                </nav>

                <!-- Desktop Access Action Buttons -->
                <div class="hidden lg:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Portal Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold text-slate-650 hover:text-blue-600 transition-colors px-4 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
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
            class="lg:hidden bg-white border-b border-slate-150 absolute top-20 left-0 w-full shadow-lg"
            style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a @click="mobileMenuOpen = false" href="{{ route('welcome') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('welcome') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Home</a>
                <a @click="mobileMenuOpen = false" href="{{ route('about') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Tentang Kami</a>
                <a @click="mobileMenuOpen = false" href="{{ route('packages') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('packages') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Program Paket</a>
                <a @click="mobileMenuOpen = false" href="{{ route('locations') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('locations') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Kolam Latihan</a>
                <a @click="mobileMenuOpen = false" href="{{ route('schedule') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('schedule') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Jadwal Latihan</a>
                <a @click="mobileMenuOpen = false" href="{{ route('contact') }}"
                    class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}">Kontak Kami</a>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-3 px-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="w-full text-center py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Portal Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full text-center py-3 text-slate-700 font-bold border border-slate-200 rounded-xl hover:bg-slate-50">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full text-center py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">
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
    <footer class="bg-slate-900 text-white pt-16 pb-12 border-t border-slate-800 text-left">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Left Info Branding -->
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/black_diamond_1.png') }}" alt="Black Diamond Logo"
                            class="w-auto h-16 object-contain">
                    </a>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Klub renang terkemuka untuk melatih keterampilan, keamanan, dan kebugaran tubuh dalam air. Kami siap
                    melatih perenang sejati.
                </p>
            </div>

            <!-- Center Menu Links -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm tracking-wider uppercase text-slate-400">Navigasi Halaman</h4>
                <ul class="space-y-2.5 text-sm text-slate-300">
                    <li><a href="{{ route('welcome') }}" class="hover:text-blue-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('packages') }}" class="hover:text-blue-400 transition-colors">Program Paket</a></li>
                    <li><a href="{{ route('locations') }}" class="hover:text-blue-400 transition-colors">Kolam Latihan</a></li>
                    <li><a href="{{ route('schedule') }}" class="hover:text-blue-400 transition-colors">Jadwal Latihan</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition-colors">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Right Contact Support -->
            <div class="space-y-4">
                <h4 class="font-bold text-sm tracking-wider uppercase text-slate-400">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-sm text-slate-300">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-450"></i>
                        <span>support@blackdiamond.club</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-slate-450"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-clock text-slate-450"></i>
                        <span>Setiap Hari (06:00 - 18:00 WIB)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Black Diamond Swimming Club. Hak Cipta Dilindungi.</p>
            <p>Made with <i class="fa-solid fa-heart text-red-500"></i> in Indonesia</p>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a class="float-wa"
        href="https://api.whatsapp.com/send/?phone=6281216700519&amp;text=Halo+Admin+Black+Diamond+Swimming+Club%2C+saya+ingin+tanya-tanya+mengenai+paket+dan+jadwal+latihan+renang.&amp;type=phone_number&amp;app_absent=0"
        target="_blank" title="Hubungi CS Black Diamond via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>

</html>
