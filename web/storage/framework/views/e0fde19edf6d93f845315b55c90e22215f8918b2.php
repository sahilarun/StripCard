

<?php $__env->startSection('content'); ?>
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>All Done.</span> Application Is Ready To Run</h2>
            <h5 class="sub-title">Please Configure Below Information To Run Your Application</h5>
            <ul class="doc-list">
                <li>
                    <a href="<?php echo e(route('admin.setup.email.config')); ?>">Configuration Mail</a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.payment.gateway.view',['add-money','automatic'])); ?>">Payment Method</a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.extension.index')); ?>">Extension</a>
                </li>
            </ul>
            <div class="doc-btn two mt-20">
                <a href="<?php echo e(url('/')); ?>" class="btn--base w-100">Website</a>
                <a href="<?php echo e(url('admin/login')); ?>" class="btn--base w-100">Admin Panel</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\installer\src\views/installer/pages/finish.blade.php ENDPATH**/ ?>