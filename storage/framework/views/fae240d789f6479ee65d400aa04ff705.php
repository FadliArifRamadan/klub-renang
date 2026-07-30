<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Umum - Riwayat Absensi'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Riwayat Absensi Saya')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi
                </h3>

                <?php if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator && $attendances->count() > 0): ?>
                    <div class="overflow-x-auto border sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 text-xs text-gray-700 uppercase border-b">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                    <th class="px-6 py-3">Nama Coach</th>
                                    <th class="px-6 py-3">Nama Peserta</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
                                    <th class="px-6 py-3 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $categorySlug = $att->student->swimmingClass->category->slug ?? '';
                                        $isPrestasi = ($categorySlug === 'prestasi');
                                        $pkgType = $att->student->package->package_type ?? '';
                                        $labels = [
                                            'regular' => 'Reguler',
                                            'private' => 'Private',
                                            'single_session' => 'Single Session',
                                            'monthly_prestasi' => 'Bulanan Prestasi'
                                        ];
                                    ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b">
                                        
                                        <td class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-500 font-semibold">
                                            <?php echo e(($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            <?php echo e(\Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y')); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="inline-flex items-center gap-1.5 text-xs">
                                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                                <?php echo e($att->location->name ?? '-'); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            <?php echo e($att->coach->name ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            <?php echo e($att->student->name ?? '-'); ?>

                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <?php if($isPrestasi): ?>
                                                <?php if($att->session_type === 'swim'): ?>
                                                    <span class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/30 px-2.5 py-1 rounded border border-cyan-200 dark:border-cyan-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-water"></i> Berenang
                                                    </span>
                                                <?php elseif($att->session_type === 'dryland'): ?>
                                                    <span class="inline-flex items-center gap-1 text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2.5 py-1 rounded border border-orange-200 dark:border-orange-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/30 px-2.5 py-1 rounded border border-cyan-200 dark:border-cyan-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-water"></i> Berenang
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/40">
                                                    <?php echo e($labels[$pkgType] ?? 'Reguler'); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <?php if($isPrestasi): ?>
                                                <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold leading-none text-green-700 bg-green-50 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 rounded whitespace-nowrap">
                                                    Ke-<?php echo e($att->session_count ?? 1); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <?php echo e($attendances->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fa-solid fa-calendar-xmark text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium">Belum Ada Riwayat Absensi</p>
                        <p class="text-gray-400 text-sm mt-1">Data absensi Anda akan muncul di sini setelah coach mencatat kehadiran Anda.</p>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/general/attendances/index.blade.php ENDPATH**/ ?>