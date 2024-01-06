<?php if(isset($transactions)): ?>
    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="dashboard-list-item-wrapper">
            <div class="dashboard-list-item sent">
                <div class="dashboard-list-left">
                    <div class="dashboard-list-user-wrapper">
                        <div class="dashboard-list-user-icon">
                            <?php if($item->attribute == payment_gateway_const()::SEND): ?>
                            <i class="las la-dollar-sign"></i>
                            <?php else: ?>
                            <i class="las la-dollar-sign"></i>
                            <?php endif; ?>
                        </div>
                        <div class="dashboard-list-user-content">
                            <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                <h4 class="title"><?php echo e(__("Add Balance via")); ?> <span class="text--warning"><?php echo e($item->currency->name); ?></span></h4>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                                <h4 class="title"><?php echo e(__("Money Out")); ?> <span class="text--warning"><?php echo e($item->currency->gateway->name); ?></span></h4>
                            <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                <h4 class="title"><?php echo e(__("Bill Pay")); ?> <span class="text--warning">(<?php echo e(@$item->details->bill_type_name); ?>)</span></h4>
                            <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                <h4 class="title"><?php echo e(__("Mobile Topup")); ?> <span class="text--warning">(<?php echo e(@$item->details->topup_type_name); ?>)</span></h4>
                            <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                <h4 class="title"><?php echo e(__("Virtual Card")); ?> <span class="text--info">(<?php echo e(@$item->remark); ?>)</span></h4>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                <h4 class="title"><?php echo e(__("Exchange Money")); ?> <span class="text--warning"><?php echo e($item->details->request_currency); ?> To <?php echo e($item->details->exchange_currency); ?></span></h4>
                            <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                <h4 class="title"><?php echo e(__("Balance Update From Admin (".$item->user_wallet->currency->code.")")); ?> </h4>
                            <?php elseif($item->type == payment_gateway_const()::TYPETRANSFERMONEY): ?>
                                <?php if($item->isAuthUser()): ?>

                                    <?php if($item->attribute == payment_gateway_const()::SEND): ?>
                                        <h4 class="title"><?php echo e(__("Transfer Money to @" . @$item->details->receiver->username." (".@$item->details->receiver->email.")")); ?> </h4>
                                    <?php elseif($item->attribute == payment_gateway_const()::RECEIVED): ?>
                                        <h4 class="title"><?php echo e(__("Transfer Money from @" .@$item->details->sender->username." (".@$item->details->sender->email.")")); ?> </h4>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <span class="<?php echo e($item->stringStatus->class); ?>"><?php echo e($item->stringStatus->value); ?> </span>
                        </div>
                    </div>
                </div>
                <div class="dashboard-list-right">
                    <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                        <h4 class="main-money text--warning"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h4>
                        <h6 class="exchange-money fw-bold"><?php echo e(get_amount($item->payable,$item->user_wallet->currency->code)); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>

                        <h6 class="exchange-money text--warning fw-bold"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h6>
                        <h4 class="main-money "><?php echo e(get_amount($item->payable,$item->currency->currency_code)); ?></h4>
                    <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                        <h4 class="main-money text--warning"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h4>
                        <h6 class="exchange-money fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                        <h4 class="main-money text--warning"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h4>
                        <h6 class="exchange-money fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                        <h4 class="main-money text--warning"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h4>
                        <h6 class="exchange-money fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                        <h4 class="main-money text--base"><?php echo e(get_amount($item->request_amount,$item->user_wallet->currency->code)); ?></h4>
                        <h6 class="exchange-money"><?php echo e(get_amount($item->available_balance,$item->user_wallet->currency->code)); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                        <h4 class="main-money text--base"><?php echo e(get_amount($item->request_amount,$item->user_wallet->currency->code)); ?></h4>
                        <h6 class="exchange-money"><?php echo e(get_amount($item->available_balance,$item->user_wallet->currency->code)); ?></h6>
                    <?php elseif($item->type == payment_gateway_const()::TYPETRANSFERMONEY): ?>
                        <?php if($item->attribute == payment_gateway_const()::SEND): ?>
                        <h6 class="exchange-money text--warning "><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h6>
                        <h4 class="main-money fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></h4>
                        <?php elseif($item->attribute == payment_gateway_const()::RECEIVED): ?>
                        <h6 class="exchange-money fw-bold"><?php echo e(get_amount($item->request_amount,get_default_currency_code())); ?></h6>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="preview-list-wrapper">

                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="lab la-tumblr"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Transaction ID")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span><?php echo e($item->trx_id); ?></span>
                    </div>
                </div>
                <?php if($item->type != payment_gateway_const()::TYPETRANSFERMONEY ): ?>
                <?php if($item->type != payment_gateway_const()::BILLPAY ): ?>
                <?php if($item->type != payment_gateway_const()::MOBILETOPUP ): ?>
                <?php if($item->type != payment_gateway_const()::VIRTUALCARD ): ?>
                <div class="preview-list-item">

                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-exchange-alt"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Exchange Rate")); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="preview-list-right">
                        <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                            <span>1 <?php echo e(get_default_currency_code()); ?> = <?php echo e(get_amount($item->currency->rate,$item->currency->currency_code)); ?></span>
                        <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                            <span>1 <?php echo e(get_default_currency_code()); ?> = <?php echo e(get_amount($item->currency->rate,$item->currency->currency_code)); ?></span>
                        <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                            <span>1 <?php echo e($item->user_wallet->currency->code); ?> = <?php echo e(get_amount($item->details->exchange_rate,$item->details->exchange_currency)); ?></span>
                        <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                            <span>1 <?php echo e(get_default_currency_code()); ?> = <?php echo e(get_amount($item->user_wallet->currency->rate,$item->user_wallet->currency->code)); ?></span>

                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>

                <?php if($item->type == payment_gateway_const()::BILLPAY ): ?>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-balance-scale"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Bill Type")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="text--base"><?php echo e(@$item->details->bill_type_name); ?></span>
                    </div>
                </div>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-balance-scale"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Bill Number")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="text--base"><?php echo e(@$item->details->bill_number); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($item->type == payment_gateway_const()::MOBILETOPUP ): ?>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-balance-scale"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Topup Type")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="text--base"><?php echo e(@$item->details->topup_type_name); ?></span>
                    </div>
                </div>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="fas fa-mobile"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Mobile Number")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="text--base"><?php echo e(@$item->details->mobile_number); ?></span>
                    </div>
                </div>
                <?php endif; ?>


                <?php if($item->type == payment_gateway_const()::TYPETRANSFERMONEY): ?>
                    <?php if($item->attribute == payment_gateway_const()::SEND): ?>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-battery-half"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span><?php echo e(__("Fees & Charge")); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span><?php echo e(get_amount($item->charge->total_charge,$item->user_wallet->currency->code)); ?></span>
                            </div>
                        </div>
                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="lab la-get-pocket"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span><?php echo e(__("Recipient Received")); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span><?php echo e(get_amount($item->details->recipient_amount,get_default_currency_code())); ?></span>
                            </div>
                        </div>

                        <div class="preview-list-item">
                            <div class="preview-list-left">
                                <div class="preview-list-user-wrapper">
                                    <div class="preview-list-user-icon">
                                        <i class="las la-balance-scale"></i>
                                    </div>
                                    <div class="preview-list-user-content">
                                        <span><?php echo e(__("Current Balance")); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-list-right">
                                <span class="text--base"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-balance-scale"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Current Balance")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <span class="text--base"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-battery-half"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <span><?php echo e(__("Fees & Charge")); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,$item->currency->currency_code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,$item->currency->currency_code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                <span><?php echo e(get_amount($item->details->total_charge,$item->user_wallet->currency->code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                <span><?php echo e(get_amount($item->charge->total_charge,$item->user_wallet->currency->code)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($item->type != payment_gateway_const()::BILLPAY): ?>
                    <?php if($item->type != payment_gateway_const()::MOBILETOPUP): ?>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="lab la-get-pocket"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                        <span><?php echo e(__("Current Balance")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                                        <span><?php echo e(__("Conversion Amount")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                        <span><?php echo e(__("Payable Amount")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                        <span><?php echo e(__("Payable Amount")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                        <span><?php echo e(__("Total Payable")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                        <span><?php echo e(__("Total Received")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                        <span><?php echo e(__("Card Amount")); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="preview-list-right">
                            <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                <span class="text-danger"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                             <?php
                                 $conversionAmount = $item->request_amount * $item->currency->rate;
                             ?>
                                <span><?php echo e(get_amount($conversionAmount,$item->currency->currency_code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                <span class="fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                <span class="fw-bold"><?php echo e(get_amount($item->payable,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                <span class="fw-bold"> <?php echo e(get_amount(@$item->details->card_info->amount,get_default_currency_code())); ?></span>

                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                <span><?php echo e(get_amount($item->payable,$item->user_wallet->currency->code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                <span><?php echo e(get_amount($item->payable,$item->user_wallet->currency->code)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($item->type != payment_gateway_const()::TYPEADDMONEY): ?>
                    <div class="preview-list-item">
                        <div class="preview-list-left">
                            <div class="preview-list-user-wrapper">
                                <div class="preview-list-user-icon">
                                    <i class="las la-receipt"></i>
                                </div>
                                <div class="preview-list-user-content">
                                    <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                        <span><?php echo e(__("Total Amount")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                                        <span><?php echo e(__("Current Balance")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                        <span><?php echo e(__("Current Balance")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                        <span><?php echo e(__("Current Balance")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                        <span><?php echo e(__("Card Masked")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                        <span><?php echo e(__("Exchange Amount")); ?></span>
                                    <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                        <span><?php echo e(__("Remark")); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="preview-list-right">
                            <?php if($item->type == payment_gateway_const()::TYPEADDMONEY): ?>
                                <span class="text--warning"><?php echo e(get_amount($item->payable,$item->currency->currency_code)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYOUT): ?>
                                <span class="text--danger"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::BILLPAY): ?>
                                <span class="text--danger"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::MOBILETOPUP): ?>
                                <span class="text--danger"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                                <?php
                                    $card_pan = str_split($item->details->card_info->card_pan??$item->details->card_info->maskedPan, 4);
                                ?>
                                <?php $__currentLoopData = $card_pan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="text--base fw-bold"><?php echo e($value); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif($item->type == payment_gateway_const()::TYPEMONEYEXCHANGE): ?>
                                <span class="text--warning"><?php echo e(get_amount($item->details->exchange_amount,$item->details->exchange_currency)); ?></span>
                            <?php elseif($item->type == payment_gateway_const()::TYPEADDSUBTRACTBALANCE): ?>
                                <span class="text--warning"><?php echo e($item->remark); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if($item->type == payment_gateway_const()::VIRTUALCARD): ?>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-smoking"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Current Balance")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="fw-bold"><?php echo e(get_amount($item->available_balance,get_default_currency_code())); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-clock"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Time & Date")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span><?php echo e(dateFormat('d-m-y h:i:s A', $item->created_at)); ?></span>
                    </div>
                </div>
                <?php if( $item->status == 4 &&  $item->reject_reason != null): ?>
                <div class="preview-list-item">
                    <div class="preview-list-left">
                        <div class="preview-list-user-wrapper">
                            <div class="preview-list-user-icon">
                                <i class="las la-smoking"></i>
                            </div>
                            <div class="preview-list-user-content">
                                <span><?php echo e(__("Rejection Reason")); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="preview-list-right">
                        <span class="text-danger"><?php echo e($item->reject_reason); ?></span>
                    </div>
                </div>
                <?php endif; ?>



            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-primary text-center">
            <?php echo e(__("No Record Found!")); ?>

        </div>
    <?php endif; ?>

    <?php echo e(get_paginate($transactions)); ?>



<?php endif; ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card_final\resources\views/user/components/transaction-log.blade.php ENDPATH**/ ?>