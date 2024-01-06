

<?php $__env->startPush('css'); ?>

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
    ], 'active' => __("Languages")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="table-area">
        <div class="table-wrapper">
            <?php echo $__env->renderUnless($languages->where("status",1)->count(),'admin.components.alerts.warning',['message' => "There is no default language in your system. System will automatically select English as a default language."], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
            <div class="table-header">
                <h5 class="title"><?php echo e(__($page_title)); ?></h5>
                <div class="table-btn-area">
                    <?php echo $__env->make('admin.components.link.add-default',[
                        'href'          => "#language-add",
                        'class'         => "py-2 px-4 modal-btn",
                        'text'          => "Add New",
                        'permission'    => "admin.languages.store",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('admin.components.link.custom',[
                        'href'          => "#language-import",
                        'class'         => "btn--base py-2 px-4 bg--info modal-btn",
                        'icon'          => "fas fa-upload me-1",
                        'text'          => "Import",
                        'permission'    => "admin.languages.import",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(language_file_exists()): ?>
                        <?php echo $__env->make('admin.components.link.custom',[
                            'text'          => "Download",
                            'icon'          => "fas fa-download me-1",
                            'permission'    => "admin.languages.download",
                            'href'          => setRoute('admin.languages.download'),
                            'class'         => "btn--base py-2 px-4 bg--primary",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-item="<?php echo e($item->editData); ?>">
                                <td><?php echo e($item->name); ?></td>
                                <td><?php echo e($item->code); ?></td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'name'          => 'status',
                                        'value'         => $item->status,
                                        'options'       => ['Default' => 1,'Selectable' => 0],
                                        'onload'     => true,
                                        'data_target'   => $item->id,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td>
                                    <?php echo $__env->make('admin.components.link.info-default',[
                                        'href'          => setRoute('admin.languages.info',$item->code),
                                        'permission'    => "admin.languages.info",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('admin.components.link.edit-default',[
                                        'class'         => "edit-modal-button",
                                        'permission'    => "admin.languages.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if(language_const()::NOT_REMOVABLE != $item->code): ?>
                                        <?php echo $__env->make('admin.components.link.delete-default',[
                                            'class'         => "delete-modal-button",
                                            'permission'    => "admin.languages.delete",
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
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

    
    <?php echo $__env->make('admin.components.modals.language.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('admin.components.modals.language.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('admin.components.modals.language.import',compact("languages"), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(".delete-modal-button").click(function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "<?php echo e(setRoute('admin.languages.delete')); ?>";
            var target      = oldData.id;
            var message     = "Are you sure to delete this language?";

            openDeleteModal(actionRoute,target,message);
        });
        // Switcher
        switcherAjax("<?php echo e(setRoute('admin.languages.status.update')); ?>");
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/language/index.blade.php ENDPATH**/ ?>