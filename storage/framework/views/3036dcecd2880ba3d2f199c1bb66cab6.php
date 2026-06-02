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
            <?php echo e(__('Dashboard Coach')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Halo, Coach <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di portal pelatih Black Diamond. Pantau perkembangan latihan murid Anda,
                    catat kemajuan fisik mereka, dan kelola kehadiran secara berkala.
                </p>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalStudents); ?> Murid</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalCoaches); ?> Pelatih</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalLocations); ?> Lokasi</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 flex flex-col">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-blue-600"></i>
                            Grafik Catatan Perkembangan Murid Bimbingan
                        </h3>
                        <p class="text-xs text-gray-500">Pilih murid bimbingan Anda untuk memantau performa latihan dan
                            indikator fisiknya.</p>
                    </div>

                    
                    <?php if($students->isNotEmpty()): ?>
                        <div class="w-full sm:w-72">
                            <select id="chart_student_id"
                                class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                                <option value="" disabled selected>-- Pilih Murid --</option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>">
                                        <?php echo e($student->name); ?> (<?php echo e($student->package->name ?? 'Tanpa Paket'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($students->isEmpty()): ?>
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-address-book text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada murid bimbingan ditugaskan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Anda belum memiliki murid bimbingan yang aktif
                            saat ini.</p>
                    </div>
                <?php else: ?>
                    
                    <div id="chart-empty-state"
                        class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown untuk menampilkan grafik
                        </p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                            kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan murid.</p>
                    </div>

                    
                    <div id="chart-no-data-state"
                        class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk murid ini</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Silakan input data
                            perkembangan fisik pertama murid ini pada menu Catat Perkembangan.</p>
                    </div>

                    
                    <div id="chart-container" class="hidden flex-1 flex-col">
                        
                        <div class="relative w-full h-[360px] mb-6">
                            <canvas id="progressChart"></canvas>
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                            <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                </h4>
                                <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada
                                    evaluasi
                                    terakhir."</p>
                                <div id="latest-note-date" class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput
                                    pada: -</div>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                <h4
                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Info Latihan Murid
                                </h4>
                                <div class="space-y-1.5 text-xs text-gray-600">
                                    <div>Pelatih: <span id="student-coach" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Lokasi: <span id="student-location" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Sisa Kuota: <span id="student-quota" class="font-bold text-blue-600">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php if($students->isNotEmpty()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data murid & perkembangan dari Laravel dijadikan object JS
                const studentsArray = <?php echo json_encode($students, 15, 512) ?>;
                const studentsMap = {};
                studentsArray.forEach(function(s) {
                    studentsMap[String(s.id)] = s;
                });

                const selectDropdown = document.getElementById('chart_student_id');
                const emptyState = document.getElementById('chart-empty-state');
                const noDataState = document.getElementById('chart-no-data-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');

                let myChart = null;

                selectDropdown.addEventListener('change', function() {
                    const studentId = String(this.value);
                    const student = studentsMap[studentId];

                    if (!student) return;

                    const reports = student.progress_reports || [];

                    if (reports.length === 0) {
                        emptyState.classList.add('hidden');

                        // Sembunyikan chart container + reset inline style agar class hidden bekerja
                        chartContainer.classList.add('hidden');
                        chartContainer.style.display = '';

                        // Hancurkan chart lama agar canvas tidak muncul di balik no-data state
                        if (myChart) {
                            myChart.destroy();
                            myChart = null;
                        }

                        noDataState.classList.remove('hidden');
                        noDataState.style.display = 'flex';

                        document.getElementById('no-data-subtext').textContent =
                            `Silakan input data perkembangan fisik pertama murid ini pada menu Catat Perkembangan.`;
                        return;
                    }

                    // Tampilkan grafik
                    emptyState.classList.add('hidden');
                    noDataState.classList.add('hidden');
                    noDataState.style.display = '';
                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Siapkan data
                    const labels = [];
                    const strengthData = [];
                    const enduranceData = [];
                    const flexibilityData = [];
                    const speedData = [];
                    const agilityData = [];

                    reports.forEach(report => {
                        const d = new Date(report.date);
                        labels.push(d.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: '2-digit'
                        }));
                        strengthData.push(report.strength);
                        enduranceData.push(report.endurance);
                        flexibilityData.push(report.flexibility);
                        speedData.push(report.speed);
                        agilityData.push(report.agility);
                    });

                    // Update catatan terakhir
                    const latestReport = reports[reports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;

                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`;

                    // Info murid
                    document.getElementById('student-coach').textContent = student.coach ? student.coach.name :
                        'Belum Ditugaskan';
                    document.getElementById('student-location').textContent = student.location ? student
                        .location.name : 'Belum Dipilih';
                    document.getElementById('student-quota').textContent = `${student.quota_left} sesi`;

                    // Hancurkan chart lama
                    if (myChart) {
                        myChart.destroy();
                    }

                    // Render Chart.js
                    const ctx = document.getElementById('progressChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Strength',
                                    data: strengthData,
                                    borderColor: 'rgb(37, 99, 235)',
                                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Endurance',
                                    data: enduranceData,
                                    borderColor: 'rgb(16, 185, 129)',
                                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Flexibility',
                                    data: flexibilityData,
                                    borderColor: 'rgb(147, 51, 234)',
                                    backgroundColor: 'rgba(147, 51, 234, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Speed',
                                    data: speedData,
                                    borderColor: 'rgb(239, 68, 68)',
                                    backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Agility',
                                    data: agilityData,
                                    borderColor: 'rgb(245, 158, 11)',
                                    backgroundColor: 'rgba(245, 158, 11, 0.05)',
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
                                        color: 'rgba(0,0,0,0.05)'
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

                // Auto-select murid pertama jika ada
                <?php if($students->isNotEmpty()): ?>
                    selectDropdown.value = "<?php echo e($students->first()->id); ?>";
                    selectDropdown.dispatchEvent(new Event('change'));
                <?php endif; ?>
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/dashboard.blade.php ENDPATH**/ ?>