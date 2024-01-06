<?php if(isset($label)): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo e($label); ?></label>
<?php endif; ?>

<?php if(isset($currency) && $currency != false): ?>
    <div class="input-group">
        <input type="number" placeholder="<?php echo e($placeholder ?? "Type Here..."); ?>" name="<?php echo e($name ?? ""); ?>" class="<?php echo e($class ?? "form--control"); ?> <?php $__errorArgs = [$name ?? false];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e($attribute ?? ""); ?> value="<?php echo e($value ?? ""); ?>" <?php if(isset($data_limit)): ?>
        data-limit = <?php echo e($data_limit); ?>

        <?php endif; ?>>
        <span class="input-group-text currency"><?php echo e($currency); ?></span>
    </div>
<?php else: ?>
    <input type="number" placeholder="<?php echo e($placeholder ?? "Type Here..."); ?>" name="<?php echo e($name ?? ""); ?>" class="<?php echo e($class ?? "form--control"); ?> <?php $__errorArgs = [$name ?? false];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" <?php echo e($attribute ?? ""); ?> value="<?php echo e($value ?? ""); ?>" <?php if(isset($data_limit)): ?>
    data-limit = <?php echo e($data_limit); ?>

    <?php endif; ?> step="any">
<?php endif; ?>

<?php $__errorArgs = [$name ?? false];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span class="invalid-feedback" role="alert">
        <strong><?php echo e($message); ?></strong>
    </span>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/form/input-amount.blade.php ENDPATH**/ ?>