<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? config('app.name', 'Klub Renang')); ?></title>

    <link rel="icon" href="<?php echo e(asset('images/black_diamond.png')); ?>" type="image/png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-outfit antialiased bg-[#0B0F17] text-white">
    <div x-data="{ sidebarExpanded: true, sidebarHovered: false, mobileSidebarOpen: false }" class="min-h-screen xl:flex">
        
        <div>
            <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            <!-- Backdrop -->
            <div x-show="mobileSidebarOpen" 
                 x-transition.opacity.duration.300ms
                 @click="mobileSidebarOpen = false" 
                 class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                 style="display: none;"></div>
        </div>

        <div class="flex-1 min-w-0 transition-all duration-300 ease-in-out"
             :class="(sidebarExpanded || sidebarHovered) ? 'lg:ml-[290px]' : 'lg:ml-[90px]'">
            
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
                <!-- Flash Messages (Global Single Notification) -->
                <?php if(session('success') || session('error') || session('status')): ?>
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 5000)" class="mb-4">
                        <?php if(session('success')): ?>
                            <div class="flex items-center p-4 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-check text-lg mr-3 text-emerald-500 shrink-0"></i>
                                <div>
                                    <span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(session('error')): ?>
                            <div class="flex items-center p-4 text-sm text-rose-800 dark:text-rose-300 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-xmark text-lg mr-3 text-rose-500 shrink-0"></i>
                                <div>
                                    <span class="font-bold">Error!</span> <?php echo e(session('error')); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(session('status')): ?>
                            <div class="flex items-center p-4 text-sm text-blue-800 dark:text-blue-300 rounded-2xl bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-info text-lg mr-3 text-blue-500 shrink-0"></i>
                                <div>
                                    <?php echo e(session('status')); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/app.blade.php ENDPATH**/ ?>