<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Umum - Dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h1 class="text-gray-900 text-3xl font-bold tracking-tight">
                    Halo, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-gray-600 mt-2 text-sm max-w-3xl leading-relaxed">
                    Selamat datang di portal anggota Black Diamond. Pantau perkembangan latihan Anda
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
                                    Sesi Latihan Anda Telah Habis!
                                </h4>
                                <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                    Seluruh kuota sesi latihan Anda telah terpakai. Silakan lakukan daftar ulang paket latihan di bawah ini.
                                </p>
                                <div class="mt-3 space-y-2 max-w-2xl">
                                    <?php $__currentLoopData = $expiredStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expStudent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-wrap items-center gap-2 bg-white/60 border border-amber-200 rounded-lg px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-user text-amber-500"></i>
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
                                            <form method="POST" action="<?php echo e(route('general.students.renew', $expStudent->id)); ?>" enctype="multipart/form-data" class="p-6 text-left"
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
                            Grafik Catatan Perkembangan Saya
                        </h3>
                        <p class="text-xs text-gray-500">Visualisasi perkembangan fisik Anda berdasarkan catatan dari
                            pelatih.</p>
                    </div>
                    
                </div>

                <?php if(!$myStudent): ?>
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-person-swimming text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Anda belum terdaftar di program latihan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">Daftarkan diri Anda terlebih dahulu untuk mulai
                            memantau perkembangan latihan.</p>
                        <a href="<?php echo e(route('general.students.create')); ?>"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-plus"></i> Daftar Sekarang
                        </a>
                    </div>
                <?php elseif($myStudent->progressReports->isEmpty()): ?>
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                        <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                        <p class="font-medium text-gray-600">Belum ada riwayat perkembangan</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm">
                            Hubungi Coach pendamping
                            <span
                                class="font-semibold text-gray-600">(<?php echo e($myStudent->coach->name ?? 'Belum Ditugaskan'); ?>)</span>
                            untuk menginput data perkembangan pertama Anda.
                        </p>
                    </div>
                <?php else: ?>
                    
                    <?php
                        $latestReport = $myStudent->progressReports->last();
                        $isFreetext = $myStudent->progressReports->first()?->report_type === 'freetext';
                    ?>

                    <?php if($isFreetext): ?>
                        
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-green-100 text-green-700 rounded-full border border-green-200">Kelas Belajar Renang</span>
                                <span class="text-xs text-gray-500">Catatan perkembangan dari pelatih</span>
                            </div>
                            <div class="overflow-y-auto max-h-[340px] space-y-2 pr-1">
                                <?php $__currentLoopData = $myStudent->progressReports->sortByDesc('date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white border border-gray-100 rounded-xl p-3 shadow-sm">
                                        <div class="flex items-start gap-2">
                                            <div class="p-1.5 bg-green-50 text-green-600 rounded-lg shrink-0 mt-0.5">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[10px] text-gray-400 font-semibold mb-0.5"><?php echo e($report->date->translatedFormat('d F Y')); ?></div>
                                                <p class="text-sm text-gray-700 leading-relaxed"><?php echo e($report->notes ?? 'Tidak ada catatan.'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                                <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                    <h4 class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                    </h4>
                                    <p class="text-sm text-gray-600 italic">"<?php echo e($latestReport->notes ?? 'Tidak ada catatan.'); ?>"</p>
                                    <div class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput pada: <?php echo e($latestReport->date->translatedFormat('d F Y')); ?></div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-info"></i> Info Latihan Saya
                                    </h4>
                                    <div class="space-y-1.5 text-xs text-gray-600">
                                        <div>Kelas: <span class="font-bold text-gray-800"><?php echo e($myStudent->swimmingClass->name ?? 'Belum Ditentukan'); ?> <?php echo e(isset($myStudent->swimmingClass->category) ? '(' . $myStudent->swimmingClass->category->name . ')' : ''); ?></span></div>
                                        <div>Pelatih: <span class="font-bold text-gray-800"><?php echo e($myStudent->coach->name ?? 'Belum Ditugaskan'); ?></span></div>
                                        <div>Lokasi: <span class="font-bold text-gray-800"><?php echo e($myStudent->location->name ?? 'Belum Dipilih'); ?><?php if($myStudent->secondaryLocation): ?> & <?php echo e($myStudent->secondaryLocation->name); ?><?php endif; ?></span></div>
                                        <div>Sisa Kuota: <span class="font-bold text-blue-600"><?php echo e($myStudent->quota_left); ?> sesi</span></div>
                                        <?php if($myStudent->schedules && $myStudent->schedules->isNotEmpty()): ?>
                                            <div class="pt-1.5 mt-1.5 border-t border-gray-200">
                                                <span class="font-bold text-gray-500 block mb-1">Jadwal Aktif:</span>
                                                <div class="space-y-1">
                                                    <?php $__currentLoopData = $myStudent->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                                            $dayName = $days[$sched->day_of_week] ?? 'Hari Tidak Valid';
                                                            $timeRange = substr($sched->start_time, 0, 5) . ' - ' . substr($sched->end_time, 0, 5);
                                                            $type = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                        ?>
                                                        <div class="bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-blue-700 font-bold"><?php echo e($dayName); ?>, <?php echo e($timeRange); ?></span>
                                                                <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded"><?php echo e($type); ?></span>
                                                            </div>
                                                            <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                <i class="fa-solid fa-location-dot"></i> <?php echo e($sched->location->name ?? 'Lokasi tidak diketahui'); ?>

                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>

                                                <?php
                                                    $pendingReq = $myStudent->scheduleChangeRequests->where('status','pending')->first();
                                                ?>

                                                
                                                <?php if($pendingReq): ?>
                                                    <div class="mt-2 p-3 bg-amber-50/70 border border-amber-200 rounded-xl text-[11px]">
                                                        <div class="flex items-center gap-1.5 text-amber-800 font-bold mb-1">
                                                            <i class="fa-solid fa-clock-rotate-left"></i> Pengajuan Pindah Jadwal (Pending)
                                                        </div>
                                                        <p class="text-slate-600 leading-relaxed mb-1">Menunggu persetujuan Admin untuk pindah ke jadwal berikut:</p>
                                                        <div class="space-y-1">
                                                            <?php $__currentLoopData = $pendingReq->new_schedule_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $newSched = $schedules->firstWhere('id', $newId); ?>
                                                                <?php if($newSched): ?>
                                                                    <?php
                                                                        $nd = $days[$newSched->day_of_week] ?? '?';
                                                                        $ntr = substr($newSched->start_time,0,5).' - '.substr($newSched->end_time,0,5);
                                                                        $nType = $newSched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                                    ?>
                                                                    <div class="bg-white border border-amber-100 rounded p-1.5 flex flex-col gap-0.5">
                                                                        <div class="flex justify-between items-center">
                                                                            <span class="text-amber-700 font-bold"><?php echo e($nd); ?>, <?php echo e($ntr); ?></span>
                                                                            <span class="px-1 text-[9px] bg-amber-50 text-amber-600 rounded"><?php echo e($nType); ?></span>
                                                                        </div>
                                                                        <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                            <i class="fa-solid fa-location-dot"></i> <?php echo e($newSched->location->name ?? '?'); ?>

                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                        <p class="text-[9px] text-slate-400 mt-1.5 font-semibold">Diajukan: <?php echo e($pendingReq->created_at->translatedFormat('d F Y')); ?></p>
                                                    </div>
                                                <?php else: ?>
                                                    
                                                    <div class="mt-3">
                                                        <button type="button" onclick="openScheduleRequestModal()"
                                                            class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                                            <i class="fa-solid fa-calendar-plus"></i> Ajukan Pindah Jadwal
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        
                        <div class="flex flex-col">
                            
                            <div class="relative w-full h-[360px] mb-6">
                                <canvas id="progressChart"></canvas>
                            </div>

                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                                <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                    <h4
                                        class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                    </h4>
                                    <p class="text-sm text-gray-600 italic">
                                        "<?php echo e($latestReport->notes ?? 'Tidak ada catatan pada evaluasi terakhir.'); ?>"
                                    </p>
                                    <div class="text-[10px] text-gray-400 mt-2 font-semibold">
                                        Diinput pada: <?php echo e($latestReport->date->translatedFormat('d F Y')); ?>

                                    </div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                    <h4
                                        class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-info"></i> Info Latihan Saya
                                    </h4>
                                    <div class="space-y-1.5 text-xs text-gray-600">
                                        <div>Kelas: <span class="font-bold text-gray-800"><?php echo e($myStudent->swimmingClass->name ?? 'Belum Ditentukan'); ?> <?php echo e(isset($myStudent->swimmingClass->category) ? '(' . $myStudent->swimmingClass->category->name . ')' : ''); ?></span></div>
                                        <div>Pelatih: <span class="font-bold text-gray-800"><?php echo e($myStudent->coach->name ?? 'Belum Ditugaskan'); ?></span></div>
                                        <div>Lokasi: <span class="font-bold text-gray-800">
                                            <?php echo e($myStudent->location->name ?? 'Belum Dipilih'); ?>

                                            <?php if($myStudent->secondaryLocation): ?> & <?php echo e($myStudent->secondaryLocation->name); ?><?php endif; ?>
                                        </span></div>
                                        <div>Sisa Kuota: <span class="font-bold text-blue-600"><?php echo e($myStudent->quota_left); ?> sesi</span></div>
                                        <?php if($myStudent->schedules && $myStudent->schedules->isNotEmpty()): ?>
                                            <div class="pt-1.5 mt-1.5 border-t border-gray-200">
                                                <span class="font-bold text-gray-500 block mb-1">Jadwal Aktif:</span>
                                                <div class="space-y-1">
                                                    <?php $__currentLoopData = $myStudent->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                                            $dayName = $days[$sched->day_of_week] ?? 'Hari Tidak Valid';
                                                            $timeRange = substr($sched->start_time, 0, 5) . ' - ' . substr($sched->end_time, 0, 5);
                                                            $type = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                        ?>
                                                        <div class="bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5">
                                                            <div class="flex justify-between items-center">
                                                                <span class="text-blue-700 font-bold"><?php echo e($dayName); ?>, <?php echo e($timeRange); ?></span>
                                                                <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded"><?php echo e($type); ?></span>
                                                            </div>
                                                            <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                <i class="fa-solid fa-location-dot"></i> <?php echo e($sched->location->name ?? 'Lokasi tidak diketahui'); ?>

                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>

                                                <?php
                                                    $pendingReq = $myStudent->scheduleChangeRequests->where('status','pending')->first();
                                                ?>

                                                
                                                <?php if($pendingReq): ?>
                                                    <div class="mt-2 p-3 bg-amber-50/70 border border-amber-200 rounded-xl text-[11px]">
                                                        <div class="flex items-center gap-1.5 text-amber-800 font-bold mb-1">
                                                            <i class="fa-solid fa-clock-rotate-left"></i> Pengajuan Pindah Jadwal (Pending)
                                                        </div>
                                                        <p class="text-slate-600 leading-relaxed mb-1">Menunggu persetujuan Admin untuk pindah ke jadwal berikut:</p>
                                                        <div class="space-y-1">
                                                            <?php $__currentLoopData = $pendingReq->new_schedule_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $newSched = $schedules->firstWhere('id', $newId); ?>
                                                                <?php if($newSched): ?>
                                                                    <?php
                                                                        $nd = $days[$newSched->day_of_week] ?? '?';
                                                                        $ntr = substr($newSched->start_time,0,5).' - '.substr($newSched->end_time,0,5);
                                                                        $nType = $newSched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                                                    ?>
                                                                    <div class="bg-white border border-amber-100 rounded p-1.5 flex flex-col gap-0.5">
                                                                        <div class="flex justify-between items-center">
                                                                            <span class="text-amber-700 font-bold"><?php echo e($nd); ?>, <?php echo e($ntr); ?></span>
                                                                            <span class="px-1 text-[9px] bg-amber-50 text-amber-600 rounded"><?php echo e($nType); ?></span>
                                                                        </div>
                                                                        <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                            <i class="fa-solid fa-location-dot"></i> <?php echo e($newSched->location->name ?? '?'); ?>

                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                        <p class="text-[9px] text-slate-400 mt-1.5 font-semibold">Diajukan: <?php echo e($pendingReq->created_at->translatedFormat('d F Y')); ?></p>
                                                    </div>
                                                <?php else: ?>
                                                    
                                                    <div class="mt-3">
                                                        <button type="button" onclick="openScheduleRequestModal()"
                                                            class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-xs font-bold rounded-lg transition-colors">
                                                            <i class="fa-solid fa-calendar-plus"></i> Ajukan Pindah Jadwal
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php if($myStudent && $myStudent->progressReports->isNotEmpty() && $myStudent->progressReports->first()?->report_type === 'structured'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reports = <?php echo json_encode($myStudent->progressReports, 15, 512) ?>;

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

                const ctx = document.getElementById('progressChart').getContext('2d');
                new Chart(ctx, {
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
        </script>
    <?php endif; ?>

    
    <?php if($myStudent): ?>
        <div id="schedule-request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeScheduleRequestModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col" style="max-height: 90vh;">
                
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <i class="fa-solid fa-calendar-plus text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-base">Ajukan Pindah Jadwal & Lokasi</h3>
                            <p class="text-blue-100 text-xs"><?php echo e($myStudent->name); ?></p>
                        </div>
                    </div>
                    <button type="button" onclick="closeScheduleRequestModal()" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                
                <form method="POST" action="<?php echo e(route('general.schedule-requests.store', $myStudent->id)); ?>" class="flex flex-col flex-1 overflow-hidden">
                    <?php echo csrf_field(); ?>
                    <div class="overflow-y-auto flex-1 p-6 space-y-5" style="scrollbar-width: thin;">

                        
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-check text-gray-400"></i> Jadwal Aktif Saat Ini
                            </h4>
                            <div class="space-y-1.5 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-xl p-3">
                                <?php if($myStudent->schedules->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $myStudent->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curSched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $cdDays = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                                            $cdName = $cdDays[$curSched->day_of_week] ?? '?';
                                            $cdTime = substr($curSched->start_time,0,5).' - '.substr($curSched->end_time,0,5);
                                            $cdType = $curSched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                            $cdTag  = $curSched->session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700';
                                        ?>
                                        <div class="flex items-center justify-between py-1">
                                            <span class="font-semibold text-gray-800"><?php echo e($cdName); ?>, <?php echo e($cdTime); ?> — <span class="text-gray-500"><?php echo e($curSched->location->name ?? '?'); ?></span></span>
                                            <span class="text-[9px] px-1.5 py-0.5 rounded <?php echo e($cdTag); ?>"><?php echo e($cdType); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p class="text-gray-400 italic text-center text-xs">Tidak ada jadwal aktif.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-gray-400"></i> Lokasi Latihan Saat Ini
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Utama</p>
                                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-blue-500"></i>
                                        <?php echo e($myStudent->location->name ?? 'Belum diatur'); ?>

                                    </p>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-1">Kedua</p>
                                    <p class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building text-indigo-500"></i>
                                        <?php echo e($myStudent->secondaryLocation->name ?? 'Tidak ada'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar-plus text-blue-500"></i> Pilih Jadwal Baru
                                <span class="text-red-500">*</span>
                            </label>
                            <p class="text-[11px] text-gray-400 mb-2">Centang semua jadwal yang diinginkan (bisa lebih dari satu).</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3 bg-gray-50 border border-gray-200 rounded-xl" style="max-height: 200px; overflow-y: auto; scrollbar-width: thin;">
                                <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $ssDays = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                                        $ssDayName = $ssDays[$sched->day_of_week] ?? '?';
                                        $ssTime = substr($sched->start_time,0,5).' - '.substr($sched->end_time,0,5);
                                        $ssType = $sched->session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                    ?>
                                    <label class="flex items-start gap-2.5 p-2 bg-white border border-gray-100 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50/50 transition-colors">
                                        <input type="checkbox" name="schedule_ids[]" value="<?php echo e($sched->id); ?>"
                                            class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-1">
                                                <span class="text-[11px] font-bold text-gray-800 truncate"><?php echo e($ssDayName); ?>, <?php echo e($ssTime); ?></span>
                                                <span class="text-[8px] px-1 py-0.2 rounded font-semibold shrink-0 <?php echo e($sched->session_type === 'dryland' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'); ?>"><?php echo e($ssType); ?></span>
                                            </div>
                                            <div class="text-[9px] text-gray-500 flex items-center gap-1 mt-0.5 truncate">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span class="truncate"><?php echo e($sched->location->name ?? '?'); ?></span>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($schedules->isEmpty()): ?>
                                    <p class="text-gray-400 italic text-center text-xs py-4 col-span-full">Tidak ada jadwal latihan tersedia untuk kelas Anda saat ini.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div>
                            <label for="schedule-reason" class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-to-square text-gray-400"></i> Alasan Pindah <span class="text-red-500">*</span>
                            </label>
                            <textarea id="schedule-reason" name="reason" rows="3" required
                                placeholder="Tuliskan alasan Anda ingin pindah jadwal/lokasi..."
                                class="w-full text-sm rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 resize-none"></textarea>
                        </div>

                    </div>

                    
                    <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex-shrink-0">
                        <button type="button" onclick="closeScheduleRequestModal()"
                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openScheduleRequestModal() {
                document.getElementById('schedule-request-modal').style.display = 'flex';
            }
            function closeScheduleRequestModal() {
                document.getElementById('schedule-request-modal').style.display = 'none';
            }
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
<?php /**PATH D:\laragon\www\klub-renang\resources\views/general/dashboard.blade.php ENDPATH**/ ?>