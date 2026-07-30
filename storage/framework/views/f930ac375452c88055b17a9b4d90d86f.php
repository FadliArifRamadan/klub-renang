<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Coach - Input Absensi Kelas Belajar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Input Absensi Murid (Kelas Belajar)')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="<?php echo e(route('coach.attendances.belajar.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border-b pb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-calendar text-gray-400 mr-1.5"></i>Tanggal Latihan
                            </label>
                            <div class="relative">
                                <input type="date" name="date" id="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                                    max="<?php echo e(date('Y-m-d')); ?>"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 pr-10 cursor-pointer"
                                    required>
                                <button type="button" onclick="document.getElementById('date').showPicker()"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-calendar-days text-lg"></i>
                                </button>
                            </div>
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
                            <p class="font-medium text-gray-600">Belum ada murid aktif yang ditugaskan ke Anda di kelas belajar.</p>
                            <p class="text-xs mt-1">Hanya murid dengan status "Aktif" yang dapat diabsen.</p>
                        </div>
                    <?php else: ?>
                        <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-center w-12">No</th>
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
                                            $scheduleDays = $student->schedules
                                                ->filter(function($s) use ($coachIds) {
                                                    return in_array($s->coach_id, $coachIds);
                                                })
                                                ->pluck('day_of_week')
                                                ->unique()
                                                ->values()
                                                ->toArray();
                                        ?>
                                        <tr data-schedule-days="<?php echo e(json_encode($scheduleDays)); ?>"
                                            class="student-row bg-white border-b hover:bg-gray-50 transition-colors duration-150 <?php echo e($quotaEmpty ? 'bg-red-50/30' : ''); ?>">
                                            <td class="px-4 py-4 text-center"><?php echo e($loop->iteration); ?></td>
                                            
                                            <td class="px-6 py-4 text-center">
                                                <input type="checkbox" name="student_ids[]" value="<?php echo e($student->id); ?>"
                                                    id="student-<?php echo e($student->id); ?>"
                                                    class="student-checkbox w-5 h-5 rounded text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-opacity-50 transition cursor-pointer"
                                                    <?php echo e($quotaEmpty ? 'disabled' : ''); ?>>
                                            </td>

                                            
                                            <td class="px-6 py-4 font-semibold text-gray-900">
                                                <label for="student-<?php echo e($student->id); ?>" class="cursor-pointer block">
                                                    <?php echo e($student->name); ?>

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
                                                        <i class="fa-solid fa-circle-exclamation"></i> Kuota Habis
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-blue-600 font-bold text-sm bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                                                        <?php echo e($student->quota_left); ?> Total
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="empty-state-row" style="display: none;">
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 dark:text-slate-300 bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                                            <i class="fa-solid fa-calendar-xmark text-4xl mb-3 text-slate-400 dark:text-slate-500"></i>
                                            <p class="font-bold text-sm text-slate-700 dark:text-slate-200">Tidak ada jadwal murid pada tanggal ini.</p>
                                            <p class="text-xs mt-1 text-slate-500 dark:text-slate-400">Silakan pilih tanggal yang lain.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="flex justify-end gap-3 mt-6">
                            <a href="<?php echo e(route('coach.attendances.belajar.index')); ?>"
                                class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white border border-slate-600 rounded-lg font-bold transition-all text-sm flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] rounded-lg font-extrabold shadow-md transition-all text-sm flex items-center gap-1.5 cursor-pointer">
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
                    const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                        return cb.closest('.student-row').style.display !== 'none' && !cb.disabled;
                    });
                    
                    visibleCheckboxes.forEach(cb => {
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

                const dateInput = document.getElementById('date');
                const studentRows = document.querySelectorAll('.student-row');

                function getPhpDayOfWeek(dateString) {
                    const parts = dateString.split('-');
                    const date = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    if (isNaN(date.getTime())) return -1;
                    const jsDay = date.getDay();
                    return jsDay === 0 ? 6 : jsDay - 1;
                }

                function filterStudents() {
                    const selectedDate = dateInput.value;
                    const selectedDow = getPhpDayOfWeek(selectedDate);
                    
                    studentRows.forEach(row => {
                        const scheduleDays = JSON.parse(row.dataset.scheduleDays || '[]');
                        const cb = row.querySelector('.student-checkbox');
                        const isMatch = selectedDow >= 0 && scheduleDays.includes(selectedDow);
                        
                        if (isMatch) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                            if (cb) {
                                cb.checked = false;
                            }
                        }
                    });

                    const emptyStateRow = document.getElementById('empty-state-row');
                    const visibleRows = Array.from(studentRows).filter(r => r.style.display !== 'none' && !r.id);
                    if (visibleRows.length === 0) {
                        if(emptyStateRow) emptyStateRow.style.display = '';
                    } else {
                        if(emptyStateRow) emptyStateRow.style.display = 'none';
                    }

                    allChecked = false;
                    btnSelectText.textContent = "Pilih Semua Murid";
                    btnSelectAll.classList.replace('bg-red-50', 'bg-blue-50');
                    btnSelectAll.classList.replace('text-red-600', 'text-blue-600');
                    btnSelectAll.classList.replace('hover:bg-red-100', 'hover:bg-blue-100');
                }

                dateInput.addEventListener('change', filterStudents);
                
                // Initial filter on page load
                filterStudents();
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/attendances/belajar/create.blade.php ENDPATH**/ ?>