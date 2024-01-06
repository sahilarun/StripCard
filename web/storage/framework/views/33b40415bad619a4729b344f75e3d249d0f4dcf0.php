<?php if(isset($label)): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo $label; ?></label>
<?php endif; ?>

<textarea class="<?php echo e($class ?? "form--control"); ?>" placeholder="<?php echo e($placeholder ?? "Type Here..."); ?>" name="<?php echo e($name ?? ""); ?>" <?php echo e($attribute ?? ""); ?> <?php if(isset($data_limit)): ?>
    data-limit="<?php echo e($data_limit); ?>"
<?php endif; ?>><?php echo e($value ?? ""); ?></textarea>

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
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/form/textarea.blade.php ENDPATH**/ ?>