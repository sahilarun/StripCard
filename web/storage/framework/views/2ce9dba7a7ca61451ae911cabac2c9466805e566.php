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

    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h6 class="title"><?php echo e(__($page_title)); ?></h6>
                <div class="table-btn-area">
                    <a href="#useful-link-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i> <?php echo e(__("Add Page")); ?></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-item="<?php echo e(json_encode($item)); ?>">
                                <td>
                                    <?php echo e($item->title->language->$system_default_lang->title ?? ""); ?>

                                </td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'name'          => 'campaign_status',
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1,'Disable' => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.campaigns.items.status.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(setRoute('admin.useful.links.edit', $item->id)); ?>" class="btn btn--base"><i
                                        class="las la-pencil-alt"></i></a>
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('admin.components.alerts.empty',['colspan' => 4], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.components.modals.site-section.useful-link-add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    
    <div id="useful-link-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title"><?php echo e(__("Edit Campaign")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.useful.links.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="target" value="<?php echo e(old('target')); ?>">
                    <div class="row mb-10-none mt-3">
                        <div class="language-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link <?php if(get_default_language_code() == language_const()::NOT_REMOVABLE): ?> active <?php endif; ?>" id="modal-english-tab" data-bs-toggle="tab" data-bs-target="#modal-english" type="button" role="tab" aria-controls="edit-modal-english" aria-selected="false">English</button>
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button class="nav-link <?php if(get_default_language_code() == $item->code): ?> active <?php endif; ?>" id="edit-modal-<?php echo e($item->name); ?>-tab" data-bs-toggle="tab" data-bs-target="#edit-modal-<?php echo e($item->name); ?>" type="button" role="tab" aria-controls="edit-modal-<?php echo e($item->name); ?>" aria-selected="true"><?php echo e($item->name); ?></button>
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
                                            'value'     => old($default_lang_code . "_title")
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e("Details*"); ?></label>
                                        <textarea name="<?php echo e($default_lang_code . "_details"); ?>" class="form--control"></textarea>
                                    </div>

                                </div>

                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $lang_code = $item->code;
                                    ?>
                                    <div class="tab-pane <?php if(get_default_language_code() == $item->code): ?> fade show active <?php endif; ?>" id="edit-modal-<?php echo e($item->name); ?>" role="tabpanel" aria-labelledby="edit-modal-<?php echo e($item->name); ?>-tab">
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Page Name*",
                                                'name'      => $lang_code . "_title",
                                                'value'     => old($lang_code . "_title")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e("Details*"); ?></label>
                                            <textarea name="<?php echo e($lang_code . "_details"); ?>" class="form--control d-none"></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close"><?php echo e(__("Cancel")); ?></button>
                            <button type="submit" class="btn btn--base"><?php echo e(__("Update")); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        openModalWhenError("useful-link-add","#useful-link-add");
        openModalWhenError("useful-link-edit","#useful-link-edit");

        var default_language = "<?php echo e($default_lang_code); ?>";
        var system_default_language = "<?php echo e($system_default_lang); ?>";
        var languages = "<?php echo e($languages_for_js_use); ?>";
        languages = JSON.parse(languages.replace(/&quot;/g,'"'));

        $(".edit-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var editModal = $("#useful-link-edit");

            editModal.find("form").first().find("input[name=target]").val(oldData.id);
            editModal.find("input[name="+default_language+"_title]").val(oldData.title.language[default_language].title);
            editModal.find("textarea[name="+default_language+"_details]").val(oldData.details.language[default_language].details);

            richTextEditorReinit(document.querySelector("#useful-link-edit textarea[name="+default_language+"_details]"));

            $.each(languages,function(index,item) {
                editModal.find("input[name="+item.code+"_title]").val(oldData.title.language[item.code].title);
                editModal.find("textarea[name="+item.code+"_details]").val(oldData.details.language[item.code].details);

                richTextEditorReinit(document.querySelector("#useful-link-edit textarea[name="+item.code+"_details]"));
            });

            openModalBySelector("#useful-link-edit");

        });

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "<?php echo e(setRoute('admin.useful.links.delete')); ?>";
            var target = oldData.id;

            var message     = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute,target,message);
        });

        // Switcher
        switcherAjax("<?php echo e(setRoute('admin.useful.links.status.update')); ?>");

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/setup-pages/useful-links/index.blade.php ENDPATH**/ ?>