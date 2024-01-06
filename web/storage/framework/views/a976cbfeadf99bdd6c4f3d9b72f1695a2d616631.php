

<?php $__env->startSection('content'); ?>
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Admin</span> Acoount Settings</h2>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <form action="<?php echo e(route('project.install.admin.setup.submit')); ?>" class="doc-form mt-20" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Admin Email</label>
                    <input type="email" class="form--control" name="email" placeholder="Enter Email..." required>
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form--control" name="f_name" placeholder="Enter Firstname..." required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form--control" name="l_name" placeholder="Enter Lastname..." required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form--control" name="password" placeholder="Enter Password..." required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Continue</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\installer\src\views/installer/pages/admin-setup.blade.php ENDPATH**/ ?>