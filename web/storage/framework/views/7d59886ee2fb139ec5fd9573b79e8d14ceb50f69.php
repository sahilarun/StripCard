

<?php $__env->startSection('content'); ?>
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Configure</span> Database</h2>
            <h5 class="sub-title">Provide Database Information Correctly</h5>
            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li>Please provide valid information. All field is required</li>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('project.install.database.config.submit')); ?>" class="doc-form mt-20" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Application name</label>
                    <input type="text" class="form--control" name="app_name" placeholder="Ex : localhost">
                </div>
                <div class="form-group">
                    
                    <input type="hidden" class="form--control" name="host" placeholder="Ex : localhost" required value="localhost">
                </div>
                <div class="form-group">
                    <label>Database Name</label>
                    <input type="text" class="form--control" name="db_name" placeholder="Enter Name..." required>
                </div>
                <div class="form-group">
                    <label>Database Username</label>
                    <input type="text" class="form--control" name="db_user" placeholder="Enter Username..." required>
                </div>
                <div class="form-group">
                    <label>Database Password</label>
                    <input type="password" class="form--control" name="db_user_password" placeholder="Enter Password...">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Continue</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\installer\src\views/installer/pages/database-config.blade.php ENDPATH**/ ?>