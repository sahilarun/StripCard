<?php if(isset($permission)): ?>
    <?php if(admin_permission_by_name($permission)): ?>
        <a href="<?php echo e($href ?? "javascript:void(0)"); ?>" class="<?php echo e($class ?? ""); ?>"><i class="<?php echo e($icon ?? ""); ?>"></i><?php echo e(__($text ?? "")); ?></a>
    <?php endif; ?>
<?php else: ?>
    <a href="<?php echo e($href ?? "javascript:void(0)"); ?>" class="<?php echo e($class ?? ""); ?>"><i class="<?php echo e($icon ?? ""); ?>"></i><?php echo e(__($text ?? "")); ?></a>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/link/custom.blade.php ENDPATH**/ ?>