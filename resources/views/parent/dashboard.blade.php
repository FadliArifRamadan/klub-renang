<x-app-layout title="Parent - Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Parent') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Panel --}}
            <div class="bg-gradient-to-r from-[#101828] via-[#1E1E2D] to-[#101828] overflow-hidden rounded-2xl p-6 md:p-8 mb-8 border border-[#D3AF37]/30 shadow-xl relative z-10">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#D3AF37]/10 rounded-full blur-2xl pointer-events-none"></div>
                <h1 class="text-[#D3AF37] text-2xl md:text-3xl font-extrabold tracking-tight mb-2">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="text-slate-300 text-sm max-w-3xl leading-relaxed font-normal">
                    Selamat datang di portal orang tua Black Diamond. Pantau perkembangan anak Anda, cek status latihan, dan lihat catatan terbaru dari pelatih di sini.
                </p>
            </div>

            {{-- Notifikasi Izin Pelatih --}}
            @if (isset($children) && $children->isNotEmpty() && isset($activeLeaves) && $activeLeaves->isNotEmpty())
                @php
                    $parentLeaves = collect();
                    foreach ($children as $child) {
                        $childLeaves = $activeLeaves->filter(function($leave) use ($child) {
                            if ($leave->coach_id != $child->coach_id) {
                                return false;
                            }
                            $dayOfWeek = ($leave->leave_date->dayOfWeek === 0) ? 6 : ($leave->leave_date->dayOfWeek - 1);
                            return $child->schedules->contains('day_of_week', $dayOfWeek);
                        });
                        foreach ($childLeaves as $leave) {
                            $parentLeaves->push([
                                'child' => $child,
                                'leave' => $leave
                            ]);
                        }
                    }
                @endphp
                @if ($parentLeaves->isNotEmpty())
                    <div class="space-y-3 mb-8">
                        @foreach ($parentLeaves as $item)
                            @php
                                $child = $item['child'];
                                $leave = $item['leave'];
                            @endphp
                            <div class="flex p-4 text-sm rounded-xl bg-sky-50 border border-sky-200 text-sky-800 shadow-sm" role="alert">
                                <div style="margin-right: 16px; margin-top: 2px; flex-shrink: 0;" class="text-sky-600">
                                    <i class="fa-solid fa-circle-info text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-bold">Informasi Latihan ({{ $child->name }}):</span>
                                    Pelatih <span class="font-bold text-slate-800">{{ $leave->coach->name }}</span> berhalangan melatih pada tanggal <span class="font-semibold">{{ $leave->leave_date->translatedFormat('d F Y') }}</span> ({{ $leave->leave_date->translatedFormat('l') }}).
                                    @if ($leave->substitute_coach_id)
                                        <div class="mt-1">
                                            Sesi latihan untuk <span class="font-bold">{{ $child->name }}</span> akan dipimpin oleh pelatih pengganti: <span class="font-bold text-slate-800 underline">{{ $leave->substituteCoach->name }}</span>.
                                        </div>
                                    @else
                                        <div class="mt-1 font-bold text-amber-700">
                                            Latihan untuk jadwal ini diliburkan (tidak ada pelatih pengganti). Kuota sesi <span class="underline">{{ $child->name }}</span> tidak akan dikurangi.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            {{-- Notifikasi Reschedule Queue (Jadwal Diliburkan & Penjadwalan Ulang) --}}
            @if (isset($rescheduleQueues) && $rescheduleQueues->isNotEmpty())
                <div class="space-y-3 mb-8">
                    @foreach ($rescheduleQueues as $rq)
                        @if ($rq->status === 'pending')
                            <div class="flex items-start p-4 text-sm rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-200 shadow-md">
                                <div class="p-2.5 bg-amber-500/20 text-amber-400 rounded-xl mr-3.5 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-calendar-minus text-lg"></i>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-amber-400 text-sm">
                                            <i class="fa-solid fa-info-circle mr-1"></i> Informasi Sesi Diliburkan ({{ $rq->student->name ?? 'Anak' }})
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                            Sesi Diliburkan
                                        </span>
                                    </div>
                                    <p class="mt-1 text-slate-300 text-xs leading-relaxed">
                                        Sesi latihan untuk <strong class="text-white">{{ $rq->student->name ?? 'Anak' }}</strong> pada hari <strong class="text-amber-300">{{ \Carbon\Carbon::parse($rq->original_date)->locale('id')->translatedFormat('l, d F Y') }}</strong> ({{ $rq->schedule->swimmingClass->name ?? '' }} — {{ $rq->schedule->location->name ?? '' }}) <strong class="text-amber-300">diliburkan</strong> karena pelatih <strong class="text-white">{{ $rq->coachLeave->coach->name ?? 'Pelatih' }}</strong> berhalangan.
                                    </p>
                                    <div class="mt-2 p-2.5 rounded-xl bg-slate-900/60 border border-slate-700/50 text-[11px] text-slate-300 flex items-center gap-2">
                                        <i class="fa-solid fa-hourglass-half text-amber-400"></i>
                                        <span>Status: <strong>Menunggu Penjadwalan Ulang (Reschedule) oleh Admin</strong> — Kuota sesi tidak dipotong.</span>
                                    </div>
                                </div>
                            </div>
                        @elseif ($rq->status === 'rescheduled')
                            <div class="flex items-start p-4 text-sm rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 shadow-md">
                                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-xl mr-3.5 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-calendar-check text-lg"></i>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-emerald-400 text-sm">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Jadwal Pengganti (Reschedule) Ditetapkan! ({{ $rq->student->name ?? 'Anak' }})
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                            Reschedule Ditetapkan
                                        </span>
                                    </div>
                                    <p class="mt-1 text-slate-300 text-xs leading-relaxed">
                                        Sesi tanggal <strong class="text-slate-400 line-through">{{ \Carbon\Carbon::parse($rq->original_date)->locale('id')->translatedFormat('d F Y') }}</strong> yang sempat diliburkan telah dijadwalkan ulang oleh Admin ke:
                                    </p>
                                    <div class="mt-2 p-2.5 rounded-xl bg-slate-900/60 border border-emerald-500/30 text-xs text-emerald-300 flex flex-wrap items-center gap-x-4 gap-y-1">
                                        <div><i class="fa-solid fa-calendar-day mr-1 text-emerald-400"></i> {{ \Carbon\Carbon::parse($rq->rescheduled_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
                                        <div><i class="fa-solid fa-clock mr-1 text-emerald-400"></i> {{ $rq->rescheduledSchedule->time_range ?? '' }}</div>
                                        <div><i class="fa-solid fa-location-dot mr-1 text-emerald-400"></i> {{ $rq->rescheduledSchedule->location->name ?? '' }}</div>
                                        <div><i class="fa-solid fa-user-tie mr-1 text-emerald-400"></i> Coach: {{ $rq->rescheduledSchedule->coach->name ?? 'Pelatih' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

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
                                        {{-- Modal Daftar Ulang --}}
                                        <x-modal name="renew-student-{{ $expStudent->id }}" maxWidth="2xl" focusable>
                                            <form method="POST" action="{{ route('parent.students.renew', $expStudent->id) }}" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{
                                                    allPackages: {{ $packages->toJson() }},
                                                    allSchedules: {{ $schedules->toJson() }},
                                                    classId: '{{ $expStudent->swimming_class_id }}',
                                                    packageId: '{{ $expStudent->package_id }}',
                                                    shouldPayRegFee: {{ $expStudent->shouldPayRegistrationFee() ? 'true' : 'false' }},
                                                    classCategorySlug: '{{ $expStudent->swimmingClass->category->slug ?? '' }}',
                                                    selectedScheduleIds: [
                                                         @if(!$expStudent->schedules->isEmpty())
                                                             @foreach($expStudent->schedules as $index => $sched)
                                                                 '{{ $sched->id }}'{{ $index < count($expStudent->schedules) - 1 ? ',' : '' }}
                                                             @endforeach
                                                         @endif
                                                     ],

                                                     get locationId() {
                                                         if (this.selectedScheduleIds.length === 0) return '';
                                                         const firstSchedId = this.selectedScheduleIds[0];
                                                         const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                                                         return sched ? String(sched.location_id) : '';
                                                     },
                                                     get secondaryLocationId() {
                                                         const loc1 = this.locationId;
                                                         if (!loc1) return '';
                                                         for (let id of this.selectedScheduleIds) {
                                                             const sched = this.allSchedules.find(s => String(s.id) == id);
                                                             if (sched && String(sched.location_id) !== loc1) {
                                                                 return String(sched.location_id);
                                                             }
                                                         }
                                                         return '';
                                                     },
                                                     get maxSlots() {
                                                         if (this.classCategorySlug === 'prestasi') return 999;
                                                         if (!this.packageId) return 1;
                                                         const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                         if (!pkg) return 1;
                                                         const sessions = pkg.sessions || 4;
                                                         if (sessions <= 4) return 1;
                                                         if (sessions <= 8) return 2;
                                                         if (sessions <= 12) return 3;
                                                         return 4;
                                                     },
                                                     get filteredPackages() {
                                                         if (!this.classId) return [];
                                                         return this.allPackages.filter(p => p.swimming_class_id == this.classId);
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
                                                     get filteredSchedules() {
                                                         if (!this.classId) return [];
                                                         return this.allSchedules.filter(s => s.swimming_class_id == this.classId);
                                                     },
                                                     isScheduleDisabled(sched) {
                                                         const limit = this.getScheduleCapacityLimit(sched);
                                                         const isFull = (sched.current_enrolled_count || 0) >= limit;
                                                         const isChecked = this.selectedScheduleIds.includes(String(sched.id));
                                                         if (isFull && !isChecked) return true;
                                                         if (this.selectedScheduleIds.length >= this.maxSlots && !isChecked) return true;
                                                         return false;
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
                                                     },
                                                     onPackageChange() {
                                                         if (this.selectedScheduleIds.length > this.maxSlots) {
                                                             this.selectedScheduleIds = this.selectedScheduleIds.slice(0, this.maxSlots);
                                                         }
                                                     },
                                                     getScheduleCapacityLimit(sched) {
                                                         if (this.classCategorySlug === 'prestasi') {
                                                             return 15;
                                                         }
                                                         if (!this.packageId) {
                                                             return 4;
                                                         }
                                                         const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                         if (!pkg) return 4;
                                                         
                                                         const type = pkg.package_type || 'regular';
                                                         const name = pkg.name || '';
                                                         
                                                         if (type === 'private' || (type === 'single_session' && name.toLowerCase().includes('private'))) {
                                                             return 1;
                                                         }
                                                         return 4;
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

                                                <!-- Paket Kursus (filtered by class) -->
                                                <div class="mb-4">
                                                    <x-input-label for="package-{{ $expStudent->id }}" value="Pilih Paket Kursus" />
                                                    <select id="package-{{ $expStudent->id }}" name="package_id" x-model="packageId" @change="onPackageChange()" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="">-- Pilih Paket Latihan --</option>
                                                        <template x-for="pkg in filteredPackages" :key="pkg.id">
                                                            <option :value="pkg.id" :selected="pkg.id == packageId" x-text="pkg.name + ' — ' + (locationId ? formatPrice(pkg.is_location_based ? ((pkg.location_prices || []).find(l => l.location_id == locationId)?.price || 0) : (pkg.price || 0)) : '(Harga menyesuaikan kolam)') + ' (' + pkg.sessions + 'x Pertemuan)'"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="location_id" :value="locationId">
                                                <input type="hidden" name="secondary_location_id" :value="secondaryLocationId">

                                                <!-- Jadwal Latihan Checkbox Grid -->
                                                <div class="mb-4" x-show="packageId && filteredSchedules.length > 0" x-transition>
                                                    <x-input-label value="Pilih Jadwal Latihan" />
                                                    <p class="text-xs text-gray-400 mb-2">Centang jadwal latihan yang diinginkan. Batas slot jadwal disesuaikan dengan jenis paket latihan.</p>

                                                    <div class="grid grid-cols-1 gap-2 max-h-48 overflow-y-auto pr-1">
                                                        <template x-for="sched in filteredSchedules" :key="sched.id">
                                                            <label class="flex items-start gap-2.5 p-2.5 border rounded-lg cursor-pointer transition-all duration-100 text-xs"
                                                                :class="selectedScheduleIds.includes(String(sched.id)) ? 'border-blue-400 bg-blue-50/50' : 
                                                                    (isScheduleDisabled(sched) ? 'border-gray-100 bg-gray-50/30 opacity-60 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')">
                                                                <input type="checkbox" name="schedule_ids[]" :value="sched.id"
                                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-0.5"
                                                                    @change="toggleSchedule(sched.id)"
                                                                    :checked="selectedScheduleIds.includes(String(sched.id))"
                                                                    :disabled="isScheduleDisabled(sched)" />
                                                                <div class="flex-1">
                                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                                        <span class="font-bold text-gray-800" x-text="getDayName(sched.day_of_week) + ', ' + formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                                                        <span class="text-[9px] px-1.5 py-0.2 rounded-full font-bold uppercase"
                                                                            :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                                            x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                                    </div>
                                                                    <span class="block text-[10px] text-gray-500 mt-0.5"><i class="fa-solid fa-map-pin text-gray-400 mr-0.5"></i><span x-text="sched.location?.name || ''"></span></span>
                                                                    <span class="block text-[10px] font-bold mt-0.5"
                                                                        :class="(sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? 'text-red-500' : 'text-blue-600'"
                                                                        x-text="(sched.current_enrolled_count || 0) + '/' + getScheduleCapacityLimit(sched) + ' Terisi' + ((sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? ' (Penuh)' : '')"></span>
                                                                </div>
                                                            </label>
                                                        </template>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('schedule_ids')" class="mt-2" />
                                                    <small class="text-gray-400 mt-1 block">*Maksimal jadwal latihan untuk paket ini adalah <span class="font-bold text-slate-600" x-text="maxSlots"></span> sesi per minggu.</small>
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

            {{-- Metrics Grid (Non-Clickable untuk Parent) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Card 1: Total Murid (Non-clickable) --}}
                <div
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-white mt-0.5">{{ $totalStudents }} Murid</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                {{-- Card 2: Total Coach (Non-clickable) --}}
                <div
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-white mt-0.5">{{ $totalCoaches }} Pelatih</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                {{-- Card 3: Total Tempat Latihan (Non-clickable) --}}
                <div
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-white mt-0.5">{{ $totalLocations }} Lokasi</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
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

                    // Cek apakah kelas Prestasi (memiliki Personal Best Time — selalu diisi untuk prestasi)
                    const isPrestasi = reports.some(r => r.metrics && ('Personal Best Time' in r.metrics));

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

                        // Cek apakah ada data Kondisi Fisik / Sistem Energi di salah satu report
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

                        const len = labels.length;

                        if (hasKondisiFisik) {
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
                        }

                        if (hasSistemEnergi) {
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

                            // Helper: render detail bulan terpilih di panel kanan
                            function showMonthDetail(report, btnEl) {
                                // Update active state pada sidebar
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

                                // Render detail di panel kanan
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

                            // Populate sidebar bulan
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

                                // Auto-select bulan pertama (terbaru)
                                if (idx === 0) {
                                    showMonthDetail(report, btn);
                                }
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
        <div id="schedule-request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none" x-data>
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
