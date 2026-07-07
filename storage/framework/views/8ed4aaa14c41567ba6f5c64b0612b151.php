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

<body class="font-outfit antialiased bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
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

        <div class="flex-1 transition-all duration-300 ease-in-out"
             :class="(sidebarExpanded || sidebarHovered) ? 'lg:ml-[290px]' : 'lg:ml-[90px]'">
            
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
                <!-- Flash Messages -->
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-4">
                    <?php if(session('success')): ?>
                        <div class="bg-success-50 border border-success-200 text-success-700 px-4 py-3 rounded-lg mb-2 flex items-center">
                            <i class="fa-solid fa-check-circle mr-2 text-success-500"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="bg-error-50 border border-error-200 text-error-700 px-4 py-3 rounded-lg mb-2 flex items-center">
                            <i class="fa-solid fa-triangle-exclamation mr-2 text-error-500"></i> <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <?php echo e($slot); ?>

            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/app.blade.php ENDPATH**/ ?>