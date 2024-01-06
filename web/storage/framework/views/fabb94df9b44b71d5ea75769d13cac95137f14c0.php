<?php if(isset($gateway)): ?>
    <div class="gateway-content text-end">
        <h5 class="title"><?php echo e(__("Total Supported Currency")); ?></h5>
    </div>

    <div class="custom-checkbox-area">
        <?php $__currentLoopData = $gateway->supported_currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="custom-check-group two">
            <input type="checkbox" id="<?php echo e(Str::lower($item)); ?>" class="payment-gateway-currency" data-currency="<?php echo e($item); ?>" data-default-currency="<?php echo e(get_default_currency_code($default_currency)); ?>" <?php echo e($option ?? ""); ?> <?php if($gateway->currencies->where('currency_code',$item)->count() == 1): ?> checked <?php endif; ?>>
            <label for="<?php echo e(Str::lower($item)); ?>"><?php echo e($item); ?></label>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/admin/components/payment-gateway/automatic/supported-currencies.blade.php ENDPATH**/ ?>