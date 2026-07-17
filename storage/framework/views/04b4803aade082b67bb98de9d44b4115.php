<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Umum - Daftar Latihan'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Form Pendaftaran Paket Saya')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                x-data="registrationForm()"
                x-init="init()">

                <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-3">
                    <i class="fa-solid fa-address-card text-blue-600 mr-2"></i>Data Diri & Pilihan Paket
                </h3>

                <form method="POST" action="<?php echo e(route('general.students.store')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'name','value' => 'Nama Lengkap']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'name','value' => 'Nama Lengkap']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'name','class' => 'block mt-1 w-full bg-gray-100','type' => 'text','name' => 'name','value' => old('name', Auth::user()->name),'required' => true,'readonly' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'name','class' => 'block mt-1 w-full bg-gray-100','type' => 'text','name' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name', Auth::user()->name)),'required' => true,'readonly' => true]); ?>
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
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('name'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'birth_date','value' => 'Tanggal Lahir']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'birth_date','value' => 'Tanggal Lahir']); ?>
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
                            <div class="relative mt-1">
                                <input type="date" id="birth_date" name="birth_date" value="<?php echo e(old('birth_date')); ?>"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10 cursor-pointer"
                                    required>
                                <button type="button" onclick="document.getElementById('birth_date').showPicker()"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-indigo-600 transition-colors">
                                    <i class="fa-solid fa-calendar-days text-lg"></i>
                                </button>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('birth_date'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('birth_date')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>

                        <div>
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'gender','value' => 'Jenis Kelamin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'gender','value' => 'Jenis Kelamin']); ?>
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
                            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L" <?php echo e(old('gender') == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="P" <?php echo e(old('gender') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('gender'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('gender')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200" />

                    
                    <div class="mt-4">
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Jenis Kelas Renang']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Jenis Kelas Renang']); ?>
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
                        <div class="grid grid-cols-2 gap-3 mt-2">
                            <?php $__currentLoopData = $classCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label
                                    class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all duration-150"
                                    :class="selectedCategoryId == '<?php echo e($cat->id); ?>'
                                        ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200'
                                        : 'border-gray-200 hover:border-gray-300 bg-white'"
                                    @click="selectCategory('<?php echo e($cat->id); ?>')">
                                    <input type="radio" name="_category" value="<?php echo e($cat->id); ?>"
                                        x-model="selectedCategoryId" class="hidden" />
                                    <div>
                                        <i class="fa-solid <?php echo e($cat->slug === 'belajar' ? 'fa-person-swimming text-blue-500' : 'fa-trophy text-amber-500'); ?> text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800"><?php echo e($cat->name); ?></p>
                                        <p class="text-[11px] text-gray-400">
                                            <?php echo e($cat->slug === 'belajar' ? 'Untuk pemula segala usia' : 'Program atlet prestasi'); ?>

                                        </p>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="mt-5" x-show="selectedCategoryId" x-transition>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'swimming_class_id','value' => 'Pilih Tingkat Kelas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'swimming_class_id','value' => 'Pilih Tingkat Kelas']); ?>
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
                        <select id="swimming_class_id" name="swimming_class_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedClassId"
                            @change="onClassChange()"
                            required>
                            <option value="">-- Pilih Tingkat Kelas --</option>
                            <template x-for="cls in filteredClasses" :key="cls.id">
                                <option :value="cls.id" x-text="cls.name + ' (' + cls.age_min + (cls.age_max ? '-' + cls.age_max : '+') + ' thn)'"></option>
                            </template>
                        </select>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('swimming_class_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('swimming_class_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="mt-5" x-show="selectedClassId" x-transition>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'package_id','value' => 'Pilih Paket Kursus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'package_id','value' => 'Pilih Paket Kursus']); ?>
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
                        <select id="package_id" name="package_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            x-model="selectedPackageId"
                            @change="onPackageChange()"
                            required>
                            <option value="">-- Pilih Paket Latihan --</option>
                            <template x-for="pkg in filteredPackages" :key="pkg.id">
                                <option :value="pkg.id" x-text="pkg.name + ' — ' + (selectedLocationId ? formatPrice(getPackagePrice(pkg)) : '(Harga menyesuaikan kolam)') + ' (' + pkg.sessions + 'x Pertemuan)'"></option>
                            </template>
                        </select>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('package_id'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('package_id')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="mt-5" x-show="filteredSchedules.length > 0" x-transition>
                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Pilih Jadwal Latihan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Pilih Jadwal Latihan']); ?>
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
                        <p class="text-xs text-gray-400 mb-2">Centang jadwal latihan yang diinginkan. Batas slot jadwal disesuaikan dengan jenis paket latihan.</p>

                        <div class="mb-3 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs" x-show="selectedCategoryId && allCategories.find(c => c.id == selectedCategoryId)?.slug === 'prestasi'">
                            <i class="fa-solid fa-lightbulb mr-1 text-amber-500"></i>
                            <strong>Petunjuk Sesi Latihan:</strong> Kelas Prestasi memiliki sesi <strong>Renang</strong> dan <strong>Dryland</strong>. Silakan centang kedua sesi latihan tersebut di bawah sesuai jadwal yang tersedia.
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                            <template x-for="sched in filteredSchedules" :key="sched.id">
                                <label class="flex items-start gap-3 p-3 border rounded-xl cursor-pointer transition-all duration-100 text-sm"
                                    :class="selectedScheduleIds.includes(String(sched.id)) ? 'border-blue-400 bg-blue-50/50' : 
                                        (isScheduleDisabled(sched) ? 'border-gray-100 bg-gray-50/30 opacity-60 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')">
                                    <input type="checkbox" name="schedule_ids[]" :value="sched.id"
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-1"
                                        @change="toggleSchedule(sched.id)"
                                        :checked="selectedScheduleIds.includes(String(sched.id))"
                                        :disabled="isScheduleDisabled(sched)" />
                                    <div class="flex-1">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="font-bold text-gray-800" x-text="getDayName(sched.day_of_week) + ', ' + formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                            <span class="text-[9px] px-2 py-0.5 rounded-full font-bold uppercase"
                                                :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                        </div>
                                        <span class="block text-xs text-gray-500 mt-1"><i class="fa-solid fa-map-pin text-gray-400 mr-1"></i><span x-text="sched.location?.name || ''"></span></span>
                                        <span class="block text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-user-tie text-gray-400 mr-1"></i>Pelatih: <span class="font-semibold text-slate-700" x-text="sched.coach_name || 'Belum Ditentukan'"></span></span>
                                        <span class="block text-[10px] font-bold mt-1"
                                            :class="(sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? 'text-red-500' : 'text-blue-600'"
                                            x-text="(sched.current_enrolled_count || 0) + '/' + getScheduleCapacityLimit(sched) + ' Terisi' + ((sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? ' (Penuh)' : '')"></span>
                                    </div>
                                </label>
                            </template>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('schedule_ids'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('schedule_ids')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        <small class="text-gray-400 mt-1 block">*Maksimal jadwal latihan untuk paket ini adalah <span class="font-bold text-slate-600" x-text="maxSlots"></span> sesi per minggu.</small>
                    </div>

                    <input type="hidden" name="location_id" :value="selectedLocationId">
                    <input type="hidden" name="secondary_location_id" :value="secondaryLocationId">

                    <div class="mt-4 bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg text-xs"
                        x-show="filteredSchedules.length === 0 && selectedClassId" x-transition>
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        <strong>Tidak Ada Jadwal:</strong> Belum ada jadwal latihan yang tersedia untuk kelas terpilih.
                    </div>

                    
                    <input type="hidden" name="coach_id" :value="selectedCoachId">

                    
                    <div class="mt-6" x-show="selectedPackageId" x-transition>
                        <div class="bg-gradient-to-br from-slate-50 to-blue-50 border border-blue-100 rounded-xl p-5 shadow-sm">
                            <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-calculator text-blue-500"></i> Ringkasan Pembayaran
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Paket Kursus</span>
                                    <span class="font-semibold text-gray-800" x-text="formatPrice(calculatedPackagePrice)"></span>
                                </div>
                                 <div class="flex justify-between" x-show="showRegistrationFee">
                                    <span class="text-gray-500">Biaya Pendaftaran <span class="text-[10px]">(sekali seumur hidup)</span></span>
                                    <span class="font-semibold text-gray-800">Rp 30.000</span>
                                </div>
                                <hr class="border-blue-200 !my-3" />
                                <div class="flex justify-between text-base">
                                    <span class="font-bold text-gray-800">Total Bayar</span>
                                    <span class="font-extrabold text-blue-600 text-lg" x-text="formatPrice(totalAmount)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end mt-8 border-t pt-4">
                        <p class="text-xs text-red-500 mb-2 font-medium" x-show="selectedPackageId && selectedScheduleIds.length === 0">
                            *Anda wajib memilih minimal satu jadwal latihan untuk melanjutkan pendaftaran.
                        </p>
                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'w-full md:w-auto justify-center','xBind:disabled' => '!selectedPackageId || selectedScheduleIds.length === 0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full md:w-auto justify-center','x-bind:disabled' => '!selectedPackageId || selectedScheduleIds.length === 0']); ?>
                            <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Pendaftaran
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function registrationForm() {
            return {
                // Data from server
                allCategories: <?php echo json_encode($classCategories, 15, 512) ?>,
                allPackages: <?php echo json_encode($packages, 15, 512) ?>,
                allSchedules: <?php echo json_encode($schedules, 15, 512) ?>,

                // Selected values
                selectedCategoryId: '<?php echo e(old('_category', '')); ?>',
                selectedClassId: '<?php echo e(old('swimming_class_id', '')); ?>',
                selectedPackageId: '<?php echo e(old('package_id', '')); ?>',
                selectedScheduleIds: [],

                init() {
                    <?php if(old('schedule_ids')): ?>
                        this.selectedScheduleIds = <?php echo json_encode(old('schedule_ids'), 15, 512) ?>.map(String);
                    <?php endif; ?>
                },

                get selectedCoachId() {
                    if (this.selectedScheduleIds.length === 0) return '';
                    const firstSchedId = this.selectedScheduleIds[0];
                    const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                    return sched ? (sched.coach_id || '') : '';
                },

                // Computed
                get selectedLocationId() {
                    if (this.selectedScheduleIds.length === 0) return '';
                    const firstSchedId = this.selectedScheduleIds[0];
                    const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                    return sched ? String(sched.location_id) : '';
                },

                get secondaryLocationId() {
                    const loc1 = this.selectedLocationId;
                    if (!loc1) return '';
                    for (let id of this.selectedScheduleIds) {
                        const sched = this.allSchedules.find(s => String(s.id) == id);
                        if (sched && String(sched.location_id) !== loc1) {
                            return String(sched.location_id);
                        }
                    }
                    return '';
                },

                get isPrestasi() {
                    if (!this.selectedCategoryId) return false;
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat && cat.slug === 'prestasi';
                },

                get maxSlots() {
                    if (this.isPrestasi) return 999;
                    if (!this.selectedPackageId) return 1;
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    if (!pkg) return 1;
                    const sessions = pkg.sessions || 4;
                    if (sessions <= 4) return 1;
                    if (sessions <= 8) return 2;
                    if (sessions <= 12) return 3;
                    return 4;
                },

                get availableCoaches() {
                    const uniqueCoaches = [];
                    const seen = new Set();
                    
                    this.selectedScheduleIds.forEach(id => {
                        const sched = this.allSchedules.find(s => String(s.id) == id);
                        if (sched && sched.coach_id && !seen.has(sched.coach_id)) {
                            seen.add(sched.coach_id);
                            uniqueCoaches.push({
                                id: sched.coach_id,
                                name: sched.coach_name || 'Belum Ditentukan'
                            });
                        }
                    });
                    
                    return uniqueCoaches;
                },

                get filteredClasses() {
                    if (!this.selectedCategoryId) return [];
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat ? (cat.swimming_classes || []) : [];
                },

                get filteredPackages() {
                    if (!this.selectedClassId) return [];
                    return this.allPackages.filter(p => p.swimming_class_id == this.selectedClassId);
                },

                get showRegistrationFee() {
                    if (!this.selectedCategoryId) return false;
                    const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                    return cat && cat.slug === 'belajar';
                },

                get calculatedPackagePrice() {
                    if (!this.selectedPackageId) return 0;
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    return this.getPackagePrice(pkg);
                },

                get totalAmount() {
                    let total = this.calculatedPackagePrice;
                    if (this.showRegistrationFee) total += 30000;
                    return total;
                },

                get filteredSchedules() {
                    if (!this.selectedClassId) return [];
                    return this.allSchedules.filter(s => s.swimming_class_id == this.selectedClassId);
                },

                // Methods
                isScheduleDisabled(sched) {
                    const limit = this.getScheduleCapacityLimit(sched);
                    const isFull = (sched.current_enrolled_count || 0) >= limit;
                    const isChecked = this.selectedScheduleIds.includes(String(sched.id));
                    if (isFull && !isChecked) return true;
                    if (this.selectedScheduleIds.length >= this.maxSlots && !isChecked) return true;
                    return false;
                },

                toggleSchedule(schedId) {
                    const id = String(schedId);
                    const idx = this.selectedScheduleIds.indexOf(id);
                    if (idx > -1) {
                        this.selectedScheduleIds.splice(idx, 1);
                    } else {
                        if (this.selectedScheduleIds.length < this.maxSlots) {
                            this.selectedScheduleIds.push(id);
                        }
                    }
                    this.autoSelectCoach();
                },

                autoSelectCoach() {
                    this.$nextTick(() => {
                        const coaches = this.availableCoaches;
                        if (coaches.length === 1) {
                            this.selectedCoachId = String(coaches[0].id);
                        } else if (coaches.length === 0 || !coaches.find(c => String(c.id) == this.selectedCoachId)) {
                            this.selectedCoachId = '';
                        }
                    });
                },

                getScheduleCapacityLimit(sched) {
                    if (this.selectedCategoryId) {
                        const cat = this.allCategories.find(c => c.id == this.selectedCategoryId);
                        if (cat && cat.slug === 'prestasi') {
                            return 15;
                        }
                    }
                    if (!this.selectedPackageId) {
                        return 4;
                    }
                    const pkg = this.allPackages.find(p => p.id == this.selectedPackageId);
                    if (!pkg) return 4;
                    
                    const type = pkg.package_type || 'regular';
                    const name = pkg.name || '';
                    
                    if (type === 'private' || (type === 'single_session' && name.toLowerCase().includes('private'))) {
                        return 1;
                    }
                    return 4;
                },

                selectCategory(catId) {
                    this.selectedCategoryId = catId;
                    this.selectedClassId = '';
                    this.selectedPackageId = '';
                    this.selectedCoachId = '';
                    this.selectedScheduleIds = [];
                },

                onClassChange() {
                    this.selectedPackageId = '';
                    this.selectedCoachId = '';
                    this.selectedScheduleIds = [];
                },

                onPackageChange() {
                    this.selectedCoachId = '';
                    if (this.selectedScheduleIds.length > this.maxSlots) {
                        this.selectedScheduleIds = this.selectedScheduleIds.slice(0, this.maxSlots);
                    }
                },

                getPackagePrice(pkg) {
                    if (!pkg) return 0;
                    if (pkg.is_location_based && this.selectedLocationId) {
                        const lp = (pkg.location_prices || []).find(lp => lp.location_id == this.selectedLocationId);
                        return lp ? lp.price : 0;
                    }
                    return pkg.price || 0;
                },

                formatPrice(val) {
                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                },

                getDayName(dayOfWeek) {
                    const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    return days[dayOfWeek] || '-';
                },

                formatTime(timeStr) {
                    if (!timeStr) return '';
                    return timeStr.substring(0, 5);
                },
            };
        }
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
<?php endif; ?>
<?php /**PATH D:\laragon\www\klub-renang\resources\views/general/students/create.blade.php ENDPATH**/ ?>