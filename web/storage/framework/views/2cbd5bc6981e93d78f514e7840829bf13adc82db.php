<?php if(isset($support_ticket)): ?>
    <div class="support-profile-wrapper">
        <div class="support-profile-header">
            <div class="custom-check-group two mb-0">
                <?php if(Str::is("admin.*", Route::currentRouteName())): ?>
                    <input type="checkbox" <?php echo e($support_ticket->status == 1 ? 'disabled':''); ?> class="solve-checkbox" id="action" <?php if($support_ticket->status == support_ticket_const()::SOLVED): ?> <?php if(true): echo 'checked'; endif; ?> <?php endif; ?>>
                    <label for="action"><?php echo e(__("Mark as Solved")); ?></label>
                <?php else: ?>
                    <span class="<?php echo e($support_ticket->stringStatus->class); ?>"><?php echo e($support_ticket->stringStatus->value); ?></span>
                <?php endif; ?>
            </div>
            <div class="chat-cross-btn">
                <i class="las la-times"></i>
            </div>
        </div>
        <div class="support-profile-body">
            <h5 class="title"><?php echo e(__("Support Details")); ?></h5>
            <ul class="support-profile-list">
                <li><?php echo e(__("Subject")); ?> : <span><?php echo e($support_ticket->subject); ?></span></li>
                <li><?php echo e(__("Description")); ?> : <span><?php echo e($support_ticket->desc); ?></span></li>
                <?php $__currentLoopData = $support_ticket->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e(__("Attachments")); ?> - <?php echo e($key + 1); ?> :
                        <span class="text--danger">
                            <a href="<?php echo e(files_asset_path('support-attachment') . "/" . $item->attachment); ?>">
                                <?php echo e(Str::words($item->attachment_info->original_base_name ?? "", 5, '...' . $item->attachment_info->extension ?? "" )); ?>

                            </a>
                        </span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    <?php if($support_ticket->status != support_ticket_const()::SOLVED): ?>
        <?php $__env->startPush('script'); ?>
            <script>
                var target = "<?php echo e($support_ticket->token); ?>";
                $(".solve-checkbox").change(function() {
                    if($(this).is(":checked")) {
                        $(this).prop("checked",false);
                        var actionRoute =  "<?php echo e(setRoute('admin.support.ticket.solve')); ?>";
                        var message     = `Are you sure to mark as solved (Token: <strong>${target}</strong>)? Because it's not reversable.`;
                        openDeleteModal(actionRoute,target,message,"Solve","POST");
                    }
                });
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/admin/components/support-ticket/details.blade.php ENDPATH**/ ?>