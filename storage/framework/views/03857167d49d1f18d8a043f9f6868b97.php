<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin Finance - Verifikasi & Riwayat Pembayaran'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Kelola & Riwayat Pembayaran Kursus')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12" x-data="{ activeTab: '<?php echo e(request('tab', $activeTab ?? 'pending')); ?>' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="flex items-center space-x-2 border-b border-gray-200 dark:border-gray-700 mb-6">
                <button type="button" @click="activeTab = 'pending'"
                    :class="activeTab === 'pending' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-gray-800 border-b-2' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="py-3 px-5 text-sm rounded-t-lg transition-all duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Menunggu Verifikasi</span>
                    <?php if($pendingPayments->total() > 0): ?>
                        <span class="bg-amber-500 text-slate-950 text-[10px] font-extrabold px-2 py-0.5 rounded-full">
                            <?php echo e($pendingPayments->total()); ?>

                        </span>
                    <?php endif; ?>
                </button>

                <button type="button" @click="activeTab = 'history'"
                    :class="activeTab === 'history' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-gray-800 border-b-2' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="py-3 px-5 text-sm rounded-t-lg transition-all duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Riwayat Transaksi</span>
                    <span class="bg-slate-700 text-slate-200 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                        <?php echo e($historyPayments->total()); ?>

                    </span>
                </button>
            </div>

            
            <div x-show="activeTab === 'pending'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white/90 mb-4 flex items-center justify-between">
                        <span><i class="fa-solid fa-money-bill-wave text-emerald-600 mr-2"></i>Daftar Persetujuan Pembayaran Kursus</span>
                        <span class="text-xs text-gray-400 font-normal">Memuat <?php echo e($pendingPayments->count()); ?> dari <?php echo e($pendingPayments->total()); ?> ajuan</span>
                    </h3>

                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Nama Murid / Wali</th>
                                    <th class="px-6 py-3">Paket Kursus</th>
                                    <th class="px-6 py-3">Nominal Transfer</th>
                                    <th class="px-6 py-3 text-center">Bukti Transfer</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90 text-center">
                                            <?php echo e(($pendingPayments->currentPage() - 1) * $pendingPayments->perPage() + $index + 1); ?>

                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 dark:text-white/90">
                                                <?php echo e($payment->student->name ?? 'N/A'); ?>

                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                <i class="fa-solid fa-user-tie mr-1 text-slate-500"></i>Wali: <?php echo e($payment->student->user->name ?? '-'); ?>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                <?php echo e($payment->student->package->name ?? 'N/A'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-emerald-600">
                                            Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php
                                                $imagePath = file_exists(public_path('receipts/' . $payment->receipt_path))
                                                    ? asset('receipts/' . $payment->receipt_path)
                                                    : asset('storage/receipts/' . $payment->receipt_path);
                                            ?>
                                            <a href="<?php echo e($imagePath); ?>" target="_blank" class="inline-block group relative">
                                                <img src="<?php echo e($imagePath); ?>" alt="Bukti Transfer"
                                                    class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                                <span class="absolute bottom-0 left-0 right-0 bg-black/60 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center py-0.5">
                                                    Buka <i class="fa-solid fa-external-link text-[8px]"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'confirm-payment-verification-<?php echo e($payment->student->id ?? $payment->id); ?>')"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-2 rounded-lg shadow transition flex items-center">
                                                    <i class="fa-solid fa-check mr-1"></i> Setujui
                                                </button>

                                                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-payment-verification-'.e($payment->student->id ?? $payment->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-payment-verification-'.e($payment->student->id ?? $payment->id).'','focusable' => true]); ?>
                                                    <form method="post" action="<?php echo e(route('admin.payments.approve', $payment->student_id)); ?>" class="p-6 text-left dark:bg-gray-800">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="flex items-center justify-start space-x-3 text-emerald-600 mb-4">
                                                            <i class="fa-solid fa-circle-check text-2xl"></i>
                                                            <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                                Persetujuan Pembayaran Kursus
                                                            </h2>
                                                        </div>

                                                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                                                            Apakah Anda yakin ingin menyetujui pembayaran sebesar
                                                            <span class="font-bold text-emerald-600">Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></span>
                                                            dari murid bernama <span class="font-bold text-gray-900 dark:text-white/90">"<?php echo e($payment->student->name ?? 'Murid'); ?>"</span>?
                                                        </p>

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
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150">
                                                                Ya, Setujui Pembayaran
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

                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'reject-payment-<?php echo e($payment->id); ?>')"
                                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-2 rounded-lg shadow transition flex items-center">
                                                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                                </button>

                                                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'reject-payment-'.e($payment->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'reject-payment-'.e($payment->id).'','focusable' => true]); ?>
                                                    <form method="post" action="<?php echo e(route('admin.payments.reject', $payment->id)); ?>" class="p-6 text-left dark:bg-gray-800">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                            <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                                Apakah Anda yakin ingin menolak pembayaran ini?
                                                            </h2>
                                                        </div>

                                                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                            Tindakan ini tidak dapat dibatalkan secara otomatis. Status transaksi milik <span class="font-bold text-gray-900 dark:text-white/90">"<?php echo e($payment->student->name ?? 'Murid'); ?>"</span> akan ditandai sebagai <span class="font-bold text-red-600">Rejected (Ditolak)</span>.
                                                        </p>

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
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
                                                                Ya, Tolak
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
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">
                                            <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300 dark:text-gray-600"></i>
                                            Saat ini tidak ada ajuan konfirmasi pembayaran baru.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <?php echo e($pendingPayments->appends(['tab' => 'pending'])->links()); ?>

                    </div>
                </div>
            </div>

            
            <div x-show="activeTab === 'history'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    
                    
                    <form method="GET" action="<?php echo e(route('admin.payments.index')); ?>" class="mb-6 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-xl border border-slate-200 dark:border-slate-700/60">
                        <input type="hidden" name="tab" value="history">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Cari Nama Murid / Wali</label>
                                <div class="relative">
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama..."
                                        class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white pl-8 focus:ring-emerald-500 focus:border-emerald-500">
                                    <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-xs text-gray-400"></i>
                                </div>
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Status Transaksi</label>
                                <select name="history_status" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Status --</option>
                                    <option value="approved" <?php echo e(request('history_status') == 'approved' ? 'selected' : ''); ?>>Disetujui (Approved)</option>
                                    <option value="rejected" <?php echo e(request('history_status') == 'rejected' ? 'selected' : ''); ?>>Ditolak (Rejected)</option>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Bulan</label>
                                <select name="month" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Bulan --</option>
                                    <?php for($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?php echo e($m); ?>" <?php echo e(request('month') == $m ? 'selected' : ''); ?>>
                                            <?php echo e(Carbon\Carbon::create()->month($m)->translatedFormat('F')); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Tahun</label>
                                <select name="year" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Tahun --</option>
                                    <?php for($y = date('Y'); $y >= 2024; $y--): ?>
                                        <option value="<?php echo e($y); ?>" <?php echo e(request('year') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-end gap-2">
                            <?php if(request()->hasAny(['search', 'history_status', 'month', 'year'])): ?>
                                <a href="<?php echo e(route('admin.payments.index', ['tab' => 'history'])); ?>" class="px-3.5 py-1.5 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-lg border border-slate-600 shadow-sm transition flex items-center gap-1">
                                    <i class="fa-solid fa-rotate-left mr-1"></i>Reset Filter
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow transition">
                                <i class="fa-solid fa-filter mr-1"></i>Terapkan Filter
                            </button>
                        </div>
                    </form>

                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Waktu Transaksi</th>
                                    <th class="px-6 py-3">Nama Murid / Wali</th>
                                    <th class="px-6 py-3">Paket Kursus</th>
                                    <th class="px-6 py-3">Nominal Transfer</th>
                                    <th class="px-6 py-3 text-center">Status</th>
                                    <th class="px-6 py-3 text-center">Bukti Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $historyPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90 text-center">
                                            <?php echo e(($historyPayments->currentPage() - 1) * $historyPayments->perPage() + $index + 1); ?>

                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-600 dark:text-slate-300">
                                            <div><i class="fa-regular fa-calendar mr-1 text-slate-400"></i><?php echo e($payment->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d M Y')); ?></div>
                                            <div class="text-[11px] text-slate-400 mt-0.5"><i class="fa-regular fa-clock mr-1 text-slate-400"></i><?php echo e($payment->created_at->setTimezone('Asia/Jakarta')->format('H:i')); ?> WIB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 dark:text-white/90 flex items-center gap-1.5">
                                                <span><?php echo e($payment->student->name ?? ($payment->student_name ?? 'Murid (Telah Dihapus)')); ?></span>
                                                <?php if(!$payment->student): ?>
                                                    <span class="text-[9px] px-1.5 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 font-bold rounded">Data Murid Dihapus</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                <i class="fa-solid fa-user-tie mr-1 text-slate-500"></i>Wali: <?php echo e($payment->student->user->name ?? ($payment->user_name ?? '-')); ?>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                <?php echo e($payment->student->package->name ?? ($payment->package_name ?? '-')); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-emerald-600">
                                            Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if($payment->status === 'approved'): ?>
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800">
                                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Disetujui
                                                </span>
                                            <?php elseif($payment->status === 'rejected'): ?>
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 border border-red-300 dark:border-red-800">
                                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Ditolak
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 border border-amber-300 dark:border-amber-800">
                                                    <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php
                                                $imagePath = file_exists(public_path('receipts/' . $payment->receipt_path))
                                                    ? asset('receipts/' . $payment->receipt_path)
                                                    : asset('storage/receipts/' . $payment->receipt_path);
                                            ?>
                                            <a href="<?php echo e($imagePath); ?>" target="_blank" class="inline-block group relative">
                                                <img src="<?php echo e($imagePath); ?>" alt="Bukti Transfer"
                                                    class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                                <span class="absolute bottom-0 left-0 right-0 bg-black/60 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center py-0.5">
                                                    Lihat <i class="fa-solid fa-external-link text-[8px]"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">
                                            <i class="fa-solid fa-receipt text-2xl block mb-2 text-gray-300 dark:text-gray-600"></i>
                                            Belum ada riwayat transaksi pembayaran.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <?php echo e($historyPayments->appends(request()->query())->links()); ?>

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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>