<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Admin - Dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard Admin')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Dashboard, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di panel kontrol Black Diamond. Kelola verifikasi pembayaran, data murid, pelatih,
                    kolam
                    latihan, dan paket program secara terpusat dan efisien.
                </p>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Card 1: Total Murid -->
                <a href="<?php echo e(route('admin.students.index')); ?>"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalStudents); ?> Murid</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 2: Total Coach -->
                <a href="<?php echo e(route('admin.users.index', ['role' => 'coach'])); ?>"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-100 transition-colors">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalCoaches); ?> Pelatih</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-emerald-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 3: Total Tempat Latihan -->
                <a href="<?php echo e(route('admin.locations.index')); ?>"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-100 transition-colors">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalLocations); ?> Lokasi</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-amber-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 4: Pending Payments -->
                <a href="<?php echo e(route('admin.payments.index')); ?>"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-100 transition-colors <?php echo e($pendingPayments > 0 ? 'animate-pulse' : ''); ?>">
                            <i class="fa-solid fa-wallet text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Verifikasi Bayar</p>
                            <div class="flex items-center gap-1.5">
                                <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($pendingPayments); ?> Pending</p>
                                <?php if($pendingPayments > 0): ?>
                                    <span
                                        class="inline-flex items-center bg-rose-100 text-rose-850 text-[9px] font-bold px-1.5 py-0.5 rounded-full border border-rose-200">
                                        Perlu Aksi
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 5: Pending Schedule Requests -->
                <?php
                    $pendingScheds = \App\Models\ScheduleChangeRequest::where('status', 'pending')->count();
                ?>
                <a href="<?php echo e(route('admin.schedule-requests.index')); ?>"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-100 transition-colors <?php echo e($pendingScheds > 0 ? 'animate-pulse' : ''); ?>">
                            <i class="fa-solid fa-calendar-check text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengajuan Jadwal</p>
                            <div class="flex items-center gap-1.5">
                                <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($pendingScheds); ?> Pending</p>
                                <?php if($pendingScheds > 0): ?>
                                    <span
                                        class="inline-flex items-center bg-indigo-100 text-indigo-850 text-[9px] font-bold px-1.5 py-0.5 rounded-full border border-indigo-200">
                                        Perlu Aksi
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-indigo-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>
            </div>


            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 flex flex-col">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-blue-600"></i>
                            Grafik Perkembangan Fisik Murid
                        </h3>
                        <p class="text-xs text-gray-500">Pilih murid di samping untuk memantau performa latihan dan
                            indikator fisiknya.</p>
                    </div>

                    
                    <div class="w-full sm:w-72">
                        <select id="chart_student_id"
                            class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                            <option value="" disabled selected>-- Pilih Murid Kursus --</option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>">
                                    <?php echo e($student->name); ?> (<?php echo e($student->package->name ?? 'Tanpa Paket'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <div id="chart-empty-state"
                    class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                    <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                    <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown untuk menampilkan grafik</p>
                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                        kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan murid.</p>
                </div>

                
                <div id="chart-no-data-state"
                    class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                    <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                    <p class="font-medium text-gray-600">Belum ada riwayat perkembangan murid ini</p>
                    <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping untuk
                        menginput data perkembangan fisik pertama.</p>
                </div>

                
                <div id="chart-container" class="hidden flex-1 flex-col">
                        
                        <div id="prestasi-charts-container" class="hidden flex-col space-y-8 w-full mt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Kondisi Fisik</h4>
                                    <div class="relative w-full h-[250px]">
                                        <canvas id="radarChart"></canvas>
                                    </div>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Sistem Energi</h4>
                                    <div class="relative w-full h-[250px]">
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Personal Best Time</h4>
                                <div class="relative w-full h-[300px]">
                                    <canvas id="lineChartPBT"></canvas>
                                </div>
                            </div>
                        </div>

                        
                        <div id="freetext-container" class="hidden overflow-y-auto max-h-[400px] mt-4 space-y-4 pr-1 mb-6">
                            
                        </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                        <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                            <h4
                                class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                            </h4>
                            <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada evaluasi
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
                                <div>Pelatih: <span id="student-coach" class="font-bold text-gray-800">-</span></div>
                                <div>Lokasi: <span id="student-location" class="font-bold text-gray-800">-</span></div>
                                <div>Sisa Kuota: <span id="student-quota" class="font-bold text-blue-600">-</span></div>
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
            let radarChartInst = null;
            let barChartInst = null;
            let lineChartPBTInst = null;

            // Handler perubahan dropdown murid di grafik
            selectDropdown.addEventListener('change', function() {
                const studentId = String(this.value);
                const student = studentsMap[studentId];

                if (!student) return;

                const reports = student.progress_reports || [];

                if (reports.length === 0) {
                    // Tampilkan state tidak ada data
                    emptyState.classList.add('hidden');
                    chartContainer.classList.add('hidden');
                    noDataState.classList.remove('hidden');

                    // Update subtext pelatih
                    const coachName = student.coach ? student.coach.name : 'Belum Ditugaskan';
                    document.getElementById('no-data-subtext').textContent =
                        `Hubungi Coach pendamping (${coachName}) untuk menginput data perkembangan fisik pertama.`;
                    return;
                }

                // Sembunyikan state kosong, tampilkan grafik
                emptyState.classList.add('hidden');
                noDataState.classList.add('hidden');
                chartContainer.classList.remove('hidden');

                                    // Update catatan terakhir
                    const latestReport = reports[reports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;
                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}`;

                                        const freetextContainer = document.getElementById('freetext-container');
                    const prestasiContainer = document.getElementById('prestasi-charts-container');

                    // Hancurkan chart lama jika ada
                    if (radarChartInst) radarChartInst.destroy();
                    if (barChartInst) barChartInst.destroy();
                    if (lineChartPBTInst) lineChartPBTInst.destroy();

                    // Cek apakah data ini adalah kelas Prestasi (memiliki Kondisi Fisik)
                    // Kita cek dari report terakhir
                    const isPrestasi = latestReport && latestReport.metrics && ('Kondisi Fisik' in latestReport.metrics);

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        // --- 1. Siapkan Data ---
                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };
                        const pbtData = { TestPerBulan: [], PbtEvent: [] };

                        // Fungsi helper ubah "01:25.50" jadi detik "85.5"
                        function parseTimeToSeconds(timeStr) {
                            if (!timeStr) return null;
                            const match = timeStr.toString().match(/(?:(\d+):)?(\d+)[.,:](\d+)/);
                            if (match) {
                                const m = parseInt(match[1] || 0);
                                const s = parseInt(match[2] || 0);
                                const ms = parseInt(match[3] || 0);
                                // ms bisa 2 digit (50 = 500ms)
                                const msVal = ms < 100 ? ms * 10 : ms; 
                                return m * 60 + s + (msVal / 1000);
                            }
                            return null;
                        }

                        // Fungsi format balik dari detik ke "MM:SS.ms"
                        function formatSecondsToTime(totalSeconds) {
                            if (totalSeconds == null) return "-";
                            const m = Math.floor(totalSeconds / 60);
                            const s = Math.floor(totalSeconds % 60);
                            const ms = Math.round((totalSeconds - Math.floor(totalSeconds)) * 100);
                            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(2, '0')}`;
                        }

                        reports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short', year: '2-digit' }));

                            if (report.metrics) {
                                // Radar (Kondisi Fisik)
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                // Bar (Sistem Energi)
                                const se = report.metrics['Sistem Energi'] || {};
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);

                                // Line (Personal Best Time)
                                const pbt = report.metrics['Personal Best Time'] || {};
                                pbtData.TestPerBulan.push(parseTimeToSeconds(pbt['Test per Bulan']));
                                pbtData.PbtEvent.push({
                                    val: parseTimeToSeconds(pbt['PBT Event']),
                                    raw: pbt['PBT Event'] // Simpan teks aslinya (misal ada tambahan "Kejurda")
                                });
                            }
                        });

                        // Ambil 2 bulan terakhir untuk komparasi Radar
                        const len = labels.length;
                        const latestLabels = ['Endurance', 'Fleksibilitas', 'Strength', 'Speed', 'Agility'];
                        const latestData = len > 0 ? [
                            radarData.Endurance[len-1], radarData.Fleksibilitas[len-1], 
                            radarData.Strength[len-1], radarData.Speed[len-1], radarData.Agility[len-1]
                        ] : [];
                        const prevData = len > 1 ? [
                            radarData.Endurance[len-2], radarData.Fleksibilitas[len-2], 
                            radarData.Strength[len-2], radarData.Speed[len-2], radarData.Agility[len-2]
                        ] : [];

                        // --- 2. Render Radar Chart (Kondisi Fisik) ---
                        const ctxRadar = document.getElementById('radarChart').getContext('2d');
                        const radarDatasets = [{
                            label: labels[len-1] || 'Bulan Ini',
                            data: latestData,
                            backgroundColor: 'rgba(37, 99, 235, 0.2)',
                            borderColor: 'rgb(37, 99, 235)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(37, 99, 235)'
                        }];
                        if (len > 1) {
                            radarDatasets.push({
                                label: labels[len-2] || 'Bulan Lalu',
                                data: prevData,
                                backgroundColor: 'rgba(156, 163, 175, 0.2)',
                                borderColor: 'rgb(156, 163, 175)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgb(156, 163, 175)'
                            });
                        }
                        radarChartInst = new Chart(ctxRadar, {
                            type: 'radar',
                            data: { labels: latestLabels, datasets: radarDatasets },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: { r: { min: 0, max: 100 } },
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });

                        // --- 3. Render Bar Chart (Sistem Energi) ---
                        const ctxBar = document.getElementById('barChart').getContext('2d');
                        barChartInst = new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    { label: 'Aerobic', data: barData.Aerobic, backgroundColor: 'rgba(16, 185, 129, 0.7)' },
                                    { label: 'Anaerobic', data: barData.Anaerobic, backgroundColor: 'rgba(239, 68, 68, 0.7)' }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom' } },
                                scales: { y: { beginAtZero: true, max: 100 } }
                            }
                        });

                        // --- 4. Render Line Chart (Personal Best Time) ---
                        const ctxLine = document.getElementById('lineChartPBT').getContext('2d');
                        
                        // Menyiapkan dataset
                        const pbtDatasets = [
                            {
                                label: 'Test per Bulan',
                                data: pbtData.TestPerBulan,
                                borderColor: 'rgb(147, 51, 234)',
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'PBT Event',
                                data: pbtData.PbtEvent.map(e => e.val), // Hanya nilainya
                                type: 'scatter',
                                pointBackgroundColor: 'rgb(245, 158, 11)',
                                pointBorderColor: 'rgb(255, 255, 255)',
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }
                        ];

                        lineChartPBTInst = new Chart(ctxLine, {
                            type: 'line',
                            data: { labels: labels, datasets: pbtDatasets },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom' },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                if (context.dataset.label === 'PBT Event') {
                                                    const rawText = pbtData.PbtEvent[context.dataIndex].raw;
                                                    return `Event: ${rawText || formatSecondsToTime(context.raw)}`;
                                                }
                                                return `Test: ${formatSecondsToTime(context.raw)}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        reverse: true, // Waktu tercepat (terkecil) ada di ATAS!
                                        ticks: {
                                            callback: function(value) { return formatSecondsToTime(value); }
                                        },
                                        title: { display: true, text: 'Waktu (MM:SS.ms)' }
                                    }
                                }
                            }
                        });

                    } else {
                        // KELAS BELAJAR (TIMELINE TEXT)
                        if (prestasiContainer) prestasiContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.style.display = 'none';

                        if (freetextContainer) {
                            freetextContainer.classList.remove('hidden');
                            freetextContainer.innerHTML = '';

                            const sortedReports = [...reports].reverse();
                            sortedReports.forEach(report => {
                                const d = new Date(report.date);
                                const dateStr = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                                
                                let metricsHtml = '';
                                if (report.metrics) {
                                    for (const [category, items] of Object.entries(report.metrics)) {
                                        metricsHtml += `<div class="mb-3"><h5 class="text-sm font-bold text-slate-800 border-b pb-1 mb-2">${category}</h5><div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                        for (const [key, val] of Object.entries(items)) {
                                            let badgeColor = 'bg-slate-100 text-slate-700';
                                            if (val === 'Sangat Mahir' || val === 'Lulus Tahap Ini' || val === 'Sudah Lancar') badgeColor = 'bg-green-100 text-green-700';
                                            else if (val === 'Berkembang Baik' || val === 'Mulai Bisa') badgeColor = 'bg-blue-100 text-blue-700';
                                            else if (val === 'Mulai Terlihat') badgeColor = 'bg-amber-100 text-amber-700';
                                            else if (val === 'Belum Berkembang' || val === 'Belum Bisa' || val === 'Belum Memulai') badgeColor = 'bg-red-100 text-red-700';

                                            metricsHtml += `<div class="text-xs flex justify-between items-center p-2 bg-slate-50 rounded border border-slate-100">
                                                <span class="font-medium text-slate-600">${key}</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold ${badgeColor}">${val}</span>
                                            </div>`;
                                        }
                                        metricsHtml += `</div></div>`;
                                    }
                                }

                                const item = document.createElement('div');
                                item.className = 'relative pl-6 pb-6 border-l-2 border-indigo-100 last:pb-0 last:border-l-0';
                                item.innerHTML = `
                                    <span class="absolute -left-[7px] top-1.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-indigo-500 ring-4 ring-white"></span>
                                    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-sm font-bold text-indigo-700">
                                                <i class="fa-regular fa-calendar-days mr-1"></i> Bulan: ${dateStr}
                                            </span>
                                        </div>
                                        <div class="mb-4">
                                            ${metricsHtml}
                                        </div>
                                        ${report.notes ? `
                                        <div class="bg-indigo-50 border border-indigo-100 p-3 rounded-md">
                                            <p class="text-xs font-bold text-indigo-800 mb-1"><i class="fa-solid fa-comment-dots"></i> Catatan Pelatih:</p>
                                            <p class="text-sm text-slate-700 italic">${report.notes}</p>
                                        </div>` : ''}
                                    </div>
                                `;
                                freetextContainer.appendChild(item);
                            });
                        }
                    }
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>