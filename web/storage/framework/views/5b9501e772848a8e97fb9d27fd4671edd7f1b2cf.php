<?php if(isset($label)): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo e($label); ?></label>
<?php endif; ?>
<select id="<?php echo e($for_id ?? ""); ?>" name="<?php echo e($name ?? ""); ?>" class="form-control <?php echo e($class ?? ""); ?>"  <?php if($multiple): ?> multiple <?php endif; ?> <?php echo e($attribute ?? ""); ?>>

</select><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/form/select.blade.php ENDPATH**/ ?>