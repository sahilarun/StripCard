<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __(@$page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="body-wrapper">
    <div class="dashboard-area mt-10">
        <div class="dashboard-header-wrapper">
            <h3 class="title"><?php echo e(__(@$page_title)); ?></h3>
        </div>
    </div>
    <div class="dashboard-list-area mt-20">
        <div class="dashboard-list-wrapper">

            <?php if(isset($card_truns) && $card_truns['data'] != null): ?>
                <?php if(array_key_exists('data', $card_truns )): ?>
                    <?php $__currentLoopData = $card_truns['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="dashboard-list-item-wrapper">
                        <div class="dashboard-list-item sent">
                            <div class="dashboard-list-left">
                                <div class="dashboard-list-user-wrapper">
                                    <div class="dashboard-list-user-icon">
                                        <i class="las la-arrow-up"></i>
                                    </div>
                                    <div class="dashboard-list-user-content">
                                        <h4 class="title"><?php echo e(__("TRX ID")); ?>: <?php echo e(@$value['id']); ?></h4>
                                        <span class="sub-title text--danger"> <span class="badge badge--success ms-2"><?php echo e(ucwords(@$value['type'])); ?></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-list-right">
                                <h4 class="main-money text--base"><?php echo e(@$value['amount'] /100); ?> <?php echo e(Str::upper(@$value['currency'])); ?></h4>
                                <h6 class="exchange-money"><?php echo e(date('Y-m-d H:i:s',$value['created'])); ?></h6>
                            </div>
                        </div>
                        <div class="preview-list-wrapper">
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-exchange-alt"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span><?php echo e(__("TRX ID")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span><?php echo e(@$value['id']); ?></span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-qrcode"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span><?php echo e(__("Card Number")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span><?php echo e("....".@$card->last4); ?></span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-user-tag"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span><?php echo e(__("Name On Card")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span><?php echo e(@$card->name); ?></span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-hand-holding-heart"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span><?php echo e(__("Amount")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span><?php echo e(@$value['amount']); ?> <?php echo e(Str::upper(@$value['currency'])); ?></span>
                                </div>
                            </div>
                            <div class="preview-list-item">
                                <div class="preview-list-left">
                                    <div class="preview-list-user-wrapper">
                                        <div class="preview-list-user-icon">
                                            <i class="las la-user-tag"></i>
                                        </div>
                                        <div class="preview-list-user-content">
                                            <span><?php echo e(__("DESCRIPTION")); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-list-right">
                                    <span><?php echo e(@$value['merchant_data']->name); ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php else: ?>
            <div class="alert alert-primary text-center">
                <?php echo e(__("No Record Found!")); ?>

            </div>
            <?php endif; ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/sections/virtual-card-stripe/trx.blade.php ENDPATH**/ ?>