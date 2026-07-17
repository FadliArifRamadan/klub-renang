<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Verifikasi Pembayaran'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Verifikasi Pembayaran Masuk')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div
                    class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 font-medium flex items-center">
                    <i class="fa-solid fa-circle-check mr-2 text-lg"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div
                    class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 font-medium flex items-center">
                    <i class="fa-solid fa-circle-xmark mr-2 text-lg"></i>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white/90 mb-4">
                    <i class="fa-solid fa-money-bill-wave text-emerald-600 mr-2"></i>Daftar Persetujuan Pembayaran
                    Kursus
                </h3>

                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-center w-12">No</th>
                                <th class="px-6 py-3">Nama Murid</th>
                                <th class="px-6 py-3">Paket Kursus</th>
                                <th class="px-6 py-3">Nominal Transfer</th>
                                <th class="px-6 py-3">Bukti Transfer</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90 text-center">
                                        <?php echo e(($payments->currentPage() - 1) * $payments->perPage() + $index + 1); ?>

                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90">
                                        <?php echo e($payment->student->name ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo e($payment->student->package->name ?? 'N/A'); ?>

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
                                        <a href="<?php echo e($imagePath); ?>" target="_blank"
                                            class="inline-block group relative">
                                            <img src="<?php echo e($imagePath); ?>" alt="Bukti Transfer"
                                                class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                            <span
                                                class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center">
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
                                                <form method="post"
                                                    action="<?php echo e(route('admin.payments.approve', $payment->student_id)); ?>"
                                                    class="p-6 text-left dark:bg-gray-800">
                                                    <?php echo csrf_field(); ?>

                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-emerald-600 mb-4">
                                                        <i class="fa-solid fa-circle-check text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                            Persetujuan Pembayaran Kursus
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                                                        Apakah Anda yakin ingin menyetujui pembayaran sebesar
                                                        <span class="font-bold text-emerald-600">Rp
                                                            <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></span>
                                                        dari anak bernama <span
                                                            class="font-bold text-gray-900 dark:text-white/90">"<?php echo e($payment->student->name ?? 'Murid'); ?>"</span> dan mengaktifkan murid ini?
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
                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150">
                                                            Ya, Setujui & Aktifkan Murid
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
                                                <form method="post"
                                                    action="<?php echo e(route('admin.payments.reject', $payment->id)); ?>"
                                                    class="p-6 text-left dark:bg-gray-800">
                                                    <?php echo csrf_field(); ?>
                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                            Apakah Anda yakin ingin menolak pembayaran ini?
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                        Tindakan ini tidak dapat dibatalkan secara otomatis. Status
                                                        transaksi milik <span
                                                            class="font-bold text-gray-900 dark:text-white/90">"<?php echo e($payment->student->name ?? 'Murid'); ?>"</span>
                                                        akan ditandai sebagai <span
                                                            class="font-bold text-red-600">Rejected (Ditolak)</span>.
                                                        Gunakan opsi ini jika bukti transfer palsu, nominal tidak
                                                        sesuai, atau dana belum masuk ke rekening klub.
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

                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                                        Saat ini tidak ada ajuan konfirmasi pembayaran baru dari Parent.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($payments->links()); ?>

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