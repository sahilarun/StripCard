<?php if(isset($label) && $label != false): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo e($label); ?></label>
<?php endif; ?>
<textarea name="<?php echo e($name ?? ""); ?>" class="rich-text-editor form--control d-none <?php echo e($class ?? ""); ?>"><?php echo $value ?? ""; ?></textarea><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/form/input-text-rich.blade.php ENDPATH**/ ?>