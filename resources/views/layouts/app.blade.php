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
                <!-- Flash Messages (Global Single Notification) -->
                @if (session('success') || session('error') || session('status'))
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 5000)" class="mb-4">
                        @if (session('success'))
                            <div class="flex items-center p-4 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-check text-lg mr-3 text-emerald-500 shrink-0"></i>
                                <div>
                                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="flex items-center p-4 text-sm text-rose-800 dark:text-rose-300 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-xmark text-lg mr-3 text-rose-500 shrink-0"></i>
                                <div>
                                    <span class="font-bold">Error!</span> {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="flex items-center p-4 text-sm text-blue-800 dark:text-blue-300 rounded-2xl bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-info text-lg mr-3 text-blue-500 shrink-0"></i>
                                <div>
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
