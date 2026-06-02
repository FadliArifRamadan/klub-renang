<x-app-layout>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg h-fit">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ $packageToEdit ? 'Edit Paket Latihan' : 'Tambah Paket Baru' }}
                    </h3>

                    <form method="POST"
                        action="{{ $packageToEdit ? route('admin.packages.update', $packageToEdit->id) : route('admin.packages.store') }}">
                        @csrf
                        @if ($packageToEdit)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" value="Nama Paket" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $packageToEdit ? $packageToEdit->name : '')" placeholder="Misal: Paket Bulanan 4x" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="price" value="Harga Paket (Rp)" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                :value="old('price', $packageToEdit ? $packageToEdit->price : '')" placeholder="Misal: 350000" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="sessions" value="Jumlah Pertemuan (Sesi)" />
                            <x-text-input id="sessions" class="block mt-1 w-full" type="number" name="sessions"
                                :value="old('sessions', $packageToEdit ? $packageToEdit->sessions : '')" placeholder="Misal: 4" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="active_period_months" value="Masa Berlaku Paket (Bulan)" />
                            <x-text-input id="active_period_months" class="block mt-1 w-full" type="number" name="active_period_months"
                                :value="old('active_period_months', $packageToEdit ? $packageToEdit->active_period_months : '1')" placeholder="Misal: 1" required />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            @if ($packageToEdit)
                                <a href="{{ route('admin.packages.index') }}"
                                    class="text-sm text-gray-600 hover:underline">
                                    Batal Edit
                                </a>
                            @else
                                <div></div>
                            @endif

                            <x-primary-button>
                                {{ $packageToEdit ? 'Simpan Perubahan' : 'Simpan Paket' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Paket Latihan</h3>

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
                                    <tr
                                        class="bg-white border-b hover:bg-gray-50 {{ $packageToEdit && $packageToEdit->id == $package->id ? 'bg-blue-50/50' : '' }}">
                                        <td class="px-4 py-4 text-center font-medium text-gray-900">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-800">{{ $package->name }}</td>
                                        <td class="px-6 py-4 text-right font-medium text-green-600">Rp
                                            {{ number_format($package->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center"><span
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $package->sessions }}x
                                                Pertemuan</span></td>
                                        <td class="px-6 py-4 text-center"><span
                                                class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $package->active_period_months }} Bulan</span></td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="inline-flex rounded-md shadow-sm" role="group">

                                                <a href="{{ route('admin.packages.index', ['edit' => $package->id]) }}"
                                                    class="px-3 py-2 text-xs font-medium text-amber-600 bg-white border border-gray-200 rounded-l-lg hover:bg-amber-50">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'confirm-package-deletion-{{ $package->id }}')"
                                                    class="px-3 py-2 text-xs font-medium text-red-600 bg-white border-y border-r border-gray-200 rounded-r-lg hover:bg-red-50">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>

                                            <x-modal name="confirm-package-deletion-{{ $package->id }}" focusable>
                                                <form method="post"
                                                    action="{{ route('admin.packages.destroy', $package->id) }}"
                                                    class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')

                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            Apakah Anda yakin ingin menghapus paket ini?
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600">
                                                        Paket <span
                                                            class="font-bold text-gray-900">"{{ $package->name }}"</span>
                                                        akan dihapus permanen. Murid baru tidak akan bisa memilih paket
                                                        ini lagi.
                                                    </p>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
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
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada data
                                            paket latihan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
