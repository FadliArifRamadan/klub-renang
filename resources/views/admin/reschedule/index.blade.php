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
        openRescheduleModal(item) {
            this.selectedItem = item;
            this.rescheduledDate = '';
            this.rescheduledScheduleId = '';
            this.notes = '';
            this.openModal = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-week text-[#D3AF37]"></i> Daftar Antrean Reschedule Murid
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Daftar murid yang kelasnya diliburkan akibat pelatih izin tanpa pengganti. Tentukan jadwal pengganti untuk setiap murid secara terisolasi per kategori kelas.</p>
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

                <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-2xl border border-gray-200">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-plus text-[#D3AF37]"></i> Atur Jadwal Pengganti
                        </h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <template x-if="selectedItem">
                        <form :action="'/admin/reschedule/' + selectedItem.id" method="POST" class="space-y-4">
                            @csrf
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 text-xs text-amber-900">
                                <p class="font-bold mb-1" x-text="'Murid: ' + selectedItem.student.name"></p>
                                <p x-text="'Kelas: ' + (selectedItem.swimming_class ? selectedItem.swimming_class.name : '-') + ' (' + (selectedItem.swimming_class && selectedItem.swimming_class.category ? selectedItem.swimming_class.category.name : '-') + ')'"></p>
                                <p class="mt-1 text-amber-800" x-text="'Diliburkan pada: ' + selectedItem.original_date"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Pengganti <span class="text-red-500">*</span></label>
                                <input type="date" name="rescheduled_date" x-model="rescheduledDate" required 
                                       class="w-full text-sm border-gray-300 rounded-xl shadow-sm focus:border-[#D3AF37] focus:ring-[#D3AF37]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilih Sesi & Pelatih Pengganti <span class="text-red-500">*</span></label>
                                <select name="rescheduled_schedule_id" x-model="rescheduledScheduleId" required 
                                        class="w-full text-sm border-gray-300 rounded-xl shadow-sm focus:border-[#D3AF37] focus:ring-[#D3AF37]">
                                    <option value="">-- Pilih Sesi & Pelatih --</option>
                                    @foreach($availableSchedules as $sched)
                                        @php
                                            $sCat = $sched->swimmingClass->category->name ?? 'Belajar';
                                        @endphp
                                        <option value="{{ $sched->id }}">
                                            [{{ $sCat }}] {{ $sched->swimmingClass->name }} - {{ $sched->day_name }} ({{ $sched->time_range }}) @ {{ $sched->location->name ?? '' }} - Coach: {{ $sched->coach->name ?? 'Belum Diatur' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" x-model="notes" rows="2" placeholder="Catatan untuk orang tua / pelatih..." 
                                          class="w-full text-sm border-gray-300 rounded-xl shadow-sm focus:border-[#D3AF37] focus:ring-[#D3AF37]"></textarea>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
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
