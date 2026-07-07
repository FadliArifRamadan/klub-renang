<x-app-layout title="Admin - Verifikasi Pembayaran">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pembayaran Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 font-medium flex items-center">
                    <i class="fa-solid fa-circle-check mr-2 text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200 font-medium flex items-center">
                    <i class="fa-solid fa-circle-xmark mr-2 text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white/90 mb-4">
                    <i class="fa-solid fa-money-bill-wave text-emerald-600 mr-2"></i>Daftar Persetujuan Pembayaran
                    Kursus
                </h3>

                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border dark:border-gray-700">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-3">Nama Murid</th>
                                <th class="px-6 py-3">Paket Kursus</th>
                                <th class="px-6 py-3">Nominal Transfer</th>
                                <th class="px-6 py-3">Bukti Transfer</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white/90">
                                        {{ $payment->student->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $payment->student->package->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-emerald-600">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Gunakan asset storage path untuk standard upload, fallback ke receipts folder lama --}}
                                        @php
                                            $imagePath = file_exists(public_path('receipts/' . $payment->receipt_path))
                                                ? asset('receipts/' . $payment->receipt_path)
                                                : asset('storage/receipts/' . $payment->receipt_path);
                                        @endphp
                                        <a href="{{ $imagePath }}" target="_blank"
                                            class="inline-block group relative">
                                            <img src="{{ $imagePath }}" alt="Bukti Transfer"
                                                class="w-16 h-12 object-cover rounded border border-gray-300 shadow-sm group-hover:opacity-75 transition">
                                            <span
                                                class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-[10px] text-white rounded-b opacity-0 group-hover:opacity-100 transition text-center">
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

                                            <x-modal
                                                name="confirm-payment-verification-{{ $payment->student->id ?? $payment->id }}"
                                                focusable>
                                                <form method="post"
                                                    action="{{ route('admin.payments.approve', $payment->student_id) }}"
                                                    class="p-6 text-left dark:bg-gray-800">
                                                    @csrf

                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-emerald-600 mb-4">
                                                        <i class="fa-solid fa-circle-check text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                            Verifikasi & Alokasi Pelatih (Coach)
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                                                        Konfirmasi pembayaran sebesar
                                                        <span class="font-bold text-emerald-600">Rp
                                                            {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                                        dari anak bernama <span
                                                            class="font-bold text-gray-900 dark:text-white/90">"{{ $payment->student->name ?? 'Murid' }}"</span>.
                                                    </p>

                                                    <div class="mb-5 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 p-4 rounded-xl">
                                                        <label
                                                            class="block text-xs font-bold uppercase tracking-wider text-blue-800 dark:text-blue-400 mb-2">
                                                            <i class="fa-solid fa-user-tie mr-1"></i> Penetapan /
                                                            Penggantian Pelatih Murid:
                                                        </label>

                                                        <select name="coach_id" required
                                                            class="w-full text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                            @foreach ($coaches as $coach)
                                                                <option value="{{ $coach->id }}"
                                                                    {{ old('coach_id', $payment->student->coach_id ?? '') == $coach->id ? 'selected' : '' }}>
                                                                    {{ $coach->name }} — (Saat ini memegang: {{ $coach->students_count }} / 15 Murid Latih)
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <p class="text-[11px] text-blue-600 dark:text-blue-400 mt-1.5 leading-tight">
                                                            *Sistem menampilkan jumlah beban murid aktif dari masing-masing coach saat ini. Sesuai kesepakatan, batas maksimal per pelatih adalah 15 anak demi efektivitas latihan.
                                                        </p>
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>
                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150">
                                                            Ya, Setujui & Aktifkan Murid
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
                                                <form method="post"
                                                    action="{{ route('admin.payments.reject', $payment->id) }}"
                                                    class="p-6 text-left dark:bg-gray-800">
                                                    @csrf
                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white/90">
                                                            Apakah Anda yakin ingin menolak pembayaran ini?
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                                        Tindakan ini tidak dapat dibatalkan secara otomatis. Status
                                                        transaksi milik <span
                                                            class="font-bold text-gray-900 dark:text-white/90">"{{ $payment->student->name ?? 'Murid' }}"</span>
                                                        akan ditandai sebagai <span
                                                            class="font-bold text-red-600">Rejected (Ditolak)</span>.
                                                        Gunakan opsi ini jika bukti transfer palsu, nominal tidak
                                                        sesuai, atau dana belum masuk ke rekening klub.
                                                    </p>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Batal
                                                        </x-secondary-button>

                                                        <button type="submit"
                                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 italic">
                                        <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300 dark:text-gray-600"></i>
                                        Saat ini tidak ada ajuan konfirmasi pembayaran baru dari Parent.
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
