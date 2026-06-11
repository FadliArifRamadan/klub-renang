<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Parent - Dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard Parent')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Halo, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di portal orang tua Black Diamond. Pantau perkembangan anak Anda, cek status latihan,
                    dan lihat catatan terbaru dari pelatih di sini.
                </p>
            </div>

            
            <?php if(isset($expiredStudents) && $expiredStudents->isNotEmpty()): ?>
                <div class="bg-amber-50 border border-amber-300 rounded-xl p-5 mb-8 shadow-sm" x-data="{ showNotif: true }" x-show="showNotif" x-transition>
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 w-full">
                            <div class="p-2 bg-amber-100 text-amber-600 rounded-lg mt-0.5 shrink-0">
                                <i class="fa-solid fa-bell text-lg"></i>
                            </div>
                            <div class="w-full">
                                <h4 class="font-bold text-amber-800 text-sm">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                    Sesi Latihan Telah Habis!
                                </h4>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Beberapa anak Anda telah menghabiskan seluruh kuota sesi latihannya. Silakan lakukan daftar ulang paket latihan di bawah ini.
                                </p>
                                <div class="mt-3 space-y-2 max-w-2xl">
                                    <?php $__currentLoopData = $expiredStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expStudent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-wrap items-center gap-2 bg-white/60 border border-amber-200 rounded-lg px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-child text-amber-500"></i>
                                                <span class="font-semibold text-sm text-gray-800"><?php echo e($expStudent->name); ?></span>
                                                <span class="text-xs text-gray-500">—</span>
                                                <span class="text-xs text-gray-600"><?php echo e($expStudent->package->name ?? 'Paket'); ?></span>
                                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-red-200">
                                                    Sesi Habis
                                                </span>
                                            </div>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'renew-student-<?php echo e($expStudent->id); ?>')"
                                                class="ml-auto px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-rotate-right"></i> Daftar Ulang
                                            </button>
                                        </div>

                                        
                                        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'renew-student-'.e($expStudent->id).'','maxWidth' => 'lg','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'renew-student-'.e($expStudent->id).'','maxWidth' => 'lg','focusable' => true]); ?>
                                            <form method="POST" action="<?php echo e(route('parent.students.renew', $expStudent->id)); ?>" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{ 
                                                    packageId: '<?php echo e($expStudent->package_id); ?>',
                                                    locationId: '<?php echo e($expStudent->location_id); ?>',
                                                    packages: <?php echo e($packages->toJson()); ?>,
                                                    getPrice() {
                                                        const pkg = this.packages.find(p => p.id == this.packageId);
                                                        if (!pkg) return 0;
                                                        if (pkg.is_location_based && pkg.location_prices) {
                                                            const lp = pkg.location_prices.find(l => l.location_id == this.locationId);
                                                            return lp ? lp.price : 0;
                                                        }
                                                        return pkg.price ?? 0;
                                                    },
                                                    formatPrice(price) {
                                                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
                                                    }
                                                }">
                                                <?php echo csrf_field(); ?>

                                                
                                                <input type="hidden" name="swimming_class_id" value="<?php echo e($expStudent->swimming_class_id); ?>">

                                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                    <i class="fa-solid fa-rotate-right text-amber-500"></i>
                                                    Daftar Ulang Paket Latihan - <?php echo e($expStudent->name); ?>

                                                </h3>

                                                <?php if($expStudent->swimmingClass): ?>
                                                    <div class="mb-4 bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 text-xs text-blue-700 flex items-center gap-2">
                                                        <i class="fa-solid fa-layer-group"></i>
                                                        <span>Kelas: <strong><?php echo e($expStudent->swimmingClass->name); ?></strong></span>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Tanggal Lahir -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'birth_date-'.e($expStudent->id).'','value' => 'Tanggal Lahir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'birth_date-'.e($expStudent->id).'','value' => 'Tanggal Lahir']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'birth_date-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'date','name' => 'birth_date','value' => ''.e($expStudent->birth_date?->format('Y-m-d')).'','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'birth_date-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'date','name' => 'birth_date','value' => ''.e($expStudent->birth_date?->format('Y-m-d')).'','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                                </div>

                                                <!-- Jenis Kelamin -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'gender-'.e($expStudent->id).'','value' => 'Jenis Kelamin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'gender-'.e($expStudent->id).'','value' => 'Jenis Kelamin']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                    <select id="gender-<?php echo e($expStudent->id); ?>" name="gender" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="L" <?php echo e($expStudent->gender == 'L' || $expStudent->gender == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                                                        <option value="P" <?php echo e($expStudent->gender == 'P' || $expStudent->gender == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                                                    </select>
                                                </div>

                                                <!-- Tempat Latihan -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'location-'.e($expStudent->id).'','value' => 'Kolam Latihan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'location-'.e($expStudent->id).'','value' => 'Kolam Latihan']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                    <select id="location-<?php echo e($expStudent->id); ?>" name="location_id" x-model="locationId" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($loc->id); ?>" <?php echo e($expStudent->location_id == $loc->id ? 'selected' : ''); ?>>
                                                                <?php echo e($loc->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <!-- Paket Latihan -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'package-'.e($expStudent->id).'','value' => 'Paket Kursus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'package-'.e($expStudent->id).'','value' => 'Paket Kursus']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                    <select id="package-<?php echo e($expStudent->id); ?>" name="package_id" x-model="packageId" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($pkg->id); ?>">
                                                                <?php echo e($pkg->name); ?> (<?php echo e($pkg->sessions); ?> Sesi)
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <!-- Info Pembayaran & Rekening -->
                                                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-4 text-xs text-blue-800">
                                                    <p class="font-bold text-sm mb-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Informasi Pembayaran</p>
                                                    <p>Silakan transfer nominal ke rekening berikut:</p>
                                                    <p class="font-extrabold text-gray-900 mt-1">Bank BCA: 123-4567-890 (a.n. Klub Renang)</p>
                                                    <div class="mt-2 pt-2 border-t border-blue-200/50 flex justify-between items-center">
                                                        <span class="font-semibold">Nominal Transfer:</span>
                                                        <span class="text-sm font-black text-blue-700" x-text="formatPrice(getPrice())"></span>
                                                    </div>
                                                </div>

                                                <!-- Bukti Transfer -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'receipt-'.e($expStudent->id).'','value' => 'Unggah Bukti Transfer (Screenshot/Foto)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'receipt-'.e($expStudent->id).'','value' => 'Unggah Bukti Transfer (Screenshot/Foto)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                                    <input type="file" id="receipt-<?php echo e($expStudent->id); ?>" name="receipt_image" accept="image/*" required
                                                        class="block w-full text-sm text-gray-500 mt-1
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-md file:border-0
                                                            file:text-xs file:font-semibold
                                                            file:bg-blue-50 file:text-blue-700
                                                            hover:file:bg-blue-100
                                                            border border-gray-300 rounded-md cursor-pointer p-1" />
                                                    <p class="text-[10px] text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                                                </div>

                                                <!-- Aksi -->
                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['type' => 'button','xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','x-on:click' => '$dispatch(\'close\')']); ?>
                                                        Batal
                                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
                                                    <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs uppercase tracking-widest rounded-md shadow-sm transition">
                                                        Kirim Pendaftaran Ulang
                                                    </button>
                                                </div>
                                            </form>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <button @click="showNotif = false" class="text-amber-400 hover:text-amber-600 transition-colors p-1 self-start">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalStudents); ?> Murid</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalCoaches); ?> Pelatih</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-gray-900 mt-0.5"><?php echo e($totalLocations); ?> Lokasi</p>
                        </div>
                    </div>
                    <div class="text-gray-200">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 flex flex-col">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-blue-600"></i>
                            Grafik Catatan Perkembangan Anak
                        </h3>
                        <p class="text-xs text-gray-500">Pilih anak Anda untuk memantau performa latihan dan indikator
                            fisiknya.</p>
                    </div>

                    
                    <?php if($children->isNotEmpty()): ?>
                        <div class="w-full sm:w-72">
                            <select id="chart_child_id"
                                class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5">
                                <option value="" disabled selected>-- Pilih Anak --</option>
                                <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($child->id); ?>">
                                        <?php echo e($child->name); ?> (<?php echo e($child->package->name ?? 'Tanpa Paket'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($children->isEmpty()): ?>
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-child-reaching text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada anak yang terdaftar</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Daftarkan anak Anda terlebih dahulu untuk mulai
                            memantau perkembangan latihannya.</p>
                        <a href="<?php echo e(route('parent.students.create')); ?>"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-plus"></i> Daftarkan Anak
                        </a>
                    </div>
                <?php else: ?>
                    
                    <div id="chart-empty-state"
                        class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-chart-column text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Silakan pilih anak pada dropdown untuk menampilkan grafik
                        </p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Grafik perkembangan akan memvisualisasikan data
                            kekuatan, daya tahan, kelenturan, kecepatan, dan kelincahan.</p>
                    </div>

                    
                    <div id="chart-no-data-state"
                        class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk anak ini</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping
                            untuk
                            menginput data perkembangan fisik pertama.</p>
                    </div>

                    
                    <div id="chart-container" class="hidden flex-1 flex-col">
                        
                        <div id="chart-canvas-wrapper" class="relative w-full h-[360px] mb-6">
                            <canvas id="progressChart"></canvas>
                        </div>

                        
                        <div id="freetext-container" class="hidden overflow-y-auto max-h-[340px] mb-6 space-y-2 pr-1">
                            
                        </div>

                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                            <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                <h4
                                    class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                </h4>
                                <p id="latest-note" class="text-sm text-gray-600 italic">"Tidak ada catatan pada evaluasi terakhir."</p>
                                <div id="latest-note-date" class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput pada: -</div>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                <h4
                                    class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Info Latihan Anak
                                </h4>
                                <div class="space-y-1.5 text-xs text-gray-600">
                                    <div>Kelas: <span id="student-class" class="font-bold text-gray-800">-</span></div>
                                    <div>Pelatih: <span id="student-coach" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Lokasi: <span id="student-location" class="font-bold text-gray-800">-</span>
                                    </div>
                                    <div>Sisa Kuota: <span id="student-quota" class="font-bold text-blue-600">-</span>
                                    </div>
                                    <div id="student-schedule-container" class="hidden pt-1.5 mt-1.5 border-t border-gray-200">
                                        <span class="font-bold text-gray-500 block mb-1">Jadwal Aktif:</span>
                                        <div id="student-schedules" class="space-y-0.5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php if($children->isNotEmpty()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data anak & perkembangan dari Laravel dijadikan object JS
                const childrenArray = <?php echo json_encode($children, 15, 512) ?>;
                const childrenMap = {};
                childrenArray.forEach(function(c) {
                    childrenMap[String(c.id)] = c;
                });

                const selectDropdown = document.getElementById('chart_child_id');
                const emptyState = document.getElementById('chart-empty-state');
                const noDataState = document.getElementById('chart-no-data-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');

                let myChart = null;

                selectDropdown.addEventListener('change', function() {
                    const childId = String(this.value);
                    const child = childrenMap[childId];

                    if (!child) return;

                    // Info anak
                    document.getElementById('student-class').textContent = child.swimming_class ?
                        `${child.swimming_class.name} (${child.swimming_class.category.name})` :
                        'Belum Ditentukan';
                    document.getElementById('student-coach').textContent = child.coach ? child.coach.name :
                        'Belum Ditugaskan';

                    let locText = child.location ? child.location.name : 'Belum Dipilih';
                    if (child.secondary_location) {
                        locText += ` & ${child.secondary_location.name}`;
                    }
                    document.getElementById('student-location').textContent = locText;
                    document.getElementById('student-quota').textContent = `${child.quota_left} sesi`;

                    // Update schedules
                    const schedulesContainer = document.getElementById('student-schedule-container');
                    const schedulesDiv = document.getElementById('student-schedules');
                    schedulesDiv.innerHTML = '';

                    if (child.schedules && child.schedules.length > 0) {
                        schedulesContainer.classList.remove('hidden');
                        const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        child.schedules.forEach(sched => {
                            const dayName = days[sched.day_of_week] || 'Hari Tidak Valid';
                            const timeRange = `${sched.start_time.substring(0, 5)} - ${sched.end_time.substring(0, 5)}`;
                            const locName = sched.location ? sched.location.name : 'Lokasi tidak diketahui';
                            const type = sched.session_type === 'dryland' ? 'Dryland' : 'Berenang';

                            const div = document.createElement('div');
                            div.className = 'bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-700 font-bold">${dayName}, ${timeRange}</span>
                                    <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded">${type}</span>
                                </div>
                                <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot"></i> ${locName}
                                </div>
                            `;
                            schedulesDiv.appendChild(div);
                        });
                    } else {
                        schedulesContainer.classList.add('hidden');
                    }

                    const reports = child.progress_reports || [];
                    const chartCanvasWrapper = document.getElementById('chart-canvas-wrapper');
                    const freetextContainer = document.getElementById('freetext-container');

                    if (reports.length === 0) {
                        emptyState.classList.add('hidden');

                        // Reset latest note
                        latestNoteText.textContent = `"Tidak ada catatan pada evaluasi terakhir."`;
                        latestNoteDate.textContent = `Diinput pada: -`;

                        // Sembunyikan chart container
                        chartContainer.classList.add('hidden');
                        chartContainer.style.display = '';

                        // Hancurkan chart lama
                        if (myChart) {
                            myChart.destroy();
                            myChart = null;
                        }

                        noDataState.classList.remove('hidden');
                        noDataState.style.display = 'flex';

                        const coachName = child.coach ? child.coach.name : 'Belum Ditugaskan';
                        document.getElementById('no-data-subtext').textContent =
                            `Hubungi Coach pendamping (${coachName}) untuk menginput data perkembangan fisik pertama.`;
                        return;
                    }

                    // Tampilkan chart container
                    emptyState.classList.add('hidden');
                    noDataState.classList.add('hidden');
                    noDataState.style.display = '';
                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Cek jenis laporan: freetext (Kelas Belajar) vs structured (Kelas Prestasi)
                    const isFreetext = reports[0] && reports[0].report_type === 'freetext';

                    // Update catatan terakhir
                    const latestReport = reports[reports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;
                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`;

                    if (isFreetext) {
                        // Tampilkan list catatan teks untuk Kelas Belajar
                        chartCanvasWrapper.classList.add('hidden');
                        freetextContainer.classList.remove('hidden');
                        freetextContainer.innerHTML = '';

                        if (myChart) { myChart.destroy(); myChart = null; }

                        // Render catatan dari terbaru ke terlama
                        const sortedReports = [...reports].reverse();
                        sortedReports.forEach(report => {
                            const d = new Date(report.date);
                            const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                            const div = document.createElement('div');
                            div.className = 'bg-white border border-gray-100 rounded-xl p-3 shadow-sm';
                            div.innerHTML = `
                                <div class="flex items-start gap-2">
                                    <div class="p-1.5 bg-green-50 text-green-600 rounded-lg shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[10px] text-gray-400 font-semibold mb-0.5">${dateStr}</div>
                                        <p class="text-sm text-gray-700 leading-relaxed">${report.notes || '<em class="text-gray-400">Tidak ada catatan.</em>'}</p>
                                    </div>
                                </div>
                            `;
                            freetextContainer.appendChild(div);
                        });
                        return;
                    }

                    // Structured report: tampilkan grafik (Kelas Prestasi)
                    chartCanvasWrapper.classList.remove('hidden');
                    freetextContainer.classList.add('hidden');
                    freetextContainer.innerHTML = '';

                    // Siapkan data
                    const labels = [];
                    const strengthData = [];
                    const enduranceData = [];
                    const flexibilityData = [];
                    const speedData = [];
                    const agilityData = [];

                    reports.forEach(report => {
                        const d = new Date(report.date);
                        labels.push(d.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: '2-digit'
                        }));
                        strengthData.push(report.strength);
                        enduranceData.push(report.endurance);
                        flexibilityData.push(report.flexibility);
                        speedData.push(report.speed);
                        agilityData.push(report.agility);
                    });

                    // Hancurkan chart lama
                    if (myChart) {
                        myChart.destroy();
                    }

                    // Render Chart.js
                    const ctx = document.getElementById('progressChart').getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Strength',
                                    data: strengthData,
                                    borderColor: 'rgb(37, 99, 235)',
                                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Endurance',
                                    data: enduranceData,
                                    borderColor: 'rgb(16, 185, 129)',
                                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Flexibility',
                                    data: flexibilityData,
                                    borderColor: 'rgb(147, 51, 234)',
                                    backgroundColor: 'rgba(147, 51, 234, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Speed',
                                    data: speedData,
                                    borderColor: 'rgb(239, 68, 68)',
                                    backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                },
                                {
                                    label: 'Agility',
                                    data: agilityData,
                                    borderColor: 'rgb(245, 158, 11)',
                                    backgroundColor: 'rgba(245, 158, 11, 0.05)',
                                    borderWidth: 2.5,
                                    tension: 0.3,
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        boxWidth: 15,
                                        font: {
                                            size: 11,
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: {
                                    padding: 10,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                y: {
                                    min: 0,
                                    max: 100,
                                    grid: {
                                        color: 'rgba(0,0,0,0.05)'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Skor Perkembangan',
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                });

                // Auto-select anak pertama jika ada
                <?php if($children->isNotEmpty()): ?>
                    selectDropdown.value = "<?php echo e($children->first()->id); ?>";
                    selectDropdown.dispatchEvent(new Event('change'));
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/parent/dashboard.blade.php ENDPATH**/ ?>