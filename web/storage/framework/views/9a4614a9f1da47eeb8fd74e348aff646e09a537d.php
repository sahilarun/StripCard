

<?php $__env->startSection('content'); ?>
    <div class="doc-inner">
        <div class="doc-wrapper w-100">
            <h2 class="inner-title"><span>Purchase</span> Validation</h2>
            <form action="<?php echo e(route('project.install.validation.form.submit')); ?>" method="POST" class="doc-form mt-20">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Codecanyon Username</label>
                    <input type="text" class="form--control" name="username" placeholder="Enter Username..." required>
                </div>
                <div class="form-group">
                    <label>Purchase Code <code><a href="">How To Get Purchase Code?</a></code></label>
                    <input type="text" name="code" class="form--control" placeholder="Enter Code..." required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn--base w-100 mt-20">Continue</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\installer\src\views/installer/pages/validation-form.blade.php ENDPATH**/ ?>