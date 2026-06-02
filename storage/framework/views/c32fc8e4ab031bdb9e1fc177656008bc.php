<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Anggota Klub Renang</h3>
                            <p class="text-xs text-gray-500">Memantau seluruh status pendaftaran, pelatih yang ditunjuk,
                                dan paket latihan aktif secara terpusat.</p>
                        </div>
                        <div
                            class="mt-3 md:mt-0 text-sm bg-blue-50 text-blue-700 font-semibold px-4 py-2 rounded-lg border border-blue-200">
                            Total Pendaftar: <?php echo e($students->total()); ?> Anak
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200 text-center">
                                <tr>
                                    <th class="px-6 py-3 text-left">Nama Anak</th>
                                    <th class="px-6 py-3">Gender</th>
                                    <th class="px-6 py-3">Paket Kursus</th>
                                    <th class="px-6 py-3">Coach / Pelatih</th>
                                    <th class="px-6 py-3 text-center">Progress Absensi</th>
                                    <th class="px-6 py-3 text-center">Batas Waktu</th>
                                    <th class="px-6 py-3">Status Akun</th>
                                    <th class="px-6 py-3">Tanggal Daftar</th>
                                    <th class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50/70 transition duration-150">

                                        <td class="px-6 py-4 font-bold text-gray-900 text-left">
                                            <?php echo e($student->name); ?>

                                        </td>

                                        <td class="px-6 py-4 text-center text-gray-600">
                                            <?php echo e($student->gender_label); ?>

                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="font-medium text-gray-800 block"><?php echo e($student->package->name ?? 'Belum Pilih Paket'); ?></span>
                                            <span class="text-[11px] text-blue-600 font-bold">Rp
                                                <?php echo e(number_format($student->package->price ?? 0, 0, ',', '.')); ?></span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <?php if($student->coach): ?>
                                                <span
                                                    class="inline-flex items-center bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-md font-medium border border-blue-200">
                                                    <i class="fa-solid fa-user-tie mr-1.5 text-[10px]"></i>
                                                    <?php echo e($student->coach->name); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400 italic">Belum Ditentukan</span>
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
                                                Sisa: <span
                                                    class="font-semibold text-blue-600"><?php echo e($student->quota_left); ?>

                                                    sesi</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <?php if($student->package_expires_at): ?>
                                                <span class="text-xs font-semibold text-gray-700 block">
                                                    <?php echo e($student->package_expires_at->format('d M Y')); ?>

                                                </span>
                                                <?php
                                                    $diffInDays = now()->diffInDays($student->package_expires_at, false);
                                                ?>
                                                <?php if($student->status == 'active'): ?>
                                                    <?php if($diffInDays < 0): ?>
                                                        <span class="text-[10px] text-red-600 font-bold bg-red-50 border border-red-200 px-1.5 py-0.5 rounded">Hangus</span>
                                                    <?php elseif($diffInDays <= 7): ?>
                                                        <span class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded"><?php echo e(round($diffInDays)); ?> hari lagi</span>
                                                    <?php else: ?>
                                                        <span class="text-[10px] text-green-600 font-bold bg-green-50 border border-green-200 px-1.5 py-0.5 rounded"><?php echo e(round($diffInDays)); ?> hari aktif</span>
                                                    <?php endif; ?>
                                                <?php elseif($student->status == 'suspended'): ?>
                                                    <span class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">DI-FREEZE</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400 italic">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <?php if($student->status == 'active'): ?>
                                                <span
                                                    class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Aktif</span>
                                            <?php elseif($student->status == 'suspended'): ?>
                                                <span
                                                    class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                    <i class="fa-solid fa-circle-pause mr-1 text-[10px]"></i>
                                                    Membeku (<?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?>)
                                                </span>
                                            <?php elseif($student->status == 'inactive'): ?>
                                                <span
                                                    class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                    <i class="fa-solid fa-circle-xmark mr-1 text-[10px]"></i>
                                                    Hangus
                                                </span>
                                            <?php elseif($student->status == 'checking'): ?>
                                                <span
                                                    class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm animate-pulse">Mengecek
                                                    Pembayaran</span>
                                            <?php elseif($student->status == 'pending'): ?>
                                                <?php if($student->latestPayment && $student->latestPayment->status == 'rejected'): ?>
                                                    <span
                                                        class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Ditolak
                                                        (Konfirmasi Ulang)
                                                    </span>
                                                <?php else: ?>
                                                    <span
                                                        class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Menunggu
                                                        Pembayaran</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span
                                                    class="bg-gray-100 text-gray-800 border border-gray-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm"><?php echo e($student->status); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-6 py-4 text-center text-xs text-gray-400">
                                            <?php echo e($student->created_at->format('d M Y - H:i')); ?>

                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <?php if($student->status == 'active'): ?>
                                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'suspend-student-<?php echo e($student->id); ?>')" 
                                                    class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
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
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                                                            <i class="fa-solid fa-pause text-amber-500 mr-2"></i>
                                                            Pemberhentian Sementara: <?php echo e($student->name); ?>

                                                        </h3>
                                                        <p class="text-sm text-gray-600 mb-4">
                                                            Murid akan diberhentikan sementara dari latihan. Sisa kuota dan masa aktif paket akan dibekukan (frozen) sampai murid diaktifkan kembali.
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
                                                                    <span class="ml-2 text-sm text-gray-700 font-medium">Sakit</span>
                                                                </label>
                                                                <label class="inline-flex items-center cursor-pointer">
                                                                    <input type="radio" name="reason" value="ijin" class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                    <span class="ml-2 text-sm text-gray-700 font-medium">Ijin</span>
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
                                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'resume-student-<?php echo e($student->id); ?>')" 
                                                    class="px-2.5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
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
                                                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                                                            <i class="fa-solid fa-play text-green-500 mr-2"></i>
                                                            Aktifkan Kembali Latihan: <?php echo e($student->name); ?>

                                                        </h3>
                                                        
                                                        <p class="text-sm text-gray-600 mb-4">
                                                            Masa aktif paket latihan murid ini akan diperpanjang secara otomatis sesuai dengan lama waktu murid tersebut ijin/sakit.
                                                        </p>

                                                        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-lg text-xs mb-4">
                                                            <i class="fa-solid fa-info-circle mr-1"></i>
                                                            <strong>Detail Pembekuan:</strong><br>
                                                            - Mulai Dibekukan: <?php echo e($student->suspended_at?->format('d M Y - H:i')); ?><br>
                                                            - Alasan: <?php echo e($student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin'); ?><br>
                                                            - Durasi Suspend: <?php echo e(round(now()->diffInDays($student->suspended_at))); ?> Hari
                                                        </div>

                                                        <div class="mt-4">
                                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'coach_id_'.e($student->id).'','value' => 'Pilih Coach / Pelatih Pendamping']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'coach_id_'.e($student->id).'','value' => 'Pilih Coach / Pelatih Pendamping']); ?>
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
                                                            <select id="coach_id_<?php echo e($student->id); ?>" name="coach_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                                                <?php $__currentLoopData = $coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $isCurrentCoach = $student->coach_id == $coach->id;
                                                                        $isFull = $coach->students_count >= 5;
                                                                    ?>
                                                                    <option value="<?php echo e($coach->id); ?>" <?php echo e($isCurrentCoach ? 'selected' : ''); ?> <?php echo e($isFull && !$isCurrentCoach ? 'disabled' : ''); ?>>
                                                                        <?php echo e($coach->name); ?> (<?php echo e($coach->students_count); ?>/5 Murid Aktif)
                                                                        <?php if($isCurrentCoach): ?> [Pelatih Asal] <?php endif; ?>
                                                                        <?php if($isFull && !$isCurrentCoach): ?> [PENUH] <?php endif; ?>
                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                            <p class="text-xs text-gray-400 mt-1">Hanya pelatih yang memiliki slot kosong (&lt; 5 murid aktif) yang dapat ditugaskan.</p>
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
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400 italic">Tidak ada aksi</span>
                                            <?php endif; ?>
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