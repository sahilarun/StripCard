


<?php $__env->startSection('content'); ?>
    <section class="forgot-password ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5">
                    <div class="forgot-password-area">
                        <div class="account-wrapper">
                            <div class="account-logo text-center">
                                <a href="<?php echo e(setRoute('index')); ?>" class="site-logo">
                                    <img src="<?php echo e(get_logo($basic_settings)); ?>"  data-white_img="<?php echo e(get_logo($basic_settings,'white')); ?>"
                                    data-dark_img="<?php echo e(get_logo($basic_settings,'dark')); ?>"
                                        alt="site-logo">
                                </a>
                            </div>
                            <div class="forgot-password-content ptb-30">
                                <h3 class="title"><?php echo e(__("Forgot Password?")); ?></h3>
                                <p><?php echo e(__("Enter your email and we'll send you a otp to reset your password.")); ?></p>
                            </div>
                            <form action="<?php echo e(setRoute('user.password.forgot.send.code')); ?>" class="card-form" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group">

                                       <input type="email" required class="form-control form--control" name="user" placeholder="<?php echo e(__("Email")); ?>" value="<?php echo e(old('user')); ?>">
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base btn w-100 btn-loading"><?php echo e(__("Send OTP")); ?></button>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <div class="account-item">
                                            <label><?php echo e(__("Already Have An Account?")); ?> <a href="javascript:void(0)" class="header-account-btn"><?php echo e(__("Login Now")); ?></a></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/auth/forgot-password/forgot.blade.php ENDPATH**/ ?>