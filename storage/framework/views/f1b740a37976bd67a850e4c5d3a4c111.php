<header class="sticky top-0 z-40 flex w-full bg-white border-b border-gray-200 dark:border-gray-800 dark:bg-gray-900 transition-colors duration-300">
    <div class="flex flex-grow items-center justify-between px-4 py-4 md:px-6">
        
        
        <div class="flex items-center gap-2 sm:gap-4">
            
            <button @click="if(window.innerWidth >= 1024) { sidebarExpanded = !sidebarExpanded; sidebarHovered = false } else { mobileSidebarOpen = !mobileSidebarOpen }"
                    class="block items-center justify-center p-1.5 shadow-sm rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            
            <div class="hidden sm:block">
                <h1 class="text-sm font-semibold text-gray-700 dark:text-gray-300 leading-tight">
                    <?php
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
                    ?>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full mr-2
                        <?php if($role === 'admin'): ?>   bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400
                        <?php elseif($role === 'coach'): ?>  bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                        <?php elseif($role === 'parent'): ?> bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                        <?php else: ?>                        bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                        <?php endif; ?>">
                        <?php echo e($roleLabel); ?>

                    </span>
                    <span class="text-gray-500 dark:text-gray-400 font-medium">Black Diamond</span>
                    <?php if(!empty($displayTitle)): ?>
                        <span class="text-gray-400 dark:text-gray-600 mx-1.5">/</span>
                        <span class="text-gray-900 dark:text-white font-semibold"><?php echo e($displayTitle); ?></span>
                    <?php endif; ?>
                </h1>
            </div>
        </div>

        
        <div class="flex items-center gap-3 2xsm:gap-4">



            
            <?php
                $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(5)->get();
                $unreadCount         = Auth::user()->unreadNotifications()->count();
            ?>

            <div x-data="{ notifOpen: false }" class="relative" @click.outside="notifOpen = false">
                <button @click="notifOpen = !notifOpen"
                        class="relative flex items-center justify-center w-10 h-10 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none">
                    <i class="fa-solid fa-bell"></i>
                    <?php if($unreadCount > 0): ?>
                        <span class="absolute top-2 right-2 flex h-3 w-3 items-center justify-center rounded-full bg-red-500 text-white text-[9px] font-bold leading-none ring-2 ring-white dark:ring-gray-900"></span>
                    <?php endif; ?>
                </button>

                
                <div x-show="notifOpen"
                     x-transition.origin.top.right
                     class="absolute -right-10 sm:right-0 mt-3 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
                     style="display:none;">
                    
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <span class="font-semibold text-gray-800 dark:text-gray-200 text-sm">Notifikasi</span>
                        <?php if($unreadCount > 0): ?>
                            <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs text-brand-500 hover:text-brand-600 dark:text-brand-400 font-medium hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-700/50">
                        <?php $__empty_1 = true; $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $data  = $notif->data;
                                $color = $data['color'] ?? 'blue';
                                $icon  = $data['icon']  ?? 'fa-bell';
                                $cMap = [
                                    'blue'  => 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                                    'green' => 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                    'red'   => 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                    'amber' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400',
                                ];
                                $c = $cMap[$color] ?? $cMap['blue'];
                            ?>
                            <form method="POST" action="<?php echo e(route('notifications.read', $notif->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors text-left">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full <?php echo e($c); ?> flex items-center justify-center mt-0.5">
                                        <i class="fa-solid <?php echo e($icon); ?> text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200"><?php echo e($data['title'] ?? 'Notifikasi'); ?></p>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2"><?php echo $data['body'] ?? ''; ?></p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">
                                            <i class="fa-regular fa-clock mr-0.5"></i>
                                            <?php echo e($notif->created_at->diffForHumans()); ?>

                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 w-2 h-2 bg-brand-500 rounded-full mt-2"></div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="py-6 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div x-data="{ userOpen: false }" class="relative" @click.outside="userOpen = false">
                <button @click="userOpen = !userOpen" class="flex items-center gap-3">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">
                            <?php echo e(Auth::user()->name); ?>

                        </span>
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400">
                            <?php echo e(ucfirst(Auth::user()->role)); ?>

                        </span>
                    </span>
                    <span class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0
                        <?php if(Auth::user()->role === 'admin'): ?> bg-purple-600
                        <?php elseif(Auth::user()->role === 'coach'): ?> bg-blue-600
                        <?php elseif(Auth::user()->role === 'parent'): ?> bg-green-600
                        <?php else: ?> bg-amber-500
                        <?php endif; ?>">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-gray-500 dark:text-gray-400 hidden lg:block transition" :class="userOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="userOpen"
                     x-transition.origin.top.right
                     class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
                     style="display:none;">
                    
                    <ul class="flex flex-col py-2 border-b border-gray-100 dark:border-gray-700">
                        <li>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-brand-500 dark:hover:text-brand-400 transition-colors">
                                <i class="fa-regular fa-user"></i>
                                Edit Profil
                            </a>
                        </li>
                    </ul>
                    
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="py-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>