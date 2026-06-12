<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Black Diamond') }}</title>

        <!-- Fonts & Icons -->
        <link rel="icon" href="{{ asset('images/black_diamond_1.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .hero-pattern {
                background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 0), radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 0);
                background-size: 32px 32px;
                background-position: 0 0, 16px 16px;
            }
        </style>
    </head>
    <body class="antialiased bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-slate-800 min-h-screen relative overflow-x-hidden overflow-y-auto">
        <!-- Background Elements for Premium Look -->
        <div class="absolute inset-0 hero-pattern opacity-30 pointer-events-none"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 relative z-10 w-full">
            <div class="w-full sm:max-w-md">
                <!-- Card Container -->
                <div class="w-full bg-white/95 backdrop-blur-md border border-slate-100 shadow-2xl rounded-3xl p-6 sm:p-8">
                <!-- Logo & Heading -->
                <div class="text-center mb-6">
                    <a href="/" class="inline-block hover:opacity-90 transition-opacity">
                        <img src="{{ asset('images/black_diamond_1.png') }}" alt="Black Diamond Logo" class="h-20 w-auto mx-auto object-contain">
                    </a>
                    <h2 class="text-xl font-extrabold text-slate-850 mt-4 leading-tight">
                        @if(request()->routeIs('login'))
                            Selamat Datang Kembali
                        @elseif(request()->routeIs('register'))
                            Pendaftaran Akun Baru
                        @elseif(request()->routeIs('password.request'))
                            Lupa Password Anda?
                        @elseif(request()->routeIs('password.reset'))
                            Atur Ulang Password
                        @else
                            Black Diamond Swim
                        @endif
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        @if(request()->routeIs('login'))
                            Silakan masuk untuk mengelola program renang Anda
                        @elseif(request()->routeIs('register'))
                            Mulai langkah pertama Anda bersama klub renang kami
                        @elseif(request()->routeIs('password.request'))
                            Masukkan email untuk menerima link reset password
                        @elseif(request()->routeIs('password.reset'))
                            Silakan tentukan password baru akun Anda
                        @endif
                    </p>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
