

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
    ], 'active' => __("App Settings")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("App Urls")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="<?php echo e(setRoute('admin.app.settings.urls.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'             => "Title*",
                                'name'              => "url_title",
                                'value'             => old('url_title',$app_settings->url_title),
                                'attribute'         => "data-limit=255",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'             => "Android App URL*",
                                'name'              => "android_url",
                                'value'             => old('android_url',$app_settings->android_url),
                                'attribute'         => "data-limit=255",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'             => "iOS App URL",
                                'name'              => "iso_url",
                                'value'             => old('iso_url',$app_settings->iso_url),
                                'attribute'         => "data-limit=255",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <button type="submit" class="btn--base w-100 btn-loading"><?php echo e(__("Update")); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/app-settings/urls.blade.php ENDPATH**/ ?>