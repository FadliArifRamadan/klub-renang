<x-app-layout title="Admin - Kelola Pengguna">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Kelola Akun Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alert Notifikasi Sukses --}}
            @if (session('success'))
                <div class="flex p-4 mb-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200" role="alert">
                    <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Sukses!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Alert Notifikasi Error --}}
            @if (session('error'))
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200" role="alert">
                    <i class="fa-solid fa-circle-xmark mt-0.5 mr-2 text-lg"></i>
                    <div>
                        <span class="font-bold">Error!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-boxdark p-6 rounded-3xl shadow-sm border border-slate-100">
                
                {{-- Bagian Atas: Filter Tab Role + Form Pencarian --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    {{-- Tab Filter Role --}}
                    <div class="flex flex-wrap items-center gap-1.5 bg-slate-50 p-1 rounded-2xl border border-slate-100 w-fit">
                        <a href="{{ route('admin.users.index', array_filter(['search' => $search])) }}" 
                           class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ empty($role) ? 'bg-white dark:bg-boxdark text-blue-600 shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.users.index', array_filter(['role' => 'admin', 'search' => $search])) }}" 
                           class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ $role === 'admin' ? 'bg-purple-100 text-purple-700 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                            Admin
                        </a>
                        <a href="{{ route('admin.users.index', array_filter(['role' => 'coach', 'search' => $search])) }}" 
                           class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ $role === 'coach' ? 'bg-blue-100 text-blue-700 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                            Coach (Pelatih)
                        </a>
                        <a href="{{ route('admin.users.index', array_filter(['role' => 'parent', 'search' => $search])) }}" 
                           class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ $role === 'parent' ? 'bg-emerald-100 text-emerald-700 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                            Orang Tua
                        </a>
                        <a href="{{ route('admin.users.index', array_filter(['role' => 'general', 'search' => $search])) }}" 
                           class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ $role === 'general' ? 'bg-amber-100 text-amber-700 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                            Umum
                        </a>
                    </div>

                    {{-- Form Pencarian dan Tombol Tambah --}}
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="relative flex-1 md:flex-initial">
                            @if($role)
                                <input type="hidden" name="role" value="{{ $role }}">
                            @endif
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Cari nama, username..." 
                                   class="pl-9 pr-4 py-2 border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl text-xs w-full md:w-60 shadow-sm transition-all" />
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                        </form>

                        <x-primary-button type="button" class="shrink-0" x-data="" x-on:click="$dispatch('open-modal', 'create-user-modal')">
                            <i class="fa-solid fa-user-plus mr-1.5"></i> Tambah Akun
                        </x-primary-button>
                    </div>
                </div>

                {{-- Tabel Data Pengguna --}}
                <div class="relative overflow-x-auto border border-slate-150 rounded-2xl shadow-sm">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-150">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-12">No</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-16">Foto</th>
                                <th scope="col" class="px-6 py-3.5">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-3.5">Username</th>
                                <th scope="col" class="px-6 py-3.5">Role</th>
                                <th scope="col" class="px-6 py-3.5">No. Telp / WA</th>
                                <th scope="col" class="px-6 py-3.5">Terdaftar</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $index => $user)
                                <tr class="bg-white dark:bg-boxdark hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-4 text-center font-semibold text-slate-800">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($user->role === 'coach' && $user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Foto {{ $user->name }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-slate-200 mx-auto shadow-sm">
                                        @else
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto border-2 border-slate-150 shadow-sm
                                                @if($user->role === 'admin') bg-purple-550/10 text-purple-600
                                                @elseif($user->role === 'coach') bg-blue-550/10 text-blue-600
                                                @elseif($user->role === 'parent') bg-emerald-550/10 text-emerald-600
                                                @else bg-amber-550/10 text-amber-600
                                                @endif">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $user->name }}</td>
                                    <td class="px-6 py-4"><code class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-xs">{{ $user->username }}</code></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold border
                                            @if($user->role === 'admin') bg-purple-50 text-purple-700 border-purple-200
                                            @elseif($user->role === 'coach') bg-blue-50 text-blue-700 border-blue-200
                                            @elseif($user->role === 'parent') bg-emerald-50 text-emerald-700 border-emerald-200
                                            @else bg-amber-50 text-amber-700 border-amber-200
                                            @endif">
                                            @if($user->role === 'admin') Admin
                                            @elseif($user->role === 'coach') Pelatih (Coach)
                                            @elseif($user->role === 'parent') Orang Tua
                                            @else Umum
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-semibold">{{ $user->phone }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-400 font-medium">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex rounded-xl shadow-sm border border-slate-200 bg-white dark:bg-boxdark" role="group">
                                            <button type="button" x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-user-{{ $user->id }}')"
                                                class="px-3 py-2 text-xs font-bold text-amber-600 hover:bg-amber-50 transition-colors rounded-l-xl border-r border-slate-150">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button type="button" x-data=""
                                                @if($user->id === auth()->id())
                                                    disabled
                                                    class="px-3 py-2 text-xs font-bold text-slate-300 cursor-not-allowed rounded-r-xl"
                                                    title="Anda tidak bisa menghapus akun Anda sendiri"
                                                @else
                                                    x-on:click="$dispatch('open-modal', 'confirm-user-deletion-{{ $user->id }}')"
                                                    class="px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors rounded-r-xl"
                                                @endif>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        {{-- Modal Edit Pengguna --}}
                                        <x-modal name="edit-user-{{ $user->id }}" maxWidth="lg" focusable>
                                            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" 
                                                  class="p-6 text-left" x-data="{ userRole: '{{ $user->role }}' }">
                                                @csrf
                                                @method('PUT')

                                                <h3 class="text-lg font-extrabold text-slate-800 mb-5 flex items-center gap-2">
                                                    <i class="fa-solid fa-user-pen text-amber-600"></i> Edit Akun Pengguna
                                                </h3>

                                                <div class="space-y-4">
                                                    <div>
                                                        <x-input-label for="name-{{ $user->id }}" value="Nama Lengkap" class="font-bold text-xs" />
                                                        <x-text-input id="name-{{ $user->id }}" class="block mt-1 w-full" type="text" name="name"
                                                            :value="old('name', $user->name)" required />
                                                    </div>

                                                    <div>
                                                        <x-input-label for="username-{{ $user->id }}" value="Username (Untuk Login)" class="font-bold text-xs" />
                                                        <x-text-input id="username-{{ $user->id }}" class="block mt-1 w-full" type="text" name="username"
                                                            :value="old('username', $user->username)" required />
                                                    </div>

                                                    <div>
                                                        <x-input-label for="phone-{{ $user->id }}" value="No. WhatsApp / Telepon" class="font-bold text-xs" />
                                                        <x-text-input id="phone-{{ $user->id }}" class="block mt-1 w-full" type="text" name="phone"
                                                            :value="old('phone', $user->phone)" required />
                                                    </div>

                                                    <div>
                                                        <x-input-label for="role-{{ $user->id }}" value="Role Akun" class="font-bold text-xs" />
                                                        <select id="role-{{ $user->id }}" name="role" x-model="userRole" required
                                                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-white dark:bg-boxdark text-sm">
                                                            <option value="admin">Admin</option>
                                                            <option value="coach">Pelatih (Coach)</option>
                                                            <option value="parent">Orang Tua</option>
                                                            <option value="general">Umum</option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="password-{{ $user->id }}" value="Ubah Password" class="font-bold text-xs" />
                                                        <div x-data="{ show: false }" class="relative mt-1">
                                                            <x-text-input id="password-{{ $user->id }}" class="block w-full pr-10" x-bind:type="show ? 'text' : 'password'" name="password"
                                                                placeholder="Kosongkan jika tidak ingin diubah" />
                                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                                                                <i x-bind:class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    {{-- Upload Foto Profil - Khusus Coach --}}
                                                    <div x-show="userRole === 'coach'" x-transition class="mt-4 p-4 bg-slate-50 border border-slate-150 rounded-xl space-y-3">
                                                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                                            <i class="fa-solid fa-image mr-1 text-slate-400"></i> Berkas Foto Coach
                                                        </h4>
                                                        
                                                        @if ($user->image)
                                                            <div class="flex items-center gap-3">
                                                                <img src="{{ asset('storage/' . $user->image) }}" alt="Foto {{ $user->name }}"
                                                                    class="w-16 h-16 rounded-xl object-cover border-2 border-slate-200 shadow-sm">
                                                                <div>
                                                                    <p class="text-xs font-bold text-slate-600">Foto Saat Ini</p>
                                                                    <p class="text-[10px] text-slate-400">Pilih file baru untuk mengganti</p>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <input type="file" id="image-{{ $user->id }}" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                                                            class="block w-full text-sm text-slate-500 mt-1
                                                                file:mr-4 file:py-2 file:px-4
                                                                file:rounded-lg file:border-0
                                                                file:text-xs file:font-bold
                                                                file:bg-blue-50 file:text-blue-700
                                                                hover:file:bg-blue-100
                                                                border border-slate-200 rounded-lg cursor-pointer bg-white dark:bg-boxdark" />
                                                        <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP. Maksimal: 2MB</p>
                                                    </div>
                                                </div>

                                                    {{-- Profil Coach: Lisensi, Sertifikasi, Pengalaman --}}
                                                    <div x-show="userRole === 'coach'" x-transition class="mt-4 p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl space-y-4">
                                                        <h4 class="text-xs font-bold text-indigo-700 uppercase tracking-wider">
                                                            <i class="fa-solid fa-id-badge mr-1"></i> Profil Coach
                                                        </h4>

                                                        {{-- Lisensi --}}
                                                        <div x-data="{ items: {{ json_encode($user->licenses ?? []) }} }">
                                                            <label class="block text-xs font-bold text-slate-700 mb-1">Lisensi</label>
                                                            <template x-for="(item, index) in items" :key="index">
                                                                <div class="flex items-center gap-2 mb-1.5">
                                                                    <input type="text" x-model="items[index]" class="flex-1 text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Lisensi C PRSI">
                                                                    <button type="button" @click="items.splice(index, 1)" class="text-red-400 hover:text-red-600 transition text-sm"><i class="fa-solid fa-circle-minus"></i></button>
                                                                </div>
                                                            </template>
                                                            <button type="button" @click="items.push('')" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold mt-1"><i class="fa-solid fa-circle-plus mr-1"></i>Tambah Lisensi</button>
                                                            <input type="hidden" name="licenses" :value="JSON.stringify(items)">
                                                        </div>

                                                        {{-- Sertifikasi --}}
                                                        <div x-data="{ items: {{ json_encode($user->certifications ?? []) }} }">
                                                            <label class="block text-xs font-bold text-slate-700 mb-1">Sertifikasi Keahlian</label>
                                                            <template x-for="(item, index) in items" :key="index">
                                                                <div class="flex items-center gap-2 mb-1.5">
                                                                    <input type="text" x-model="items[index]" class="flex-1 text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Sertifikat First Aid & CPR">
                                                                    <button type="button" @click="items.splice(index, 1)" class="text-red-400 hover:text-red-600 transition text-sm"><i class="fa-solid fa-circle-minus"></i></button>
                                                                </div>
                                                            </template>
                                                            <button type="button" @click="items.push('')" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold mt-1"><i class="fa-solid fa-circle-plus mr-1"></i>Tambah Sertifikasi</button>
                                                            <input type="hidden" name="certifications" :value="JSON.stringify(items)">
                                                        </div>

                                                        {{-- Pengalaman --}}
                                                        <div>
                                                            <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman & Status</label>
                                                            <input type="text" name="experience" value="{{ $user->experience }}" class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Aktif melatih sejak 2021 di Black Diamond">
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

                                        {{-- Modal Konfirmasi Hapus --}}
                                        <x-modal name="confirm-user-deletion-{{ $user->id }}" focusable>
                                            <form method="post" action="{{ route('admin.users.destroy', $user->id) }}" class="p-6 text-left">
                                                @csrf
                                                @method('delete')

                                                <div class="flex items-center justify-start space-x-3 text-red-650 mb-4">
                                                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                                                    <h2 class="text-lg font-extrabold text-slate-800">
                                                        Hapus Akun Pengguna?
                                                    </h2>
                                                </div>

                                                <p class="text-sm text-slate-600 leading-relaxed">
                                                    Akun pengguna bernama <strong class="text-slate-900">"{{ $user->name }}"</strong> dengan role <strong class="text-slate-900">{{ ucfirst($user->role) }}</strong> akan dihapus permanen. Pengguna yang bersangkutan tidak akan bisa login lagi ke dalam sistem.
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
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-users-slash text-slate-300 text-3xl mb-3"></i>
                                            <p class="text-sm font-semibold text-slate-500">Tidak ada data pengguna ditemukan.</p>
                                            @if($search)
                                                <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian Anda.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-4 px-2">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Pendaftaran Pengguna Baru (Create) --}}
    <x-modal name="create-user-modal" maxWidth="lg" focusable>
        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" 
              class="p-6 text-left" x-data="{ userRole: 'parent' }">
            @csrf

            <h3 class="text-lg font-extrabold text-slate-800 mb-5 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-blue-600"></i> Registrasi Akun Pengguna Baru
            </h3>

            <div class="space-y-4">
                <div>
                    <x-input-label for="create-name" value="Nama Lengkap" class="font-bold text-xs" />
                    <x-text-input id="create-name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                </div>

                <div>
                    <x-input-label for="create-username" value="Username (Untuk Login)" class="font-bold text-xs" />
                    <x-text-input id="create-username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
                </div>

                <div>
                    <x-input-label for="create-phone" value="No. WhatsApp / Telepon" class="font-bold text-xs" />
                    <x-text-input id="create-phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Misal: 0812345..." required />
                </div>

                <div>
                    <x-input-label for="create-role" value="Role Akun" class="font-bold text-xs" />
                    <select id="create-role" name="role" x-model="userRole" required
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm bg-white dark:bg-boxdark text-sm">
                        <option value="parent">Orang Tua</option>
                        <option value="general">Umum</option>
                        <option value="coach">Pelatih (Coach)</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="create-password" value="Password" class="font-bold text-xs" />
                    <div x-data="{ show: false }" class="relative mt-1">
                        <x-text-input id="create-password" class="block w-full pr-10" x-bind:type="show ? 'text' : 'password'" name="password" required />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition">
                            <i x-bind:class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Upload Foto Profil - Khusus Coach --}}
                <div x-show="userRole === 'coach'" x-transition class="mt-4 p-4 bg-slate-50 border border-slate-150 rounded-xl space-y-3">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                        <i class="fa-solid fa-image mr-1 text-slate-400"></i> Berkas Foto Coach
                    </h4>
                    <input type="file" id="create-image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="block w-full text-sm text-slate-500 mt-1
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-xs file:font-bold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            border border-slate-200 rounded-lg cursor-pointer bg-white dark:bg-boxdark" />
                    <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP. Maksimal: 2MB</p>
                </div>

                {{-- Profil Coach: Lisensi, Sertifikasi, Pengalaman --}}
                <div x-show="userRole === 'coach'" x-transition class="mt-4 p-4 bg-indigo-50/50 border border-indigo-100 rounded-xl space-y-4">
                    <h4 class="text-xs font-bold text-indigo-700 uppercase tracking-wider">
                        <i class="fa-solid fa-id-badge mr-1"></i> Profil Coach
                    </h4>

                    {{-- Lisensi --}}
                    <div x-data="{ items: [] }">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Lisensi</label>
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-center gap-2 mb-1.5">
                                <input type="text" x-model="items[index]" class="flex-1 text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Lisensi C PRSI">
                                <button type="button" @click="items.splice(index, 1)" class="text-red-400 hover:text-red-600 transition text-sm"><i class="fa-solid fa-circle-minus"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="items.push('')" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold mt-1"><i class="fa-solid fa-circle-plus mr-1"></i>Tambah Lisensi</button>
                        <input type="hidden" name="licenses" :value="JSON.stringify(items)">
                    </div>

                    {{-- Sertifikasi --}}
                    <div x-data="{ items: [] }">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Sertifikasi Keahlian</label>
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-center gap-2 mb-1.5">
                                <input type="text" x-model="items[index]" class="flex-1 text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Sertifikat First Aid & CPR">
                                <button type="button" @click="items.splice(index, 1)" class="text-red-400 hover:text-red-600 transition text-sm"><i class="fa-solid fa-circle-minus"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="items.push('')" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold mt-1"><i class="fa-solid fa-circle-plus mr-1"></i>Tambah Sertifikasi</button>
                        <input type="hidden" name="certifications" :value="JSON.stringify(items)">
                    </div>

                    {{-- Pengalaman --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman & Status</label>
                        <input type="text" name="experience" class="w-full text-sm border-slate-200 rounded-lg px-3 py-1.5 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Aktif melatih sejak 2021 di Black Diamond">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button>
                    Daftarkan Pengguna
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
