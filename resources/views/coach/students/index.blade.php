<x-app-layout title="Coach - Data Murid Saya">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Murid Saya') }}
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

                {{-- Header & Ringkasan --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fa-solid fa-users text-blue-600 mr-2"></i>
                        Daftar Murid Saya
                        <span class="ml-2 bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            {{ $students->count() }} Murid
                        </span>
                    </h3>
                </div>

                {{-- Tabel Data Murid --}}
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">#</th>
                                <th class="px-6 py-3">Nama Murid</th>
                                <th class="px-6 py-3">Paket Kursus</th>
                                <th class="px-6 py-3">Kolam Latihan</th>
                                <th class="px-6 py-3 text-center">Progress Absensi</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                @php
                                    $totalSesi = $student->package->sessions ?? 0;
                                    $sesiTerpakai = $totalSesi - $student->quota_left;
                                    $sesiTerpakai = max(0, $sesiTerpakai); // pastikan tidak negatif
                                    $progressPct = $totalSesi > 0 ? round(($sesiTerpakai / $totalSesi) * 100) : 0;

                                    // Warna progress bar
                                    $barColor = match (true) {
                                        $progressPct >= 80 => 'bg-red-500',
                                        $progressPct >= 50 => 'bg-amber-400',
                                        default => 'bg-blue-500',
                                    };

                                    $latestPayment = $student->latestPayment;
                                @endphp
                                <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium">{{ $index + 1 }}</td>

                                    {{-- Nama & Info --}}
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $student->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            <i class="fa-solid fa-venus-mars mr-1"></i>
                                            {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            &nbsp;·&nbsp;
                                            <i class="fa-solid fa-cake-candles mr-1"></i>
                                            {{ $student->birth_date?->format('d M Y') ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Paket --}}
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800">
                                            {{ $student->package->name ?? 'Tidak Ada Paket' }}
                                        </span>
                                        <div class="text-xs text-gray-400">Total: {{ $totalSesi }} Sesi</div>
                                        @if ($student->package_expires_at)
                                            <div class="text-[10px] text-gray-500 mt-0.5">
                                                <i class="fa-solid fa-calendar-day mr-0.5"></i>
                                                Batas: {{ $student->package_expires_at->format('d M Y') }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Lokasi --}}
                                    <td class="px-6 py-4">
                                        <i class="fa-solid fa-location-dot text-blue-400 mr-1"></i>
                                        {{ $student->location->name ?? 'Belum Dipilih' }}
                                    </td>

                                    {{-- Progress Absensi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-[80px]">
                                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-300"
                                                    style="width: {{ $progressPct }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                                                {{ $sesiTerpakai }} / {{ $totalSesi }} sesi
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1 text-center">
                                            Sisa: <span class="font-semibold text-blue-600">{{ $student->quota_left }}
                                                sesi</span>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($student->status === 'active')
                                            <span
                                                class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-check mr-1"></i>Aktif
                                            </span>
                                        @elseif($student->status === 'suspended')
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-pause mr-1"></i>Dibekukan ({{ $student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin' }})
                                            </span>
                                        @elseif($student->status === 'inactive')
                                            <span
                                                class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i>Hangus
                                            </span>
                                        @else
                                            <span
                                                class="bg-gray-100 text-gray-600 border border-gray-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-clock mr-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fa-solid fa-users-slash text-4xl mb-3 block text-gray-300"></i>
                                        <p class="font-medium">Belum ada murid yang ditugaskan ke Anda.</p>
                                        <p class="text-xs mt-1">Silakan hubungi Admin untuk penugasan murid.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
