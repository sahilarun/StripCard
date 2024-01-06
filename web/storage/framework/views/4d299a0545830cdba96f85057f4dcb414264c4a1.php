<?php if($basic_settings->kyc_verification == true && isset($user_kyc) && $user_kyc != null && $user_kyc->fields != null): ?>
    <h3 class="title"><?php echo e(__("KYC Information")); ?> &nbsp; <span class="<?php echo e(auth()->user()->kycStringStatus->class); ?>"><?php echo e(auth()->user()->kycStringStatus->value); ?></span></h3>

    <?php if(auth()->user()->kyc_verified == global_const()::PENDING): ?>
        <div class="pending text--warning kyc-text">Your KYC information is submited. Please wait for admin confirmation. When you are KYC verified you will show your submited information here.</div>
    <?php elseif(auth()->user()->kyc_verified == global_const()::APPROVED): ?>
        <div class="approved text--success kyc-text">Your KYC information is verified</div>
        <ul class="kyc-data">
            <?php $__currentLoopData = auth()->user()->kyc->data ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php if($item->type == "file"): ?>
                        <?php
                            $file_link = get_file_link("kyc-files",$item->value);
                        ?>
                        <span class="kyc-title"><?php echo e($item->label); ?>:</span>
                        <?php if(its_image($item->value)): ?>
                            <div class="kyc-image">
                                <img src="<?php echo e($file_link); ?>" alt="<?php echo e($item->label); ?>">
                            </div>
                        <?php else: ?>
                            <span class="text--danger">
                                <?php
                                    $file_info = get_file_basename_ext_from_link($file_link);
                                ?>
                                <a href="<?php echo e(setRoute('file.download',["kyc-files",$item->value])); ?>" >
                                    <?php echo e(Str::substr($file_info->base_name ?? "", 0 , 20 ) ."..." . $file_info->extension ?? ""); ?>

                                </a>
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="kyc-title"><?php echo e($item->label); ?>:</span>
                        <span><?php echo e($item->value); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php elseif(auth()->user()->kyc_verified == global_const()::REJECTED): ?>
        <div class="unverified text--danger kyc-text d-flex align-items-center justify-content-between mb-4">
            <div class="title text--warning"><?php echo e(__("Your KYC information is rejected.")); ?></div>
            <a href="<?php echo e(setRoute('user.authorize.kyc')); ?>" class="btn--base"><?php echo e(__("Verify KYC")); ?></a>
        </div>
        <div class="rejected">
            <div class="rejected-reason"><?php echo e(auth()->user()->kyc->reject_reason ?? ""); ?></div>
        </div>
    <?php else: ?>
    <p><?php echo e(__("Please submit your KYC information with valid data.")); ?></p>
    <form action="<?php echo e(setRoute('user.authorize.kyc.submit')); ?>" class="account-form" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row ml-b-20">

            <?php echo $__env->make('user.components.generate-kyc-fields',['fields' => $kyc_fields], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-lg-12 form-group">
                <div class="forgot-item">
                    <label><?php echo e(__("Back to ")); ?><a href="<?php echo e(setRoute('user.dashboard')); ?>" class="text--base"><?php echo e(__("Dashboard")); ?></a></label>
                </div>
            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" class="btn--base w-100"><?php echo e(__("Submit")); ?></button>
            </div>
        </div>
    </form>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\stripe_card\resources\views/user/components/profile/kyc.blade.php ENDPATH**/ ?>