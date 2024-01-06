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
    ], 'active' => __("Setup Blog Section")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

                                </div>

                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $lang_code = $item->code;
                                    ?>
                                    <div class="tab-pane <?php if(get_default_language_code() == $item->code): ?> fade show active <?php endif; ?>" id="<?php echo e($item->name); ?>" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Title*",
                                                'name'      => $item->code . "_title",
                                                'value'     => old($item->code . "_title",$data->value->language->$lang_code->title ?? "")
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Heading*",
                                                'name'      =>$item->code . "_heading",
                                                'value'     => old($item->code . "_heading",$data->value->language->$lang_code->heading ?? "")
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
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header justify-content-end">
                <div class="table-btn-area">
                    <a href="#blog-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i> <?php echo e(__("Add Blog")); ?></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $blogs?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr data-item="<?php echo e($item->editData); ?>">
                                <td><?php echo e($item->category->name??""); ?></td>
                                <td>
                                    <ul class="user-list">
                                        <li><img src="<?php echo e(get_image($item->image ?? "","blog")); ?>" alt="product"></li>
                                    </ul>
                                </td>
                                <td><?php echo e(textLength($item->name->language->$system_default_lang->name ?? "",60)); ?></td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'name'          => 'category_status',
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1,'Disable' => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.setup.sections.blog.status.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>

                                <td>
                                    <a href="<?php echo e(setRoute('admin.setup.sections.blog.edit', $item->id)); ?>" class="btn btn--base"><i
                                        class="las la-pencil-alt"></i></a>
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('admin.components.alerts.empty',['colspan' => 5], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.components.modals.site-section.add-blog-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        openModalWhenError("blog-add","#blog-add");
        // openModalWhenError("blog-edit","#blog-edit");

        var default_language = "<?php echo e($default_lang_code); ?>";
        var system_default_language = "<?php echo e($system_default_lang); ?>";
        var languages = "<?php echo e($languages_for_js_use); ?>";
        languages = JSON.parse(languages.replace(/&quot;/g,'"'));

        // $(".edit-modal-button").click(function(){
        //     var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
        //     var editModal = $("#blog-edit");
        //     var category = oldData.category_id;
        //     var tags = oldData.tags;
        //     editModal.find("select[name=category_id]").val(category);

        //     editModal.find("form").first().find("input[name=target]").val(oldData.id);
        //     editModal.find("input[name="+default_language+"_name]").val(oldData.name.language[default_language].name);
        //     editModal.find("textarea[name="+default_language+"_details]").val(oldData.details.language[default_language].details);
        //     richTextEditorReinit(document.querySelector("#blog-edit textarea[name="+default_language+"_details]"));

        //     $.each(languages,function(index,item) {
        //     editModal.find("form").first().find("input[name=target]").val(oldData.id);
        //     editModal.find("input[name="+item.code+"_name]").val(oldData.name.language[item.code].name);
        //     editModal.find("textarea[name="+item.code+"_details]").val(oldData.details.language[item.code].details);
        //     richTextEditorReinit(document.querySelector("#blog-edit textarea[name="+item.code+"_details]"));
        //     });

        //     editModal.find("input[name=image]").attr("data-preview-name",oldData.image);
        //     fileHolderPreviewReInit("#blog-edit input[name=image]");
        //      // tags
        //     var  blogTags = tags;
        //     var options = "";
        //     $.each(blogTags,function(index,item) {
        //         // console.log(item);
        //             options += `<option value="${item}" selected>${item}</option>`;

        //     });
        //     var seletedTags = `<select class="form--control select2-auto-tokenize" data-tags="true" name="tags[]"  multiple data-placeholder="Select Tags">
        //                         ${options}
        //                     </select>`;

        //     editModal.find(".tags select").remove();
        //     editModal.find(".tags .select2").remove();
        //     editModal.find(".tags").append(seletedTags);
        //     editModal.find(".tags select").select2();
        //     openModalBySelector("#blog-edit");

        // });

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "<?php echo e(setRoute('admin.setup.sections.blog.delete')); ?>";
            var target = oldData.id;

            var message     = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute,target,message);
        });
        $(document).ready(function(){
            // Switcher
            switcherAjax("<?php echo e(setRoute('admin.setup.sections.blog.status.update')); ?>");
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/setup-sections/blog-section.blade.php ENDPATH**/ ?>