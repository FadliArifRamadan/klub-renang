<x-app-layout title="Parent - Menu Pembayaran">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Pembayaran Kursus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    <i class="fa-solid fa-receipt text-blue-600 mr-2"></i>Status Tagihan Pendaftaran Anak
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($students as $student)
                        @php
                            // Ambil data payment terakhir dari relasi eager loaded
                            $latestPayment = $student->latestPayment;
                        @endphp

                        <div class="border rounded-xl p-5 bg-gray-50 shadow-sm relative overflow-hidden">
                            <div class="absolute top-4 right-4">
                                @if ($student->status == 'active' || ($latestPayment && $latestPayment->status == 'approved'))
                                    <span
                                        class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-semibold">Lunas
                                        / Aktif</span>
                                @elseif($latestPayment && $latestPayment->status == 'pending')
                                    <span
                                        class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-semibold">Sedang
                                        Diverifikasi</span>
                                @elseif($latestPayment && $latestPayment->status == 'rejected')
                                    <span
                                        class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-semibold">Pembayaran
                                        Ditolak</span>
                                @else
                                    <span
                                        class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-semibold">Belum
                                        Bayar</span>
                                @endif
                            </div>

                            <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $student->name }}</h4>
                            <p class="text-sm text-gray-500 mb-4">Paket Kursus: <span
                                    class="font-semibold text-gray-700">{{ $student->package->name ?? 'Belum Pilih Paket' }}</span>
                            </p>

                            @if ($latestPayment && $latestPayment->status == 'rejected')
                                <div class="mb-4 p-2.5 text-xs text-red-700 bg-red-50 rounded-lg border border-red-200">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> Konfirmasi pembayaran Anda
                                    ditolak Admin. Silakan periksa kembali nominal transfer Anda dan lakukan konfirmasi
                                    ulang di bawah.
                                </div>
                            @endif

                            <div class="border-t pt-3 mt-3 flex justify-between items-center">
                                <div>
                                    <span class="text-xs text-gray-400 block">Total Tagihan</span>
                                    <span class="text-lg font-extrabold text-blue-600">Rp
                                        {{ number_format($student->package->price ?? 0, 0, ',', '.') }}</span>
                                </div>

                                @if ($student->status == 'active' || ($latestPayment && $latestPayment->status == 'approved'))
                                    <span class="text-green-600 font-bold text-sm"><i
                                            class="fa-solid fa-circle-check mr-1"></i> Selesai / Aktif</span>
                                @elseif($latestPayment && $latestPayment->status == 'pending')
                                    <button disabled
                                        class="px-4 py-2 bg-gray-300 text-gray-500 text-xs font-bold uppercase rounded-lg cursor-not-allowed">
                                        Menunggu Admin
                                    </button>
                                @else
                                    <button type="button" x-data=""
                                        x-on:click="$dispatch('open-modal', 'upload-receipt-{{ $student->id }}')"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-lg shadow transition flex items-center">
                                        <i class="fa-solid fa-upload mr-1.5"></i> Konfirmasi Bayar
                                    </button>

                                    <x-modal name="upload-receipt-{{ $student->id }}" focusable>
                                        <form method="POST"
                                            action="{{ route('parent.payments.checkout', $student->id) }}"
                                            enctype="multipart/form-data" class="p-6 text-left">
                                            @csrf

                                            <div class="flex items-center justify-start space-x-3 text-blue-600 mb-4">
                                                <i class="fa-solid fa-file-invoice-dollar text-2xl"></i>
                                                <h2 class="text-lg font-medium text-gray-900">
                                                    Unggah Bukti Transfer
                                                </h2>
                                            </div>

                                            <div
                                                class="bg-gray-50 border border-gray-200 p-3 rounded-lg mb-4 text-xs text-gray-600">
                                                <p class="mb-1">Silakan transfer sesuai nominal ke rekening berikut:
                                                </p>
                                                <p class="font-bold text-gray-800">Bank BCA: 123-4567-890 (a.n. Klub
                                                    Renang)</p>
                                                <p class="mt-2">Nominal Tagihan: <span
                                                        class="font-bold text-blue-600 text-sm">Rp
                                                        {{ number_format($student->package->price ?? 0, 0, ',', '.') }}</span>
                                                </p>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih
                                                    Screenshot Bukti Transfer (Format: JPG/PNG):</label>
                                                <input type="file" name="receipt_image" accept="image/*" required
                                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md p-1 focus:outline-none focus:border-blue-500">
                                            </div>

                                            <div class="mt-6 flex justify-end space-x-3">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    Batal
                                                </x-secondary-button>

                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                                    Kirim Bukti Transfer
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-6 text-gray-400 italic">
                            Tidak ada data anak yang memerlukan transaksi pembayaran saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
