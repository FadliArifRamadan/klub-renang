<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Persetujuan Izin Pelatih'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Persetujuan Izin Pelatih')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <?php if(session('success')): ?>
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal!</span> <?php echo e(session('error')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Kelola Pengajuan Izin Pelatih</h3>
                    <p class="text-xs text-gray-500 mt-1">Review pengajuan izin berhalangan melatih, tugaskan pelatih pengganti, atau liburkan sesi latihan jika pelatih tidak tersedia.</p>
                </div>

                
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
                    <?php
                        $pendingCount = \App\Models\CoachLeave::where('status', 'pending')->count();
                        $approvedCount = \App\Models\CoachLeave::where('status', 'approved')->count();
                        $rejectedCount = \App\Models\CoachLeave::where('status', 'rejected')->count();
                    ?>
                    <a href="<?php echo e(route('admin.leaves.index', ['status' => 'pending'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'pending' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-hourglass-half"></i>
                        Menunggu Persetujuan
                        <span class="px-2 py-0.5 text-xs rounded-full <?php echo e($status === 'pending' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600'); ?>">
                            <?php echo e($pendingCount); ?>

                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.leaves.index', ['status' => 'approved'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'approved' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-circle-check"></i>
                        Disetujui
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            <?php echo e($approvedCount); ?>

                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.leaves.index', ['status' => 'rejected'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'rejected' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Ditolak
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            <?php echo e($rejectedCount); ?>

                        </span>
                    </a>
                </div>

                
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Pelatih</th>
                                <th scope="col" class="px-6 py-3">Tanggal Izin</th>
                                <th scope="col" class="px-6 py-3">Alasan Izin</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3">Pelatih Pengganti / Info</th>
                                <?php if($status === 'pending'): ?>
                                    <th scope="col" class="px-4 py-3 text-center w-36">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        <?php echo e(($leaves->currentPage() - 1) * $leaves->perPage() + $index + 1); ?>

                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800">
                                        <?php echo e($leave->coach->name); ?>

                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">
                                        <?php echo e($leave->leave_date->translatedFormat('d F Y')); ?>

                                        <div class="text-[10px] font-normal text-gray-400">Hari <?php echo e($leave->leave_date->translatedFormat('l')); ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                        <?php echo e($leave->reason); ?>

                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php if($leave->status === 'approved'): ?>
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Disetujui</span>
                                        <?php elseif($leave->status === 'rejected'): ?>
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Ditolak</span>
                                        <?php else: ?>
                                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($leave->status === 'approved'): ?>
                                            <?php if($leave->substitute_coach_id): ?>
                                                <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-user-tie text-blue-500"></i>
                                                    Pengganti: <?php echo e($leave->substituteCoach->name); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-sm font-bold text-amber-600 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-calendar-minus"></i>
                                                    Latihan Diliburkan
                                                </span>
                                            <?php endif; ?>
                                        <?php elseif($leave->status === 'rejected'): ?>
                                            <div class="text-xs text-red-500 font-semibold italic">
                                                Catatan: <?php echo e($leave->rejection_reason ?? '-'); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">Menunggu keputusan</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if($status === 'pending'): ?>
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'approve-leave-<?php echo e($leave->id); ?>')"
                                                    class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1">
                                                    <i class="fa-solid fa-check"></i> Proses
                                                </button>
                                            </div>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'approve-leave-'.e($leave->id).'','maxWidth' => 'lg','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'approve-leave-'.e($leave->id).'','maxWidth' => 'lg','focusable' => true]); ?>
                                                <div class="p-6 text-left">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                                                        <i class="fa-solid fa-calendar-times text-blue-600"></i>
                                                        Proses Izin Pelatih: <?php echo e($leave->coach->name); ?>

                                                    </h3>
                                                    <p class="text-xs text-gray-400 mb-4">
                                                        Izin untuk tanggal: <strong><?php echo e($leave->leave_date->translatedFormat('d F Y')); ?></strong> (<?php echo e($leave->leave_date->translatedFormat('l')); ?>).
                                                        <br>Alasan: <span class="italic text-gray-600">"<?php echo e($leave->reason); ?>"</span>
                                                    </p>

                                                    
                                                    <div class="mb-4 bg-slate-50 border border-slate-200 rounded-xl p-3">
                                                        <h4 class="text-xs font-bold text-gray-700 mb-2 flex items-center gap-1">
                                                            <i class="fa-solid fa-business-time text-slate-500"></i>
                                                            Jadwal Bertugas Hari Ini:
                                                        </h4>
                                                        <?php if(isset($leave->schedules) && count($leave->schedules) > 0): ?>
                                                            <ul class="space-y-1.5 text-xs text-gray-600">
                                                                <?php $__currentLoopData = $leave->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li class="flex justify-between border-b border-gray-100 pb-1 last:border-0 last:pb-0">
                                                                        <span><?php echo e($sched->swimmingClass->name); ?> (<?php echo e($sched->time_range); ?>)</span>
                                                                        <span class="font-semibold text-gray-700"><?php echo e($sched->location->name); ?></span>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        <?php else: ?>
                                                            <p class="text-xs text-red-500 italic font-semibold">Tidak ada jadwal latihan regular pelatih di hari <?php echo e($leave->leave_date->translatedFormat('l')); ?>.</p>
                                                        <?php endif; ?>
                                                    </div>

                                                    <form method="POST" action="<?php echo e(route('admin.leaves.approve', $leave->id)); ?>">
                                                        <?php echo csrf_field(); ?>

                                                        
                                                        <div class="mb-4">
                                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'substitute_coach_id-'.e($leave->id).'','value' => 'Pilih Pelatih Pengganti / Substitusi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'substitute_coach_id-'.e($leave->id).'','value' => 'Pilih Pelatih Pengganti / Substitusi']); ?>
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
                                                            <select id="substitute_coach_id-<?php echo e($leave->id); ?>" name="substitute_coach_id" 
                                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                                <option value="" selected>-- Latihan Diliburkan (Tidak ada pengganti) --</option>
                                                                
                                                                
                                                                <?php if(isset($leave->recommended_coaches) && $leave->recommended_coaches->isNotEmpty()): ?>
                                                                    <optgroup label="Rekomendasi Pelatih (Bertugas di Jam & Lokasi yang Sama)">
                                                                        <?php $__currentLoopData = $leave->recommended_coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recCoach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($recCoach->id); ?>"><?php echo e($recCoach->name); ?> (Terjadwal)</option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </optgroup>
                                                                <?php endif; ?>

                                                                
                                                                <?php if(isset($leave->day_coaches) && $leave->day_coaches->isNotEmpty()): ?>
                                                                    <optgroup label="Pelatih Bertugas di Hari yang Sama (Beda Jam/Lokasi)">
                                                                        <?php $__currentLoopData = $leave->day_coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayCoach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(!isset($leave->recommended_coaches) || !$leave->recommended_coaches->contains('id', $dayCoach->id)): ?>
                                                                                <option value="<?php echo e($dayCoach->id); ?>"><?php echo e($dayCoach->name); ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </optgroup>
                                                                <?php endif; ?>
                                                            </select>
                                                            <small class="text-gray-400 mt-1 block">*Jika diliburkan, murid tidak akan dipotong kuotanya dan mendapat notifikasi libur.</small>
                                                        </div>

                                                        <div class="flex justify-between items-center border-t pt-4 mt-6">
                                                            
                                                            <button type="button" x-data=""
                                                                x-on:click="$dispatch('close'); setTimeout(() => $dispatch('open-modal', 'reject-leave-<?php echo e($leave->id); ?>'), 200)"
                                                                class="px-3 py-1.5 border border-red-300 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors">
                                                                Tolak Izin
                                                            </button>

                                                            <div class="flex gap-2">
                                                                <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['type' => 'button','xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','x-on:click' => '$dispatch(\'close\')']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                                    Setujui Izin
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
                                                        </div>
                                                    </form>
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

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'reject-leave-'.e($leave->id).'','maxWidth' => 'lg','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'reject-leave-'.e($leave->id).'','maxWidth' => 'lg','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.leaves.reject', $leave->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>

                                                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 text-red-600">
                                                        <i class="fa-solid fa-times-circle"></i>
                                                        Tolak Izin Pelatih: <?php echo e($leave->coach->name); ?>

                                                    </h3>

                                                    <div class="mb-4">
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'rejection_reason-'.e($leave->id).'','value' => 'Alasan Penolakan Izin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'rejection_reason-'.e($leave->id).'','value' => 'Alasan Penolakan Izin']); ?>
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
                                                        <textarea id="rejection_reason-<?php echo e($leave->id); ?>" name="rejection_reason" rows="3" required
                                                            placeholder="Tulis alasan mengapa pengajuan izin pelatih ditolak..."
                                                            class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"></textarea>
                                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('rejection_reason'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('rejection_reason')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                                                        <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['type' => 'button','xOn:click' => '$dispatch(\'close\'); setTimeout(() => $dispatch(\'open-modal\', \'approve-leave-'.e($leave->id).'\'), 200)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','x-on:click' => '$dispatch(\'close\'); setTimeout(() => $dispatch(\'open-modal\', \'approve-leave-'.e($leave->id).'\'), 200)']); ?>
                                                            Kembali
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
                                                        <?php if (isset($component)) { $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                            Ya, Tolak Izin
                                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $attributes = $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $component = $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
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
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada pengajuan izin pelatih dengan status ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="mt-4">
                    <?php echo e($leaves->links()); ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/leaves/index.blade.php ENDPATH**/ ?>