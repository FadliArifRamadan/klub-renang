<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Coach - Catat Perkembangan'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Catat & Pantau Perkembangan')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <i class="fa-solid fa-triangle-exclamation mt-0.5 mr-2 text-lg"></i>
            <div><span class="font-bold">Error!</span> <?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                
                <div class="lg:col-span-5">
                    <?php
                        $studentCategories = $students->mapWithKeys(function($s) {
                            $className = strtolower($s->swimmingClass->name ?? '');
                            $mapped = 'anak-anak'; // default
                            if (str_contains($className, 'batita')) $mapped = 'batita';
                            elseif (str_contains($className, 'balita')) $mapped = 'balita';
                            elseif (str_contains($className, 'dewasa')) $mapped = 'dewasa';
                            elseif (str_contains($className, 'anak')) $mapped = 'anak-anak';
                            elseif (in_array($className, ['pra junior', 'junior', 'senior', 'finswimming'])) $mapped = 'prestasi';
                            return [$s->id => $mapped];
                        });
                        $options = ['Belum Berkembang', 'Mulai Terlihat', 'Berkembang Baik', 'Sangat Mahir'];
                    ?>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100"
                        x-data="{
                            selectedStudentId: '<?php echo e(old('student_id', '')); ?>',
                            categoriesMap: <?php echo \Illuminate\Support\Js::from($studentCategories)->toHtml() ?>,
                            get classType() {
                                return this.selectedStudentId ? this.categoriesMap[this.selectedStudentId] : null;
                            }
                        }">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-file-signature text-blue-600"></i>
                            <span>Input Catatan Perkembangan</span>
                        </h3>

                        <form action="<?php echo e(route('coach.progress.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            
                            <div class="mb-4">
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Pilih Murid *
                                </label>
                                <select name="student_id" id="student_id" x-model="selectedStudentId"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900"
                                    required>
                                    <option value="" disabled selected>-- Pilih Murid Latihan --</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>">
                                            <?php echo e($student->name); ?> (<?php echo e($student->swimmingClass->name ?? 'Belum ada kelas'); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Bulan Penilaian *
                                    </label>
                                    <input type="month" name="date" id="date"
                                        value="<?php echo e(old('date', date('Y-m'))); ?>"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 text-sm"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Nama Coach
                                    </label>
                                    <input type="text" value="<?php echo e(Auth::user()->name); ?>"
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
                                    <h4 class="font-bold text-blue-600 mb-2">Kondisi Fisik</h4>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Endurance</label>
                                        <input type="number" name="metrics[Kondisi Fisik][Endurance]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Fleksibilitas</label>
                                        <input type="number" name="metrics[Kondisi Fisik][Fleksibilitas]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Strength (Kekuatan)</label>
                                        <input type="number" name="metrics[Kondisi Fisik][Strength]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Speed (Kecepatan)</label>
                                        <input type="number" name="metrics[Kondisi Fisik][Speed]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Agility (Kelincahan)</label>
                                        <input type="number" name="metrics[Kondisi Fisik][Agility]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>

                                    <h4 class="font-bold text-blue-600 mb-2 mt-4">Sistem Energi</h4>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Aerobic</label>
                                        <input type="number" name="metrics[Sistem Energi][Aerobic]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Anaerobic</label>
                                        <input type="number" name="metrics[Sistem Energi][Anaerobic]" class="w-full text-sm rounded-md border-gray-300" placeholder="Skor..." required>
                                    </div>

                                    <h4 class="font-bold text-blue-600 mb-2 mt-4">Personal Best Time</h4>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Test per Bulan</label>
                                        <input type="text" name="metrics[Personal Best Time][Test per Bulan]" class="w-full text-sm rounded-md border-gray-300" placeholder="Contoh: 01:25.50" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">PBT Event (Opsional)</label>
                                        <input type="text" name="metrics[Personal Best Time][PBT Event]" class="w-full text-sm rounded-md border-gray-300" placeholder="Contoh: 01:22.10 (Kejurda)">
                                    </div>
                                </div>
                            </template>

                            
                            <div class="mb-6 mt-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea name="notes" id="notes" rows="3" placeholder="Tulis catatan penting..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 text-sm"><?php echo e(old('notes')); ?></textarea>
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
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            const studentsMap = <?php echo json_encode($students->keyBy('id')->map(function($s) {
                return [
                    'id' => $s->id, 'name' => $s->name, 'progress_reports' => $s->progressReports
                ];
            })) ?>;

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

            <?php if(old('student_id')): ?>
                selectDropdown.value = "<?php echo e(old('student_id')); ?>";
                selectDropdown.dispatchEvent(new Event('change'));
            <?php elseif($students->isNotEmpty()): ?>
                selectDropdown.value = "<?php echo e($students->first()->id); ?>";
                selectDropdown.dispatchEvent(new Event('change'));
            <?php endif; ?>
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\klub-renang\resources\views/coach/progress/index.blade.php ENDPATH**/ ?>