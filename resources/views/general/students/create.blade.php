<x-app-layout title="Umum - Daftar Latihan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pendaftaran Paket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                x-data="registrationForm()"
                x-init="init()">

                <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-3">
                    <i class="fa-solid fa-address-card text-blue-600 mr-2"></i>Data Diri & Pilihan Paket Kursus
                </h3>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl text-xs text-red-700 dark:text-red-300">
                        <div class="font-bold flex items-center gap-1.5 mb-1.5 text-sm">
                            <i class="fa-solid fa-triangle-exclamation text-red-500"></i> Pendaftaran Belum Lengkap:
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('general.students.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Lengkap (readonly, diambil dari auth user) --}}
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 cursor-not-allowed" type="text" name="name" :value="old('name', Auth::user()->name)" required readonly />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Nomor HP / WhatsApp (readonly, diambil dari akun) --}}
                        <div>
                            <x-input-label for="phone" value="Nomor HP / WhatsApp" />
                            <x-text-input id="phone" class="block mt-1 w-full bg-gray-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 cursor-not-allowed" type="text" value="{{ Auth::user()->phone }}" readonly disabled />
                            <span class="text-[11px] text-slate-400 mt-1 block"><i class="fa-solid fa-circle-info mr-1 text-[#D3AF37]"></i>Otomatis diambil dari akun Anda.</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="birth_date" value="Tanggal Lahir" />
                            <div class="relative mt-1">
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10 cursor-pointer"
                                    required>
                                <button type="button" onclick="document.getElementById('birth_date').showPicker()"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-indigo-600 transition-colors">
                                    <i class="fa-solid fa-calendar-days text-lg"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gender" value="Jenis Kelamin" />
                            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Preferensi Gender Pelatih --}}
                    <div class="mt-4">
                        <x-input-label value="Preferensi Gender Pelatih" />
                        <div class="grid grid-cols-3 gap-3 mt-1.5">
                            <label class="flex items-center justify-center gap-2 p-2.5 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                :class="coachGenderPref === 'any' ? 'border-blue-500 bg-blue-50/70 text-blue-700 font-bold ring-2 ring-blue-200' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                <input type="radio" name="coach_gender_preference" value="any" x-model="coachGenderPref" @change="onGenderPrefChange()" class="hidden" />
                                <i class="fa-solid fa-users text-blue-500"></i>
                                <span>Bebas (Siapa Saja)</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 p-2.5 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                :class="coachGenderPref === 'L' ? 'border-blue-500 bg-blue-50/70 text-blue-700 font-bold ring-2 ring-blue-200' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                <input type="radio" name="coach_gender_preference" value="L" x-model="coachGenderPref" @change="onGenderPrefChange()" class="hidden" />
                                <i class="fa-solid fa-mars text-cyan-600"></i>
                                <span>Pelatih Laki-laki</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 p-2.5 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                :class="coachGenderPref === 'P' ? 'border-blue-500 bg-blue-50/70 text-blue-700 font-bold ring-2 ring-blue-200' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300'">
                                <input type="radio" name="coach_gender_preference" value="P" x-model="coachGenderPref" @change="onGenderPrefChange()" class="hidden" />
                                <i class="fa-solid fa-venus text-pink-500"></i>
                                <span>Pelatih Perempuan</span>
                            </label>
                        </div>
                        <!-- Peringatan Jika Tidak Ada Pelatih Tersedia untuk Gender yang Dipilih -->
                        <div x-show="coachGenderPref !== 'any' && selectedClassId && filteredSchedules.length === 0" x-transition
                            class="mt-2.5 p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-600 dark:text-amber-400 text-xs flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 text-base shrink-0"></i>
                            <div>
                                <p class="font-bold">Tidak ada pelatih <span x-text="coachGenderPref === 'L' ? 'Laki-laki' : 'Perempuan'"></span> yang tersedia untuk jadwal kelas ini.</p>
                                <p class="text-[11px] opacity-90 mt-0.5">Silakan ubah preferensi ke "Bebas (Siapa Saja)" untuk melihat jadwal pelatih lain.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Upload Berkas Khusus Kelas Prestasi --}}
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4" x-show="isPrestasi" x-transition>
                        <div class="bg-amber-500/10 border border-amber-500/30 p-4 rounded-xl">
                            <x-input-label for="family_card_image" value="Upload Foto Kartu Keluarga (KK) *" class="text-amber-500 dark:text-amber-400 font-bold text-xs" />
                            <input type="file" id="family_card_image" name="family_card_image" accept="image/*,.pdf" x-bind:required="isPrestasi"
                                class="block w-full text-xs text-slate-600 dark:text-slate-300 mt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer" />
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 block">Wajib untuk Kelas Prestasi (JPG, PNG, WEBP, PDF max 2MB)</span>
                            <x-input-error :messages="$errors->get('family_card_image')" class="mt-1" />
                        </div>

                        <div class="bg-amber-500/10 border border-amber-500/30 p-4 rounded-xl">
                            <x-input-label for="student_image" value="Upload Foto Murid (Pas Foto / Atlet) *" class="text-amber-500 dark:text-amber-400 font-bold text-xs" />
                            <input type="file" id="student_image" name="student_image" accept="image/*" x-bind:required="isPrestasi"
                                class="block w-full text-xs text-slate-600 dark:text-slate-300 mt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer" />
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 block">Wajib untuk Kelas Prestasi (JPG, PNG, WEBP max 2MB)</span>
                            <x-input-error :messages="$errors->get('student_image')" class="mt-1" />
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
                                    :class="selectedCategoryId == '{{ $cat->id }}'
                                        ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200'
                                        : 'border-gray-200 hover:border-gray-300 bg-white'"
                                    @click="selectCategory('{{ $cat->id }}')">
                                    <input type="radio" name="_category" value="{{ $cat->id }}"
                                        x-model="selectedCategoryId" class="hidden" />
                                    <div>
                                        <i class="fa-solid {{ $cat->slug === 'belajar' ? 'fa-person-swimming text-blue-500' : 'fa-trophy text-amber-500' }} text-2xl"></i>
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
                            x-model="selectedClassId"
                            @change="onClassChange()"
                            required>
                            <option value="">-- Pilih Tingkat Kelas --</option>
                            <template x-for="cls in filteredClasses" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name + ' (' + cls.age_min + (cls.age_max ? '-' + cls.age_max : '+') + ' thn)'"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('swimming_class_id')" class="mt-2" />
                    </div>

                    {{-- Step 4: Pilih Paket --}}
                    <div class="mt-5" x-show="selectedClassId" x-transition>
                        <x-input-label for="package_id" value="Pilih Paket Kursus" />
                        <select id="package_id" name="package_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedPackageId"
                            @change="onPackageChange()"
                            required>
                            <option value="">-- Pilih Paket Latihan --</option>
                            <template x-for="pkg in filteredPackages" :key="pkg.id">
                                <option :value="pkg.id" x-text="pkg.name + ' — ' + (selectedLocationId ? formatPrice(getPackagePrice(pkg)) : '(Harga menyesuaikan kolam)') + ' (' + pkg.sessions + 'x Pertemuan)'"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('package_id')" class="mt-2" />
                    </div>

                    <input type="hidden" name="location_id" :value="selectedLocationId">
                    <input type="hidden" name="secondary_location_id" :value="secondaryLocationId">
                    <template x-for="schedId in effectiveScheduleIds" :key="schedId">
                        <input type="hidden" name="schedule_ids[]" :value="schedId">
                    </template>

                    {{-- Step 5: Pilih Jadwal Latihan --}}
                    <div class="mt-5" x-show="filteredSchedules.length > 0" x-transition>
                        <x-input-label value="Jadwal Latihan" />
                        <p class="text-xs text-gray-400 mb-2" x-show="!isPrestasi">Centang jadwal latihan yang diinginkan. Batas slot jadwal disesuaikan dengan jenis paket latihan.</p>

                        <div class="mb-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-lg text-xs" x-show="isPrestasi">
                            <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i>
                            <strong>Jadwal Wajib Kelas Prestasi:</strong> Seluruh jadwal di bawah ini merupakan alur latihan wajib atlet. Murid akan otomatis terdaftar pada semua sesi latihan yang tersedia.
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                            <template x-for="sched in filteredSchedules" :key="sched.id">
                                <div>
                                    <template x-if="isPrestasi">
                                        <div class="flex items-start gap-3 p-3 border border-emerald-300 bg-emerald-50/40 rounded-xl text-sm">
                                            <div class="mt-1 text-emerald-600 font-bold">
                                                <i class="fa-solid fa-circle-check text-base"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-bold text-gray-800" x-text="getDayName(sched.day_of_week) + ', ' + formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"
                                                        :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                        x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-700">Jadwal Wajib</span>
                                                </div>
                                                <span class="block text-xs text-gray-500 mt-1"><i class="fa-solid fa-map-pin text-gray-400 mr-1"></i><span x-text="sched.location?.name || ''"></span></span>
                                                <span class="block text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-user-tie text-gray-400 mr-1"></i>Pelatih: <span class="font-semibold text-slate-700" x-text="sched.coach_name || 'Belum Ditentukan'"></span></span>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!isPrestasi">
                                        <label class="flex items-start gap-3 p-3 border rounded-xl cursor-pointer transition-all duration-100 text-sm"
                                            :class="selectedScheduleIds.includes(String(sched.id)) ? 'border-blue-400 bg-blue-50/50' : 
                                                (isScheduleDisabled(sched) ? 'border-gray-100 bg-gray-50/30 opacity-60 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')">
                                            <input type="checkbox" :value="sched.id"
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-1"
                                                @change="toggleSchedule(sched.id)"
                                                :checked="selectedScheduleIds.includes(String(sched.id))"
                                                :disabled="isScheduleDisabled(sched)" />
                                            <div class="flex-1">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-bold text-gray-800" x-text="getDayName(sched.day_of_week) + ', ' + formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"
                                                        :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                        x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                </div>
                                                <span class="block text-xs text-gray-500 mt-1"><i class="fa-solid fa-map-pin text-gray-400 mr-1"></i><span x-text="sched.location?.name || ''"></span></span>
                                                <span class="block text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-user-tie text-gray-400 mr-1"></i>Pelatih: <span class="font-semibold text-slate-700" x-text="sched.coach_name || 'Belum Ditentukan'"></span></span>
                                                <span class="block text-[10px] font-bold mt-1"
                                                    :class="(sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? 'text-red-500' : 'text-blue-600'"
                                                    x-text="(sched.current_enrolled_count || 0) + '/' + getScheduleCapacityLimit(sched) + ' Terisi' + ((sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? ' (Penuh)' : '')"></span>
                                                <template x-if="isSchedulePriceMismatch(sched) && !selectedScheduleIds.includes(String(sched.id))">
                                                    <span class="block text-[10px] text-amber-600 dark:text-amber-400 font-bold mt-0.5">
                                                        <i class="fa-solid fa-triangle-exclamation mr-0.5"></i>Beda tarif lokasi paket
                                                    </span>
                                                </template>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('schedule_ids')" class="mt-2" />
                        <small class="text-gray-400 mt-1 block" x-show="!isPrestasi">*Maksimal jadwal latihan untuk paket ini adalah <span class="font-bold text-slate-600" x-text="maxSlots"></span> sesi per minggu.</small>
                    </div>

                    <div class="mt-4 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs"
                        x-show="filteredSchedules.length === 0 && selectedClassId" x-transition>
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        <strong>Tidak Ada Jadwal:</strong> Belum ada jadwal latihan yang tersedia untuk kelas terpilih.
                    </div>

                    {{-- Hidden input for coach_id (automatically derived from first selected schedule) --}}
                    <input type="hidden" name="coach_id" :value="selectedCoachId">

                    {{-- Ringkasan Pembayaran --}}
                    <div class="mt-6" x-show="selectedPackageId" x-transition>
                        <div class="bg-[#101828] dark:bg-[#101828] border border-[#D3AF37]/30 rounded-2xl p-5 shadow-md">
                            <h4 class="text-xs uppercase font-extrabold text-[#D3AF37] tracking-wider mb-3.5 flex items-center gap-2">
                                <i class="fa-solid fa-calculator text-[#D3AF37]"></i> Ringkasan Pembayaran
                            </h4>
                            <div class="space-y-2.5 text-sm">
                                <div class="flex justify-between items-center text-slate-300">
                                    <span class="font-medium text-xs text-slate-300">Paket Kursus</span>
                                    <span class="font-bold text-white text-sm" x-text="formatPrice(calculatedPackagePrice)"></span>
                                </div>
                                 <div class="flex justify-between items-center text-slate-300" x-show="showRegistrationFee">
                                    <span class="font-medium text-xs text-slate-300">Biaya Pendaftaran <span class="text-[10px] text-slate-400">(sekali seumur hidup)</span></span>
                                    <span class="font-bold text-white text-sm">Rp 30.000</span>
                                </div>
                                <hr class="border-slate-800 my-3 border-dashed" />
                                <div class="flex justify-between items-center text-base pt-1">
                                    <span class="font-extrabold text-white text-sm">Total Bayar</span>
                                    <span class="font-black text-[#D3AF37] text-xl tracking-tight" x-text="formatPrice(totalAmount)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end mt-8 border-t pt-4">
                        <p class="text-xs text-red-500 mb-2 font-medium" x-show="selectedPackageId && !isPrestasi && selectedScheduleIds.length === 0">
                            *Anda wajib memilih minimal satu jadwal latihan untuk melanjutkan pendaftaran.
                        </p>
                        <x-primary-button class="w-full md:w-auto justify-center"
                            x-bind:disabled="!selectedPackageId || (!isPrestasi && selectedScheduleIds.length === 0)">
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
                selectedPackageId: '{{ old('package_id', '') }}',
                coachGenderPref: '{{ old('coach_gender_preference', 'any') }}',
                selectedScheduleIds: [],

                init() {
                    @if(old('schedule_ids'))
                        this.selectedScheduleIds = @json(old('schedule_ids')).map(String);
                    @endif
                },

                get isPrestasi() {
                    if (!this.selectedCategoryId) return false;
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat ? (cat.slug === 'prestasi') : false;
                },

                get effectiveScheduleIds() {
                    if (this.isPrestasi) {
                        return this.filteredSchedules.map(s => String(s.id));
                    }
                    return this.selectedScheduleIds;
                },

                get selectedCoachId() {
                    const ids = this.effectiveScheduleIds;
                    if (ids.length === 0) return '';
                    const firstSchedId = ids[0];
                    const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                    return sched ? (sched.coach_id || '') : '';
                },

                // Computed
                get selectedLocationId() {
                    const ids = this.effectiveScheduleIds;
                    if (ids.length === 0) return '';
                    const firstSchedId = ids[0];
                    const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                    return sched ? String(sched.location_id) : '';
                },

                get secondaryLocationId() {
                    const loc1 = this.selectedLocationId;
                    if (!loc1) return '';
                    for (let id of this.effectiveScheduleIds) {
                        const sched = this.allSchedules.find(s => String(s.id) == id);
                        if (sched && String(sched.location_id) !== loc1) {
                            return String(sched.location_id);
                        }
                    }
                    return '';
                },

                get maxSlots() {
                    if (this.isPrestasi) return 999;
                    if (!this.selectedPackageId) return 1;
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    if (!pkg) return 1;
                    if (pkg.package_type === 'single_session') return 1;
                    const sessions = pkg.sessions || 4;
                    if (sessions <= 4) return 1;
                    if (sessions <= 8) return 2;
                    if (sessions <= 12) return 3;
                    return 4;
                },

                get availableCoaches() {
                    const uniqueCoaches = [];
                    const seen = new Set();
                    
                    this.selectedScheduleIds.forEach(id => {
                        const sched = this.allSchedules.find(s => String(s.id) == id);
                        if (sched && sched.coach_id && !seen.has(sched.coach_id)) {
                            seen.add(sched.coach_id);
                            uniqueCoaches.push({
                                id: sched.coach_id,
                                name: sched.coach_name || 'Belum Ditentukan'
                            });
                        }
                    });
                    
                    return uniqueCoaches;
                },

                get filteredClasses() {
                    if (!this.selectedCategoryId) return [];
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat ? (cat.swimming_classes || []) : [];
                },

                get filteredPackages() {
                    if (!this.selectedClassId) return [];
                    return this.allPackages.filter(p => p.swimming_class_id == this.selectedClassId);
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

                get filteredSchedules() {
                    if (!this.selectedClassId) return [];
                    let list = this.allSchedules.filter(s => s.swimming_class_id == this.selectedClassId);

                    if (this.selectedPackageId) {
                        const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                        if (pkg) {
                            const pkgName = (pkg.name || '').toLowerCase();
                            const pkgType = (pkg.package_type || '').toLowerCase();
                            const isPrivate = pkgType.includes('private') || pkgName.includes('private');

                            if (!isPrivate) {
                                list = list.filter(s => {
                                    const locName = (s.location?.name || '').toLowerCase();
                                    return !locName.includes('home visit') && s.location_id != 6;
                                });
                            }
                        }
                    } else {
                        list = list.filter(s => {
                            const locName = (s.location?.name || '').toLowerCase();
                            return !locName.includes('home visit') && s.location_id != 6;
                        });
                    }

                    if (this.coachGenderPref && this.coachGenderPref !== 'any') {
                        list = list.filter(s => {
                            const gender = s.coach?.gender || s.coach_gender;
                            return gender === this.coachGenderPref;
                        });
                    }

                    return list;
                },

                // Methods
                onGenderPrefChange() {
                    if (!this.isPrestasi) {
                        this.selectedScheduleIds = [];
                    }
                },
                isScheduleDisabled(sched) {
                    const limit = this.getScheduleCapacityLimit(sched);
                    const isFull = (sched.current_enrolled_count || 0) >= limit;
                    const isChecked = this.selectedScheduleIds.includes(String(sched.id));
                    if (isFull && !isChecked) return true;
                    if (this.selectedScheduleIds.length >= this.maxSlots && !isChecked) return true;
                    if (!isChecked && this.isSchedulePriceMismatch(sched)) return true;
                    return false;
                },
                getPackageLocationPrice(pkg, locationId) {
                    if (!pkg || !locationId) return 0;
                    if (pkg.is_location_based) {
                        const lp = (pkg.location_prices || []).find(l => l.location_id == locationId);
                        return lp ? Number(lp.price) : 0;
                    }
                    return Number(pkg.price || 0);
                },
                isSchedulePriceMismatch(sched) {
                    if (!this.selectedScheduleIds.length || !sched) return false;
                    const pkgId = this.selectedPackageId;
                    if (!pkgId) return false;
                    const pkg = this.allPackages.find(p => p.id == pkgId);
                    if (!pkg || !(pkg.sessions == 8 || (pkg.name || '').toLowerCase().includes('8 sesi'))) return false;

                    const firstSchedId = this.selectedScheduleIds[0];
                    const firstSched = this.allSchedules.find(s => String(s.id) === String(firstSchedId));
                    if (!firstSched) return false;

                    const firstPrice = this.getPackageLocationPrice(pkg, firstSched.location_id);
                    const targetPrice = this.getPackageLocationPrice(pkg, sched.location_id);
                    return firstPrice !== targetPrice;
                },

                toggleSchedule(schedId) {
                    const id = String(schedId);
                    const idx = this.selectedScheduleIds.indexOf(id);
                    if (idx > -1) {
                        this.selectedScheduleIds.splice(idx, 1);
                    } else {
                        if (this.selectedScheduleIds.length < this.maxSlots) {
                            this.selectedScheduleIds.push(id);
                        }
                    }
                    this.autoSelectCoach();
                },

                autoSelectCoach() {
                    this.$nextTick(() => {
                        const coaches = this.availableCoaches;
                        if (coaches.length === 1) {
                            this.selectedCoachId = String(coaches[0].id);
                        } else if (coaches.length === 0 || !coaches.find(c => String(c.id) == this.selectedCoachId)) {
                            this.selectedCoachId = '';
                        }
                    });
                },

                getScheduleCapacityLimit(sched) {
                    if (this.selectedCategoryId) {
                        const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                        if (cat && cat.slug === 'prestasi') {
                            return 15;
                        }
                    }
                    if (!this.selectedPackageId) {
                        return 4;
                    }
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    if (!pkg) return 4;
                    
                    const type = pkg.package_type || 'regular';
                    const name = pkg.name || '';
                    
                    if (type === 'private' || (type === 'single_session' && name.toLowerCase().includes('private'))) {
                        return 1;
                    }
                    return 4;
                },

                selectCategory(catId) {
                    this.selectedCategoryId = catId;
                    this.selectedClassId = '';
                    this.selectedPackageId = '';
                    this.selectedCoachId = '';
                    this.selectedScheduleIds = [];
                },

                onClassChange() {
                    this.selectedPackageId = '';
                    this.selectedCoachId = '';
                    this.selectedScheduleIds = [];
                },

                onPackageChange() {
                    this.selectedCoachId = '';
                    if (this.selectedPackageId) {
                        const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                        if (pkg) {
                            const pkgName = (pkg.name || '').toLowerCase();
                            const pkgType = (pkg.package_type || '').toLowerCase();
                            const isPrivate = pkgType.includes('private') || pkgName.includes('private');

                            if (!isPrivate) {
                                this.selectedScheduleIds = this.selectedScheduleIds.filter(id => {
                                    const sched = this.allSchedules.find(s => String(s.id) === String(id));
                                    if (!sched) return false;
                                    const locName = (sched.location?.name || '').toLowerCase();
                                    return !locName.includes('home visit') && sched.location_id != 6;
                                });
                            }
                        }
                    }
                    if (this.selectedScheduleIds.length > this.maxSlots) {
                        this.selectedScheduleIds = this.selectedScheduleIds.slice(0, this.maxSlots);
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
