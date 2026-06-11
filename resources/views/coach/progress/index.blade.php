<x-app-layout title="Coach - Catat Perkembangan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat & Pantau Perkembangan') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> {{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> {{ session('error') }}</div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Kiri: Form Input Perkembangan (Lg: 5/12) --}}
                <div class="lg:col-span-5">
                    @php
                        $studentCategories = $students->mapWithKeys(function($s) {
                            return [$s->id => $s->swimmingClass->category->slug ?? 'belajar'];
                        });
                    @endphp
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100"
                        x-data="{
                            selectedStudentId: '{{ old('student_id', '') }}',
                            categoriesMap: @js($studentCategories),
                            get isPrestasi() {
                                return this.selectedStudentId && this.categoriesMap[this.selectedStudentId] === 'prestasi';
                            }
                        }">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-blue-600"></i>
                            <span x-text="isPrestasi ? 'Input Nilai Fisik Murid' : 'Input Catatan Perkembangan'">Input Nilai Fisik Murid</span>
                        </h3>

                        <form action="{{ route('coach.progress.store') }}" method="POST">
                            @csrf

                            {{-- Pilih Murid --}}
                            <div class="mb-4">
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Pilih Murid *
                                </label>
                                <select name="student_id" id="student_id" x-model="selectedStudentId"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                    required>
                                    <option value="" disabled selected>-- Pilih Murid Latihan --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }} ({{ $student->location->name ?? 'Kolam Latihan' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal & Coach --}}
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Tanggal Tes *
                                    </label>
                                    <input type="date" name="date" id="date"
                                        value="{{ old('date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 text-sm"
                                        required>
                                    @error('date')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Nama Coach
                                    </label>
                                    <input type="text" value="{{ Auth::user()->name }}"
                                        class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 text-sm cursor-not-allowed"
                                        readonly>
                                </div>
                            </div>

                            <div x-show="isPrestasi" x-transition>
                                <hr class="my-6 border-gray-150">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Indikator Fisik
                                    Murid (1 - 100)</p>

                                {{-- Slider/Range Inputs untuk 5 Indikator --}}
                                @php
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
                                @endphp

                                @foreach ($indicators as $ind)
                                    <div class="mb-5">
                                        <div class="flex justify-between items-center mb-1.5">
                                            <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                                <i class="fa-solid {{ $ind['icon'] }} {{ $ind['color'] }} w-4"></i>
                                                {{ $ind['label'] }}
                                            </span>
                                            <span id="val-{{ $ind['name'] }}"
                                                class="bg-gray-100 text-gray-800 text-xs font-bold px-2 py-0.5 rounded shadow-sm border">
                                                {{ old($ind['name'], 50) }}
                                            </span>
                                        </div>
                                        <input type="range" name="{{ $ind['name'] }}" id="range-{{ $ind['name'] }}"
                                            min="1" max="100" value="{{ old($ind['name'], 50) }}"
                                            class="w-full h-2 bg-gray-200 rounded-lg cursor-pointer transition-all duration-150 {{ $ind['bg'] }}"
                                            oninput="document.getElementById('val-{{ $ind['name'] }}').innerText = this.value">
                                        @error($ind['name'])
                                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            {{-- Catatan tambahan --}}
                            <div class="mb-6 mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5" x-text="isPrestasi ? 'Catatan Perkembangan (Opsional)' : 'Catatan Perkembangan (Wajib) *'">
                                    Catatan Perkembangan (Opsional)
                                </label>
                                <textarea name="notes" id="notes" rows="4" placeholder="Tulis catatan penting tentang latihan hari ini..."
                                    x-bind:required="!isPrestasi"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 text-sm">{{ old('notes') }}</textarea>
                            </div>

                            <button type="submit"
                                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-150 text-sm flex justify-center items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Perkembangan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Kanan: Visualisasi Grafik Perkembangan (Lg: 7/12) --}}
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 flex-1 flex flex-col">

                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                            <h3 id="panel-title" class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i id="panel-icon" class="fa-solid fa-chart-line text-blue-600"></i>
                                <span id="panel-title-text">Visualisasi Perkembangan</span>
                            </h3>

                            {{-- Dropdown Pilih Murid di Grafik --}}
                            <div class="w-full sm:w-64">
                                <select id="chart_student_id"
                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50">
                                    <option value="" disabled selected>-- Pilih Murid Grafik --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Empty State (Belum ada murid dipilih) --}}
                        <div id="chart-empty-state"
                            class="flex-1 flex flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Silakan pilih murid pada dropdown di atas</p>
                            <p class="text-xs mt-1">Grafik/riwayat perkembangan akan dirender setelah murid dipilih.</p>
                        </div>

                        {{-- State data kosong untuk murid terpilih --}}
                        <div id="chart-no-data-state"
                            class="hidden flex-1 flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Belum ada riwayat perkembangan murid ini</p>
                            <p class="text-xs mt-1">Gunakan form di sebelah kiri untuk menginput data perkembangan pertama.</p>
                        </div>

                        {{-- Container Grafik & Detail Perkembangan (Untuk Prestasi) --}}
                        <div id="chart-container" class="hidden flex-1 flex-col">
                            {{-- Canvas Chart.js --}}
                            <div class="relative w-full h-[320px] mb-6">
                                <canvas id="progressChart"></canvas>
                            </div>

                            {{-- Catatan Terakhir Murid --}}
                            <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-4 mt-auto">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Coach
                                </h4>
                                <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada evaluasi terakhir."</p>
                                <div id="latest-note-date" class="text-[10px] text-gray-400 mt-1 font-semibold">Diinput pada: -</div>
                            </div>
                        </div>

                        {{-- Container Catatan Perkembangan (Untuk Belajar) --}}
                        <div id="notes-timeline-container" class="hidden flex-1 flex-col overflow-y-auto max-h-[450px]">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">
                                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Riwayat Catatan Perkembangan Sesi
                            </h4>
                            <div id="notes-timeline" class="space-y-4 pr-2">
                                <!-- Will be populated by JS -->
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
            const studentsMap = @json($students->keyBy('id'));
            const categoriesMap = @json($studentCategories);

            const selectDropdown = document.getElementById('chart_student_id');
            const emptyState = document.getElementById('chart-empty-state');
            const noDataState = document.getElementById('chart-no-data-state');
            const chartContainer = document.getElementById('chart-container');
            const notesTimelineContainer = document.getElementById('notes-timeline-container');
            const notesTimeline = document.getElementById('notes-timeline');
            const latestNoteText = document.getElementById('latest-note');
            const latestNoteDate = document.getElementById('latest-note-date');
            const panelTitleText = document.getElementById('panel-title-text');
            const panelIcon = document.getElementById('panel-icon');

            let myChart = null;

            // Handler perubahan dropdown murid di grafik
            selectDropdown.addEventListener('change', function() {
                const studentId = this.value;
                const student = studentsMap[studentId];
                const categorySlug = categoriesMap[studentId] || 'belajar';

                if (!student) return;

                const reports = student.progress_reports || [];

                if (reports.length === 0) {
                    // Tampilkan state tidak ada data
                    emptyState.classList.add('hidden');
                    chartContainer.classList.add('hidden');
                    chartContainer.classList.remove('flex');
                    notesTimelineContainer.classList.add('hidden');
                    notesTimelineContainer.classList.remove('flex');
                    noDataState.classList.remove('hidden');
                    noDataState.classList.add('flex');
                    return;
                }

                // Sembunyikan state kosong & tidak ada data
                emptyState.classList.add('hidden');
                noDataState.classList.add('hidden');
                noDataState.classList.remove('flex');

                if (categorySlug === 'prestasi') {
                    // Tampilkan grafik, sembunyikan timeline
                    notesTimelineContainer.classList.add('hidden');
                    notesTimelineContainer.classList.remove('flex');
                    chartContainer.classList.remove('hidden');
                    chartContainer.classList.add('flex');

                    // Sesuaikan Title & Icon Panel
                    panelTitleText.innerText = 'Visualisasi Perkembangan';
                    panelIcon.className = 'fa-solid fa-chart-line text-blue-600';

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
                } else {
                    // Belajar: Tampilkan timeline notes, sembunyikan grafik
                    chartContainer.classList.add('hidden');
                    chartContainer.classList.remove('flex');
                    notesTimelineContainer.classList.remove('hidden');
                    notesTimelineContainer.classList.add('flex');

                    // Sesuaikan Title & Icon Panel
                    panelTitleText.innerText = 'Riwayat Perkembangan';
                    panelIcon.className = 'fa-solid fa-clock-rotate-left text-indigo-600';

                    // Kosongkan dan isi timeline
                    notesTimeline.innerHTML = '';
                    // Urutkan dari yang terbaru ke terlama
                    const sortedReports = [...reports].sort((a, b) => new Date(b.date) - new Date(a.date));

                    sortedReports.forEach(report => {
                        const d = new Date(report.date);
                        const dateFormatted = d.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                        const item = document.createElement('div');
                        item.className = 'relative pl-6 pb-6 border-l-2 border-indigo-100 last:pb-0 last:border-l-0';
                        item.innerHTML = `
                            <!-- Dot -->
                            <span class="absolute -left-[7px] top-1.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-indigo-500 ring-4 ring-white"></span>
                            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 shadow-sm hover:shadow transition-all duration-150">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-400">
                                        <i class="fa-regular fa-calendar-days mr-1"></i> ${dateFormatted}
                                    </span>
                                    <span class="text-[10px] bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full font-bold border border-indigo-100">
                                        Sesi Latihan
                                    </span>
                                </div>
                                <p class="text-sm text-slate-700 whitespace-pre-line font-medium leading-relaxed">
                                    ${report.notes || 'Tidak ada catatan.'}
                                </p>
                            </div>
                        `;
                        notesTimeline.appendChild(item);
                    });
                }
            });

            // Auto select murid pertama di dropdown grafik jika ada & form baru saja disubmit
            @if (old('student_id'))
                selectDropdown.value = "{{ old('student_id') }}";
                selectDropdown.dispatchEvent(new Event('change'));
            @elseif ($students->isNotEmpty())
                // Pilih murid pertama
                selectDropdown.value = "{{ $students->first()->id }}";
                selectDropdown.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app-layout>
