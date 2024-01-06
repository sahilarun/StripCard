<?php if(isset($gateway)): ?>
    <div class="payment-gateway-currencies-wrapper">
        <?php $__currentLoopData = $gateway->currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="custom-card mt-15 gateway-currency" id="<?php echo e(Str::lower($item->currency_code) . "-block"); ?>" data-target="<?php echo e($item->id); ?>">
                <div class="card-header">
                    <h6 class="currency-title"><?php echo e($item->name); ?></h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 form-group">
                            <?php echo $__env->make('admin.components.form.input-file',[
                                'label'             => "Gateway Image",
                                'name'              => "gateway_currency[".$item->currency_code."][image]",
                                'class'             => "file-holder",
                                'old_files_path'    => files_asset_path('payment-gateways'),
                                'old_files'         => $item->image,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="col-xl-3 col-lg-3 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title"><?php echo e(__("Amount Limit")); ?></h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input-amount',[
                                                    'label'         => "Minimum",
                                                    'name'          => "gateway_currency[".$item->currency_code."][min_limit]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".min_limit",$item->min_limit),
                                                    'currency'      => $item->currency_code,            
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input-amount',[
                                                    'label'         => "Maximum",
                                                    'name'          => "gateway_currency[".$item->currency_code."][max_limit]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".max_limit",$item->max_limit),
                                                    'currency'      => $item->currency_code,            
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title"><?php echo e(__("Charge")); ?></h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input-amount',[
                                                    'label'         => "Fixed",
                                                    'name'          => "gateway_currency[".$item->currency_code."][fixed_charge]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".fixed_charge",$item->fixed_charge),
                                                    'currency'      => $item->currency_code,          
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input-amount',[
                                                    'label'         => "Percent",
                                                    'name'          => "gateway_currency[".$item->currency_code."][percent_charge]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".percent_charge",$item->percent_charge),
                                                    'currency'      => "%",          
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title"><?php echo e(__("Rate")); ?></h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <label><?php echo e(__("Rate")); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-text append ">1 &nbsp; <span class="default-currency"><?php echo e(get_default_currency_code($default_currency)); ?></span> = </span>
                                                    <input type="number" class="form--control" value="<?php echo e(old("gateway_currency.".$item->currency_code.".rate",$item->rate)); ?>" name="<?php echo e("gateway_currency[".$item->currency_code."][rate]"); ?>">
                                                    <span class="input-group-text"><?php echo e($item->currency_code); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <?php echo $__env->make('admin.components.form.input',[
                                                    'label'     => "Symbol",
                                                    'name'      => "gateway_currency[".$item->currency_code."][currency_symbol]",
                                                    'value'     => old("gateway_currency.".$item->currency_code.".currency_symbol",$item->currency_symbol),
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/admin/components/payment-gateway/automatic/gateway-currency.blade.php ENDPATH**/ ?>