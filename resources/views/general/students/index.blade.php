<x-app-layout title="Umum - Data Pendaftaran">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kursus Saya') }}
        </h2>
    </x-slot>

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
                <span class="font-bold">Error!</span> {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fa-solid fa-address-card text-blue-600 mr-2"></i>Daftar Kursus Saya
                    </h3>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-center w-12">No</th>
                                <th class="px-6 py-3">Nama Peserta</th>
                                <th class="px-6 py-3">Gender</th>
                                <th class="px-6 py-3">Paket Kursus</th>
                                <th class="px-6 py-3">Kolam Latihan</th>
                                <th class="px-6 py-3">Coach / Pelatih</th>
                                <th class="px-6 py-3">Progress Absensi</th>
                                <th class="px-6 py-3 text-center">Status Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $student->name }}
                                        <div class="text-xs text-gray-400 font-normal">Lahir:
                                            {{ $student->birth_date?->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $student->gender_label }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="font-medium text-gray-800">{{ $student->package->name ?? 'Tidak Ada Paket' }}</span>
                                        <div class="text-xs text-gray-400">Total: {{ $student->package->sessions ?? 0 }}
                                            Sesi</div>
                                        @if ($student->package_expires_at)
                                            <div class="text-[10px] text-gray-500 mt-0.5 whitespace-nowrap">
                                                <i class="fa-solid fa-calendar-day mr-0.5"></i>
                                                Batas: {{ $student->package_expires_at->format('d M Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $student->location->name ?? 'Belum Dipilih' }}</td>
                                    <td class="px-6 py-4">
                                        @if ($student->coach)
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold px-2.5 py-1 rounded">
                                                    <i class="fa-solid fa-user-tie mr-1.5"></i>
                                                    {{ $student->coach->name }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Mencari Rekomendasi Admin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $totalSesi = $student->package->sessions ?? 0;
                                            $sesiTerpakai = max(0, $totalSesi - $student->quota_left);
                                            $progressPct =
                                                $totalSesi > 0 ? round(($sesiTerpakai / $totalSesi) * 100) : 0;
                                            $barColor = match (true) {
                                                $progressPct >= 80 => 'bg-red-500',
                                                $progressPct >= 50 => 'bg-amber-400',
                                                default => 'bg-blue-500',
                                            };
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-[70px]">
                                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-300"
                                                    style="width: {{ $progressPct }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                                                {{ $sesiTerpakai }}/{{ $totalSesi }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            Sisa: <span class="font-semibold text-blue-600">{{ $student->quota_left }}
                                                sesi</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php $latestPayment = $student->latestPayment; @endphp
                                        @if ($student->status === 'active')
                                            <span
                                                class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">Aktif</span>
                                        @elseif($student->status === 'suspended')
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-pause mr-1"></i>Dibekukan
                                                ({{ $student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin' }})
                                            </span>
                                        @elseif($student->status === 'inactive')
                                            <span
                                                class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i>Hangus
                                            </span>
                                        @elseif($latestPayment && $latestPayment->status === 'pending')
                                            <span
                                                class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-semibold">Sedang
                                                Diverifikasi</span>
                                        @elseif($latestPayment && $latestPayment->status === 'rejected')
                                            <span
                                                class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">Ditolak
                                                (Konfirmasi Ulang)
                                            </span>
                                        @else
                                            <span
                                                class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">Menunggu
                                                Pembayaran</span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Anda belum
                                        mendaftarkan kursus apapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
