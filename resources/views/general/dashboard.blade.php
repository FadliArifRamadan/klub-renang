<x-app-layout title="Umum - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                    Selamat datang di portal anggota Black Diamond. Pantau perkembangan latihan Anda
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
                                    Sesi Latihan Anda Telah Habis!
                                </h4>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Seluruh kuota sesi latihan Anda telah terpakai. Silakan lakukan daftar ulang paket latihan di bawah ini.
                                </p>
                                <div class="mt-3 space-y-2 max-w-2xl">
                                    @foreach ($expiredStudents as $expStudent)
                                        <div class="flex flex-wrap items-center gap-2 bg-white/60 border border-amber-200 rounded-lg px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-user text-amber-500"></i>
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
                                            <form method="POST" action="{{ route('general.students.renew', $expStudent->id) }}" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{ 
                                                    packageId: '{{ $expStudent->package_id }}',
                                                    packages: {{ $packages->toJson() }},
                                                    getPrice() {
                                                        const pkg = this.packages.find(p => p.id == this.packageId);
                                                        return pkg ? pkg.price : 0;
                                                    },
                                                    formatPrice(price) {
                                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
                                                    }
                                                }">
                                                @csrf

                                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                    <i class="fa-solid fa-rotate-right text-amber-500"></i>
                                                    Daftar Ulang Paket Latihan - {{ $expStudent->name }}
                                                </h3>

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
                                                    <select id="location-{{ $expStudent->id }}" name="location_id" required
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
                                                                {{ $pkg->name }} ({{ $pkg->sessions }} Sesi - Rp {{ number_format($pkg->price, 0, ',', '.') }})
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

            {{-- Metrics Grid (Non-Clickable untuk General) --}}
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
                            Grafik Catatan Perkembangan Saya
                        </h3>
                        <p class="text-xs text-gray-500">Visualisasi perkembangan fisik Anda berdasarkan catatan dari
                            pelatih.</p>
                    </div>
                    {{-- Tidak ada dropdown — grafik langsung milik akun sendiri --}}
                </div>

                @if (!$myStudent)
                    {{-- Belum terdaftar sebagai murid --}}
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-person-swimming text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Anda belum terdaftar di program latihan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Daftarkan diri Anda terlebih dahulu untuk mulai
                            memantau perkembangan latihan.</p>
                        <a href="{{ route('general.students.create') }}"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-plus"></i> Daftar Sekarang
                        </a>
                    </div>
                @elseif ($myStudent->progressReports->isEmpty())
                    {{-- Sudah terdaftar tapi belum ada catatan perkembangan --}}
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">
                            Hubungi Coach pendamping
                            <span
                                class="font-semibold text-gray-600">({{ $myStudent->coach->name ?? 'Belum Ditugaskan' }})</span>
                            untuk menginput data perkembangan fisik pertama Anda.
                        </p>
                    </div>
                @else
                    {{-- Ada data perkembangan — langsung tampilkan grafik --}}
                    <div class="flex flex-col">
                        {{-- Canvas Chart.js --}}
                        <div class="relative w-full h-[360px] mb-6">
                            <canvas id="progressChart"></canvas>
                        </div>

                        {{-- Detail / Catatan Tambahan --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                            <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                </h4>
                                @php $latestReport = $myStudent->progressReports->last(); @endphp
                                <p class="text-sm text-gray-600 italic">
                                    "{{ $latestReport->notes ?? 'Tidak ada catatan pada evaluasi terakhir.' }}"
                                </p>
                                <div class="text-[10px] text-gray-400 mt-2 font-semibold">
                                    Diinput pada: {{ $latestReport->date->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                <h4
                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Info Latihan Saya
                                </h4>
                                <div class="space-y-1.5 text-xs text-gray-600">
                                    <div>Pelatih: <span
                                            class="font-bold text-gray-800">{{ $myStudent->coach->name ?? 'Belum Ditugaskan' }}</span>
                                    </div>
                                    <div>Lokasi: <span
                                            class="font-bold text-gray-800">{{ $myStudent->location->name ?? 'Belum Dipilih' }}</span>
                                    </div>
                                    <div>Sisa Kuota: <span class="font-bold text-blue-600">{{ $myStudent->quota_left }}
                                            sesi</span></div>
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

    @if ($myStudent && $myStudent->progressReports->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reports = @json($myStudent->progressReports);

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

                const ctx = document.getElementById('progressChart').getContext('2d');
                new Chart(ctx, {
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
        </script>
    @endif

</x-app-layout>
