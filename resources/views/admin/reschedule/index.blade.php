<x-app-layout title="Admin - Kelola Reschedule Murid">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Reschedule Murid') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        openModal: false, 
        selectedItem: null,
        rescheduledDate: '',
        rescheduledScheduleId: '',
        notes: '',
        allSchedules: {{ $availableSchedules->toJson() }},
        get filteredSchedules() {
            if (!this.selectedItem || !this.selectedItem.swimming_class_id) {
                return [];
            }
            // Filter: Hanya kelas yang sama DAN bukan jadwal asal yang sedang diliburkan
            return this.allSchedules.filter(s => 
                s.swimming_class_id == this.selectedItem.swimming_class_id &&
                s.id != this.selectedItem.schedule_id
            );
        },
        selectSchedule(sched) {
            this.rescheduledScheduleId = sched.id;
            // Hitung otomatis Tanggal Pengganti ke hari terdekat berikutnya sesuai sched.day_of_week
            if (this.selectedItem && this.selectedItem.original_date) {
                let origStr = this.selectedItem.original_date.includes('T') 
                    ? this.selectedItem.original_date.split('T')[0] 
                    : this.selectedItem.original_date;
                let origDate = new Date(origStr + 'T00:00:00');
                
                // Konversi JS Day (0=Sun, 1=Mon, ..., 6=Sat) ke sistem day_of_week (0=Mon, 1=Tue, 2=Wed, 3=Thu, 4=Fri, 5=Sat, 6=Sun)
                let currentDayIndex = (origDate.getDay() + 6) % 7; 
                let targetDayIndex = parseInt(sched.day_of_week, 10);
                
                let diff = targetDayIndex - currentDayIndex;
                if (diff <= 0) {
                    diff += 7; // Ambil hari yang sama di minggu berikutnya
                }
                
                let targetDate = new Date(origDate);
                targetDate.setDate(origDate.getDate() + diff);
                
                // Format YYYY-MM-DD
                let year = targetDate.getFullYear();
                let month = String(targetDate.getMonth() + 1).padStart(2, '0');
                let day = String(targetDate.getDate()).padStart(2, '0');
                this.rescheduledDate = `${year}-${month}-${day}`;
            }
        },
        formatDate(dateStr) {
            if (!dateStr) return '-';
            let cleanStr = dateStr.includes('T') ? dateStr.split('T')[0] : dateStr;
            let parts = cleanStr.split('-');
            if (parts.length === 3) {
                let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                let mIndex = parseInt(parts[1], 10) - 1;
                return parts[2] + ' ' + (months[mIndex] || parts[1]) + ' ' + parts[0];
            }
            return cleanStr;
        },
        openRescheduleModal(item) {
            this.selectedItem = item;
            this.rescheduledDate = item.rescheduled_date ? (item.rescheduled_date.includes('T') ? item.rescheduled_date.split('T')[0] : item.rescheduled_date) : '';
            this.rescheduledScheduleId = item.rescheduled_schedule_id || '';
            this.notes = item.notes || '';
            this.openModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-week text-[#D3AF37]"></i> Daftar Antrean Reschedule Murid
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Daftar murid yang kelasnya diliburkan akibat pelatih izin tanpa pengganti. Tentukan jadwal pengganti untuk setiap murid secara terisolasi per kelas & kategori.</p>
                    </div>
                </div>

                {{-- Status & Category Filters --}}
                <div class="flex flex-wrap items-center justify-between border-b border-gray-200 mb-6 gap-4 pb-4">
                    {{-- Status Tabs --}}
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.reschedule.index', ['status' => 'pending', 'category' => $category]) }}" 
                           class="py-2 px-4 rounded-lg font-semibold text-xs transition flex items-center gap-2 {{ $status === 'pending' ? 'bg-[#101828] text-[#D3AF37]' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Menunggu Reschedule
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-amber-400 text-[#101828] font-bold">
                                {{ \App\Models\RescheduleQueue::where('status', 'pending')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.reschedule.index', ['status' => 'rescheduled', 'category' => $category]) }}" 
                           class="py-2 px-4 rounded-lg font-semibold text-xs transition flex items-center gap-2 {{ $status === 'rescheduled' ? 'bg-[#101828] text-[#D3AF37]' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            <i class="fa-solid fa-circle-check"></i>
                            Sudah Di-reschedule
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-green-500 text-white font-bold">
                                {{ \App\Models\RescheduleQueue::where('status', 'rescheduled')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('admin.reschedule.index', ['status' => 'all', 'category' => $category]) }}" 
                           class="py-2 px-4 rounded-lg font-semibold text-xs transition flex items-center gap-2 {{ $status === 'all' ? 'bg-[#101828] text-[#D3AF37]' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Semua Status
                        </a>
                    </div>

                    {{-- Category Filter --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-500">Kategori:</span>
                        <a href="{{ route('admin.reschedule.index', ['status' => $status, 'category' => 'all']) }}" 
                           class="px-3 py-1 text-xs rounded-full border {{ $category === 'all' ? 'bg-[#D3AF37] text-[#101828] font-extrabold border-[#D3AF37]' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.reschedule.index', ['status' => $status, 'category' => 'belajar']) }}" 
                           class="px-3 py-1 text-xs rounded-full border {{ $category === 'belajar' ? 'bg-[#D3AF37] text-[#101828] font-extrabold border-[#D3AF37]' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                            Belajar
                        </a>
                        <a href="{{ route('admin.reschedule.index', ['status' => $status, 'category' => 'prestasi']) }}" 
                           class="px-3 py-1 text-xs rounded-full border {{ $category === 'prestasi' ? 'bg-[#D3AF37] text-[#101828] font-extrabold border-[#D3AF37]' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                            Prestasi
                        </a>
                    </div>
                </div>

                {{-- Tabel Queue --}}
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Murid</th>
                                <th scope="col" class="px-6 py-3">Kelas & Kategori</th>
                                <th scope="col" class="px-6 py-3">Sesi Asal (Diliburkan)</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3">Jadwal Pengganti</th>
                                <th scope="col" class="px-4 py-3 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($queues as $index => $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        {{ ($queues->currentPage() - 1) * $queues->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $item->student->name }}</div>
                                        <div class="text-xs text-gray-400">Ortu: {{ $item->student->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $item->swimmingClass->name ?? '-' }}</div>
                                        @php
                                            $catSlug = strtolower($item->swimmingClass->category->slug ?? 'belajar');
                                        @endphp
                                        <span class="inline-block mt-1 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full {{ $catSlug === 'prestasi' ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-cyan-100 text-cyan-800 border border-cyan-300' }}">
                                            {{ ucfirst($catSlug) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-amber-700">
                                            <i class="fa-solid fa-calendar-xmark mr-1"></i> {{ $item->original_date->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            Coach Izin: <span class="font-semibold text-gray-700">{{ $item->coachLeave->coach->name ?? '-' }}</span>
                                        </div>
                                        <div class="text-[11px] text-gray-400">
                                            {{ $item->schedule->day_name ?? '' }} ({{ $item->schedule->time_range ?? '' }}) @ {{ $item->schedule->location->name ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status === 'rescheduled')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full border border-green-200">
                                                Sudah Reschedule
                                            </span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-200 animate-pulse">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->status === 'rescheduled' && $item->rescheduled_date)
                                            <div class="font-bold text-green-700">
                                                <i class="fa-solid fa-calendar-check mr-1"></i> {{ $item->rescheduled_date->translatedFormat('d F Y') }}
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                Coach: {{ $item->rescheduledSchedule->coach->name ?? '-' }}
                                            </div>
                                            <div class="text-[11px] text-gray-400">
                                                {{ $item->rescheduledSchedule->time_range ?? '' }} @ {{ $item->rescheduledSchedule->location->name ?? '' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum diatur</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <button @click="openRescheduleModal({{ json_encode($item) }})" 
                                                class="px-3 py-1.5 bg-[#101828] hover:bg-black text-[#D3AF37] font-bold text-xs rounded-lg transition shadow-sm flex items-center justify-center gap-1.5 mx-auto">
                                            <i class="fa-solid fa-calendar-plus"></i>
                                            {{ $item->status === 'rescheduled' ? 'Ubah' : 'Reschedule' }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                        <i class="fa-solid fa-calendar-check text-4xl mb-2 text-gray-300"></i>
                                        <p class="font-semibold text-sm">Tidak ada antrean reschedule murid.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $queues->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Reschedule --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-60 backdrop-blur-sm" @click="openModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-boxdark rounded-2xl shadow-2xl border border-gray-200 dark:border-strokedark">
                    <div class="flex items-center justify-between border-b border-gray-200 dark:border-strokedark pb-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-calendar-plus text-[#D3AF37]"></i> Atur Jadwal Pengganti
                        </h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <template x-if="selectedItem">
                        <form :action="'/admin/reschedule/' + selectedItem.id" method="POST" class="space-y-4">
                            @csrf
                            <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-3.5 text-xs text-amber-200">
                                <p class="font-bold mb-1 text-amber-400" x-text="'Murid: ' + selectedItem.student.name"></p>
                                <p class="text-slate-300" x-text="'Kelas Spesifik: ' + (selectedItem.swimming_class && selectedItem.swimming_class.category ? selectedItem.swimming_class.category.name : '-') + ' — ' + (selectedItem.swimming_class ? selectedItem.swimming_class.name : '-')"></p>
                                <p class="mt-1 text-amber-300/80" x-text="'Diliburkan pada: ' + formatDate(selectedItem.original_date)"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1">Pilih Sesi & Pelatih Pengganti <span class="text-red-500">*</span></label>
                                <div class="mb-2 text-[11px] text-[#D3AF37] font-semibold flex items-center gap-1" x-show="selectedItem && selectedItem.swimming_class">
                                    <i class="fa-solid fa-filter text-[10px]"></i> Dikunci khusus untuk kelas: <span class="underline font-bold" x-text="(selectedItem.swimming_class.category ? selectedItem.swimming_class.category.name : 'Kelas') + ' — ' + selectedItem.swimming_class.name"></span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                                    <template x-for="sched in filteredSchedules" :key="sched.id">
                                        <label class="flex items-start gap-3 p-3 border rounded-xl cursor-pointer transition-all duration-150 text-sm"
                                               @click="selectSchedule(sched)"
                                               :class="String(rescheduledScheduleId) === String(sched.id) 
                                                   ? 'border-[#D3AF37] bg-[#D3AF37]/15 ring-1 ring-[#D3AF37]' 
                                                   : ((sched.current_enrolled_count || 0) >= (sched.capacity_limit || 4)
                                                       ? 'border-rose-500/30 bg-rose-500/5 hover:border-rose-500/50'
                                                       : 'border-gray-200 dark:border-strokedark bg-white dark:bg-meta-4 hover:border-[#D3AF37]/60')">
                                            <input type="radio" name="rescheduled_schedule_id" :value="sched.id" x-model="rescheduledScheduleId" required
                                                   class="mt-1 rounded-full border-gray-300 text-[#D3AF37] focus:ring-[#D3AF37] h-4 w-4 shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="font-bold text-gray-900 dark:text-white text-xs" x-text="sched.day_name + ', ' + sched.time_range"></span>
                                                    <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"
                                                          :class="sched.session_type === 'swim' ? 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/30' : 'bg-orange-500/20 text-orange-400 border border-orange-500/30'"
                                                          x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                </div>
                                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                                                    <i class="fa-solid fa-map-pin text-[#D3AF37] mr-1"></i>
                                                    <span x-text="sched.location ? sched.location.name : 'Kolam'"></span>
                                                </span>
                                                <span class="block text-xs text-gray-600 dark:text-gray-300 mt-0.5 truncate">
                                                    <i class="fa-solid fa-user-tie text-[#D3AF37] mr-1"></i>Pelatih: 
                                                    <span class="font-semibold text-gray-800 dark:text-white" x-text="sched.coach ? sched.coach.name : 'Belum Diatur'"></span>
                                                </span>
                                                <span class="block text-[10px] font-extrabold mt-1.5"
                                                      :class="(sched.current_enrolled_count || 0) >= (sched.capacity_limit || 4) ? 'text-rose-400' : 'text-emerald-400'"
                                                      x-text="(sched.current_enrolled_count || 0) + '/' + (sched.capacity_limit || 4) + ' Terisi' + ((sched.current_enrolled_count || 0) >= (sched.capacity_limit || 4) ? ' (Penuh)' : '')"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>

                                <template x-if="filteredSchedules.length === 0">
                                    <div class="p-3.5 bg-rose-500/10 border border-rose-500/30 rounded-xl text-xs text-rose-300 flex items-start gap-2.5 mt-2">
                                        <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base mt-0.5 shrink-0"></i>
                                        <div>
                                            <strong class="font-bold block mb-0.5">Tidak Ada Jadwal Berkelanjutan:</strong>
                                            Belum ada jadwal aktif lain yang terdaftar khusus untuk kelas ini. Silakan buat jadwal baru terlebih dahulu di menu <strong>Kelola Jadwal</strong>.
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1">Tanggal Pengganti <span class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <input type="date" id="rescheduled_date" name="rescheduled_date" x-model="rescheduledDate" required 
                                           class="w-full text-sm border-gray-300 dark:border-strokedark bg-white dark:bg-meta-4 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-[#D3AF37] focus:ring-[#D3AF37] pr-10 cursor-pointer">
                                    <button type="button" onclick="document.getElementById('rescheduled_date').showPicker()"
                                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-[#D3AF37] transition-colors">
                                        <i class="fa-solid fa-calendar-days text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-[11px] text-emerald-400 mt-1 italic flex items-center gap-1" x-show="rescheduledDate">
                                    <i class="fa-solid fa-circle-info"></i> Tanggal otomatis disesuaikan ke hari terdekat: <strong x-text="formatDate(rescheduledDate)"></strong>
                                </p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" x-model="notes" rows="2" placeholder="Catatan untuk orang tua / pelatih..." 
                                          class="w-full text-sm border-gray-300 dark:border-strokedark bg-white dark:bg-meta-4 text-gray-900 dark:text-white rounded-xl shadow-sm focus:border-[#D3AF37] focus:ring-[#D3AF37]"></textarea>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-strokedark">
                                <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-meta-4 rounded-xl hover:bg-gray-200 transition">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2 text-xs font-extrabold text-[#101828] bg-[#D3AF37] hover:bg-[#B89426] rounded-xl transition shadow-md">
                                    Simpan Reschedule
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
