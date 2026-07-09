<x-app-layout title="Coach - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Coach') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Panel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Halo, Coach {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di portal pelatih Black Diamond. Pantau perkembangan latihan murid Anda,
                    catat kemajuan fisik mereka, dan kelola kehadiran secara berkala.
                </p>
            </div>

            {{-- Metrics Grid (Non-Clickable untuk Coach) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Card 1: Total Murid (Non-clickable) --}}
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalStudents }} Murid</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                {{-- Card 2: Total Coach (Non-clickable) --}}
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalCoaches }} Pelatih</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                {{-- Card 3: Total Tempat Latihan (Non-clickable) --}}
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalLocations }} Lokasi</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>
            </div>

            {{-- Progress Chart Section --}}
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

                    {{-- Dropdown Pilih Murid --}}
                    @if ($students->isNotEmpty())
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <div class="w-full sm:w-72">
                                <select id="chart_student_id"
                                    class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                                    <option value="" disabled selected>-- Pilih Murid --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }} ({{ $student->package->name ?? 'Tanpa Paket' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full sm:w-40">
                                <select id="chart_year_filter"
                                    class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5"
                                    disabled>
                                    <option value="" disabled selected>-- Tahun --</option>
                                </select>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- State: Tidak ada murid bimbingan --}}
                @if ($students->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-address-book text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada murid bimbingan ditugaskan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Anda belum memiliki murid bimbingan yang aktif
                            saat ini.</p>
                    </div>
                @else
                    {{-- Empty State (Belum ada murid dipilih) --}}
                    <div id="chart-empty-state"
                        class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown untuk menampilkan grafik
                        </p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                            kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan murid.</p>
                    </div>

                    {{-- State: Data kosong untuk murid terpilih --}}
                    <div id="chart-no-data-state"
                        class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk murid ini</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Silakan input data
                            perkembangan fisik pertama murid ini pada menu Catat Perkembangan.</p>
                    </div>

                    <div id="chart-year-empty-state"
                        class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-regular fa-calendar-xmark text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600" id="year-empty-title">Belum ada data latihan di tahun ini</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm" id="year-empty-subtext">Pilih tahun lain atau tunggu hingga Coach menginput data perkembangan.</p>
                    </div>

                    {{-- Container Grafik & Detail Perkembangan --}}
                    <div id="chart-container" class="hidden flex-1 flex-col">
                        {{-- Container Prestasi (3 Grafik) --}}
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
                                 <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-2">
                                     <h4 class="text-sm font-bold text-slate-700 flex items-center gap-1"><i class="fa-solid fa-stopwatch text-indigo-500"></i> Personal Best Time</h4>
                                     <div class="w-full sm:w-60">
                                         <select id="pbt_filter_selector" class="w-full text-xs rounded-md border-gray-300 shadow-sm text-gray-900 font-semibold bg-white py-1">
                                             <!-- Dynamically populated -->
                                         </select>
                                     </div>
                                 </div>
                                 <div class="relative w-full h-[300px]">
                                     <canvas id="lineChartPBT"></canvas>
                                 </div>
                             </div>
                        </div>

                        {{-- Catatan Kelas Belajar: Layout Vertical Tabs (2 Kolom) --}}
                        <div id="freetext-container" class="hidden mt-4 mb-6">
                            <div style="display: flex; height: 420px; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; background: #fff;">
                                {{-- Kolom Kiri: Sidebar Menu Bulan --}}
                                <div style="width: 200px; min-width: 200px; background: #f8fafc; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column;">
                                    <div style="padding: 12px; border-bottom: 1px solid #e2e8f0; background: rgba(241,245,249,0.8);">
                                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar-days"></i> Menu Bulan
                                        </h4>
                                    </div>
                                    <div id="freetext-month-list" style="flex: 1; overflow-y: auto; padding: 8px;" class="space-y-1">
                                        {{-- Diisi oleh JS --}}
                                    </div>
                                </div>
                                {{-- Kolom Kanan: Detail Bulan Terpilih --}}
                                <div style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                                    <div id="freetext-detail-panel" style="flex: 1; overflow-y: auto; padding: 20px;">
                                        <div id="freetext-detail-empty" class="flex flex-col items-center justify-center h-full text-gray-400">
                                            <i class="fa-regular fa-hand-pointer text-4xl mb-3 text-gray-200"></i>
                                            <p class="text-sm font-medium text-gray-500">Pilih bulan di samping kiri</p>
                                            <p class="text-xs text-gray-400 mt-1">Detail catatan perkembangan akan ditampilkan di sini.</p>
                                        </div>
                                        <div id="freetext-detail-content" class="hidden">
                                            {{-- Diisi oleh JS --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Detail/Catatan Tambahan --}}
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
                @endif
            </div>

        </div>
    </div>

    {{-- Import Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if ($students->isNotEmpty())
        <script>
            // Fungsi helper ubah "01:25.50" jadi detik "85.5"
            function parseTimeToSeconds(timeStr) {
                if (!timeStr) return null;
                const match = timeStr.match(/(?:(\d+):)?(\d+)[.,:](\d+)/);
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

            document.addEventListener('DOMContentLoaded', function() {
                // Data murid & perkembangan dari Laravel dijadikan object JS
                const studentsArray = @json($students);
                const studentsMap = {};
                studentsArray.forEach(function(s) {
                    studentsMap[String(s.id)] = s;
                });

                const selectDropdown = document.getElementById('chart_student_id');
                const yearDropdown = document.getElementById('chart_year_filter');
                const emptyState = document.getElementById('chart-empty-state');
                const noDataState = document.getElementById('chart-no-data-state');
                const yearEmptyState = document.getElementById('chart-year-empty-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');
                const freetextContainer = document.getElementById('freetext-container');
                const prestasiContainer = document.getElementById('prestasi-charts-container');

                let radarChartInst = null;
                let barChartInst = null;
                let lineChartPBTInst = null;
                let currentReports = [];
                let currentStudent = null;

                function hideAllStates() {
                    emptyState.classList.add('hidden');
                    emptyState.style.display = '';
                    noDataState.classList.add('hidden');
                    noDataState.style.display = '';
                    yearEmptyState.classList.add('hidden');
                    yearEmptyState.style.display = '';
                    chartContainer.classList.add('hidden');
                    chartContainer.style.display = '';
                }

                function destroyAllCharts() {
                    if (radarChartInst) { radarChartInst.destroy(); radarChartInst = null; }
                    if (barChartInst) { barChartInst.destroy(); barChartInst = null; }
                    if (lineChartPBTInst) { lineChartPBTInst.destroy(); lineChartPBTInst = null; }
                }

                function renderChartsForYear(year) {
                    destroyAllCharts();
                    hideAllStates();

                    const filteredReports = currentReports.filter(r => {
                        return new Date(r.date).getFullYear() === parseInt(year);
                    });

                    if (filteredReports.length === 0) {
                        yearEmptyState.classList.remove('hidden');
                        yearEmptyState.style.display = 'flex';
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) { prestasiContainer.classList.add('hidden'); prestasiContainer.style.display = 'none'; }
                        return;
                    }

                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Update catatan terakhir (dari filtered reports)
                    const latestReport = filteredReports[filteredReports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;

                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}`;

                    // Info murid
                    document.getElementById('student-coach').textContent = currentStudent.coach ? currentStudent.coach.name :
                        'Belum Ditugaskan';
                    document.getElementById('student-location').textContent = currentStudent.location ? currentStudent
                        .location.name : 'Belum Dipilih';
                    document.getElementById('student-quota').textContent = `${currentStudent.quota_left} sesi`;

                    // Cek apakah data ini adalah kelas Prestasi (memiliki Personal Best Time — selalu diisi untuk prestasi)
                    const isPrestasi = filteredReports.some(r => r.metrics && ('Personal Best Time' in r.metrics));

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        // --- 1. Siapkan Data ---
                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };

                        // Cek apakah ada data Kondisi Fisik / Sistem Energi di salah satu report
                        let hasKondisiFisik = false;
                        let hasSistemEnergi = false;

                        filteredReports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short' }));

                            if (report.metrics) {
                                // Radar (Kondisi Fisik)
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                if (Object.keys(kf).length > 0) hasKondisiFisik = true;
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                // Bar (Sistem Energi)
                                const se = report.metrics['Sistem Energi'] || {};
                                if (Object.keys(se).length > 0) hasSistemEnergi = true;
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);
                            }
                        });

                        // Tampilkan/Sembunyikan chart berdasarkan ketersediaan data
                        const kondisiFisikEl = document.getElementById('radarChart').closest('.bg-slate-50');
                        const sistemEnergiEl = document.getElementById('barChart').closest('.bg-slate-50');
                        const chartsGridEl = kondisiFisikEl.parentElement; // grid container

                        if (hasKondisiFisik) {
                            kondisiFisikEl.style.display = '';
                        } else {
                            kondisiFisikEl.style.display = 'none';
                        }

                        if (hasSistemEnergi) {
                            sistemEnergiEl.style.display = '';
                        } else {
                            sistemEnergiEl.style.display = 'none';
                        }

                        // Sembunyikan seluruh grid baris atas jika kedua chart tidak ada
                        if (!hasKondisiFisik && !hasSistemEnergi) {
                            chartsGridEl.style.display = 'none';
                        } else {
                            chartsGridEl.style.display = '';
                        }

                        // Ambil 2 bulan terakhir untuk komparasi Radar
                        const len = labels.length;

                        if (hasKondisiFisik) {
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
                        }

                        if (hasSistemEnergi) {
                            // --- 3. Render Bar Chart (Sistem Energi) ---
                            barChartInst = new Chart(document.getElementById('barChart').getContext('2d'), {
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
                        }

                        // --- 4. Render Line Chart PBT with selector dropdown ---
                        const pbtSelector = document.getElementById('pbt_filter_selector');
                        const pbtCombinations = [];

                        filteredReports.forEach(report => {
                            if (report.metrics && report.metrics['Personal Best Time']) {
                                let entries = [];
                                if (Array.isArray(report.metrics['Personal Best Time'])) {
                                    entries = report.metrics['Personal Best Time'];
                                } else {
                                    entries = [{
                                        gaya: 'Gaya Bebas',
                                        jarak: '50m',
                                        test_per_bulan: report.metrics['Personal Best Time']['Test per Bulan'] || '',
                                        pbt_event: report.metrics['Personal Best Time']['PBT Event'] || ''
                                    }];
                                }
                                entries.forEach(e => {
                                    if (e.gaya && e.jarak) {
                                        const key = `${e.gaya} - ${e.jarak}`;
                                        if (!pbtCombinations.includes(key)) {
                                            pbtCombinations.push(key);
                                        }
                                    }
                                });
                            }
                        });

                        const oldSelectedVal = pbtSelector ? pbtSelector.value : '';

                        if (pbtSelector) {
                            pbtSelector.innerHTML = '';
                            if (pbtCombinations.length === 0) {
                                const opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = 'Tidak ada data PBT';
                                pbtSelector.appendChild(opt);
                            } else {
                                pbtCombinations.forEach(comb => {
                                    const opt = document.createElement('option');
                                    opt.value = comb;
                                    opt.textContent = comb;
                                    pbtSelector.appendChild(opt);
                                });

                                if (pbtCombinations.includes(oldSelectedVal)) {
                                    pbtSelector.value = oldSelectedVal;
                                } else {
                                    pbtSelector.value = pbtCombinations[0];
                                }
                            }

                            // Remove old event listener to prevent duplication
                            pbtSelector.onchange = null;
                            pbtSelector.addEventListener('change', updateLineChartPBT);
                        }

                        function updateLineChartPBT() {
                            if (lineChartPBTInst) {
                                lineChartPBTInst.destroy();
                                lineChartPBTInst = null;
                            }

                            const val = pbtSelector ? pbtSelector.value : '';
                            if (!val) return;

                            const parts = val.split(' - ');
                            const selGaya = parts[0];
                            const selJarak = parts[1];

                            const localLabels = [];
                            const localPbtData = { TestPerBulan: [], PbtEvent: [] };

                            filteredReports.forEach(report => {
                                const d = new Date(report.date);
                                let entry = null;

                                if (report.metrics && report.metrics['Personal Best Time']) {
                                    let entries = [];
                                    if (Array.isArray(report.metrics['Personal Best Time'])) {
                                        entries = report.metrics['Personal Best Time'];
                                    } else {
                                        entries = [{
                                            gaya: 'Gaya Bebas',
                                            jarak: '50m',
                                            test_per_bulan: report.metrics['Personal Best Time']['Test per Bulan'] || '',
                                            pbt_event: report.metrics['Personal Best Time']['PBT Event'] || ''
                                        }];
                                    }
                                    entry = entries.find(e => e.gaya === selGaya && e.jarak === selJarak);
                                }

                                if (entry && entry.test_per_bulan) {
                                    localLabels.push(d.toLocaleDateString('id-ID', { month: 'short' }));
                                    localPbtData.TestPerBulan.push(parseTimeToSeconds(entry.test_per_bulan));
                                    localPbtData.PbtEvent.push({
                                        val: parseTimeToSeconds(entry.pbt_event),
                                        raw: entry.pbt_event
                                    });
                                }
                            });

                            const pbtDatasets = [
                                {
                                    label: 'Test per Bulan',
                                    data: localPbtData.TestPerBulan,
                                    borderColor: 'rgb(147, 51, 234)',
                                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                    tension: 0.3,
                                    fill: true
                                },
                                {
                                    label: 'PBT Event',
                                    data: localPbtData.PbtEvent.map(e => e.val),
                                    type: 'scatter',
                                    pointBackgroundColor: 'rgb(245, 158, 11)',
                                    pointBorderColor: 'rgb(255, 255, 255)',
                                    pointRadius: 6,
                                    pointHoverRadius: 8
                                }
                            ];

                            lineChartPBTInst = new Chart(document.getElementById('lineChartPBT').getContext('2d'), {
                                type: 'line',
                                data: { labels: localLabels, datasets: pbtDatasets },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    if (context.dataset.label === 'PBT Event') {
                                                        const rawText = localPbtData.PbtEvent[context.dataIndex].raw;
                                                        return `Event: ${rawText || formatSecondsToTime(context.raw)}`;
                                                    }
                                                    return `Test: ${formatSecondsToTime(context.raw)}`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            reverse: true,
                                            ticks: {
                                                callback: function(value) { return formatSecondsToTime(value); }
                                            },
                                            title: { display: true, text: 'Waktu (MM:SS.ms)' }
                                        }
                                    }
                                }
                            });
                        }

                        // Initial render
                        updateLineChartPBT();

                    } else {
                        // KELAS BELAJAR (VERTICAL TABS — 2 Kolom)
                        if (prestasiContainer) { prestasiContainer.classList.add('hidden'); prestasiContainer.style.display = 'none'; }

                        if (freetextContainer) {
                            freetextContainer.classList.remove('hidden');

                            const monthList = document.getElementById('freetext-month-list');
                            const detailEmpty = document.getElementById('freetext-detail-empty');
                            const detailContent = document.getElementById('freetext-detail-content');
                            monthList.innerHTML = '';
                            detailContent.innerHTML = '';
                            detailContent.classList.add('hidden');
                            detailEmpty.classList.remove('hidden');

                            const sortedReports = [...filteredReports].reverse();

                            function showMonthDetail(report, btnEl) {
                                monthList.querySelectorAll('button').forEach(b => {
                                    b.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
                                    b.classList.add('bg-white', 'text-slate-700', 'hover:bg-indigo-50');
                                    b.querySelector('.month-dot')?.classList.remove('bg-white');
                                    b.querySelector('.month-dot')?.classList.add('bg-indigo-400');
                                });
                                btnEl.classList.remove('bg-white', 'text-slate-700', 'hover:bg-indigo-50');
                                btnEl.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
                                btnEl.querySelector('.month-dot')?.classList.remove('bg-indigo-400');
                                btnEl.querySelector('.month-dot')?.classList.add('bg-white');

                                detailEmpty.classList.add('hidden');
                                detailContent.classList.remove('hidden');

                                const d = new Date(report.date);
                                const dateStr = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });

                                let metricsHtml = '';
                                if (report.metrics) {
                                    for (const [category, items] of Object.entries(report.metrics)) {
                                        metricsHtml += `<div class="mb-4">
                                            <h5 class="text-sm font-bold text-slate-800 border-b border-slate-200 pb-1.5 mb-3 flex items-center gap-1.5">
                                                <i class="fa-solid fa-layer-group text-indigo-500 text-xs"></i> ${category}
                                            </h5>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                        for (const [key, val] of Object.entries(items)) {
                                            let badgeColor = 'bg-slate-100 text-slate-700';
                                            if (val === 'Sangat Mahir' || val === 'Lulus Tahap Ini' || val === 'Sudah Lancar') badgeColor = 'bg-green-100 text-green-700';
                                            else if (val === 'Berkembang Baik' || val === 'Mulai Bisa') badgeColor = 'bg-blue-100 text-blue-700';
                                            else if (val === 'Mulai Terlihat') badgeColor = 'bg-amber-100 text-amber-700';
                                            else if (val === 'Belum Berkembang' || val === 'Belum Bisa' || val === 'Belum Memulai') badgeColor = 'bg-red-100 text-red-700';

                                            metricsHtml += `<div class="text-xs flex justify-between items-center p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                                                <span class="font-medium text-slate-600">${key}</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold ${badgeColor}">${val}</span>
                                            </div>`;
                                        }
                                        metricsHtml += `</div></div>`;
                                    }
                                }

                                detailContent.innerHTML = `
                                    <div class="flex items-center gap-2 mb-5">
                                        <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                                        <h4 class="text-base font-bold text-slate-800">Bulan: ${dateStr}</h4>
                                    </div>
                                    <div class="mb-5">
                                        ${metricsHtml || '<p class="text-sm text-gray-400 italic">Tidak ada data metrik untuk bulan ini.</p>'}
                                    </div>
                                    ${report.notes ? `
                                    <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl">
                                        <p class="text-xs font-bold text-indigo-800 mb-1.5 flex items-center gap-1">
                                            <i class="fa-solid fa-comment-dots"></i> Catatan Pelatih:
                                        </p>
                                        <p class="text-sm text-slate-700 italic leading-relaxed">${report.notes}</p>
                                    </div>` : `
                                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                                        <p class="text-xs text-slate-400 italic">Tidak ada catatan dari pelatih pada bulan ini.</p>
                                    </div>`}
                                `;
                            }

                            sortedReports.forEach((report, idx) => {
                                const d = new Date(report.date);
                                const monthName = d.toLocaleDateString('id-ID', { month: 'long' });

                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left text-sm font-semibold transition-all duration-150 bg-white text-slate-700 hover:bg-indigo-50 border border-transparent';
                                btn.innerHTML = `
                                    <span class="month-dot w-2 h-2 rounded-full bg-indigo-400 shrink-0"></span>
                                    <span class="truncate">${monthName}</span>
                                `;
                                btn.addEventListener('click', () => showMonthDetail(report, btn));
                                monthList.appendChild(btn);

                                if (idx === 0) {
                                    showMonthDetail(report, btn);
                                }
                            });
                        }
                    }
                }

                selectDropdown.addEventListener('change', function() {
                    const studentId = String(this.value);
                    const student = studentsMap[studentId];

                    if (!student) return;

                    currentStudent = student;
                    currentReports = student.progress_reports || [];

                    destroyAllCharts();
                    hideAllStates();

                    if (currentReports.length === 0) {
                        yearDropdown.innerHTML = '<option value="" disabled selected>-- Tahun --</option>';
                        yearDropdown.disabled = true;

                        noDataState.classList.remove('hidden');
                        noDataState.style.display = 'flex';

                        document.getElementById('no-data-subtext').textContent =
                            'Silakan input data perkembangan fisik pertama murid ini pada menu Catat Perkembangan.';
                        return;
                    }

                    // Populate year dropdown
                    const yearsSet = new Set();
                    currentReports.forEach(r => {
                        yearsSet.add(new Date(r.date).getFullYear());
                    });
                    const years = [...yearsSet].sort((a, b) => b - a);

                    yearDropdown.innerHTML = '<option value="" disabled>-- Tahun --</option>';
                    years.forEach(y => {
                        const opt = document.createElement('option');
                        opt.value = y;
                        opt.textContent = y;
                        yearDropdown.appendChild(opt);
                    });
                    yearDropdown.disabled = false;
                    yearDropdown.value = years[0]; // Auto-select latest year

                    renderChartsForYear(years[0]);
                });

                yearDropdown.addEventListener('change', function() {
                    if (this.value) {
                        renderChartsForYear(this.value);
                    }
                });

                // Auto-select murid pertama jika ada
                @if ($students->isNotEmpty())
                    selectDropdown.value = "{{ $students->first()->id }}";
                    selectDropdown.dispatchEvent(new Event('change'));
                @endif
            });
        </script>
    @endif

</x-app-layout>
