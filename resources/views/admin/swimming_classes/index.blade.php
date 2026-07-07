<x-app-layout title="Admin - Kelola Kelas">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kelola Kelas Renang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-boxdark p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Kelas Renang</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mengelola kelompok umur kelas renang, baik untuk kelas belajar maupun kelas prestasi.</p>
                    </div>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-class-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Kelas Baru
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Kelas</th>
                                <th scope="col" class="px-6 py-3">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-center">Rentang Umur</th>
                                <th scope="col" class="px-6 py-3 text-center">Kuota Maksimal</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($swimmingClasses as $index => $class)
                                <tr class="bg-white dark:bg-boxdark border-b hover:bg-gray-50 dark:bg-meta-4">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($swimmingClasses->currentPage() - 1) * $swimmingClasses->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-100">
                                        {{ $class->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $class->category->slug == 'prestasi' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $class->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($class->age_max)
                                            {{ $class->age_min }} - {{ $class->age_max }} Tahun
                                        @else
                                            {{ $class->age_min }} Tahun Keatas
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-gray-100 text-gray-800 dark:text-gray-100 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $class->max_quota }} Murid / Kelas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($class->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-class-{{ $class->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-amber-600 bg-white dark:bg-boxdark border border-gray-200 dark:border-strokedark rounded-l-lg hover:bg-amber-50">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-class-deletion-{{ $class->id }}')"
                                                class="px-3 py-2 text-xs font-medium text-red-600 bg-white dark:bg-boxdark border-y border-r border-gray-200 dark:border-strokedark rounded-r-lg hover:bg-red-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-class-{{ $class->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.swimming-classes.update', $class->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Edit Kelas Renang</h3>

                                                <div>
                                                    <x-input-label for="name-{{ $class->id }}" value="Nama Kelas" />
                                                    <x-text-input id="name-{{ $class->id }}" class="block mt-1 w-full" type="text" name="name"
                                                        :value="old('name', $class->name)" placeholder="Misal: Batita, Pra Junior" required />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="class_category_id-{{ $class->id }}" value="Kategori Kelas" />
                                                    <select id="class_category_id-{{ $class->id }}" name="class_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" @selected($cat->id == $class->class_category_id)>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="progress_form_type-{{ $class->id }}" value="Tipe Form Penilaian (Coach)" />
                                                    <select id="progress_form_type-{{ $class->id }}" name="progress_form_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="" disabled @selected(!$class->progress_form_type)>-- Pilih Tipe Form --</option>
                                                        <option value="batita" @selected(old('progress_form_type', $class->progress_form_type) == 'batita')>Batita (Water Comfort, Skills, Safety)</option>
                                                        <option value="balita" @selected(old('progress_form_type', $class->progress_form_type) == 'balita')>Balita (Water Safety, Propulsion)</option>
                                                        <option value="anak-anak" @selected(old('progress_form_type', $class->progress_form_type) == 'anak-anak')>Anak-anak (Basic Skills & Stroke Intro)</option>
                                                        <option value="dewasa" @selected(old('progress_form_type', $class->progress_form_type) == 'dewasa')>Dewasa (Basic Skills Only)</option>
                                                        <option value="prestasi" @selected(old('progress_form_type', $class->progress_form_type) == 'prestasi')>Prestasi (Fisik, Sistem Energi, PBT)</option>
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4 mt-4">
                                                    <div>
                                                        <x-input-label for="age_min-{{ $class->id }}" value="Usia Minimum (Tahun)" />
                                                        <x-text-input id="age_min-{{ $class->id }}" class="block mt-1 w-full" type="number" name="age_min"
                                                            :value="old('age_min', $class->age_min)" required />
                                                    </div>
                                                    <div>
                                                        <x-input-label for="age_max-{{ $class->id }}" value="Usia Maksimum (Nullable)" />
                                                        <x-text-input id="age_max-{{ $class->id }}" class="block mt-1 w-full" type="number" name="age_max"
                                                            :value="old('age_max', $class->age_max)" placeholder="Kosongkan jika bebas" />
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="max_quota-{{ $class->id }}" value="Kuota Maksimal Murid per Kelas" />
                                                    <x-text-input id="max_quota-{{ $class->id }}" class="block mt-1 w-full" type="number" name="max_quota"
                                                        :value="old('max_quota', $class->max_quota)" placeholder="15" required />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="description-{{ $class->id }}" value="Deskripsi Kelas" />
                                                    <textarea id="description-{{ $class->id }}" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Catatan tambahan mengenai kelas">{{ old('description', $class->description) }}</textarea>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="is_active-{{ $class->id }}" value="Status Aktif" />
                                                    <select id="is_active-{{ $class->id }}" name="is_active" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="1" @selected($class->is_active == 1)>Aktif</option>
                                                        <option value="0" @selected($class->is_active == 0)>Nonaktif</option>
                                                    </select>
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
                                        <x-modal name="confirm-class-deletion-{{ $class->id }}" focusable>
                                            <form method="post" action="{{ route('admin.swimming-classes.destroy', $class->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-600 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white font-bold">
                                                        Apakah Anda yakin ingin menghapus kelas ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    Kelas <span class="font-bold text-gray-900 dark:text-white">"{{ $class->name }}"</span>
                                                    akan dihapus permanen dari sistem. Tindakan ini hanya diperbolehkan jika tidak ada murid atau paket yang aktif menggunakan kelas ini.
                                                </p>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                                        Batal
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        Ya, Hapus Kelas
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">Belum ada data kelas renang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-2">
                    {{ $swimmingClasses->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-class-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.swimming-classes.store') }}" class="p-6 text-left">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Tambah Kelas Baru</h3>

            <div>
                <x-input-label for="create-name" value="Nama Kelas" />
                <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Misal: Batita, Pra Junior" required />
            </div>

            <div class="mt-4">
                <x-input-label for="create-category" value="Kategori Kelas" />
                <select id="create-category" name="class_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('class_category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-progress-form" value="Tipe Form Penilaian (Coach)" />
                <select id="create-progress-form" name="progress_form_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Tipe Form --</option>
                    <option value="batita" @selected(old('progress_form_type') == 'batita')>Batita (Water Comfort, Skills, Safety)</option>
                    <option value="balita" @selected(old('progress_form_type') == 'balita')>Balita (Water Safety, Propulsion)</option>
                    <option value="anak-anak" @selected(old('progress_form_type') == 'anak-anak')>Anak-anak (Basic Skills & Stroke Intro)</option>
                    <option value="dewasa" @selected(old('progress_form_type') == 'dewasa')>Dewasa (Basic Skills Only)</option>
                    <option value="prestasi" @selected(old('progress_form_type') == 'prestasi')>Prestasi (Fisik, Sistem Energi, PBT)</option>
                </select>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Menentukan metrik penilaian apa yang akan muncul saat pelatih mencatat perkembangan murid di kelas ini.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="create-age-min" value="Usia Minimum (Tahun)" />
                    <x-text-input id="create-age-min" class="block mt-1 w-full" type="number" name="age_min" :value="old('age_min', 0)" required />
                </div>
                <div>
                    <x-input-label for="create-age-max" value="Usia Maksimum (Nullable)" />
                    <x-text-input id="create-age-max" class="block mt-1 w-full" type="number" name="age_max" :value="old('age_max')" placeholder="Kosongkan jika bebas" />
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="create-quota" value="Kuota Maksimal Murid per Kelas" />
                <x-text-input id="create-quota" class="block mt-1 w-full" type="number" name="max_quota" :value="old('max_quota', 15)" placeholder="15" required />
            </div>

            <div class="mt-4">
                <x-input-label for="create-description" value="Deskripsi Kelas" />
                <textarea id="create-description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Catatan tambahan mengenai kelas">{{ old('description') }}</textarea>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Simpan Kelas
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
