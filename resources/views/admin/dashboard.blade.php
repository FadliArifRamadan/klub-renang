<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Panel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Dashboard, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di panel kontrol Black Diamond. Kelola verifikasi pembayaran, data murid, pelatih,
                    kolam
                    latihan, dan paket program secara terpusat dan efisien.
                </p>
            </div>

            {{-- Metrics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1: Total Murid -->
                <a href="{{ route('admin.students.index') }}"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalStudents }} Murid</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 2: Total Coach -->
                <a href="{{ route('admin.coaches.index') }}"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-100 transition-colors">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalCoaches }} Pelatih</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-emerald-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 3: Total Tempat Latihan -->
                <a href="{{ route('admin.locations.index') }}"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-100 transition-colors">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalLocations }} Lokasi</p>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-amber-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>

                <!-- Card 4: Pending Payments -->
                <a href="{{ route('admin.payments.index') }}"
                    class="group bg-white overflow-hidden shadow-sm hover:shadow-md sm:rounded-xl p-6 border border-gray-100 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="p-3 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-100 transition-colors {{ $pendingPayments > 0 ? 'animate-pulse' : '' }}">
                            <i class="fa-solid fa-wallet text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Verifikasi Bayar</p>
                            <div class="flex items-center gap-1.5">
                                <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ $pendingPayments }} Pending</p>
                                @if ($pendingPayments > 0)
                                    <span
                                        class="inline-flex items-center bg-rose-100 text-rose-850 text-[9px] font-bold px-1.5 py-0.5 rounded-full border border-rose-200">
                                        Perlu Aksi
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-300 group-hover:text-rose-500 transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </a>
            </div>

            {{-- Progress Chart Section --}}
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

                    {{-- Dropdown Pilih Murid di Grafik --}}
                    <div class="w-full sm:w-72">
                        <select id="chart_student_id"
                            class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                            <option value="" disabled selected>-- Pilih Murid Kursus --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} ({{ $student->package->name ?? 'Tanpa Paket' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Empty State (Belum ada murid dipilih) --}}
                <div id="chart-empty-state"
                    class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                    <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                    <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown untuk menampilkan grafik</p>
                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                        kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan murid.</p>
                </div>

                {{-- State data kosong untuk murid terpilih --}}
                <div id="chart-no-data-state"
                    class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                    <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                    <p class="font-medium text-gray-600">Belum ada riwayat perkembangan murid ini</p>
                    <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping untuk
                        menginput data perkembangan fisik pertama.</p>
                </div>

                {{-- Container Grafik & Detail Perkembangan --}}
                <div id="chart-container" class="hidden flex-1 flex-col">
                    {{-- Canvas Chart.js --}}
                    <div class="relative w-full h-[360px] mb-6">
                        <canvas id="progressChart"></canvas>
                    </div>

                    {{-- Detail/Catatan Tambahan --}}
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

    {{-- Import Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data murid & perkembangan dari Laravel yang dijadikan object JS
            const studentsArray = @json($students);
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

                // Update info murid
                document.getElementById('student-coach').textContent = student.coach ? student.coach.name :
                    'Belum Ditugaskan';
                document.getElementById('student-location').textContent = student.location ? student
                    .location.name : 'Belum Dipilih';
                document.getElementById('student-quota').textContent = `${student.quota_left} sesi`;

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
                                backgroundColor: 'rgba(37, 99, 235, 0.05)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Endurance',
                                data: enduranceData,
                                borderColor: 'rgb(16, 185, 129)', // Emerald
                                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Flexibility',
                                data: flexibilityData,
                                borderColor: 'rgb(147, 51, 234)', // Purple
                                backgroundColor: 'rgba(147, 51, 234, 0.05)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Speed',
                                data: speedData,
                                borderColor: 'rgb(239, 68, 68)', // Red
                                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                borderWidth: 2.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Agility',
                                data: agilityData,
                                borderColor: 'rgb(245, 158, 11)', // Amber
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

            // Auto select murid pertama di dropdown grafik jika ada
            @if ($students->isNotEmpty())
                selectDropdown.value = "{{ $students->first()->id }}";
                selectDropdown.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app-layout>
