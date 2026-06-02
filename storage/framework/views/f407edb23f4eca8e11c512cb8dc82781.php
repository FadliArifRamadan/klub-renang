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
            <?php echo e(__('Catat & Pantau Perkembangan')); ?>

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
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                
                <div class="lg:col-span-5">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-blue-600"></i>
                            Input Nilai Fisik Murid
                        </h3>

                        <form action="<?php echo e(route('coach.progress.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            
                            <div class="mb-4">
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Pilih Murid *
                                </label>
                                <select name="student_id" id="student_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                    required>
                                    <option value="" disabled selected>-- Pilih Murid Latihan --</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>"
                                            <?php echo e(old('student_id') == $student->id ? 'selected' : ''); ?>>
                                            <?php echo e($student->name); ?> (<?php echo e($student->location->name ?? 'Kolam Latihan'); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['student_id'];
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

                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Tanggal Tes *
                                    </label>
                                    <input type="date" name="date" id="date"
                                        value="<?php echo e(old('date', date('Y-m-d'))); ?>" max="<?php echo e(date('Y-m-d')); ?>"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 text-sm"
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
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Nama Coach
                                    </label>
                                    <input type="text" value="<?php echo e(Auth::user()->name); ?>"
                                        class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 text-sm cursor-not-allowed"
                                        readonly>
                                </div>
                            </div>

                            <hr class="my-6 border-gray-150">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Indikator Fisik
                                Murid (1 - 100)</p>

                            
                            <?php
                                $indicators = [
                                    [
                                        'name' => 'strength',
                                        'label' => 'Strength (Kekuatan)',
                                        'icon' => 'fa-dumbbell',
                                        'color' => 'text-blue-600',
                                        'bg' => 'accent-blue-600',
                                    ],
                                    [
                                        'name' => 'endurance',
                                        'label' => 'Endurance / VO2Max',
                                        'icon' => 'fa-heart-pulse',
                                        'color' => 'text-emerald-600',
                                        'bg' => 'accent-emerald-600',
                                    ],
                                    [
                                        'name' => 'flexibility',
                                        'label' => 'Flexibility (Kelenturan)',
                                        'icon' => 'fa-child-reaching',
                                        'color' => 'text-purple-600',
                                        'bg' => 'accent-purple-600',
                                    ],
                                    [
                                        'name' => 'speed',
                                        'label' => 'Speed (Kecepatan)',
                                        'icon' => 'fa-gauge-high',
                                        'color' => 'text-red-600',
                                        'bg' => 'accent-red-600',
                                    ],
                                    [
                                        'name' => 'agility',
                                        'label' => 'Agility (Kelincahan)',
                                        'icon' => 'fa-bolt-lightning',
                                        'color' => 'text-amber-500',
                                        'bg' => 'accent-amber-500',
                                    ],
                                ];
                            ?>

                            <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-5">
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                            <i class="fa-solid <?php echo e($ind['icon']); ?> <?php echo e($ind['color']); ?> w-4"></i>
                                            <?php echo e($ind['label']); ?>

                                        </span>
                                        <span id="val-<?php echo e($ind['name']); ?>"
                                            class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-0.5 rounded shadow-sm border">
                                            <?php echo e(old($ind['name'], 50)); ?>

                                        </span>
                                    </div>
                                    <input type="range" name="<?php echo e($ind['name']); ?>" id="range-<?php echo e($ind['name']); ?>"
                                        min="1" max="100" value="<?php echo e(old($ind['name'], 50)); ?>"
                                        class="w-full h-2 bg-gray-200 rounded-lg cursor-pointer transition-all duration-150 <?php echo e($ind['bg']); ?>"
                                        oninput="document.getElementById('val-<?php echo e($ind['name']); ?>').innerText = this.value">
                                    <?php $__errorArgs = [$ind['name']];
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <div class="mb-6 mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Catatan Perkembangan (Opsional)
                                </label>
                                <textarea name="notes" id="notes" rows="3" placeholder="Tulis catatan penting tentang latihan hari ini..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 text-sm"><?php echo e(old('notes')); ?></textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-150 text-sm flex justify-center items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Perkembangan
                            </button>
                        </form>
                    </div>
                </div>

                
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 flex-1 flex flex-col">

                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-chart-line text-blue-600"></i>
                                Grafik Perkembangan Fisik
                            </h3>

                            
                            <div class="w-full sm:w-64">
                                <select id="chart_student_id"
                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50">
                                    <option value="" disabled selected>-- Pilih Murid Grafik --</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>">
                                            <?php echo e($student->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        
                        <div id="chart-empty-state"
                            class="flex-1 flex flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown di atas</p>
                            <p class="text-xs mt-1">Grafik perkembangan akan dirender setelah murid dipilih.</p>
                        </div>

                        
                        <div id="chart-no-data-state"
                            class="hidden flex-1 flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Belum ada riwayat perkembangan murid ini</p>
                            <p class="text-xs mt-1">Gunakan form di sebelah kiri untuk menginput data perkembangan
                                pertama.</p>
                        </div>

                        
                        <div id="chart-container" class="hidden flex-1 flex-col">
                            
                            <div class="relative w-full h-[320px] mb-6">
                                <canvas id="progressChart"></canvas>
                            </div>

                            
                            <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-4 mt-auto">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Coach
                                </h4>
                                <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada
                                    evaluasi terakhir."</p>
                                <div id="latest-note-date" class="text-[10px] text-gray-400 mt-1 font-semibold">Diinput
                                    pada: -</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data murid & perkembangan dari Laravel yang dijadikan object JS
            const studentsMap = <?php echo json_encode($students->keyBy('id'), 15, 512) ?>;

            const selectDropdown = document.getElementById('chart_student_id');
            const emptyState = document.getElementById('chart-empty-state');
            const noDataState = document.getElementById('chart-no-data-state');
            const chartContainer = document.getElementById('chart-container');
            const latestNoteText = document.getElementById('latest-note');
            const latestNoteDate = document.getElementById('latest-note-date');

            let myChart = null;

            // Handler perubahan dropdown murid di grafik
            selectDropdown.addEventListener('change', function() {
                const studentId = this.value;
                const student = studentsMap[studentId];

                if (!student) return;

                const reports = student.progress_reports || [];

                if (reports.length === 0) {
                    // Tampilkan state tidak ada data
                    emptyState.classList.add('hidden');
                    chartContainer.classList.add('hidden');
                    chartContainer.classList.remove('flex');
                    noDataState.classList.remove('hidden');
                    noDataState.classList.add('flex');
                    return;
                }

                // Sembunyikan state kosong, tampilkan grafik
                emptyState.classList.add('hidden');
                noDataState.classList.add('hidden');
                noDataState.classList.remove('flex');
                chartContainer.classList.remove('hidden');
                chartContainer.classList.add('flex');

                // Siapkan data untuk render chart
                const labels = [];
                const strengthData = [];
                const enduranceData = [];
                const flexibilityData = [];
                const speedData = [];
                const agilityData = [];

                reports.forEach(report => {
                    // Format tanggal (DD-MM-YYYY)
                    const d = new Date(report.date);
                    const formattedDate = d.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: '2-digit'
                    });

                    labels.push(formattedDate);
                    strengthData.push(report.strength);
                    enduranceData.push(report.endurance);
                    flexibilityData.push(report.flexibility);
                    speedData.push(report.speed);
                    agilityData.push(report.agility);
                });

                // Update catatan terakhir coach
                const latestReport = reports[reports.length - 1];
                if (latestReport.notes) {
                    latestNoteText.textContent = `"${latestReport.notes}"`;
                } else {
                    latestNoteText.textContent = `"Tidak ada catatan pada evaluasi terakhir."`;
                }
                const d = new Date(latestReport.date);
                latestNoteDate.textContent =
                    `Diinput pada: ${d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`;

                // Hancurkan chart lama jika ada agar tidak tumpang tindih
                if (myChart) {
                    myChart.destroy();
                }

                // Render Chart.js baru
                const ctx = document.getElementById('progressChart').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Strength',
                                data: strengthData,
                                borderColor: 'rgb(37, 99, 235)', // Blue
                                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Endurance',
                                data: enduranceData,
                                borderColor: 'rgb(16, 185, 129)', // Emerald
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Flexibility',
                                data: flexibilityData,
                                borderColor: 'rgb(147, 51, 234)', // Purple
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Speed',
                                data: speedData,
                                borderColor: 'rgb(239, 68, 68)', // Red
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Agility',
                                data: agilityData,
                                borderColor: 'rgb(245, 158, 11)', // Amber
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 15,
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                padding: 10,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            y: {
                                min: 0,
                                max: 100,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                title: {
                                    display: true,
                                    text: 'Skor Perkembangan',
                                    font: {
                                        weight: '600'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            });

            // Auto select murid pertama di dropdown grafik jika ada & form baru saja disubmit
            <?php if(old('student_id')): ?>
                selectDropdown.value = "<?php echo e(old('student_id')); ?>";
                selectDropdown.dispatchEvent(new Event('change'));
            <?php elseif($students->isNotEmpty()): ?>
                // Pilih murid pertama
                selectDropdown.value = "<?php echo e($students->first()->id); ?>";
                selectDropdown.dispatchEvent(new Event('change'));
            <?php endif; ?>
        });
    </script>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/progress/index.blade.php ENDPATH**/ ?>