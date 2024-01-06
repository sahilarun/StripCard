

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 448px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 404px !important;
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
    ], 'active' => __("App Settings")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title"><?php echo e(__("Onboard Screen")); ?></h5>
                <div class="table-btn-area">
                    <?php echo $__env->make('admin.components.link.add-default',[
                        'href'          => "#onboard-screen-add",
                        'class'         => "modal-btn",
                        'text'          => "Add New Screen",
                        'permission'    => "admin.app.settings.onboard.screen.store",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th><?php echo e(__("Title")); ?></th>
                            <th><?php echo e(__("Sub Title")); ?></th>
                            <th><?php echo e(__("Status")); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $onboard_screens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-item="<?php echo e($item->editData); ?>">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="<?php echo e(get_image($item->image,'app-images')); ?>" alt="onboard-image"></li>
                                    </ul>
                                </td>
                                <td><?php echo e($item->title); ?></td>
                                <td><?php echo e(textLength($item->sub_title ?? "",20)); ?> </td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'label'         => false,
                                        'name'          => 'status',
                                        'value'         => old('status',$item->status),
                                        'options'       => ['Enable' => 1,'Disable' => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.app.settings.onboard.screen.status.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td>
                                    <?php echo $__env->make('admin.components.link.edit-default',[
                                        'class'         => "onboard-screen-edit-modal-btn",
                                        'permission'    => "admin.app.settings.onboard.screen.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if($key != 0 &&  $key != 1): ?>
                                    <?php echo $__env->make('admin.components.link.delete-default',[
                                        'class'         => "onboard-screen-delete-modal-btn",
                                        'permission'    => "admin.app.settings.onboard.screen.delete",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>

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

    
    <?php echo $__env->make('admin.components.modals.add-onboard-screen', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make('admin.components.modals.edit-onboard-screen', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function(){

            switcherAjax("<?php echo e(setRoute('admin.app.settings.onboard.screen.status.update')); ?>");

            $(".onboard-screen-delete-modal-btn").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

                var actionRoute =  "<?php echo e(setRoute('admin.app.settings.onboard.screen.delete')); ?>";
                var target      = oldData.target;
                var message     = "Are you sure to <strong>delete</strong> this screen?";

                openDeleteModal(actionRoute,target,message);
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/sections/app-settings/onboard-screens.blade.php ENDPATH**/ ?>