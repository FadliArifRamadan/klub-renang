{{-- ============================================================
     TOP BAR — Black Diamond Swim Academy
     Kiri  : Hamburger toggle sidebar + Judul halaman dinamis
     Kanan : Notification bell + User info + Dropdown
     ============================================================ --}}
<header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">

        {{-- ===== KIRI: Hamburger + Page Title ===== --}}
        <div class="flex items-center gap-4">
            {{-- Tombol toggle sidebar (hanya di mobile/tablet) --}}
            <button @click="sidebarOpen = !sidebarOpen"
                class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors duration-150 lg:hidden"
                aria-label="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Nama halaman dinamis dari title tag --}}
            <div class="hidden sm:block">
                <h1 class="text-sm font-semibold text-gray-700 leading-tight">
                    @php
                        $role = Auth::user()->role;
                        $roleLabel = match($role) {
                            'admin'   => 'Admin',
                            'coach'   => 'Pelatih',
                            'parent'  => 'Orang Tua',
                            'general' => 'Umum',
                            default   => ucfirst($role),
                        };
                        $displayTitle = '';
                        if (isset($title)) {
                            $displayTitle = preg_replace('/^(Admin|Coach|Orang Tua|Umum|Parent|General|Black Diamond)\s*-\s*/i', '', $title);
                        }
                    @endphp
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full mr-2
                        @if($role === 'admin')   bg-purple-100 text-purple-700
                        @elseif($role === 'coach')  bg-blue-100   text-blue-700
                        @elseif($role === 'parent') bg-green-100  text-green-700
                        @else                        bg-amber-100  text-amber-700
                        @endif">
                        {{ $roleLabel }}
                    </span>
                    <span class="text-gray-500 font-medium">Black Diamond</span>
                    @if(!empty($displayTitle))
                        <span class="text-gray-400 mx-1.5">/</span>
                        <span class="text-gray-900 font-semibold">{{ $displayTitle }}</span>
                    @endif
                </h1>
            </div>
        </div>

        {{-- ===== KANAN: Notification Bell + User Dropdown ===== --}}
        <div class="flex items-center gap-2">

            {{-- -------- NOTIFICATION BELL -------- --}}
            @php
                $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(5)->get();
                $unreadCount         = Auth::user()->unreadNotifications()->count();
            @endphp

            <div x-data="{ notifOpen: false }" class="relative" @click.outside="notifOpen = false">
                <button @click="notifOpen = !notifOpen"
                    class="relative flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors duration-150"
                    aria-label="Notifikasi">
                    <i class="fa-solid fa-bell text-base"></i>
                    @if($unreadCount > 0)
                        <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-white text-[9px] font-bold leading-none ring-2 ring-white">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                </button>

                {{-- Notification Dropdown Panel --}}
                <div x-show="notifOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden"
                     style="display:none; top: calc(100% + 4px);">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/80">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-bell text-blue-500 text-sm"></i>
                            <span class="font-semibold text-gray-800 text-sm">Notifikasi</span>
                            @if($unreadCount > 0)
                                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                    {{ $unreadCount }} baru
                                </span>
                            @endif
                        </div>
                        @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.read-all') }}">
                                @csrf
                                <button type="submit"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Notification List --}}
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                        @forelse($unreadNotifications as $notif)
                            @php
                                $data  = $notif->data;
                                $color = $data['color'] ?? 'blue';
                                $icon  = $data['icon']  ?? 'fa-bell';
                                $colorMap = [
                                    'blue'  => ['bg'=>'bg-blue-50',  'text'=>'text-blue-600',  'border'=>'border-blue-200'],
                                    'green' => ['bg'=>'bg-green-50', 'text'=>'text-green-600', 'border'=>'border-green-200'],
                                    'red'   => ['bg'=>'bg-red-50',   'text'=>'text-red-600',   'border'=>'border-red-200'],
                                    'amber' => ['bg'=>'bg-amber-50', 'text'=>'text-amber-600', 'border'=>'border-amber-200'],
                                ];
                                $c = $colorMap[$color] ?? $colorMap['blue'];
                            @endphp
                            <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors text-left">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $c['bg'] }} {{ $c['border'] }} border flex items-center justify-center mt-0.5">
                                        <i class="fa-solid {{ $icon }} {{ $c['text'] }} text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800">{{ $data['title'] ?? 'Notifikasi' }}</p>
                                        <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2">{!! $data['body'] ?? '' !!}</p>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            <i class="fa-regular fa-clock mr-0.5"></i>
                                            {{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                </button>
                            </form>
                        @empty
                            <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-bell-slash text-gray-400 text-lg"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600">Tidak ada notifikasi baru</p>
                                <p class="text-xs text-gray-400 mt-0.5">Anda sudah up-to-date!</p>
                            </div>
                        @endforelse
                    </div>

                    @if(Auth::user()->readNotifications()->count() > 0 && $unreadCount === 0)
                        <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-center">
                            <p class="text-xs text-gray-400">
                                <i class="fa-solid fa-circle-check text-green-400 mr-1"></i>
                                Semua notifikasi sudah dibaca
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            {{-- -------- END NOTIFICATION BELL -------- --}}

            {{-- -------- USER DROPDOWN -------- --}}
            <div x-data="{ userOpen: false }" class="relative" @click.outside="userOpen = false">
                <button @click="userOpen = !userOpen"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-150 focus:outline-none"
                    aria-label="User Menu">

                    {{-- Avatar initials --}}
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0
                        @if(Auth::user()->role === 'admin')   bg-purple-600
                        @elseif(Auth::user()->role === 'coach')  bg-blue-600
                        @elseif(Auth::user()->role === 'parent') bg-green-600
                        @else                                     bg-amber-500
                        @endif">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-semibold text-gray-800 leading-tight max-w-[120px] truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[10px] text-gray-400 leading-tight">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>

                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 hidden sm:block"></i>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="userOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden py-1"
                     style="display:none; top: calc(100% + 4px);">

                    {{-- User info header --}}
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/60">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 truncate">
                            <span class="inline-block w-1.5 h-1.5 rounded-full mr-1
                                @if(Auth::user()->role === 'admin')   bg-purple-500
                                @elseif(Auth::user()->role === 'coach')  bg-blue-500
                                @elseif(Auth::user()->role === 'parent') bg-green-500
                                @else                                     bg-amber-500
                                @endif">
                            </span>
                            {{ ucfirst(Auth::user()->role) }}
                        </p>
                    </div>

                    {{-- Profile link --}}
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-user-gear w-4 text-center text-gray-400"></i>
                        Edit Profil
                    </a>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100 my-1"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            {{-- -------- END USER DROPDOWN -------- --}}

        </div>
    </div>
</header>
