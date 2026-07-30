<x-app-layout title="Orang Tua - Riwayat Absensi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Absensi Anak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi Anak
                </h3>

                @if($attendances->count() > 0)
                    <div class="overflow-x-auto border sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 text-xs text-gray-700 uppercase border-b">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                    <th class="px-6 py-3">Nama Coach</th>
                                    <th class="px-6 py-3">Nama Anak</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
                                    <th class="px-6 py-3 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attendances as $index => $att)
                                    @php
                                        $categorySlug = $att->student->swimmingClass->category->slug ?? '';
                                        $isPrestasi = ($categorySlug === 'prestasi');
                                        $pkgType = $att->student->package->package_type ?? '';
                                        $labels = [
                                            'regular' => 'Reguler',
                                            'private' => 'Private',
                                            'single_session' => 'Single Session',
                                            'monthly_prestasi' => 'Bulanan Prestasi'
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b">
                                        {{-- No --}}
                                        <td class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-500 font-semibold">
                                            {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}
                                        </td>

                                        {{-- Tempat Latihan --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="inline-flex items-center gap-1.5 text-xs">
                                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                                {{ $att->location->name ?? '-' }}
                                            </span>
                                        </td>

                                        {{-- Nama Coach --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $att->coach->name ?? '-' }}
                                        </td>

                                        {{-- Nama Anak --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            {{ $att->student->name ?? '-' }}
                                        </td>

                                        {{-- Jenis Sesi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($isPrestasi)
                                                @if($att->session_type === 'swim')
                                                    <span class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/30 px-2.5 py-1 rounded border border-cyan-200 dark:border-cyan-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-water"></i> Berenang
                                                    </span>
                                                @elseif($att->session_type === 'dryland')
                                                    <span class="inline-flex items-center gap-1 text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2.5 py-1 rounded border border-orange-200 dark:border-orange-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-cyan-700 dark:text-cyan-300 bg-cyan-50 dark:bg-cyan-900/30 px-2.5 py-1 rounded border border-cyan-200 dark:border-cyan-800 text-xs font-semibold whitespace-nowrap">
                                                        <i class="fa-solid fa-water"></i> Berenang
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/40">
                                                    {{ $labels[$pkgType] ?? 'Reguler' }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Jumlah --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($isPrestasi)
                                                <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold leading-none text-green-700 bg-green-50 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 rounded whitespace-nowrap">
                                                    Ke-{{ $att->session_count ?? 1 }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="text-center py-12 border rounded-lg">
                        <i class="fa-solid fa-calendar-xmark text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 text-lg font-medium">Belum Ada Riwayat Absensi</p>
                        <p class="text-gray-400 text-sm mt-1">Data absensi anak Anda akan muncul di sini setelah coach mencatat kehadiran mereka.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
