<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pendaftaran Murid Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-3">
                    <i class="fa-solid fa-address-card text-blue-600 mr-2"></i>Data Diri Anak & Pilihan Paket
                </h3>

                <form method="POST" action="{{ route('parent.students.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama Lengkap Anak" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="birth_date" value="Tanggal Lahir" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date"
                                :value="old('birth_date')" required />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gender" value="Jenis Kelamin" />
                            <select id="gender" name="gender"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200" />

                    <div class="mt-4">
                        <x-input-label for="location_id" value="Pilih Tempat Latihan Kolam Renang" />
                        <select id="location_id" name="location_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="" disabled selected>-- Pilih Kolam Renang --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }} — ({{ $location->address }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="package_id" value="Pilih Paket Kursus" />
                        <select id="package_id" name="package_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="" disabled selected>-- Pilih Paket Latihan --</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}"
                                    {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} — Rp {{ number_format($package->price, 0, ',', '.') }}
                                    ({{ $package->sessions }}x Pertemuan)
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('package_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="coach_id" value="Rekomendasi / Preferensi Coach Pelatih (Opsional)" />
                        <select id="coach_id" name="coach_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected>-- Bebas / Rekomendasi Admin --</option>
                            @foreach ($coaches as $coach)
                                <option value="{{ $coach->id }}"
                                    {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                    {{ $coach->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-gray-400 mt-1 block">*Sifatnya pengajuan, Admin akan menyesuaikan dengan
                            kuota luang Coach.</small>
                        <x-input-error :messages="$errors->get('coach_id')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t pt-4">
                        <x-primary-button class="w-full md:w-auto justify-center">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Pendaftaran
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
