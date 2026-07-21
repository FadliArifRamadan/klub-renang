<x-app-layout title="Admin - Tempat Latihan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
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

            <div class="bg-white dark:bg-boxdark p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Tempat Latihan</h3>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-location-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Tempat Baru
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3 text-center">Foto</th>
                                <th scope="col" class="px-6 py-3">Nama Kolam</th>
                                <th scope="col" class="px-6 py-3">Alamat</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $index => $location)
                                <tr class="bg-white dark:bg-boxdark border-b hover:bg-gray-50 dark:bg-meta-4">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($locations->currentPage() - 1) * $locations->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($location->image)
                                            <img src="{{ asset('storage/' . $location->image) }}" alt="Foto {{ $location->name }}"
                                                class="w-16 h-12 rounded-md object-cover border-2 border-gray-200 dark:border-strokedark mx-auto">
                                        @else
                                            <div class="w-16 h-12 rounded-md bg-blue-50 flex items-center justify-center mx-auto border-2 border-gray-200 dark:border-strokedark">
                                                <i class="fa-solid fa-water text-blue-400 text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-600">{{ $location->name }}</td>
                                    <td class="px-6 py-4">{{ $location->address }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-xl shadow-sm border border-[#D3AF37]/30 bg-[#161F30] overflow-hidden" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-location-{{ $location->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-[#D3AF37] bg-[#D3AF37]/15 hover:bg-[#D3AF37] hover:text-[#101828] transition-colors border-r border-[#D3AF37]/30"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-location-deletion-{{ $location->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-rose-400 bg-rose-950/40 hover:bg-rose-600 hover:text-white transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-location-{{ $location->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.locations.update', $location->id) }}" enctype="multipart/form-data" class="p-6">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 text-left">Edit Tempat Latihan</h3>

                                                <div class="text-left">
                                                    <x-input-label for="name-{{ $location->id }}" value="Nama Kolam Renang" />
                                                    <x-text-input id="name-{{ $location->id }}" class="block mt-1 w-full" type="text" name="name"
                                                        :value="old('name', $location->name)" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="address-{{ $location->id }}" value="Alamat Lengkap" />
                                                    <textarea id="address-{{ $location->id }}" name="address" rows="3"
                                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                        required>{{ old('address', $location->address) }}</textarea>
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="image-{{ $location->id }}" value="Foto Tempat Latihan" />
                                                    @if ($location->image)
                                                        <div class="mt-2 mb-3">
                                                            <img src="{{ asset('storage/' . $location->image) }}" alt="Foto {{ $location->name }}"
                                                                class="w-full h-32 rounded-lg object-cover border-2 border-gray-200 dark:border-strokedark shadow-sm">
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Foto saat ini. Pilih file baru untuk mengganti.</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" id="image-{{ $location->id }}" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 mt-1
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-md file:border-0
                                                            file:text-sm file:font-semibold
                                                            file:bg-indigo-50 file:text-indigo-700
                                                            hover:file:bg-indigo-100
                                                            border border-gray-300 rounded-md cursor-pointer" />
                                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB</p>
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
                                        <x-modal name="confirm-location-deletion-{{ $location->id }}" focusable>
                                            <form method="post" action="{{ route('admin.locations.destroy', $location->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                                        Apakah Anda yakin ingin menghapus tempat ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    Tindakan ini tidak dapat dibatalkan. Data kolam <span class="font-bold text-gray-900 dark:text-white">"{{ $location->name }}"</span>
                                                    akan dihapus secara permanen dari sistem.
                                                </p>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
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
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada data tempat latihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $locations->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-location-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.locations.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 text-left">Tambah Tempat Baru</h3>

            <div class="text-left">
                <x-input-label for="create-name" value="Nama Kolam Renang" />
                <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-address" value="Alamat Lengkap" />
                <textarea id="create-address" name="address" rows="3"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>{{ old('address') }}</textarea>
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-image" value="Foto Tempat Latihan" />
                <input type="file" id="create-image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400 mt-1
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        border border-gray-300 rounded-md cursor-pointer" />
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB</p>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Simpan Tempat
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
