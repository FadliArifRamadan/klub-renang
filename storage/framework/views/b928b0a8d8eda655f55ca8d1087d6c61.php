<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Parent - Data Anak Saya'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Daftar Anak Saya')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200"
                    role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fa-solid fa-children text-blue-600 mr-2"></i>Informasi Kursus Anak
                    </h3>
                    <a href="<?php echo e(route('parent.students.create')); ?>"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dynamic-button">
                        <i class="fa-solid fa-plus mr-1"></i> Daftarkan Anak Lagi
                    </a>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Anak</th>
                                <th scope="col" class="px-6 py-3">Gender</th>
                                <th scope="col" class="px-6 py-3">Paket Kursus</th>
                                <th scope="col" class="px-6 py-3 min-w-[150px]">Jadwal Latihan</th>
                                <th scope="col" class="px-6 py-3">Coach / Pelatih</th>
                                <th scope="col" class="px-6 py-3">Progress Absensi</th>
                                <th scope="col" class="px-6 py-3 text-center">Status Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        <?php echo e($loop->iteration); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo e($student->name); ?>

                                        <div class="text-xs text-gray-400 font-normal">Lahir:
                                            <?php echo e($student->birth_date?->format('d M Y')); ?></div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php echo e($student->gender_label); ?>

                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="font-medium text-gray-800"><?php echo e($student->package->name ?? 'Tidak Ada Paket'); ?></span>
                                        <div class="text-xs text-gray-400">Total: <?php echo e($student->package->sessions ?? 0); ?>

                                            Sesi</div>
                                        <?php if($student->package_expires_at): ?>
                                            <div class="text-[10px] text-gray-500 mt-0.5 whitespace-nowrap">
                                                <i class="fa-solid fa-calendar-day mr-0.5"></i>
                                                Batas: <?php echo e($student->package_expires_at->format('d M Y')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php $__empty_2 = true; $__currentLoopData = $student->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <div class="mb-1.5 last:mb-0">
                                                <span class="inline-flex items-center text-[11px] font-semibold text-slate-800 bg-slate-100 rounded px-1.5 py-0.5">
                                                    <?php echo e($sched->day_name); ?> (<?php echo e(substr($sched->start_time, 0, 5)); ?>)
                                                </span>
                                                <div class="text-[10px] text-slate-500 font-medium ml-1 mt-0.5 leading-tight">
                                                    <i class="fa-solid fa-map-pin mr-0.5 text-amber-500"></i> <?php echo e($sched->location->name); ?> 
                                                    <span class="mx-1 text-gray-300">•</span> 
                                                    <?php if($sched->session_type == 'dryland'): ?>
                                                        <span class="text-amber-600">Darat</span>
                                                    <?php else: ?>
                                                        <span class="text-blue-600">Renang</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <span class="text-xs text-gray-400 italic">Belum Pilih Jadwal</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if($student->coach): ?>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-2.5 py-1 rounded">
                                                    <i class="fa-solid fa-user-tie mr-1.5"></i>
                                                    <?php echo e($student->coach->name); ?>

                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400 italic text-xs">Mencari Rekomendasi Admin</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php
                                            $totalSesi = $student->package->sessions ?? 0;
                                            $sesiTerpakai = max(0, $totalSesi - $student->quota_left);
                                            $progressPct =
                                                $totalSesi > 0 ? round(($sesiTerpakai / $totalSesi) * 100) : 0;
                                            $barColor = match (true) {
                                                $progressPct >= 80 => 'bg-red-500',
                                                $progressPct >= 50 => 'bg-amber-400',
                                                default => 'bg-blue-500',
                                            };
                                        ?>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-[70px]">
                                                <div class="<?php echo e($barColor); ?> h-2 rounded-full transition-all duration-300"
                                                    style="width: <?php echo e($progressPct); ?>%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                                                <?php echo e($sesiTerpakai); ?>/<?php echo e($totalSesi); ?>

                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            Sisa: <span class="font-semibold text-blue-600"><?php echo e($student->quota_left); ?>

                                                sesi</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $latestPayment = $student->latestPayment;
                                        ?>

                                        <?php if($student->status == 'active'): ?>
                                            <span
                                                class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">Aktif</span>
                                        <?php elseif($student->status == 'suspended'): ?>
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-pause mr-1"></i>Dibekukan
                                                (<?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?>)
                                            </span>
                                        <?php elseif($student->status == 'inactive'): ?>
                                            <?php if($student->quota_left <= 0): ?>
                                                <span
                                                    class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                    <i class="fa-solid fa-circle-xmark mr-1"></i>Sesi Habis
                                                </span>
                                            <?php else: ?>
                                                <span
                                                    class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                    <i class="fa-solid fa-circle-xmark mr-1"></i>Masa Aktif Habis
                                                </span>
                                            <?php endif; ?>
                                        <?php elseif($latestPayment && $latestPayment->status == 'pending'): ?>
                                            <span
                                                class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-semibold">Sedang
                                                Diverifikasi</span>
                                        <?php elseif($latestPayment && $latestPayment->status == 'rejected'): ?>
                                            <span
                                                class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">Ditolak
                                                (Konfirmasi Ulang)
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">Menunggu
                                                Pembayaran</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Anda belum
                                        mendaftarkan anak. Silakan klik tombol "Daftarkan Anak Lagi".</td>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/parent/students/index.blade.php ENDPATH**/ ?>