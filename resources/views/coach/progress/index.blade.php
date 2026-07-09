<x-app-layout title="Coach - Catat Perkembangan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat & Pantau Perkembangan') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> {{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> {{ session('error') }}</div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Kiri: Form Input Perkembangan (Lg: 5/12) --}}
                <div class="lg:col-span-5">
                    @php
                        $studentCategories = $students->mapWithKeys(function($s) {
                            $formType = $s->swimmingClass->progress_form_type ?? null;
                            $categorySlug = $s->swimmingClass->category->slug ?? '';
                            $className = strtolower($s->swimmingClass->name ?? '');
                            
                            if ($formType) {
                                $mapped = $formType; // Menggunakan pilihan dari Admin
                            } else {
                                // Fallback untuk data lama sebelum ada fitur ini
                                if ($categorySlug === 'prestasi') {
                                    $mapped = 'prestasi';
                                } else {
                                    $mapped = 'anak-anak'; // default belajar
                                    if (str_contains($className, 'batita')) $mapped = 'batita';
                                    elseif (str_contains($className, 'balita')) $mapped = 'balita';
                                    elseif (str_contains($className, 'dewasa')) $mapped = 'dewasa';
                                }
                            }
                            
                            return [$s->id => $mapped];
                        });
                        $options = ['Belum Berkembang', 'Mulai Terlihat', 'Berkembang Baik', 'Sangat Mahir'];
                        $defaultPbtRows = old('metrics.Personal Best Time') ?: [['gaya' => 'Gaya Bebas', 'jarak' => '50m', 'test_per_bulan' => '', 'pbt_event' => '']];
                    @endphp
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100"
                        x-data="{
                            selectedStudentId: '{{ old('student_id', '') }}',
                            categoriesMap: @js($studentCategories),
                            get classType() {
                                return this.selectedStudentId ? this.categoriesMap[this.selectedStudentId] : null;
                            },
                            showKondisiFisik: false,
                            showSistemEnergi: false,
                            pbtRows: @js($defaultPbtRows),
                            distanceMap: {
                                'Gaya Bebas': ['50m', '100m', '200m', '400m', '800m', '1500m'],
                                'Gaya Punggung': ['50m', '100m', '200m'],
                                'Gaya Dada': ['50m', '100m', '200m'],
                                'Gaya Kupu-kupu': ['50m', '100m', '200m']
                            },
                            addPbtRow() {
                                this.pbtRows.push({ gaya: 'Gaya Bebas', jarak: '50m', test_per_bulan: '', pbt_event: '' });
                            },
                            removePbtRow(index) {
                                this.pbtRows.splice(index, 1);
                            },
                            onGayaChange(row) {
                                row.jarak = this.distanceMap[row.gaya][0];
                            }
                        }">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-blue-600"></i>
                            <span>Input Catatan Perkembangan</span>
                        </h3>

                        <form action="{{ route('coach.progress.store') }}" method="POST">
                            @csrf

                            {{-- Pilih Murid --}}
                            <div class="mb-4">
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Pilih Murid *
                                </label>
                                <select name="student_id" id="student_id" x-model="selectedStudentId"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                    required>
                                    <option value="" disabled selected>-- Pilih Murid Latihan --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }} ({{ $student->swimmingClass->name ?? 'Belum ada kelas' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Bulan & Coach --}}
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Bulan Penilaian *
                                    </label>
                                    <input type="month" name="date" id="date"
                                        value="{{ old('date', date('Y-m')) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 text-sm"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Nama Coach
                                    </label>
                                    <input type="text" value="{{ Auth::user()->name }}"
                                        class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 text-sm cursor-not-allowed"
                                        readonly>
                                </div>
                            </div>

                            <hr class="my-6 border-gray-150">

                            <!-- Form Batita -->
                            <template x-if="classType === 'batita'">
                                <div class="space-y-4">
                                    <h4 class="font-bold text-blue-600 mb-2">Penilaian Batita</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Water Comfort</label>
                                        <select name="metrics[Batita][Water Comfort]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Calm">Calm</option>
                                            <option value="Fear reduce">Fear reduce</option>
                                            <option value="Exploration">Exploration</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Water Skills</label>
                                        <select name="metrics[Batita][Water Skills]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Splashing">Splashing</option>
                                            <option value="Wall gripping">Wall gripping</option>
                                            <option value="Floating (front & back)">Floating (front & back)</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Water Safety</label>
                                        <select name="metrics[Batita][Water Safety]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Breath control">Breath control</option>
                                            <option value="Submersion">Submersion</option>
                                            <option value="Turn & grab">Turn & grab</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                            <!-- Form Balita -->
                            <template x-if="classType === 'balita'">
                                <div class="space-y-4">
                                    <h4 class="font-bold text-blue-600 mb-2">Penilaian Balita</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Water Safety</label>
                                        <select name="metrics[Balita][Water Safety]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Jump">Jump</option>
                                            <option value="Wall exit">Wall exit</option>
                                            <option value="Water trapping">Water trapping</option>
                                            <option value="Rollover">Rollover</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Propulsion & Streamline</label>
                                        <select name="metrics[Balita][Propulsion & Streamline]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Streamline glide">Streamline glide</option>
                                            <option value="Flutter kick">Flutter kick</option>
                                            <option value="Paddling">Paddling</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                                <!-- Form Anak2 & Dewasa -->
                            <template x-if="classType === 'anak-anak'">
                                <div class="space-y-4">
                                    <h4 class="font-bold text-blue-600 mb-2">Basic Skills & Stroke Intro</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">1. Freestyle (Gaya Bebas)</label>
                                        <select name="metrics[Basic Skills][Freestyle]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Side Breathing">Side Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">2. Backstroke (Gaya Punggung)</label>
                                        <select name="metrics[Basic Skills][Backstroke]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breath Control">Breath Control</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">3. Breaststroke (Gaya Dada)</label>
                                        <select name="metrics[Basic Skills][Breaststroke]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breathing">Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">4. Butterfly (Gaya Kupu-kupu)</label>
                                        <select name="metrics[Basic Skills][Butterfly]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breathing">Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <h4 class="font-bold text-blue-600 mb-2 mt-4">Stroke Refinement & Endurance</h4>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Distance 25m</label>
                                        <select name="metrics[Stroke Refinement][Distance 25m]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Nilai...</option>
                                            <option value="Belum Bisa">Belum Bisa</option>
                                            <option value="Mulai Bisa">Mulai Bisa</option>
                                            <option value="Sudah Lancar">Sudah Lancar</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Dive</label>
                                        <select name="metrics[Stroke Refinement][Dive]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Nilai...</option>
                                            <option value="Belum Bisa">Belum Bisa</option>
                                            <option value="Mulai Bisa">Mulai Bisa</option>
                                            <option value="Sudah Lancar">Sudah Lancar</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Turns</label>
                                        <select name="metrics[Stroke Refinement][Turns]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Nilai...</option>
                                            <option value="Belum Bisa">Belum Bisa</option>
                                            <option value="Mulai Bisa">Mulai Bisa</option>
                                            <option value="Sudah Lancar">Sudah Lancar</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                            <!-- Form Dewasa (Basic Skills & Stroke Intro ONLY) -->
                            <template x-if="classType === 'dewasa'">
                                <div class="space-y-4">
                                    <h4 class="font-bold text-blue-600 mb-2">Basic Skills & Stroke Intro</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">1. Freestyle (Gaya Bebas)</label>
                                        <select name="metrics[Basic Skills][Freestyle]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Side Breathing">Side Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">2. Backstroke (Gaya Punggung)</label>
                                        <select name="metrics[Basic Skills][Backstroke]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breath Control">Breath Control</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">3. Breaststroke (Gaya Dada)</label>
                                        <select name="metrics[Basic Skills][Breaststroke]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breathing">Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">4. Butterfly (Gaya Kupu-kupu)</label>
                                        <select name="metrics[Basic Skills][Butterfly]" class="w-full text-sm rounded-md border-gray-300 mb-2" required>
                                            <option value="">Pilih Tahap Dikuasai...</option>
                                            <option value="Belum Memulai">Belum Memulai</option>
                                            <option value="Kicking">Kicking</option>
                                            <option value="Pulling">Pulling</option>
                                            <option value="Breathing">Breathing</option>
                                            <option value="Lulus Tahap Ini">Lulus Tahap Ini</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                            <!-- Form Prestasi -->
                            <template x-if="classType === 'prestasi'">
                                 <div class="space-y-4">
                                    {{-- Personal Best Time - WAJIB diisi setiap bulan --}}
                                    <h4 class="font-bold text-blue-600 mb-2 flex items-center gap-2">
                                        <i class="fa-solid fa-stopwatch"></i> Personal Best Time
                                        <span class="text-xs font-normal text-red-500">*Wajib diisi minimal satu nomor</span>
                                    </h4>

                                    <div class="space-y-3">
                                        <template x-for="(row, index) in pbtRows" :key="index">
                                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg relative space-y-3">
                                                <!-- Header Baris + Tombol Hapus -->
                                                <div class="flex justify-between items-center border-b pb-2 border-slate-200">
                                                    <span class="text-xs font-bold text-slate-700" x-text="'Nomor Tes #' + (index + 1)"></span>
                                                    <template x-if="index > 0">
                                                        <button type="button" @click="removePbtRow(index)"
                                                            class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1 font-semibold transition-colors duration-150">
                                                            <i class="fa-solid fa-trash-can"></i> Hapus Nomor Ini
                                                        </button>
                                                    </template>
                                                </div>

                                                <!-- Grid Input: 1 Baris per input (Vertical Stack) -->
                                                <div class="space-y-3">
                                                    <!-- Gaya Renang -->
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Gaya Renang</label>
                                                        <select :name="'metrics[Personal Best Time][' + index + '][gaya]'" x-model="row.gaya" @change="onGayaChange(row)"
                                                            class="w-full text-xs rounded-md border-gray-300 py-1.5 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                                                            <option value="Gaya Bebas">Gaya Bebas</option>
                                                            <option value="Gaya Punggung">Gaya Punggung</option>
                                                            <option value="Gaya Dada">Gaya Dada</option>
                                                            <option value="Gaya Kupu-kupu">Gaya Kupu-kupu</option>
                                                        </select>
                                                    </div>

                                                    <!-- Jarak -->
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jarak</label>
                                                        <select :name="'metrics[Personal Best Time][' + index + '][jarak]'" x-model="row.jarak"
                                                            class="w-full text-xs rounded-md border-gray-300 py-1.5 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                                                            <template x-for="dist in distanceMap[row.gaya]" :key="dist">
                                                                <option :value="dist" x-text="dist"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <!-- Test per Bulan -->
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Test per Bulan</label>
                                                        <input type="text" :name="'metrics[Personal Best Time][' + index + '][test_per_bulan]'" x-model="row.test_per_bulan"
                                                            placeholder="Contoh: 01:25.50" required
                                                            class="w-full text-xs rounded-md border-gray-300 py-1.5 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                                                    </div>

                                                    <!-- PBT Event (Opsional) -->
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1">PBT Event (Opsional)</label>
                                                        <input type="text" :name="'metrics[Personal Best Time][' + index + '][pbt_event]'" x-model="row.pbt_event"
                                                            placeholder="Contoh: 01:22.10 (Kejurda)"
                                                            class="w-full text-xs rounded-md border-gray-300 py-1.5 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Tombol Tambah Baris -->
                                    <div class="mt-2 mb-4">
                                        <button type="button" @click="addPbtRow()"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-lg text-xs transition-all duration-150">
                                            <i class="fa-solid fa-plus"></i> Tambah Tes Gaya/Jarak Lain
                                        </button>
                                    </div>

                                    <hr class="my-4 border-gray-200">

                                    {{-- Kondisi Fisik - OPSIONAL --}}
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" @click="showKondisiFisik = !showKondisiFisik"
                                            class="w-full flex items-center justify-between p-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150">
                                            <h4 class="font-bold text-blue-600 flex items-center gap-2 text-sm">
                                                <i class="fa-solid fa-dumbbell"></i> Kondisi Fisik
                                                <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                                            </h4>
                                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                                :class="showKondisiFisik ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="showKondisiFisik" x-collapse class="p-4 space-y-3 bg-white">
                                            <p class="text-xs text-gray-400 italic mb-2">Kosongkan jika tidak ada penilaian bulan ini.</p>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Endurance</label>
                                                <input type="number" name="metrics[Kondisi Fisik][Endurance]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Fleksibilitas</label>
                                                <input type="number" name="metrics[Kondisi Fisik][Fleksibilitas]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Strength (Kekuatan)</label>
                                                <input type="number" name="metrics[Kondisi Fisik][Strength]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Speed (Kecepatan)</label>
                                                <input type="number" name="metrics[Kondisi Fisik][Speed]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Agility (Kelincahan)</label>
                                                <input type="number" name="metrics[Kondisi Fisik][Agility]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sistem Energi - OPSIONAL --}}
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" @click="showSistemEnergi = !showSistemEnergi"
                                            class="w-full flex items-center justify-between p-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150">
                                            <h4 class="font-bold text-blue-600 flex items-center gap-2 text-sm">
                                                <i class="fa-solid fa-bolt"></i> Sistem Energi
                                                <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                                            </h4>
                                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                                :class="showSistemEnergi ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="showSistemEnergi" x-collapse class="p-4 space-y-3 bg-white">
                                            <p class="text-xs text-gray-400 italic mb-2">Kosongkan jika tidak ada penilaian bulan ini.</p>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Aerobic</label>
                                                <input type="number" name="metrics[Sistem Energi][Aerobic]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1">Anaerobic</label>
                                                <input type="number" name="metrics[Sistem Energi][Anaerobic]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Catatan tambahan --}}
                            <div class="mb-6 mt-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea name="notes" id="notes" rows="3" placeholder="Tulis catatan penting..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 text-sm">{{ old('notes') }}</textarea>
                            </div>

                            <div x-show="classType !== null">
                                <button type="submit"
                                    class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-150 text-sm flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Simpan Perkembangan
                                </button>
                            </div>
                            <div x-show="classType === null" class="text-center text-sm text-gray-500 mt-4">
                                Silakan pilih murid untuk menampilkan form.
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Kanan: Visualisasi History --}}
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 flex-1 flex flex-col">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                                <span>Riwayat Perkembangan Terakhir</span>
                            </h3>

                            <div class="w-full sm:w-64">
                                <select id="chart_student_id"
                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm text-gray-900 font-semibold bg-gray-50">
                                    <option value="" disabled selected>-- Pilih Murid --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="chart-empty-state" class="flex-1 flex flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Silakan pilih murid</p>
                        </div>

                        <div id="chart-no-data-state" class="hidden flex-1 flex-col items-center justify-center text-center p-12 text-gray-400">
                            <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                            <p class="font-medium text-gray-600">Belum ada riwayat</p>
                        </div>

                        <div id="notes-timeline-container" class="hidden flex-1 flex-col overflow-y-auto max-h-[600px]">
                            <div id="notes-timeline" class="space-y-6 pr-2">
                                <!-- Populated via JS -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentsMap = @json($students->keyBy('id')->map(function($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'progress_reports' => $s->progressReports
                ];
            }));

            const selectDropdown = document.getElementById('chart_student_id');
            const emptyState = document.getElementById('chart-empty-state');
            const noDataState = document.getElementById('chart-no-data-state');
            const notesTimelineContainer = document.getElementById('notes-timeline-container');
            const notesTimeline = document.getElementById('notes-timeline');

            selectDropdown.addEventListener('change', function() {
                const studentId = this.value;
                const student = studentsMap[studentId];

                if (!student) return;

                const reports = student.progress_reports || [];

                if (reports.length === 0) {
                    emptyState.classList.add('hidden');
                    notesTimelineContainer.classList.add('hidden');
                    notesTimelineContainer.classList.remove('flex');
                    noDataState.classList.remove('hidden');
                    noDataState.classList.add('flex');
                    return;
                }

                emptyState.classList.add('hidden');
                noDataState.classList.add('hidden');
                noDataState.classList.remove('flex');
                
                notesTimelineContainer.classList.remove('hidden');
                notesTimelineContainer.classList.add('flex');

                notesTimeline.innerHTML = '';
                const sortedReports = [...reports].sort((a, b) => new Date(b.date) - new Date(a.date));

                sortedReports.forEach(report => {
                    const d = new Date(report.date);
                    const monthYear = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                    
                    let metricsHtml = '';
                    if (report.metrics) {
                        for (const [category, items] of Object.entries(report.metrics)) {
                            if (category === 'Personal Best Time') {
                                metricsHtml += `<div class="mb-3"><h5 class="text-sm font-bold text-slate-800 border-b pb-1 mb-2">${category}</h5><div class="space-y-2">`;
                                const entries = Array.isArray(items) ? items : [items];
                                entries.forEach(e => {
                                    if (e.gaya) {
                                        metricsHtml += `<div class="text-xs p-2.5 bg-slate-50 border border-slate-100 rounded-lg flex flex-col gap-1">
                                            <div class="flex justify-between items-center">
                                                <span class="font-bold text-indigo-700">${e.gaya} (${e.jarak})</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold bg-purple-100 text-purple-700">Test: ${e.test_per_bulan}</span>
                                            </div>
                                            ${e.pbt_event ? `<div class="text-[10px] text-gray-500"><i class="fa-solid fa-medal text-amber-500 mr-1"></i>Event: ${e.pbt_event}</div>` : ''}
                                        </div>`;
                                    } else {
                                        // Old format fallback
                                        metricsHtml += `<div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                        for (const [key, val] of Object.entries(e)) {
                                            metricsHtml += `<div class="text-xs flex justify-between items-center p-2 bg-slate-50 rounded">
                                                <span class="font-medium text-slate-600">${key}</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold bg-purple-100 text-purple-700">${val}</span>
                                            </div>`;
                                        }
                                        metricsHtml += `</div>`;
                                    }
                                });
                                metricsHtml += `</div></div>`;
                            } else {
                                metricsHtml += `<div class="mb-3"><h5 class="text-sm font-bold text-slate-800 border-b pb-1 mb-2">${category}</h5><div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                for (const [key, val] of Object.entries(items)) {
                                    let badgeColor = 'bg-slate-100 text-slate-700';
                                    if (val === 'Sangat Mahir') badgeColor = 'bg-green-100 text-green-700';
                                    else if (val === 'Berkembang Baik') badgeColor = 'bg-blue-100 text-blue-700';
                                    else if (val === 'Mulai Terlihat') badgeColor = 'bg-amber-100 text-amber-700';
                                    else if (val === 'Belum Berkembang') badgeColor = 'bg-red-100 text-red-700';

                                    metricsHtml += `<div class="text-xs flex justify-between items-center p-2 bg-slate-50 rounded">
                                        <span class="font-medium text-slate-600">${key}</span>
                                        <span class="px-2 py-0.5 rounded-full font-bold ${badgeColor}">${val}</span>
                                    </div>`;
                                }
                                metricsHtml += `</div></div>`;
                            }
                        }
                    }

                    const item = document.createElement('div');
                    item.className = 'relative pl-6 pb-6 border-l-2 border-indigo-100 last:pb-0 last:border-l-0';
                    item.innerHTML = `
                        <span class="absolute -left-[7px] top-1.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-indigo-500 ring-4 ring-white"></span>
                        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm font-bold text-indigo-700">
                                    <i class="fa-regular fa-calendar-days mr-1"></i> Bulan: ${monthYear}
                                </span>
                            </div>
                            <div class="mb-4">
                                ${metricsHtml}
                            </div>
                            ${report.notes ? `
                            <div class="bg-indigo-50 border border-indigo-100 p-3 rounded-md">
                                <p class="text-xs font-bold text-indigo-800 mb-1"><i class="fa-solid fa-comment-dots"></i> Catatan Pelatih:</p>
                                <p class="text-sm text-slate-700 italic">${report.notes}</p>
                            </div>` : ''}
                        </div>
                    `;
                    notesTimeline.appendChild(item);
                });
            });

            @if (old('student_id'))
                selectDropdown.value = "{{ old('student_id') }}";
                selectDropdown.dispatchEvent(new Event('change'));
            @elseif ($students->isNotEmpty())
                selectDropdown.value = "{{ $students->first()->id }}";
                selectDropdown.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app-layout>