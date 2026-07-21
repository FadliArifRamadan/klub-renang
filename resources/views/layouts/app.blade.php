<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Klub Renang') }}</title>

    <link rel="icon" href="{{ asset('images/black_diamond.png') }}" type="image/png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-outfit antialiased bg-[#0B0F17] text-white">
    <div x-data="{ sidebarExpanded: true, sidebarHovered: false, mobileSidebarOpen: false }" class="min-h-screen xl:flex">
        
        <div>
            @include('layouts.sidebar')
            
            <!-- Backdrop -->
            <div x-show="mobileSidebarOpen" 
                 x-transition.opacity.duration.300ms
                 @click="mobileSidebarOpen = false" 
                 class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                 style="display: none;"></div>
        </div>

        <div class="flex-1 min-w-0 transition-all duration-300 ease-in-out"
             :class="(sidebarExpanded || sidebarHovered) ? 'lg:ml-[290px]' : 'lg:ml-[90px]'">
            
            @include('layouts.navigation')

            <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
                <!-- Flash Messages -->
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4">
                    @if (session('success'))
                        <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg mb-2 flex items-center">
                            <i class="fa-solid fa-check-circle mr-2 text-success-500"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-error-50 border border-error-200 text-error-700 px-4 py-3 rounded-lg mb-2 flex items-center">
                            <i class="fa-solid fa-triangle-exclamation mr-2 text-error-500"></i> {{ session('error') }}
                        </div>
                    @endif
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
