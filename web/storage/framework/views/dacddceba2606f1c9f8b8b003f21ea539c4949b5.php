<?php if(admin_permission_by_name("admin.currency.update")): ?>
    <div id="currency-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title"><?php echo e(__("Edit Currency")); ?></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="<?php echo e(setRoute('admin.currency.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field("PUT"); ?>
                    <?php echo $__env->make('admin.components.form.hidden-input',[
                        'name'          => 'target',
                        'value'         => old('target'),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label for="countryFlag"><?php echo e(__("Country Flag")); ?></label>
                            <div class="col-12 col-sm-3 m-auto">
                                <?php echo $__env->make('admin.components.form.input-file',[
                                    'label'             => false,
                                    'class'             => "file-holder m-auto",
                                    'name'              => "currency_flag",
                                    'old_files_path'    => files_asset_path('currency-flag'),
                                    'old_files'         => old('old_flag'),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label><?php echo e(__("Country*")); ?></label>
                            <select name="currency_country" class="form--control select2-auto-tokenize country-select" data-old="<?php echo e(old('currency_country')); ?>">
                                <option selected disabled>Select Country</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Name*',
                                'name'          => 'currency_name',
                                'value'         => old('currency_name'),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Code*',
                                'name'          => 'currency_code',
                                'value'         => old('currency_code'),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            <?php echo $__env->make('admin.components.form.input',[
                                'label'         => 'Symbol*',
                                'name'          => 'currency_symbol',
                                'value'         => old('currency_symbol'),
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        
                        

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close"><?php echo e(__("Cancel")); ?></button>
                            <button type="submit" class="btn btn--base"><?php echo e(__("Update")); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush("script"); ?>
        <script>
            $(document).ready(function(){
                reloadAllCountries("select[name=currency_country]");
                openModalWhenError("currency_edit","#currency-edit");
                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                    var editModal = $("#currency-edit");

                    var readOnly = true;
                    if(oldData.type == "CRYPTO") {
                        readOnly = false;
                    }

                    editModal.find(".invalid-feedback").remove();
                    editModal.find(".form--control").removeClass("is-invalid");

                    editModal.find("form").first().find("input[name=target]").val(oldData.code);
                    editModal.find("input[name=currency_code]").val(oldData.code).prop("readonly",readOnly);
                    editModal.find("input[name=currency_name]").val(oldData.name).prop("readonly",readOnly);
                    editModal.find("input[name=currency_symbol]").val(oldData.symbol).prop("readonly",readOnly);
                    editModal.find("input[name=currency_rate]").val(oldData.rate);
                    editModal.find("input[name=currency_type]").val(oldData.type);
                    editModal.find("input[name=currency_flag]").attr("data-preview-name",oldData.flag);
                    editModal.find("input[name=currency_option]").val(oldData.option);
                    editModal.find(".selcted-currency-edit").text(oldData.code);
                    editModal.find("select[name=currency_country]").attr("data-old",oldData.country);

                    selectFormRadio("#currency-edit input[name=currency_role]",oldData.role);
                    reloadAllCountries("select[name=currency_country]");
                    fileHolderPreviewReInit("#currency-edit input[name=currency_flag]");
                    refreshSwitchers("#currency-edit");
                    openModalBySelector("#currency-edit");

                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/modals/edit-currency.blade.php ENDPATH**/ ?>