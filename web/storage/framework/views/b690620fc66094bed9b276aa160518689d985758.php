

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
    ], 'active' => __("Virtual Card Api")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Virtual Card Api")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="<?php echo e(setRoute('admin.virtual.card.api.update')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row mb-10-none">
                    <div class="col-xl-12   col-lg-12 form-group">
                        <label><?php echo e(__("Name*")); ?></label>
                        <select class="form--control nice-select" name="api_method">
                            <option disabled><?php echo e(__("Select Platfrom")); ?></option>
                            <option value="flutterwave" <?php if(@$api->config->name == 'flutterwave'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Flutterwave'); ?></option>
                            <option value="sudo" <?php if(@$api->config->name == 'sudo'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Sudo Africa'); ?></option>
                            <option value="stripe" <?php if(@$api->config->name == 'stripe'): ?> selected <?php endif; ?>><?php echo app('translator')->get('Stripe Api'); ?></option>
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group configForm" id="flutterwave">
                        <div class="row" >
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 form-group">
                                <label><?php echo e(__("Secret Key*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="text" class="form--control" name="flutterwave_secret_key" value="<?php echo e(@$api->config->flutterwave_secret_key); ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 form-group">
                                <label><?php echo e(__("Secret Hash*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-hashtag"></i></span>
                                    <input type="text" class="form--control" name="flutterwave_secret_hash" value="<?php echo e(@$api->config->flutterwave_secret_hash); ?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                <label><?php echo e(__("Base Url*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-link"></i></span>
                                    <input type="text" class="form--control" name="flutterwave_url" value="<?php echo e(@$api->config->flutterwave_url); ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group configForm" id="sudo">
                        <div class="row" >
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                <label><?php echo e(__("Api Key*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="text" class="form--control" name="sudo_api_key" value="<?php echo e(@$api->config->sudo_api_key); ?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 form-group">
                                <label><?php echo e(__("Vault ID Url*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-link"></i></span>
                                    <input type="text" class="form--control" name="sudo_vault_id" value="<?php echo e(@$api->config->sudo_vault_id); ?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 form-group">
                                <label><?php echo e(__("Base Url*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-link"></i></span>
                                    <input type="text" class="form--control" name="sudo_url" value="<?php echo e(@$api->config->sudo_url); ?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 form-group">
                                <?php echo $__env->make('admin.components.form.switcher', [
                                    'label'         => 'Mode',
                                    'value'         => old('sudo_mode',@$api->config->sudo_mode),
                                    'name'          => "sudo_mode",
                                    'options'       => ['Live' => global_const()::LIVE, 'Sandbox' => global_const()::SANDBOX]
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group configForm" id="stripe">
                        <div class="row" >
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                <label><?php echo e(__("Public Key*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="text" class="form--control" name="stripe_public_key" value="<?php echo e(@$api->config->stripe_public_key); ?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                <label><?php echo e(__("Secret Key*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="text" class="form--control" name="stripe_secret_key" value="<?php echo e(@$api->config->stripe_secret_key); ?>">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                <label><?php echo e(__("Base Url*")); ?></label>
                                <div class="input-group append">
                                    <span class="input-group-text"><i class="las la-link"></i></span>
                                    <input type="text" class="form--control" name="stripe_url" value="<?php echo e(@$api->config->stripe_url); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.form.input-text-rich',[
                            'label'         => 'Card Details*',
                            'name'          => 'card_details',
                            'value'         => old('card_details',@$api->card_details),
                            'placeholder'   => "Write Here...",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.virtual.card.api.update"
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function ($) {
            "use strict";
            var method = '<?php echo e(@$api->config->name); ?>';
            if (!method) {
                method = 'flutterwave';
            }

            smsMethod(method);
            $('select[name=api_method]').on('change', function() {
                var method = $(this).val();
                smsMethod(method);
            });

            function smsMethod(method){
                $('.configForm').addClass('d-none');
                if(method != 'other') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/admin/sections/virtual-card/api.blade.php ENDPATH**/ ?>