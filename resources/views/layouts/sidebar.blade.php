<div class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-white border-r">
    <h2 class="text-3xl font-semibold text-center text-blue-600">Klub Renang</h2>

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

                <x-sidebar-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.index')">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span class="font-medium">Kelola Murid</span>
                </x-sidebar-nav-link>

                <hr class="my-4 border-gray-200" />
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Data Master</p>

                <x-sidebar-nav-link :href="route('admin.coaches.index')" :active="request()->routeIs('admin.coaches.index')">
                    <i class="fa-solid fa-user-tie w-5 text-center"></i>
                    <span class="font-medium">Kelola Coach</span>
                </x-sidebar-nav-link>

                <x-sidebar-nav-link :href="route('admin.packages.index')" :active="request()->routeIs('admin.packages.index')">
                    <i class="fa-solid fa-box w-5 text-center"></i>
                    <span class="font-medium">Kelola Paket</span>
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
