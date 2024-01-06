<?php if(isset($links) && is_array($links)): ?>
    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(admin_permission_by_name($item['route'])): ?>
            <li><a href="<?php echo e(setRoute($item['route'])); ?>"><?php echo $item['title']; ?></a></li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH F:\xampp-8.0\htdocs\Project-Modify\stripe-card\resources\views/admin/components/side-nav-mini/support/link.blade.php ENDPATH**/ ?>