<?php
    $current_route = Route::currentRouteName();
?>
<?php if(isset($route) && $route != ""): ?>
    <?php if(admin_permission_by_name($route)): ?>
        <a href="<?php echo e(setRoute($route)); ?>" class="nav-link <?php if($current_route == $route): ?> active <?php endif; ?>">
            <i class="menu-icon las la-ellipsis-h"></i>
            <span class="menu-title"><?php echo e($title ?? ""); ?></span>
        </a>
    <?php endif; ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/admin/components/side-nav/dropdown-link.blade.php ENDPATH**/ ?>