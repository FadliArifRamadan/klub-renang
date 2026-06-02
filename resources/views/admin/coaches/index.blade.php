<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Akun Coach (Pelatih)') }}
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
                    <h3 class="text-lg font-medium text-gray-900">Daftar Pelatih Aktif</h3>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-coach-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Coach Baru
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3 text-center">Foto</th>
                                <th scope="col" class="px-6 py-3">Nama Coach</th>
                                <th scope="col" class="px-6 py-3">Username</th>
                                <th scope="col" class="px-6 py-3">No. Telp / WA</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coaches as $index => $coach)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900">
                                        {{ ($coaches->currentPage() - 1) * $coaches->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($coach->image)
                                            <img src="{{ asset('storage/' . $coach->image) }}" alt="Foto {{ $coach->name }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mx-auto">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mx-auto border-2 border-gray-200">
                                                <i class="fa-solid fa-user text-indigo-400 text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $coach->name }}</td>
                                    <td class="px-6 py-4"><code>{{ $coach->username }}</code></td>
                                    <td class="px-6 py-4 text-blue-600 font-medium">{{ $coach->phone }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-coach-{{ $coach->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-amber-600 bg-white border border-gray-200 rounded-l-lg hover:bg-amber-50">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-coach-deletion-{{ $coach->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-red-600 bg-white border-y border-r border-gray-200 rounded-r-lg hover:bg-red-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-coach-{{ $coach->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.coaches.update', $coach->id) }}" enctype="multipart/form-data" class="p-6">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 mb-4 text-left">Edit Data Coach</h3>

                                                <div class="text-left">
                                                    <x-input-label for="name-{{ $coach->id }}" value="Nama Lengkap" />
                                                    <x-text-input id="name-{{ $coach->id }}" class="block mt-1 w-full" type="text" name="name"
                                                        :value="old('name', $coach->name)" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="username-{{ $coach->id }}" value="Username (Untuk Login)" />
                                                    <x-text-input id="username-{{ $coach->id }}" class="block mt-1 w-full" type="text" name="username"
                                                        :value="old('username', $coach->username)" required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="phone-{{ $coach->id }}" value="No. WhatsApp / Telepon" />
                                                    <x-text-input id="phone-{{ $coach->id }}" class="block mt-1 w-full" type="text" name="phone"
                                                        :value="old('phone', $coach->phone)" placeholder="Misal: 0812345..." required />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="password-{{ $coach->id }}" value="Password" />
                                                    <x-text-input id="password-{{ $coach->id }}" class="block mt-1 w-full" type="password" name="password"
                                                        placeholder="Kosongkan jika tidak ingin diubah" />
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="image-{{ $coach->id }}" value="Foto Coach" />
                                                    @if ($coach->image)
                                                        <div class="mt-2 mb-3">
                                                            <img src="{{ asset('storage/' . $coach->image) }}" alt="Foto {{ $coach->name }}"
                                                                class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200 shadow-sm">
                                                            <p class="text-xs text-gray-500 mt-1">Foto saat ini. Pilih file baru untuk mengganti.</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" id="image-{{ $coach->id }}" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                                                        class="block w-full text-sm text-gray-500 mt-1
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
                                        <x-modal name="confirm-coach-deletion-{{ $coach->id }}" focusable>
                                            <form method="post" action="{{ route('admin.coaches.destroy', $coach->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        Apakah Anda yakin ingin menghapus Coach ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600">
                                                    Akun pelatih bernama <span class="font-bold text-gray-900">"{{ $coach->name }}"</span>
                                                    akan dihapus permanen. Coach yang bersangkutan tidak akan bisa login lagi ke dalam sistem.
                                                </p>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        Ya, Hapus Akun
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-400">Belum ada data coach didaftarkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $coaches->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-coach-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.coaches.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 mb-4 text-left">Registrasi Coach Baru</h3>

            <div class="text-left">
                <x-input-label for="create-name" value="Nama Lengkap" />
                <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-username" value="Username (Untuk Login)" />
                <x-text-input id="create-username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-phone" value="No. WhatsApp / Telepon" />
                <x-text-input id="create-phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Misal: 0812345..." required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-password" value="Password" />
                <x-text-input id="create-password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-image" value="Foto Coach" />
                <input type="file" id="create-image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="block w-full text-sm text-gray-500 mt-1
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
                    Daftarkan Coach
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
