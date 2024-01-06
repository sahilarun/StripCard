<?php
    if(isset($label)) {
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    }
?>
<label>Role*</label>
<div class="radio-form-group">
    <?php if($options): ?>

        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $input_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="radio-wrapper">
                <input type="radio" id="<?php echo e($item); ?>" name="<?php echo e($name ?? ""); ?>" class="<?php echo e($class ?? "form--control"); ?>" value="<?php echo e($input_value ?? ""); ?>" 
                    <?php if(isset($value) && $value == $input_value): ?>
                        <?php echo e("checked"); ?>

                    <?php endif; ?>
                >
                <label for="<?php echo e($item); ?>"><?php echo e($item); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php $__errorArgs = [$name ?? false];
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
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/form/radio-button.blade.php ENDPATH**/ ?>