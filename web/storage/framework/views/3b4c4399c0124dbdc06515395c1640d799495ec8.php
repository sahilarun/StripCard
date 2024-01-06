<?php $__env->startPush('css'); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Manual Withdraw Gateway")], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 mb-30">
                    <div class="deposit-form">
                        <div class="form-title text-center">
                            <h3 class="title"><?php echo e(__($page_title)); ?></h3>
                        </div>
                        <div class="row justify-content-center">

                             <div class="col-lg-12 mb-30">

                                <div class="dash-payment-item-wrapper">
                                    <div class="dash-payment-item active">
                                        <div class="dash-payment-title-area">

                                            <h5 class="title">
                                                <?php
                                                    echo @$gateway->desc;
                                                ?>
                                            </h5>
                                        </div>
                                        <div class="dash-payment-body">
                                            <form class="card-form" action="<?php echo e(setRoute("user.withdraw.confirm")); ?>" method="POST" enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <div class="row">
                                                    <?php $__currentLoopData = $gateway->input_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <?php if($item->type == "select"): ?>
                                                        <div class="col-lg-12 form-group">
                                                            <label for="<?php echo e($item->name); ?>"><?php echo e($item->label); ?>

                                                                <?php if($item->required == true): ?>
                                                                <span class="text-danger">*</span>
                                                                <?php else: ?>
                                                                <span class="">( Optional )</span>
                                                                <?php endif; ?>
                                                            </label>
                                                            <select name="<?php echo e($item->name); ?>" id="<?php echo e($item->name); ?>" class="form--control nice-select">
                                                                <option selected disabled>Choose One</option>
                                                                <?php $__currentLoopData = $item->validation->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innerItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($innerItem); ?>"><?php echo e($innerItem); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                            <?php $__errorArgs = [$item->name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong><?php echo e($message); ?></strong>
                                                                </span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    <?php elseif($item->type == "file"): ?>
                                                        <div class="col-lg-12 form-group">
                                                            <label for="<?php echo e($item->name); ?>"><?php echo e($item->label); ?>

                                                                <?php if($item->required == true): ?>
                                                                <span class="text-danger">*</span>
                                                                <?php else: ?>
                                                                <span class="">( Optional )</span>
                                                                <?php endif; ?>
                                                            </label>
                                                            <input type="<?php echo e($item->type); ?>" class="form--control"  name="<?php echo e($item->name); ?>" value="<?php echo e(old($item->name)); ?>">
                                                        </div>
                                                    <?php elseif($item->type == "text"): ?>
                                                        <div class="col-lg-12 form-group">
                                                            <label for="<?php echo e($item->name); ?>"><?php echo e($item->label); ?>

                                                                <?php if($item->required == true): ?>
                                                                <span class="text-danger">*</span>
                                                                <?php else: ?>
                                                                <span class="">( Optional )</span>
                                                                <?php endif; ?>
                                                            </label>
                                                            <input type="<?php echo e($item->type); ?>" class="form--control" placeholder="<?php echo e(ucwords(str_replace('_',' ', $item->name))); ?>" name="<?php echo e($item->name); ?>" value="<?php echo e(old($item->name)); ?>">
                                                        </div>
                                                    <?php elseif($item->type == "textarea"): ?>
                                                        <div class="col-lg-12 form-group">
                                                            <?php echo $__env->make('admin.components.form.textarea',[
                                                                'label'     => $item->label,
                                                                'name'      => $item->name,
                                                                'value'     => old($item->name),
                                                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-xl-12 col-lg-12">
                                                        <button type="submit" class="btn--base w-100 btn-loading"> <?php echo e(__("Confirm")); ?>


                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8">
                    <div class="deposit-form">
                        <div class="form-title text-center pb-4">
                            <h3 class="title"> <?php echo e(__("Payment Information")); ?></h3>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Enter Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="request-amount"><?php echo e(number_format(@$moneyOutData->amount,2 )); ?> <?php echo e(get_default_currency_code()); ?> </p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Exchange Rate")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="rate-show"><?php echo e(__("1")); ?> <?php echo e(get_default_currency_code()); ?> =  <?php echo e(number_format(@$moneyOutData->gateway_rate,2 )); ?> <?php echo e(@$moneyOutData->gateway_currency); ?></p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Fees & Charges")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="fees"><?php echo e(number_format(@$moneyOutData->base_cur_charge,4 )); ?> <?php echo e(get_default_currency_code()); ?></p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Conversion Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="conversionAmount"><?php echo e(number_format(@$moneyOutData->conversion_amount,4 )); ?> <?php echo e(@$moneyOutData->gateway_currency); ?></p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Will Get")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="will-get"><?php echo e(number_format(@$moneyOutData->will_get,4 )); ?> <?php echo e(@$moneyOutData->gateway_currency); ?></p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Total Payable Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="pay-in-total"><?php echo e(number_format(@$moneyOutData->payable,4 )); ?> <?php echo e(get_default_currency_code()); ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/user/sections/withdraw/preview.blade.php ENDPATH**/ ?>