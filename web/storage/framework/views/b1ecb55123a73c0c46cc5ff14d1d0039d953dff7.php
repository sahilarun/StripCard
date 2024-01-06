<div class="pass-wrapper show_hide_password">
    <?php if(isset($label)): ?>
        <?php
            $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
        ?>
        <label for="<?php echo e($for_id ?? ""); ?>"><?php echo $label; ?></label>
    <?php endif; ?>
    <input type="password" class="form--control <?php echo e($class ?? ""); ?>" title="<?php echo e($title ?? ""); ?>" <?php if(isset($required)): ?> required <?php endif; ?> name="<?php echo e($name ?? ""); ?>" placeholder="<?php echo e($placeholder ?? "Type Here..."); ?>" value="<?php echo e($value ?? ""); ?>">

    <span class="show-pass"><i class="fa fa-eye-slash"></i></span>
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
unset($__errorArgs, $__bag); ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/form/input-password.blade.php ENDPATH**/ ?>