<x-app-layout title="Coach - Input Absensi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Absensi Murid') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> {{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> {{ session('error') }}</div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('coach.attendances.store') }}" method="POST">
                    @csrf

                    {{-- Form Meta Informasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border-b pb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fa-solid fa-calendar text-gray-400 mr-1.5"></i>Tanggal Latihan
                            </label>
                            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                required>
                            @error('date')
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
                            <i class="fa-solid fa-users text-blue-600 mr-2"></i>Pilih Murid yang Hadir Latihan
                        </h3>
                        @if ($students->isNotEmpty())
                            <button type="button" id="btn-select-all"
                                class="text-xs text-blue-600 hover:text-blue-800 font-bold transition-all flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 rounded hover:bg-blue-100">
                                <i class="fa-solid fa-square-check"></i>
                                <span id="btn-select-text">Pilih Semua Murid</span>
                            </button>
                        @endif
                    </div>

                    {{-- Daftar Murid --}}
                    @if ($students->isEmpty())
                        <div class="border rounded-lg p-12 text-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-medium text-gray-600">Belum ada murid aktif yang ditugaskan ke Anda.</p>
                            <p class="text-xs mt-1">Hanya murid dengan status "Aktif" yang dapat diabsen.</p>
                        </div>
                    @else
                        <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3 text-center w-16">Kehadiran</th>
                                        <th class="px-6 py-3">Nama Murid</th>
                                        <th class="px-6 py-3">Paket Kursus</th>
                                        <th class="px-6 py-3">Tempat Latihan (Otomatis)</th>
                                        <th class="px-6 py-3 text-center">Sisa Sesi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        @php
                                            $quotaEmpty = $student->quota_left <= 0;
                                        @endphp
                                        <tr
                                            class="bg-white border-b hover:bg-gray-50 transition-colors duration-150 {{ $quotaEmpty ? 'bg-red-50/30' : '' }}">
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
                                                        <i class="fa-solid fa-circle-exclamation"></i> Kuota Habis (0
                                                        Sesi)
                                                    </span>
                                                @else
                                                    <span
                                                        class="text-blue-600 font-bold text-sm bg-blue-50 border border-blue-200 px-3 py-1 rounded-lg">
                                                        {{ $student->quota_left }} Sesi
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('coach.students.index') }}"
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

    {{-- Script untuk tombol Select All --}}
    @if ($students->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnSelectAll = document.getElementById('btn-select-all');
                const btnSelectText = document.getElementById('btn-select-text');
                const checkboxes = document.querySelectorAll('.student-checkbox');
                let allChecked = false;

                btnSelectAll.addEventListener('click', function() {
                    allChecked = !allChecked;
                    checkboxes.forEach(cb => {
                        cb.checked = allChecked;
                    });

                    if (allChecked) {
                        btnSelectText.textContent = "Batalkan Semua Pilihan";
                        btnSelectAll.classList.replace('bg-blue-50', 'bg-red-50');
                        btnSelectAll.classList.replace('text-blue-600', 'text-red-600');
                        btnSelectAll.classList.replace('hover:bg-blue-100', 'hover:bg-red-100');
                    } else {
                        btnSelectText.textContent = "Pilih Semua Murid";
                        btnSelectAll.classList.replace('bg-red-50', 'bg-blue-50');
                        btnSelectAll.classList.replace('text-red-600', 'text-blue-600');
                        btnSelectAll.classList.replace('hover:bg-red-100', 'hover:bg-blue-100');
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
