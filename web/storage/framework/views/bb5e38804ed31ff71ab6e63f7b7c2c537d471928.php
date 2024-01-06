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
    ], 'active' => __("Money Out Logs")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="table-area">
    <div class="table-wrapper">
        <div class="table-header">
            <h5 class="title"><?php echo e($page_title); ?></h5>
        </div>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th><?php echo e(__("TRX")); ?></th>
                        <th><?php echo e(__("Full Name")); ?></th>
                        <th><?php echo e(__("Email")); ?></th>
                        <th><?php echo e(__("User Type")); ?></th>
                        <th><?php echo e(__("Request Amount")); ?></th>
                        <th><?php echo e(__("Method")); ?></th>
                        <th><?php echo e(__(("Status"))); ?></th>
                        <th><?php echo e(__("Time")); ?></th>
                        <th><?php echo e(__("Action")); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <tr>
                            <td><?php echo e($item->trx_id); ?></td>
                            <td>
                                <a href="<?php echo e(setRoute('admin.users.details',$item->creator->username)); ?>"><?php echo e($item->creator->fullname); ?></a>
                            </td>
                            <td>
                               <?php echo e($item->creator->email ?? ''); ?>

                            </td>
                            <td><?php echo e(__("USER")); ?></td>

                            <td><?php echo e(number_format($item->request_amount,2)); ?> <?php echo e(get_default_currency_code()); ?></td>
                            <td><span class="text--info"><?php echo e($item->currency->name); ?></span></td>
                            <td>
                                <span class="<?php echo e($item->stringStatus->class); ?>"><?php echo e($item->stringStatus->value); ?></span>
                            </td>
                            <td><?php echo e($item->created_at->format('d-m-y h:i:s A')); ?></td>
                            <td>
                                <?php echo $__env->make('admin.components.link.info-default',[
                                    'href'          => setRoute('admin.money.out.details', $item->id),
                                    'permission'    => "admin.money.out.details",
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="alert alert-primary"><?php echo e(__('No data found!')); ?></div>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e(get_paginate($transactions)); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/sections/money-out/index.blade.php ENDPATH**/ ?>