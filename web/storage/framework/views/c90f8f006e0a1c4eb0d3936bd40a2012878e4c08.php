<?php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
?>


<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,
        .fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view {
            height: 330px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $__env->make('admin.components.page-title', ['title' => __($page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Setup Section'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__($page_title)); ?></h6>
        </div>

        <div class="card-body">
            <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.setup.sections.blog.update')); ?>"
            enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <input type="hidden" name="target" value="<?php echo e($data->id); ?>">
                <div class="row mb-10-none mt-3">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form--control nice-select"
                                required>
                                <?php $__currentLoopData = $categories ??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e($data->category_id == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> active <?php endif; ?>"
                                    id="edit-modal-english-tab" data-bs-toggle="tab"
                                    data-bs-target="#edit-modal-english" type="button" role="tab"
                                    aria-controls="edit-modal-english" aria-selected="false">English</button>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="nav-link <?php if(get_default_language_code() == $item->code): ?> active <?php endif; ?>"
                                        id="edit-modal-<?php echo e($item->name); ?>-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-modal-<?php echo e($item->name); ?>" type="button" role="tab"
                                        aria-controls="edit-modal-<?php echo e($item->name); ?>"
                                        aria-selected="true"><?php echo e($item->name); ?></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> fade show active <?php endif; ?>"
                                id="edit-modal-english" role="tabpanel" aria-labelledby="edit-modal-english-tab">
                                <?php
                                    $default_lang_code = language_const()::NOT_REMOVABLE;
                                ?>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input', [
                                                'label' => 'Name*',
                                                'name' => $default_lang_code . '_name',
                                                'value' => old(
                                                    $default_lang_code . '_name',
                                                    $data->name->language->$default_lang_code->name ?? ''),
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label><?php echo e('Details*'); ?></label>
                                    <textarea name="<?php echo e($default_lang_code . '_details'); ?>" class="form--control rich-text-editor">
                                    <?php echo old($default_lang_code . '_details', $data->details->language->$default_lang_code->details); ?></textarea>
                                </div>

                            </div>

                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $lang_code = $item->code;
                                ?>
                                <div class="tab-pane <?php if(get_default_language_code() == $item->code): ?> fade show active <?php endif; ?>"
                                    id="edit-modal-<?php echo e($item->name); ?>" role="tabpanel"
                                    aria-labelledby="edit-modal-<?php echo e($item->name); ?>-tab">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input', [
                                                    'label' => 'Name*',
                                                    'name' => $lang_code . '_name',
                                                    'value' => old( $lang_code . '_name', $data->name->language->$lang_code->name ?? ''),
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label><?php echo e('Details*'); ?></label>
                                        <textarea name="<?php echo e($lang_code . '_details'); ?>" class="form--control rich-text-editor">
                                            <?php echo old($lang_code . '_details', $data->details->language->$lang_code->details); ?>

                                        </textarea>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags"><?php echo e(__('Tags')); ?>*</label>
                        <select name="<?php echo e($default_lang_code . '_tags[]'); ?>" multiple id=""
                            class="select2-auto-tokenize">
                            <?php $__currentLoopData = $data->tags ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>" selected><?php echo e($item); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.form.input-file', [
                            'label' => 'Image:',
                            'name' => 'image',
                            'class' => 'file-holder',
                            'old_files_path' => files_asset_path('blog'),
                            'old_files' => $data->image,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                        <button type="button" class="btn btn--danger modal-close"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn--base"><?php echo e(__('Update')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        editModal.find("input[name=image]").attr("data-preview-name", oldData.image);
        // fileHolderPreviewReInit("#event-edit input[name=image]");
        fileHolderPreviewReInit("#blog-edit input[name=image]");
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/setup-sections/blog-section-edit.blade.php ENDPATH**/ ?>