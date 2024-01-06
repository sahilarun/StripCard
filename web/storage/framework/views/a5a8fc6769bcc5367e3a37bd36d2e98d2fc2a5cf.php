<div class="right">
    <div class="dashboard-path">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="main-path"><a href="<?php echo e($item['url']); ?>"><?php echo e($item['name']); ?></a></span>
            <i class="las la-angle-right"></i>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <span class="active-path"><?php echo e($active ?? ""); ?></span>
    </div>
</div><?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/breadcrumb.blade.php ENDPATH**/ ?>