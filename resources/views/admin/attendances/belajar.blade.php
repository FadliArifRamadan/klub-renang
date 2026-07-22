<x-app-layout title="Admin - Riwayat Absensi Kelas Belajar">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Absensi - Kelas Belajar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:bg-boxdark dark:border-strokedark">
                
                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi Kelas Belajar
                    </h3>

                    {{-- Search Form --}}
                    <form action="{{ route('admin.attendances.belajar') }}" method="GET" class="flex items-center gap-2 flex-nowrap whitespace-nowrap">
                        <div class="relative flex items-center w-48 sm:w-60 shrink-0">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-[#D3AF37] focus:border-[#D3AF37] block w-full pl-9 pr-3 py-2 dark:bg-meta-4 dark:border-strokedark dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cari nama coach/murid...">
                        </div>
                        <button type="submit" class="px-3.5 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-bold rounded-lg transition shadow-sm cursor-pointer whitespace-nowrap shrink-0">
                            Cari
                        </button>
                        <a href="{{ route('admin.attendances.belajar') }}" class="px-3.5 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold rounded-lg transition-all shadow-sm flex items-center gap-1.5 whitespace-nowrap cursor-pointer shrink-0">
                            <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset
                        </a>
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
                                    <th class="px-6 py-3">Nama Murid</th>
                                    <th class="px-6 py-3 text-center">Jenis Sesi</th>
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

                                        {{-- Nama Murid --}}
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ $att->student->name ?? '-' }}
                                        </td>

                                        {{-- Jenis Sesi --}}
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $pkgType = $att->student->package->package_type ?? '';
                                                $labels = [
                                                    'regular' => 'Reguler',
                                                    'private' => 'Private',
                                                    'single_session' => 'Single Session',
                                                    'monthly_prestasi' => 'Bulanan Prestasi'
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center gap-1 text-[#D3AF37] bg-[#D3AF37]/15 px-3 py-1 rounded-md border border-[#D3AF37]/40 text-xs font-bold whitespace-nowrap">
                                                {{ $labels[$pkgType] ?? 'Reguler' }}
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
