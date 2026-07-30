<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Riwayat Absensi Kelas Prestasi'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Riwayat Absensi - Kelas Prestasi')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:bg-boxdark dark:border-strokedark">
                
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        <i class="fa-solid fa-clipboard-list text-amber-500 mr-2"></i>Riwayat Absensi Kelas Prestasi
                    </h3>

                    
                    <form action="<?php echo e(route('admin.attendances.prestasi')); ?>" method="GET" class="flex items-center gap-2 flex-nowrap whitespace-nowrap">
                        <div class="relative flex items-center w-48 sm:w-60 shrink-0">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-[#D3AF37] focus:border-[#D3AF37] block w-full pl-9 pr-3 py-2 dark:bg-meta-4 dark:border-strokedark dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cari nama coach/atlet...">
                        </div>
                        <button type="submit" class="px-3.5 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-bold rounded-lg transition shadow-sm cursor-pointer whitespace-nowrap shrink-0">
                            Cari
                        </button>
                        <a href="<?php echo e(route('admin.attendances.prestasi')); ?>" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-lg border border-slate-600 shadow-sm transition flex items-center gap-1.5 whitespace-nowrap cursor-pointer shrink-0">
                            <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset
                        </a>
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
                                    <th class="px-6 py-3">Nama Atlet</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
                                    <th class="px-6 py-3 text-center">Jumlah</th>
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
                                            <?php if($att->session_type === 'swim'): ?>
                                                <span class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/30 px-2.5 py-1 rounded border border-cyan-200 dark:border-cyan-800 text-xs font-semibold whitespace-nowrap">
                                                    <i class="fa-solid fa-water"></i> Berenang
                                                </span>
                                            <?php elseif($att->session_type === 'dryland'): ?>
                                                <span class="inline-flex items-center gap-1 text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2.5 py-1 rounded border border-orange-200 dark:border-orange-800 text-xs font-semibold whitespace-nowrap">
                                                    <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                         
                                         <td class="px-6 py-4 text-center">
                                             <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold leading-none text-green-700 bg-green-50 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 rounded whitespace-nowrap">
                                                 Ke-<?php echo e($att->session_count ?? 1); ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/attendances/prestasi.blade.php ENDPATH**/ ?>