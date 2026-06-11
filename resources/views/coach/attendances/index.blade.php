<x-app-layout title="Coach - Riwayat Absensi">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Absensi Murid') }}
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

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-base font-semibold text-gray-800">
                        <i class="fa-solid fa-clipboard-list text-blue-600 mr-2"></i>Riwayat Absensi
                    </h3>
                    <a href="{{ route('coach.attendances.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-lg font-bold shadow-md transition-all text-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-plus"></i> Input Absensi Baru
                    </a>
                </div>

                @if ($attendances->isEmpty())
                    {{-- Empty State --}}
                    <div class="border rounded-lg p-12 text-center text-gray-400">
                        <i class="fa-solid fa-clipboard-list text-4xl mb-3 block text-gray-300"></i>
                        <p class="font-medium text-gray-600">Belum ada data absensi.</p>
                        <p class="text-xs mt-1">Data absensi murid akan muncul di sini setelah Anda menginput absensi.</p>
                    </div>
                @else
                    {{-- Table --}}
                    <div class="relative overflow-x-auto border sm:rounded-lg mb-6">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Nama Murid</th>
                                    <th class="px-6 py-3">Jenis Sesi</th>
                                    <th class="px-6 py-3">Tempat Latihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $att)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors duration-150">
                                        {{-- No --}}
                                        <td class="px-4 py-4 text-center">
                                            {{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($att->date)->translatedFormat('l, d M Y') }}
                                        </td>

                                        {{-- Nama Murid --}}
                                        <td class="px-6 py-4 font-semibold text-gray-900">
                                            {{ $att->student->name ?? '-' }}
                                        </td>

                                        {{-- Jenis Sesi --}}
                                        <td class="px-6 py-4">
                                            @if ($att->session_type === 'swim')
                                                <span class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs font-semibold">
                                                    <i class="fa-solid fa-water"></i> Berenang
                                                </span>
                                            @elseif ($att->session_type === 'dryland')
                                                <span class="inline-flex items-center gap-1.5 text-orange-700 bg-orange-50 px-2.5 py-1 rounded border border-orange-200 text-xs font-semibold">
                                                    <i class="fa-solid fa-person-running"></i> Latihan Darat
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Tempat Latihan --}}
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 text-blue-700 bg-blue-50 px-2.5 py-1 rounded border border-blue-200 text-xs">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $att->location->name ?? '-' }}
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
