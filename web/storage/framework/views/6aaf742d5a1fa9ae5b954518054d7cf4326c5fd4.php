<?php if(isset($label) && $label != false): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo $label ?? ""; ?></label>
<?php endif; ?>
<input type="file" class="<?php echo e($class ?? ""); ?>" name="<?php echo e($name ?? ""); ?>" accept="<?php echo e($accept ?? "image/*"); ?>" 
    <?php if(isset($old_files) && $old_files != ""): ?>
        data-preview-name= "<?php echo e($old_files); ?>"
    <?php endif; ?>
    <?php if(isset($old_files_path) && $old_files_path != ""): ?>
        data-preview-path="<?php echo e($old_files_path); ?>"
    <?php endif; ?>
<?php echo e($attribute ?? ""); ?> id="<?php echo e($for_id ?? ""); ?>">
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
unset($__errorArgs, $__bag); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/form/input-file.blade.php ENDPATH**/ ?>