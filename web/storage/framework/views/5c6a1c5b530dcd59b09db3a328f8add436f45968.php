
<?php if(isset($label)): ?>
    <?php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', Str::lower($label));
    ?>
    <label for="<?php echo e($for_id ?? ""); ?>"><?php echo e($label ?? ""); ?></label>
<?php endif; ?>

<?php if($options): ?>
    <?php if(isset($permission)): ?>
        <?php if(admin_permission_by_name($permission) == false): ?>
            <?php
                $clickable = false;
                $onload = false;
                $data_target = "";
            ?>
        <?php endif; ?>
    <?php endif; ?>
    <div class="toggle-container">
        <?php
            $first_item = array_values($options)[0];
        ?>
        <div data-clickable="<?php if(isset($clickable) && $clickable == false): ?><?php echo e("false"); ?><?php else: ?> <?php echo e("true"); ?> <?php endif; ?>" class="switch-toggles <?php echo e((isset($onload) && $onload == true) ? "btn-load" : "default"); ?> two
            <?php if(isset($value) && $value == $first_item): ?>
                <?php echo e("active"); ?>

            <?php endif; ?>
        ">
            <input type="hidden" name="<?php echo e($name ?? ""); ?>" value="<?php echo e($value ?? ""); ?>" <?php echo e($attribute ?? ""); ?>

                <?php if(isset($data_target)): ?>
                    data-target="<?php echo e($data_target); ?>"
                <?php endif; ?>
            >
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="switch <?php echo e((isset($onload) && $onload == true) ? "btn-loading event-ready" : ""); ?>" data-value="<?php echo e($value); ?>"><?php echo e($item); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\full_project\resources\views/admin/components/form/switcher.blade.php ENDPATH**/ ?>