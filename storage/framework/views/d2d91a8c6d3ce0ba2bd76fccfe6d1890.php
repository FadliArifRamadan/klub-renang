<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Pengajuan Pindah Jadwal'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            <?php echo e(__('Pengajuan Pindah Jadwal')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-boxdark p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-strokedark">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-gray-100 dark:border-strokedark pb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Pengajuan Perubahan Jadwal</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review dan kelola permohonan pemindahan jadwal latihan mingguan yang diajukan oleh Orang Tua atau Murid Mandiri.</p>
                    </div>
                </div>

                
                <div class="flex border-b border-gray-200 dark:border-strokedark mb-6 overflow-x-auto">
                    <?php
                        $pendingCount = \App\Models\ScheduleChangeRequest::where('status', 'pending')->count();
                        $approvedCount = \App\Models\ScheduleChangeRequest::where('status', 'approved')->count();
                        $rejectedCount = \App\Models\ScheduleChangeRequest::where('status', 'rejected')->count();
                    ?>
                    <a href="<?php echo e(route('admin.schedule-requests.index', ['status' => 'pending'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'pending' ? 'border-amber-500 text-amber-600 dark:text-[#D3AF37]' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-200 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Pending
                        <span class="px-2 py-0.5 text-xs rounded-full <?php echo e($status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:text-gray-300'); ?>">
                            <?php echo e($pendingCount); ?>

                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.schedule-requests.index', ['status' => 'approved'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'approved' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-200 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-circle-check"></i>
                        Disetujui
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:text-gray-300">
                            <?php echo e($approvedCount); ?>

                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.schedule-requests.index', ['status' => 'rejected'])); ?>" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 <?php echo e($status === 'rejected' ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-200 hover:border-gray-300'); ?>">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Ditolak
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:text-gray-300">
                            <?php echo e($rejectedCount); ?>

                        </span>
                    </a>
                </div>

                <div class="relative overflow-x-auto border border-gray-100 dark:border-strokedark sm:rounded-xl">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b border-gray-100 dark:border-strokedark">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3">Tanggal & Murid</th>
                                <th scope="col" class="px-4 py-3">Diajukan Oleh</th>
                                <th scope="col" class="px-4 py-3">Jadwal Lama</th>
                                <th scope="col" class="px-4 py-3">Jadwal Baru</th>
                                <th scope="col" class="px-4 py-3">Alasan</th>
                                <th scope="col" class="px-4 py-3 text-center w-48">Status / Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white dark:bg-boxdark border-b border-gray-100 dark:border-strokedark hover:bg-gray-50 dark:bg-meta-4/50 transition-colors">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        <?php echo e(($requests->currentPage() - 1) * $requests->perPage() + $index + 1); ?>

                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                                            <i class="fa-solid fa-clock"></i>
                                            <?php echo e($req->created_at->translatedFormat('d M Y, H:i')); ?>

                                        </div>
                                        <div class="font-bold text-gray-900 dark:text-white"><?php echo e($req->student->name); ?></div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mt-0.5">
                                            <span class="px-1.5 py-0.5 rounded-full <?php echo e(($req->student->swimmingClass->category->slug ?? '') === 'prestasi' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-blue-50 text-blue-700 border border-blue-100'); ?>">
                                                <?php echo e($req->student->swimmingClass->name ?? '-'); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800 dark:text-gray-100"><?php echo e($req->user->name); ?></div>
                                        <div class="text-[10px] text-gray-400 mt-0.5">
                                            <?php echo e($req->user->role === 'parent' ? 'Orang Tua (Parent)' : 'Mandiri (General)'); ?>

                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1.5">
                                            <?php $__empty_2 = true; $__currentLoopData = $req->old_schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oldSched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <div class="p-1.5 bg-gray-50 dark:bg-meta-4 border border-gray-200 dark:border-strokedark rounded-lg text-[11px]">
                                                    <div class="font-bold text-gray-700 dark:text-gray-200 flex items-center justify-between">
                                                        <span><?php echo e($oldSched->day_name); ?>, <?php echo e($oldSched->time_range); ?></span>
                                                        <span class="px-1 py-0.2 rounded text-[9px] <?php echo e($oldSched->session_type === 'dryland' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800'); ?>">
                                                            <?php echo e($oldSched->session_type === 'dryland' ? 'Darat' : 'Air'); ?>

                                                        </span>
                                                    </div>
                                                    <div class="text-gray-500 dark:text-gray-400 text-[10px] mt-0.5 flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-[9px]"></i>
                                                        <?php echo e($oldSched->location->name ?? '-'); ?>

                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <span class="text-gray-400 italic text-xs">Tidak ada jadwal lama</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1.5">
                                            <?php $__empty_2 = true; $__currentLoopData = $req->new_schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newSched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <div class="p-1.5 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-[11px]">
                                                    <div class="font-bold text-slate-800 dark:text-slate-200 flex items-center justify-between">
                                                        <span><?php echo e($newSched->day_name); ?>, <?php echo e($newSched->time_range); ?></span>
                                                        <span class="px-1 py-0.2 rounded text-[9px] <?php echo e($newSched->session_type === 'dryland' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300' : 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-800 dark:text-cyan-300'); ?>">
                                                            <?php echo e($newSched->session_type === 'dryland' ? 'Darat' : 'Air'); ?>

                                                        </span>
                                                    </div>
                                                    <div class="text-slate-500 dark:text-slate-400 text-[10px] mt-0.5 flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-[9px]"></i>
                                                        <?php echo e($newSched->location->name ?? '-'); ?>

                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <span class="text-gray-400 italic text-xs text-red-500">Tidak ada jadwal baru pilihan</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="text-xs text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-meta-4/60 p-2.5 rounded-lg border border-gray-100 dark:border-strokedark max-w-[200px] break-words whitespace-pre-line italic">
                                            "<?php echo e($req->reason); ?>"
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <?php if($req->status === 'pending'): ?>
                                            <div class="flex flex-col gap-2 justify-center items-center">
                                                <button type="button" 
                                                        x-data=""
                                                        x-on:click="$dispatch('open-modal', 'approve-request-<?php echo e($req->id); ?>')"
                                                        class="w-full py-1.5 px-3 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 rounded-lg shadow-sm transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-check"></i> Setujui
                                                </button>

                                                <button type="button" 
                                                        x-data=""
                                                        x-on:click="$dispatch('open-modal', 'reject-request-<?php echo e($req->id); ?>')"
                                                        class="w-full py-1.5 px-3 text-xs font-bold text-rose-600 bg-white dark:bg-boxdark border border-rose-200 hover:bg-rose-50 rounded-lg transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-xmark"></i> Tolak
                                                </button>
                                            </div>

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'approve-request-'.e($req->id).'','maxWidth' => 'md','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'approve-request-'.e($req->id).'','maxWidth' => 'md','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.schedule-requests.approve', $req->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>
                                                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2 text-emerald-600">
                                                        <i class="fa-solid fa-circle-check text-lg"></i> Setujui Pengajuan Jadwal
                                                    </h3>
                                                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                                        Apakah Anda yakin ingin menyetujui pengajuan pindah jadwal murid <strong><?php echo e($req->student->name); ?></strong>? Jadwal (dan lokasi latihan jika relevan) murid akan terupdate secara otomatis.
                                                    </p>

                                                    <div class="flex justify-end gap-2 mt-6">
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
                                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition flex items-center gap-1.5">
                                                            <i class="fa-solid fa-check"></i> Ya, Setujui
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

                                            
                                            <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'reject-request-'.e($req->id).'','maxWidth' => 'md','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'reject-request-'.e($req->id).'','maxWidth' => 'md','focusable' => true]); ?>
                                                <form method="POST" action="<?php echo e(route('admin.schedule-requests.reject', $req->id)); ?>" class="p-6 text-left">
                                                    <?php echo csrf_field(); ?>
                                                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2 text-rose-600">
                                                        <i class="fa-solid fa-circle-exclamation text-lg"></i> Tolak Pengajuan Jadwal
                                                    </h3>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                                        Masukkan alasan penolakan untuk pengajuan jadwal murid <strong><?php echo e($req->student->name); ?></strong>. Alasan ini akan dikirimkan langsung ke pengguna pembuat pengajuan.
                                                    </p>

                                                    <div class="mb-4">
                                                        <label for="rejection_reason-<?php echo e($req->id); ?>" class="text-xs font-bold text-gray-700 dark:text-gray-200 block mb-1">
                                                            Alasan Penolakan <span class="text-red-500">*</span>
                                                        </label>
                                                        <textarea id="rejection_reason-<?php echo e($req->id); ?>" name="rejection_reason" rows="3" required
                                                                  placeholder="Tuliskan alasan mengapa pengajuan ini ditolak..."
                                                                  class="w-full text-xs rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 resize-none"></textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-2">
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
                                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-sm transition flex items-center gap-1">
                                                            <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
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
                                        <?php elseif($req->status === 'approved'): ?>
                                            <div class="text-left space-y-1">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                                </span>
                                                <div class="text-[9px] text-gray-400">
                                                    Oleh: <?php echo e($req->processor->name ?? '-'); ?>

                                                </div>
                                                <div class="text-[9px] text-gray-400">
                                                    Tgl: <?php echo e($req->processed_at ? $req->processed_at->translatedFormat('d M Y') : '-'); ?>

                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-left space-y-1">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">
                                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                                </span>
                                                <div class="text-[9px] text-gray-400">
                                                    Oleh: <?php echo e($req->processor->name ?? '-'); ?>

                                                </div>
                                                <div class="text-[9px] text-gray-400">
                                                    Tgl: <?php echo e($req->processed_at ? $req->processed_at->translatedFormat('d M Y') : '-'); ?>

                                                </div>
                                                <?php if($req->rejection_reason): ?>
                                                    <div class="text-[10px] text-rose-600 bg-rose-50/50 p-2 rounded-lg border border-rose-100 mt-1 italic break-words max-w-[150px]">
                                                        "<?php echo e($req->rejection_reason); ?>"
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                                            <span>Tidak ada data pengajuan pindah jadwal dengan status ini.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($requests->links()); ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/schedule-requests/index.blade.php ENDPATH**/ ?>