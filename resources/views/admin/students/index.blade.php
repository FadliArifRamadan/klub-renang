<x-app-layout title="Admin - Kelola Murid">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Semua Data Murid') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-strokedark">
                <div class="p-6 text-gray-900 dark:text-white">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 pb-4 border-b border-gray-200 dark:border-strokedark">
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-users text-[#D3AF37]"></i> Daftar Anggota Klub Renang
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Memantau seluruh status pendaftaran, pelatih yang ditunjuk, dan paket latihan aktif secara terpusat.</p>
                        </div>
                        <div class="flex flex-col items-start md:items-end gap-2.5 w-full md:w-auto">
                            {{-- Total Anak diatas --}}
                            <div
                                class="text-xs bg-[#D3AF37]/15 border border-[#D3AF37]/30 text-[#D3AF37] font-bold px-3.5 py-1.5 rounded-lg whitespace-nowrap shadow-sm">
                                Total: {{ $students->total() }} Anak
                            </div>

                            {{-- Form Pencarian dibawah --}}
                            <form method="GET" action="{{ route('admin.students.index') }}" class="flex items-center gap-2 flex-nowrap whitespace-nowrap">
                                <div class="relative flex items-center w-48 sm:w-56 shrink-0">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ $search ?? '' }}" 
                                           placeholder="Cari murid / coach..." 
                                           class="w-full pl-9 pr-3 py-2 text-xs border border-gray-300 dark:border-strokedark rounded-lg bg-gray-50 dark:bg-meta-4 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#D3AF37] shadow-sm">
                                </div>
                                <button type="submit" class="px-3.5 py-2 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-bold rounded-lg transition shadow-sm cursor-pointer whitespace-nowrap shrink-0">
                                    Cari
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="px-3.5 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold rounded-lg transition-all shadow-sm flex items-center gap-1.5 whitespace-nowrap cursor-pointer shrink-0">
                                    <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-strokedark shadow-sm">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-meta-4 border-b border-gray-200 dark:border-strokedark text-center">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-4 py-3 text-left">Nama Anak</th>
                                    <th class="px-4 py-3 text-left">Kelas & Paket</th>
                                    <th class="px-4 py-3 text-left min-w-[150px]">Jadwal Latihan</th>
                                    <th class="px-4 py-3">Coach / Pelatih</th>
                                    <th class="px-4 py-3 text-center min-w-[120px]">Absensi</th>
                                    <th class="px-4 py-3 text-center">Status & Masa Aktif</th>
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-strokedark">
                                @forelse($students as $student)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-meta-4 transition duration-150">

                                        <td class="px-4 py-4 text-center text-gray-600 dark:text-gray-400">
                                            {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}
                                        </td>

                                        <td class="px-4 py-4 font-bold text-gray-900 dark:text-white text-left">
                                            {{ $student->name }}
                                            <div class="text-xs font-normal text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ $student->gender_label }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-left">
                                            <div class="font-semibold text-gray-950 dark:text-white">{{ $student->swimmingClass->name ?? 'Belum Pilih Kelas' }}</div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">{{ $student->swimmingClass->category->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                                Paket: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $student->package->name ?? '-' }}</span>
                                            </div>
                                            <div class="text-[11px] text-blue-600 dark:text-blue-400 font-bold mt-0.5">
                                                Harga: Rp 
                                                @if($student->package)
                                                    {{ number_format($student->package->getPriceForLocation($student->location_id), 0, ',', '.') }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-left">
                                            @forelse($student->schedules as $sched)
                                                <div class="mb-1.5 last:mb-0">
                                                    <span class="inline-flex items-center text-[11px] font-semibold text-slate-800 dark:text-slate-100 bg-slate-100 dark:bg-slate-800 rounded px-1.5 py-0.5">
                                                        {{ $sched->day_name }} ({{ substr($sched->start_time, 0, 5) }})
                                                    </span>
                                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium ml-1 mt-0.5 leading-tight">
                                                        <i class="fa-solid fa-map-pin mr-0.5 text-amber-500"></i> {{ $sched->location->name }} 
                                                        <span class="mx-1 text-gray-300 dark:text-gray-600">•</span> 
                                                        @if($sched->session_type == 'dryland')
                                                            <span class="text-amber-600 dark:text-amber-400">Darat</span>
                                                        @else
                                                            <span class="text-blue-600 dark:text-blue-400">Renang</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum Pilih Jadwal</span>
                                            @endforelse
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            @php
                                                $coaches = $student->schedules->map(fn($s) => $s->coach)->filter()->unique('id');
                                            @endphp
                                            @forelse($coaches as $c)
                                                <div class="mb-1 last:mb-0">
                                                    <span
                                                        class="inline-flex items-center bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs px-2.5 py-1 rounded-md font-medium border border-blue-200 dark:border-blue-800">
                                                        <i class="fa-solid fa-user-tie mr-1.5 text-[10px]"></i>
                                                        {{ $c->name }}
                                                    </span>
                                                </div>
                                            @empty
                                                @if ($student->coach)
                                                    <span
                                                        class="inline-flex items-center bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs px-2.5 py-1 rounded-md font-medium border border-blue-200 dark:border-blue-800">
                                                        <i class="fa-solid fa-user-tie mr-1.5 text-[10px]"></i>
                                                        {{ $student->coach->name }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum Ditentukan</span>
                                                @endif
                                            @endforelse
                                        </td>

                                        <td class="px-6 py-4">
                                            @php
                                                $totalSesi = $student->package->sessions ?? 0;
                                                $sesiTerpakai = max(0, $totalSesi - $student->quota_left);
                                                $progressPct =
                                                    $totalSesi > 0 ? round(($sesiTerpakai / $totalSesi) * 100) : 0;
                                                $barColor = match (true) {
                                                    $progressPct >= 80 => 'bg-red-500',
                                                    $progressPct >= 50 => 'bg-amber-400',
                                                    default => 'bg-blue-500',
                                                };
                                            @endphp
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2 min-w-[70px]">
                                                    <div class="{{ $barColor }} h-2 rounded-full transition-all duration-300"
                                                        style="width: {{ $progressPct }}%"></div>
                                                </div>
                                                <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">
                                                    {{ $sesiTerpakai }}/{{ $totalSesi }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Sisa: <span
                                                    class="font-semibold text-blue-600">{{ $student->quota_left }}
                                                    sesi</span>
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            <!-- Status Label -->
                                            <div class="mb-2">
                                                @if ($student->status == 'active')
                                                    <span
                                                        class="bg-green-100 text-green-800 border border-green-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Aktif</span>
                                                @elseif($student->status == 'suspended')
                                                    <span
                                                        class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                        <i class="fa-solid fa-circle-pause mr-1 text-[10px]"></i>
                                                        Membeku
                                                        ({{ $student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin' }})
                                                    </span>
                                                @elseif($student->status == 'inactive')
                                                    @if ($student->quota_left <= 0)
                                                        <span
                                                            class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                            <i class="fa-solid fa-circle-exclamation mr-1 text-[10px]"></i>
                                                            Sesi Habis
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">
                                                            <i class="fa-solid fa-circle-xmark mr-1 text-[10px]"></i>
                                                            Masa Aktif Habis
                                                        </span>
                                                    @endif
                                                @elseif($student->status == 'checking')
                                                    <span
                                                        class="bg-blue-100 text-blue-800 border border-blue-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm animate-pulse">Mengecek
                                                        Pembayaran</span>
                                                @elseif($student->status == 'pending')
                                                    @if ($student->latestPayment && $student->latestPayment->status == 'rejected')
                                                        <span
                                                            class="bg-red-100 text-red-800 border border-red-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Ditolak
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-amber-100 text-amber-800 border border-amber-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">Menunggu
                                                            Pembayaran</span>
                                                    @endif
                                                @else
                                                    <span
                                                        class="bg-gray-100 text-gray-800 border border-gray-300 text-xs px-3 py-1 rounded-full font-bold shadow-sm">{{ $student->status }}</span>
                                                @endif
                                            </div>

                                            <!-- Batas Waktu -->
                                            @if ($student->package_expires_at)
                                                <span class="text-[11px] font-semibold text-gray-700 dark:text-gray-300 block mb-1">
                                                    s/d {{ $student->package_expires_at->format('d M Y') }}
                                                </span>
                                                @php
                                                    $diffInDays = now()->diffInDays(
                                                        $student->package_expires_at,
                                                        false,
                                                    );
                                                @endphp
                                                @if ($student->status == 'active')
                                                    @if ($diffInDays < 0)
                                                        <span
                                                            class="text-[10px] text-red-600 font-bold bg-red-50 border border-red-200 px-1.5 py-0.5 rounded">Hangus</span>
                                                    @elseif ($diffInDays <= 7)
                                                        <span
                                                            class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">{{ round($diffInDays) }}
                                                            hari lagi</span>
                                                    @else
                                                        <span
                                                            class="text-[10px] text-green-600 font-bold bg-green-50 border border-green-200 px-1.5 py-0.5 rounded">{{ round($diffInDays) }}
                                                            hari aktif</span>
                                                    @endif
                                                @elseif($student->status == 'suspended')
                                                    <span
                                                        class="text-[10px] text-amber-600 font-bold bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">DI-FREEZE</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">-</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                                @if ($student->status == 'active')
                                                    <button type="button" x-data=""
                                                        x-on:click="$dispatch('open-modal', 'suspend-student-{{ $student->id }}')"
                                                        class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                                                        <i class="fa-solid fa-pause mr-1"></i> Ijin/Sakit
                                                    </button>

                                                    {{-- Modal Suspend --}}
                                                    <x-modal name="suspend-student-{{ $student->id }}" focusable>
                                                        <form method="POST"
                                                            action="{{ route('admin.students.suspend', $student->id) }}"
                                                            class="p-6 text-left">
                                                            @csrf
                                                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                                                                <i class="fa-solid fa-pause text-amber-500 mr-2"></i>
                                                                Pemberhentian Sementara: {{ $student->name }}
                                                            </h3>
                                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                                Murid akan diberhentikan sementara dari latihan. Sisa kuota
                                                                dan masa aktif paket akan dibekukan (frozen) sampai murid
                                                                diaktifkan kembali.
                                                            </p>

                                                            <div class="mt-4">
                                                                <x-input-label for="reason-{{ $student->id }}"
                                                                    value="Pilih Alasan Pemberhentian" />
                                                                <div class="flex items-center space-x-6 mt-2">
                                                                    <label class="inline-flex items-center cursor-pointer">
                                                                        <input type="radio" name="reason" value="sakit"
                                                                            checked
                                                                            class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                        <span
                                                                            class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Sakit</span>
                                                                    </label>
                                                                    <label class="inline-flex items-center cursor-pointer">
                                                                        <input type="radio" name="reason" value="ijin"
                                                                            class="form-radio text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                        <span
                                                                            class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Ijin</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="mt-6 flex justify-end space-x-3">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    Batal
                                                                </x-secondary-button>
                                                                <x-primary-button
                                                                    class="bg-amber-500 hover:bg-amber-600 text-white">
                                                                    Bekukan Paket
                                                                </x-primary-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                @elseif($student->status == 'suspended')
                                                    <button type="button" x-data=""
                                                        x-on:click="$dispatch('open-modal', 'resume-student-{{ $student->id }}')"
                                                        class="px-2.5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap">
                                                        <i class="fa-solid fa-play mr-1"></i> Aktifkan
                                                    </button>

                                                    {{-- Modal Resume --}}
                                                    <x-modal name="resume-student-{{ $student->id }}" focusable>
                                                        <form method="POST"
                                                            action="{{ route('admin.students.resume', $student->id) }}"
                                                            class="p-6 text-left">
                                                            @csrf
                                                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                                                                <i class="fa-solid fa-play text-green-500 mr-2"></i>
                                                                Aktifkan Kembali Latihan: {{ $student->name }}
                                                            </h3>

                                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                                                Masa aktif paket latihan murid ini akan diperpanjang secara
                                                                otomatis sesuai dengan lama waktu murid tersebut ijin/sakit.
                                                            </p>

                                                            <div
                                                                class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-lg text-xs mb-4">
                                                                <i class="fa-solid fa-info-circle mr-1"></i>
                                                                <strong>Detail Pembekuan:</strong><br>
                                                                - Mulai Dibekukan:
                                                                {{ $student->suspended_at?->format('d M Y - H:i') }}<br>
                                                                - Alasan:
                                                                {{ $student->suspension_reason === 'sakit' ? 'Sakit' : 'Ijin' }}<br>
                                                                - Durasi Suspend:
                                                                {{ round(now()->diffInDays($student->suspended_at)) }} Hari
                                                            </div>

                                                            <div class="mt-6 flex justify-end space-x-3">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    Batal
                                                                </x-secondary-button>
                                                                <x-primary-button
                                                                    class="bg-green-600 hover:bg-green-700 text-white">
                                                                    Aktifkan Latihan
                                                                </x-primary-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
                                                @endif

                                                {{-- Tombol Hapus Murid --}}
                                                <button type="button" x-data=""
                                                    x-on:click="$dispatch('open-modal', 'delete-student-{{ $student->id }}')"
                                                    class="px-2.5 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg transition duration-150 shadow-sm whitespace-nowrap"
                                                    title="Hapus Murid">
                                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                                </button>

                                                {{-- Modal Delete Confirmation --}}
                                                <x-modal name="delete-student-{{ $student->id }}" focusable>
                                                    <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}" class="p-6 text-left">
                                                        @csrf
                                                        @method('DELETE')
                                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                                                            <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                                                            Hapus Data Murid: {{ $student->name }}
                                                        </h3>
                                                        <p class="text-xs text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                                            Apakah Anda yakin ingin menghapus data murid <span class="font-bold text-gray-900 dark:text-white">{{ $student->name }}</span>? Data murid, pendaftaran, dan riwayat absensinya akan dihapus dari sistem secara permanen.
                                                        </p>
                                                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-strokedark">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                Batal
                                                            </x-secondary-button>
                                                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-lg transition shadow-md">
                                                                Ya, Hapus Murid
                                                            </button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-10 text-center text-sm text-gray-400">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                                                <span>Belum ada data murid yang terdaftar pada sistem.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 px-2">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
