

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
    ], 'active' => __("Add Money")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title"><?php echo e(__($page_title)); ?></h5>
                <div class="table-btn-area">
                    <?php echo $__env->make('admin.components.link.add-default',[
                        'href'          => setRoute('admin.payment.gateway.create',['add-money','manual']),
                        'text'          => "Add New",
                        'permission'    => "admin.payment.gateway.create",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Gateway</th>
                            <th>Currency Code</th>
                            <th>Currency Symbol</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-target="<?php echo e($item->id); ?>">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="<?php echo e(get_image($item->image,'payment-gateways')); ?>" alt="Image"></li>
                                    </ul>
                                </td>
                                <td><?php echo e($item->name); ?></td>
                                <td><?php echo e($item->currencies->first()->currency_code); ?></td>
                                <td><?php echo e($item->currencies->first()->currency_symbol); ?></td>
                                <td>
                                    <?php echo $__env->make('admin.components.form.switcher',[
                                        'name'          => 'status',
                                        'data_target'   => $item->id,
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1, 'Disabled' => 0],
                                        'onload'        => true,
                                        'permission'    => "admin.payment.gateway.status.update",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                                <td>
                                    <?php echo $__env->make('admin.components.link.edit-default',[
                                        'href'          => setRoute('admin.payment.gateway.edit',['add-money','manual',$item->alias]),
                                        'permission'    => "admin.payment.gateway.edit",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <?php echo $__env->make('admin.components.link.delete-default',[
                                        'class'         => "gateway-delete-btn",
                                        'permission'    => "admin.payment.gateway.remove",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </td>
                            </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('admin.components.alerts.empty',['colspan' => 6], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        switcherAjax("<?php echo e(setRoute('admin.payment.gateway.status.update')); ?>");

        $(".gateway-delete-btn").click(function(){
            var targetElement = $(this).parents("tr").attr("data-target");
            var action = "<?php echo e(setRoute('admin.payment.gateway.remove')); ?>"
            var method = '<?php echo method_field("DELETE"); ?>';

            openModalByContent(
                {
                    content: `<div class="card modal-alert border-0">
                                <div class="card-body">
                                    <form method="POST" action="${action}">
                                        <input type="hidden" name="_token" value="${laravelCsrf()}">
                                        ${method}
                                        <div class="head mb-3">
                                            Are you sure to delete this <strong>gateway</strong> ?
                                            <input type="hidden" name="target" value="${targetElement}">
                                        </div>
                                        <div class="foot d-flex align-items-center justify-content-between">
                                            <button type="button" class="modal-close btn btn--info">Close</button>
                                            <button type="submit" class="alert-submit-btn btn btn--danger btn-loading">Remove</button>
                                        </div>    
                                    </form>
                                </div>
                            </div>`,
                },

            );
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/sections/payment-gateways/add-money/manual/index.blade.php ENDPATH**/ ?>