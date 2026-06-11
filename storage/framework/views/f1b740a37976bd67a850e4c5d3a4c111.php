
<header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">

        
        <div class="flex items-center gap-4">
            
            <button @click="sidebarOpen = !sidebarOpen"
                class="flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors duration-150 lg:hidden"
                aria-label="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            
            <div class="hidden sm:block">
                <h1 class="text-sm font-semibold text-gray-700 leading-tight">
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
                        <?php if($role === 'admin'): ?>   bg-purple-100 text-purple-700
                        <?php elseif($role === 'coach'): ?>  bg-blue-100   text-blue-700
                        <?php elseif($role === 'parent'): ?> bg-green-100  text-green-700
                        <?php else: ?>                        bg-amber-100  text-amber-700
                        <?php endif; ?>">
                        <?php echo e($roleLabel); ?>

                    </span>
                    <span class="text-gray-500 font-medium">Black Diamond</span>
                    <?php if(!empty($displayTitle)): ?>
                        <span class="text-gray-400 mx-1.5">/</span>
                        <span class="text-gray-900 font-semibold"><?php echo e($displayTitle); ?></span>
                    <?php endif; ?>
                </h1>
            </div>
        </div>

        
        <div class="flex items-center gap-2">

            
            <?php
                $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(5)->get();
                $unreadCount         = Auth::user()->unreadNotifications()->count();
            ?>

            <div x-data="{ notifOpen: false }" class="relative" @click.outside="notifOpen = false">
                <button @click="notifOpen = !notifOpen"
                    class="relative flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors duration-150"
                    aria-label="Notifikasi">
                    <i class="fa-solid fa-bell text-base"></i>
                    <?php if($unreadCount > 0): ?>
                        <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-white text-[9px] font-bold leading-none ring-2 ring-white">
                            <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                        </span>
                    <?php endif; ?>
                </button>

                
                <div x-show="notifOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden"
                     style="display:none; top: calc(100% + 4px);">

                    
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/80">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-bell text-blue-500 text-sm"></i>
                            <span class="font-semibold text-gray-800 text-sm">Notifikasi</span>
                            <?php if($unreadCount > 0): ?>
                                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                    <?php echo e($unreadCount); ?> baru
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if($unreadCount > 0): ?>
                            <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                        <?php $__empty_1 = true; $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
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
                            ?>
                            <form method="POST" action="<?php echo e(route('notifications.read', $notif->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="w-full flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors text-left">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full <?php echo e($c['bg']); ?> <?php echo e($c['border']); ?> border flex items-center justify-center mt-0.5">
                                        <i class="fa-solid <?php echo e($icon); ?> <?php echo e($c['text']); ?> text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800"><?php echo e($data['title'] ?? 'Notifikasi'); ?></p>
                                        <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2"><?php echo $data['body'] ?? ''; ?></p>
                                        <p class="text-[10px] text-gray-400 mt-1">
                                            <i class="fa-regular fa-clock mr-0.5"></i>
                                            <?php echo e($notif->created_at->diffForHumans()); ?>

                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                </button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-bell-slash text-gray-400 text-lg"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600">Tidak ada notifikasi baru</p>
                                <p class="text-xs text-gray-400 mt-0.5">Anda sudah up-to-date!</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if(Auth::user()->readNotifications()->count() > 0 && $unreadCount === 0): ?>
                        <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-center">
                            <p class="text-xs text-gray-400">
                                <i class="fa-solid fa-circle-check text-green-400 mr-1"></i>
                                Semua notifikasi sudah dibaca
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            

            
            <div x-data="{ userOpen: false }" class="relative" @click.outside="userOpen = false">
                <button @click="userOpen = !userOpen"
                    class="flex items-center gap-2.5 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-150 focus:outline-none"
                    aria-label="User Menu">

                    
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0
                        <?php if(Auth::user()->role === 'admin'): ?>   bg-purple-600
                        <?php elseif(Auth::user()->role === 'coach'): ?>  bg-blue-600
                        <?php elseif(Auth::user()->role === 'parent'): ?> bg-green-600
                        <?php else: ?>                                     bg-amber-500
                        <?php endif; ?>">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                    </div>

                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-semibold text-gray-800 leading-tight max-w-[120px] truncate">
                            <?php echo e(Auth::user()->name); ?>

                        </p>
                        <p class="text-[10px] text-gray-400 leading-tight"><?php echo e(ucfirst(Auth::user()->role)); ?></p>
                    </div>

                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 hidden sm:block"></i>
                </button>

                
                <div x-show="userOpen"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden py-1"
                     style="display:none; top: calc(100% + 4px);">

                    
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/60">
                        <p class="text-xs font-semibold text-gray-800 truncate"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-[11px] text-gray-500 mt-0.5 truncate">
                            <span class="inline-block w-1.5 h-1.5 rounded-full mr-1
                                <?php if(Auth::user()->role === 'admin'): ?>   bg-purple-500
                                <?php elseif(Auth::user()->role === 'coach'): ?>  bg-blue-500
                                <?php elseif(Auth::user()->role === 'parent'): ?> bg-green-500
                                <?php else: ?>                                     bg-amber-500
                                <?php endif; ?>">
                            </span>
                            <?php echo e(ucfirst(Auth::user()->role)); ?>

                        </p>
                    </div>

                    
                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-user-gear w-4 text-center text-gray-400"></i>
                        Edit Profil
                    </a>

                    
                    <div class="border-t border-gray-100 my-1"></div>

                    
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            

        </div>
    </div>
</header>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>