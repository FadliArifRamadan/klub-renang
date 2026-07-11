<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Riwayat Absensi Kelas Belajar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Riwayat Absensi - Kelas Belajar')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:bg-boxdark dark:border-strokedark">
                
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi Kelas Belajar
                    </h3>

                    
                    <form action="<?php echo e(route('admin.attendances.belajar')); ?>" method="GET" class="flex gap-2">
                        <div class="relative w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 dark:bg-meta-4 dark:border-strokedark dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Cari nama coach/murid...">
                        </div>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            Cari
                        </button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('admin.attendances.belajar')); ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-meta-4 dark:border-strokedark dark:text-white dark:hover:bg-gray-700 transition-colors">
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if($attendances->isEmpty()): ?>
                    
                    <div class="border border-gray-200 dark:border-strokedark rounded-lg p-12 text-center text-gray-400 dark:text-gray-500">
                        <i class="fa-solid fa-clipboard-list text-4xl mb-3 block text-gray-300 dark:text-gray-600"></i>
                        <p class="font-medium text-gray-600 dark:text-gray-400">Belum ada data absensi yang ditemukan.</p>
                    </div>
                <?php else: ?>
                    
                    <div class="relative overflow-x-auto border border-gray-200 dark:border-strokedark sm:rounded-lg mb-6">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-meta-4 border-b border-gray-200 dark:border-strokedark dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                    <th class="px-6 py-3">Nama Coach</th>
                                    <th class="px-6 py-3">Nama Murid</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="bg-white dark:bg-boxdark border-b border-gray-200 dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4 transition-colors duration-150">
                                        
                                        <td class="px-4 py-4 text-center">
                                            <?php echo e(($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            <?php echo e(\Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y')); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            <span class="inline-flex items-center gap-1.5 text-xs">
                                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                                <?php echo e($att->location->name ?? '-'); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            <?php echo e($att->coach->name ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            <?php echo e($att->student->name ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 text-center">
                                            <?php
                                                $pkgType = $att->student->package->package_type ?? '';
                                                $labels = [
                                                    'regular' => 'Reguler',
                                                    'private' => 'Private',
                                                    'single_session' => 'Single Session',
                                                    'monthly_prestasi' => 'Bulanan Prestasi'
                                                ];
                                            ?>
                                            <span class="inline-flex items-center gap-1 text-gray-700 bg-gray-100 px-2.5 py-1 rounded border border-gray-300 text-xs font-semibold whitespace-nowrap">
                                                <?php echo e($labels[$pkgType] ?? 'Reguler'); ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/attendances/belajar.blade.php ENDPATH**/ ?>