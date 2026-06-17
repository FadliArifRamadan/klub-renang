<!-- Background backdrop for mobile/tablet when sidebar is open -->
<div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-650/50 lg:hidden" @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>

<!-- Sidebar container -->
<div class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-white border-r transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-auto"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="flex items-center justify-between px-2 mb-6">
        <img src="{{ asset('images/black_diamond_1.png') }}" alt="Black Diamond Logo">
        <button @click="sidebarOpen = false"
            class="p-2 text-gray-500 rounded-md lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="space-y-1">
            {{-- Dashboard (semua role) --}}
            <x-sidebar-nav-link :href="route(Auth::user()->role . '.dashboard')" :active="request()->routeIs(Auth::user()->role . '.dashboard')">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                <span class="font-medium">Dashboard</span>
            </x-sidebar-nav-link>

            {{-- ADMIN --}}
            @if (Auth::user()->role === 'admin')
                <x-sidebar-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.index')">
                    <i class="fa-solid fa-wallet w-5 text-center"></i>
                    <span class="font-medium">Verifikasi Pembayaran</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.schedule-requests.index')" :active="request()->routeIs('admin.schedule-requests.index')">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span class="font-medium flex-1">Pengajuan Jadwal</span>
                    @php
                        $pendingSchedCount = \App\Models\ScheduleChangeRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingSchedCount > 0)
                        <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ $pendingSchedCount }}
                        </span>
                    @endif
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.index')">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span class="font-medium">Kelola Murid</span>
                </x-sidebar-nav-link>

                <hr class="my-4 border-gray-200" />
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Data Master</p>

                <x-sidebar-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    <i class="fa-solid fa-users-gear w-5 text-center"></i>
                    <span class="font-medium">Kelola Pengguna</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.swimming-classes.index')" :active="request()->routeIs('admin.swimming-classes.index')">
                    <i class="fa-solid fa-water w-5 text-center"></i>
                    <span class="font-medium">Kelola Kelas</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.packages.index')" :active="request()->routeIs('admin.packages.index')">
                    <i class="fa-solid fa-box w-5 text-center"></i>
                    <span class="font-medium">Kelola Paket</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.index')">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span class="font-medium">Kelola Jadwal</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.locations.index')" :active="request()->routeIs('admin.locations.index')">
                    <i class="fa-solid fa-location-dot w-5 text-center"></i>
                    <span class="font-medium">Tempat Latihan</span>
                </x-sidebar-nav-link>
            @endif

            {{-- COACH --}}
            @if (Auth::user()->role === 'coach')
                <x-sidebar-nav-link :href="route('coach.students.index')" :active="request()->routeIs('coach.students.index')">
                    <i class="fa-solid fa-address-book w-5 text-center"></i>
                    <span class="font-medium">Data Murid Saya</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('coach.attendances.create')" :active="request()->routeIs('coach.attendances.create')">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span class="font-medium">Input Absensi</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('coach.attendances.index')" :active="request()->routeIs('coach.attendances.index')">
                    <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
                    <span class="font-medium">Riwayat Absensi</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('coach.progress.index')" :active="request()->routeIs('coach.progress.index')">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span class="font-medium">Catat Perkembangan</span>
                </x-sidebar-nav-link>
            @endif

            {{-- PARENT (ORANG TUA) --}}
            @if (Auth::user()->role === 'parent')
                <x-sidebar-nav-link :href="route('parent.students.create')" :active="request()->routeIs('parent.students.create')">
                    <i class="fa-solid fa-child w-5 text-center"></i>
                    <span class="font-medium">Daftarkan Anak</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('parent.students.index')" :active="request()->routeIs('parent.students.index')">
                    <i class="fa-solid fa-children w-5 text-center"></i>
                    <span class="font-medium">Data Anak Saya</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('parent.payments.index')" :active="request()->routeIs('parent.payments.index')">
                    <i class="fa-solid fa-credit-card w-5 text-center"></i>
                    <span class="font-medium">Menu Pembayaran</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('parent.attendances.index')" :active="request()->routeIs('parent.attendances.index')">
                    <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
                    <span class="font-medium">Riwayat Absensi</span>
                </x-sidebar-nav-link>
            @endif

            {{-- GENERAL (UMUM) --}}
            @if (Auth::user()->role === 'general')
                <x-sidebar-nav-link :href="route('general.students.create')" :active="request()->routeIs('general.students.create')">
                    <i class="fa-solid fa-user-plus w-5 text-center"></i>
                    <span class="font-medium">Daftar Paket Saya</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('general.students.index')" :active="request()->routeIs('general.students.index')">
                    <i class="fa-solid fa-address-card w-5 text-center"></i>
                    <span class="font-medium">Data Kursus Saya</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('general.payments.index')" :active="request()->routeIs('general.payments.index')">
                    <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
                    <span class="font-medium">Menu Pembayaran</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('general.attendances.index')" :active="request()->routeIs('general.attendances.index')">
                    <i class="fa-solid fa-clipboard-list w-5 text-center"></i>
                    <span class="font-medium">Riwayat Absensi</span>
                </x-sidebar-nav-link>
            @endif
        </nav>

        <div class="mt-auto pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-150">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
