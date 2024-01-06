<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __(@$page_title)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 pb-30">
                    <div class="deposit-form">
                        <div class="form-title text-center">
                            <h3 class="title"><?php echo e(__($page_title)); ?></h3>
                        </div>
                        <div class="row justify-content-center">
                            <form class="card-form" action="<?php echo e(setRoute("user.withdraw.submit")); ?>" method="POST">
                             <?php echo csrf_field(); ?>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><?php echo e(__("Enter Amount")); ?><span>*</span></label>
                                    <input type="number" required class="form--control" placeholder="<?php echo e(__("Enter Amount")); ?>" name="amount" value="<?php echo e(old("amount")); ?>">
                                    <div class="currency">
                                        <p><?php echo e(get_default_currency_code()); ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo e(__("Payment Gateway")); ?><span>*</span></label>
                                     <div class="method">
                                        <select class="form--control nice-select gateway-select" name="gateway">
                                            <?php $__currentLoopData = $payment_gateways ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($item->alias); ?>"
                                                    data-currency="<?php echo e($item->currency_code); ?>"
                                                    data-min_amount="<?php echo e($item->min_limit); ?>"
                                                    data-max_amount="<?php echo e($item->max_limit); ?>"
                                                    data-percent_charge="<?php echo e($item->percent_charge); ?>"
                                                    data-fixed_charge="<?php echo e($item->fixed_charge); ?>"
                                                    data-rate="<?php echo e($item->rate); ?>"
                                                    >
                                                    <?php echo e($item->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                     </div>
                                     <code class="d-block mt-10 text-end fw-bold balance-show"><?php echo e(__("Available Balance")); ?> <?php echo e(authWalletBalance()); ?> <?php echo e(get_default_currency_code()); ?></code>
                                </div>
                                <div class="note-area d-flex justify-content-between">
                                    <div class="d-block limit-show">--</div>
                                    <div class="d-block fees-show">--</div>
                                </div>
                                  <div class="button pt-3">
                                    <button type="submit" class="btn--base w-100 btn-loading sendBtn"><?php echo e(__("Confirm")); ?></i></button>
                                  </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8">
                    <div class="deposit-form">
                        <div class="form-title text-center pb-4">
                            <h3 class="title"><?php echo e(__($page_title)); ?> <?php echo e(__("Preview")); ?></h3>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Enter Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="request-amount"> </p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Exchange Rate")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="rate-show">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Fees & Charges")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="fees">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Conversion Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="conversionAmount">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Will Get")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="will-get">--</p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p><?php echo e(__("Total Payable Amount")); ?></p>
                            </div>
                            <div class="preview-content">
                                <p class="pay-in-total">--</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-area mt-20">
        <div class="dashboard-header-wrapper">
            <h4 class="title"><?php echo e(__("Withdraw Money Log")); ?></h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn mb-2">
                    <a href="<?php echo e(setRoute('user.transactions.index','withdraw-money')); ?>" class="btn--base"><?php echo e(__("View More")); ?></a>
                </div>
            </div>
        </div>
        <div class="dashboard-list-wrapper">
            <?php echo $__env->make('user.components.transaction-log',compact("transactions"), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
         var defualCurrency = "<?php echo e(get_default_currency_code()); ?>";
         var defualCurrencyRate = "<?php echo e(get_default_currency_rate()); ?>";

        $('select[name=gateway]').on('change',function(){
            getExchangeRate($(this));
            getLimit();
            getFees();
            getPreview();
        });
        $(document).ready(function(){
            getExchangeRate();
            getLimit();
            getFees();
            getPreview();
        });
        $("input[name=amount]").keyup(function(){
             getFees();
             getPreview();
        });
        $("input[name=amount]").focusout(function(){
            enterLimit();
       });
        function getExchangeRate(event) {
            var element = event;
            var currencyCode = acceptVar().currencyCode;
            var currencyRate = acceptVar().currencyRate;
            var currencyMinAmount = acceptVar().currencyMinAmount;
            var currencyMaxAmount = acceptVar().currencyMaxAmount;
            $('.rate-show').html("1 " + defualCurrency + " = " + parseFloat(currencyRate).toFixed(2) + " " + currencyCode);
        }
        function getLimit() {
            var sender_currency = acceptVar().currencyCode;
            var sender_currency_rate = acceptVar().currencyRate;
            var min_limit = acceptVar().currencyMinAmount;
            var max_limit =acceptVar().currencyMaxAmount;
            if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
                var min_limit_calc = parseFloat(min_limit/sender_currency_rate).toFixed(4);
                var max_limit_clac = parseFloat(max_limit/sender_currency_rate).toFixed(4);
                $('.limit-show').html("Limit " + min_limit_calc + " " + defualCurrency + " - " + max_limit_clac + " " + defualCurrency);
                return {
                    minLimit:min_limit_calc,
                    maxLimit:max_limit_clac,
                };
            }else {
                $('.limit-show').html("--");
                return {
                    minLimit:0,
                    maxLimit:0,
                };
            }
        }
        function enterLimit(){
            var sender_currency_rate = acceptVar().currencyRate;
            var min_limit = acceptVar().currencyMinAmount;
            var max_limit =acceptVar().currencyMaxAmount;
            if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
                var min_limit_calc = parseFloat(min_limit/sender_currency_rate).toFixed(2);
                var max_limit_clac = parseFloat(max_limit/sender_currency_rate).toFixed(2);

            }
            var sender_amount = parseFloat($("input[name=amount]").val());

            if( sender_amount < min_limit_calc ){
                throwMessage('error',["Please follow the mimimum limit"]);
                $('.sendBtn').attr('disabled',true)
            }else if(sender_amount > max_limit_clac){
                throwMessage('error',["Please follow the maximum limit"]);
                $('.sendBtn').attr('disabled',true)
            }else{
                $('.sendBtn').attr('disabled',false)
            }

        }


        function acceptVar() {
            var selectedVal = $("select[name=gateway] :selected");
            var currencyCode = $("select[name=gateway] :selected").attr("data-currency");
            var currencyRate = $("select[name=gateway] :selected").attr("data-rate");
            var currencyMinAmount = $("select[name=gateway] :selected").attr("data-min_amount");
            var currencyMaxAmount = $("select[name=gateway] :selected").attr("data-max_amount");
            var currencyFixedCharge = $("select[name=gateway] :selected").attr("data-fixed_charge");
            var currencyPercentCharge = $("select[name=gateway] :selected").attr("data-percent_charge");

            return {
                currencyCode:currencyCode,
                currencyRate:currencyRate,
                currencyMinAmount:currencyMinAmount,
                currencyMaxAmount:currencyMaxAmount,
                currencyFixedCharge:currencyFixedCharge,
                currencyPercentCharge:currencyPercentCharge,
                selectedVal:selectedVal,

            };
        }

        function feesCalculation() {
            var sender_currency = acceptVar().currencyCode;
            var sender_currency_rate = acceptVar().currencyRate;
            var sender_amount = $("input[name=amount]").val();
            sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);
            var conversion_amount = parseFloat( sender_amount) *  parseFloat(sender_currency_rate)

            var fixed_charge = acceptVar().currencyFixedCharge;
            var percent_charge = acceptVar().currencyPercentCharge;
            if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(conversion_amount)) {
                // Process Calculation
                var fixed_charge_calc = parseFloat(fixed_charge)/sender_currency_rate;
                var percent_charge_calc = (parseFloat(sender_amount) / 100) * parseFloat(percent_charge)/sender_currency_rate;
                var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
                total_charge = parseFloat(total_charge).toFixed(4);
                // return total_charge;
                return {
                    total: total_charge,
                    fixed: fixed_charge_calc,
                    percent: percent_charge,
                };
            } else {
                // return "--";
                return false;
            }
        }

        function getFees() {
            var sender_currency = acceptVar().currencyCode;
            var percent = acceptVar().currencyPercentCharge;
            var charges = feesCalculation();
            if (charges == false) {
                return false;
            }
            $(".fees-show").html("Charge: " + parseFloat(charges.fixed).toFixed(4) + " " + defualCurrency + " + " + parseFloat(charges.percent).toFixed(4) + "%");
        }
        function getPreview() {
                var senderAmount = $("input[name=amount]").val();
                var sender_currency = acceptVar().currencyCode;
                var sender_currency_rate = acceptVar().currencyRate;
                // var receiver_currency = acceptVar().rCurrency;
                senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;

                // Sending Amount
                $('.request-amount').text(senderAmount + " " + defualCurrency);

                // Fees
                var charges = feesCalculation();
                // console.log(total_charge + "--");
                $('.fees').text(charges.total + " " + defualCurrency);

                var conversionAmount = senderAmount * sender_currency_rate;
                $('.conversionAmount').text(parseFloat(conversionAmount).toFixed(2) + " " + sender_currency);
                // will get amount
                var willGetAmount = parseFloat(senderAmount) * parseFloat(sender_currency_rate);
                var willGet = parseFloat(willGetAmount).toFixed(2);
                $('.will-get').text(willGet + " " + sender_currency);

                // Pay In Total
                var totalPay = parseFloat(senderAmount);
                 var pay_in_total = parseFloat(charges.total) + parseFloat(totalPay);
                $('.pay-in-total').text(parseFloat(pay_in_total).toFixed(2) + " " + defualCurrency);

        }


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.3.0\full_project\resources\views/user/sections/withdraw/index.blade.php ENDPATH**/ ?>