<x-app-layout title="Parent - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Parent') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Panel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di portal orang tua Black Diamond. Pantau perkembangan anak Anda, cek status latihan,
                    dan lihat catatan terbaru dari pelatih di sini.
                </p>
            </div>

            {{-- Notifikasi Sesi Habis --}}
            @if (isset($expiredStudents) && $expiredStudents->isNotEmpty())
                <div class="bg-amber-50 border border-amber-300 rounded-xl p-5 mb-8 shadow-sm" x-data="{ showNotif: true }" x-show="showNotif" x-transition>
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 w-full">
                            <div class="p-2 bg-amber-100 text-amber-600 rounded-lg mt-0.5 shrink-0">
                                <i class="fa-solid fa-bell text-lg"></i>
                            </div>
                            <div class="w-full">
                                <h4 class="font-bold text-amber-800 text-sm">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                    Sesi Latihan Telah Habis!
                                </h4>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Beberapa anak Anda telah menghabiskan seluruh kuota sesi latihannya. Silakan lakukan daftar ulang paket latihan di bawah ini.
                                </p>
                                <div class="mt-3 space-y-2 max-w-2xl">
                                    @foreach ($expiredStudents as $expStudent)
                                        <div class="flex flex-wrap items-center gap-2 bg-white/60 border border-amber-200 rounded-lg px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-child text-amber-500"></i>
                                                <span class="font-semibold text-sm text-gray-800">{{ $expStudent->name }}</span>
                                                <span class="text-xs text-gray-500">—</span>
                                                <span class="text-xs text-gray-600">{{ $expStudent->package->name ?? 'Paket' }}</span>
                                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-red-200">
                                                    Sesi Habis
                                                </span>
                                            </div>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'renew-student-{{ $expStudent->id }}')"
                                                class="ml-auto px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-rotate-right"></i> Daftar Ulang
                                            </button>
                                        </div>

                                        {{-- Modal Daftar Ulang --}}
                                        <x-modal name="renew-student-{{ $expStudent->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('parent.students.renew', $expStudent->id) }}" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{ 
                                                    packageId: '{{ $expStudent->package_id }}',
                                                    locationId: '{{ $expStudent->location_id }}',
                                                    packages: {{ $packages->toJson() }},
                                                    getPrice() {
                                                        const pkg = this.packages.find(p => p.id == this.packageId);
                                                        if (!pkg) return 0;
                                                        if (pkg.is_location_based && pkg.location_prices) {
                                                            const lp = pkg.location_prices.find(l => l.location_id == this.locationId);
                                                            return lp ? lp.price : 0;
                                                        }
                                                        return pkg.price ?? 0;
                                                    },
                                                    formatPrice(price) {
                                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
                                                    }
                                                }">
                                                @csrf

                                                {{-- Field tersembunyi untuk swimming_class_id --}}
                                                <input type="hidden" name="swimming_class_id" value="{{ $expStudent->swimming_class_id }}">

                                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                    <i class="fa-solid fa-rotate-right text-amber-500"></i>
                                                    Daftar Ulang Paket Latihan - {{ $expStudent->name }}
                                                </h3>

                                                @if($expStudent->swimmingClass)
                                                    <div class="mb-4 bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 text-xs text-blue-700 flex items-center gap-2">
                                                        <i class="fa-solid fa-layer-group"></i>
                                                        <span>Kelas: <strong>{{ $expStudent->swimmingClass->name }}</strong></span>
                                                    </div>
                                                @endif

                                                <!-- Tanggal Lahir -->
                                                <div class="mb-4">
                                                    <x-input-label for="birth_date-{{ $expStudent->id }}" value="Tanggal Lahir" />
                                                    <x-text-input id="birth_date-{{ $expStudent->id }}" class="block mt-1 w-full text-sm" type="date" name="birth_date"
                                                        value="{{ $expStudent->birth_date?->format('Y-m-d') }}" required />
                                                </div>

                                                <!-- Jenis Kelamin -->
                                                <div class="mb-4">
                                                    <x-input-label for="gender-{{ $expStudent->id }}" value="Jenis Kelamin" />
                                                    <select id="gender-{{ $expStudent->id }}" name="gender" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="L" {{ $expStudent->gender == 'L' || $expStudent->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $expStudent->gender == 'P' || $expStudent->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>

                                                <!-- Tempat Latihan -->
                                                <div class="mb-4">
                                                    <x-input-label for="location-{{ $expStudent->id }}" value="Kolam Latihan" />
                                                    <select id="location-{{ $expStudent->id }}" name="location_id" x-model="locationId" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        @foreach ($locations as $loc)
                                                            <option value="{{ $loc->id }}" {{ $expStudent->location_id == $loc->id ? 'selected' : '' }}>
                                                                {{ $loc->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Paket Latihan -->
                                                <div class="mb-4">
                                                    <x-input-label for="package-{{ $expStudent->id }}" value="Paket Kursus" />
                                                    <select id="package-{{ $expStudent->id }}" name="package_id" x-model="packageId" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        @foreach ($packages as $pkg)
                                                            <option value="{{ $pkg->id }}">
                                                                {{ $pkg->name }} ({{ $pkg->sessions }} Sesi)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Info Pembayaran & Rekening -->
                                                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-4 text-xs text-blue-800">
                                                    <p class="font-bold text-sm mb-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Informasi Pembayaran</p>
                                                    <p>Silakan transfer nominal ke rekening berikut:</p>
                                                    <p class="font-extrabold text-gray-900 mt-1">Bank BCA: 123-4567-890 (a.n. Klub Renang)</p>
                                                    <div class="mt-2 pt-2 border-t border-blue-200/50 flex justify-between items-center">
                                                        <span class="font-semibold">Nominal Transfer:</span>
                                                        <span class="text-sm font-black text-blue-700" x-text="formatPrice(getPrice())"></span>
                                                    </div>
                                                </div>

                                                <!-- Bukti Transfer -->
                                                <div class="mb-4">
                                                    <x-input-label for="receipt-{{ $expStudent->id }}" value="Unggah Bukti Transfer (Screenshot/Foto)" />
                                                    <input type="file" id="receipt-{{ $expStudent->id }}" name="receipt_image" accept="image/*" required
                                                        class="block w-full text-sm text-gray-500 mt-1
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-md file:border-0
                                                            file:text-xs file:font-semibold
                                                            file:bg-blue-50 file:text-blue-700
                                                            hover:file:bg-blue-100
                                                            border border-gray-300 rounded-md cursor-pointer p-1" />
                                                    <p class="text-[10px] text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                                                </div>

                                                <!-- Aksi -->
                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>
                                                    <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs uppercase tracking-widest rounded-md shadow-sm transition">
                                                        Kirim Pendaftaran Ulang
                                                    </button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button @click="showNotif = false" class="text-amber-400 hover:text-amber-600 transition-colors p-1 self-start">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Metrics Grid (Non-Clickable untuk Parent) --}}
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
                            Grafik Catatan Perkembangan Anak
                        </h3>
                        <p class="text-xs text-gray-500">Pilih anak Anda untuk memantau performa latihan dan indikator
                            fisiknya.</p>
                    </div>

                    {{-- Dropdown Pilih Anak + Tahun --}}
                    @if ($children->isNotEmpty())
                        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                            <div class="w-full sm:w-64">
                                <select id="chart_child_id"
                                    class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                                    <option value="" disabled selected>-- Pilih Anak --</option>
                                    @foreach ($children as $child)
                                        <option value="{{ $child->id }}">
                                            {{ $child->name }} ({{ $child->package->name ?? 'Tanpa Paket' }})
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

                {{-- State: Tidak ada anak terdaftar --}}
                @if ($children->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-child-reaching text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada anak yang terdaftar</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Daftarkan anak Anda terlebih dahulu untuk mulai
                            memantau perkembangan latihannya.</p>
                        <a href="{{ route('parent.students.create') }}"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-plus"></i> Daftarkan Anak
                        </a>
                    </div>
                @else
                    {{-- Empty State (Belum ada anak dipilih) --}}
                    <div id="chart-empty-state"
                        class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Silakan pilih anak pada dropdown untuk menampilkan grafik
                        </p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                            kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan.</p>
                    </div>

                    {{-- State: Data kosong untuk anak terpilih --}}
                    <div id="chart-no-data-state"
                        class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk anak ini</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping
                            untuk
                            menginput data perkembangan fisik pertama.</p>
                    </div>

                    {{-- State: Tahun dipilih tapi tidak ada data --}}
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
                                <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Personal Best Time</h4>
                                <div class="relative w-full h-[300px]">
                                    <canvas id="lineChartPBT"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan Free-text (Timeline untuk Kelas Belajar) --}}
                        <div id="freetext-container" class="hidden overflow-y-auto max-h-[400px] mt-4 space-y-4 pr-1 mb-6">
                            {{-- Diisi oleh JS --}}
                        </div>

                        {{-- Detail/Catatan Tambahan --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                            <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                </h4>
                                <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada evaluasi terakhir."</p>
                                <div id="latest-note-date" class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput pada: -</div>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                <h4
                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Info Latihan Anak
                                </h4>
                                <div class="space-y-1.5 text-xs text-gray-600">
                                    <div>Kelas: <span id="student-class" class="font-bold text-gray-800">-</span></div>
                                    <div>Pelatih: <span id="student-coach" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Lokasi: <span id="student-location" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Sisa Kuota: <span id="student-quota" class="font-bold text-blue-600">-</span>
                                    </div>
                                    <div id="student-schedule-container" class="hidden pt-1.5 mt-1.5 border-t border-gray-200">
                                        <span class="font-bold text-gray-500 block mb-1">Jadwal Latihan Aktif:</span>
                                        <div id="student-schedules" class="space-y-0.5 mb-3"></div>

                                        {{-- Info Pengajuan Pindah Jadwal Pending --}}
                                        <div id="student-pending-schedule-request" class="p-3 bg-amber-50/70 border border-amber-200 rounded-xl text-[11px] hidden">
                                            <div class="flex items-center gap-1.5 text-amber-800 font-bold mb-1">
                                                <i class="fa-solid fa-clock-rotate-left"></i> Pengajuan Pindah Jadwal (Pending)
                                            </div>
                                            <p class="text-slate-650 leading-relaxed mb-1">
                                                Menunggu persetujuan Admin untuk pindah ke jadwal berikut:
                                            </p>
                                            <div id="pending-schedules-list" class="space-y-1"></div>
                                            <p class="text-[9px] text-slate-400 mt-2 font-semibold" id="pending-request-date"></p>
                                        </div>

                                        {{-- Tombol Ajukan Pindah Jadwal --}}
                                        <div id="student-schedule-change-wrapper" class="mt-3">
                                            <button type="button" onclick="openScheduleRequestModal()"
                                                class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                                <i class="fa-solid fa-calendar-plus"></i> Ajukan Pindah Jadwal
                                            </button>
                                        </div>
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

    @if ($children->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data anak & perkembangan dari Laravel dijadikan object JS
                const childrenArray = @json($children);
                const childrenMap = {};
                childrenArray.forEach(function(c) {
                    childrenMap[String(c.id)] = c;
                });

                const selectDropdown = document.getElementById('chart_child_id');
                const yearDropdown = document.getElementById('chart_year_filter');
                const emptyState = document.getElementById('chart-empty-state');
                const noDataState = document.getElementById('chart-no-data-state');
                const yearEmptyState = document.getElementById('chart-year-empty-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');

                let myChart = null;
                let radarChartInst = null;
                let barChartInst = null;
                let lineChartPBTInst = null;
                let activeChild = null;
                let allReports = [];

                // Helper: sembunyikan semua state
                function hideAllStates() {
                    emptyState.classList.add('hidden');
                    noDataState.classList.add('hidden');
                    noDataState.style.display = '';
                    yearEmptyState.classList.add('hidden');
                    yearEmptyState.style.display = '';
                    chartContainer.classList.add('hidden');
                    chartContainer.style.display = '';
                }

                // Helper: hancurkan semua chart
                function destroyAllCharts() {
                    if (myChart) { myChart.destroy(); myChart = null; }
                    if (radarChartInst) { radarChartInst.destroy(); radarChartInst = null; }
                    if (barChartInst) { barChartInst.destroy(); barChartInst = null; }
                    if (lineChartPBTInst) { lineChartPBTInst.destroy(); lineChartPBTInst = null; }
                }

                // Fungsi helper ubah "01:25.50" jadi detik "85.5"
                function parseTimeToSeconds(timeStr) {
                    if (!timeStr) return null;
                    const match = String(timeStr).match(/(?:(\d+):)?(\d+)[.,:](\d+)/);
                    if (match) {
                        const m = parseInt(match[1] || 0);
                        const s = parseInt(match[2] || 0);
                        const ms = parseInt(match[3] || 0);
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

                // ====================================================
                // FUNGSI UTAMA: Render grafik berdasarkan tahun terpilih
                // ====================================================
                function renderChartsForYear(year) {
                    destroyAllCharts();

                    const reports = allReports;
                    const filteredReports = reports.filter(r => new Date(r.date).getFullYear() === year);

                    const freetextContainer = document.getElementById('freetext-container');
                    const prestasiContainer = document.getElementById('prestasi-charts-container');

                    // Cek apakah kelas Prestasi
                    const latestReportAll = reports[reports.length - 1];
                    const isPrestasi = latestReportAll && latestReportAll.metrics && ('Kondisi Fisik' in latestReportAll.metrics);

                    if (filteredReports.length === 0) {
                        // Tahun dipilih tapi tidak ada data
                        hideAllStates();
                        yearEmptyState.classList.remove('hidden');
                        yearEmptyState.style.display = 'flex';
                        document.getElementById('year-empty-title').textContent = `Belum ada data latihan di tahun ${year}`;
                        document.getElementById('year-empty-subtext').textContent = 'Pilih tahun lain atau tunggu hingga Coach menginput data perkembangan.';
                        return;
                    }

                    // Tampilkan container grafik
                    hideAllStates();
                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Update catatan terakhir (dari data di tahun ini)
                    const latestInYear = filteredReports[filteredReports.length - 1];
                    latestNoteText.textContent = latestInYear.notes ?
                        `"${latestInYear.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;
                    const ld = new Date(latestInYear.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}`;

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        // --- 1. Siapkan Data dari report tahun ini ---
                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };
                        const pbtData = { TestPerBulan: [], PbtEvent: [] };

                        filteredReports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short' }));

                            if (report.metrics) {
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                const se = report.metrics['Sistem Energi'] || {};
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);

                                const pbt = report.metrics['Personal Best Time'] || {};
                                pbtData.TestPerBulan.push(parseTimeToSeconds(pbt['Test per Bulan']));
                                pbtData.PbtEvent.push({
                                    val: parseTimeToSeconds(pbt['PBT Event']),
                                    raw: pbt['PBT Event']
                                });
                            }
                        });

                        const len = labels.length;

                        // --- 2. Radar Chart (Kondisi Fisik) — maks 2 titik terakhir ---
                        const latestLabels = ['Endurance', 'Fleksibilitas', 'Strength', 'Speed', 'Agility'];
                        const latestData = len > 0 ? [
                            radarData.Endurance[len-1], radarData.Fleksibilitas[len-1],
                            radarData.Strength[len-1], radarData.Speed[len-1], radarData.Agility[len-1]
                        ] : [];
                        const prevData = len > 1 ? [
                            radarData.Endurance[len-2], radarData.Fleksibilitas[len-2],
                            radarData.Strength[len-2], radarData.Speed[len-2], radarData.Agility[len-2]
                        ] : [];

                        const radarDatasets = [{
                            label: labels[len-1] || 'Terbaru',
                            data: latestData,
                            backgroundColor: 'rgba(37, 99, 235, 0.2)',
                            borderColor: 'rgb(37, 99, 235)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(37, 99, 235)'
                        }];
                        if (len > 1) {
                            radarDatasets.push({
                                label: labels[len-2] || 'Sebelumnya',
                                data: prevData,
                                backgroundColor: 'rgba(156, 163, 175, 0.2)',
                                borderColor: 'rgb(156, 163, 175)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgb(156, 163, 175)'
                            });
                        }
                        radarChartInst = new Chart(document.getElementById('radarChart').getContext('2d'), {
                            type: 'radar',
                            data: { labels: latestLabels, datasets: radarDatasets },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: { r: { min: 0, max: 100 } },
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });

                        // --- 3. Bar Chart (Sistem Energi) — langsung semua bulan di tahun ini ---
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

                        // --- 4. Line Chart (Personal Best Time) ---
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
                                data: pbtData.PbtEvent.map(e => e.val),
                                type: 'scatter',
                                pointBackgroundColor: 'rgb(245, 158, 11)',
                                pointBorderColor: 'rgb(255, 255, 255)',
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }
                        ];

                        lineChartPBTInst = new Chart(document.getElementById('lineChartPBT').getContext('2d'), {
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
                                        reverse: true,
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

                            const sortedReports = [...filteredReports].reverse();
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
                }

                // ====================================================
                // EVENT: Pilih Anak → populate dropdown tahun
                // ====================================================
                selectDropdown.addEventListener('change', function() {
                    const childId = String(this.value);
                    const child = childrenMap[childId];
                    if (!child) return;

                    activeChild = child;

                    // Info anak
                    document.getElementById('student-class').textContent = child.swimming_class ?
                        `${child.swimming_class.name} (${child.swimming_class.category.name})` :
                        'Belum Ditentukan';
                    document.getElementById('student-coach').textContent = child.coach ? child.coach.name :
                        'Belum Ditugaskan';

                    let locText = child.location ? child.location.name : 'Belum Dipilih';
                    if (child.secondary_location) {
                        locText += ` & ${child.secondary_location.name}`;
                    }
                    document.getElementById('student-location').textContent = locText;
                    document.getElementById('student-quota').textContent = `${child.quota_left} sesi`;

                    // Update schedules
                    const schedulesContainer = document.getElementById('student-schedule-container');
                    const schedulesDiv = document.getElementById('student-schedules');
                    schedulesDiv.innerHTML = '';

                    if (child.schedules && child.schedules.length > 0) {
                        schedulesContainer.classList.remove('hidden');
                        const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        child.schedules.forEach(sched => {
                            const dayName = days[sched.day_of_week] || 'Hari Tidak Valid';
                            const timeRange = `${sched.start_time.substring(0, 5)} - ${sched.end_time.substring(0, 5)}`;
                            const locName = sched.location ? sched.location.name : 'Lokasi tidak diketahui';
                            const type = sched.session_type === 'dryland' ? 'Dryland' : 'Berenang';

                            const div = document.createElement('div');
                            div.className = 'bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-700 font-bold">${dayName}, ${timeRange}</span>
                                    <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded">${type}</span>
                                </div>
                                <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot"></i> ${locName}
                                </div>
                            `;
                            schedulesDiv.appendChild(div);
                        });
                    } else {
                        schedulesContainer.classList.add('hidden');
                    }

                    // Update pending schedule-change-request info
                    const pendingBox       = document.getElementById('student-pending-schedule-request');
                    const pendingListDiv   = document.getElementById('pending-schedules-list');
                    const pendingDateEl    = document.getElementById('pending-request-date');
                    const changeWrapper    = document.getElementById('student-schedule-change-wrapper');

                    const pendingReq = child.schedule_change_requests && child.schedule_change_requests.find(r => r.status === 'pending');

                    if (pendingReq) {
                        pendingBox.classList.remove('hidden');
                        changeWrapper.classList.add('hidden');
                        pendingListDiv.innerHTML = '';

                        const newIds = pendingReq.new_schedule_ids || [];
                        const allSchedules = @json($schedules);
                        const days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

                        newIds.forEach(sid => {
                            const s = allSchedules.find(x => x.id == sid);
                            if (s) {
                                const dayName  = days[s.day_of_week] || 'Hari ?';
                                const timeRange = `${s.start_time.substring(0,5)} - ${s.end_time.substring(0,5)}`;
                                const locName  = s.location ? s.location.name : 'Lokasi ?';
                                const type     = s.session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                const el = document.createElement('div');
                                el.className = 'bg-white border border-amber-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5';
                                el.innerHTML = `<div class="flex justify-between items-center"><span class="text-amber-700 font-bold">${dayName}, ${timeRange}</span><span class="px-1 py-0.2 text-[9px] bg-amber-50 text-amber-600 rounded">${type}</span></div><div class="text-[10px] text-gray-500 flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> ${locName}</div>`;
                                pendingListDiv.appendChild(el);
                            }
                        });

                        const reqDate = new Date(pendingReq.created_at);
                        pendingDateEl.textContent = `Diajukan: ${reqDate.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' })}`;
                    } else {
                        pendingBox.classList.add('hidden');
                        changeWrapper.classList.remove('hidden');
                    }

                    // Simpan child id aktif untuk modal
                    window.activeChildId = childId;

                    allReports = child.progress_reports || [];

                    // Jika TIDAK ada data perkembangan sama sekali
                    if (allReports.length === 0) {
                        hideAllStates();
                        noDataState.classList.remove('hidden');
                        noDataState.style.display = 'flex';
                        document.getElementById('no-data-subtext').textContent =
                            `Hubungi Coach pendamping untuk menginput data perkembangan fisik pertama.`;
                        yearDropdown.disabled = true;
                        yearDropdown.innerHTML = '<option value="" disabled selected>-- Tahun --</option>';
                        return;
                    }

                    // Populate dropdown tahun (descending)
                    const years = [...new Set(allReports.map(r => new Date(r.date).getFullYear()))].sort((a, b) => b - a);
                    yearDropdown.innerHTML = '';
                    years.forEach((y, i) => {
                        const opt = document.createElement('option');
                        opt.value = y;
                        opt.textContent = y;
                        if (i === 0) opt.selected = true; // Tahun terbaru default
                        yearDropdown.appendChild(opt);
                    });
                    yearDropdown.disabled = false;

                    // Langsung render tahun terbaru
                    renderChartsForYear(years[0]);
                });

                // ====================================================
                // EVENT: Pilih Tahun → re-render grafik
                // ====================================================
                yearDropdown.addEventListener('change', function() {
                    const selectedYear = parseInt(this.value);
                    if (!isNaN(selectedYear)) {
                        renderChartsForYear(selectedYear);
                    }
                });

                // Auto-select anak pertama jika ada
                @if ($children->isNotEmpty())
                    selectDropdown.value = "{{ $children->first()->id }}";
                    selectDropdown.dispatchEvent(new Event('change'));
                @endif
            });
        </script>
    @endif

    {{-- Modal Pengajuan Pindah Jadwal --}}
    @if ($children->isNotEmpty())
        <div id="schedule-request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none!important" x-data>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeScheduleRequestModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col" style="max-height: 90vh;">
                {{-- Header (tetap di atas) --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <i class="fa-solid fa-calendar-plus text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Ajukan Pindah Jadwal & Lokasi</h3>
                            <p class="text-blue-100 text-xs" id="modal-child-name">Anak</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeScheduleRequestModal()" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form id="schedule-request-form" method="POST" action="" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    {{-- Scrollable Body --}}
                    <div class="overflow-y-auto flex-1 p-6 space-y-5" style="scrollbar-width: thin;">

                        {{-- Jadwal Saat Ini --}}
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-check text-gray-400"></i> Jadwal Aktif Saat Ini
                            </h4>
                            <div id="modal-current-schedules" class="space-y-1.5 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-xl p-3">
                                <p class="text-gray-400 italic text-center">Memuat jadwal...</p>
                            </div>
                        </div>

                        {{-- Lokasi Saat Ini --}}
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-gray-400"></i> Lokasi Latihan Saat Ini
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Utama</p>
                                    <p id="modal-current-location" class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-blue-500"></i>
                                        <span>—</span>
                                    </p>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Kedua</p>
                                    <p id="modal-current-sec-location" class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-indigo-500"></i>
                                        <span>—</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        {{-- Pilih Jadwal Baru --}}
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-plus text-blue-500"></i> Pilih Jadwal Baru
                                <span class="text-red-500">*</span>
                            </label>
                            <p class="text-[11px] text-gray-400 mb-2">Centang semua jadwal yang diinginkan (bisa lebih dari satu).</p>
                            <div id="modal-schedules-list" class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 bg-gray-50 border border-gray-200 rounded-xl" style="max-height: 200px; overflow-y: auto; scrollbar-width: thin;">
                                @foreach($schedules as $sched)
                                    @php
                                        $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                                        $dayName = $days[$sched->day_of_week] ?? '?';
                                        $timeRange = substr($sched->start_time,0,5).' - '.substr($sched->end_time,0,5);
                                        $type = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                    @endphp
                                    <label data-class-id="{{ $sched->swimming_class_id }}" class="schedule-checkbox-item flex items-start gap-2.5 p-2 bg-white border border-gray-100 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50/50 transition-colors">
                                        <input type="checkbox" name="schedule_ids[]" value="{{ $sched->id }}"
                                            class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-1">
                                                <span class="text-[11px] font-bold text-gray-800 truncate">{{ $dayName }}, {{ $timeRange }}</span>
                                                <span class="text-[8px] px-1 py-0.2 rounded font-semibold shrink-0 {{ $sched->session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">{{ $type }}</span>
                                            </div>
                                            <div class="text-[9px] text-gray-500 flex items-center gap-1 mt-0.5 truncate">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span class="truncate">{{ $sched->location->name ?? '?' }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Alasan Pindah --}}
                        <div>
                            <label for="schedule-reason" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-to-square text-gray-400"></i> Alasan Pindah <span class="text-red-500">*</span>
                            </label>
                            <textarea id="schedule-reason" name="reason" rows="3" required
                                placeholder="Tuliskan alasan Anda ingin pindah jadwal/lokasi..."
                                class="w-full text-sm rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 resize-none"></textarea>
                        </div>

                    </div>

                    {{-- Footer (tetap di bawah) --}}
                    <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex-shrink-0">
                        <button type="button" onclick="closeScheduleRequestModal()"
                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const allSchedulesData = @json($schedules);
            const daysMap = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

            function openScheduleRequestModal() {
                const childId = window.activeChildId;
                if (!childId) return;

                const childrenArr = @json($children->load('schedules.location', 'location', 'secondaryLocation'));
                const child = childrenArr.find(c => String(c.id) === String(childId));
                if (!child) return;

                // Update form action
                const form = document.getElementById('schedule-request-form');
                form.action = `/parent/schedule-requests/store/${child.id}`;

                // Set child name in modal header
                document.getElementById('modal-child-name').textContent = child.name;

                // Tampilkan jadwal aktif saat ini
                const currentDiv = document.getElementById('modal-current-schedules');
                currentDiv.innerHTML = '';
                if (child.schedules && child.schedules.length > 0) {
                    child.schedules.forEach(s => {
                        const dayName  = daysMap[s.day_of_week] || '?';
                        const tr       = `${s.start_time.substring(0,5)} - ${s.end_time.substring(0,5)}`;
                        const locName  = s.location ? s.location.name : 'Lokasi ?';
                        const type     = s.session_type === 'dryland' ? 'Dryland' : 'Berenang';
                        const tag      = s.session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700';
                        const el = document.createElement('div');
                        el.className = 'flex items-center justify-between py-1';
                        el.innerHTML = `<span class="font-semibold text-gray-800">${dayName}, ${tr} — <span class="text-gray-500">${locName}</span></span><span class="text-[9px] px-1.5 py-0.5 rounded ${tag}">${type}</span>`;
                        currentDiv.appendChild(el);
                    });
                } else {
                    currentDiv.innerHTML = '<p class="text-gray-400 italic text-center text-xs">Tidak ada jadwal aktif.</p>';
                }

                // Tampilkan lokasi latihan saat ini
                const locEl = document.getElementById('modal-current-location');
                const secLocEl = document.getElementById('modal-current-sec-location');
                locEl.innerHTML = `<i class="fa-solid fa-building text-blue-500"></i><span>${child.location ? child.location.name : 'Belum diatur'}</span>`;
                secLocEl.innerHTML = `<i class="fa-solid fa-building text-indigo-500"></i><span>${child.secondary_location ? child.secondary_location.name : 'Tidak ada'}</span>`;

                // Filter daftar jadwal baru berdasarkan swimming_class_id milik anak
                const childClassId = child.swimming_class_id;
                const items = document.querySelectorAll('.schedule-checkbox-item');
                let visibleCount = 0;
                items.forEach(item => {
                    if (String(item.getAttribute('data-class-id')) === String(childClassId)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Tampilkan pesan jika tidak ada jadwal baru tersedia untuk kelas anak ini
                let noSchedMsg = document.getElementById('no-schedules-message');
                if (visibleCount === 0) {
                    if (!noSchedMsg) {
                        noSchedMsg = document.createElement('p');
                        noSchedMsg.id = 'no-schedules-message';
                        noSchedMsg.className = 'text-gray-400 italic text-center text-xs py-4 col-span-full';
                        noSchedMsg.textContent = 'Tidak ada jadwal latihan tersedia untuk tingkat kelas anak ini.';
                        document.getElementById('modal-schedules-list').appendChild(noSchedMsg);
                    } else {
                        noSchedMsg.style.display = 'block';
                    }
                } else if (noSchedMsg) {
                    noSchedMsg.style.display = 'none';
                }

                // Reset form state
                form.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
                document.getElementById('schedule-reason').value = '';
                document.getElementById('par-new-location').value = '';
                document.getElementById('par-new-sec-location').value = '';

                // Tampilkan modal
                const modal = document.getElementById('schedule-request-modal');
                modal.style.removeProperty('display');
                modal.style.display = 'flex';
            }


            function closeScheduleRequestModal() {
                document.getElementById('schedule-request-modal').style.display = 'none';
            }
        </script>
    @endif

</x-app-layout>
