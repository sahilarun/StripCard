<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Support Tickets")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="body-wrapper">
    <div class="table-area mt-10">
        <div class="table-wrapper">
            <div class="dashboard-header-wrapper">
                <h4 class="title"><?php echo e(__("Support Tickets")); ?></h4>
                <div class="dashboard-btn-wrapper">
                    <div class="dashboard-btn">
                        <a href="<?php echo e(route('user.support.ticket.create')); ?>" class="btn--base"><i class="las la-plus me-1"></i><?php echo e(__("Add New")); ?></a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th><?php echo e(__("Ticket ID")); ?></th>
                            <th><?php echo e(__("Full Name")); ?></th>
                            <th><?php echo e(__("Email")); ?></th>
                            <th><?php echo e(__("Subject")); ?></th>
                            <th><?php echo e(__("Status")); ?></th>
                            <th><?php echo e(__("Last Replied")); ?></th>
                            <th><?php echo e(__("Details")); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $support_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($item->token); ?></td>
                                <td><span class="text--info"><?php echo e($item->user->fullname); ?></span></td>
                                <td><span class="text--info"><?php echo e($item->user->email); ?></span></td>
                                <td><span class="text--info"><?php echo e($item->subject); ?></span></td>
                                <td>
                                    <span class="<?php echo e($item->stringStatus->class); ?>"><?php echo e($item->stringStatus->value); ?></span>
                                </td>
                                <td><?php echo e($item->created_at->format("Y-m-d H:i A")); ?></td>
                                <td>
                                    <a href="<?php echo e(route('user.support.ticket.conversation',encrypt($item->id))); ?>" class="btn btn--base"><i class="las la-comment"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <?php echo $__env->make('admin.components.alerts.empty',['colspan'=>7], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
        <?php echo e(get_paginate($support_tickets)); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\resources\views/user/sections/support-ticket/index.blade.php ENDPATH**/ ?>