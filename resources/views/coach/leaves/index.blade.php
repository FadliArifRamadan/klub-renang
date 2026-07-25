<x-app-layout title="Coach - Pengajuan Izin Latihan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Izin Latihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-slate-100 dark:border-strokedark">

                {{-- Header & Tombol Tambah --}}
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-calendar-minus text-[#D3AF37]"></i>
                            Riwayat Pengajuan Izin Saya
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar pengajuan izin berhalangan melatih dan pelatih pengganti yang ditugaskan.</p>
                    </div>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-leave-modal')">
                        <i class="fa-solid fa-file-signature mr-2"></i> Ajukan Izin Baru
                    </x-primary-button>
                </div>

                {{-- Tabel Riwayat Izin --}}
                <div class="relative overflow-x-auto border border-slate-150 dark:border-strokedark sm:rounded-xl">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b border-slate-150 dark:border-strokedark">
                            <tr>
                                <th class="px-6 py-3.5 text-center w-12">No</th>
                                <th class="px-6 py-3.5">Tanggal & Sesi Izin</th>
                                <th class="px-6 py-3.5">Alasan Izin</th>
                                <th class="px-6 py-3.5 text-center">Status</th>
                                <th class="px-6 py-3.5">Pelatih Pengganti / Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $index => $leave)
                                <tr class="bg-white dark:bg-boxdark border-b border-slate-100 dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($leaves->currentPage() - 1) * $leaves->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 dark:text-white text-sm">
                                            {{ $leave->leave_date->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Hari {{ $leave->leave_date->translatedFormat('l') }}</div>
                                        
                                        @if($leave->schedule)
                                            <div class="inline-flex items-center gap-1 mt-1.5 px-2.5 py-1 rounded-md bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 text-xs font-semibold">
                                                <i class="fa-solid fa-clock text-[10px]"></i>
                                                {{ $leave->schedule->time_range }} — {{ $leave->schedule->swimmingClass->name ?? '' }} ({{ $leave->schedule->location->name ?? '' }})
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1 mt-1.5 px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-semibold">
                                                <i class="fa-solid fa-layer-group text-[10px]"></i>
                                                Semua Sesi Hari Ini
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 max-w-xs">
                                        {{ $leave->reason }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($leave->status === 'approved')
                                            <span class="inline-flex items-center gap-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Disetujui
                                            </span>
                                        @elseif($leave->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 bg-rose-100 dark:bg-rose-900/30 text-rose-800 dark:text-rose-300 text-xs font-semibold px-2.5 py-1 rounded-full border border-rose-200 dark:border-rose-800">
                                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                                                <i class="fa-solid fa-hourglass-half text-[10px]"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($leave->status === 'approved')
                                            @if($leave->substitute_coach_id)
                                                <div class="text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-1.5">
                                                    <i class="fa-solid fa-user-tie text-[#D3AF37]"></i>
                                                    Pengganti: {{ $leave->substituteCoach->name }}
                                                </div>
                                            @else
                                                <div class="text-sm font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-calendar-minus"></i>
                                                    Sesi Latihan Diliburkan
                                                </div>
                                            @endif
                                        @elseif($leave->status === 'rejected')
                                            <div class="text-xs text-rose-500 font-semibold italic">
                                                Catatan: {{ $leave->rejection_reason ?? '-' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Anda belum pernah mengajukan izin latihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pengajuan Izin --}}
    <x-modal name="create-leave-modal" maxWidth="lg" focusable>
        <div x-data="{
            leaveDate: '{{ old('leave_date') }}',
            schedules: [],
            loading: false,
            selectAll: true,
            fetchSchedules() {
                if (!this.leaveDate) {
                    this.schedules = [];
                    return;
                }
                this.loading = true;
                fetch('{{ route('coach.leaves.schedules-by-date') }}?date=' + this.leaveDate)
                    .then(res => res.json())
                    .then(data => {
                        this.schedules = data;
                        this.loading = false;
                    })
                    .catch(() => {
                        this.schedules = [];
                        this.loading = false;
                    });
            }
        }" x-init="if (leaveDate) fetchSchedules()" class="p-6 text-left">
            <form method="POST" action="{{ route('coach.leaves.store') }}">
                @csrf

                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-file-signature text-[#D3AF37]"></i>
                    Ajukan Izin Latihan Baru
                </h3>

                {{-- Tanggal Izin --}}
                <div class="mb-4">
                    <x-input-label for="leave_date" value="Tanggal Berhalangan Melatih" />
                    <div class="relative mt-1">
                        <input type="date" id="leave_date" name="leave_date" x-model="leaveDate" @change="fetchSchedules()"
                            class="block w-full border-gray-300 dark:border-strokedark bg-white dark:bg-meta-4 text-gray-900 dark:text-white focus:border-[#D3AF37] focus:ring-[#D3AF37] rounded-xl shadow-sm pr-10 cursor-pointer text-sm"
                            required min="{{ date('Y-m-d') }}">
                        <button type="button" onclick="document.getElementById('leave_date').showPicker()"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-[#D3AF37] transition-colors">
                            <i class="fa-solid fa-calendar-days text-sm"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('leave_date')" class="mt-2" />
                </div>

                {{-- Sesi/Jadwal Latihan yang Diizinkan --}}
                <div class="mb-4" x-show="leaveDate">
                    <x-input-label value="Pilih Sesi / Jam Latihan yang Ingin Diizinkan" />
                    
                    <div x-show="loading" class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                        <i class="fa-solid fa-spinner animate-spin text-[#D3AF37]"></i>
                        Memeriksa jadwal mengajar Anda di tanggal ini...
                    </div>

                    <div x-show="!loading && schedules.length > 0" class="mt-2 space-y-2">
                        <template x-for="(sched, index) in schedules" :key="sched.id">
                            <label class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-meta-4 border border-slate-200 dark:border-strokedark rounded-xl cursor-pointer hover:border-[#D3AF37] transition-colors">
                                <input type="checkbox" name="schedules[]" :value="sched.id" checked
                                    class="mt-0.5 rounded border-slate-300 text-[#D3AF37] focus:ring-[#D3AF37] h-4 w-4">
                                <div class="flex-1">
                                    <div class="font-bold text-xs text-gray-900 dark:text-white" x-text="sched.time_range + ' — ' + sched.class_name"></div>
                                    <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5" x-text="sched.location + ' (' + sched.category + ')'"></div>
                                </div>
                            </label>
                        </template>
                    </div>

                    <template x-if="!loading && schedules.length === 0 && leaveDate">
                        <div class="mt-2 p-3 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50 rounded-xl text-xs text-amber-800 dark:text-amber-300">
                            <i class="fa-solid fa-info-circle mr-1"></i>
                            Tidak ada jadwal latihan regular Anda pada tanggal ini. Izin akan didaftarkan untuk seluruh sesi hari tersebut.
                            <input type="hidden" name="schedules[]" value="all">
                        </div>
                    </template>

                    <x-input-error :messages="$errors->get('schedules')" class="mt-2" />
                </div>

                {{-- Alasan Izin --}}
                <div class="mb-4">
                    <x-input-label for="reason" value="Alasan Izin" />
                    <textarea id="reason" name="reason" rows="3" required placeholder="Tulis alasan Anda berhalangan melatih dengan jelas..."
                        class="block mt-1 w-full text-sm rounded-xl border-gray-300 dark:border-strokedark bg-white dark:bg-meta-4 text-gray-900 dark:text-white shadow-sm focus:border-[#D3AF37] focus:ring focus:ring-[#D3AF37]/20">{{ old('reason') }}</textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3 border-t border-slate-100 dark:border-strokedark pt-4">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>
                    <x-primary-button>
                        Kirim Pengajuan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
