<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Kelola Murid'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Kelola Semua Data Murid')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-strokedark">
                <div class="p-6 text-gray-900 dark:text-white">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 pb-4 border-b border-gray-200 dark:border-strokedark">
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-users text-[#D3AF37]"></i> Daftar Anggota Klub Renang
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Memantau seluruh status pendaftaran, pelatih yang ditunjuk, dan paket latihan aktif secara terpusat.</p>
                        </div>
                        <div class="flex flex-col items-start md:items-end gap-2.5 w-full md:w-auto">
                            
                            <div class="text-xs bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] font-bold px-3.5 py-1.5 rounded-lg whitespace-nowrap shadow-sm">
                                Total: <?php echo e($students->total()); ?> Anak
                            </div>

                            
                            <form method="GET" action="<?php echo e(route('admin.students.index')); ?>" class="flex items-center gap-2 flex-nowrap whitespace-nowrap">
                                <div class="relative flex items-center w-48 sm:w-56 shrink-0">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </span>
                                    <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Cari murid / coach..." class="w-full pl-9 pr-3 py-2 text-xs border border-gray-300 dark:border-strokedark rounded-lg bg-gray-50 dark:bg-meta-4 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#D3AF37] shadow-sm">
                                </div>
                                <button type="submit" class="px-3.5 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-bold rounded-lg transition shadow-sm cursor-pointer whitespace-nowrap shrink-0">
                                    Cari
                                </button>
                                <a href="<?php echo e(route('admin.students.index')); ?>" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-lg border border-slate-600 shadow-sm transition flex items-center gap-1.5 whitespace-nowrap cursor-pointer shrink-0">
                                    <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-strokedark shadow-sm">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-meta-4 border-b border-gray-200 dark:border-strokedark text-center">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-4 py-3 text-left">Nama Anak</th>
                                    <th class="px-4 py-3 text-left">Kelas & Paket</th>
                                    <th class="px-4 py-3 text-left min-w-[150px]">Jadwal Latihan</th>
                                    <th class="px-4 py-3">Coach / Pelatih</th>
                                    <th class="px-4 py-3 text-center min-w-[120px]">Absensi</th>
                                    <th class="px-4 py-3 text-center">Status & Masa Aktif</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-strokedark">
                                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-meta-4 transition duration-150">

                                    <td class="px-4 py-4 text-center text-gray-600 dark:text-gray-400">
                                        <?php echo e($loop->iteration + ($students->currentPage() - 1) * $students->perPage()); ?>

                                    </td>

                                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white text-left">
                                        <div><?php echo e($student->name); ?></div>
                                        <div class="mt-1">
                                            <?php if($student->coach_gender_preference === 'P'): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-[#D3AF37]/10 dark:bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30">
                                                <i class="fa-solid fa-venus"></i> Pref: Pelatih Perempuan
                                            </span>
                                            <?php elseif($student->coach_gender_preference === 'L'): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-[#D3AF37]/10 dark:bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30">
                                                <i class="fa-solid fa-mars"></i> Pref: Pelatih Laki-laki
                                            </span>
                                            <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                <i class="fa-solid fa-users text-[9px]"></i> Pref: Bebas
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-left">
                                        <div class="font-semibold text-gray-950 dark:text-white"><?php echo e($student->swimmingClass->name ?? 'Belum Pilih Kelas'); ?></div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400 font-medium"><?php echo e($student->swimmingClass->category->name ?? '-'); ?></div>
                                        <div class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                            Paket: <span class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($student->package->name ?? '-'); ?></span>
                                        </div>
                                        <div class="text-[11px] text-amber-600 dark:text-[#D3AF37] font-bold mt-0.5">
                                            Harga: Rp
                                            <?php if($student->package): ?>
                                            <?php echo e(number_format($student->package->getPriceForLocation($student->location_id), 0, ',', '.')); ?>

                                            <?php else: ?>
                                            0
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-left">
                                        <?php $__empty_2 = true; $__currentLoopData = $student->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <div class="mb-1.5 last:mb-0">
                                            <span class="inline-flex items-center text-[11px] font-semibold text-slate-800 dark:text-slate-100 bg-slate-100 dark:bg-slate-800 rounded px-1.5 py-0.5">
                                                <?php echo e($sched->day_name); ?> (<?php echo e(substr($sched->start_time, 0, 5)); ?>)
                                            </span>
                                            <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium ml-1 mt-0.5 leading-tight">
                                                <i class="fa-solid fa-map-pin mr-0.5 text-amber-500"></i> <?php echo e($sched->location->name); ?>

                                                <span class="mx-1 text-gray-300 dark:text-gray-600">•</span>
                                                <?php if($sched->session_type == 'dryland'): ?>
                                                <span class="text-slate-600 dark:text-slate-300">Darat</span>
                                                <?php else: ?>
                                                <span class="text-slate-600 dark:text-slate-300">Renang</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum Pilih Jadwal</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <?php
                                        $coaches = $student->schedules->map(fn($s) => $s->coach)->filter()->unique('id');
                                        ?>
                                        <?php $__empty_2 = true; $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <div class="mb-1 last:mb-0">
                                            <span class="inline-flex items-center bg-[#D3AF37]/10 dark:bg-[#D3AF37]/15 text-[#D3AF37] text-xs px-2.5 py-1 rounded-md font-bold border border-[#D3AF37]/40 shadow-sm">
                                                <i class="fa-solid fa-user-tie mr-1.5 text-[10px]"></i>
                                                <?php echo e($c->name); ?>

                                            </span>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <?php if($student->coach): ?>
                                        <span class="inline-flex items-center bg-[#D3AF37]/10 dark:bg-[#D3AF37]/15 text-[#D3AF37] text-xs px-2.5 py-1 rounded-md font-bold border border-[#D3AF37]/40 shadow-sm">
                                            <i class="fa-solid fa-user-tie mr-1.5 text-[10px]"></i>
                                            <?php echo e($student->coach->name); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum Ditentukan</span>
                                        <?php endif; ?>
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
                                        default => 'bg-amber-400',
                                        };
                                        ?>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 dark:bg-slate-700 rounded-full h-2 min-w-[70px]">
                                                <div class="<?php echo e($barColor); ?> h-2 rounded-full transition-all duration-300" style="width: <?php echo e($progressPct); ?>%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 dark:text-slate-300 whitespace-nowrap">
                                                <?php echo e($sesiTerpakai); ?>/<?php echo e($totalSesi); ?>

                                            </span>
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                            Sisa: <span class="font-bold text-amber-600 dark:text-[#D3AF37]"><?php echo e($student->quota_left); ?> sesi</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <!-- Status Label -->
                                        <div class="mb-2">
                                            <?php if($student->status == 'active'): ?>
                                            <span class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Aktif</span>
                                            <?php elseif($student->status == 'suspended'): ?>
                                            <span class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                <i class="fa-solid fa-circle-pause mr-1 text-[10px]"></i>
                                                Membeku
                                                (<?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?>)
                                            </span>
                                            <?php elseif($student->status == 'inactive'): ?>
                                            <?php if($student->quota_left <= 0): ?> <span class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                <i class="fa-solid fa-circle-exclamation mr-1 text-[10px]"></i>
                                                Sesi Habis
                                                </span>
                                                <?php else: ?>
                                                <span class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                    <i class="fa-solid fa-circle-xmark mr-1 text-[10px]"></i>
                                                    Masa Aktif Habis
                                                </span>
                                                <?php endif; ?>
                                                <?php elseif($student->status == 'pending_activation'): ?>
                                                <span class="bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/40 text-xs px-3 py-1 rounded-full font-bold shadow-sm inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-hourglass-half text-[10px]"></i> Menunggu Aktivasi
                                                </span>
                                                <?php elseif($student->status == 'checking'): ?>
                                                <span class="bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/40 text-xs px-3 py-1 rounded-full font-bold shadow-sm animate-pulse">Mengecek Pembayaran</span>
                                                <?php elseif($student->status == 'pending'): ?>
                                                <?php if($student->latestPayment && $student->latestPayment->status == 'rejected'): ?>
                                                <span class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Ditolak
                                                </span>
                                                <?php else: ?>
                                                <span class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Menunggu
                                                    Pembayaran</span>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <span class="bg-gray-100 text-gray-800 border border-gray-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm"><?php echo e($student->status); ?></span>
                                                <?php endif; ?>
                                        </div>

                                        <!-- Batas Waktu -->
                                        <?php
                                        $isSingleSession = ($student->package->package_type ?? '') === 'single_session' || ($student->package->sessions ?? 0) == 1 || ($student->package->active_period_months ?? 1) == 0;
                                        ?>
                                        <?php if(!$isSingleSession && $student->package_expires_at): ?>
                                        <span class="text-[11px] font-semibold text-gray-700 dark:text-gray-300 block mb-1">
                                            s/d <?php echo e($student->package_expires_at->format('d M Y')); ?>

                                        </span>
                                        <?php
                                        $isFutureStart = $student->package_activated_at && $student->package_activated_at->isFuture();
                                        $startDate = $isFutureStart ? $student->package_activated_at : now();
                                        $diffInDays = $startDate->diffInDays($student->package_expires_at, false);
                                        ?>
                                        <?php if($student->status == 'active'): ?>
                                        <?php if($isFutureStart): ?>
                                        <span class="text-[10px] text-amber-600 dark:text-amber-400 font-bold bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 px-1.5 py-0.5 rounded block mt-0.5">
                                            Mulai <?php echo e($student->package_activated_at->format('d M')); ?> (<?php echo e(round($diffInDays)); ?> hr)
                                        </span>
                                        <?php elseif($diffInDays < 0): ?> <span class="text-[10px] text-red-600 font-bold bg-red-50 border border-red-200 px-1.5 py-0.5 rounded">Hangus</span>
                                            <?php elseif($diffInDays <= 7): ?> <span class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded"><?php echo e(round($diffInDays)); ?>

                                                hari lagi</span>
                                                <?php else: ?>
                                                <span class="text-[10px] text-green-600 font-bold bg-green-50 border border-green-200 px-1.5 py-0.5 rounded"><?php echo e(round($diffInDays)); ?>

                                                    hari aktif</span>
                                                <?php endif; ?>
                                                <?php elseif($student->status == 'suspended'): ?>
                                                <span class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">DI-FREEZE</span>
                                                <?php endif; ?>
                                        <?php elseif($isSingleSession): ?>
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 dark:text-[#D3AF37] bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800/50 px-2 py-0.5 rounded mt-0.5">
                                            <i class="fa-solid fa-bolt text-[9px]"></i> Single Session
                                        </span>
                                        <?php else: ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">
                                            <?php if($student->status == 'active'): ?>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'suspend-student-<?php echo e($student->id); ?>')" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                                                <i class="fa-solid fa-pause mr-1"></i> Ijin/Sakit
                                            </button>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'suspend-student-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'suspend-student-'.e($student->id).'','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.students.suspend', $student->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>
                                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                                                        <i class="fa-solid fa-pause text-amber-500 mr-2"></i>
                                                        Pemberhentian Sementara: <?php echo e($student->name); ?>

                                                    </h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                        Murid akan diberhentikan sementara dari latihan. Sisa kuota
                                                        dan masa aktif paket akan dibekukan (frozen) sampai murid
                                                        diaktifkan kembali.
                                                    </p>

                                                    <div class="mt-4">
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'reason-'.e($student->id).'','value' => 'Pilih Alasan Pemberhentian']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'reason-'.e($student->id).'','value' => 'Pilih Alasan Pemberhentian']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                        <div class="flex items-center space-x-6 mt-2">
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input type="radio" name="reason" value="sakit" checked class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Sakit</span>
                                                            </label>
                                                            <label class="inline-flex items-center cursor-pointer">
                                                                <input type="radio" name="reason" value="ijin" class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Ijin</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                                                            Batal
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'bg-amber-500 hover:bg-amber-600 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-amber-500 hover:bg-amber-600 text-white']); ?>
                                                            Bekukan Paket
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                                    </div>
                                                </form>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                            <?php elseif($student->status == 'suspended'): ?>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'resume-student-<?php echo e($student->id); ?>')" class="px-2.5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                                                <i class="fa-solid fa-play mr-1"></i> Aktifkan
                                            </button>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'resume-student-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'resume-student-'.e($student->id).'','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.students.resume', $student->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>
                                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                                                        <i class="fa-solid fa-play text-green-500 mr-2"></i>
                                                        Aktifkan Kembali Latihan: <?php echo e($student->name); ?>

                                                    </h3>

                                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                        Masa aktif paket latihan murid ini akan diperpanjang secara
                                                        otomatis sesuai dengan lama waktu murid tersebut ijin/sakit.
                                                    </p>

                                                    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-lg text-xs mb-4">
                                                        <i class="fa-solid fa-info-circle mr-1"></i>
                                                        <strong>Detail Pembekuan:</strong><br>
                                                        - Mulai Dibekukan:
                                                        <?php echo e($student->suspended_at?->format('d M Y - H:i')); ?><br>
                                                        - Alasan:
                                                        <?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?><br>
                                                        - Durasi Suspend:
                                                        <?php echo e(round(now()->diffInDays($student->suspended_at))); ?> Hari
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                                                            Batal
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'bg-green-600 hover:bg-green-700 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-green-600 hover:bg-green-700 text-white']); ?>
                                                            Aktifkan Latihan
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                                    </div>
                                                </form>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                            <?php elseif($student->status == 'pending_activation'): ?>
                                             <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'activate-student-<?php echo e($student->id); ?>')" class="px-2.5 py-1.5 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                                                 <i class="fa-solid fa-calendar-check mr-1"></i> Aktifkan Paket
                                             </button>

                                             
                                             <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'activate-student-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'activate-student-'.e($student->id).'','focusable' => true]); ?>
                                                 <form method="POST" action="<?php echo e(route('admin.students.activate', $student->id)); ?>" class="p-6 text-left">
                                                     <?php echo csrf_field(); ?>
                                                     <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                                                         <i class="fa-solid fa-calendar-check text-[#D3AF37]"></i>
                                                         Aktifkan Paket Latihan: <?php echo e($student->name); ?>

                                                     </h3>

                                                     <p class="text-xs text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                                         Pembayaran murid telah disetujui. Silakan tentukan <strong>Tanggal Mulai Latihan</strong>. Masa aktif paket 30 hari akan dihitung mulai dari tanggal yang Anda tetapkan di bawah ini.
                                                     </p>

                                                     <div class="mb-4">
                                                         <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'activation_date-'.e($student->id).'','value' => 'Tanggal Mulai Latihan *','class' => 'font-bold text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'activation_date-'.e($student->id).'','value' => 'Tanggal Mulai Latihan *','class' => 'font-bold text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                         <div class="relative mt-1">
                                                             <input type="date" id="activation_date-<?php echo e($student->id); ?>" name="activation_date" value="<?php echo e(date('Y-m-d')); ?>" class="block w-full border-gray-300 dark:border-strokedark focus:border-[#D3AF37] focus:ring-[#D3AF37] rounded-lg shadow-sm text-xs bg-gray-50 dark:bg-meta-4 text-gray-900 dark:text-white pr-10 cursor-pointer" required>
                                                             <button type="button" onclick="document.getElementById('activation_date-<?php echo e($student->id); ?>').showPicker()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-[#D3AF37]">
                                                                 <i class="fa-solid fa-calendar-days text-sm"></i>
                                                             </button>
                                                         </div>
                                                         <span class="text-[10px] text-gray-400 mt-1 block">*Masa berlaku paket (30 hari) akan terhitung sejak tanggal yang Anda pilih.</span>
                                                     </div>

                                                     <div class="mt-6 flex justify-end space-x-3">
                                                         <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                                                             Batal
                                                          <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                         <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-bold text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-bold text-xs']); ?>
                                                             <i class="fa-solid fa-check mr-1.5"></i> Setujui & Aktifkan Paket
                                                          <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                                     </div>
                                                 </form>
                                              <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                             <?php elseif($student->status == 'pending'): ?>
                                             <span class="px-2.5 py-1.5 bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 font-bold text-xs rounded-lg inline-flex items-center gap-1.5 cursor-not-allowed whitespace-nowrap" title="Pembayaran belum diverifikasi oleh Admin Finance">
                                                 <i class="fa-solid fa-clock text-amber-500"></i> Menunggu Verifikasi Finance
                                             </span>
                                             <?php endif; ?>

                                            
                                            <?php if(($student->swimmingClass->category->slug ?? '') === 'prestasi' || $student->family_card_image || $student->student_image): ?>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'athlete-documents-<?php echo e($student->id); ?>')" class="px-2.5 py-1.5 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap" title="Lihat Berkas Lomba Atlet">
                                                <i class="fa-solid fa-folder-open mr-1"></i> Berkas
                                            </button>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'athlete-documents-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'athlete-documents-'.e($student->id).'','focusable' => true]); ?>
                                                <div class="p-6 text-left dark:bg-gray-800">
                                                    <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                                                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                            <i class="fa-solid fa-trophy text-amber-500"></i> Berkas Atlet Pendaftaran Lomba: <?php echo e($student->name); ?>

                                                        </h3>
                                                        <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                                            <i class="fa-solid fa-xmark text-lg"></i>
                                                        </button>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        
                                                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                                            <h4 class="text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                                                                <i class="fa-solid fa-image text-amber-500"></i> Pas Foto / Foto Atlet
                                                            </h4>
                                                            <?php if($student->student_image): ?>
                                                            <?php
                                                            $photoUrl = asset('storage/' . $student->student_image);
                                                            ?>
                                                            <div class="relative group mb-3">
                                                                <img src="<?php echo e($photoUrl); ?>" alt="Foto <?php echo e($student->name); ?>" class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm" />
                                                            </div>
                                                            <a href="<?php echo e($photoUrl); ?>" download target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-bold rounded-lg transition shadow-sm">
                                                                <i class="fa-solid fa-download"></i> Unduh Pas Foto
                                                            </a>
                                                            <?php else: ?>
                                                            <div class="p-6 text-center text-xs text-gray-400 italic bg-white dark:bg-gray-800 rounded-lg border border-dashed">
                                                                Belum ada foto atlet yang diunggah.
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        
                                                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                                            <h4 class="text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-2 flex items-center gap-1.5">
                                                                <i class="fa-solid fa-id-card text-emerald-500"></i> Kartu Keluarga (KK)
                                                            </h4>
                                                            <?php if($student->family_card_image): ?>
                                                            <?php
                                                            $kkUrl = asset('storage/' . $student->family_card_image);
                                                            $isPdf = str_ends_with(strtolower($student->family_card_image), '.pdf');
                                                            ?>
                                                            <?php if($isPdf): ?>
                                                            <div class="p-6 text-center bg-white dark:bg-gray-800 rounded-lg border border-gray-200 mb-3">
                                                                <i class="fa-solid fa-file-pdf text-red-500 text-4xl mb-2"></i>
                                                                <span class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Dokumen PDF KK</span>
                                                            </div>
                                                            <?php else: ?>
                                                            <div class="relative group mb-3">
                                                                <img src="<?php echo e($kkUrl); ?>" alt="KK <?php echo e($student->name); ?>" class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm" />
                                                            </div>
                                                            <?php endif; ?>
                                                            <a href="<?php echo e($kkUrl); ?>" download target="_blank" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                                                                <i class="fa-solid fa-download"></i> Unduh Berkas KK
                                                            </a>
                                                            <?php else: ?>
                                                            <div class="p-6 text-center text-xs text-gray-400 italic bg-white dark:bg-gray-800 rounded-lg border border-dashed">
                                                                Belum ada berkas KK yang diunggah.
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="mt-4 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/80 p-4 rounded-xl text-xs shadow-sm">
                                                        <h5 class="font-bold text-amber-600 dark:text-[#D3AF37] mb-3 text-xs uppercase tracking-wider flex items-center gap-1.5">
                                                            <i class="fa-solid fa-user-check text-amber-500"></i> Detail Data Atlet untuk Pendaftaran Kejuaraan:
                                                        </h5>
                                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">Nama Lengkap</span>
                                                                <strong class="text-xs text-slate-900 dark:text-white font-extrabold block truncate"><?php echo e($student->name); ?></strong>
                                                            </div>
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">Tanggal Lahir</span>
                                                                <strong class="text-xs text-slate-900 dark:text-white font-extrabold block"><?php echo e($student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->translatedFormat('d F Y') : '-'); ?></strong>
                                                            </div>
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">Usia Atlet</span>
                                                                <strong class="text-xs text-amber-600 dark:text-amber-400 font-extrabold block"><?php echo e($student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->age . ' Tahun' : '-'); ?></strong>
                                                            </div>
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">Jenis Kelamin</span>
                                                                <strong class="text-xs text-slate-900 dark:text-white font-extrabold block"><?php echo e($student->gender === 'L' ? 'Laki-laki' : ($student->gender === 'P' ? 'Perempuan' : '-')); ?></strong>
                                                            </div>
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">Nama Wali</span>
                                                                <strong class="text-xs text-slate-900 dark:text-white font-extrabold block truncate"><?php echo e($student->user->name ?? '-'); ?></strong>
                                                            </div>
                                                            <div class="bg-white dark:bg-slate-800/90 p-2.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                                <span class="text-[10px] font-bold uppercase text-slate-500 dark:text-slate-400 block mb-0.5">No. WhatsApp</span>
                                                                <strong class="text-xs text-emerald-600 dark:text-emerald-400 font-extrabold block"><?php echo e($student->user->phone ?? ($student->parent_phone ?? '-')); ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-5 flex justify-end">
                                                        <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                                                            Tutup
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                    </div>
                                                </div>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                            <?php endif; ?>

                                            
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'delete-student-<?php echo e($student->id); ?>')" class="px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap" title="Hapus Murid">
                                                <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                            </button>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'delete-student-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'delete-student-'.e($student->id).'','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.students.destroy', $student->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                                                        <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                                                        Hapus Data Murid: <?php echo e($student->name); ?>

                                                    </h3>
                                                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                                        Apakah Anda yakin ingin menghapus data murid <span class="font-bold text-gray-900 dark:text-white"><?php echo e($student->name); ?></span>? Data murid, pendaftaran, dan riwayat absensinya akan dihapus dari sistem secara permanen.
                                                    </p>
                                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-strokedark">
                                                        <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
                                                            Batal
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg transition shadow-md">
                                                            Ya, Hapus Murid
                                                        </button>
                                                    </div>
                                                </form>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="px-6 py-10 text-center text-sm text-gray-400">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                                            <span>Belum ada data murid yang terdaftar pada sistem.</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 px-2">
                        <?php echo e($students->links()); ?>

                    </div>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/students/index.blade.php ENDPATH**/ ?>