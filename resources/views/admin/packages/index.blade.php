<x-app-layout title="Admin - Kelola Paket">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kelola Paket Latihan Renang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-boxdark p-6 rounded-lg shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Paket Latihan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mengelola paket, harga (lokasi/flat), dan detail kelas renang.</p>
                    </div>
                    <x-primary-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-package-modal')">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Paket Baru
                    </x-primary-button>
                </div>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-meta-4 border-b">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3">Nama Paket</th>
                                <th scope="col" class="px-6 py-3">Kelas & Kategori</th>
                                <th scope="col" class="px-6 py-3 text-center">Tipe Paket</th>
                                <th scope="col" class="px-6 py-3 text-right">Harga</th>
                                <th scope="col" class="px-6 py-3 text-center">Sesi Latihan</th>
                                <th scope="col" class="px-6 py-3 text-center">Masa Berlaku</th>
                                <th scope="col" class="px-4 py-3 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $index => $package)
                                <tr class="bg-white dark:bg-boxdark border-b hover:bg-gray-50 dark:bg-meta-4">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ ($packages->currentPage() - 1) * $packages->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-100">
                                        {{ $package->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 dark:text-white font-semibold">{{ $package->swimmingClass->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $package->swimmingClass->category->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @switch($package->package_type)
                                            @case('regular')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Regular (1:4)</span>
                                                @break
                                            @case('private')
                                                <span class="bg-teal-100 text-teal-800 text-xs font-semibold px-2.5 py-0.5 rounded">Private (1:1)</span>
                                                @break
                                            @case('single_session')
                                                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded">Single Session</span>
                                                @break
                                            @case('monthly_prestasi')
                                                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Prestasi (Bulanan)</span>
                                                @break
                                            @default
                                                <span class="bg-gray-100 text-gray-800 dark:text-gray-100 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $package->package_type }}</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($package->is_location_based)
                                            <div class="text-xs font-semibold text-amber-600">Bervariasi per Lokasi:</div>
                                            <div class="space-y-0.5 mt-1">
                                                @foreach($package->locationPrices as $locPrice)
                                                    <div class="text-[11px] text-gray-500 dark:text-gray-400">
                                                        {{ $locPrice->location->name }}: <span class="font-bold text-slate-700">Rp {{ number_format($locPrice->price, 0, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="font-bold text-green-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $package->sessions }}x Sesi</div>
                                        @if($package->package_type == 'monthly_prestasi')
                                            <div class="text-[10px] text-gray-500 dark:text-gray-400">
                                                Renang: {{ $package->swim_sessions }}x | Darat: {{ $package->dryland_sessions }}x
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-slate-100 text-slate-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $package->active_period_months }} Bulan
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-xl shadow-sm border border-[#D3AF37]/30 bg-[#161F30] overflow-hidden" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-package-{{ $package->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-[#D3AF37] bg-[#D3AF37]/15 hover:bg-[#D3AF37] hover:text-[#101828] transition-colors border-r border-[#D3AF37]/30"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'confirm-package-deletion-{{ $package->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-rose-400 bg-rose-950/40 hover:bg-rose-600 hover:text-white transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <x-modal name="edit-package-{{ $package->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.packages.update', $package->id) }}" class="p-6 text-left"
                                                x-data="{
                                                    isLocationBased: {{ $package->is_location_based ? 'true' : 'false' }},
                                                    packageType: '{{ $package->package_type }}',
                                                    sessions: {{ $package->sessions }},
                                                    swimSessions: {{ $package->swim_sessions ?? 0 }},
                                                    drylandSessions: {{ $package->dryland_sessions ?? 0 }},
                                                    updateSessions() {
                                                        if (this.packageType === 'monthly_prestasi') {
                                                            this.sessions = parseInt(this.swimSessions || 0) + parseInt(this.drylandSessions || 0);
                                                        }
                                                    }
                                                }">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Edit Paket Latihan</h3>

                                                <div>
                                                    <x-input-label for="name-{{ $package->id }}" value="Nama Paket" />
                                                    <x-text-input id="name-{{ $package->id }}" class="block mt-1 w-full" type="text" name="name"
                                                        :value="old('name', $package->name)" placeholder="Nama paket latihan" required />
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="swimming_class_id-{{ $package->id }}" value="Kelas Latihan" />
                                                    <select id="swimming_class_id-{{ $package->id }}" name="swimming_class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        @foreach($swimmingClasses as $class)
                                                            <option value="{{ $class->id }}" @selected($class->id == $package->swimming_class_id)>
                                                                {{ $class->name }} ({{ $class->category->name }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="package_type-{{ $package->id }}" value="Tipe Paket" />
                                                    <select id="package_type-{{ $package->id }}" name="package_type" x-model="packageType" x-on:change="updateSessions()" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                        <option value="regular">Regular (1:4)</option>
                                                        <option value="private">Private (1:1)</option>
                                                        <option value="single_session">Single Session</option>
                                                        <option value="monthly_prestasi">Prestasi (Bulanan)</option>
                                                    </select>
                                                </div>

                                                <div class="mt-4 flex items-center">
                                                    <input id="is_location_based-{{ $package->id }}" type="checkbox" name="is_location_based" value="1" x-model="isLocationBased" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    <label for="is_location_based-{{ $package->id }}" class="ms-2 text-sm text-gray-600 dark:text-gray-300 font-bold">Harga Bergantung Lokasi</label>
                                                </div>

                                                <!-- Single Flat Price -->
                                                <div class="mt-4" x-show="!isLocationBased">
                                                    <x-input-label for="price-{{ $package->id }}" value="Harga Flat Paket (Rp)" />
                                                    <x-text-input id="price-{{ $package->id }}" class="block mt-1 w-full" type="number" name="price"
                                                        :value="old('price', $package->price)" placeholder="Misal: 600000" x-bind:required="!isLocationBased" />
                                                </div>

                                                <!-- Location Based Prices -->
                                                <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-lg" x-show="isLocationBased">
                                                    <h4 class="text-sm font-semibold text-slate-800 mb-3"><i class="fa-solid fa-map-pin text-amber-500 mr-1"></i> Harga Per Lokasi</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        @foreach($locations as $loc)
                                                            @php
                                                                $locPrice = $package->locationPrices->where('location_id', $loc->id)->first();
                                                            @endphp
                                                            <div>
                                                                <x-input-label for="loc_price_{{ $package->id }}_{{ $loc->id }}" value="Harga di {{ $loc->name }} (Rp)" />
                                                                <x-text-input id="loc_price_{{ $package->id }}_{{ $loc->id }}" class="block mt-1 w-full" type="number" name="location_prices[{{ $loc->id }}]"
                                                                    value="{{ $locPrice ? $locPrice->price : '' }}" placeholder="Misal: 450000" />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Sessions Split -->
                                                <div class="grid grid-cols-3 gap-4 mt-4">
                                                    <div x-show="packageType !== 'monthly_prestasi'">
                                                        <x-input-label for="sessions-{{ $package->id }}" value="Total Sesi" />
                                                        <x-text-input id="sessions-{{ $package->id }}" class="block mt-1 w-full" type="number" name="sessions"
                                                            x-model="sessions" placeholder="8" required />
                                                    </div>

                                                    <div x-show="packageType === 'monthly_prestasi'">
                                                        <x-input-label for="swim_sessions-{{ $package->id }}" value="Sesi Renang" />
                                                        <x-text-input id="swim_sessions-{{ $package->id }}" class="block mt-1 w-full" type="number" name="swim_sessions"
                                                            x-model="swimSessions" x-on:input="updateSessions()" placeholder="16" />
                                                    </div>

                                                    <div x-show="packageType === 'monthly_prestasi'">
                                                        <x-input-label for="dryland_sessions-{{ $package->id }}" value="Sesi Darat" />
                                                        <x-text-input id="dryland_sessions-{{ $package->id }}" class="block mt-1 w-full" type="number" name="dryland_sessions"
                                                            x-model="drylandSessions" x-on:input="updateSessions()" placeholder="4" />
                                                    </div>

                                                    <div x-show="packageType === 'monthly_prestasi'">
                                                        <x-input-label for="total_sessions_hidden-{{ $package->id }}" value="Total Sesi" />
                                                        <input type="hidden" name="sessions" x-model="sessions" />
                                                        <x-text-input id="total_sessions_hidden-{{ $package->id }}" class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="number"
                                                            x-model="sessions" disabled />
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <x-input-label for="active_period_months-{{ $package->id }}" value="Masa Berlaku Paket (Bulan)" />
                                                    <x-text-input id="active_period_months-{{ $package->id }}" class="block mt-1 w-full" type="number"
                                                        name="active_period_months" :value="old('active_period_months', $package->active_period_months)" placeholder="1" required />
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
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white font-bold">
                                                        Apakah Anda yakin ingin menghapus paket ini?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    Paket <span class="font-bold text-gray-900 dark:text-white">"{{ $package->name }}"</span>
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
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-400">Belum ada data paket latihan.</td>
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
        <form method="POST" action="{{ route('admin.packages.store') }}" class="p-6 text-left"
            x-data="{
                isLocationBased: false,
                packageType: 'regular',
                sessions: 8,
                swimSessions: 8,
                drylandSessions: 0,
                updateSessions() {
                    if (this.packageType === 'monthly_prestasi') {
                        this.sessions = parseInt(this.swimSessions || 0) + parseInt(this.drylandSessions || 0);
                    }
                }
            }">
            @csrf

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 font-bold">Tambah Paket Baru</h3>

            <div>
                <x-input-label for="create-name" value="Nama Paket" />
                <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Nama paket" required />
            </div>

            <div class="mt-4">
                <x-input-label for="create-swimming-class" value="Kelas Latihan" />
                <select id="create-swimming-class" name="swimming_class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>-- Pilih Kelas Renang --</option>
                    @foreach($swimmingClasses as $class)
                        <option value="{{ $class->id }}" @selected(old('swimming_class_id') == $class->id)>
                            {{ $class->name }} ({{ $class->category->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="create-package-type" value="Tipe Paket" />
                <select id="create-package-type" name="package_type" x-model="packageType" x-on:change="updateSessions()" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="regular">Regular (1:4)</option>
                    <option value="private">Private (1:1)</option>
                    <option value="single_session">Single Session</option>
                    <option value="monthly_prestasi">Prestasi (Bulanan)</option>
                </select>
            </div>

            <div class="mt-4 flex items-center">
                <input id="create-is-location-based" type="checkbox" name="is_location_based" value="1" x-model="isLocationBased" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="create-is-location-based" class="ms-2 text-sm text-gray-600 dark:text-gray-300 font-bold">Harga Bergantung Lokasi</label>
            </div>

            <!-- Single Flat Price -->
            <div class="mt-4" x-show="!isLocationBased">
                <x-input-label for="create-price" value="Harga Flat Paket (Rp)" />
                <x-text-input id="create-price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" placeholder="Misal: 600000" x-bind:required="!isLocationBased" />
            </div>

            <!-- Location Based Prices -->
            <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-lg" x-show="isLocationBased">
                <h4 class="text-sm font-semibold text-slate-800 mb-3"><i class="fa-solid fa-map-pin text-amber-500 mr-1"></i> Harga Per Lokasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($locations as $loc)
                        <div>
                            <x-input-label for="create-loc-price-{{ $loc->id }}" value="Harga di {{ $loc->name }} (Rp)" />
                            <x-text-input id="create-loc-price-{{ $loc->id }}" class="block mt-1 w-full" type="number" name="location_prices[{{ $loc->id }}]" placeholder="Misal: 450000" />
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sessions Split -->
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div x-show="packageType !== 'monthly_prestasi'">
                    <x-input-label for="create-sessions" value="Total Sesi" />
                    <x-text-input id="create-sessions" class="block mt-1 w-full" type="number" name="sessions" x-model="sessions" placeholder="8" required />
                </div>

                <div x-show="packageType === 'monthly_prestasi'">
                    <x-input-label for="create-swim-sessions" value="Sesi Renang" />
                    <x-text-input id="create-swim-sessions" class="block mt-1 w-full" type="number" name="swim_sessions" x-model="swimSessions" x-on:input="updateSessions()" placeholder="16" />
                </div>

                <div x-show="packageType === 'monthly_prestasi'">
                    <x-input-label for="create-dryland-sessions" value="Sesi Darat" />
                    <x-text-input id="create-dryland-sessions" class="block mt-1 w-full" type="number" name="dryland_sessions" x-model="drylandSessions" x-on:input="updateSessions()" placeholder="4" />
                </div>

                <div x-show="packageType === 'monthly_prestasi'">
                    <x-input-label for="create-total-sessions-hidden" value="Total Sesi" />
                    <input type="hidden" name="sessions" x-model="sessions" />
                    <x-text-input id="create-total-sessions-hidden" class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="number" x-model="sessions" disabled />
                </div>
            </div>

            <div class="mt-4">
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
