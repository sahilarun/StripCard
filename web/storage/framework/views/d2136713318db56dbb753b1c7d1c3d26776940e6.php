

<?php $__env->startPush('css'); ?>
    <style>
        .fileholder {
            min-height: 300px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 256px !important;
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
    ], 'active' => __("Money Out")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(setRoute('admin.payment.gateway.update',['money-out','manual',$payment_gateway->alias])); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field("PUT"); ?>
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title"><?php echo e($page_title); ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-10-none">
                <div class="col-xl-3 col-lg-3 form-group">
                    <?php echo $__env->make('admin.components.form.input-file',[
                        'label'             => "Gateway Image",
                        'name'              => "image",
                        'class'             => "file-holder",
                        'old_files_path'    => files_asset_path('payment-gateways'),
                        'old_files'         => $payment_gateway->image,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-xl-9 col-lg-9">
                    <div class="form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Gateway Name*",
                            'name'          => "gateway_name",
                            'value'         => old('gateway_name',$payment_gateway->name),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Currency Code*",
                            'name'          => "currency_code",
                            'value'         => old('currency_code',$payment_gateway->currencies->first()->currency_code),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $__env->make('admin.components.form.input',[
                            'label'         => "Currency Symbol*",
                            'name'          => "currency_symbol",
                            'value'         => old('currency_symbol',$payment_gateway->currencies->first()->currency_symbol),
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-card mt-15">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-10">
                    <div class="custom-inner-card">
                        <div class="card-inner-header">
                            <h5 class="title"><?php echo e(__("Amount Limit")); ?></h5>
                        </div>
                        <div class="card-inner-body">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input-amount',[
                                            'label'         => "Minimum*",
                                            'name'          => "min_limit",
                                            'value'         => old("min_limit",$payment_gateway->currencies->first()->min_limit),
                                            'currency'      => $payment_gateway->currencies->first()->currency_code,     
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input-amount',[
                                            'label'         => "Maximum*",
                                            'name'          => "max_limit",
                                            'value'         => old("max_limit",$payment_gateway->currencies->first()->max_limit),
                                            'currency'      => $payment_gateway->currencies->first()->currency_code,     
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 mb-10">
                    <div class="custom-inner-card">
                        <div class="card-inner-header">
                            <h5 class="title"><?php echo e(__("Charge")); ?></h5>
                        </div>
                        <div class="card-inner-body">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input-amount',[
                                            'label'         => "Fixed*",
                                            'name'          => "fixed_charge",
                                            'value'         => old("fixed_charge",$payment_gateway->currencies->first()->fixed_charge),
                                            'currency'      => $payment_gateway->currencies->first()->currency_code,     
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="form-group">
                                        <?php echo $__env->make('admin.components.form.input-amount',[
                                            'label'         => "Percent*",
                                            'name'          => "percent_charge",
                                            'value'         => old("percent_charge",$payment_gateway->currencies->first()->percent_charge),
                                            'currency'      => $payment_gateway->currencies->first()->currency_code,    
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 mb-10">
                    <div class="custom-inner-card">
                        <div class="card-inner-header">
                            <h5 class="title"><?php echo e(__("Rate")); ?></h5>
                        </div>
                        <div class="card-inner-body">
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 form-group">
                                    <div class="form-group">
                                        <label><?php echo e(__("Rate")); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text append ">1 &nbsp; <span class="default-currency"><?php echo e(get_default_currency_code($default_currency)); ?></span>&nbsp; = </span>
                                            <input type="number" class="form--control" value="<?php echo e(old("rate",$payment_gateway->currencies->first()->rate)); ?>" name="rate" placeholder="Type Here...">
                                            <span class="input-group-text currency"><?php echo e($payment_gateway->currencies->first()->currency_code); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    <?php echo $__env->make('admin.components.form.input-text-rich',[
                        'label'     => "Instruction*",
                        'name'      => "desc",
                        'value'     => old("desc",$payment_gateway->desc),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-xl-12 col-lg-12 form-group">
                    <div class="custom-inner-card input-field-generator" data-source="manual_gateway_input_fields">
                        <div class="card-inner-header">
                            <h6 class="title"><?php echo e(__("Collect Data")); ?></h6>
                            <button type="button" class="btn--base add-row-btn"><i class="fas fa-plus"></i> <?php echo e(__("Add")); ?></button>
                        </div>
                        <div class="card-inner-body">
                            <div class="results">
                                <?php $__currentLoopData = $payment_gateway->input_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row add-row-wrapper align-items-end">
                                        <div class="col-xl-3 col-lg-3 form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Field Name*",
                                                'name'      => "label[]",
                                                'attribute' => "required",
                                                'value'     => $item->label,
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 form-group">
                                            <?php
                                                $selectOptions = ['text' => "Input Text", 'file' => "File", 'textarea' => "Textarea"];
                                            ?>
                                            <label><?php echo e(__("Field Types*")); ?></label>
                                            <select class="form--control nice-select field-input-type" name="input_type[]" data-old="<?php echo e($item->type); ?>" data-show-db="true">
                                                <?php $__currentLoopData = $selectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e(($key == $item->type) ? "selected" : ""); ?>><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
    
                                        <div class="field_type_input col-lg-4 col-xl-4">
                                            <?php if($item->type == "file"): ?>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'         => "Max File Size (mb)*",
                                                            'name'          => "file_max_size[]",
                                                            'type'          => "number",
                                                            'attribute'     => "required",
                                                            'value'         => old('file_max_size[]',$item->validation->max),
                                                            'placeholder'   => "ex: 10",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'         => "File Extension*",
                                                            'name'          => "file_extensions[]",
                                                            'attribute'     => "required",
                                                            'value'         => old('file_extensions[]',implode(",",$item->validation->mimes)),
                                                            'placeholder'   => "ex: jpg, png, pdf",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'         => "Min Character*",
                                                            'name'          => "min_char[]",
                                                            'type'          => "number",
                                                            'attribute'     => "required",
                                                            'value'         => old('min_char[]',$item->validation->min),
                                                            'placeholder'   => "ex: 6",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 form-group">
                                                        <?php echo $__env->make('admin.components.form.input',[
                                                            'label'         => "Max Character*",
                                                            'name'          => "max_char[]",
                                                            'type'          => "number",
                                                            'attribute'     => "required",
                                                            'value'         => old('max_char[]',$item->validation->max),
                                                            'placeholder'   => "ex: 16",
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
    
                                        <div class="col-xl-2 col-lg-2 form-group">
                                            <?php echo $__env->make('admin.components.form.switcher',[
                                                'label'     => "Field Necessity*",
                                                'name'      => "field_necessity[]",
                                                'options'   => ['Required' => 1,'Optional' => 0],
                                                'value'     => old("field_necessity[]",$item->required),
                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 form-group">
                                            <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100 btn-loading"><i class="las la-times"></i></button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10-none">
                <div class="col-xl-12 col-lg-12 form-group">
                    <?php echo $__env->make('admin.components.button.form-btn',[
                        'class'          => "w-100",
                        'text'           => "Update",
                        'permission'     => "admin.payment.gateway.update",
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/sections/payment-gateways/money-out/manual/edit.blade.php ENDPATH**/ ?>