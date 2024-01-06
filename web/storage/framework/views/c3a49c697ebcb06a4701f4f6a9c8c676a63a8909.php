<?php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
?>



<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/fontawesome-iconpicker.css')); ?>">
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $__env->make('admin.components.page-title',['title' => __($page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Setup Section")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__($page_title)); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="<?php echo e(setRoute('admin.setup.sections.section.update',$slug)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row justify-content-center mb-10-none">


                    <div class="col-xl-12 col-lg-12">
                        <div class="product-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> active <?php endif; ?>" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab" aria-controls="english" aria-selected="false">English</button>
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button class="nav-link <?php if(get_default_language_code() == $item->code): ?> active <?php endif; ?>" id="<?php echo e($item->name); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo e($item->name); ?>" type="button" role="tab" aria-controls="<?php echo e($item->name); ?>" aria-selected="true"><?php echo e($item->name); ?></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> fade show active <?php endif; ?>" id="english" role="tabpanel" aria-labelledby="english-tab">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Title*",
                                            'name'      => $default_lang_code . "_title",
                                            'value'     => old($default_lang_code . "_title",$data->value->language->$default_lang_code->title ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Heading*",
                                            'name'      => $default_lang_code . "_heading",
                                            'value'     => old($default_lang_code . "_heading",$data->value->language->$default_lang_code->heading ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.textarea',[
                                            'label'     => "Information*",
                                            'name'      => $default_lang_code . "_infomation",
                                            'value'     => old($default_lang_code . "_infomation",$data->value->language->$default_lang_code->infomation ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Address*",
                                                'name'      => $default_lang_code . "_address",
                                                'value'     => old($default_lang_code . "_address",$data->value->language->$default_lang_code->address ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Phone Number*",
                                            'name'      => $default_lang_code . "_phone",
                                            'value'     => old($default_lang_code . "_phone",$data->value->language->$default_lang_code->phone ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Email Address*",
                                            'name'      => $default_lang_code . "_email",
                                            'value'     => old($default_lang_code . "_email",$data->value->language->$default_lang_code->email ?? "")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                </div>

                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $lang_code = $item->code;
                                    ?>
                                    <div class="tab-pane <?php if(get_default_language_code() == $item->code): ?> fade show active <?php endif; ?>" id="<?php echo e($item->name); ?>" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Title*",
                                                'name'      => $lang_code . "_title",
                                                'value'     => old($lang_code . "_title",$data->value->language->$lang_code->title ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>

                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Heading*",
                                                'name'      => $lang_code . "_heading",
                                                'value'     => old($lang_code . "_heading",$data->value->language->$lang_code->heading ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.textarea',[
                                                'label'     => "Information*",
                                                'name'      => $lang_code . "_infomation",
                                                'value'     => old($lang_code . "_infomation",$data->value->language->$lang_code->infomation ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Address*",
                                                'name'      => $lang_code . "_address",
                                                'value'     => old($lang_code ."_address",$data->value->language->$lang_code->address ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Phone Number*",
                                                'name'      => $lang_code . "_phone",
                                                'value'     => old($lang_code . "_phone",$data->value->language->$lang_code->phone ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>

                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Email Address*",
                                                'name'      => $lang_code . "_email",
                                                'value'     => old($lang_code . "_email",$data->value->language->$lang_code->email ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Submit",
                            'permission'    => "admin.setup.sections.section.update"
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/setup-sections/contact-section.blade.php ENDPATH**/ ?>