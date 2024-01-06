

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
    ], 'active' => __("Push Notification")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Browser Push Notification Configuration")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="<?php echo e(setRoute('admin.push.notification.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            <label><?php echo e(__("Method*")); ?></label>
                            <?php
                                $selectOptions = ['pusher' => "Pusher (Message Bird)"];
                                $old_value = old('method',$push_notification->method ?? "");
                            ?>
                            <select class="form--control nice-select mb-10" name="method">
                                <option selected disabled>Select Method</option>
                                <?php $__currentLoopData = $selectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if($old_value == $value): ?>
                                        <?php if(true): echo 'selected'; endif; ?>
                                    <?php endif; ?>><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="pusher-view input-field-group" style="display: none">
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Instance ID*",
                                    'name'          => "instance_id",
                                    'value'         => old("instance_id", $push_notification->instance_id ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Primary key*",
                                    'name'          => "primary_key",
                                    'value'         => old("primary_key", $push_notification->primary_key ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.push.notification.update",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="custom-card mt-3">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Broadcasting/ Internal Notification Configuration")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="<?php echo e(setRoute('admin.broadcast.config.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            <label><?php echo e(__("Method*")); ?></label>
                            <?php
                                $selectOptions = ['pusher' => "Pusher (Message Bird)"];
                                $old_value = old('broadcast_method',$broadcast_config->method ?? "");
                            ?>
                            <select class="form--control nice-select mb-10" name="broadcast_method">
                                <option selected disabled>Select Method</option>
                                <?php $__currentLoopData = $selectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if($old_value == $value): ?>
                                        <?php if(true): echo 'selected'; endif; ?>
                                    <?php endif; ?>><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="pusher-view input-field-group" style="display: none">
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "APP ID*",
                                    'name'          => "broadcast_app_id",
                                    'value'         => old("broadcast_app_id", $broadcast_config->app_id ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Primary key*",
                                    'name'          => "broadcast_primary_key",
                                    'value'         => old("broadcast_primary_key", $broadcast_config->primary_key ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Secret key*",
                                    'name'          => "broadcast_secret_key",
                                    'value'         => old("broadcast_secret_key", $broadcast_config->secret_key ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'         => "Cluster*",
                                    'name'          => "broadcast_cluster",
                                    'value'         => old("broadcast_cluster", $broadcast_config->cluster ?? ""),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.broadcast.config.update",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $("select[name=method],select[name=broadcast_method]").change(function(){
            var selectedValue = $(this).val();
            $(this).parents("form").find(".input-field-group").slideUp(300);
            $(this).parents("form").find("."+selectedValue+"-view").delay(300).slideDown();
        });
        $(document).ready(function(){
            var selectedMethod = $("select[name=method] :selected").val();
            $("select[name=method]").parents("form").find("."+selectedMethod+"-view").slideDown();

            var selectedMethodTwo = $("select[name=broadcast_method] :selected").val();
            $("select[name=broadcast_method]").parents("form").find("."+selectedMethodTwo+"-view").slideDown();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/push-notification/config.blade.php ENDPATH**/ ?>