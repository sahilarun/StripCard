<?php if(isset($permission)): ?>
    <?php if(admin_permission_by_name($permission)): ?>  
        <button type="<?php echo e($type ?? "submit"); ?>" class="btn--base <?php echo e($class ?? ""); ?>"><?php echo e(__($text ?? "")); ?></button>
    <?php endif; ?>
<?php else: ?>
    <button type="<?php echo e($type ?? "submit"); ?>" class="btn--base <?php echo e($class ?? ""); ?>"><?php echo e(__($text ?? "")); ?></button>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/button/form-btn.blade.php ENDPATH**/ ?>