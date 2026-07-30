<x-app-layout title="Admin Finance - Verifikasi & Riwayat Pembayaran">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola & Riwayat Pembayaran Kursus') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: '{{ request('tab', $activeTab ?? 'pending') }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Navigasi Tab --}}
            <div class="flex items-center space-x-2 border-b border-gray-200 dark:border-gray-700 mb-6">
                <button type="button" @click="activeTab = 'pending'"
                    :class="activeTab === 'pending' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-gray-800 border-b-2' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="py-3 px-5 text-sm rounded-t-lg transition-all duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Menunggu Verifikasi</span>
                    @if($pendingPayments->total() > 0)
                        <span class="bg-amber-500 text-slate-950 text-[10px] font-extrabold px-2 py-0.5 rounded-full">
                            {{ $pendingPayments->total() }}
                        </span>
                    @endif
                </button>

                <button type="button" @click="activeTab = 'history'"
                    :class="activeTab === 'history' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold bg-white dark:bg-gray-800 border-b-2' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="py-3 px-5 text-sm rounded-t-lg transition-all duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Riwayat Transaksi</span>
                    <span class="bg-slate-700 text-slate-200 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                        {{ $historyPayments->total() }}
                    </span>
                </button>
            </div>

            {{-- TAB 1: MENUNGGU VERIFIKASI --}}
            <div x-show="activeTab === 'pending'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white/90 mb-4 flex items-center justify-between">
                        <span><i class="fa-solid fa-money-bill-wave text-emerald-600 mr-2"></i>Daftar Persetujuan Pembayaran Kursus</span>
                        <span class="text-xs text-gray-400 font-normal">Memuat {{ $pendingPayments->count() }} dari {{ $pendingPayments->total() }} ajuan</span>
                    </h3>

                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Nama Murid / Wali</th>
                                    <th class="px-6 py-3">Paket Kursus</th>
                                    <th class="px-6 py-3">Nominal Transfer</th>
                                    <th class="px-6 py-3 text-center">Bukti Transfer</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingPayments as $index => $payment)
                                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90 text-center">
                                            {{ ($pendingPayments->currentPage() - 1) * $pendingPayments->perPage() + $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 dark:text-white/90">
                                                {{ $payment->student->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                <i class="fa-solid fa-user-tie mr-1 text-slate-500"></i>Wali: {{ $payment->student->user->name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                {{ $payment->student->package->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-emerald-600">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $imagePath = file_exists(public_path('receipts/' . $payment->receipt_path))
                                                    ? asset('receipts/' . $payment->receipt_path)
                                                    : asset('storage/receipts/' . $payment->receipt_path);
                                            @endphp
                                            <a href="{{ $imagePath }}" target="_blank" class="inline-block group relative">
                                                <img src="{{ $imagePath }}" alt="Bukti Transfer"
                                                    class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                                <span class="absolute bottom-0 left-0 right-0 bg-black/60 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center py-0.5">
                                                    Buka <i class="fa-solid fa-external-link text-[8px]"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'confirm-payment-verification-{{ $payment->student->id ?? $payment->id }}')"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-2 rounded-lg shadow transition flex items-center">
                                                    <i class="fa-solid fa-check mr-1"></i> Setujui
                                                </button>

                                                <x-modal name="confirm-payment-verification-{{ $payment->student->id ?? $payment->id }}" focusable>
                                                    <form method="post" action="{{ route('admin.payments.approve', $payment->student_id) }}" class="p-6 text-left dark:bg-gray-800">
                                                        @csrf
                                                        <div class="flex items-center justify-start space-x-3 text-emerald-600 mb-4">
                                                            <i class="fa-solid fa-circle-check text-2xl"></i>
                                                            <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                                Persetujuan Pembayaran Kursus
                                                            </h2>
                                                        </div>

                                                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                                                            Apakah Anda yakin ingin menyetujui pembayaran sebesar
                                                            <span class="font-bold text-emerald-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                                            dari murid bernama <span class="font-bold text-gray-900 dark:text-white/90">"{{ $payment->student->name ?? 'Murid' }}"</span>?
                                                        </p>

                                                        <div class="mt-6 flex justify-end space-x-3">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                Batal
                                                            </x-secondary-button>
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150">
                                                                Ya, Setujui Pembayaran
                                                            </button>
                                                        </div>
                                                    </form>
                                                </x-modal>

                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'reject-payment-{{ $payment->id }}')"
                                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-2 rounded-lg shadow transition flex items-center">
                                                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                                </button>

                                                <x-modal name="reject-payment-{{ $payment->id }}" focusable>
                                                    <form method="post" action="{{ route('admin.payments.reject', $payment->id) }}" class="p-6 text-left dark:bg-gray-800">
                                                        @csrf
                                                        <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                            <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                                Apakah Anda yakin ingin menolak pembayaran ini?
                                                            </h2>
                                                        </div>

                                                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                            Tindakan ini tidak dapat dibatalkan secara otomatis. Status transaksi milik <span class="font-bold text-gray-900 dark:text-white/90">"{{ $payment->student->name ?? 'Murid' }}"</span> akan ditandai sebagai <span class="font-bold text-red-600">Rejected (Ditolak)</span>.
                                                        </p>

                                                        <div class="mt-6 flex justify-end space-x-3">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                Batal
                                                            </x-secondary-button>
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
                                                                Ya, Tolak
                                                            </button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">
                                            <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300 dark:text-gray-600"></i>
                                            Saat ini tidak ada ajuan konfirmasi pembayaran baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pendingPayments->appends(['tab' => 'pending'])->links() }}
                    </div>
                </div>
            </div>

            {{-- TAB 2: RIWAYAT TRANSAKSI --}}
            <div x-show="activeTab === 'history'" x-transition>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    
                    {{-- Filter & Search Form --}}
                    <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-6 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-xl border border-slate-200 dark:border-slate-700/60">
                        <input type="hidden" name="tab" value="history">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            {{-- Search Input --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Cari Nama Murid / Wali</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..."
                                        class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white pl-8 focus:ring-emerald-500 focus:border-emerald-500">
                                    <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-xs text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Filter Status --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Status Transaksi</label>
                                <select name="history_status" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Status --</option>
                                    <option value="approved" {{ request('history_status') == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                                    <option value="rejected" {{ request('history_status') == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                                </select>
                            </div>

                            {{-- Filter Bulan --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Bulan</label>
                                <select name="month" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Bulan --</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                            {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Filter Tahun --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-1">Tahun</label>
                                <select name="year" class="w-full text-xs rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">-- Semua Tahun --</option>
                                    @for ($y = date('Y'); $y >= 2024; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-end gap-2">
                            @if(request()->hasAny(['search', 'history_status', 'month', 'year']))
                                <a href="{{ route('admin.payments.index', ['tab' => 'history']) }}" class="px-3.5 py-1.5 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-lg border border-slate-600 shadow-sm transition flex items-center gap-1">
                                    <i class="fa-solid fa-rotate-left mr-1"></i>Reset Filter
                                </a>
                            @endif
                            <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow transition">
                                <i class="fa-solid fa-filter mr-1"></i>Terapkan Filter
                            </button>
                        </div>
                    </form>

                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-center w-12">No</th>
                                    <th class="px-6 py-3">Waktu Transaksi</th>
                                    <th class="px-6 py-3">Nama Murid / Wali</th>
                                    <th class="px-6 py-3">Paket Kursus</th>
                                    <th class="px-6 py-3">Nominal Transfer</th>
                                    <th class="px-6 py-3 text-center">Status</th>
                                    <th class="px-6 py-3 text-center">Bukti Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historyPayments as $index => $payment)
                                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90 text-center">
                                            {{ ($historyPayments->currentPage() - 1) * $historyPayments->perPage() + $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-600 dark:text-slate-300">
                                            <div><i class="fa-regular fa-calendar mr-1 text-slate-400"></i>{{ $payment->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d M Y') }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5"><i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ $payment->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 dark:text-white/90 flex items-center gap-1.5">
                                                <span>{{ $payment->student->name ?? ($payment->student_name ?? 'Murid (Telah Dihapus)') }}</span>
                                                @if(!$payment->student)
                                                    <span class="text-[9px] px-1.5 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-300 font-bold rounded">Data Murid Dihapus</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">
                                                <i class="fa-solid fa-user-tie mr-1 text-slate-500"></i>Wali: {{ $payment->student->user->name ?? ($payment->user_name ?? '-') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                                {{ $payment->student->package->name ?? ($payment->package_name ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-emerald-600">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($payment->status === 'approved')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800">
                                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Disetujui
                                                </span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 border border-red-300 dark:border-red-800">
                                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 border border-amber-300 dark:border-amber-800">
                                                    <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $imagePath = file_exists(public_path('receipts/' . $payment->receipt_path))
                                                    ? asset('receipts/' . $payment->receipt_path)
                                                    : asset('storage/receipts/' . $payment->receipt_path);
                                            @endphp
                                            <a href="{{ $imagePath }}" target="_blank" class="inline-block group relative">
                                                <img src="{{ $imagePath }}" alt="Bukti Transfer"
                                                    class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                                <span class="absolute bottom-0 left-0 right-0 bg-black/60 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center py-0.5">
                                                    Lihat <i class="fa-solid fa-external-link text-[8px]"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">
                                            <i class="fa-solid fa-receipt text-2xl block mb-2 text-gray-300 dark:text-gray-600"></i>
                                            Belum ada riwayat transaksi pembayaran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $historyPayments->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
