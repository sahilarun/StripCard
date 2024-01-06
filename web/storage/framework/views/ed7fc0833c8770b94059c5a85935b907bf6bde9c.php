

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder-image {
            object-fit: contain;
        }

        .image-dark .fileholder-single-file-view {
            background: #bfbfbf;
        }

        .fileholder {
            min-height: 280px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 236px !important;
        }
    </style>
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
            <h6 class="title"><?php echo e(__($page_title)); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="<?php echo e(setRoute('admin.web.settings.image.assets.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group" style="height: 300px">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Logo (Light Version)",
                            'class'             => "file-holder",
                            'name'              => "site_logo",
                            'old_files'         => $basic_settings->site_logo,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group image-dark">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Logo (Dark Version)",
                            'class'             => "file-holder",
                            'name'              => "site_logo_dark",
                            'old_files'         => $basic_settings->site_logo_dark,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Favicon (Light Version)",
                            'class'             => "file-holder",
                            'name'              => "site_fav",
                            'old_files'         => $basic_settings->site_fav,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group image-dark">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Favicon (Dark Version)",
                            'class'             => "file-holder",
                            'name'              => "site_fav_dark",
                            'old_files'         => $basic_settings->site_fav_dark,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.web.settings.image.assets.update",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/web-settings/image-assets.blade.php ENDPATH**/ ?>