<x-app-layout title="Admin - Kelola Paket">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Paket Latihan Renang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200"
                    role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Paket Latihan</h3>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-package-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Paket Baru
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Paket</th>
                                <th scope="col" class="px-6 py-3 text-right">Harga</th>
                                <th scope="col" class="px-6 py-3 text-center">Kuota Sesi</th>
                                <th scope="col" class="px-6 py-3 text-center">Masa Berlaku</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $index => $package)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        {{ ($packages->currentPage() - 1) * $packages->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $package->name }}</td>
                                    <td class="px-6 py-4 text-right font-medium text-green-600">Rp
                                        {{ number_format($package->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $package->sessions }}x Pertemuan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $package->active_period_months }} Bulan
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-package-{{ $package->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-amber-600 bg-white border border-gray-200 rounded-l-lg hover:bg-amber-50">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-package-deletion-{{ $package->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-red-600 bg-white border-y border-r border-gray-200 rounded-r-lg hover:bg-red-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-package-{{ $package->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.packages.update', $package->id) }}" class="p-6">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 mb-4 text-left">Edit Paket Latihan</h3>

                                                <div class="text-left">
                                                    <x-input-label for="name-{{ $package->id }}" value="Nama Paket" />
                                                    <x-text-input id="name-{{ $package->id }}" class="block mt-1 w-full" type="text" name="name"
                                                        :value="old('name', $package->name)" placeholder="Misal: Paket Bulanan 4x" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="price-{{ $package->id }}" value="Harga Paket (Rp)" />
                                                    <x-text-input id="price-{{ $package->id }}" class="block mt-1 w-full" type="number" name="price"
                                                        :value="old('price', $package->price)" placeholder="Misal: 350000" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="sessions-{{ $package->id }}" value="Jumlah Pertemuan (Sesi)" />
                                                    <x-text-input id="sessions-{{ $package->id }}" class="block mt-1 w-full" type="number" name="sessions"
                                                        :value="old('sessions', $package->sessions)" placeholder="Misal: 4" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="active_period_months-{{ $package->id }}" value="Masa Berlaku Paket (Bulan)" />
                                                    <x-text-input id="active_period_months-{{ $package->id }}" class="block mt-1 w-full" type="number"
                                                        name="active_period_months" :value="old('active_period_months', $package->active_period_months)" placeholder="Misal: 1" required />
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>
                                                    <x-primary-button>
                                                        Simpan Perubahan
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>

                                        <!-- Delete Modal -->
                                        <x-modal name="confirm-package-deletion-{{ $package->id }}" focusable>
                                            <form method="post" action="{{ route('admin.packages.destroy', $package->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        Apakah Anda yakin ingin menghapus paket ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600">
                                                    Paket <span class="font-bold text-gray-900">"{{ $package->name }}"</span>
                                                    akan dihapus permanen. Murid baru tidak akan bisa memilih paket ini lagi.
                                                </p>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        Ya, Hapus Paket
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-400">Belum ada data paket latihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $packages->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-package-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.packages.store') }}" class="p-6">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 mb-4 text-left">Tambah Paket Baru</h3>

            <div class="text-left">
                <x-input-label for="create-name" value="Nama Paket" />
                <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Misal: Paket Bulanan 4x" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-price" value="Harga Paket (Rp)" />
                <x-text-input id="create-price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" placeholder="Misal: 350000" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-sessions" value="Jumlah Pertemuan (Sesi)" />
                <x-text-input id="create-sessions" class="block mt-1 w-full" type="number" name="sessions" :value="old('sessions')" placeholder="Misal: 4" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-active-period" value="Masa Berlaku Paket (Bulan)" />
                <x-text-input id="create-active-period" class="block mt-1 w-full" type="number" name="active_period_months" :value="old('active_period_months', '1')" placeholder="Misal: 1" required />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Simpan Paket
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
