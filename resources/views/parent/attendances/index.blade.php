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
                                    <th class="px-6 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Nama Anak</th>
                                    <th class="px-6 py-3">Jenis Sesi</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                    <th class="px-6 py-3">Coach</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attendances as $index => $att)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150 border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center font-semibold">
                                            {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $att->student->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $categorySlug = $att->student->swimmingClass->category->slug ?? '';
                                                $pkgType = $att->student->package->package_type ?? '';
                                                $labels = [
                                                    'regular' => 'Reguler',
                                                    'private' => 'Private',
                                                    'single_session' => 'Single Session',
                                                    'monthly_prestasi' => 'Bulanan Prestasi'
                                                ];
                                            @endphp
                                            @if($categorySlug === 'prestasi')
                                                @if($att->session_type === 'swim')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300">
                                                        <i class="fa-solid fa-person-swimming mr-1"></i> Berenang
                                                    </span>
                                                @elseif($att->session_type === 'dryland')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300">
                                                        <i class="fa-solid fa-dumbbell mr-1"></i> Latihan Darat
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 border border-gray-300">
                                                    {{ $labels[$pkgType] ?? 'Reguler' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $att->location->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                            {{ $att->coach->name ?? '-' }}
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
