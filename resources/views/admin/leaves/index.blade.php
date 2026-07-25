<x-app-layout title="Admin - Persetujuan Izin Pelatih">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Izin Pelatih') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Kelola Pengajuan Izin Pelatih</h3>
                    <p class="text-xs text-gray-500 mt-1">Review pengajuan izin berhalangan melatih, tugaskan pelatih pengganti, atau liburkan sesi latihan jika pelatih tidak tersedia.</p>
                </div>

                {{-- Status Tabs --}}
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
                    @php
                        $pendingCount = \App\Models\CoachLeave::where('status', 'pending')->count();
                        $approvedCount = \App\Models\CoachLeave::where('status', 'approved')->count();
                        $rejectedCount = \App\Models\CoachLeave::where('status', 'rejected')->count();
                    @endphp
                    <a href="{{ route('admin.leaves.index', ['status' => 'pending']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'pending' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-hourglass-half"></i>
                        Menunggu Persetujuan
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $status === 'pending' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $pendingCount }}
                        </span>
                    </a>
                    <a href="{{ route('admin.leaves.index', ['status' => 'approved']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'approved' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-circle-check"></i>
                        Disetujui
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            {{ $approvedCount }}
                        </span>
                    </a>
                    <a href="{{ route('admin.leaves.index', ['status' => 'rejected']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'rejected' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Ditolak
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            {{ $rejectedCount }}
                        </span>
                    </a>
                </div>

                {{-- Tabel Izin Pelatih --}}
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Pelatih</th>
                                <th scope="col" class="px-6 py-3">Tanggal Izin</th>
                                <th scope="col" class="px-6 py-3">Alasan Izin</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3">Pelatih Pengganti / Info</th>
                                @if($status === 'pending')
                                    <th scope="col" class="px-4 py-3 text-center w-36">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $index => $leave)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        {{ ($leaves->currentPage() - 1) * $leaves->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800">
                                        {{ $leave->coach->name }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-200">
                                        {{ $leave->leave_date->translatedFormat('d F Y') }}
                                        <div class="text-[10px] font-normal text-gray-400">Hari {{ $leave->leave_date->translatedFormat('l') }}</div>
                                        @if($leave->schedule)
                                            <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 text-[11px] font-semibold">
                                                <i class="fa-solid fa-clock text-[10px]"></i> {{ $leave->schedule->time_range }} — {{ $leave->schedule->swimmingClass->name ?? '' }} ({{ $leave->schedule->location->name ?? '' }})
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[11px] font-semibold">
                                                <i class="fa-solid fa-layer-group text-[10px]"></i> Semua Sesi Hari Ini
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                        {{ $leave->reason }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($leave->status === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Disetujui</span>
                                        @elseif($leave->status === 'rejected')
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Ditolak</span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($leave->status === 'approved')
                                            @if($leave->substitute_coach_id)
                                                <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-user-tie text-blue-500"></i>
                                                    Pengganti: {{ $leave->substituteCoach->name }}
                                                </span>
                                            @else
                                                <span class="text-sm font-bold text-amber-600 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-calendar-minus"></i>
                                                    Latihan Diliburkan
                                                </span>
                                            @endif
                                        @elseif($leave->status === 'rejected')
                                            <div class="text-xs text-red-500 font-semibold italic">
                                                Catatan: {{ $leave->rejection_reason ?? '-' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Menunggu keputusan</span>
                                        @endif
                                    </td>
                                    @if($status === 'pending')
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'approve-leave-{{ $leave->id }}')"
                                                    class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1">
                                                    <i class="fa-solid fa-check"></i> Proses
                                                </button>
                                            </div>

                                            {{-- Modal Proses Izin (Approval/Substitusi) --}}
                                            <x-modal name="approve-leave-{{ $leave->id }}" maxWidth="lg" focusable>
                                                <div class="p-6 text-left">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                                                        <i class="fa-solid fa-calendar-times text-blue-600"></i>
                                                        Proses Izin Pelatih: {{ $leave->coach->name }}
                                                    </h3>
                                                    <p class="text-xs text-gray-400 mb-4">
                                                        Izin untuk tanggal: <strong>{{ $leave->leave_date->translatedFormat('d F Y') }}</strong> ({{ $leave->leave_date->translatedFormat('l') }}).
                                                        <br>Alasan: <span class="italic text-gray-600">"{{ $leave->reason }}"</span>
                                                    </p>

                                                    {{-- Daftar Jadwal Bertugas di Tanggal Tersebut --}}
                                                    <div class="mb-4 bg-slate-50 border border-slate-200 rounded-xl p-3">
                                                        <h4 class="text-xs font-bold text-gray-700 mb-2 flex items-center gap-1">
                                                            <i class="fa-solid fa-business-time text-slate-500"></i>
                                                            Jadwal Bertugas Hari Ini:
                                                        </h4>
                                                        @if(isset($leave->schedules) && count($leave->schedules) > 0)
                                                            <ul class="space-y-1.5 text-xs text-gray-600">
                                                                @foreach($leave->schedules as $sched)
                                                                    <li class="flex justify-between border-b border-gray-100 pb-1 last:border-0 last:pb-0">
                                                                        <span>{{ $sched->swimmingClass->name }} ({{ $sched->time_range }})</span>
                                                                        <span class="font-semibold text-gray-700">{{ $sched->location->name }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p class="text-xs text-red-500 italic font-semibold">Tidak ada jadwal latihan regular pelatih di hari {{ $leave->leave_date->translatedFormat('l') }}.</p>
                                                        @endif
                                                    </div>

                                                    <form method="POST" action="{{ route('admin.leaves.approve', $leave->id) }}">
                                                        @csrf

                                                        {{-- Dropdown Pelatih Pengganti --}}
                                                        <div class="mb-4">
                                                            <x-input-label for="substitute_coach_id-{{ $leave->id }}" value="Pilih Pelatih Pengganti / Substitusi" />
                                                            <select id="substitute_coach_id-{{ $leave->id }}" name="substitute_coach_id" 
                                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                                <option value="" selected>-- Latihan Diliburkan (Tidak ada pengganti) --</option>
                                                                
                                                                {{-- Tampilkan Pelatih Pengganti yang Terdaftar di Kelas & Hari yang Sama Persis --}}
                                                                @if(isset($leave->eligible_substitutes) && $leave->eligible_substitutes->isNotEmpty())
                                                                    <optgroup label="Pelatih Mengajar {{ $leave->target_class_name ?? '' }} (Hari {{ $leave->target_day_name ?? '' }})">
                                                                        @foreach($leave->eligible_substitutes as $recCoach)
                                                                            <option value="{{ $recCoach->id }}">{{ $recCoach->name }} (Bertugas Hari {{ $leave->target_day_name ?? '' }})</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                            @if(!isset($leave->eligible_substitutes) || $leave->eligible_substitutes->isEmpty())
                                                                <div class="mt-3.5 p-3.5 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-300 text-xs flex items-start gap-3 shadow-sm">
                                                                    <i class="fa-solid fa-triangle-exclamation text-amber-400 text-base mt-0.5 shrink-0"></i>
                                                                    <div class="leading-relaxed">
                                                                        <span class="font-bold text-amber-400 block mb-0.5">Informasi Pelatih Pengganti:</span>
                                                                        <p class="text-amber-200/90">
                                                                            Tidak ada pelatih lain yang mengajar <strong class="text-white font-semibold">{{ $leave->target_class_name ?? '' }}</strong> pada hari <strong class="text-white font-semibold">{{ $leave->target_day_name ?? '' }}</strong>.
                                                                        </p>
                                                                        <p class="mt-1.5 text-[11px] text-amber-300/75">
                                                                            *Pilih opsi <strong>Latihan Diliburkan</strong> agar murid pada sesi ini otomatis masuk ke Antrean Reschedule.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <small class="text-gray-400 mt-1.5 block">*Jika diliburkan, murid tidak akan dipotong kuotanya dan mendapat notifikasi libur.</small>
                                                            @endif
                                                        </div>

                                                        <div class="flex justify-between items-center border-t pt-4 mt-6">
                                                            {{-- Tombol Tolak --}}
                                                            <button type="button" x-data=""
                                                                x-on:click="$dispatch('close'); setTimeout(() => $dispatch('open-modal', 'reject-leave-{{ $leave->id }}'), 200)"
                                                                class="px-3 py-1.5 border border-red-300 hover:bg-red-50 text-red-600 text-xs font-bold rounded-lg transition-colors">
                                                                Tolak Izin
                                                            </button>

                                                            <div class="flex gap-2">
                                                                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                                    Batal
                                                                </x-secondary-button>
                                                                <x-primary-button>
                                                                    Setujui Izin
                                                                </x-primary-button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </x-modal>

                                            {{-- Modal Tolak Izin --}}
                                            <x-modal name="reject-leave-{{ $leave->id }}" maxWidth="lg" focusable>
                                                <form method="POST" action="{{ route('admin.leaves.reject', $leave->id) }}" class="p-6 text-left">
                                                    @csrf

                                                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2 text-red-600">
                                                        <i class="fa-solid fa-times-circle"></i>
                                                        Tolak Izin Pelatih: {{ $leave->coach->name }}
                                                    </h3>

                                                    <div class="mb-4">
                                                        <x-input-label for="rejection_reason-{{ $leave->id }}" value="Alasan Penolakan Izin" />
                                                        <textarea id="rejection_reason-{{ $leave->id }}" name="rejection_reason" rows="3" required
                                                            placeholder="Tulis alasan mengapa pengajuan izin pelatih ditolak..."
                                                            class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200"></textarea>
                                                        <x-input-error :messages="$errors->get('rejection_reason')" class="mt-2" />
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                                                        <x-secondary-button type="button" x-on:click="$dispatch('close'); setTimeout(() => $dispatch('open-modal', 'approve-leave-{{ $leave->id }}'), 200)">
                                                            Kembali
                                                        </x-secondary-button>
                                                        <x-danger-button>
                                                            Ya, Tolak Izin
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada pengajuan izin pelatih dengan status ini.</td>
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
</x-app-layout>
