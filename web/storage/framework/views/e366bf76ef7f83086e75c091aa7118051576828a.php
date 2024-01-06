

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Dashboard")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="body-wrapper">
    <div class="dashboard-area mt-10">
        <div class="dashboard-header-wrapper">
            <h3 class="title"><?php echo e(__("Welcome Back")); ?>, <span><?php echo e(@$user->fullname); ?></span></h3>
        </div>
        <div class="dashboard-item-area">
            <div class="row mb-20-none">
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title"><?php echo e(__("Current Balance")); ?></span>
                            <h4 class="title"><?php echo e(@$baseCurrency->symbol); ?><?php echo e(authWalletBalance()); ?></h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title"><?php echo e(__("Total Add Money")); ?></span>
                            <h4 class="title"><?php echo e(@$baseCurrency->symbol); ?><?php echo e(getAmount(@$totalAddMoney,2)); ?></h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-cloud-upload-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title"><?php echo e(__("Active Tickets ")); ?></span>
                            <h4 class="title"><?php echo e(@$active_tickets); ?></h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-recycle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title"><?php echo e(__("Active Card")); ?></span>
                            <h4 class="title"><?php echo e(@$virtualCards); ?></h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-area mt-60">
        <div class="dashboard-header-wrapper">
            <h4 class="title"><?php echo e(__("Latest Transactions")); ?></h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn">
                    <a href="<?php echo e(setRoute('user.transactions.index','add-money')); ?>" class="btn--base"><?php echo e(__("View More")); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-wrapper">
        <?php echo $__env->make('user.components.transaction-log',compact("transactions"), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/user/dashboard.blade.php ENDPATH**/ ?>