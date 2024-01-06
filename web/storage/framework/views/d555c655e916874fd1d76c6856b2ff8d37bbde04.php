<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $__env->make('admin.components.page-title',['title' => __($page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Web Settings")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Basic Settings")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="<?php echo e(setRoute('admin.web.settings.basic.settings.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 form-group">
                        <label>Site Base Color*</label>
                        <div class="picker">
                            <input type="color" value="<?php echo e(old('base_color',$basic_settings->base_color)); ?>" class="color color-picker">
                            <input type="text" autocomplete="off" spellcheck="false" class="color-input" value="<?php echo e(old('base_color',$basic_settings->base_color)); ?>" name="base_color">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Web Version*",
                            'type'          => "text",
                            'class'         => "form--control",
                            'placeholder'   => "Write Web Version...",
                            'name'          => "web_version",
                            'value'         => old('web_version',$basic_settings->web_version),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Site Name*",
                            'type'          => "text",
                            'class'         => "form--control",
                            'placeholder'   => "Write Name...",
                            'name'          => "site_name",
                            'value'         => old('site_name',$basic_settings->site_name),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Site Title*",
                            'type'          => "text",
                            'class'         => "form--control",
                            'placeholder'   => "Write Name...",
                            'name'          => "site_title",
                            'value'         => old('site_title',$basic_settings->site_title),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        <label>OTP Expiration*</label>
                        <div class="input-group">
                            <input type="number" class="form--control" value="<?php echo e(old('otp_exp_seconds',$basic_settings->otp_exp_seconds)); ?>" name="otp_exp_seconds">
                            <span class="input-group-text">Seconds</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        <label>Timezone*</label>
                        <select name="timezone" class="form--control select2-auto-tokenize timezone-select" data-old="<?php echo e(old('timezone',$basic_settings->timezone)); ?>">
                            <option selected disabled>Select Timezone</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <?php echo $__env->make('admin.components.button.form-btn',[
                        'class'         => "w-100 btn-loading",
                        'text'          => "Update",
                        'permission'    => "admin.web.settings.basic.settings.update",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </form>
        </div>
    </div>
    <div class="custom-card mt-15">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Activation Settings")); ?></h6>
        </div>
        <div class="card-body">
            <div class="custom-inner-card mt-10 mb-10">
                <div class="card-inner-body">
                    <div class="row mb-10-none">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'User Registration',
                                'name'          => 'user_registration',
                                'value'         => old('user_registration',$basic_settings->user_registration),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Secure Password',
                                'name'          => 'secure_password',
                                'value'         => old('secure_password',$basic_settings->secure_password),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Agree Policy',
                                'name'          => 'agree_policy',
                                'value'         => old('agree_policy',$basic_settings->agree_policy),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Force SSL',
                                'name'          => 'force_ssl',
                                'value'         => old('force_ssl',$basic_settings->force_ssl),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Email Verification',
                                'name'          => 'email_verification',
                                'value'         => old('email_verification',$basic_settings->email_verification),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Email Notification',
                                'name'          => 'email_notification',
                                'value'         => old('email_notification',$basic_settings->email_notification),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Push Notification',
                                'name'          => 'push_notification',
                                'value'         => old('push_notification',$basic_settings->push_notification),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'KYC Verification',
                                'name'          => 'kyc_verification',
                                'value'         => old('kyc_verification',$basic_settings->kyc_verification),
                                'options'       => ['Activated' => 1,'Deactivated' => 0],
                                'onload'        => true,
                                'permission'    => "admin.web.settings.basic.settings.activation.update",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $(".color-picker").on("input",function() {
                $(this).siblings("input").val($(this).val());
            });
            $(".color-input").on('keyup', function(){
                $(this).siblings("input").val($(this).val());
            })
            // Get Timezone
            getTimeZones("<?php echo e(setRoute('global.timezones')); ?>");

            switcherAjax("<?php echo e(setRoute('admin.web.settings.basic.settings.activation.update')); ?>");

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/sections/web-settings/basic-settings.blade.php ENDPATH**/ ?>