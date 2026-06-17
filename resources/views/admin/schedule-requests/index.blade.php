<x-app-layout title="Admin - Pengajuan Pindah Jadwal">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Pindah Jadwal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200" role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200" role="alert">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b border-gray-100 pb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Daftar Pengajuan Perubahan Jadwal</h3>
                        <p class="text-sm text-gray-500 mt-1">Review dan kelola permohonan pemindahan jadwal latihan mingguan yang diajukan oleh Orang Tua atau Murid Mandiri.</p>
                    </div>
                </div>

                {{-- Status Tabs --}}
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
                    @php
                        $pendingCount = \App\Models\ScheduleChangeRequest::where('status', 'pending')->count();
                        $approvedCount = \App\Models\ScheduleChangeRequest::where('status', 'approved')->count();
                        $rejectedCount = \App\Models\ScheduleChangeRequest::where('status', 'rejected')->count();
                    @endphp
                    <a href="{{ route('admin.schedule-requests.index', ['status' => 'pending']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'pending' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Pending
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $status === 'pending' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $pendingCount }}
                        </span>
                    </a>
                    <a href="{{ route('admin.schedule-requests.index', ['status' => 'approved']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'approved' ? 'border-emerald-600 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-circle-check"></i>
                        Disetujui
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            {{ $approvedCount }}
                        </span>
                    </a>
                    <a href="{{ route('admin.schedule-requests.index', ['status' => 'rejected']) }}" 
                       class="py-3 px-5 border-b-2 font-semibold text-sm whitespace-nowrap transition flex items-center gap-2 {{ $status === 'rejected' ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Ditolak
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">
                            {{ $rejectedCount }}
                        </span>
                    </a>
                </div>

                <div class="relative overflow-x-auto border border-gray-100 sm:rounded-xl">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3">Tanggal & Murid</th>
                                <th scope="col" class="px-4 py-3">Diajukan Oleh</th>
                                <th scope="col" class="px-4 py-3">Jadwal Lama</th>
                                <th scope="col" class="px-4 py-3">Jadwal Baru</th>
                                <th scope="col" class="px-4 py-3">Alasan</th>
                                <th scope="col" class="px-4 py-3 text-center w-48">Status / Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $index => $req)
                                <tr class="bg-white border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        {{ ($requests->currentPage() - 1) * $requests->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                                            <i class="fa-solid fa-clock"></i>
                                            {{ $req->created_at->translatedFormat('d M Y, H:i') }}
                                        </div>
                                        <div class="font-bold text-gray-900">{{ $req->student->name }}</div>
                                        <div class="text-[11px] text-gray-500 flex items-center gap-1.5 mt-0.5">
                                            <span class="px-1.5 py-0.5 rounded-full {{ ($req->student->swimmingClass->category->slug ?? '') === 'prestasi' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                                {{ $req->student->swimmingClass->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">{{ $req->user->name }}</div>
                                        <div class="text-[10px] text-gray-400 mt-0.5">
                                            {{ $req->user->role === 'parent' ? 'Orang Tua (Parent)' : 'Mandiri (General)' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1.5">
                                            @forelse($req->old_schedules as $oldSched)
                                                <div class="p-1.5 bg-gray-50 border border-gray-200 rounded-lg text-[11px]">
                                                    <div class="font-bold text-gray-700 flex items-center justify-between">
                                                        <span>{{ $oldSched->day_name }}, {{ $oldSched->time_range }}</span>
                                                        <span class="px-1 py-0.2 rounded text-[9px] {{ $oldSched->session_type === 'dryland' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                                            {{ $oldSched->session_type === 'dryland' ? 'Darat' : 'Air' }}
                                                        </span>
                                                    </div>
                                                    <div class="text-gray-500 text-[10px] mt-0.5 flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-[9px]"></i>
                                                        {{ $oldSched->location->name ?? '-' }}
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-gray-400 italic text-xs">Tidak ada jadwal lama</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1.5">
                                            @forelse($req->new_schedules as $newSched)
                                                <div class="p-1.5 bg-blue-50/50 border border-blue-100 rounded-lg text-[11px]">
                                                    <div class="font-bold text-blue-900 flex items-center justify-between">
                                                        <span>{{ $newSched->day_name }}, {{ $newSched->time_range }}</span>
                                                        <span class="px-1 py-0.2 rounded text-[9px] {{ $newSched->session_type === 'dryland' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                                            {{ $newSched->session_type === 'dryland' ? 'Darat' : 'Air' }}
                                                        </span>
                                                    </div>
                                                    <div class="text-blue-700 text-[10px] mt-0.5 flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-[9px]"></i>
                                                        {{ $newSched->location->name ?? '-' }}
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-gray-400 italic text-xs text-red-500">Tidak ada jadwal baru pilihan</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="text-xs text-gray-700 bg-gray-50/60 p-2.5 rounded-lg border border-gray-100 max-w-[200px] break-words whitespace-pre-line italic">
                                            "{{ $req->reason }}"
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($req->status === 'pending')
                                            <div class="flex flex-col gap-2 justify-center items-center">
                                                <button type="button" 
                                                        x-data=""
                                                        x-on:click="$dispatch('open-modal', 'approve-request-{{ $req->id }}')"
                                                        class="w-full py-1.5 px-3 text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 rounded-lg shadow-sm transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-check"></i> Setujui
                                                </button>

                                                <button type="button" 
                                                        x-data=""
                                                        x-on:click="$dispatch('open-modal', 'reject-request-{{ $req->id }}')"
                                                        class="w-full py-1.5 px-3 text-xs font-bold text-rose-600 bg-white border border-rose-200 hover:bg-rose-50 rounded-lg transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-xmark"></i> Tolak
                                                </button>
                                            </div>

                                            {{-- Approve Modal --}}
                                            <x-modal name="approve-request-{{ $req->id }}" maxWidth="md" focusable>
                                                <form method="POST" action="{{ route('admin.schedule-requests.approve', $req->id) }}" class="p-6 text-left">
                                                    @csrf
                                                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2 text-emerald-600">
                                                        <i class="fa-solid fa-circle-check text-lg"></i> Setujui Pengajuan Jadwal
                                                    </h3>
                                                    <p class="text-xs text-gray-600 mb-4 leading-relaxed">
                                                        Apakah Anda yakin ingin menyetujui pengajuan pindah jadwal murid <strong>{{ $req->student->name }}</strong>? Jadwal (dan lokasi latihan jika relevan) murid akan terupdate secara otomatis.
                                                    </p>

                                                    <div class="flex justify-end gap-2 mt-6">
                                                        <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>
                                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition flex items-center gap-1.5">
                                                            <i class="fa-solid fa-check"></i> Ya, Setujui
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>

                                            {{-- Reject Modal --}}
                                            <x-modal name="reject-request-{{ $req->id }}" maxWidth="md" focusable>
                                                <form method="POST" action="{{ route('admin.schedule-requests.reject', $req->id) }}" class="p-6 text-left">
                                                    @csrf
                                                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2 text-rose-600">
                                                        <i class="fa-solid fa-circle-exclamation text-lg"></i> Tolak Pengajuan Jadwal
                                                    </h3>
                                                    <p class="text-xs text-gray-500 mb-4">
                                                        Masukkan alasan penolakan untuk pengajuan jadwal murid <strong>{{ $req->student->name }}</strong>. Alasan ini akan dikirimkan langsung ke pengguna pembuat pengajuan.
                                                    </p>

                                                    <div class="mb-4">
                                                        <label for="rejection_reason-{{ $req->id }}" class="text-xs font-bold text-gray-700 block mb-1">
                                                            Alasan Penolakan <span class="text-red-500">*</span>
                                                        </label>
                                                        <textarea id="rejection_reason-{{ $req->id }}" name="rejection_reason" rows="3" required
                                                                  placeholder="Tuliskan alasan mengapa pengajuan ini ditolak..."
                                                                  class="w-full text-xs rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50 resize-none"></textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-2">
                                                        <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>
                                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-sm transition flex items-center gap-1">
                                                            <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        @elseif($req->status === 'approved')
                                            <div class="text-left space-y-1">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                                </span>
                                                <div class="text-[9px] text-gray-400">
                                                    Oleh: {{ $req->processor->name ?? '-' }}
                                                </div>
                                                <div class="text-[9px] text-gray-400">
                                                    Tgl: {{ $req->processed_at ? $req->processed_at->translatedFormat('d M Y') : '-' }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-left space-y-1">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">
                                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                                </span>
                                                <div class="text-[9px] text-gray-400">
                                                    Oleh: {{ $req->processor->name ?? '-' }}
                                                </div>
                                                <div class="text-[9px] text-gray-400">
                                                    Tgl: {{ $req->processed_at ? $req->processed_at->translatedFormat('d M Y') : '-' }}
                                                </div>
                                                @if($req->rejection_reason)
                                                    <div class="text-[10px] text-rose-600 bg-rose-50/50 p-2 rounded-lg border border-rose-100 mt-1 italic break-words max-w-[150px]">
                                                        "{{ $req->rejection_reason }}"
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                                            <span>Tidak ada data pengajuan pindah jadwal dengan status ini.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
