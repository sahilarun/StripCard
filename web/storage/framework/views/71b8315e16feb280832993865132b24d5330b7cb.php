<div id="useful-link-add" class="mfp-hide large">
    <div class="modal-data">
        <div class="modal-header px-0">
            <h5 class="modal-title"><?php echo e(__("Add Page")); ?></h5>
        </div>
        <div class="modal-form-data">
            <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.useful.links.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row mb-10-none mt-3">
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> active <?php endif; ?>" id="modal-english-tab" data-bs-toggle="tab" data-bs-target="#modal-english" type="button" role="tab" aria-controls="modal-english" aria-selected="false">English</button>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="nav-link <?php if(get_default_language_code() == $item->code): ?> active <?php endif; ?>" id="modal-<?php echo e($item->name); ?>-tab" data-bs-toggle="tab" data-bs-target="#modal-<?php echo e($item->name); ?>" type="button" role="tab" aria-controls="modal-<?php echo e($item->name); ?>" aria-selected="true"><?php echo e($item->name); ?></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> fade show active <?php endif; ?>" id="modal-english" role="tabpanel" aria-labelledby="modal-english-tab">
                                <?php
                                    $default_lang_code = language_const()::NOT_REMOVABLE;
                                ?>
                                <div class="form-group">
                                    <?php echo $__env->make('admin.components.form.input',[
                                        'label'     => "Page Name*",
                                        'name'      => $default_lang_code . "_title",
                                        'value'     => old($default_lang_code . "_title",$data->title->language->$default_lang_code->title ?? "")
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="form-group">
                                     <?php echo $__env->make('admin.components.form.input-text-rich',[
                                        'label'     => "Details*",
                                        'name'      => $default_lang_code . "_details",
                                        'value'     => old($default_lang_code . "_details",$data->details->language->$default_lang_code->details ?? "")
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>

                            </div>

                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $lang_code = $item->code;
                                ?>
                                <div class="tab-pane <?php if(get_default_language_code() == $item->code): ?> fade show active <?php endif; ?>" id="modal-<?php echo e($item->name); ?>" role="tabpanel" aria-labelledby="modal-<?php echo e($item->name); ?>-tab">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Page Name*",
                                            'name'      => $lang_code . "_title",
                                            'value'     => old($lang_code . "_title",$data->title->language->$lang_code->title ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input-text-rich',[
                                            'label'     => "Details*",
                                            'name'      => $lang_code . "_details",
                                            'value'     => old($lang_code . "_details",$data->details->language->$lang_code->details ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                        <button type="button" class="btn btn--danger modal-close"><?php echo e(__("Cancel")); ?></button>
                        <button type="submit" class="btn btn--base"><?php echo e(__("Add")); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/modals/site-section/useful-link-add.blade.php ENDPATH**/ ?>