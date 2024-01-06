

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 280px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 246px !important;
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
    ], 'active' => __("Admin Profile")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e(__("Admin Profile")); ?></h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" enctype="multipart/form-data" action="<?php echo e(setRoute('admin.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field("PUT"); ?>
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 form-group">
                        <?php echo $__env->make('admin.components.form.input-file',[
                            'label'             => "Profile Image:",
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files_path'    => files_asset_path('admin-profile'),
                            'old_files'         => $profile->image,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'First Name*',
                                'name'          => 'firstname',
                                'value'         => old('firstname',$profile->firstname),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Last Name*',
                                'name'          => 'lastname',
                                'value'         => old('lastname',$profile->lastname),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Email*',
                                'type'          => 'email',
                                'name'          => 'email',
                                'value'         => old('email',$profile->email),
                                'attribute'     => (!auth_is_super_admin()) ? "readonly" : "",
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Phone Number',
                                'name'          => 'phone',
                                'value'         => old('phone',$profile->phone),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <?php
                            $old_country = old('country',$profile->country);
                        ?>
                        <label><?php echo e(__("Country")); ?></label>
                        <select name="country" class="form--control select2-auto-tokenize country-select">
                            <option selected disabled>Select Country</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->name); ?>" data-id="<?php echo e($item->id); ?>" <?php echo e(($old_country == $item->name) ? "selected" : ""); ?>><?php echo e($item->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <?php
                            $old_state = old('state',$profile->state);
                        ?>
                        <label><?php echo e(__("State")); ?></label>
                        <select name="state" class="form--control select2-auto-tokenize state-select">
                            <option selected disabled>Select State</option>
                            <?php if($old_state): ?>
                                <option selected value="<?php echo e($old_state); ?>"><?php echo e($old_state); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <?php
                            $old_city = old('city',$profile->city);
                        ?>
                        <label><?php echo e(__("City")); ?></label>
                        <select name="city" class="form--control select2-auto-tokenize city-select">
                            <option selected disabled>Select City</option>
                            <?php if($old_city): ?>
                                <option selected value="<?php echo e($old_city); ?>"><?php echo e($old_city); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => 'Zip/Postal',
                            'type'          => 'number',
                            'name'          => 'zip_postal',
                            'value'         => old('zip_postal',$profile->zip_postal),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => 'Address',
                            'name'          => 'address',
                            'value'         => old('address',$profile->address),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <button type="submit" class="btn--base w-100 btn-loading"><?php echo e(__("Save & Change")); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            countrySelect(".country-select",$(".country-select").siblings(".select2"));
            stateSelect(".state-select",$(".state-select").siblings(".select2"));
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/sections/profile/index.blade.php ENDPATH**/ ?>