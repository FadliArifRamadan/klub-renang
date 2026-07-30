<aside
    class="fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-gradient-to-b from-[#E5C158] via-[#D3AF37] to-[#B89426] text-[#101828] h-screen transition-all duration-300 ease-in-out z-50 border-r border-[#B89426]/40 shadow-2xl lg:translate-x-0"
    :class="{
        'w-[290px]': sidebarExpanded || mobileSidebarOpen || sidebarHovered,
        'w-[90px]': !sidebarExpanded && !mobileSidebarOpen && !sidebarHovered,
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full': !mobileSidebarOpen
    }"
    @mouseover="!sidebarExpanded && (sidebarHovered = true)" @mouseleave="sidebarHovered = false">
    <div class="py-8 flex"
        :class="{
            'lg:justify-center': !sidebarExpanded && !sidebarHovered,
            'justify-start': sidebarExpanded ||
                sidebarHovered || mobileSidebarOpen
        }">
        <a href="<?php echo e(route('login')); ?>">
            <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                <div class="flex items-center gap-3">
                    <img src="<?php echo e(asset('images/black_diamond_1.png')); ?>" alt="Logo" class="drop-shadow-[0_0_8px_rgba(211,175,55,0.4)]">
                </div>
            </template>
            <template x-if="!sidebarExpanded && !sidebarHovered && !mobileSidebarOpen">
                <img src="<?php echo e(asset('images/black_diamond.png')); ?>" alt="Logo" class="w-10 mx-auto drop-shadow-[0_0_8px_rgba(211,175,55,0.4)]">
            </template>
        </a>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">

                <!-- DASHBOARD SECTION -->
                <div>
                    <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-[#101828] font-black tracking-wider"
                        :class="{ 'lg:justify-center': !sidebarExpanded && !sidebarHovered }">
                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                            <span>Menu Utama</span>
                        </template>
                        <template x-if="!sidebarExpanded && !sidebarHovered && !mobileSidebarOpen">
                            <i class="fa-solid fa-ellipsis"></i>
                        </template>
                    </h2>

                    <ul class="flex flex-col gap-2">
                        <li>
                            <?php
                                $dashRoute = Auth::user()->isAdmin() ? 'admin.dashboard' : Auth::user()->role . '.dashboard';
                            ?>
                            <a href="<?php echo e(route($dashRoute)); ?>"
                                class="menu-item group <?php echo e(request()->routeIs('admin.dashboard') || request()->routeIs(Auth::user()->role . '.dashboard') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                :class="{
                                    'lg:justify-center': !sidebarExpanded && !
                                        sidebarHovered,
                                    'lg:justify-start': sidebarExpanded || sidebarHovered
                                }">
                                <span
                                    class="menu-item-icon-size <?php echo e(request()->routeIs('admin.dashboard') || request()->routeIs(Auth::user()->role . '.dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                    <i class="fa-solid fa-gauge-high text-xl w-6 text-center"></i>
                                </span>
                                <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                    <span class="menu-item-text">Dashboard</span>
                                </template>
                            </a>
                        </li>

                        <!-- ADMIN (FINANCE & OPERASIONAL) -->
                        <?php if(Auth::user()->isAdmin()): ?>
                            <?php if(Auth::user()->isAdminFinance()): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.payments.index')); ?>"
                                        class="menu-item group <?php echo e(request()->routeIs('admin.payments.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                        :class="{
                                            'lg:justify-center': !sidebarExpanded && !
                                                sidebarHovered,
                                            'lg:justify-start': sidebarExpanded || sidebarHovered
                                        }">
                                        <span
                                            class="menu-item-icon-size <?php echo e(request()->routeIs('admin.payments.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                            <i class="fa-solid fa-wallet text-xl w-6 text-center"></i>
                                        </span>
                                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                            <span class="menu-item-text">Verifikasi Pembayaran</span>
                                        </template>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->isAdminOperasional()): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.schedule-requests.index')); ?>"
                                        class="menu-item group <?php echo e(request()->routeIs('admin.schedule-requests.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                        :class="{
                                            'lg:justify-center': !sidebarExpanded && !
                                                sidebarHovered,
                                            'lg:justify-start': sidebarExpanded || sidebarHovered
                                        }">
                                        <span
                                            class="menu-item-icon-size <?php echo e(request()->routeIs('admin.schedule-requests.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                            <i class="fa-solid fa-calendar-check text-xl w-6 text-center"></i>
                                        </span>
                                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                            <span class="menu-item-text flex-1">Pengajuan Jadwal</span>
                                        </template>
                                        <?php
                                            $pendingSchedCount = \App\Models\ScheduleChangeRequest::where(
                                                'status',
                                                'pending',
                                            )->count();
                                        ?>
                                        <?php if($pendingSchedCount > 0): ?>
                                            <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                                <span
                                                    class="bg-brand-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-auto">
                                                    <?php echo e($pendingSchedCount); ?>

                                                </span>
                                            </template>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('admin.students.index')); ?>"
                                        class="menu-item group <?php echo e(request()->routeIs('admin.students.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                        :class="{
                                            'lg:justify-center': !sidebarExpanded && !
                                                sidebarHovered,
                                            'lg:justify-start': sidebarExpanded || sidebarHovered
                                        }">
                                        <span
                                            class="menu-item-icon-size <?php echo e(request()->routeIs('admin.students.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                            <i class="fa-solid fa-users text-xl w-6 text-center"></i>
                                        </span>
                                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                            <span class="menu-item-text">Kelola Murid</span>
                                        </template>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->isAdminFinance()): ?>
                                <li x-data="{ open: <?php echo e(request()->routeIs('admin.attendances.*') ? 'true' : 'false'); ?> }">
                                    <a href="#" @click.prevent="open = !open"
                                        class="menu-item group w-full flex justify-between items-center <?php echo e(request()->routeIs('admin.attendances.*') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                        :class="{
                                            'lg:justify-center': !sidebarExpanded && !sidebarHovered,
                                            'lg:justify-start': sidebarExpanded || sidebarHovered
                                        }">
                                        <div class="flex items-center">
                                            <span class="menu-item-icon-size <?php echo e(request()->routeIs('admin.attendances.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                                <i class="fa-solid fa-clipboard-list text-xl w-6 text-center"></i>
                                            </span>
                                            <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                                <span class="menu-item-text ml-3">Riwayat Absensi</span>
                                            </template>
                                        </div>
                                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                                        </template>
                                    </a>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <ul x-show="open" x-transition class="mt-2 space-y-1" style="display: none;">
                                            <li>
                                                <a href="<?php echo e(route('admin.attendances.belajar')); ?>"
                                                    class="block py-2 pl-12 pr-4 text-sm rounded-lg transition-colors <?php echo e(request()->routeIs('admin.attendances.belajar') ? 'bg-[#101828] text-[#D3AF37] font-black border border-[#F5E6A3]/30 shadow-md' : 'text-[#101828] hover:text-black hover:bg-[#101828]/15 font-bold'); ?>">
                                                    Kelas Belajar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('admin.attendances.prestasi')); ?>"
                                                    class="block py-2 pl-12 pr-4 text-sm rounded-lg transition-colors <?php echo e(request()->routeIs('admin.attendances.prestasi') ? 'bg-[#101828] text-[#D3AF37] font-black border border-[#F5E6A3]/30 shadow-md' : 'text-[#101828] hover:text-black hover:bg-[#101828]/15 font-bold'); ?>">
                                                    Kelas Prestasi
                                                </a>
                                            </li>
                                        </ul>
                                    </template>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- COACH -->
                        <?php if(Auth::user()->role === 'coach'): ?>
                            <li>
                                <a href="<?php echo e(route('coach.students.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('coach.students.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('coach.students.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-address-book text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Data Murid Saya</span>
                                    </template>
                                </a>
                            </li>
                            <li x-data="{ open: <?php echo e(request()->routeIs('coach.attendances.*') ? 'true' : 'false'); ?> }">
                                <a href="#" @click.prevent="open = !open"
                                    class="menu-item group w-full flex justify-between items-center <?php echo e(request()->routeIs('coach.attendances.*') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <div class="flex items-center">
                                        <span class="menu-item-icon-size <?php echo e(request()->routeIs('coach.attendances.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                            <i class="fa-solid fa-clipboard-list text-xl w-6 text-center"></i>
                                        </span>
                                        <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                            <span class="menu-item-text ml-3">Absensi</span>
                                        </template>
                                    </div>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                                    </template>
                                </a>
                                <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                    <ul x-show="open" x-transition class="mt-2 space-y-1" style="display: none;">
                                        <li>
                                            <a href="<?php echo e(route('coach.attendances.belajar.index')); ?>"
                                                class="block py-2 pl-12 pr-4 text-sm rounded-lg transition-colors <?php echo e(request()->routeIs('coach.attendances.belajar.*') ? 'bg-[#101828] text-[#D3AF37] font-black border border-[#F5E6A3]/30 shadow-md' : 'text-[#101828] hover:text-black hover:bg-[#101828]/15 font-bold'); ?>">
                                                Kelas Belajar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('coach.attendances.prestasi.index')); ?>"
                                                class="block py-2 pl-12 pr-4 text-sm rounded-lg transition-colors <?php echo e(request()->routeIs('coach.attendances.prestasi.*') ? 'bg-[#101828] text-[#D3AF37] font-black border border-[#F5E6A3]/30 shadow-md' : 'text-[#101828] hover:text-black hover:bg-[#101828]/15 font-bold'); ?>">
                                                Kelas Prestasi
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                            <li>
                                <a href="<?php echo e(route('coach.progress.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('coach.progress.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('coach.progress.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-chart-line text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Catat Perkembangan</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('coach.leaves.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('coach.leaves.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('coach.leaves.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-calendar-times text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Izin Latihan</span>
                                    </template>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- PARENT -->
                        <?php if(Auth::user()->role === 'parent'): ?>
                            <li>
                                <a href="<?php echo e(route('parent.students.create')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('parent.students.create') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('parent.students.create') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-child text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Daftarkan Anak</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('parent.students.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('parent.students.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('parent.students.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-children text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Data Anak Saya</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('parent.payments.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('parent.payments.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('parent.payments.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-credit-card text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Menu Pembayaran</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('parent.attendances.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('parent.attendances.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('parent.attendances.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-clipboard-list text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Riwayat Absensi</span>
                                    </template>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- GENERAL -->
                        <?php if(Auth::user()->role === 'general'): ?>
                            <li>
                                <a href="<?php echo e(route('general.students.create')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('general.students.create') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('general.students.create') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-user-plus text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Daftar Paket Saya</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('general.students.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('general.students.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('general.students.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-address-card text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Data Kursus Saya</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('general.payments.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('general.payments.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('general.payments.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-money-bill-wave text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Menu Pembayaran</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('general.attendances.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('general.attendances.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('general.attendances.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-clipboard-list text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Riwayat Absensi</span>
                                    </template>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>

                <!-- ADMIN MASTER DATA -->
                <?php if(Auth::user()->isAdminOperasional()): ?>
                    <div>
                        <h2 class="mb-4 mt-4 text-xs uppercase flex leading-[20px] text-[#101828] font-black tracking-wider"
                            :class="{ 'lg:justify-center': !sidebarExpanded && !sidebarHovered }">
                            <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                <span>Data Master</span>
                            </template>
                            <template x-if="!sidebarExpanded && !sidebarHovered && !mobileSidebarOpen">
                                <i class="fa-solid fa-ellipsis"></i>
                            </template>
                        </h2>

                        <ul class="flex flex-col gap-2">
                            <li>
                                <a href="<?php echo e(route('admin.users.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.users.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.users.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-users-gear text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Kelola Pengguna</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.swimming-classes.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.swimming-classes.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.swimming-classes.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-water text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Kelola Kelas</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.packages.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.packages.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.packages.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-box text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Kelola Paket</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.schedules.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.schedules.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.schedules.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-calendar-days text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Kelola Jadwal</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.leaves.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.leaves.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.leaves.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-calendar-times text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Persetujuan Izin</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.reschedule.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.reschedule.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.reschedule.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-clock-rotate-left text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Kelola Reschedule</span>
                                    </template>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admin.locations.index')); ?>"
                                    class="menu-item group <?php echo e(request()->routeIs('admin.locations.index') ? 'menu-item-active' : 'menu-item-inactive'); ?>"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size <?php echo e(request()->routeIs('admin.locations.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'); ?>">
                                        <i class="fa-solid fa-location-dot text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Tempat Latihan</span>
                                    </template>
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- LOGOUT -->
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <ul class="flex flex-col gap-2">
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="menu-item group menu-item-inactive w-full text-red-500 dark:text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10"
                                    :class="{
                                        'lg:justify-center': !sidebarExpanded && !
                                            sidebarHovered,
                                        'lg:justify-start': sidebarExpanded || sidebarHovered
                                    }">
                                    <span
                                        class="menu-item-icon-size text-red-500 group-hover:text-red-600 dark:text-red-400 dark:group-hover:text-red-300">
                                        <i class="fa-solid fa-right-from-bracket text-xl w-6 text-center"></i>
                                    </span>
                                    <template x-if="sidebarExpanded || sidebarHovered || mobileSidebarOpen">
                                        <span class="menu-item-text">Keluar</span>
                                    </template>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</aside>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>