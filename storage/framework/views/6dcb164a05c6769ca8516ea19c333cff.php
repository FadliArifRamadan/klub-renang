<!-- Background backdrop for mobile/tablet when sidebar is open -->
<div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-650/50 lg:hidden" @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;"></div>

<!-- Sidebar container -->
<div class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-white border-r transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-auto"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="flex items-center justify-between px-2 mb-6">
        <img src="<?php echo e(asset('images/black_diamond_1.png')); ?>" alt="Black Diamond Logo">
        <button @click="sidebarOpen = false"
            class="p-2 text-gray-500 rounded-md lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav class="space-y-1">
            
            <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route(Auth::user()->role . '.dashboard'),'active' => request()->routeIs(Auth::user()->role . '.dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route(Auth::user()->role . '.dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs(Auth::user()->role . '.dashboard'))]); ?>
                <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                <span class="font-medium">Dashboard</span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

            
            <?php if(Auth::user()->role === 'admin'): ?>
                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('admin.payments.index'),'active' => request()->routeIs('admin.payments.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.payments.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.payments.index'))]); ?>
                    <i class="fa-solid fa-wallet w-5 text-center"></i>
                    <span class="font-medium">Verifikasi Pembayaran</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('admin.students.index'),'active' => request()->routeIs('admin.students.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.students.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.students.index'))]); ?>
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span class="font-medium">Kelola Murid</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <hr class="my-4 border-gray-200" />
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Data Master</p>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('admin.coaches.index'),'active' => request()->routeIs('admin.coaches.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.coaches.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.coaches.index'))]); ?>
                    <i class="fa-solid fa-user-tie w-5 text-center"></i>
                    <span class="font-medium">Kelola Coach</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('admin.packages.index'),'active' => request()->routeIs('admin.packages.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.packages.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.packages.index'))]); ?>
                    <i class="fa-solid fa-box w-5 text-center"></i>
                    <span class="font-medium">Kelola Paket</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('admin.locations.index'),'active' => request()->routeIs('admin.locations.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.locations.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.locations.index'))]); ?>
                    <i class="fa-solid fa-location-dot w-5 text-center"></i>
                    <span class="font-medium">Tempat Latihan</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
            <?php endif; ?>

            
            <?php if(Auth::user()->role === 'coach'): ?>
                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('coach.students.index'),'active' => request()->routeIs('coach.students.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('coach.students.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('coach.students.index'))]); ?>
                    <i class="fa-solid fa-address-book w-5 text-center"></i>
                    <span class="font-medium">Data Murid Saya</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('coach.attendances.create'),'active' => request()->routeIs('coach.attendances.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('coach.attendances.create')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('coach.attendances.create'))]); ?>
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span class="font-medium">Input Absensi</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('coach.progress.index'),'active' => request()->routeIs('coach.progress.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('coach.progress.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('coach.progress.index'))]); ?>
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span class="font-medium">Catat Perkembangan</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
            <?php endif; ?>

            
            <?php if(Auth::user()->role === 'parent'): ?>
                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('parent.students.create'),'active' => request()->routeIs('parent.students.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('parent.students.create')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('parent.students.create'))]); ?>
                    <i class="fa-solid fa-child w-5 text-center"></i>
                    <span class="font-medium">Daftarkan Anak</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('parent.students.index'),'active' => request()->routeIs('parent.students.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('parent.students.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('parent.students.index'))]); ?>
                    <i class="fa-solid fa-children w-5 text-center"></i>
                    <span class="font-medium">Data Anak Saya</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('parent.payments.index'),'active' => request()->routeIs('parent.payments.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('parent.payments.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('parent.payments.index'))]); ?>
                    <i class="fa-solid fa-credit-card w-5 text-center"></i>
                    <span class="font-medium">Menu Pembayaran</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
            <?php endif; ?>

            
            <?php if(Auth::user()->role === 'general'): ?>
                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('general.students.create'),'active' => request()->routeIs('general.students.create')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('general.students.create')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('general.students.create'))]); ?>
                    <i class="fa-solid fa-user-plus w-5 text-center"></i>
                    <span class="font-medium">Daftar Paket Saya</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('general.students.index'),'active' => request()->routeIs('general.students.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('general.students.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('general.students.index'))]); ?>
                    <i class="fa-solid fa-address-card w-5 text-center"></i>
                    <span class="font-medium">Data Kursus Saya</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-nav-link','data' => ['href' => route('general.payments.index'),'active' => request()->routeIs('general.payments.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('general.payments.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('general.payments.index'))]); ?>
                    <i class="fa-solid fa-money-bill-wave w-5 text-center"></i>
                    <span class="font-medium">Menu Pembayaran</span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $attributes = $__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__attributesOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5)): ?>
<?php $component = $__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5; ?>
<?php unset($__componentOriginal0f13263f1f512da2bd4a4ff79680dcd5); ?>
<?php endif; ?>
            <?php endif; ?>
        </nav>

        <div class="mt-auto pt-4 border-t border-gray-200">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-150">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>