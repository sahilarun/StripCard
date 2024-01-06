<?php
    $app_mode = strtolower(env('APP_MODE'));

?>
<section class="account-section">
    <div class="account-bg"></div>
    <div class="account-area change-form">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-center">
                <a href="<?php echo e(setRoute('index')); ?>" class="site-logo">
                    <img src="<?php echo e(get_logo($basic_settings)); ?>"  data-white_img="<?php echo e(get_logo($basic_settings,'white')); ?>"
                    data-dark_img="<?php echo e(get_logo($basic_settings,'dark')); ?>"
                        alt="site-logo">
                </a>
            </div>
            <h5 class="title"><?php echo e(__("Login Information")); ?></h5>
            <form action="<?php echo e(setRoute('user.login.submit')); ?>" method="POST" class="account-form">
                <?php echo csrf_field(); ?>
                <div class="row ml-b-20">
                    <div class="col-lg-12 form-group">
                        <input type="email" required class="form-control form--control" name="credentials" placeholder="<?php echo e(__("Email")); ?>" spellcheck="false" data-ms-editor="true" value="<?php echo e(@$app_mode == 'demo' ? 'user@appdevs.net': old('credentials')); ?>">
                    </div>
                    <div class="col-lg-12 form-group show_hide_password">
                        <input type="password" name="password" class="form-control form--control  "  placeholder="<?php echo e(__("Password")); ?>" required value="<?php echo e(@$app_mode == 'demo' ? 'appdevs':''); ?>">
                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>

                    </div>
                    <div class="col-lg-12 form-group">
                        <div class="forgot-item">
                            <label><a href="<?php echo e(setRoute('user.password.forgot')); ?>"><?php echo e(__("Forgot Password?")); ?></a></label>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100 btn-loading"><?php echo e(__("Login Now")); ?></button>
                    </div>
                    <div class="or-area">
                        <span class="or-line"></span>
                        <span class="or-title">Or</span>
                        <span class="or-line"></span>
                    </div>
                    <?php if($basic_settings->user_registration): ?>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label><?php echo e(__("Don't Have An Account?")); ?> <a href="javascript:void(0)" class="account-control-btn"><?php echo e(__("Register Now")); ?></a></label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="account-area">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-center">
                <a class="site-logo" href="index.html"><img src="<?php echo e(get_logo($basic_settings)); ?>"  data-white_img="<?php echo e(get_logo($basic_settings,'white')); ?>"
                    data-dark_img="<?php echo e(get_logo($basic_settings,'dark')); ?>" alt="logo"></a>
            </div>
            <h5 class="title"><?php echo e(__("Register Information")); ?></h5>
            <p><?php echo e(__("Please input your details and register to your account to get access to your dashboard.")); ?></p>
            <form class="account-form" action="<?php echo e(setRoute('user.register.submit')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row ml-b-20">
                    <div class="col-lg-6 form-group">

                            <input type="text" class="form-control form--control" name="firstname" placeholder="<?php echo e(__("First Name")); ?>" required value="<?php echo e(old('firstname')); ?>">
                    </div>
                    <div class="col-lg-6 form-group">
                    <input type="text" class="form-control form--control" name="lastname" placeholder="<?php echo e(__("Last Name")); ?>" required value="<?php echo e(old('lastname')); ?>">
                    </div>
                    <div class="col-lg-12 form-group">
                            <input type="email" class="form-control form--control" name="register_email" placeholder="<?php echo e(__("Email")); ?>" required value="<?php echo e(old('register_email')); ?>">
                    </div>
                    <div class="col-lg-12 form-group show_hide_password">
                            <input type="password" name="register_password" class="form-control form--control" required placeholder="<?php echo e(__("Password")); ?>">
                            <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                        <?php if($basic_settings->agree_policy): ?>
                    <div class="col-lg-12 form-group">
                        <div class="custom-check-group">
                            <input type="checkbox" id="level-1" name="agree" required>
                            <label for="level-1"><?php echo e(__("I have agreed with")); ?> <a href="javascript:void(0)"><?php echo e(__("Terms Of Use & Privacy Policy")); ?></a></label>
                        </div>

                    </div>
                    <?php endif; ?>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100 btn-loading"><?php echo e(__("Register Now")); ?></button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label><?php echo e(__("Already Have An Account?")); ?> <a href="javascript:void(0)" class="account-control-btn"><?php echo e(__("Login Now")); ?></a></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php $__env->startPush('script'); ?>
<?php
     $errorName ='';
?>
<?php if($errors->any()): ?>
<?php
    $error = (object)$errors;
    $msg = $error->default;
    $messageNames  = $msg->keys();
    $errorName = $messageNames[0];
?>
<?php endif; ?>
<script>
    var error = "<?php echo e($errorName); ?>";
  if(error == 'credentials' ){
    $('.account-section').addClass('active');
  }
  if(
    error == 'firstname' ||
    error == 'agree' ||
    error == 'register_password' ||
    error == 'register_email' ||
    error == 'lastname'
  ){
    $('.account-section').addClass('active');
    $('.account-area').toggleClass('change-form');
  }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/frontend/partials/account-info.blade.php ENDPATH**/ ?>