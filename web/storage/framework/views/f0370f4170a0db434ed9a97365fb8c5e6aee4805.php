<?php
    $current_route = Route::currentRouteName();
?>
<?php if(isset($route) && $route != ""): ?>
    <?php if(admin_permission_by_name($route)): ?>
        <li class="sidebar-menu-item <?php if($current_route == $route): ?> active <?php endif; ?>">
            <a href="<?php echo e(setRoute($route)); ?>">
                <i class="<?php echo e($icon ?? ""); ?>"></i>
                <span class="menu-title"><?php echo e($title ?? ""); ?></span>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/side-nav/link.blade.php ENDPATH**/ ?>