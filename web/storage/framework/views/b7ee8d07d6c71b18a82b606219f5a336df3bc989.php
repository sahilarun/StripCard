<?php
    $current_route = Route::currentRouteName();
?>
<?php if(isset($group_links) && is_array($group_links)): ?>

    <?php if(isset($group_links['dropdown']) && count($group_links['dropdown']) > 0): ?>

        <?php
            $title_permission = false;
            $dropdown_items = [];
        ?>
        <?php $__currentLoopData = $group_links['dropdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item['links']) && count($item['links']) > 0): ?>
                <?php
                    $routes = Arr::pluck($item['links'],"route");
                    $access_permission = admin_permission_by_name_array($routes);
                    if($access_permission == true) {
                        $title_permission = true;

                        $dropdown_items[] = [
                            'title'     => $item['title'],
                            'links'     => $item['links'],
                            'routes'    => $routes,
                            'icon'      => $item['icon'] ?? "",
                        ];
                    }
                ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($title_permission === true): ?>
            <li class="sidebar-menu-header"><?php echo e($group_title ?? ""); ?></li>
        <?php endif; ?>

        <?php $__currentLoopData = $dropdown_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="sidebar-menu-item sidebar-dropdown <?php if(in_array($current_route,$item['routes'])): ?> active <?php endif; ?>">
                <a href="javascript:void(0)">
                    <i class="<?php echo e($item['icon'] ?? ""); ?>"></i>
                    <span class="menu-title"><?php echo e($item['title'] ?? ""); ?></span>
                </a>
                <ul class="sidebar-submenu">
                    <li class="sidebar-menu-item">
                        <?php $__currentLoopData = $item['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('admin.components.side-nav.dropdown-link',[
                                'title'         => $nav_item['title'],
                                'route'         => $nav_item['route'],
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </li>
                </ul>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <?php
            $routes = Arr::pluck($group_links,"route");
            $access_permission = admin_permission_by_name_array($routes);
        ?>

        <?php if(isset($access_permission) && $access_permission === true): ?>
            <?php if(isset($group_title)): ?>
                <li class="sidebar-menu-header"><?php echo e($group_title); ?></li>
            <?php endif; ?>
            <?php $__currentLoopData = $group_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('admin.components.side-nav.link',[
                    'title'     => $item['title'],
                    'route'     => $item['route'],
                    'icon'      => $item['icon'],
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/side-nav/link-group.blade.php ENDPATH**/ ?>