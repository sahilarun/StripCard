<?php if(isset($fields) && count($fields) > 0): ?>
    <?php $__currentLoopData = $kyc_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($item->type == "select"): ?>
            <div class="col-lg-12 form-group">
                <label for="<?php echo e($item->name); ?>"><?php echo e($item->label); ?></label>
                <select name="<?php echo e($item->name); ?>" id="<?php echo e($item->name); ?>" class="form--control nice-select">
                    <option selected disabled>Choose One</option>
                    <?php $__currentLoopData = $item->validation->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innerItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($innerItem); ?>"><?php echo e($innerItem); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = [$item->name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        <?php elseif($item->type == "file"): ?>
            <div class="col-lg-12 form-group">
                <?php echo $__env->make('admin.components.form.input',[
                    'label'     => $item->label,
                    'name'      => $item->name,
                    'type'      => $item->type,
                    'value'     => old($item->name),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php elseif($item->type == "text"): ?>
            <div class="col-lg-12 form-group">
                <?php echo $__env->make('admin.components.form.input',[
                    'label'     => $item->label,
                    'name'      => $item->name,
                    'type'      => $item->type,
                    'value'     => old($item->name),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php elseif($item->type == "textarea"): ?>
            <div class="col-lg-12 form-group">
                <?php echo $__env->make('admin.components.form.textarea',[
                    'label'     => $item->label,
                    'name'      => $item->name,
                    'value'     => old($item->name),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/components/generate-kyc-fields.blade.php ENDPATH**/ ?>