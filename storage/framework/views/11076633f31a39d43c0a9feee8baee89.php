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
            <?php echo e(__('Menu Pembayaran Kursus')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    <i class="fa-solid fa-receipt text-blue-600 mr-2"></i>Status Tagihan Pendaftaran Kursus
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            // Ambil data payment terakhir dari relasi eager loaded
                            $latestPayment = $student->latestPayment;
                        ?>

                        <div class="border rounded-xl p-5 bg-gray-50 shadow-sm relative overflow-hidden">
                            <div class="absolute top-4 right-4">
                                <?php if($student->status == 'active' || ($latestPayment && $latestPayment->status == 'approved')): ?>
                                    <span
                                        class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">Lunas
                                        / Aktif</span>
                                <?php elseif($latestPayment && $latestPayment->status == 'pending'): ?>
                                    <span
                                        class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-semibold">Sedang
                                        Diverifikasi</span>
                                <?php elseif($latestPayment && $latestPayment->status == 'rejected'): ?>
                                    <span
                                        class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">Pembayaran
                                        Ditolak</span>
                                <?php else: ?>
                                    <span
                                        class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">Belum
                                        Bayar</span>
                                <?php endif; ?>
                            </div>

                            <h4 class="text-xl font-bold text-gray-800 mb-1"><?php echo e($student->name); ?></h4>
                            <p class="text-sm text-gray-500 mb-4">Paket Kursus: <span
                                    class="font-semibold text-gray-700"><?php echo e($student->package->name ?? 'Belum Pilih Paket'); ?></span>
                            </p>

                            <?php if($latestPayment && $latestPayment->status == 'rejected'): ?>
                                <div class="mb-4 p-2.5 text-xs text-red-700 bg-red-50 rounded-lg border border-red-200">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> Konfirmasi pembayaran Anda
                                    ditolak Admin. Silakan periksa kembali nominal transfer Anda dan lakukan konfirmasi
                                    ulang di bawah.
                                </div>
                            <?php endif; ?>

                            <div class="border-t pt-3 mt-3 flex justify-between items-center">
                                <div>
                                    <span class="text-xs text-gray-400 block">Total Tagihan</span>
                                    <span class="text-lg font-extrabold text-blue-600">Rp
                                        <?php echo e(number_format($student->package->price ?? 0, 0, ',', '.')); ?></span>
                                </div>

                                <?php if($student->status == 'active' || ($latestPayment && $latestPayment->status == 'approved')): ?>
                                    <span class="text-green-600 font-bold text-sm"><i
                                            class="fa-solid fa-circle-check mr-1"></i> Selesai / Aktif</span>
                                <?php elseif($latestPayment && $latestPayment->status == 'pending'): ?>
                                    <button disabled
                                        class="px-4 py-2 bg-gray-300 text-gray-500 text-xs font-bold uppercase rounded-lg cursor-not-allowed">
                                        Menunggu Admin
                                    </button>
                                <?php else: ?>
                                    <button type="button" x-data=""
                                        x-on:click="$dispatch('open-modal', 'upload-receipt-<?php echo e($student->id); ?>')"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-lg shadow transition flex items-center">
                                        <i class="fa-solid fa-upload mr-1.5"></i> Konfirmasi Bayar
                                    </button>

                                    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'upload-receipt-'.e($student->id).'','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'upload-receipt-'.e($student->id).'','focusable' => true]); ?>
                                        <form method="POST"
                                            action="<?php echo e(route('general.payments.checkout', $student->id)); ?>"
                                            enctype="multipart/form-data" class="p-6 text-left">
                                            <?php echo csrf_field(); ?>

                                            <div class="flex items-center justify-start space-x-3 text-blue-600 mb-4">
                                                <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                                                <h2 class="text-lg font-medium text-gray-900">
                                                    Unggah Bukti Transfer
                                                </h2>
                                            </div>

                                            <div
                                                class="bg-gray-50 border border-gray-200 p-3 rounded-lg mb-4 text-xs text-gray-600">
                                                <p class="mb-1">Silakan transfer sesuai nominal ke rekening berikut:
                                                </p>
                                                <p class="font-bold text-gray-800">Bank BCA: 123-4567-890 (a.n. Klub
                                                    Renang)</p>
                                                <p class="mt-2">Nominal Tagihan: <span
                                                        class="font-bold text-blue-600 text-sm">Rp
                                                        <?php echo e(number_format($student->package->price ?? 0, 0, ',', '.')); ?></span>
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih
                                                    Screenshot Bukti Transfer (Format: JPG/PNG):</label>
                                                <input type="file" name="receipt_image" accept="image/*" required
                                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md p-1 focus:outline-none focus:border-blue-500">
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

                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                                    Kirim Bukti Transfer
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
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-2 text-center py-6 text-gray-400 italic">
                            Anda belum memiliki pendaftaran kursus. Silakan daftar terlebih dahulu.
                        </div>
                    <?php endif; ?>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/general/payments/index.blade.php ENDPATH**/ ?>