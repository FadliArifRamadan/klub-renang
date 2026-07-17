<x-app-layout title="Coach - Pengajuan Izin Latihan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Izin Latihan') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="flex p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                <div><span class="font-bold">Sukses!</span> {{ session('success') }}</div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="flex p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
                <div><span class="font-bold">Gagal!</span> {{ session('error') }}</div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Header & Tombol Tambah --}}
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fa-solid fa-calendar-times text-blue-600 mr-2"></i>
                            Riwayat Pengajuan Izin Saya
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Daftar pengajuan izin berhalangan melatih dan pelatih pengganti yang ditugaskan.</p>
                    </div>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-leave-modal')">
                        <i class="fa-solid fa-file-signature mr-2"></i> Ajukan Izin Baru
                    </x-primary-button>
                </div>

                {{-- Tabel Riwayat Izin --}}
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-center w-12">No</th>
                                <th class="px-6 py-3">Tanggal Izin</th>
                                <th class="px-6 py-3">Alasan Izin</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3">Pelatih Pengganti / Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $index => $leave)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900">
                                        {{ ($leaves->currentPage() - 1) * $leaves->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">
                                        {{ $leave->leave_date->translatedFormat('d F Y') }}
                                        <div class="text-[10px] font-normal text-gray-400">Hari {{ $leave->leave_date->translatedFormat('l') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $leave->reason }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($leave->status === 'approved')
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Disetujui
                                            </span>
                                        @elseif($leave->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                <i class="fa-solid fa-hourglass-half text-[10px]"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($leave->status === 'approved')
                                            @if($leave->substitute_coach_id)
                                                <div class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-user-tie text-blue-500"></i>
                                                    Pengganti: {{ $leave->substituteCoach->name }}
                                                </div>
                                            @else
                                                <div class="text-sm font-bold text-amber-600 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-calendar-minus"></i>
                                                    Sesi Latihan Diliburkan
                                                </div>
                                            @endif
                                        @elseif($leave->status === 'rejected')
                                            <div class="text-xs text-red-500 font-semibold italic">
                                                Catatan: {{ $leave->rejection_reason ?? '-' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Anda belum pernah mengajukan izin latihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pengajuan Izin --}}
    <x-modal name="create-leave-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('coach.leaves.store') }}" class="p-6 text-left">
            @csrf

            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-file-signature text-blue-600"></i>
                Ajukan Izin Latihan Baru
            </h3>

            {{-- Tanggal Izin --}}
            <div class="mb-4">
                <x-input-label for="leave_date" value="Tanggal Berhalangan Melatih" />
                <div class="relative mt-1">
                    <input type="date" id="leave_date" name="leave_date" value="{{ old('leave_date') }}"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10 cursor-pointer text-sm"
                        required min="{{ date('Y-m-d') }}">
                    <button type="button" onclick="document.getElementById('leave_date').showPicker()"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-calendar-days text-sm"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('leave_date')" class="mt-2" />
            </div>

            {{-- Alasan Izin --}}
            <div class="mb-4">
                <x-input-label for="reason" value="Alasan Izin" />
                <textarea id="reason" name="reason" rows="4" required placeholder="Tulis alasan Anda berhalangan melatih dengan jelas..."
                    class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">{{ old('reason') }}</textarea>
                <x-input-error :messages="$errors->get('reason')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Kirim Pengajuan
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
