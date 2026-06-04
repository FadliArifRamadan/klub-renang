<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Coach - Data Murid Saya'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Data Murid Saya')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> <?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fa-solid fa-users text-blue-600 mr-2"></i>
                        Daftar Murid Saya
                        <span class="ml-2 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            <?php echo e($students->count()); ?> Murid
                        </span>
                    </h3>
                </div>

                
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">#</th>
                                <th class="px-6 py-3">Nama Murid</th>
                                <th class="px-6 py-3">Paket Kursus</th>
                                <th class="px-6 py-3">Kolam Latihan</th>
                                <th class="px-6 py-3 text-center">Progress Absensi</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $totalSesi = $student->package->sessions ?? 0;
                                    $sesiTerpakai = $totalSesi - $student->quota_left;
                                    $sesiTerpakai = max(0, $sesiTerpakai); // pastikan tidak negatif
                                    $progressPct = $totalSesi > 0 ? round(($sesiTerpakai / $totalSesi) * 100) : 0;

                                    // Warna progress bar
                                    $barColor = match (true) {
                                        $progressPct >= 80 => 'bg-red-500',
                                        $progressPct >= 50 => 'bg-amber-400',
                                        default => 'bg-blue-500',
                                    };

                                    $latestPayment = $student->latestPayment;
                                ?>
                                <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium"><?php echo e($index + 1); ?></td>

                                    
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900"><?php echo e($student->name); ?></div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            <i class="fa-solid fa-venus-mars mr-1"></i>
                                            <?php echo e($student->gender === 'L' ? 'Laki-laki' : 'Perempuan'); ?>

                                            &nbsp;·&nbsp;
                                            <i class="fa-solid fa-cake-candles mr-1"></i>
                                            <?php echo e($student->birth_date?->format('d M Y') ?? '-'); ?>

                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800">
                                            <?php echo e($student->package->name ?? 'Tidak Ada Paket'); ?>

                                        </span>
                                        <div class="text-xs text-gray-400">Total: <?php echo e($totalSesi); ?> Sesi</div>
                                        <?php if($student->package_expires_at): ?>
                                            <div class="text-[10px] text-gray-500 mt-0.5">
                                                <i class="fa-solid fa-calendar-day mr-0.5"></i>
                                                Batas: <?php echo e($student->package_expires_at->format('d M Y')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    
                                    <td class="px-6 py-4">
                                        <i class="fa-solid fa-location-dot text-blue-400 mr-1"></i>
                                        <?php echo e($student->location->name ?? 'Belum Dipilih'); ?>

                                    </td>

                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-[80px]">
                                                <div class="<?php echo e($barColor); ?> h-2 rounded-full transition-all duration-300"
                                                    style="width: <?php echo e($progressPct); ?>%">
                                                </div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                                                <?php echo e($sesiTerpakai); ?> / <?php echo e($totalSesi); ?> sesi
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1 text-center">
                                            Sisa: <span class="font-semibold text-blue-600"><?php echo e($student->quota_left); ?>

                                                sesi</span>
                                        </div>
                                    </td>

                                    
                                    <td class="px-6 py-4 text-center">
                                        <?php if($student->status === 'active'): ?>
                                            <span
                                                class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-check mr-1"></i>Aktif
                                            </span>
                                        <?php elseif($student->status === 'suspended'): ?>
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-pause mr-1"></i>Dibekukan (<?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?>)
                                            </span>
                                        <?php elseif($student->status === 'inactive'): ?>
                                            <span
                                                class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i>Hangus
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="bg-gray-100 text-gray-600 border border-gray-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-clock mr-1"></i>Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fa-solid fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                                        <p class="font-medium">Belum ada murid yang ditugaskan ke Anda.</p>
                                        <p class="text-xs mt-1">Silakan hubungi Admin untuk penugasan murid.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/students/index.blade.php ENDPATH**/ ?>