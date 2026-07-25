<x-app-layout title="Coach - Input Absensi Kelas Prestasi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Absensi Atlet (Kelas Prestasi)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('coach.attendances.prestasi.store') }}" method="POST">
                    @csrf

                    {{-- Form Meta Informasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b pb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-calendar text-gray-400 mr-1.5"></i>Tanggal Latihan
                            </label>
                            <div class="relative">
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 pr-10 cursor-pointer"
                                    required>
                                <button type="button" onclick="document.getElementById('date').showPicker()"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-calendar-days text-lg"></i>
                                </button>
                            </div>
                            @error('date')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="session_type" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-person-running text-gray-400 mr-1.5"></i>Jenis Sesi Latihan
                            </label>
                            <select name="session_type" id="session_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900" required>
                                <option value="swim">Berenang (Swim Session)</option>
                                <option value="dryland">Latihan Darat (Dryland Session)</option>
                            </select>
                            @error('session_type')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-user-tie text-gray-400 mr-1.5"></i>Nama Coach (Pelatih)
                            </label>
                            <input type="text" value="{{ Auth::user()->name }}"
                                class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 cursor-not-allowed"
                                readonly>
                        </div>
                    </div>



                    {{-- Header Table / Select All --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-800">
                            <i class="fa-solid fa-users text-blue-600 mr-2"></i>Pilih Atlet yang Hadir Latihan
                        </h3>
                        @if ($students->isNotEmpty())
                            <button type="button" id="btn-select-all"
                                class="text-xs text-blue-600 hover:text-blue-800 font-bold transition-all flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 rounded hover:bg-blue-100">
                                <i class="fa-solid fa-square-check"></i>
                                <span id="btn-select-text">Pilih Semua Atlet</span>
                            </button>
                        @endif
                    </div>

                    {{-- Daftar Murid --}}
                    @if ($students->isEmpty())
                        <div class="border rounded-lg p-12 text-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-medium text-gray-600">Belum ada atlet aktif yang ditugaskan ke Anda di kelas prestasi.</p>
                            <p class="text-xs mt-1">Hanya atlet dengan status "Aktif" yang dapat diabsen.</p>
                        </div>
                    @else
                        <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-center w-12">No</th>
                                        <th class="px-6 py-3 text-center w-16">Kehadiran</th>
                                        <th class="px-6 py-3">Nama Atlet</th>
                                        <th class="px-6 py-3">Paket Kursus</th>
                                        <th class="px-6 py-3">Tempat Latihan (Otomatis)</th>
                                        <th class="px-6 py-3 text-center">Sisa Sesi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        @php
                                            $quotaEmpty = $student->quota_left <= 0;
                                            $schedulesData = $student->schedules
                                                ->filter(function($s) use ($coachIds) {
                                                    return in_array($s->coach_id, $coachIds);
                                                })
                                                ->map(function($s) {
                                                    return ['day' => $s->day_of_week, 'type' => $s->session_type];
                                                })
                                                ->values()
                                                ->toArray();
                                            $hasSwim = $student->package && !is_null($student->package->swim_sessions) && $student->package->swim_sessions > 0;
                                            $hasDryland = $student->package && !is_null($student->package->dryland_sessions) && $student->package->dryland_sessions > 0;
                                            if ($student->package && is_null($student->package->swim_sessions)) {
                                                $hasSwim = true;
                                                $hasDryland = true;
                                            }
                                        @endphp
                                        <tr data-schedules="{{ json_encode($schedulesData) }}"
                                            data-has-swim="{{ $hasSwim ? '1' : '0' }}"
                                            data-has-dryland="{{ $hasDryland ? '1' : '0' }}"
                                            data-swim-left="{{ $student->swim_sessions_left }}"
                                            data-dryland-left="{{ $student->dryland_sessions_left }}"
                                            class="student-row bg-white border-b hover:bg-gray-50 transition-colors duration-150 {{ $quotaEmpty ? 'bg-red-50/30' : '' }}">
                                            <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>
                                            {{-- Checkbox --}}
                                            <td class="px-6 py-4 text-center">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                    id="student-{{ $student->id }}"
                                                    class="student-checkbox w-5 h-5 rounded text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-opacity-50 transition cursor-pointer">
                                            </td>

                                            {{-- Nama Murid --}}
                                            <td class="px-6 py-4 font-semibold text-gray-900">
                                                <label for="student-{{ $student->id }}" class="cursor-pointer block">
                                                    {{ $student->name }}
                                                    <span class="text-xs text-gray-400 font-normal block mt-0.5">
                                                        {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </span>
                                                </label>
                                            </td>

                                            {{-- Paket --}}
                                            <td class="px-6 py-4">
                                                <span class="font-medium text-gray-800">
                                                    {{ $student->package->name ?? 'Tidak Ada Paket' }}
                                                </span>
                                                <span class="text-xs text-gray-400 block">Total:
                                                    {{ $student->package->sessions ?? 0 }} Sesi</span>
                                            </td>

                                            {{-- Tempat Latihan --}}
                                            <td class="px-6 py-4 font-medium text-gray-700">
                                                <span
                                                    class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    {{ $student->location->name ?? 'Belum Dipilih' }}
                                                </span>
                                            </td>

                                            {{-- Sisa Sesi --}}
                                            <td class="px-6 py-4 text-center">
                                                @if ($quotaEmpty)
                                                    <span
                                                        class="bg-red-100 text-red-800 border border-red-300 text-xs px-2.5 py-1 rounded-full font-bold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-circle-exclamation"></i> Kuota Habis
                                                    </span>
                                                @else
                                                    <div class="flex flex-col gap-1 items-center">
                                                        <span class="text-blue-600 font-bold text-sm bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                                                            {{ $student->quota_left }} Total
                                                        </span>
                                                        @if($student->package && !is_null($student->package->swim_sessions))
                                                            <div class="flex gap-1.5 mt-0.5">
                                                                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold {{ $student->swim_sessions_left > 0 ? 'bg-cyan-100 text-cyan-700' : 'bg-red-100 text-red-700' }}">
                                                                    🏊 {{ $student->swim_sessions_left }}/{{ $student->package->swim_sessions }}
                                                                </span>
                                                                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-bold {{ $student->dryland_sessions_left > 0 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700' }}">
                                                                    🏋 {{ $student->dryland_sessions_left }}/{{ $student->package->dryland_sessions ?? 0 }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="empty-state-row" style="display: none;">
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-gray-50/50">
                                            <i class="fa-solid fa-calendar-xmark text-3xl mb-3 text-gray-400"></i>
                                            <p class="font-medium text-gray-600">Tidak ada jadwal atlet pada tanggal dan sesi ini.</p>
                                            <p class="text-xs mt-1 text-gray-400">Silakan pilih tanggal atau jenis sesi yang lain.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('coach.attendances.prestasi.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 border rounded-lg font-medium transition-all text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-bold shadow-md transition-all text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Absensi
                            </button>
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>

    @if ($students->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnSelectAll = document.getElementById('btn-select-all');
                const btnSelectText = document.getElementById('btn-select-text');
                const checkboxes = document.querySelectorAll('.student-checkbox');
                let allChecked = false;

                btnSelectAll.addEventListener('click', function() {
                    allChecked = !allChecked;
                    const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                        return cb.closest('.student-row').style.display !== 'none' && !cb.disabled;
                    });
                    
                    visibleCheckboxes.forEach(cb => {
                        cb.checked = allChecked;
                    });

                    if (allChecked) {
                        btnSelectText.textContent = "Batalkan Semua Pilihan";
                        btnSelectAll.classList.replace('bg-blue-50', 'bg-red-50');
                        btnSelectAll.classList.replace('text-blue-600', 'text-red-600');
                        btnSelectAll.classList.replace('hover:bg-blue-100', 'hover:bg-red-100');
                    } else {
                        btnSelectText.textContent = "Pilih Semua Atlet";
                        btnSelectAll.classList.replace('bg-red-50', 'bg-blue-50');
                        btnSelectAll.classList.replace('text-red-600', 'text-blue-600');
                        btnSelectAll.classList.replace('hover:bg-red-100', 'hover:bg-blue-100');
                    }
                });

                const sessionTypeSelect = document.getElementById('session_type');
                const dateInput = document.getElementById('date');
                const studentRows = document.querySelectorAll('.student-row');

                function getPhpDayOfWeek(dateString) {
                    const parts = dateString.split('-');
                    const date = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    if (isNaN(date.getTime())) return -1;
                    const jsDay = date.getDay();
                    return jsDay === 0 ? 6 : jsDay - 1;
                }

                function filterStudents() {
                    const selectedType = sessionTypeSelect.value;
                    const selectedDate = dateInput.value;
                    const selectedDow = getPhpDayOfWeek(selectedDate);
                    
                    studentRows.forEach(row => {
                        const schedules = JSON.parse(row.dataset.schedules || '[]');
                        const hasSwim = row.dataset.hasSwim === '1';
                        const hasDryland = row.dataset.hasDryland === '1';
                        const cb = row.querySelector('.student-checkbox');
                        
                        const hasScheduleOnDayAndType = selectedDow >= 0 && schedules.some(s => s.day === selectedDow && s.type === selectedType);
                        const packageHasSession = selectedType === 'swim' ? hasSwim : hasDryland;
                        const isMatch = hasScheduleOnDayAndType && packageHasSession;
                        
                        if (isMatch) {
                            row.style.display = '';
                            
                            const swimLeft = parseInt(row.dataset.swimLeft || '0');
                            const drylandLeft = parseInt(row.dataset.drylandLeft || '0');
                            const sessionsLeft = selectedType === 'swim' ? swimLeft : drylandLeft;
                            
                            const oldBadge = row.querySelector('.quota-warning-badge');
                            if (oldBadge) oldBadge.remove();
                            
                            if (sessionsLeft <= 0) {
                                if (cb) {
                                    cb.checked = false;
                                    cb.disabled = true;
                                    cb.classList.add('opacity-30', 'cursor-not-allowed');
                                    cb.classList.remove('cursor-pointer');
                                }
                                row.classList.add('opacity-50');
                                
                                const nameCell = row.querySelectorAll('td')[2];
                                if (nameCell) {
                                    const badge = document.createElement('span');
                                    badge.className = 'quota-warning-badge block text-[10px] mt-0.5 px-1.5 py-0.5 rounded bg-red-100 text-red-600 font-bold w-fit';
                                    badge.textContent = selectedType === 'swim' ? '⚠ Kuota Renang Habis' : '⚠ Kuota Darat Habis';
                                    nameCell.appendChild(badge);
                                }
                            } else {
                                if (cb) {
                                    cb.disabled = false;
                                    cb.classList.remove('opacity-30', 'cursor-not-allowed');
                                    cb.classList.add('cursor-pointer');
                                }
                                row.classList.remove('opacity-50');
                            }
                        } else {
                            row.style.display = 'none';
                            if (cb) {
                                cb.checked = false;
                                cb.disabled = false;
                                cb.classList.remove('opacity-30', 'cursor-not-allowed');
                                cb.classList.add('cursor-pointer');
                            }
                            row.classList.remove('opacity-50');
                            const oldBadge = row.querySelector('.quota-warning-badge');
                            if (oldBadge) oldBadge.remove();
                        }
                    });

                    const emptyStateRow = document.getElementById('empty-state-row');
                    const visibleRows = Array.from(studentRows).filter(r => r.style.display !== 'none' && !r.id);
                    if (visibleRows.length === 0) {
                        if(emptyStateRow) emptyStateRow.style.display = '';
                    } else {
                        if(emptyStateRow) emptyStateRow.style.display = 'none';
                    }

                    allChecked = false;
                    btnSelectText.textContent = "Pilih Semua Atlet";
                    btnSelectAll.classList.replace('bg-red-50', 'bg-blue-50');
                    btnSelectAll.classList.replace('text-red-600', 'text-blue-600');
                    btnSelectAll.classList.replace('hover:bg-red-100', 'hover:bg-blue-100');
                }

                sessionTypeSelect.addEventListener('change', filterStudents);
                dateInput.addEventListener('change', filterStudents);
                
                // Initial filter on page load
                filterStudents();
            });
        </script>
    @endif
</x-app-layout>
