<?php if(isset($permission)): ?>
    <?php if(admin_permission_by_name($permission)): ?>
        <a href="<?php echo e($href ?? "javascript:void(0)"); ?>" class="btn btn--base btn--danger <?php echo e($class ?? ""); ?>"><i class="las la-trash-alt"></i></a>
    <?php endif; ?>
<?php else: ?>
    <a href="<?php echo e($href ?? "javascript:void(0)"); ?>" class="btn btn--base btn--danger <?php echo e($class ?? ""); ?>"><i class="las la-trash-alt"></i></a>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/link/delete-default.blade.php ENDPATH**/ ?>