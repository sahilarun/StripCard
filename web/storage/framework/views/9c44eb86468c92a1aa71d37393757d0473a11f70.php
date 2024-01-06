<?php if(isset($permission)): ?>
    <?php if(admin_permission_by_name($permission)): ?>
        <button type="<?php echo e($type ?? "button"); ?>" class="btn btn--base <?php echo e($class ?? ""); ?>"><?php if(isset($icon)): ?><i class="<?php echo e($icon); ?>"></i><?php endif; ?> <?php echo e(__($text ?? "")); ?></button>
    <?php endif; ?>
<?php else: ?>
    <button type="<?php echo e($type ?? "button"); ?>" class="btn btn--base <?php echo e($class ?? ""); ?>"><?php if(isset($icon)): ?><i class="<?php echo e($icon); ?>"></i><?php endif; ?> <?php echo e(__($text ?? "")); ?></button>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/button/custom.blade.php ENDPATH**/ ?>