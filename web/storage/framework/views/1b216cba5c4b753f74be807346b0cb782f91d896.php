<div class="dashboard-path">
    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="main-path"><a href="<?php echo e($item['url']); ?>"><?php echo e($item['name']); ?></a></span>
        <?php if(request()->routeIs('user.dashboard')): ?>
        <?php else: ?>
        <i class="las la-angle-right" ></i>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if(request()->routeIs('user.dashboard')): ?>
    <?php else: ?>
    <?php
        $link = $link ??'';
    ?>
      <span class="active-path "><a href="<?php echo e($link != '' ? setRoute($link):"javascript:void(0)"); ?>"><?php echo e($active??""); ?></a></span>
    <?php endif; ?>
</div>



<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/user/components/breadcrumb.blade.php ENDPATH**/ ?>