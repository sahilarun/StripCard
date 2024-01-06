
<?php
    $app_mode = strtolower(env('APP_MODE'));
?>
<?php $__env->startSection('section'); ?>
    <div class="account-wrapper">
        <div class="account-header">
            <div class="site-logo">
                <img src="<?php echo e(get_logo($basic_settings)); ?>" alt="logo">
            </div>
            <span class="inner-title">👋</span>
            <h6 class="sub-title"><?php echo e(__("Welcome To")); ?> <span><?php echo e(__("Admin Panel")); ?></span></h6>
        </div>
        <form class="account-form" action="<?php echo e(setRoute('admin.login.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <input type="text" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" title="Enter Username" required name="email" value="<?php echo e(@$app_mode == 'demo' ? 'admin@appdevs.net': old('email')); ?>" autofocus>
                <label><?php echo e(__("Email Address")); ?></label>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group show_hide_password">
                <input type="password" title="Enter password" required name="password" value="<?php echo e(@$app_mode == 'demo' ? 'appdevs':''); ?>">
                <button type="button" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                <label><?php echo e(__("Password")); ?></label>
            </div>
            <div class="form-group">
                <div class="forgot-item">
                    <p><a href="<?php echo e(setRoute('admin.password.forgot')); ?>" class="text--base"><?php echo e(__("Forgot Password?")); ?></a></p>
                </div>
            </div>
            <button type="submit" class="btn--base w-100 btn-loading"><?php echo e(__("Login")); ?></button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.auth.layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>