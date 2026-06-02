<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Tempat Latihan Renang') }}
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
                        {{ $locationToEdit ? 'Edit Tempat Latihan' : 'Tambah Tempat Baru' }}
                    </h3>

                    <form method="POST"
                        action="{{ $locationToEdit ? route('admin.locations.update', $locationToEdit->id) : route('admin.locations.store') }}">
                        @csrf
                        @if ($locationToEdit)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" value="Nama Kolam Renang" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $locationToEdit ? $locationToEdit->name : '')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="address" value="Alamat Lengkap" />
                            <textarea id="address" name="address" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('address', $locationToEdit ? $locationToEdit->address : '') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            @if ($locationToEdit)
                                <a href="{{ route('admin.locations.index') }}"
                                    class="text-sm text-gray-600 hover:underline">
                                    Batal Edit
                                </a>
                            @else
                                <div></div>
                            @endif

                            <x-primary-button>
                                {{ $locationToEdit ? 'Simpan Perubahan' : 'Simpan Tempat' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Tempat Latihan</h3>

                    <div class="relative overflow-x-auto border sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Kolam</th>
                                    <th scope="col" class="px-6 py-3">Alamat</th>
                                    <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($locations as $index => $location)
                                    <tr
                                        class="bg-white border-b hover:bg-gray-50 {{ $locationToEdit && $locationToEdit->id == $location->id ? 'bg-blue-50/50' : '' }}">
                                        <td class="px-4 py-4 text-center font-medium text-gray-900">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-blue-600">{{ $location->name }}</td>
                                        <td class="px-6 py-4">{{ $location->address }}</td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="inline-flex rounded-md shadow-sm" role="group">

                                                <a href="{{ route('admin.locations.index', ['edit' => $location->id]) }}"
                                                    class="px-3 py-2 text-xs font-medium text-amber-600 bg-white border border-gray-200 rounded-l-lg hover:bg-amber-50">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'confirm-location-deletion-{{ $location->id }}')"
                                                    class="px-3 py-2 text-xs font-medium text-red-600 bg-white border-y border-r border-gray-200 rounded-r-lg hover:bg-red-50">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>

                                            <x-modal name="confirm-location-deletion-{{ $location->id }}" focusable>
                                                <form method="post"
                                                    action="{{ route('admin.locations.destroy', $location->id) }}"
                                                    class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')

                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            Apakah Anda yakin ingin menghapus tempat ini?
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600">
                                                        Tindakan ini tidak dapat dibatalkan. Data kolam <span
                                                            class="font-bold text-gray-900">"{{ $location->name }}"</span>
                                                        akan dihapus secara permanen dari sistem.
                                                    </p>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Batal') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="ms-3">
                                                            {{ __('Ya, Hapus Permanen') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data
                                            tempat latihan.</td>
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
