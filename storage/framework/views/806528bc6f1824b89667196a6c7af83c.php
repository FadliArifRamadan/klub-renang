<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e($title ?? config('app.name', 'Black Diamond')); ?></title>

        <!-- Fonts & Icons -->
        <link rel="icon" href="<?php echo e(asset('images/black_diamond_1.png')); ?>" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .hero-pattern {
                background-image: radial-gradient(rgba(211, 175, 55, 0.08) 1px, transparent 0), radial-gradient(rgba(211, 175, 55, 0.04) 1px, transparent 0);
                background-size: 32px 32px;
                background-position: 0 0, 16px 16px;
            }
        </style>
    </head>
    <body class="antialiased bg-[#0B0F17] text-slate-100 min-h-screen relative overflow-x-hidden overflow-y-auto">
        <!-- Background Elements for Dark Luxury Look -->
        <div class="absolute inset-0 hero-pattern opacity-40 pointer-events-none"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#D3AF37]/15 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-[#D3AF37]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 relative z-10 w-full">
            <div class="w-full sm:max-w-md">
                <!-- Card Container -->
                <div class="w-full bg-[#101828]/90 backdrop-blur-xl border border-[#D3AF37]/30 shadow-2xl shadow-black/80 rounded-3xl p-6 sm:p-8">
                    <!-- Logo & Heading -->
                    <div class="text-center mb-6">
                        <a href="/" class="inline-block hover:opacity-90 transition-opacity">
                            <img src="<?php echo e(asset('images/black_diamond_1.png')); ?>" alt="Black Diamond Logo" class="h-20 w-auto mx-auto object-contain brightness-0 invert drop-shadow-[0_0_12px_rgba(211,175,55,0.5)]">
                        </a>
                        <h2 class="text-xl font-extrabold text-[#D3AF37] mt-4 leading-tight">
                            <?php if(request()->routeIs('login')): ?>
                                Selamat Datang Kembali
                            <?php elseif(request()->routeIs('register')): ?>
                                Pendaftaran Akun Baru
                            <?php elseif(request()->routeIs('password.request')): ?>
                                Lupa Password Anda?
                            <?php elseif(request()->routeIs('password.reset')): ?>
                                Atur Ulang Password
                            <?php else: ?>
                                Black Diamond Swim
                            <?php endif; ?>
                        </h2>
                        <?php if(!request()->routeIs('password.request')): ?>
                            <p class="text-xs text-slate-300 mt-1">
                                <?php if(request()->routeIs('login')): ?>
                                    Silakan masuk untuk mengelola program renang Anda
                                <?php elseif(request()->routeIs('register')): ?>
                                    Mulai langkah pertama Anda bersama klub renang kami
                                <?php elseif(request()->routeIs('password.reset')): ?>
                                    Silakan tentukan password baru akun Anda
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php echo e($slot); ?>

                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/guest.blade.php ENDPATH**/ ?>