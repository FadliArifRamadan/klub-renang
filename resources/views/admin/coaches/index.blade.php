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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg h-fit">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ $coachToEdit ? 'Edit Data Coach' : 'Registrasi Coach Baru' }}
                    </h3>

                    <form method="POST"
                        action="{{ $coachToEdit ? route('admin.coaches.update', $coachToEdit->id) : route('admin.coaches.store') }}">
                        @csrf
                        @if ($coachToEdit)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $coachToEdit ? $coachToEdit->name : '')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="username" value="Username (Untuk Login)" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                                :value="old('username', $coachToEdit ? $coachToEdit->username : '')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="phone" value="No. WhatsApp / Telepon" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                :value="old('phone', $coachToEdit ? $coachToEdit->phone : '')" placeholder="Misal: 0812345..." required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                :placeholder="$coachToEdit ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 8 karakter'" :required="!$coachToEdit" />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            @if ($coachToEdit)
                                <a href="{{ route('admin.coaches.index') }}"
                                    class="text-sm text-gray-600 hover:underline">
                                    Batal Edit
                                </a>
                            @else
                                <div></div>
                            @endif

                            <x-primary-button>
                                {{ $coachToEdit ? 'Simpan Perubahan' : 'Daftarkan Coach' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pelatih Aktif</h3>

                    <div class="relative overflow-x-auto border sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Coach</th>
                                    <th scope="col" class="px-6 py-3">Username</th>
                                    <th scope="col" class="px-6 py-3">No. Telp / WA</th>
                                    <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coaches as $index => $coach)
                                    <tr
                                        class="bg-white border-b hover:bg-gray-50 {{ $coachToEdit && $coachToEdit->id == $coach->id ? 'bg-blue-50/50' : '' }}">
                                        <td class="px-4 py-4 text-center font-medium text-gray-900">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-800">{{ $coach->name }}</td>
                                        <td class="px-6 py-4"><code>{{ $coach->username }}</code></td>
                                        <td class="px-6 py-4 text-blue-600 font-medium">{{ $coach->phone }}</td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="inline-flex rounded-md shadow-sm" role="group">

                                                <a href="{{ route('admin.coaches.index', ['edit' => $coach->id]) }}"
                                                    class="px-3 py-2 text-xs font-medium text-amber-600 bg-white border border-gray-200 rounded-l-lg hover:bg-amber-50">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'confirm-coach-deletion-{{ $coach->id }}')"
                                                    class="px-3 py-2 text-xs font-medium text-red-600 bg-white border-y border-r border-gray-200 rounded-r-lg hover:bg-red-50">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>

                                            <x-modal name="confirm-coach-deletion-{{ $coach->id }}" focusable>
                                                <form method="post"
                                                    action="{{ route('admin.coaches.destroy', $coach->id) }}"
                                                    class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')

                                                    <div
                                                        class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            Apakah Anda yakin ingin menghapus Coach ini?
                                                        </h2>
                                                    </div>

                                                    <p class="text-sm text-gray-600">
                                                        Akun pelatih bernama <span
                                                            class="font-bold text-gray-900">"{{ $coach->name }}"</span>
                                                        akan dihapus permanen. Coach yang bersangkutan tidak akan bisa
                                                        login lagi ke dalam sistem.
                                                    </p>

                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
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
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada data
                                            coach didaftarkan.</td>
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
