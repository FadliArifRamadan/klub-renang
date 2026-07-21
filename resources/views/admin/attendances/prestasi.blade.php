<x-app-layout title="Admin - Riwayat Absensi Kelas Prestasi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Absensi - Kelas Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:bg-boxdark dark:border-strokedark">
                
                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi Kelas Prestasi
                    </h3>

                    {{-- Search Form --}}
                    <form action="{{ route('admin.attendances.prestasi') }}" method="GET" class="flex gap-2">
                        <div class="relative w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 dark:bg-meta-4 dark:border-strokedark dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Cari nama coach/atlet...">
                        </div>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.attendances.prestasi') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-meta-4 dark:border-strokedark dark:text-white dark:hover:bg-gray-700 transition-colors">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                @if ($attendances->isEmpty())
                    {{-- Empty State --}}
                    <div class="border border-gray-200 dark:border-strokedark rounded-lg p-12 text-center text-gray-400 dark:text-gray-500">
                        <i class="fa-solid fa-clipboard-list text-4xl mb-3 block text-gray-300 dark:text-gray-600"></i>
                        <p class="font-medium text-gray-600 dark:text-gray-400">Belum ada data absensi yang ditemukan.</p>
                    </div>
                @else
                    {{-- Table --}}
                    <div class="relative overflow-x-auto border border-gray-200 dark:border-strokedark sm:rounded-lg mb-6">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-meta-4 border-b border-gray-200 dark:border-strokedark dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                    <th class="px-6 py-3">Nama Coach</th>
                                    <th class="px-6 py-3">Nama Atlet</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
                                    <th class="px-6 py-3 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $att)
                                    <tr class="bg-white dark:bg-boxdark border-b border-gray-200 dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4 transition-colors duration-150">
                                        {{-- No --}}
                                        <td class="px-4 py-4 text-center">
                                            {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}
                                        </td>

                                        {{-- Tempat Latihan --}}
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            <span class="inline-flex items-center gap-1.5 text-xs">
                                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                                {{ $att->location->name ?? '-' }}
                                            </span>
                                        </td>

                                        {{-- Nama Coach --}}
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $att->coach->name ?? '-' }}
                                        </td>

                                        {{-- Nama Atlet --}}
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ $att->student->name ?? '-' }}
                                        </td>

                                        {{-- Jenis Sesi --}}
                                        <td class="px-6 py-4 text-center">
                                            @if ($att->session_type === 'swim')
                                                <span class="inline-flex items-center gap-1 text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-1 rounded border border-blue-200 dark:border-blue-800 text-xs font-semibold whitespace-nowrap">
                                                    <i class="fa-solid fa-water"></i> Berenang
                                                </span>
                                            @elseif ($att->session_type === 'dryland')
                                                <span class="inline-flex items-center gap-1 text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 px-2.5 py-1 rounded border border-orange-200 dark:border-orange-800 text-xs font-semibold whitespace-nowrap">
                                                    <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                </span>
                                            @endif
                                        </td>

                                         {{-- Jumlah (Sesi ke-n) --}}
                                         <td class="px-6 py-4 text-center">
                                             <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold leading-none text-green-700 bg-green-50 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800 rounded whitespace-nowrap">
                                                 Ke-{{ $att->session_count ?? 1 }}
                                             </span>
                                         </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $attendances->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
