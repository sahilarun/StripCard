

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
    ], 'active' => __("Support Chat")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card support-card">
        <div class="support-card-wrapper">
            <div class="card-header">
                <div class="card-header-user-area">
                    <img class="avatar" src="<?php echo e(get_image($support_ticket->user->image,"user-profile")); ?>" alt="client">
                    <div class="card-header-user-content">
                        <h6 class="title"><?php echo e($support_ticket->user->fullname); ?></h6>
                        <span class="sub-title"><?php echo e(__("Ticket ID")); ?> : <span class="text--danger">#<?php echo e($support_ticket->token); ?></span></span>
                    </div>
                </div>
                <div class="info-btn">
                    <i class="las la-info-circle"></i>
                </div>
            </div>
            <div class="support-chat-area">
                <div class="chat-container messages">
                    <ul>
                        <?php $__currentLoopData = $support_ticket->conversations ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="media media-chat <?php if($item->receiver_type != "ADMIN"): ?> media-chat-reverse sent <?php else: ?> replies <?php endif; ?>">
                                <img class="avatar" src="<?php echo e($item->senderImage); ?>" alt="Profile">
                                <div class="media-body">
                                    <p><?php echo e($item->message); ?></p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php echo $__env->make('admin.components.support-ticket.conversation.message-input',['support_ticket' => $support_ticket], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <?php echo $__env->make('admin.components.support-ticket.details',['support_ticket' => $support_ticket], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.components.support-ticket.conversation.connection-admin',[
    'support_ticket' => $support_ticket,
    'route'          => setRoute('admin.support.ticket.messaage.reply'),
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/support-ticket/conversation.blade.php ENDPATH**/ ?>