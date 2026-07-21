<x-app-layout title="Admin - Kelola Jadwal">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kelola Jadwal Latihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
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

            <div class="bg-white dark:bg-boxdark p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Jadwal Sesi Latihan Mingguan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mengatur jadwal hari, waktu, lokasi kolam, dan jenis sesi (latihan renang/darat) untuk setiap kelas.</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3">
                        <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-schedule-modal')">
                            <i class="fa-solid fa-plus mr-2"></i> Tambah Jadwal Baru
                        </x-primary-button>
                    </div>
                </div>

                {{-- Filter & Pencarian --}}
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                    {{-- Tab Filter Lokasi --}}
                    <div class="flex flex-wrap items-center gap-1.5 bg-slate-50 p-1 rounded-2xl border border-slate-100 w-fit">
                        <a href="{{ route('admin.schedules.index', ['coach_name' => request('coach_name')]) }}" 
                            class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ empty($locationId) ? 'bg-white dark:bg-boxdark text-blue-600 shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800' }}">
                            Semua
                        </a>
                        @foreach($locations as $loc)
                            <a href="{{ route('admin.schedules.index', ['location_id' => $loc->id, 'coach_name' => request('coach_name')]) }}" 
                                class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ $locationId == $loc->id ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                                {{ $loc->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Form Pencarian Coach --}}
                    <form method="GET" action="{{ route('admin.schedules.index') }}" class="flex items-center gap-2 w-full lg:w-auto">
                        @if($locationId)
                            <input type="hidden" name="location_id" value="{{ $locationId }}">
                        @endif
                        <div class="relative w-full lg:w-64">
                            <input type="text" name="coach_name" value="{{ request('coach_name') }}" placeholder="Cari nama pelatih..." 
                                class="w-full pl-9 pr-4 py-2 text-xs border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 shadow-sm">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                        </div>
                        <button type="submit" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow transition-colors flex items-center gap-1.5 shrink-0">
                            <i class="fa-solid fa-filter"></i> Cari
                        </button>
                        @if(request('coach_name'))
                            <a href="{{ route('admin.schedules.index', $locationId ? ['location_id' => $locationId] : []) }}" 
                                class="px-3.5 py-2 border border-gray-300 hover:bg-gray-50 text-gray-600 text-xs font-bold rounded-xl transition-colors flex items-center gap-1.5 shrink-0">
                                <i class="fa-solid fa-rotate-right"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Hari</th>
                                <th scope="col" class="px-6 py-3">Jam Latihan</th>
                                <th scope="col" class="px-6 py-3">Kelas Renang</th>
                                <th scope="col" class="px-6 py-3">Lokasi Kolam</th>
                                <th scope="col" class="px-6 py-3">Pelatih (Coach)</th>
                                <th scope="col" class="px-6 py-3 text-center">Jenis Sesi</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $index => $sched)
                                <tr class="bg-white dark:bg-boxdark border-b hover:bg-gray-50 dark:bg-meta-4">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($schedules->currentPage() - 1) * $schedules->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-100">
                                        {{ $sched->day_name }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">
                                        {{ $sched->time_range }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 dark:text-white font-semibold">{{ $sched->swimmingClass->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $sched->swimmingClass->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-100">
                                        {{ $sched->location->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 dark:text-gray-100 font-medium">
                                        {{ $sched->coach->name ?? 'Belum Ditentukan' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($sched->session_type == 'dryland')
                                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                <i class="fa-solid fa-person-running mr-1"></i> Dryland (Darat)
                                            </span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                <i class="fa-solid fa-water-ladder mr-1"></i> Swim (Renang)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($sched->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-xl shadow-sm border border-[#D3AF37]/30 bg-[#161F30] overflow-hidden" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-schedule-{{ $sched->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-[#D3AF37] bg-[#D3AF37]/15 hover:bg-[#D3AF37] hover:text-[#101828] transition-colors border-r border-[#D3AF37]/30"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-schedule-deletion-{{ $sched->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-rose-400 bg-rose-950/40 hover:bg-rose-600 hover:text-white transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-schedule-{{ $sched->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.schedules.update', $sched->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Edit Jadwal Latihan</h3>

                                                <div>
                                                    <x-input-label for="class-{{ $sched->id }}" value="Kelas Renang" />
                                                    <select id="class-{{ $sched->id }}" name="swimming_class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        @foreach($swimmingClasses as $cls)
                                                            <option value="{{ $cls->id }}" @selected($cls->id == $sched->swimming_class_id)>{{ $cls->name }} ({{ $cls->category->name }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="location-{{ $sched->id }}" value="Lokasi Kolam" />
                                                    <select id="location-{{ $sched->id }}" name="location_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        @foreach($locations as $loc)
                                                            <option value="{{ $loc->id }}" @selected($loc->id == $sched->location_id)>{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="day-{{ $sched->id }}" value="Hari Latihan" />
                                                    <select id="day-{{ $sched->id }}" name="day_of_week" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="0" @selected($sched->day_of_week == 0)>Senin</option>
                                                        <option value="1" @selected($sched->day_of_week == 1)>Selasa</option>
                                                        <option value="2" @selected($sched->day_of_week == 2)>Rabu</option>
                                                        <option value="3" @selected($sched->day_of_week == 3)>Kamis</option>
                                                        <option value="4" @selected($sched->day_of_week == 4)>Jumat</option>
                                                        <option value="5" @selected($sched->day_of_week == 5)>Sabtu</option>
                                                        <option value="6" @selected($sched->day_of_week == 6)>Minggu</option>
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4 mt-4">
                                                    <div>
                                                        <x-input-label for="start_time-{{ $sched->id }}" value="Jam Mulai" />
                                                        <div class="relative mt-1">
                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                                <i class="fa-regular fa-clock text-gray-500"></i>
                                                            </div>
                                                            <x-text-input id="start_time-{{ $sched->id }}" class="block w-full pr-10" type="time" name="start_time"
                                                                value="{{ substr($sched->start_time, 0, 5) }}" required onclick="this.showPicker()" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <x-input-label for="end_time-{{ $sched->id }}" value="Jam Selesai" />
                                                        <div class="relative mt-1">
                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                                <i class="fa-regular fa-clock text-gray-500"></i>
                                                            </div>
                                                            <x-text-input id="end_time-{{ $sched->id }}" class="block w-full pr-10" type="time" name="end_time"
                                                                value="{{ substr($sched->end_time, 0, 5) }}" required onclick="this.showPicker()" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="session_type-{{ $sched->id }}" value="Jenis Sesi" />
                                                    <select id="session_type-{{ $sched->id }}" name="session_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="swim" @selected($sched->session_type == 'swim')>Renang (Swim)</option>
                                                        <option value="dryland" @selected($sched->session_type == 'dryland')>Latihan Darat (Dryland)</option>
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="coach-{{ $sched->id }}" value="Pelatih / Coach (Opsional)" />
                                                    <select id="coach-{{ $sched->id }}" name="coach_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option value="">-- Tanpa Pelatih --</option>
                                                        @foreach($coaches as $coach)
                                                            <option value="{{ $coach->id }}" @selected($sched->coach_id == $coach->id)>{{ $coach->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="notes-{{ $sched->id }}" value="Catatan Jadwal (Opsional)" />
                                                    <x-text-input id="notes-{{ $sched->id }}" class="block mt-1 w-full" type="text" name="notes"
                                                        value="{{ $sched->notes }}" placeholder="Misal: Bawa karet renang" />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="is_active-{{ $sched->id }}" value="Status Aktif" />
                                                    <select id="is_active-{{ $sched->id }}" name="is_active" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="1" @selected($sched->is_active == 1)>Aktif</option>
                                                        <option value="0" @selected($sched->is_active == 0)>Nonaktif</option>
                                                    </select>
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>
                                                    <x-primary-button>
                                                        Simpan Perubahan
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>

                                        <!-- Delete Modal -->
                                        <x-modal name="confirm-schedule-deletion-{{ $sched->id }}" focusable>
                                            <form method="post" action="{{ route('admin.schedules.destroy', $sched->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white font-bold">
                                                        Apakah Anda yakin ingin menghapus jadwal ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    Jadwal latihan <span class="font-bold text-gray-900 dark:text-white">"{{ $sched->day_name }} {{ $sched->time_range }} di {{ $sched->location->name }}"</span>
                                                    akan dihapus permanen. Murid yang terdaftar pada slot jadwal ini tidak akan bisa terhubung lagi.
                                                </p>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        Ya, Hapus Jadwal
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-400">Belum ada data jadwal sesi latihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $schedules->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-schedule-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.schedules.store') }}" class="p-6 text-left">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Tambah Jadwal Baru</h3>

            <div>
                <x-input-label for="create-class" value="Kelas Renang" />
                <select id="create-class" name="swimming_class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Kelas Renang --</option>
                    @foreach($swimmingClasses as $cls)
                        <option value="{{ $cls->id }}" @selected(old('swimming_class_id') == $cls->id)>{{ $cls->name }} ({{ $cls->category->name }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-location" value="Lokasi Kolam" />
                <select id="create-location" name="location_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Lokasi Kolam --</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" @selected(old('location_id') == $loc->id)>{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-day" value="Hari Latihan" />
                <select id="create-day" name="day_of_week" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Hari --</option>
                    <option value="0" @selected(old('day_of_week') == '0')>Senin</option>
                    <option value="1" @selected(old('day_of_week') == '1')>Selasa</option>
                    <option value="2" @selected(old('day_of_week') == '2')>Rabu</option>
                    <option value="3" @selected(old('day_of_week') == '3')>Kamis</option>
                    <option value="4" @selected(old('day_of_week') == '4')>Jumat</option>
                    <option value="5" @selected(old('day_of_week') == '5')>Sabtu</option>
                    <option value="6" @selected(old('day_of_week') == '6')>Minggu</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="create-start" value="Jam Mulai" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fa-regular fa-clock text-gray-500"></i>
                        </div>
                        <x-text-input id="create-start" class="block w-full pr-10" type="time" name="start_time" :value="old('start_time')" required onclick="this.showPicker()" />
                    </div>
                </div>
                <div>
                    <x-input-label for="create-end" value="Jam Selesai" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fa-regular fa-clock text-gray-500"></i>
                        </div>
                        <x-text-input id="create-end" class="block w-full pr-10" type="time" name="end_time" :value="old('end_time')" required onclick="this.showPicker()" />
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="create-session-type" value="Jenis Sesi" />
                <select id="create-session-type" name="session_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="swim" @selected(old('session_type') == 'swim')>Renang (Swim)</option>
                    <option value="dryland" @selected(old('session_type') == 'dryland')>Latihan Darat (Dryland)</option>
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-coach" value="Pelatih / Coach (Opsional)" />
                <select id="create-coach" name="coach_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="" selected>-- Tanpa Pelatih --</option>
                    @foreach($coaches as $coach)
                        <option value="{{ $coach->id }}" @selected(old('coach_id') == $coach->id)>{{ $coach->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-notes" value="Catatan Jadwal (Opsional)" />
                <x-text-input id="create-notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes')" placeholder="Misal: Bawa karet renang" />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Simpan Jadwal
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
