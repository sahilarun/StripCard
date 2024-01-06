<?php if(admin_permission_by_name("admin.app.settings.onboard.screen.store")): ?>
    <div id="onboard-screen-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__("Add New Screen")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.app.settings.onboard.screen.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row mb-10-none">
                        <div class="card-body">
                            <div class="row mb-10-none">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 form-group">
                                    <?php echo $__env->make('admin.components.form.input-file',[
                                        'label'             => 'Image: <span class="text--danger">(577*433)</span>',
                                        'class'             => "file-holder",
                                        'name'              => "image",
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-6">

                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Title",
                                            'name'      => "title",
                                            'attribute' => "data-limit=120",
                                            'value'     => old('title'),
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input',[
                                            'label'     => "Sub Title",
                                            'name'      => "sub_title",
                                            'attribute' => "data-limit=255",
                                            'value'     => old('sub_title'),
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close"><?php echo e(__("Cancel")); ?></button>
                            <button type="submit" class="btn btn--base"><?php echo e(__("Add")); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script'); ?>
        <script>
            openModalWhenError("onboard-screen-add","#onboard-screen-add");
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/modals/add-onboard-screen.blade.php ENDPATH**/ ?>