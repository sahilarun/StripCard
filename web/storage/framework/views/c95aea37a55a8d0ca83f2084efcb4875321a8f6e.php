

<?php $__env->startSection('content'); ?>
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Migrate</span> Database</h2>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <ul class="doc-list two">
                <li>
                    Database Host : <span class="text--base"><?php echo e($database_data['host']); ?></span>
                </li>
                <li>
                    Database Name : <span class="text--base"><?php echo e($database_data['db_name']); ?></span>
                </li>
                <li>
                    Database Username : <span class="text--base"><?php echo e($database_data['db_user']); ?></span>
                </li>
                <li>
                    Database Password : <span class="text--base"><?php echo e($database_data['db_user_password'] ?? ""); ?></span>
                </li>
            </ul>
            <h5 class="sub-title mt-20">Please Click Migrate Button</h5>
            <form action="<?php echo e(route('project.install.migration.submit')); ?>" class="doc-form mt-10" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Migrate</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\installer\src\views/installer/pages/migration.blade.php ENDPATH**/ ?>