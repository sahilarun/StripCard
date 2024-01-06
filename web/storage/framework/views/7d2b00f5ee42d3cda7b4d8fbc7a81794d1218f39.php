<?php if(admin_permission_by_name("admin.currency.store")): ?>
    <div id="currency-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title"><?php echo e(__("Add Currency")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.currency.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label for="countryFlag"><?php echo e(__("Country Flag")); ?></label>
                            <div class="col-12 col-sm-3 m-auto">
                                <?php echo $__env->make('admin.components.form.input-file',[
                                    'label'         => false,
                                    'class'         => "file-holder m-auto",
                                    'name'          => "flag",
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Type*',
                                'name'          => 'type',
                                'value'         => old('type','FIAT'),
                                'options'       => ['FIAT' => 'FIAT','CRYPTO' => 'CRYPTO'],
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label><?php echo e(__("Country*")); ?></label>
                            <select name="country" class="form--control select2-auto-tokenize country-select" data-old="<?php echo e(old('country')); ?>">
                                <option selected disabled>Select Country</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Name*',
                                'name'          => 'name',
                                'value'         => old('name')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Code*',
                                'name'          => 'code',
                                'value'         => old('code')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Symbol*',
                                'name'          => 'symbol',
                                'value'         => old('symbol')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label><?php echo e(__("Rate*")); ?></label>
                            <div class="input-group">
                                <span class="input-group-text append">1 <?php echo e(get_default_currency_code()); ?> = </span>
                                <input type="number" class="form--control" value="<?php echo e(old('rate',0.00)); ?>" name="rate">
                                <span class="input-group-text selcted-currency"><?php echo e(old('code')); ?></span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.form.radio-button',[
                                'label'         => 'Role*',
                                'name'          => 'role',
                                'value'         => old('role','both'),
                                'options'       => ['Both' => 'both', 'Sender' => 'sender', 'Receiver' => 'receiver'],
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <?php echo $__env->make('admin.components.form.switcher',[
                                'label'         => 'Option*',
                                'name'          => 'option',
                                'value'         => old('option','optional'),
                                'options'       => ['Optional' => 'optional','Default' => 'default'],
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
            $(document).ready(function(){
                openModalWhenError("currency_add","#currency-add");
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/modals/add-currency.blade.php ENDPATH**/ ?>