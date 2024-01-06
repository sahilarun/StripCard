<table class="custom-table user-search-table">
    <thead>
        <tr>
            <th></th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Email Verification</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <ul class="user-list">
                        <li><img src="<?php echo e($item->userImage); ?>" alt="user"></li>
                    </ul>
                </td>
                <td><span><?php echo e($item->fullname); ?></span></td>
                <td><?php echo e($item->email); ?></td>
                <td>
                    <span class="<?php echo e($item->emailStatus->class); ?>"><?php echo e($item->emailStatus->value); ?></span>
                </td>
                <td>
                    <?php if(Route::currentRouteName() == "admin.users.kyc.unverified"): ?>
                        <span class="<?php echo e($item->kycStringStatus->class); ?>"><?php echo e($item->kycStringStatus->value); ?></span>
                    <?php else: ?>
                        <span class="<?php echo e($item->stringStatus->class); ?>"><?php echo e($item->stringStatus->value); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(Route::currentRouteName() == "admin.users.kyc.unverified"): ?>
                        <?php echo $__env->make('admin.components.link.info-default',[
                            'href'          => setRoute('admin.users.kyc.details', $item->username),
                            'permission'    => "admin.users.kyc.details",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('admin.components.link.info-default',[
                            'href'          => setRoute('admin.users.details', $item->username),
                            'permission'    => "admin.users.details",
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php echo $__env->make('admin.components.alerts.empty',['colspan' => 7], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/data-table/user-table.blade.php ENDPATH**/ ?>