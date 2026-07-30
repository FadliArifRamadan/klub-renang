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

            
            <div class="bg-gradient-to-r from-[#101828] via-[#1E1E2D] to-[#101828] overflow-hidden rounded-2xl p-6 md:p-8 mb-8 border border-[#D3AF37]/30 shadow-xl relative z-10">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#D3AF37]/10 rounded-full blur-2xl pointer-events-none"></div>
                <h1 class="text-[#D3AF37] text-2xl md:text-3xl font-extrabold tracking-tight mb-2">
                    Halo, <?php echo e(Auth::user()->name); ?>!
                </h1>
                <p class="text-slate-300 text-sm max-w-3xl leading-relaxed font-normal">
                    Selamat datang di portal anggota Black Diamond. Pantau perkembangan latihan Anda dan lihat catatan terbaru dari pelatih di sini.
                </p>
            </div>

            
            <?php if($myStudent && isset($activeLeaves) && $activeLeaves->isNotEmpty()): ?>
                <?php
                    $myStudentLeaves = $activeLeaves->filter(function($leave) use ($myStudent) {
                        if ($leave->coach_id != $myStudent->coach_id) {
                            return false;
                        }
                        $dayOfWeek = ($leave->leave_date->dayOfWeek === 0) ? 6 : ($leave->leave_date->dayOfWeek - 1);
                        return $myStudent->schedules->contains('day_of_week', $dayOfWeek);
                    });
                ?>
                <?php if($myStudentLeaves->isNotEmpty()): ?>
                    <div class="space-y-3 mb-8">
                        <?php $__currentLoopData = $myStudentLeaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex p-4 text-sm rounded-xl bg-sky-50 border border-sky-200 text-sky-800 shadow-sm" role="alert">
                                <div style="margin-right: 16px; margin-top: 2px; flex-shrink: 0;" class="text-sky-600">
                                    <i class="fa-solid fa-circle-info text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-bold">Informasi Latihan:</span>
                                    Pelatih Anda <span class="font-bold text-slate-800"><?php echo e($leave->coach->name); ?></span> berhalangan melatih pada tanggal <span class="font-semibold"><?php echo e($leave->leave_date->translatedFormat('d F Y')); ?></span> (<?php echo e($leave->leave_date->translatedFormat('l')); ?>).
                                    <?php if($leave->substitute_coach_id): ?>
                                        <div class="mt-1">
                                            Sesi latihan akan dipimpin oleh pelatih pengganti: <span class="font-bold text-slate-800 underline"><?php echo e($leave->substituteCoach->name); ?></span>.
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-1 font-bold text-amber-700">
                                            Latihan untuk jadwal ini diliburkan (tidak ada pelatih pengganti). Kuota sesi Anda tidak akan dikurangi.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(isset($rescheduleQueues) && $rescheduleQueues->isNotEmpty()): ?>
                <div class="space-y-3 mb-8">
                    <?php $__currentLoopData = $rescheduleQueues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($rq->status === 'pending'): ?>
                            <div class="flex items-start p-4 text-sm rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-200 shadow-md">
                                <div class="p-2.5 bg-amber-500/20 text-amber-400 rounded-xl mr-3.5 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-calendar-minus text-lg"></i>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-amber-400 text-sm">
                                            <i class="fa-solid fa-info-circle mr-1"></i> Informasi Sesi Latihan Diliburkan
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                            Sesi Diliburkan
                                        </span>
                                    </div>
                                    <p class="mt-1 text-slate-300 text-xs leading-relaxed">
                                        Sesi latihan Anda pada hari <strong class="text-amber-300"><?php echo e(\Carbon\Carbon::parse($rq->original_date)->locale('id')->translatedFormat('l, d F Y')); ?></strong> (<?php echo e($rq->schedule->swimmingClass->name ?? ''); ?> — <?php echo e($rq->schedule->location->name ?? ''); ?>) <strong class="text-amber-300">diliburkan</strong> karena pelatih <strong class="text-white"><?php echo e($rq->coachLeave->coach->name ?? 'Pelatih'); ?></strong> berhalangan.
                                    </p>
                                    <div class="mt-2 p-2.5 rounded-xl bg-slate-900/60 border border-slate-700/50 text-[11px] text-slate-300 flex items-center gap-2">
                                        <i class="fa-solid fa-hourglass-half text-amber-400"></i>
                                        <span>Status: <strong>Menunggu Penjadwalan Ulang (Reschedule) oleh Admin</strong> — Kuota sesi Anda tidak dipotong.</span>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($rq->status === 'rescheduled'): ?>
                            <div class="flex items-start p-4 text-sm rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-200 shadow-md">
                                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-xl mr-3.5 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-calendar-check text-lg"></i>
                                </div>
                                <div class="w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-emerald-400 text-sm">
                                            <i class="fa-solid fa-circle-check mr-1"></i> Jadwal Pengganti (Reschedule) Ditetapkan!
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                            Reschedule Ditetapkan
                                        </span>
                                    </div>
                                    <p class="mt-1 text-slate-300 text-xs leading-relaxed">
                                        Sesi tanggal <strong class="text-slate-400 line-through"><?php echo e(\Carbon\Carbon::parse($rq->original_date)->locale('id')->translatedFormat('d F Y')); ?></strong> yang sempat diliburkan telah dijadwalkan ulang oleh Admin ke:
                                    </p>
                                    <div class="mt-2 p-2.5 rounded-xl bg-slate-900/60 border border-emerald-500/30 text-xs text-emerald-300 flex flex-wrap items-center gap-x-4 gap-y-1">
                                        <div><i class="fa-solid fa-calendar-day mr-1 text-emerald-400"></i> <?php echo e(\Carbon\Carbon::parse($rq->rescheduled_date)->locale('id')->translatedFormat('l, d F Y')); ?></div>
                                        <div><i class="fa-solid fa-clock mr-1 text-emerald-400"></i> <?php echo e($rq->rescheduledSchedule->time_range ?? ''); ?></div>
                                        <div><i class="fa-solid fa-location-dot mr-1 text-emerald-400"></i> <?php echo e($rq->rescheduledSchedule->location->name ?? ''); ?></div>
                                        <div><i class="fa-solid fa-user-tie mr-1 text-emerald-400"></i> Coach: <?php echo e($rq->rescheduledSchedule->coach->name ?? 'Pelatih'); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            
            <?php if(isset($expiredStudents) && $expiredStudents->isNotEmpty()): ?>
                <div class="bg-amber-500/10 dark:bg-amber-900/20 border border-amber-300/50 dark:border-amber-800/50 rounded-xl p-5 mb-8 shadow-sm" x-data="{ showNotif: true }" x-show="showNotif" x-transition>
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3 w-full">
                            <div class="p-2 bg-amber-500/20 text-amber-600 dark:text-[#D3AF37] rounded-lg mt-0.5 shrink-0">
                                <i class="fa-solid fa-bell text-lg"></i>
                            </div>
                            <div class="w-full">
                                <h4 class="font-bold text-white text-sm flex items-center gap-1.5">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
                                    Sesi Latihan Anda Telah Habis!
                                </h4>
                                <p class="text-xs text-white/90 dark:text-slate-200 mt-1 leading-relaxed">
                                    Seluruh kuota sesi latihan Anda telah terpakai. Silakan lakukan daftar ulang paket latihan di bawah ini.
                                </p>
                                <div class="mt-3 space-y-2 max-w-2xl">
                                    <?php $__currentLoopData = $expiredStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expStudent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-wrap items-center justify-between gap-3 bg-white dark:bg-slate-800/80 border border-amber-200/60 dark:border-slate-700 rounded-lg px-4 py-2.5 shadow-sm">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <i class="fa-solid fa-user text-amber-500"></i>
                                                <span class="font-bold text-sm text-slate-800 dark:text-white"><?php echo e($expStudent->name); ?></span>
                                                <span class="text-xs text-slate-400">—</span>
                                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300"><?php echo e($expStudent->package->name ?? 'Paket'); ?></span>
                                                <span class="bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-red-200 dark:border-red-800/50">
                                                    Sesi Habis
                                                </span>
                                            </div>
                                            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'renew-student-<?php echo e($expStudent->id); ?>')"
                                                class="px-3.5 py-1.5 bg-[#D3AF37] hover:bg-[#B89426] text-[#101828] text-xs font-extrabold rounded-lg shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                                                <i class="fa-solid fa-rotate-right text-[10px]"></i> Daftar Ulang
                                            </button>
                                        </div>

                                        
                                        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'renew-student-'.e($expStudent->id).'','maxWidth' => '2xl','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'renew-student-'.e($expStudent->id).'','maxWidth' => '2xl','focusable' => true]); ?>
                                            <form method="POST" action="<?php echo e(route('general.students.renew', $expStudent->id)); ?>" enctype="multipart/form-data" class="p-6 text-left"
                                                x-data="{
                                                    allPackages: <?php echo e($packages->toJson()); ?>,
                                                    allSchedules: <?php echo e($schedules->toJson()); ?>,
                                                    classId: '<?php echo e($expStudent->swimming_class_id); ?>',
                                                    packageId: '<?php echo e($expStudent->package_id); ?>',
                                                    coachGenderPref: '<?php echo e($expStudent->coach_gender_preference ?? 'any'); ?>',
                                                    shouldPayRegFee: <?php echo e($expStudent->shouldPayRegistrationFee() ? 'true' : 'false'); ?>,
                                                    classCategorySlug: '<?php echo e($expStudent->swimmingClass->category->slug ?? ''); ?>',
                                                    selectedScheduleIds: [
                                                         <?php if(!$expStudent->schedules->isEmpty()): ?>
                                                             <?php $__currentLoopData = $expStudent->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 '<?php echo e($sched->id); ?>'<?php echo e($index < count($expStudent->schedules) - 1 ? ',' : ''); ?>

                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         <?php endif; ?>
                                                     ],

                                                     get locationId() {
                                                         if (this.selectedScheduleIds.length === 0) return '';
                                                         const firstSchedId = this.selectedScheduleIds[0];
                                                         const sched = this.allSchedules.find(s => String(s.id) == firstSchedId);
                                                         return sched ? String(sched.location_id) : '';
                                                     },
                                                     get secondaryLocationId() {
                                                         const loc1 = this.locationId;
                                                         if (!loc1) return '';
                                                         for (let id of this.selectedScheduleIds) {
                                                             const sched = this.allSchedules.find(s => String(s.id) == id);
                                                             if (sched && String(sched.location_id) !== loc1) {
                                                                 return String(sched.location_id);
                                                             }
                                                         }
                                                         return '';
                                                     },
                                                     get maxSlots() {
                                                          if (this.classCategorySlug === 'prestasi') return 999;
                                                          if (!this.packageId) return 1;
                                                          const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                          if (!pkg) return 1;
                                                          if (pkg.package_type === 'single_session') return 1;
                                                          const sessions = pkg.sessions || 4;
                                                          if (sessions <= 4) return 1;
                                                          if (sessions <= 8) return 2;
                                                          if (sessions <= 12) return 3;
                                                          return 4;
                                                      },
                                                     get filteredPackages() {
                                                         if (!this.classId) return [];
                                                         return this.allPackages.filter(p => p.swimming_class_id == this.classId);
                                                     },
                                                     get calculatedPrice() {
                                                         const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                         if (!pkg) return 0;
                                                         if (pkg.is_location_based && this.locationId) {
                                                             const lp = (pkg.location_prices || []).find(l => l.location_id == this.locationId);
                                                             return lp ? lp.price : 0;
                                                         }
                                                         return pkg.price || 0;
                                                     },
                                                     get totalAmount() {
                                                         let total = this.calculatedPrice;
                                                         if (this.shouldPayRegFee) total += 30000;
                                                         return total;
                                                     },
                                                     get filteredSchedules() {
                                                          if (!this.classId) return [];
                                                          let list = this.allSchedules.filter(s => s.swimming_class_id == this.classId);

                                                          if (this.coachGenderPref && this.coachGenderPref !== 'any') {
                                                              list = list.filter(s => {
                                                                  const gender = s.coach?.gender || s.coach_gender;
                                                                  return gender === this.coachGenderPref;
                                                              });
                                                          }

                                                          if (this.packageId) {
                                                              const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                              if (pkg) {
                                                                  const pkgName = (pkg.name || '').toLowerCase();
                                                                  const pkgType = (pkg.package_type || '').toLowerCase();
                                                                  const isPrivate = pkgType.includes('private') || pkgName.includes('private');

                                                                  if (!isPrivate) {
                                                                      list = list.filter(s => {
                                                                          const locName = (s.location?.name || '').toLowerCase();
                                                                          return !locName.includes('home visit') && s.location_id != 6;
                                                                      });
                                                                  }
                                                              }
                                                          } else {
                                                              list = list.filter(s => {
                                                                  const locName = (s.location?.name || '').toLowerCase();
                                                                  return !locName.includes('home visit') && s.location_id != 6;
                                                              });
                                                          }

                                                          return list;
                                                      },
                                                      isScheduleDisabled(sched) {
                                                           const limit = this.getScheduleCapacityLimit(sched);
                                                           const isFull = (sched.current_enrolled_count || 0) >= limit;
                                                           const isChecked = this.selectedScheduleIds.includes(String(sched.id));
                                                           if (isFull && !isChecked) return true;
                                                           if (this.selectedScheduleIds.length >= this.maxSlots && !isChecked) return true;
                                                           if (!isChecked && this.isSchedulePriceMismatch(sched)) return true;
                                                           return false;
                                                       },
                                                       getPackageLocationPrice(pkg, locationId) {
                                                           if (!pkg || !locationId) return 0;
                                                           if (pkg.is_location_based) {
                                                               const lp = (pkg.location_prices || []).find(l => l.location_id == locationId);
                                                               return lp ? Number(lp.price) : 0;
                                                           }
                                                           return Number(pkg.price || 0);
                                                       },
                                                       isSchedulePriceMismatch(sched) {
                                                           if (!this.selectedScheduleIds.length || !sched) return false;
                                                           const pkgId = this.packageId;
                                                           if (!pkgId) return false;
                                                           const pkg = this.allPackages.find(p => p.id == pkgId);
                                                           if (!pkg || !(pkg.sessions == 8 || (pkg.name || '').toLowerCase().includes('8 sesi'))) return false;

                                                           const firstSchedId = this.selectedScheduleIds[0];
                                                           const firstSched = this.allSchedules.find(s => String(s.id) === String(firstSchedId));
                                                           if (!firstSched) return false;

                                                           const firstPrice = this.getPackageLocationPrice(pkg, firstSched.location_id);
                                                           const targetPrice = this.getPackageLocationPrice(pkg, sched.location_id);
                                                           return firstPrice !== targetPrice;
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
                                                      },
                                                      onPackageChange() {
                                                          if (this.packageId) {
                                                              const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                              if (pkg) {
                                                                  const pkgName = (pkg.name || '').toLowerCase();
                                                                  const pkgType = (pkg.package_type || '').toLowerCase();
                                                                  const isPrivate = pkgType.includes('private') || pkgName.includes('private');

                                                                  if (!isPrivate) {
                                                                      this.selectedScheduleIds = this.selectedScheduleIds.filter(id => {
                                                                          const sched = this.allSchedules.find(s => String(s.id) === String(id));
                                                                          if (!sched) return false;
                                                                          const locName = (sched.location?.name || '').toLowerCase();
                                                                          return !locName.includes('home visit') && sched.location_id != 6;
                                                                      });
                                                                  }
                                                              }
                                                          }
                                                          if (this.selectedScheduleIds.length > this.maxSlots) {
                                                              this.selectedScheduleIds = this.selectedScheduleIds.slice(0, this.maxSlots);
                                                          }
                                                      },
                                                     getScheduleCapacityLimit(sched) {
                                                         if (this.classCategorySlug === 'prestasi') {
                                                             return 15;
                                                         }
                                                         if (!this.packageId) {
                                                             return 4;
                                                         }
                                                         const pkg = this.allPackages.find(p => p.id == this.packageId);
                                                         if (!pkg) return 4;
                                                         
                                                         const type = pkg.package_type || 'regular';
                                                         const name = pkg.name || '';
                                                         
                                                         if (type === 'private' || (type === 'single_session' && name.toLowerCase().includes('private'))) {
                                                             return 1;
                                                         }
                                                         return 4;
                                                     },
                                                    formatPrice(val) {
                                                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                                                    },
                                                    getDayName(d) {
                                                        return ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'][d] || '-';
                                                    },
                                                    formatTime(t) { return t ? t.substring(0,5) : ''; }
                                                }">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="swimming_class_id" value="<?php echo e($expStudent->swimming_class_id); ?>">

                                                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2 border-b dark:border-slate-700 pb-3">
                                                    <i class="fa-solid fa-rotate-right text-[#D3AF37]"></i>
                                                    Daftar Ulang Paket Latihan - <?php echo e($expStudent->name); ?>

                                                </h3>

                                                <!-- Nama Lengkap Murid -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'name-gen-'.e($expStudent->id).'','value' => 'Nama Lengkap Murid *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'name-gen-'.e($expStudent->id).'','value' => 'Nama Lengkap Murid *']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'name-gen-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'text','name' => 'name','value' => ''.e($expStudent->name).'','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'name-gen-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'text','name' => 'name','value' => ''.e($expStudent->name).'','required' => true]); ?>
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

                                                <!-- Tanggal Lahir & Jenis Kelamin -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'birth_date-gen-'.e($expStudent->id).'','value' => 'Tanggal Lahir *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'birth_date-gen-'.e($expStudent->id).'','value' => 'Tanggal Lahir *']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'birth_date-gen-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'date','name' => 'birth_date','value' => ''.e($expStudent->birth_date?->format('Y-m-d')).'','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'birth_date-gen-'.e($expStudent->id).'','class' => 'block mt-1 w-full text-sm','type' => 'date','name' => 'birth_date','value' => ''.e($expStudent->birth_date?->format('Y-m-d')).'','required' => true]); ?>
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

                                                    <div>
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'gender-gen-'.e($expStudent->id).'','value' => 'Jenis Kelamin *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'gender-gen-'.e($expStudent->id).'','value' => 'Jenis Kelamin *']); ?>
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
                                                        <select id="gender-gen-<?php echo e($expStudent->id); ?>" name="gender" required
                                                            class="block mt-1 w-full text-sm rounded-lg border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white shadow-sm focus:border-[#D3AF37]">
                                                            <option value="L" <?php echo e($expStudent->gender == 'L' || $expStudent->gender == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                                                            <option value="P" <?php echo e($expStudent->gender == 'P' || $expStudent->gender == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Preferensi Gender Pelatih -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Preferensi Gender Pelatih']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Preferensi Gender Pelatih']); ?>
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
                                                    <div class="grid grid-cols-3 gap-2.5 mt-1.5">
                                                        <label class="flex items-center justify-center gap-1.5 p-2 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                                            :class="coachGenderPref === 'any' ? 'border-[#D3AF37] bg-[#D3AF37]/10 text-[#D3AF37] font-bold ring-1 ring-[#D3AF37]/50' : 'border-gray-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-gray-300'">
                                                            <input type="radio" name="coach_gender_preference" value="any" x-model="coachGenderPref" class="hidden" />
                                                            <i class="fa-solid fa-users text-[#D3AF37]"></i>
                                                            <span>Bebas (Siapa Saja)</span>
                                                        </label>
                                                        <label class="flex items-center justify-center gap-1.5 p-2 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                                            :class="coachGenderPref === 'L' ? 'border-[#D3AF37] bg-[#D3AF37]/10 text-[#D3AF37] font-bold ring-1 ring-[#D3AF37]/50' : 'border-gray-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-gray-300'">
                                                            <input type="radio" name="coach_gender_preference" value="L" x-model="coachGenderPref" class="hidden" />
                                                            <i class="fa-solid fa-mars text-cyan-500"></i>
                                                            <span>Pelatih Laki-laki</span>
                                                        </label>
                                                        <label class="flex items-center justify-center gap-1.5 p-2 border rounded-xl cursor-pointer transition text-xs font-semibold"
                                                            :class="coachGenderPref === 'P' ? 'border-[#D3AF37] bg-[#D3AF37]/10 text-[#D3AF37] font-bold ring-1 ring-[#D3AF37]/50' : 'border-gray-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-gray-300'">
                                                            <input type="radio" name="coach_gender_preference" value="P" x-model="coachGenderPref" class="hidden" />
                                                            <i class="fa-solid fa-venus text-pink-500"></i>
                                                            <span>Pelatih Perempuan</span>
                                                        </label>
                                                    </div>
                                                    <!-- Peringatan Jika Tidak Ada Pelatih Tersedia untuk Gender yang Dipilih -->
                                                    <div x-show="coachGenderPref !== 'any' && classId && filteredSchedules.length === 0" x-transition
                                                         class="mt-2.5 p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-600 dark:text-amber-400 text-xs flex items-center gap-2.5">
                                                         <i class="fa-solid fa-triangle-exclamation text-amber-500 text-base shrink-0"></i>
                                                         <div>
                                                             <p class="font-bold">Tidak ada pelatih <span x-text="coachGenderPref === 'L' ? 'Laki-laki' : 'Perempuan'"></span> yang tersedia untuk jadwal kelas ini.</p>
                                                             <p class="text-[11px] opacity-90 mt-0.5">Silakan ubah preferensi ke "Bebas (Siapa Saja)" untuk melihat jadwal pelatih lain.</p>
                                                         </div>
                                                     </div>
                                                </div>

                                                <!-- Nomor HP / WA -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Nomor HP / WhatsApp']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Nomor HP / WhatsApp']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['class' => 'block mt-1 w-full bg-slate-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 cursor-not-allowed text-sm','type' => 'text','value' => ''.e(Auth::user()->phone).'','readonly' => true,'disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'block mt-1 w-full bg-slate-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 cursor-not-allowed text-sm','type' => 'text','value' => ''.e(Auth::user()->phone).'','readonly' => true,'disabled' => true]); ?>
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

                                                <!-- Upload Berkas khusus Prestasi -->
                                                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3" x-show="classCategorySlug === 'prestasi'" x-transition>
                                                    <div class="bg-amber-500/10 border border-amber-500/30 p-3 rounded-xl">
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Perbarui Foto KK (Opsional)','class' => 'text-amber-500 dark:text-amber-400 font-bold text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Perbarui Foto KK (Opsional)','class' => 'text-amber-500 dark:text-amber-400 font-bold text-xs']); ?>
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
                                                        <input type="file" name="family_card_image" accept="image/*,.pdf"
                                                            class="block w-full text-xs text-slate-600 dark:text-slate-300 mt-1 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer" />
                                                    </div>

                                                    <div class="bg-amber-500/10 border border-amber-500/30 p-3 rounded-xl">
                                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['value' => 'Perbarui Foto Murid (Opsional)','class' => 'text-amber-500 dark:text-amber-400 font-bold text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'Perbarui Foto Murid (Opsional)','class' => 'text-amber-500 dark:text-amber-400 font-bold text-xs']); ?>
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
                                                        <input type="file" name="student_image" accept="image/*"
                                                            class="block w-full text-xs text-slate-600 dark:text-slate-300 mt-1 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer" />
                                                    </div>
                                                </div>

                                                <?php if($expStudent->swimmingClass): ?>
                                                    <div class="mb-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 rounded-lg px-3 py-2 text-xs text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                                        <i class="fa-solid fa-layer-group"></i>
                                                        <span>Kelas: <strong><?php echo e($expStudent->swimmingClass->name); ?></strong></span>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Paket Kursus (filtered by class) -->
                                                <div class="mb-4">
                                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'package-'.e($expStudent->id).'','value' => 'Pilih Paket Kursus *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'package-'.e($expStudent->id).'','value' => 'Pilih Paket Kursus *']); ?>
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
                                                    <select id="package-<?php echo e($expStudent->id); ?>" name="package_id" x-model="packageId" @change="onPackageChange()" required
                                                        class="block mt-1 w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                                        <option value="">-- Pilih Paket Latihan --</option>
                                                        <template x-for="pkg in filteredPackages" :key="pkg.id">
                                                            <option :value="pkg.id" :selected="pkg.id == packageId" x-text="pkg.name + ' — ' + (locationId ? formatPrice(pkg.is_location_based ? ((pkg.location_prices || []).find(l => l.location_id == locationId)?.price || 0) : (pkg.price || 0)) : '(Harga menyesuaikan kolam)') + ' (' + pkg.sessions + 'x Pertemuan)'"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="location_id" :value="locationId">
                                                <input type="hidden" name="secondary_location_id" :value="secondaryLocationId">

                                                <!-- Jadwal Latihan Checkbox Grid -->
                                                <div class="mb-4" x-show="packageId && filteredSchedules.length > 0" x-transition>
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

                                                    <div class="grid grid-cols-1 gap-2 max-h-48 overflow-y-auto pr-1">
                                                        <template x-for="sched in filteredSchedules" :key="sched.id">
                                                            <label class="flex items-start gap-2.5 p-2.5 border rounded-lg cursor-pointer transition-all duration-100 text-xs"
                                                                :class="selectedScheduleIds.includes(String(sched.id)) ? 'border-blue-400 bg-blue-50/50' : 
                                                                    (isScheduleDisabled(sched) ? 'border-gray-100 bg-gray-50/30 opacity-60 cursor-not-allowed' : 'border-gray-200 hover:border-gray-300')">
                                                                <input type="checkbox" name="schedule_ids[]" :value="sched.id"
                                                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-0.5"
                                                                    @change="toggleSchedule(sched.id)"
                                                                    :checked="selectedScheduleIds.includes(String(sched.id))"
                                                                    :disabled="isScheduleDisabled(sched)" />
                                                                <div class="flex-1">
                                                                    <div class="flex items-center gap-1.5 flex-wrap">
                                                                        <span class="font-bold text-gray-800" x-text="getDayName(sched.day_of_week) + ', ' + formatTime(sched.start_time) + ' - ' + formatTime(sched.end_time)"></span>
                                                                        <span class="text-[9px] px-1.5 py-0.2 rounded-full font-bold uppercase"
                                                                            :class="sched.session_type === 'swim' ? 'bg-cyan-100 text-cyan-700' : 'bg-orange-100 text-orange-700'"
                                                                            x-text="sched.session_type === 'swim' ? 'Renang' : 'Dryland'"></span>
                                                                    </div>
                                                                    <span class="block text-[10px] text-gray-500 mt-0.5"><i class="fa-solid fa-map-pin text-gray-400 mr-0.5"></i><span x-text="sched.location?.name || ''"></span></span>
                                                                    <span class="block text-[10px] font-bold mt-0.5"
                                                                        :class="(sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? 'text-red-500' : 'text-blue-600'"
                                                                        x-text="(sched.current_enrolled_count || 0) + '/' + getScheduleCapacityLimit(sched) + ' Terisi' + ((sched.current_enrolled_count || 0) >= getScheduleCapacityLimit(sched) ? ' (Penuh)' : '')"></span>
                                                                    <template x-if="isSchedulePriceMismatch(sched) && !selectedScheduleIds.includes(String(sched.id))">
                                                                        <span class="block text-[10px] text-amber-600 dark:text-amber-400 font-bold mt-0.5">
                                                                            <i class="fa-solid fa-triangle-exclamation mr-0.5"></i>Beda tarif lokasi paket
                                                                        </span>
                                                                    </template>
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
                                                </div></div>

                                                <!-- Ringkasan Pembayaran -->
                                                <div class="mb-4" x-show="packageId" x-transition>
                                                    <div class="bg-[#101828] border border-[#D3AF37]/30 rounded-2xl p-4 shadow-md">
                                                        <h4 class="text-xs uppercase font-extrabold text-[#D3AF37] tracking-wider mb-3 flex items-center gap-2">
                                                            <i class="fa-solid fa-calculator text-[#D3AF37]"></i> Ringkasan Pembayaran
                                                        </h4>
                                                        <div class="space-y-2 text-sm">
                                                            <div class="flex justify-between items-center text-slate-300">
                                                                <span class="text-slate-300 font-medium text-xs">Paket Kursus</span>
                                                                <span class="font-bold text-white text-sm" x-text="formatPrice(calculatedPrice)"></span>
                                                            </div>
                                                            <div class="flex justify-between items-center text-slate-300" x-show="shouldPayRegFee">
                                                                <span class="text-slate-300 font-medium text-xs">Biaya Pendaftaran <span class="text-[10px] text-slate-400">(> 3 bulan tidak aktif)</span></span>
                                                                <span class="font-bold text-white text-sm">Rp 30.000</span>
                                                            </div>
                                                            <hr class="border-slate-800 my-2.5 border-dashed" />
                                                            <div class="flex justify-between items-center text-base pt-0.5">
                                                                <span class="font-extrabold text-white text-sm">Total Bayar</span>
                                                                <span class="font-black text-[#D3AF37] text-lg tracking-tight" x-text="formatPrice(totalAmount)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Info Rekening -->
                                                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-4 text-xs text-blue-800">
                                                    <p class="font-bold text-sm mb-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Informasi Pembayaran</p>
                                                    <p>Silakan transfer nominal ke rekening berikut:</p>
                                                    <p class="font-extrabold text-gray-900 mt-1">Bank BCA: 123-4567-890 (a.n. Klub Renang)</p>
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
                                                        x-bind:disabled="!packageId || selectedScheduleIds.length === 0"
                                                        class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-xs uppercase tracking-widest rounded-md shadow-sm transition">
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
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-users text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Murid</p>
                            <p class="text-2xl font-bold text-white mt-0.5"><?php echo e($totalStudents); ?> Murid</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-user-tie text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Coach</p>
                            <p class="text-2xl font-bold text-white mt-0.5"><?php echo e($totalCoaches); ?> Pelatih</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                </div>

                
                <div
                    class="bg-[#101828] overflow-hidden shadow-md sm:rounded-2xl p-6 border border-[#D3AF37]/30 flex items-center justify-between cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-[#D3AF37]/15 text-[#D3AF37] border border-[#D3AF37]/30 rounded-xl">
                            <i class="fa-solid fa-location-dot text-2xl w-8 text-center"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tempat Latihan</p>
                            <p class="text-2xl font-bold text-white mt-0.5"><?php echo e($totalLocations); ?> Lokasi</p>
                        </div>
                    </div>
                    <div class="text-slate-600">
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
                    <?php if($myStudent && $myStudent->progressReports->isNotEmpty()): ?>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <div class="w-full sm:w-40">
                                <select id="chart_year_filter"
                                    class="w-full text-sm rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-900 font-semibold bg-gray-50 p-2.5"
                                    disabled>
                                    <option value="" disabled selected>-- Tahun --</option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
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
                                            
                                            <div id="chart-year-empty-state"
                                                class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                                                <i class="fa-regular fa-calendar-xmark text-6xl mb-4 text-gray-200"></i>
                                                <p class="font-medium text-gray-800 dark:text-white/90 text-lg" id="year-empty-title">Belum ada data latihan di tahun ini</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-sm" id="year-empty-subtext">Pilih tahun lain atau tunggu hingga Coach menginput data perkembangan.</p>
                                            </div>

                                            
                                            <div id="chart-no-data-state"
                                                class="hidden flex-1 flex-col items-center justify-center text-center py-16 px-4 text-gray-400">
                                                <i class="fa-solid fa-folder-open text-6xl mb-4 text-gray-200"></i>
                                                <p class="font-medium text-gray-600">Belum ada riwayat perkembangan untuk murid ini</p>
                                                <p class="text-xs text-gray-400 mt-1 max-w-sm" id="no-data-subtext">Hubungi Coach pendamping untuk menginput data perkembangan fisik pertama.</p>
                                            </div>

                                            
                                            <div id="chart-container" class="hidden flex-1 flex-col min-w-0 overflow-hidden">
                                                
                                                <div id="prestasi-charts-container" class="hidden flex-col space-y-8 w-full mt-4 min-w-0">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                            <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Kondisi Fisik</h4>
                                                            <div class="relative w-full h-[250px]">
                                                                <canvas id="radarChart"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                            <h4 class="text-sm font-bold text-center text-slate-700 mb-2">Sistem Energi</h4>
                                                            <div class="relative w-full h-[250px]">
                                                                <canvas id="barChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-0">
                                                         <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-2">
                                                             <h4 class="text-sm font-bold text-slate-700 flex items-center gap-1"><i class="fa-solid fa-stopwatch text-indigo-500"></i> Personal Best Time</h4>
                                                             <div class="w-full sm:w-60">
                                                                 <select id="pbt_filter_selector" class="w-full text-xs rounded-md border-gray-300 shadow-sm text-gray-900 font-semibold bg-white py-1 max-w-full truncate">
                                                                     <!-- Dynamically populated -->
                                                                 </select>
                                                             </div>
                                                         </div>
                                                         <div class="relative w-full h-[300px]">
                                                             <canvas id="lineChartPBT"></canvas>
                                                         </div>
                                                     </div>
                                                </div>

                                                
                                                <div id="freetext-container" class="hidden mt-4 mb-6 min-w-0">
                                                    <div style="display: flex; height: 420px; border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; background: #fff;">
                                                        
                                                        <div style="width: 200px; min-width: 200px; background: #f8fafc; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column;">
                                                            <div style="padding: 12px; border-bottom: 1px solid #e2e8f0; background: rgba(241,245,249,0.8);">
                                                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                                                    <i class="fa-regular fa-calendar-days"></i> Menu Bulan
                                                                </h4>
                                                            </div>
                                                            <div id="freetext-month-list" style="flex: 1; overflow-y: auto; padding: 8px;" class="space-y-1">
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                                                            <div id="freetext-detail-panel" style="flex: 1; overflow-y: auto; padding: 20px;">
                                                                <div id="freetext-detail-empty" class="flex flex-col items-center justify-center h-full text-gray-400">
                                                                    <i class="fa-regular fa-hand-pointer text-4xl mb-3 text-gray-200"></i>
                                                                    <p class="text-sm font-medium text-gray-500">Pilih bulan di samping kiri</p>
                                                                    <p class="text-xs text-gray-400 mt-1">Detail catatan perkembangan akan ditampilkan di sini.</p>
                                                                </div>
                                                                <div id="freetext-detail-content" class="hidden">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-100">
                                                    <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                                        <h4
                                                            class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                                            <i class="fa-solid fa-comment-dots"></i> Catatan Terakhir Pelatih
                                                        </h4>
                                                        <p id="latest-note" class="text-sm text-gray-600 italic break-words whitespace-pre-wrap">"Tidak ada catatan pada evaluasi terakhir."</p>
                                                        <div id="latest-note-date" class="text-[10px] text-gray-400 mt-2 font-semibold">Diinput pada: -</div>
                                                    </div>

                                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex flex-col justify-center">
                                                        <h4
                                                            class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
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
                    <?php endif; ?>
            </div>

        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php if($myStudent && $myStudent->progressReports->isNotEmpty()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearDropdown = document.getElementById('chart_year_filter');
                const noDataState = document.getElementById('chart-no-data-state');
                const yearEmptyState = document.getElementById('chart-year-empty-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');
                const freetextContainer = document.getElementById('freetext-container');
                const prestasiContainer = document.getElementById('prestasi-charts-container');

                let radarChartInst = null;
                let barChartInst = null;
                let lineChartPBTInst = null;
                
                const allReports = <?php echo json_encode($myStudent->progressReports, 15, 512) ?>;

                // Helper: ubah "01:25.50" jadi detik "85.5"
                function parseTimeToSeconds(timeStr) {
                    if (!timeStr) return null;
                    const match = String(timeStr).match(/(?:(\d+):)?(\d+)[.,:](\d+)/);
                    if (match) {
                        const m = parseInt(match[1] || 0);
                        const s = parseInt(match[2] || 0);
                        const ms = parseInt(match[3] || 0);
                        const msVal = ms < 100 ? ms * 10 : ms;
                        return m * 60 + s + (msVal / 1000);
                    }
                    return null;
                }

                // Fungsi format balik dari detik ke "MM:SS.ms"
                function formatSecondsToTime(totalSeconds) {
                    if (totalSeconds == null) return "-";
                    const m = Math.floor(totalSeconds / 60);
                    const s = Math.floor(totalSeconds % 60);
                    const ms = Math.round((totalSeconds - Math.floor(totalSeconds)) * 100);
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(2, '0')}`;
                }

                function hideAllStates() {
                    noDataState.classList.add('hidden');
                    noDataState.style.display = '';
                    yearEmptyState.classList.add('hidden');
                    yearEmptyState.style.display = '';
                    chartContainer.classList.add('hidden');
                    chartContainer.style.display = '';
                }

                function destroyAllCharts() {
                    if (radarChartInst) { radarChartInst.destroy(); radarChartInst = null; }
                    if (barChartInst) { barChartInst.destroy(); barChartInst = null; }
                    if (lineChartPBTInst) { lineChartPBTInst.destroy(); lineChartPBTInst = null; }
                }

                function renderChartsForYear(year) {
                    destroyAllCharts();
                    hideAllStates();

                    const filteredReports = allReports.filter(r => new Date(r.date).getFullYear() === parseInt(year));

                    if (filteredReports.length === 0) {
                        yearEmptyState.classList.remove('hidden');
                        yearEmptyState.style.display = 'flex';
                        return;
                    }

                    chartContainer.classList.remove('hidden');
                    chartContainer.style.display = 'flex';

                    // Update catatan terakhir
                    const latestReport = filteredReports[filteredReports.length - 1];
                    latestNoteText.textContent = latestReport.notes ?
                        `"${latestReport.notes}"` :
                        `"Tidak ada catatan pada evaluasi terakhir."`;

                    const ld = new Date(latestReport.date);
                    latestNoteDate.textContent =
                        `Diinput pada: ${ld.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}`;

                    const isPrestasi = allReports.some(r => r.metrics && ('Personal Best Time' in r.metrics));

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };

                        let hasKondisiFisik = false;
                        let hasSistemEnergi = false;

                        filteredReports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short' }));

                            if (report.metrics) {
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                if (Object.keys(kf).length > 0) hasKondisiFisik = true;
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                const se = report.metrics['Sistem Energi'] || {};
                                if (Object.keys(se).length > 0) hasSistemEnergi = true;
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);
                            }
                        });

                        const kondisiFisikEl = document.getElementById('radarChart').closest('.bg-slate-50, .bg-gray-50, .rounded-xl');
                        const sistemEnergiEl = document.getElementById('barChart').closest('.bg-slate-50, .bg-gray-50, .rounded-xl');
                        const chartsGridEl = kondisiFisikEl.parentElement;

                        if (hasKondisiFisik) kondisiFisikEl.style.display = '';
                        else kondisiFisikEl.style.display = 'none';

                        if (hasSistemEnergi) sistemEnergiEl.style.display = '';
                        else sistemEnergiEl.style.display = 'none';

                        if (!hasKondisiFisik && !hasSistemEnergi) chartsGridEl.style.display = 'none';
                        else chartsGridEl.style.display = '';

                        const len = labels.length;

                        if (hasKondisiFisik) {
                            const latestLabels = ['Endurance', 'Fleksibilitas', 'Strength', 'Speed', 'Agility'];
                            const latestData = len > 0 ? [
                                radarData.Endurance[len-1], radarData.Fleksibilitas[len-1],
                                radarData.Strength[len-1], radarData.Speed[len-1], radarData.Agility[len-1]
                            ] : [];
                            const prevData = len > 1 ? [
                                radarData.Endurance[len-2], radarData.Fleksibilitas[len-2],
                                radarData.Strength[len-2], radarData.Speed[len-2], radarData.Agility[len-2]
                            ] : [];

                            const radarDatasets = [{
                                label: labels[len-1] || 'Bulan Ini',
                                data: latestData,
                                backgroundColor: 'rgba(37, 99, 235, 0.2)',
                                borderColor: 'rgb(37, 99, 235)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgb(37, 99, 235)'
                            }];
                            if (len > 1) {
                                radarDatasets.push({
                                    label: labels[len-2] || 'Bulan Lalu',
                                    data: prevData,
                                    backgroundColor: 'rgba(156, 163, 175, 0.2)',
                                    borderColor: 'rgb(156, 163, 175)',
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgb(156, 163, 175)'
                                });
                            }
                            radarChartInst = new Chart(document.getElementById('radarChart').getContext('2d'), {
                                type: 'radar',
                                data: { labels: latestLabels, datasets: radarDatasets },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: { r: { min: 0, max: 100 } },
                                    plugins: { legend: { position: 'bottom' } }
                                }
                            });
                        }

                        if (hasSistemEnergi) {
                            barChartInst = new Chart(document.getElementById('barChart').getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [
                                        { label: 'Aerobic', data: barData.Aerobic, backgroundColor: 'rgba(16, 185, 129, 0.7)' },
                                        { label: 'Anaerobic', data: barData.Anaerobic, backgroundColor: 'rgba(239, 68, 68, 0.7)' }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { position: 'bottom' } },
                                    scales: { y: { beginAtZero: true, max: 100 } }
                                }
                            });
                        }

                        const pbtSelector = document.getElementById('pbt_filter_selector');
                        const pbtCombinations = [];

                        filteredReports.forEach(report => {
                            if (report.metrics && report.metrics['Personal Best Time']) {
                                let entries = [];
                                if (Array.isArray(report.metrics['Personal Best Time'])) {
                                    entries = report.metrics['Personal Best Time'];
                                } else {
                                    entries = [{
                                        gaya: 'Gaya Bebas',
                                        jarak: '50m',
                                        test_per_bulan: report.metrics['Personal Best Time']['Test per Bulan'] || '',
                                        pbt_event: report.metrics['Personal Best Time']['PBT Event'] || ''
                                    }];
                                }
                                entries.forEach(e => {
                                    if (e.gaya && e.jarak) {
                                        const key = `${e.gaya} - ${e.jarak}`;
                                        if (!pbtCombinations.includes(key)) pbtCombinations.push(key);
                                    }
                                });
                            }
                        });

                        const oldSelectedVal = pbtSelector ? pbtSelector.value : '';

                        if (pbtSelector) {
                            pbtSelector.innerHTML = '';
                            if (pbtCombinations.length === 0) {
                                const opt = document.createElement('option');
                                opt.value = '';
                                opt.textContent = 'Tidak ada data PBT';
                                pbtSelector.appendChild(opt);
                            } else {
                                pbtCombinations.forEach(comb => {
                                    const opt = document.createElement('option');
                                    opt.value = comb;
                                    opt.textContent = comb;
                                    pbtSelector.appendChild(opt);
                                });

                                if (pbtCombinations.includes(oldSelectedVal)) pbtSelector.value = oldSelectedVal;
                                else pbtSelector.value = pbtCombinations[0];
                            }
                            pbtSelector.onchange = null;
                            pbtSelector.addEventListener('change', updateLineChartPBT);
                        }

                        function updateLineChartPBT() {
                            if (lineChartPBTInst) { lineChartPBTInst.destroy(); lineChartPBTInst = null; }
                            const val = pbtSelector ? pbtSelector.value : '';
                            if (!val) return;

                            const parts = val.split(' - ');
                            const selGaya = parts[0];
                            const selJarak = parts[1];

                            const localLabels = [];
                            const localPbtData = { TestPerBulan: [], PbtEvent: [] };

                            filteredReports.forEach(report => {
                                const d = new Date(report.date);
                                let entry = null;

                                if (report.metrics && report.metrics['Personal Best Time']) {
                                    let entries = [];
                                    if (Array.isArray(report.metrics['Personal Best Time'])) {
                                        entries = report.metrics['Personal Best Time'];
                                    } else {
                                        entries = [{
                                            gaya: 'Gaya Bebas',
                                            jarak: '50m',
                                            test_per_bulan: report.metrics['Personal Best Time']['Test per Bulan'] || '',
                                            pbt_event: report.metrics['Personal Best Time']['PBT Event'] || ''
                                        }];
                                    }
                                    entry = entries.find(e => e.gaya === selGaya && e.jarak === selJarak);
                                }

                                if (entry && entry.test_per_bulan) {
                                    localLabels.push(d.toLocaleDateString('id-ID', { month: 'short' }));
                                    localPbtData.TestPerBulan.push(parseTimeToSeconds(entry.test_per_bulan));
                                    localPbtData.PbtEvent.push({
                                        val: parseTimeToSeconds(entry.pbt_event),
                                        raw: entry.pbt_event
                                    });
                                }
                            });

                            const pbtDatasets = [
                                {
                                    label: 'Test per Bulan',
                                    data: localPbtData.TestPerBulan,
                                    borderColor: 'rgb(147, 51, 234)',
                                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                    tension: 0.3,
                                    fill: true
                                },
                                {
                                    label: 'PBT Event',
                                    data: localPbtData.PbtEvent.map(e => e.val),
                                    type: 'scatter',
                                    pointBackgroundColor: 'rgb(245, 158, 11)',
                                    pointBorderColor: 'rgb(255, 255, 255)',
                                    pointRadius: 6,
                                    pointHoverRadius: 8
                                }
                            ];

                            lineChartPBTInst = new Chart(document.getElementById('lineChartPBT').getContext('2d'), {
                                type: 'line',
                                data: { labels: localLabels, datasets: pbtDatasets },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    if (context.dataset.label === 'PBT Event') {
                                                        const rawText = localPbtData.PbtEvent[context.dataIndex].raw;
                                                        return `Event: ${rawText || formatSecondsToTime(context.raw)}`;
                                                    }
                                                    return `Test: ${formatSecondsToTime(context.raw)}`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            reverse: true,
                                            ticks: {
                                                callback: function(value) { return formatSecondsToTime(value); }
                                            },
                                            title: { display: true, text: 'Waktu (MM:SS.ms)' }
                                        }
                                    }
                                }
                            });
                        }

                        updateLineChartPBT();

                    } else {
                        if (prestasiContainer) { prestasiContainer.classList.add('hidden'); prestasiContainer.style.display = 'none'; }
                        if (freetextContainer) {
                            freetextContainer.classList.remove('hidden');

                            const monthList = document.getElementById('freetext-month-list');
                            const detailEmpty = document.getElementById('freetext-detail-empty');
                            const detailContent = document.getElementById('freetext-detail-content');
                            monthList.innerHTML = '';
                            detailContent.innerHTML = '';
                            detailContent.classList.add('hidden');
                            detailEmpty.classList.remove('hidden');

                            const sortedReports = [...filteredReports].reverse();

                            function showMonthDetail(report, btnEl) {
                                monthList.querySelectorAll('button').forEach(b => {
                                    b.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
                                    b.classList.add('bg-white', 'text-slate-700', 'hover:bg-indigo-50');
                                    b.querySelector('.month-dot')?.classList.remove('bg-white');
                                    b.querySelector('.month-dot')?.classList.add('bg-indigo-400');
                                });
                                btnEl.classList.remove('bg-white', 'text-slate-700', 'hover:bg-indigo-50');
                                btnEl.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
                                btnEl.querySelector('.month-dot')?.classList.remove('bg-indigo-400');
                                btnEl.querySelector('.month-dot')?.classList.add('bg-white');

                                detailEmpty.classList.add('hidden');
                                detailContent.classList.remove('hidden');

                                const d = new Date(report.date);
                                const dateStr = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });

                                let metricsHtml = '';
                                if (report.metrics) {
                                    for (const [category, items] of Object.entries(report.metrics)) {
                                        metricsHtml += `<div class="mb-4">
                                            <h5 class="text-sm font-bold text-slate-800 border-b border-slate-200 pb-1.5 mb-3 flex items-center gap-1.5">
                                                <i class="fa-solid fa-layer-group text-indigo-500 text-xs"></i> ${category}
                                            </h5>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                        for (const [key, val] of Object.entries(items)) {
                                            let badgeColor = 'bg-slate-100 text-slate-700';
                                            if (val === 'Sangat Mahir' || val === 'Lulus Tahap Ini' || val === 'Sudah Lancar') badgeColor = 'bg-green-100 text-green-700';
                                            else if (val === 'Berkembang Baik' || val === 'Mulai Bisa') badgeColor = 'bg-blue-100 text-blue-700';
                                            else if (val === 'Mulai Terlihat') badgeColor = 'bg-amber-100 text-amber-700';
                                            else if (val === 'Belum Berkembang' || val === 'Belum Bisa' || val === 'Belum Memulai') badgeColor = 'bg-red-100 text-red-700';

                                            metricsHtml += `<div class="text-xs flex justify-between items-center p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                                                <span class="font-medium text-slate-600">${key}</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold ${badgeColor}">${val}</span>
                                            </div>`;
                                        }
                                        metricsHtml += `</div></div>`;
                                    }
                                }

                                detailContent.innerHTML = `
                                    <div class="flex items-center gap-2 mb-5">
                                        <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                                        <h4 class="text-base font-bold text-slate-800">Bulan: ${dateStr}</h4>
                                    </div>
                                    <div class="mb-5">
                                        ${metricsHtml || '<p class="text-sm text-gray-400 italic">Tidak ada data metrik untuk bulan ini.</p>'}
                                    </div>
                                    ${report.notes ? `
                                    <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl">
                                        <p class="text-xs font-bold text-indigo-800 mb-1.5 flex items-center gap-1">
                                            <i class="fa-solid fa-comment-dots"></i> Catatan Pelatih:
                                        </p>
                                        <p class="text-sm text-slate-700 italic leading-relaxed">${report.notes}</p>
                                    </div>` : `
                                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                                        <p class="text-xs text-slate-400 italic">Tidak ada catatan dari pelatih pada bulan ini.</p>
                                    </div>`}
                                `;
                            }

                            sortedReports.forEach((report, idx) => {
                                const d = new Date(report.date);
                                const monthName = d.toLocaleDateString('id-ID', { month: 'long' });

                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-left text-sm font-semibold transition-all duration-150 bg-white text-slate-700 hover:bg-indigo-50 border border-transparent';
                                btn.innerHTML = `
                                    <span class="month-dot w-2 h-2 rounded-full bg-indigo-400 shrink-0"></span>
                                    <span class="truncate">${monthName}</span>
                                `;
                                btn.addEventListener('click', () => showMonthDetail(report, btn));
                                monthList.appendChild(btn);

                                if (idx === 0) showMonthDetail(report, btn);
                            });
                        }
                    }
                }

                if (allReports.length === 0) {
                    hideAllStates();
                    noDataState.classList.remove('hidden');
                    noDataState.style.display = 'flex';
                    yearDropdown.disabled = true;
                    yearDropdown.innerHTML = '<option value="" disabled selected>-- Tahun --</option>';
                    return;
                }

                const yearsSet = new Set();
                allReports.forEach(r => {
                    yearsSet.add(new Date(r.date).getFullYear());
                });
                const years = [...yearsSet].sort((a, b) => b - a);

                yearDropdown.innerHTML = '<option value="" disabled>-- Tahun --</option>';
                years.forEach(y => {
                    const opt = document.createElement('option');
                    opt.value = y;
                    opt.textContent = y;
                    yearDropdown.appendChild(opt);
                });
                yearDropdown.disabled = false;
                yearDropdown.value = years[0];

                renderChartsForYear(years[0]);

                yearDropdown.addEventListener('change', function() {
                    if (this.value) renderChartsForYear(this.value);
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