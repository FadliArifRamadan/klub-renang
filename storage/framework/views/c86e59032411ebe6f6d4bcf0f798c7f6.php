<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Coach - Input Absensi'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Input Absensi Murid')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> <?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="<?php echo e(route('coach.attendances.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border-b pb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-calendar text-gray-400 mr-1.5"></i>Tanggal Latihan
                            </label>
                            <input type="date" name="date" id="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                                max="<?php echo e(date('Y-m-d')); ?>"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                required>
                            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1 font-semibold"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-user-tie text-gray-400 mr-1.5"></i>Nama Coach (Pelatih)
                            </label>
                            <input type="text" value="<?php echo e(Auth::user()->name); ?>"
                                class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 cursor-not-allowed"
                                readonly>
                        </div>
                    </div>

                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-800">
                            <i class="fa-solid fa-users text-blue-600 mr-2"></i>Pilih Murid yang Hadir Latihan
                        </h3>
                        <?php if($students->isNotEmpty()): ?>
                            <button type="button" id="btn-select-all"
                                class="text-xs text-blue-600 hover:text-blue-800 font-bold transition-all flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 rounded hover:bg-blue-100">
                                <i class="fa-solid fa-square-check"></i>
                                <span id="btn-select-text">Pilih Semua Murid</span>
                            </button>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($students->isEmpty()): ?>
                        <div class="border rounded-lg p-12 text-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-medium text-gray-600">Belum ada murid aktif yang ditugaskan ke Anda.</p>
                            <p class="text-xs mt-1">Hanya murid dengan status "Aktif" yang dapat diabsen.</p>
                        </div>
                    <?php else: ?>
                        <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-center w-16">Kehadiran</th>
                                        <th class="px-6 py-3">Nama Murid</th>
                                        <th class="px-6 py-3">Paket Kursus</th>
                                        <th class="px-6 py-3">Tempat Latihan (Otomatis)</th>
                                        <th class="px-6 py-3 text-center">Sisa Sesi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $quotaEmpty = $student->quota_left <= 0;
                                        ?>
                                        <tr
                                            class="bg-white border-b hover:bg-gray-50 transition-colors duration-150 <?php echo e($quotaEmpty ? 'bg-red-50/30' : ''); ?>">
                                            
                                            <td class="px-6 py-4 text-center">
                                                <input type="checkbox" name="student_ids[]" value="<?php echo e($student->id); ?>"
                                                    id="student-<?php echo e($student->id); ?>"
                                                    class="student-checkbox w-5 h-5 rounded text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-opacity-50 transition cursor-pointer">
                                            </td>

                                            
                                            <td class="px-6 py-4 font-semibold text-gray-900">
                                                <label for="student-<?php echo e($student->id); ?>" class="cursor-pointer block">
                                                    <?php echo e($student->name); ?>

                                                    <span class="text-xs text-gray-400 font-normal block mt-0.5">
                                                        <?php echo e($student->gender === 'L' ? 'Laki-laki' : 'Perempuan'); ?>

                                                    </span>
                                                </label>
                                            </td>

                                            
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-gray-800">
                                                    <?php echo e($student->package->name ?? 'Tidak Ada Paket'); ?>

                                                </span>
                                                <span class="text-xs text-gray-400 block">Total:
                                                    <?php echo e($student->package->sessions ?? 0); ?> Sesi</span>
                                            </td>

                                            
                                            <td class="px-6 py-4 font-medium text-gray-700">
                                                <span
                                                    class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <?php echo e($student->location->name ?? 'Belum Dipilih'); ?>

                                                </span>
                                            </td>

                                            
                                            <td class="px-6 py-4 text-center">
                                                <?php if($quotaEmpty): ?>
                                                    <span
                                                        class="bg-red-100 text-red-800 border border-red-300 text-xs px-2.5 py-1 rounded-full font-bold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-circle-exclamation"></i> Kuota Habis (0
                                                        Sesi)
                                                    </span>
                                                <?php else: ?>
                                                    <span
                                                        class="text-blue-600 font-bold text-sm bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                                                        <?php echo e($student->quota_left); ?> Sesi
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="flex justify-end gap-3">
                            <a href="<?php echo e(route('coach.students.index')); ?>"
                                class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 border rounded-lg font-medium transition-all text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-bold shadow-md transition-all text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Absensi
                            </button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>
        </div>
    </div>

    
    <?php if($students->isNotEmpty()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnSelectAll = document.getElementById('btn-select-all');
                const btnSelectText = document.getElementById('btn-select-text');
                const checkboxes = document.querySelectorAll('.student-checkbox');
                let allChecked = false;

                btnSelectAll.addEventListener('click', function() {
                    allChecked = !allChecked;
                    checkboxes.forEach(cb => {
                        cb.checked = allChecked;
                    });

                    if (allChecked) {
                        btnSelectText.textContent = "Batalkan Semua Pilihan";
                        btnSelectAll.classList.replace('bg-blue-50', 'bg-red-50');
                        btnSelectAll.classList.replace('text-blue-600', 'text-red-600');
                        btnSelectAll.classList.replace('hover:bg-blue-100', 'hover:bg-red-100');
                    } else {
                        btnSelectText.textContent = "Pilih Semua Murid";
                        btnSelectAll.classList.replace('bg-red-50', 'bg-blue-50');
                        btnSelectAll.classList.replace('text-red-600', 'text-blue-600');
                        btnSelectAll.classList.replace('hover:bg-red-100', 'hover:bg-blue-100');
                    }
                });
            });
        </script>
    <?php endif; ?>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/attendances/create.blade.php ENDPATH**/ ?>