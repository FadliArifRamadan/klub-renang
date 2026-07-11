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
                                        {{-- Modal Daftar Ulang --}}
                                        <x-modal name="renew-student-{{ $expStudent->id }}" maxWidth="2xl" focusable>
                                            <form method="POST" action="{{ route('general.students.renew', $expStudent->id) }}" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{
                                                    allPackages: {{ $packages->toJson() }},
                                                    allSchedules: {{ $schedules->toJson() }},
                                                    classId: '{{ $expStudent->swimming_class_id }}',
                                                    locationId: '{{ $expStudent->location_id }}',
                                                    secondaryLocationId: '{{ $expStudent->secondary_location_id }}',
                                                    packageId: '{{ $expStudent->package_id }}',
                                                    selectedScheduleIds: {{ $expStudent->schedules->pluck('id')->map(fn($id) => (string)$id)->toJson() }},
                                                    shouldPayRegFee: {{ $expStudent->shouldPayRegistrationFee() ? 'true' : 'false' }},

                                                    get filteredPackages() {
                                                        if (!this.classId) return [];
                                                        return this.allPackages.filter(p => p.swimming_class_id == this.classId);
                                                    },
                                                    get filteredSchedules() {
                                                        if (!this.classId) return [];
                                                        let schedules = this.allSchedules.filter(s => s.swimming_class_id == this.classId);
                                                        if (this.locationId) {
                                                            const locIds = [this.locationId];
                                                            if (this.secondaryLocationId) locIds.push(this.secondaryLocationId);
                                                            schedules = schedules.filter(s => locIds.includes(String(s.location_id)));
                                                        }
                                                        return schedules;
                                                    },
                                                    get showSecondaryLocation() {
                                                        if (!this.packageId) return false;
                                                        const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                        return pkg && pkg.sessions >= 8 && pkg.is_location_based;
                                                    },
                                                    get calculatedPrice() {
                                                        const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                        if (!pkg) return 0;
                                                        if (pkg.is_location_based && this.locationId) {
                                                            const lp = (pkg.location_prices || []).find(l => l.location_id == this.locationId);
                                                            return lp ? lp.price : 0;
                                                        }
                                                        return pkg.price || 0;
                                                    },
                                                    get totalAmount() {
                                                        let total = this.calculatedPrice;
                                                        if (this.shouldPayRegFee) total += 30000;
                                                        return total;
                                                    },
                                                    onLocationChange() {
                                                        this.selectedScheduleIds = [];
                                                        this.secondaryLocationId = '';
                                                    },
                                                    onPackageChange() {
                                                        if (!this.showSecondaryLocation) this.secondaryLocationId = '';
                                                    },
                                                    toggleSchedule(schedId) {
                                                        const id = String(schedId);
                                                        const idx = this.selectedScheduleIds.indexOf(id);
                                                        if (idx > -1) this.selectedScheduleIds.splice(idx, 1);
                                                        else this.selectedScheduleIds.push(id);
                                                    },
                                                    formatPrice(val) {
                                                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                                                    },
                                                    getDayName(d) {
                                                        return ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'][d] || '-';
                                                    },
                                                    formatTime(t) { return t ? t.substring(0,5) : ''; }
                                                }">
                                                @csrf
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

                                                <!-- Tempat Latihan Utama -->
                                                <div class="mb-4">
                                                    <x-input-label for="location-{{ $expStudent->id }}" value="Pilih Tempat Latihan Utama" />
                                                    <select id="location-{{ $expStudent->id }}" name="location_id" x-model="locationId" @change="onLocationChange()" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="">-- Pilih Kolam Renang --</option>
                                                        @foreach ($locations as $loc)
                                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Paket Kursus (filtered by class) -->
                                                <div class="mb-4">
                                                    <x-input-label for="package-{{ $expStudent->id }}" value="Pilih Paket Kursus" />
                                                    <select id="package-{{ $expStudent->id }}" name="package_id" x-model="packageId" @change="onPackageChange()" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="">-- Pilih Paket Latihan --</option>
                                                        <template x-for="pkg in filteredPackages" :key="pkg.id">
                                                            <option :value="pkg.id" :selected="pkg.id == packageId" x-text="pkg.name + ' — ' + formatPrice(pkg.is_location_based ? ((pkg.location_prices || []).find(l => l.location_id == locationId)?.price || 0) : (pkg.price || 0)) + ' (' + pkg.sessions + 'x Pertemuan)'"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                <!-- Lokasi Kedua (opsional, paket >= 8 sesi) -->
                                                <div class="mb-4" x-show="showSecondaryLocation" x-transition>
                                                    <x-input-label value="Pilih Tempat Latihan Kedua (Opsional, Paket 8 Sesi)" />
                                                    <select name="secondary_location_id" x-model="secondaryLocationId"
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="">-- Tidak Perlu / Sama Dengan Lokasi Utama --</option>
                                                        @foreach ($locations as $loc)
                                                            <option value="{{ $loc->id }}" x-bind:disabled="locationId == '{{ $loc->id }}'">{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-gray-400 mt-1 block">*Untuk paket 8 pertemuan, Anda bisa memilih 2 lokasi berbeda.</small>
                                                </div>

                                                <!-- Jadwal Latihan -->
                                                <div class="mb-4" x-show="filteredSchedules.length > 0" x-transition>
                                                    <x-input-label value="Pilih Jadwal Latihan" />
                                                    <p class="text-xs text-gray-400 mb-2">Centang jadwal latihan yang diinginkan.</p>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 overflow-y-auto pr-1">
                                                        <template x-for="sched in filteredSchedules" :key="sched.id">
                                                            <label class="flex items-center gap-2.5 p-3 border rounded-lg cursor-pointer transition-all duration-100 text-sm"
                                                                :class="selectedScheduleIds.includes(String(sched.id)) ? 'border-blue-400 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                                                <input type="checkbox" name="schedule_ids[]" :value="sched.id"
                                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                                    @change="toggleSchedule(sched.id)"
                                                                    :checked="selectedScheduleIds.includes(String(sched.id))" />
                                                                <div>
                                                                    <span class="font-semibold text-gray-700" x-text="getDayName(sched.day_of_week)"></span>
                                                                    <span class="text-gray-500" x-text="formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                                                    <span class="text-[10px] ml-1 px-1.5 py-0.5 rounded-full font-bold"
                                                                        :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                                        x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                                    <span class="block text-[10px] text-gray-400" x-text="sched.location?.name || ''"></span>
                                                                </div>
                                                            </label>
                                                        </template>
                                                    </div>
                                                </div>

                                                <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs"
                                                    x-show="filteredSchedules.length === 0 && locationId" x-transition>
                                                    <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                                    <strong>Tidak Ada Jadwal:</strong> Belum ada jadwal latihan yang tersedia untuk kelas dan lokasi terpilih.
                                                </div>

                                                <!-- Ringkasan Pembayaran -->
                                                <div class="mb-4" x-show="packageId" x-transition>
                                                    <div class="bg-gradient-to-br from-slate-50 to-blue-50 border border-blue-100 rounded-xl p-4 shadow-sm">
                                                        <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                                            <i class="fa-solid fa-calculator text-blue-500"></i> Ringkasan Pembayaran
                                                        </h4>
                                                        <div class="space-y-2 text-sm">
                                                            <div class="flex justify-between">
                                                                <span class="text-gray-500">Paket Kursus</span>
                                                                <span class="font-semibold text-gray-800" x-text="formatPrice(calculatedPrice)"></span>
                                                            </div>
                                                            <div class="flex justify-between" x-show="shouldPayRegFee">
                                                                <span class="text-gray-500">Biaya Pendaftaran <span class="text-[10px]">(> 3 bulan tidak aktif)</span></span>
                                                                <span class="font-semibold text-gray-800">Rp 30.000</span>
                                                            </div>
                                                            <hr class="border-blue-200 !my-3" />
                                                            <div class="flex justify-between text-base">
                                                                <span class="font-bold text-gray-800">Total Bayar</span>
                                                                <span class="font-extrabold text-blue-600 text-lg" x-text="formatPrice(totalAmount)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Info Rekening -->
                                                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-4 text-xs text-blue-800">
                                                    <p class="font-bold text-sm mb-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Informasi Pembayaran</p>
                                                    <p>Silakan transfer nominal ke rekening berikut:</p>
                                                    <p class="font-extrabold text-gray-900 mt-1">Bank BCA: 123-4567-890 (a.n. Klub Renang)</p>
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
                                                        x-bind:disabled="!packageId || selectedScheduleIds.length === 0"
                                                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-xs uppercase tracking-widest rounded-md shadow-sm transition">
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
                    @if ($myStudent && $myStudent->progressReports->isNotEmpty())
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
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
                                                    untuk menginput data perkembangan pertama Anda.
                                                </p>
                                            </div>
                                        @else
                                            {{-- State: Tahun kosong --}}
                                            <div id="chart-year-empty-state"
                                                class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                                                <i class="fa-regular fa-calendar-xmark text-6xl mb-4 text-gray-200"></i>
                                                <p class="font-medium text-gray-800 dark:text-white/90 text-lg" id="year-empty-title">Belum ada data latihan di tahun ini</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-sm" id="year-empty-subtext">Pilih tahun lain atau tunggu hingga Coach menginput data perkembangan.</p>
                                            </div>

                                            {{-- State: Data kosong --}}
                                            <div id="chart-no-data-state"
                                                class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                                                <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                                                <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk murid ini</p>
                                                <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping untuk menginput data perkembangan fisik pertama.</p>
                                            </div>

                                            {{-- Container Grafik & Detail Perkembangan --}}
                                            <div id="chart-container" class="hidden flex-1 flex-col min-w-0 overflow-hidden">
                                                {{-- Container Prestasi (3 Grafik) --}}
                                                <div id="prestasi-charts-container" class="hidden flex-col space-y-8 w-full mt-4 min-w-0">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                            <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Kondisi Fisik</h4>
                                                            <div class="relative w-full h-[250px]">
                                                                <canvas id="radarChart"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                            <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Sistem Energi</h4>
                                                            <div class="relative w-full h-[250px]">
                                                                <canvas id="barChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                         <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-2">
                                                             <h4 class="text-sm font-bold text-slate-700 flex items-center gap-1"><i class="fa-solid fa-stopwatch text-indigo-500"></i> Personal Best Time</h4>
                                                             <div class="w-full sm:w-60">
                                                                 <select id="pbt_filter_selector" class="w-full text-xs rounded-md border-gray-300 shadow-sm text-gray-900 font-semibold bg-white py-1 max-w-full truncate">
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
                                                <div id="freetext-container" class="hidden mt-4 mb-6 min-w-0">
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
                                                        <p id="latest-note" class="text-sm text-gray-600 italic break-words whitespace-pre-wrap">"Tidak ada catatan pada evaluasi terakhir."</p>
                                                        <div id="latest-note-date" class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput pada: -</div>
                                                    </div>

                                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                                        <h4
                                                            class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                            <i class="fa-solid fa-circle-info"></i> Info Latihan Saya
                                                        </h4>
                                                        <div class="space-y-1.5 text-xs text-gray-600">
                                                            <div>Kelas: <span class="font-bold text-gray-800">{{ $myStudent->swimmingClass->name ?? 'Belum Ditentukan' }} {{ isset($myStudent->swimmingClass->category) ? '(' . $myStudent->swimmingClass->category->name . ')' : '' }}</span></div>
                                                            <div>Pelatih: <span class="font-bold text-gray-800">{{ $myStudent->coach->name ?? 'Belum Ditugaskan' }}</span></div>
                                                            <div>Lokasi: <span class="font-bold text-gray-800">{{ $myStudent->location->name ?? 'Belum Dipilih' }}@if($myStudent->secondaryLocation) & {{ $myStudent->secondaryLocation->name }}@endif</span></div>
                                                            <div>Sisa Kuota: <span class="font-bold text-blue-600">{{ $myStudent->quota_left }} sesi</span></div>
                                                            @if($myStudent->schedules && $myStudent->schedules->isNotEmpty())
                                                                <div class="pt-1.5 mt-1.5 border-t border-gray-200">
                                                                    <span class="font-bold text-gray-500 block mb-1">Jadwal Aktif:</span>
                                                                    <div class="space-y-1">
                                                                        @foreach($myStudent->schedules as $sched)
                                                                            @php
                                                                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                                                                $dayName = $days[$sched->day_of_week] ?? 'Hari Tidak Valid';
                                                                                $timeRange = substr($sched->start_time, 0, 5) . ' - ' . substr($sched->end_time, 0, 5);
                                                                                $type = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                                            @endphp
                                                                            <div class="bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5">
                                                                                <div class="flex justify-between items-center">
                                                                                    <span class="text-blue-700 font-bold">{{ $dayName }}, {{ $timeRange }}</span>
                                                                                    <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded">{{ $type }}</span>
                                                                                </div>
                                                                                <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                                    <i class="fa-solid fa-location-dot"></i> {{ $sched->location->name ?? 'Lokasi tidak diketahui' }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    @php
                                                                        $pendingReq = $myStudent->scheduleChangeRequests->where('status','pending')->first();
                                                                    @endphp

                                                                    {{-- Info Pengajuan Pending --}}
                                                                    @if($pendingReq)
                                                                        <div class="mt-2 p-3 bg-amber-50/70 border border-amber-200 rounded-xl text-[11px]">
                                                                            <div class="flex items-center gap-1.5 text-amber-800 font-bold mb-1">
                                                                                <i class="fa-solid fa-clock-rotate-left"></i> Pengajuan Pindah Jadwal (Pending)
                                                                            </div>
                                                                            <p class="text-slate-600 leading-relaxed mb-1">Menunggu persetujuan Admin untuk pindah ke jadwal berikut:</p>
                                                                            <div class="space-y-1">
                                                                                @foreach($pendingReq->new_schedule_ids as $newId)
                                                                                    @php $newSched = $schedules->firstWhere('id', $newId); @endphp
                                                                                    @if($newSched)
                                                                                        @php
                                                                                            $nd = $days[$newSched->day_of_week] ?? '?';
                                                                                            $ntr = substr($newSched->start_time,0,5).' - '.substr($newSched->end_time,0,5);
                                                                                            $nType = $newSched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                                                        @endphp
                                                                                        <div class="bg-white border border-amber-100 rounded p-1.5 flex flex-col gap-0.5">
                                                                                            <div class="flex justify-between items-center">
                                                                                                <span class="text-amber-700 font-bold">{{ $nd }}, {{ $ntr }}</span>
                                                                                                <span class="px-1 text-[9px] bg-amber-50 text-amber-600 rounded">{{ $nType }}</span>
                                                                                            </div>
                                                                                            <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                                                <i class="fa-solid fa-location-dot"></i> {{ $newSched->location->name ?? '?' }}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <p class="text-[9px] text-slate-400 mt-1.5 font-semibold">Diajukan: {{ $pendingReq->created_at->translatedFormat('d F Y') }}</p>
                                                                        </div>
                                                                    @else
                                                                        {{-- Tombol Ajukan Pindah Jadwal --}}
                                                                        <div class="mt-3">
                                                                            <button type="button" onclick="openScheduleRequestModal()"
                                                                                class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                                                                <i class="fa-solid fa-calendar-plus"></i> Ajukan Pindah Jadwal
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    @endif
            </div>

        </div>
    {{-- Import Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if ($myStudent && $myStudent->progressReports->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearDropdown = document.getElementById('chart_year_filter');
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
                
                const allReports = @json($myStudent->progressReports);

                // Helper: ubah "01:25.50" jadi detik "85.5"
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

                function hideAllStates() {
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

                    const filteredReports = allReports.filter(r => new Date(r.date).getFullYear() === parseInt(year));

                    if (filteredReports.length === 0) {
                        yearEmptyState.classList.remove('hidden');
                        yearEmptyState.style.display = 'flex';
                        return;
                    }

                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Update catatan terakhir
                    const latestReport = filteredReports[filteredReports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;

                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}`;

                    const isPrestasi = allReports.some(r => r.metrics && ('Personal Best Time' in r.metrics));

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };

                        let hasKondisiFisik = false;
                        let hasSistemEnergi = false;

                        filteredReports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short' }));

                            if (report.metrics) {
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                if (Object.keys(kf).length > 0) hasKondisiFisik = true;
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                const se = report.metrics['Sistem Energi'] || {};
                                if (Object.keys(se).length > 0) hasSistemEnergi = true;
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);
                            }
                        });

                        const kondisiFisikEl = document.getElementById('radarChart').closest('.bg-slate-50, .bg-gray-50, .rounded-xl');
                        const sistemEnergiEl = document.getElementById('barChart').closest('.bg-slate-50, .bg-gray-50, .rounded-xl');
                        const chartsGridEl = kondisiFisikEl.parentElement;

                        if (hasKondisiFisik) kondisiFisikEl.style.display = '';
                        else kondisiFisikEl.style.display = 'none';

                        if (hasSistemEnergi) sistemEnergiEl.style.display = '';
                        else sistemEnergiEl.style.display = 'none';

                        if (!hasKondisiFisik && !hasSistemEnergi) chartsGridEl.style.display = 'none';
                        else chartsGridEl.style.display = '';

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
                        }

                        if (hasSistemEnergi) {
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
                                        if (!pbtCombinations.includes(key)) pbtCombinations.push(key);
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

                                if (pbtCombinations.includes(oldSelectedVal)) pbtSelector.value = oldSelectedVal;
                                else pbtSelector.value = pbtCombinations[0];
                            }
                            pbtSelector.onchange = null;
                            pbtSelector.addEventListener('change', updateLineChartPBT);
                        }

                        function updateLineChartPBT() {
                            if (lineChartPBTInst) { lineChartPBTInst.destroy(); lineChartPBTInst = null; }
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

                        updateLineChartPBT();

                    } else {
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

                                if (idx === 0) showMonthDetail(report, btn);
                            });
                        }
                    }
                }

                if (allReports.length === 0) {
                    hideAllStates();
                    noDataState.classList.remove('hidden');
                    noDataState.style.display = 'flex';
                    yearDropdown.disabled = true;
                    yearDropdown.innerHTML = '<option value="" disabled selected>-- Tahun --</option>';
                    return;
                }

                const yearsSet = new Set();
                allReports.forEach(r => {
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
                yearDropdown.value = years[0];

                renderChartsForYear(years[0]);

                yearDropdown.addEventListener('change', function() {
                    if (this.value) renderChartsForYear(this.value);
                });
            });
        </script>
    @endif

    {{-- Modal Pengajuan Pindah Jadwal (General) --}}
    @if ($myStudent)
        <div id="schedule-request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
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
                            <p class="text-blue-100 text-xs">{{ $myStudent->name }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeScheduleRequestModal()" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                {{-- Scrollable Body --}}
                <form method="POST" action="{{ route('general.schedule-requests.store', $myStudent->id) }}" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    <div class="overflow-y-auto flex-1 p-6 space-y-5" style="scrollbar-width: thin;">

                        {{-- Jadwal Saat Ini --}}
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-check text-gray-400"></i> Jadwal Aktif Saat Ini
                            </h4>
                            <div class="space-y-1.5 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-xl p-3">
                                @if($myStudent->schedules->isNotEmpty())
                                    @foreach($myStudent->schedules as $curSched)
                                        @php
                                            $cdDays = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                                            $cdName = $cdDays[$curSched->day_of_week] ?? '?';
                                            $cdTime = substr($curSched->start_time,0,5).' - '.substr($curSched->end_time,0,5);
                                            $cdType = $curSched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                            $cdTag  = $curSched->session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700';
                                        @endphp
                                        <div class="flex items-center justify-between py-1">
                                            <span class="font-semibold text-gray-800">{{ $cdName }}, {{ $cdTime }} — <span class="text-gray-500">{{ $curSched->location->name ?? '?' }}</span></span>
                                            <span class="text-[9px] px-1.5 py-0.5 rounded {{ $cdTag }}">{{ $cdType }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-400 italic text-center text-xs">Tidak ada jadwal aktif.</p>
                                @endif
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
                                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-blue-500"></i>
                                        {{ $myStudent->location->name ?? 'Belum diatur' }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Kedua</p>
                                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-indigo-500"></i>
                                        {{ $myStudent->secondaryLocation->name ?? 'Tidak ada' }}
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 bg-gray-50 border border-gray-200 rounded-xl" style="max-height: 200px; overflow-y: auto; scrollbar-width: thin;">
                                @foreach($schedules as $sched)
                                    @php
                                        $ssDays = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                                        $ssDayName = $ssDays[$sched->day_of_week] ?? '?';
                                        $ssTime = substr($sched->start_time,0,5).' - '.substr($sched->end_time,0,5);
                                        $ssType = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                    @endphp
                                    <label class="flex items-start gap-2.5 p-2 bg-white border border-gray-100 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50/50 transition-colors">
                                        <input type="checkbox" name="schedule_ids[]" value="{{ $sched->id }}"
                                            class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-1">
                                                <span class="text-[11px] font-bold text-gray-800 truncate">{{ $ssDayName }}, {{ $ssTime }}</span>
                                                <span class="text-[8px] px-1 py-0.2 rounded font-semibold shrink-0 {{ $sched->session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">{{ $ssType }}</span>
                                            </div>
                                            <div class="text-[9px] text-gray-500 flex items-center gap-1 mt-0.5 truncate">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span class="truncate">{{ $sched->location->name ?? '?' }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                                @if($schedules->isEmpty())
                                    <p class="text-gray-400 italic text-center text-xs py-4 col-span-full">Tidak ada jadwal latihan tersedia untuk kelas Anda saat ini.</p>
                                @endif
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
            function openScheduleRequestModal() {
                document.getElementById('schedule-request-modal').style.display = 'flex';
            }
            function closeScheduleRequestModal() {
                document.getElementById('schedule-request-modal').style.display = 'none';
            }
        </script>
    @endif

</x-app-layout>
