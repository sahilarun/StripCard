

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
    ], 'active' => __("Setup KYC")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(setRoute('admin.setup.kyc.update',$kyc->slug)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field("PUT"); ?>
        <div class="custom-card kyc-form input-field-generator" data-source="kyc_input_fields">
            <div class="card-header">
                <h6 class="title"><?php echo e(__("KYC Data Form")); ?></h6>
                <?php echo $__env->make('admin.components.button.custom',[
                    'type'          => "button",
                    'class'         => "add-row-btn",
                    'text'          => "Add",
                    'icon'          => "fas fa-plus",
                    'permission'    => "admin.setup.kyc.update",
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="card-body">
                <div class="results">
                    <?php $__currentLoopData = $kyc->fields ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row add-row-wrapper align-items-end">
                            <div class="col-xl-3 col-lg-3 form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'     => "Field Name*",
                                    'name'      => "label[]",
                                    'attribute' => "required",
                                    'value'     => old('label[]',$item->label),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-2 col-lg-2 form-group">
                                <?php
                                    $selectOptions = ['text' => "Input Text", 'file' => "File", 'textarea' => "Textarea",'select' => "Select"];
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
                                <?php elseif($item->type == "select"): ?>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 form-group">
                                            <?php echo $__env->make('admin.components.form.input',[
                                                'label'     => "Options*",
                                                'name'      => "select_options[]",
                                                'attribute' => "required=true",
                                                'value'     => old("select_options[]",implode(",",$item->validation->options)),
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
                                    'options'   => ['Required' => "1",'Optional' => "0"],
                                    'value'     => old("field_necessity[]",$item->required),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-1 col-lg-1 form-group">
                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if(count($kyc->fields ?? []) == 0): ?>
                        <div class="row add-row-wrapper align-items-end">
                            <div class="col-xl-3 col-lg-3 form-group">
                                <?php echo $__env->make('admin.components.form.input',[
                                    'label'     => "Field Name*",
                                    'name'      => "label[]",
                                    'attribute' => "required",
                                    'value'     => old('label[]'),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-2 col-lg-2 form-group">
                                <?php
                                    $selectOptions = ['text' => "Input Text", 'file' => "File", 'textarea' => "Textarea",'select' => "Select"];
                                ?>
                                <label><?php echo e(__("Field Types*")); ?></label>
                                <select class="form--control nice-select field-input-type" name="input_type[]" data-old="file">
                                    <?php $__currentLoopData = $selectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
            
                            <div class="field_type_input col-lg-4 col-xl-4">
            
                            </div>
            
                            <div class="col-xl-2 col-lg-2 form-group">
                                <?php echo $__env->make('admin.components.form.switcher',[
                                    'label'     => "Field Necessity*",
                                    'name'      => "field_necessity[]",
                                    'options'   => ['Required' => "1",'Optional' => "0"],
                                    'value'     => old("field_necessity[]","1"),
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <div class="col-xl-1 col-lg-1 form-group">
                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 form-group">
                        <?php echo $__env->make('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Save & Change",
                            'permission'    => "admin.setup.kyc.update",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/sections/setup-kyc/edit.blade.php ENDPATH**/ ?>