<x-app-layout title="Admin - Kelola Founders">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kelola Data Founders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-boxdark p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Founders</h3>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-founder-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Founder
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3 text-center">Foto</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Jabatan</th>
                                <th scope="col" class="px-4 py-3 text-center">Urutan</th>
                                <th scope="col" class="px-4 py-3 text-center">Status</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($founders as $index => $founder)
                                <tr class="bg-white dark:bg-boxdark border-b hover:bg-gray-50 dark:bg-meta-4">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($founders->currentPage() - 1) * $founders->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($founder->image)
                                            <img src="{{ asset('storage/' . $founder->image) }}" alt="Foto {{ $founder->name }}"
                                                class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 dark:border-strokedark mx-auto">
                                        @else
                                            <div class="w-16 h-16 rounded-full bg-[#D3AF37]/15 flex items-center justify-center mx-auto border-2 border-gray-200 dark:border-strokedark">
                                                <i class="fa-solid fa-crown text-[#D3AF37] text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $founder->name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $founder->position }}</td>
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">{{ $founder->order }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($founder->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-xl shadow-sm border border-[#D3AF37]/30 bg-[#161F30] overflow-hidden" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-founder-{{ $founder->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-[#D3AF37] bg-[#D3AF37]/15 hover:bg-[#D3AF37] hover:text-[#101828] transition-colors border-r border-[#D3AF37]/30"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-founder-deletion-{{ $founder->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-rose-400 bg-rose-950/40 hover:bg-rose-600 hover:text-white transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-founder-{{ $founder->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.founders.update', $founder->id) }}" enctype="multipart/form-data" class="p-6">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 text-left">Edit Founder</h3>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="text-left">
                                                        <x-input-label for="name-{{ $founder->id }}" value="Nama Lengkap" />
                                                        <x-text-input id="name-{{ $founder->id }}" class="block mt-1 w-full" type="text" name="name"
                                                            :value="old('name', $founder->name)" required />
                                                    </div>

                                                    <div class="text-left">
                                                        <x-input-label for="position-{{ $founder->id }}" value="Jabatan" />
                                                        <x-text-input id="position-{{ $founder->id }}" class="block mt-1 w-full" type="text" name="position"
                                                            :value="old('position', $founder->position)" required placeholder="Co-Founder, Chairman, dll" />
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="bio-{{ $founder->id }}" value="Bio / Deskripsi Singkat" />
                                                    <textarea id="bio-{{ $founder->id }}" name="bio" rows="3"
                                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                        placeholder="Deskripsi singkat tentang founder...">{{ old('bio', $founder->bio) }}</textarea>
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label for="image-{{ $founder->id }}" value="Foto Profil" />
                                                    @if ($founder->image)
                                                        <div class="mt-2 mb-3">
                                                            <img src="{{ asset('storage/' . $founder->image) }}" alt="Foto {{ $founder->name }}"
                                                                class="w-24 h-24 rounded-full object-cover border-2 border-gray-200 dark:border-strokedark shadow-sm">
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Foto saat ini. Pilih file baru untuk mengganti.</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" id="image-{{ $founder->id }}" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 mt-1
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-md file:border-0
                                                            file:text-sm file:font-semibold
                                                            file:bg-indigo-50 file:text-indigo-700
                                                            hover:file:bg-indigo-100
                                                            border border-gray-300 rounded-md cursor-pointer" />
                                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB</p>
                                                </div>

                                                <div class="mt-4 text-left">
                                                    <x-input-label value="Sosial Media" class="mb-2" />
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                        <div>
                                                            <div class="flex items-center gap-2">
                                                                <i class="fa-brands fa-instagram text-pink-500 w-5 text-center"></i>
                                                                <x-text-input class="block w-full" type="text" name="instagram"
                                                                    :value="old('instagram', $founder->social_media['instagram'] ?? '')" placeholder="@username" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex items-center gap-2">
                                                                <i class="fa-brands fa-linkedin text-blue-600 w-5 text-center"></i>
                                                                <x-text-input class="block w-full" type="text" name="linkedin"
                                                                    :value="old('linkedin', $founder->social_media['linkedin'] ?? '')" placeholder="URL profil" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex items-center gap-2">
                                                                <i class="fa-brands fa-tiktok text-gray-800 dark:text-gray-200 w-5 text-center"></i>
                                                                <x-text-input class="block w-full" type="text" name="tiktok"
                                                                    :value="old('tiktok', $founder->social_media['tiktok'] ?? '')" placeholder="@username" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                    <div class="text-left">
                                                        <x-input-label for="order-{{ $founder->id }}" value="Urutan Tampil" />
                                                        <x-text-input id="order-{{ $founder->id }}" class="block mt-1 w-full" type="number" name="order"
                                                            :value="old('order', $founder->order)" min="0" />
                                                    </div>
                                                    <div class="text-left flex items-end pb-1">
                                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" name="is_active" value="1"
                                                                {{ old('is_active', $founder->is_active) ? 'checked' : '' }}
                                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktif (Tampilkan di website)</span>
                                                        </label>
                                                    </div>
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
                                        <x-modal name="confirm-founder-deletion-{{ $founder->id }}" focusable>
                                            <form method="post" action="{{ route('admin.founders.destroy', $founder->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                                        Apakah Anda yakin ingin menghapus founder ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    Tindakan ini tidak dapat dibatalkan. Data founder <span class="font-bold text-gray-900 dark:text-white">"{{ $founder->name }}"</span>
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
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Belum ada data founder.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $founders->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-founder-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.founders.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 text-left">Tambah Founder Baru</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-left">
                    <x-input-label for="create-name" value="Nama Lengkap" />
                    <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                </div>

                <div class="text-left">
                    <x-input-label for="create-position" value="Jabatan" />
                    <x-text-input id="create-position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" required placeholder="Co-Founder, Chairman, dll" />
                </div>
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-bio" value="Bio / Deskripsi Singkat" />
                <textarea id="create-bio" name="bio" rows="3"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Deskripsi singkat tentang founder...">{{ old('bio') }}</textarea>
            </div>

            <div class="mt-4 text-left">
                <x-input-label for="create-image" value="Foto Profil" />
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

            <div class="mt-4 text-left">
                <x-input-label value="Sosial Media" class="mb-2" />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-instagram text-pink-500 w-5 text-center"></i>
                            <x-text-input class="block w-full" type="text" name="instagram" :value="old('instagram')" placeholder="@username" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-linkedin text-blue-600 w-5 text-center"></i>
                            <x-text-input class="block w-full" type="text" name="linkedin" :value="old('linkedin')" placeholder="URL profil" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <i class="fa-brands fa-tiktok text-gray-800 dark:text-gray-200 w-5 text-center"></i>
                            <x-text-input class="block w-full" type="text" name="tiktok" :value="old('tiktok')" placeholder="@username" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="text-left">
                    <x-input-label for="create-order" value="Urutan Tampil" />
                    <x-text-input id="create-order" class="block mt-1 w-full" type="number" name="order" :value="old('order', 0)" min="0" />
                </div>
                <div class="text-left flex items-end pb-1">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aktif (Tampilkan di website)</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Simpan Founder
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
