<?php if(admin_permission_by_name("admin.languages.store")): ?>
    <div id="language-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title"><?php echo e(__("Add Language")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.languages.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row mb-10-none mt-2">
                        <div class="col-xl-6 col-lg-6 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Language Name*',
                                'name'          => 'name',
                                'value'         => old('name')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Language Code*',
                                'name'          => 'code',
                                'value'         => old('code')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

    <?php $__env->startPush("script"); ?>
        <script>
            openModalWhenError("language-add","#language-add");
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/modals/language/add.blade.php ENDPATH**/ ?>