<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Coach - Riwayat Absensi'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Riwayat Absensi Murid')); ?>

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
                    <h3 class="text-base font-semibold text-gray-800">
                        <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi
                    </h3>
                    <a href="<?php echo e(route('coach.attendances.create')); ?>"
                        class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-bold shadow-md transition-all text-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-plus"></i> Input Absensi Baru
                    </a>
                </div>

                <?php if($attendances->isEmpty()): ?>
                    
                    <div class="border rounded-lg p-12 text-center text-gray-400">
                        <i class="fa-solid fa-clipboard-list text-4xl mb-3 block text-gray-300"></i>
                        <p class="font-medium text-gray-600">Belum ada data absensi.</p>
                        <p class="text-xs mt-1">Data absensi murid akan muncul di sini setelah Anda menginput absensi.</p>
                    </div>
                <?php else: ?>
                    
                    <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Nama Murid</th>
                                    <th class="px-6 py-3">Jenis Sesi</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-150">
                                        
                                        <td class="px-4 py-4 text-center">
                                            <?php echo e(($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <?php echo e(\Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y')); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 font-semibold text-gray-900">
                                            <?php echo e($att->student->name ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4">
                                            <?php if($att->session_type === 'swim'): ?>
                                                <span class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs font-semibold">
                                                    <i class="fa-solid fa-water"></i> Berenang
                                                </span>
                                            <?php elseif($att->session_type === 'dryland'): ?>
                                                <span class="inline-flex items-center gap-1.5 text-orange-700 bg-orange-50 px-2.5 py-1 rounded border border-orange-200 text-xs font-semibold">
                                                    <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <?php echo e($att->location->name ?? '-'); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="mt-4">
                        <?php echo e($attendances->links()); ?>

                    </div>
                <?php endif; ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/attendances/index.blade.php ENDPATH**/ ?>