<x-app-layout title="Parent - Daftar Anak">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pendaftaran Murid Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" x-data="registrationForm()"
                x-init="init()">

                <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-3">
                    <i class="fa-solid fa-address-card text-blue-600 mr-2"></i>Data Diri Anak & Pilihan Paket
                </h3>

                <form method="POST" action="{{ route('parent.students.store') }}">
                    @csrf

                    {{-- Nama Lengkap Anak --}}
                    <div>
                        <x-input-label for="name" value="Nama Lengkap Anak" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="birth_date" value="Tanggal Lahir" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date"
                                :value="old('birth_date')" required />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gender" value="Jenis Kelamin" />
                            <select id="gender" name="gender"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200" />

                    {{-- Step 1: Pilih Kategori Kelas --}}
                    <div class="mt-4">
                        <x-input-label value="Jenis Kelas Renang" />
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            @foreach ($classCategories as $cat)
                                <label
                                    class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all duration-150"
                                    :class="selectedCategoryId == '{{ $cat->id }}' ?
                                        'border-blue-500 bg-blue-50 ring-2 ring-blue-200' :
                                        'border-gray-200 hover:border-gray-300 bg-white'"
                                    @click="selectCategory('{{ $cat->id }}')">
                                    <input type="radio" name="_category" value="{{ $cat->id }}"
                                        x-model="selectedCategoryId" class="hidden" />
                                    <div>
                                        <i
                                            class="fa-solid {{ $cat->slug === 'belajar' ? 'fa-person-swimming text-blue-500' : 'fa-trophy text-amber-500' }} text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $cat->name }}</p>
                                        <p class="text-[11px] text-gray-400">
                                            {{ $cat->slug === 'belajar' ? 'Untuk pemula segala usia' : 'Program atlet prestasi' }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Step 2: Pilih Tingkat Kelas --}}
                    <div class="mt-5" x-show="selectedCategoryId" x-transition>
                        <x-input-label for="swimming_class_id" value="Pilih Tingkat Kelas" />
                        <select id="swimming_class_id" name="swimming_class_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedClassId" @change="onClassChange()" required>
                            <option value="">-- Pilih Tingkat Kelas --</option>
                            <template x-for="cls in filteredClasses" :key="cls.id">
                                <option :value="cls.id"
                                    x-text="cls.name + ' (' + cls.age_min + (cls.age_max ? '-' + cls.age_max : '+') + ' thn)'">
                                </option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('swimming_class_id')" class="mt-2" />
                    </div>

                    {{-- Step 3: Pilih Lokasi Utama --}}
                    <div class="mt-5" x-show="selectedClassId" x-transition>
                        <x-input-label for="location_id" value="Pilih Tempat Latihan Utama" />
                        <select id="location_id" name="location_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedLocationId" @change="onLocationChange()" required>
                            <option value="">-- Pilih Kolam Renang --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">
                                    {{ $location->name }} — ({{ $location->address }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                    </div>

                    {{-- Step 4: Pilih Paket --}}
                    <div class="mt-5" x-show="selectedClassId" x-transition>
                        <x-input-label for="package_id" value="Pilih Paket Kursus" />
                        <select id="package_id" name="package_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedPackageId" @change="onPackageChange()" required>
                            <option value="">-- Pilih Paket Latihan --</option>
                            <template x-for="pkg in filteredPackages" :key="pkg.id">
                                <option :value="pkg.id"
                                    x-text="pkg.name + ' — ' + formatPrice(getPackagePrice(pkg)) + ' (' + pkg.sessions + 'x Pertemuan)'">
                                </option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('package_id')" class="mt-2" />
                    </div>

                    {{-- Step 4b: Lokasi Kedua (hanya untuk paket 8 sesi) --}}
                    <div class="mt-5" x-show="showSecondaryLocation" x-transition>
                        <x-input-label for="secondary_location_id"
                            value="Pilih Tempat Latihan Kedua (Opsional, Paket 8 Sesi)" />
                        <select id="secondary_location_id" name="secondary_location_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedSecondaryLocationId">
                            <option value="">-- Tidak Perlu / Sama Dengan Lokasi Utama --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    x-bind:disabled="selectedLocationId == '{{ $location->id }}'">
                                    {{ $location->name }} — ({{ $location->address }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-gray-400 mt-1 block">*Untuk paket 8 pertemuan (2x seminggu), Anda bisa
                            memilih 2 lokasi berbeda sesuai ketersediaan jadwal.</small>
                        <x-input-error :messages="$errors->get('secondary_location_id')" class="mt-2" />
                    </div>

                    {{-- Step 5: Pilih Jadwal Latihan --}}
                    <div class="mt-5" x-show="filteredSchedules.length > 0" x-transition>
                        <x-input-label value="Pilih Jadwal Latihan" />
                        <p class="text-xs text-gray-400 mb-2">Centang jadwal latihan yang diinginkan.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto pr-1">
                            <template x-for="sched in filteredSchedules" :key="sched.id">
                                <label
                                    class="flex items-center gap-2.5 p-3 border rounded-lg cursor-pointer transition-all duration-100 text-sm"
                                    :class="selectedScheduleIds.includes(String(sched.id)) ?
                                        'border-blue-400 bg-blue-50' :
                                        'border-gray-200 hover:border-gray-300'">
                                    <input type="checkbox" name="schedule_ids[]" :value="sched.id"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        @change="toggleSchedule(sched.id)"
                                        :checked="selectedScheduleIds.includes(String(sched.id))" />
                                    <div>
                                        <span class="font-semibold text-gray-700"
                                            x-text="getDayName(sched.day_of_week)"></span>
                                        <span class="text-gray-500"
                                            x-text="formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                        <span class="text-[10px] ml-1 px-1.5 py-0.5 rounded-full font-bold"
                                            :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' :
                                                'bg-orange-100 text-orange-700'"
                                            x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                        <span class="block text-[10px] text-gray-400"
                                            x-text="sched.location?.name || ''"></span>
                                    </div>
                                </label>
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('schedule_ids')" class="mt-2" />
                    </div>

                    <div class="mt-5 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs"
                        x-show="filteredSchedules.length === 0 && selectedClassId && selectedLocationId" x-transition>
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        <strong>Tidak Ada Jadwal:</strong> Belum ada jadwal latihan yang tersedia untuk kelas dan lokasi
                        kolam terpilih. Silakan hubungi admin atau pilih lokasi/kelas lain.
                    </div>

                    {{-- Pilih Coach --}}
                    <div class="mt-5" x-show="selectedClassId" x-transition>
                        <x-input-label for="coach_id" value="Rekomendasi / Preferensi Coach Pelatih (Opsional)" />
                        <select id="coach_id" name="coach_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected>-- Bebas / Rekomendasi Admin --</option>
                            @foreach ($coaches as $coach)
                                <option value="{{ $coach->id }}"
                                    {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                    {{ $coach->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-gray-400 mt-1 block">*Sifatnya pengajuan, Admin akan menyesuaikan dengan
                            kuota luang Coach.</small>
                        <x-input-error :messages="$errors->get('coach_id')" class="mt-2" />
                    </div>

                    {{-- Ringkasan Pembayaran --}}
                    <div class="mt-6" x-show="selectedPackageId" x-transition>
                        <div
                            class="bg-gradient-to-br from-slate-50 to-blue-50 border border-blue-100 rounded-xl p-5 shadow-sm">
                            <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-calculator text-blue-500"></i> Ringkasan Pembayaran
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Paket Kursus</span>
                                    <span class="font-semibold text-gray-800"
                                        x-text="formatPrice(calculatedPackagePrice)"></span>
                                </div>
                                <div class="flex justify-between" x-show="showRegistrationFee">
                                    <span class="text-gray-500">Biaya Pendaftaran</span>
                                    <span class="font-semibold text-gray-800">Rp 30.000</span>
                                </div>
                                <hr class="border-blue-200 !my-3" />
                                <div class="flex justify-between text-base">
                                    <span class="font-bold text-gray-800">Total Bayar</span>
                                    <span class="font-extrabold text-blue-600 text-lg"
                                        x-text="formatPrice(totalAmount)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end mt-8 border-t pt-4">
                        <p class="text-xs text-red-500 mb-2 font-medium"
                            x-show="selectedPackageId && selectedScheduleIds.length === 0">
                            *Anda wajib memilih minimal satu jadwal latihan untuk melanjutkan pendaftaran.
                        </p>
                        <x-primary-button class="w-full md:w-auto justify-center"
                            x-bind:disabled="!selectedPackageId || selectedScheduleIds.length === 0">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Pendaftaran
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function registrationForm() {
            return {
                // Data from server
                allCategories: @json($classCategories),
                allPackages: @json($packages),
                allSchedules: @json($schedules),


                // Selected values
                selectedCategoryId: '{{ old('_category', '') }}',
                selectedClassId: '{{ old('swimming_class_id', '') }}',
                selectedLocationId: '{{ old('location_id', '') }}',
                selectedSecondaryLocationId: '{{ old('secondary_location_id', '') }}',
                selectedPackageId: '{{ old('package_id', '') }}',
                selectedScheduleIds: [],

                init() {
                    // Restore old schedule_ids if available
                    @if (old('schedule_ids'))
                        this.selectedScheduleIds = @json(old('schedule_ids')).map(String);
                    @endif
                },

                // Computed
                get filteredClasses() {
                    if (!this.selectedCategoryId) return [];
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat ? (cat.swimming_classes || []) : [];
                },

                get filteredPackages() {
                    if (!this.selectedClassId) return [];
                    return this.allPackages.filter(p => p.swimming_class_id == this.selectedClassId);
                },

                get filteredSchedules() {
                    if (!this.selectedClassId) return [];
                    let schedules = this.allSchedules.filter(s => s.swimming_class_id == this.selectedClassId);

                    // Filter by selected locations
                    if (this.selectedLocationId) {
                        const locIds = [this.selectedLocationId];
                        if (this.selectedSecondaryLocationId) {
                            locIds.push(this.selectedSecondaryLocationId);
                        }
                        schedules = schedules.filter(s => locIds.includes(String(s.location_id)));
                    }

                    return schedules;
                },

                get showSecondaryLocation() {
                    if (!this.selectedPackageId) return false;
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    return pkg && pkg.sessions >= 8 && pkg.is_location_based;
                },

                get showRegistrationFee() {
                    if (!this.selectedCategoryId) return false;
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat && cat.slug === 'belajar';
                },

                get calculatedPackagePrice() {
                    if (!this.selectedPackageId) return 0;
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    return this.getPackagePrice(pkg);
                },

                get totalAmount() {
                    let total = this.calculatedPackagePrice;
                    if (this.showRegistrationFee) total += 30000;
                    return total;
                },

                // Methods
                selectCategory(catId) {
                    this.selectedCategoryId = catId;
                    this.selectedClassId = '';
                    this.selectedPackageId = '';
                    this.selectedScheduleIds = [];
                },

                onClassChange() {
                    this.selectedPackageId = '';
                    this.selectedScheduleIds = [];
                },

                onLocationChange() {
                    this.selectedScheduleIds = [];
                    this.selectedSecondaryLocationId = '';
                },

                onPackageChange() {
                    // Reset secondary location when package changes
                    if (!this.showSecondaryLocation) {
                        this.selectedSecondaryLocationId = '';
                    }
                },

                toggleSchedule(schedId) {
                    const id = String(schedId);
                    const idx = this.selectedScheduleIds.indexOf(id);
                    if (idx > -1) {
                        this.selectedScheduleIds.splice(idx, 1);
                    } else {
                        this.selectedScheduleIds.push(id);
                    }
                },

                getPackagePrice(pkg) {
                    if (!pkg) return 0;
                    if (pkg.is_location_based && this.selectedLocationId) {
                        const lp = (pkg.location_prices || []).find(lp => lp.location_id == this.selectedLocationId);
                        return lp ? lp.price : 0;
                    }
                    return pkg.price || 0;
                },

                formatPrice(val) {
                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                },

                getDayName(dayOfWeek) {
                    const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    return days[dayOfWeek] || '-';
                },

                formatTime(timeStr) {
                    if (!timeStr) return '';
                    return timeStr.substring(0, 5);
                },
            };
        }
    </script>
</x-app-layout>
