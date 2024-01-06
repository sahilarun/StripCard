<?php if(isset($gateway)): ?>
    <div class="gateway-content">
        <h3 class="title"><?php echo e($gateway->title); ?></h3>
        <p><?php echo e(__("Global Setting for")); ?> <?php echo e($gateway->alias); ?> <?php echo e(__("in bellow")); ?></p>
    </div>
    <?php $__currentLoopData = $gateway->credentials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group">
            <label><?php echo e($item->label); ?></label>
            <input type="text" class="form--control" placeholder="<?php echo e($item->placeholder); ?>" name="<?php echo e($item->name); ?>" value="<?php echo e($item->value); ?>">
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/admin/components/payment-gateway/automatic/credentials.blade.php ENDPATH**/ ?>