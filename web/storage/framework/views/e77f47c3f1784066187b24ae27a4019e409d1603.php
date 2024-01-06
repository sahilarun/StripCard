<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="BuyCardModal" tabindex="-1" aria-labelledby="buycard-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title"><?php echo e(__("Add Card")); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">

                    <form class="card-form row g-4" action="<?php echo e(route('user.virtual.card.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group">
                                <label><?php echo e(__("Card Amount")); ?><span>*</span></label>
                                <input type="number" class="form--control" required placeholder="<?php echo e(__("Enter Amount")); ?>" name="card_amount" value="<?php echo e(old("card_amount")); ?>">
                                <div class="currency">
                                    <p><?php echo e(get_default_currency_code()); ?></p>
                                </div>
                               <div class="d-flex justify-content-between">
                                <code class="d-block mt-3  text--base fw-bold balance-show limit-show">--</code>
                                <code class="d-block mt-3  text--base fw-bold balance-show"><?php echo e(__(" Balance: ")); ?> <?php echo e(authWalletBalance()); ?> <?php echo e(get_default_currency_code()); ?></code>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="ps-4">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Total Charge")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize fees-show">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Total Pay")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize payable-total">--</h3>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100 btn-loading buyBtn"><?php echo e(__("Confirm")); ?></button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="FundCardModal" tabindex="-1" aria-labelledby="card-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title"><?php echo e(__("Fund Card")); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">

                    <form class="card-form row g-4" action="<?php echo e(route('user.virtual.card.fund')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id">
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group">
                                <label><?php echo e(__("Fund Amount")); ?><span>*</span></label>
                                <input type="number" class="form--control" required placeholder="<?php echo e(__("Enter Amount")); ?>" name="fund_amount" value="<?php echo e(old("fund_amount")); ?>">
                                <div class="currency">
                                    <p><?php echo e(get_default_currency_code()); ?></p>
                                </div>
                               <div class="d-flex justify-content-between">
                                <code class="d-block mt-3  text--base fw-bold balance-show fund-limit-show">--</code>
                                <code class="d-block mt-3  text--base fw-bold balance-show"><?php echo e(__(" Balance: ")); ?> <?php echo e(authWalletBalance()); ?> <?php echo e(get_default_currency_code()); ?></code>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="ps-4">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Total Charge")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize fund-fees-show">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Total Pay")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize fund-payable-total">--</h3>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100 btn-loading fund-btn"><?php echo e(__("Confirm")); ?></button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="WithdrowModal" tabindex="-1" aria-labelledby="Withdrow-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="Withdrow-modal">
                <h4 class="modal-title"><?php echo e(__("Withdrow")); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">
                <form class="row g-4" action="<?php echo e(setRoute('user.virtual.card.withdraw')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group">
                                <label><?php echo e(__("Withdraw Amount")); ?><span>*</span></label>
                                <input type="number" class="form--control" required placeholder="<?php echo e(__("Enter Amount")); ?>" name="withdraw_amount" value="<?php echo e(old("withdraw_amount")); ?>">
                                <div class="currency">
                                    <p><?php echo e(get_default_currency_code()); ?></p>
                                </div>
                               <div class="d-flex justify-content-between">
                                <code class="d-block mt-3  text--base fw-bold balance-show withdraw-limit-show">--</code>
                                <code class="d-block mt-3  text--base fw-bold withdraw-balance-show"><?php echo e(__(" Balance: ")); ?> <?php echo e(authWalletBalance()); ?> <?php echo e(get_default_currency_code()); ?></code>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="ps-4">
                            <div class="d-flex justify-content-between modal-preview">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Amount")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize req-amount">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Charge")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize withdraw-fees-show">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; <?php echo e(__("Will Get")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize withdraw-will-get">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize ">&bull; <?php echo e(__("Total Pay")); ?> :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize withdraw-payable-total">--</h3>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100 btn-loading withdrawConfirm"><?php echo e(__("Confirm")); ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<?php $__env->startPush('script'); ?>
    <script>
    var defualCurrency = "<?php echo e(get_default_currency_code()); ?>";
    var defualCurrencyRate = "<?php echo e(get_default_currency_rate()); ?>";
    $('.buyCard').on('click', function () {
        var modal = $('#BuyCardModal');
        $(document).ready(function(){
           getLimit();
           getFees();
           getPreview();
       });
       $("input[name=card_amount]").keyup(function(){
            getFees();
            getPreview();
       });
       $("input[name=card_amount]").focusout(function(){
            enterLimit();
       });
       function getLimit() {
           var currencyCode = acceptVar().currencyCode;
           var currencyRate = acceptVar().currencyRate;

           var min_limit = acceptVar().currencyMinAmount;
           var max_limit =acceptVar().currencyMaxAmount;
           if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
               var min_limit_calc = parseFloat(min_limit/currencyRate).toFixed(2);
               var max_limit_clac = parseFloat(max_limit/currencyRate).toFixed(2);
               $('.limit-show').html( "Limit: "+min_limit_calc + " " + currencyCode + " - " + max_limit_clac + " " + currencyCode);

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
       function acceptVar() {

           var currencyCode = defualCurrency;
           var currencyRate = defualCurrencyRate;
           var currencyMinAmount ="<?php echo e(getAmount($cardCharge->min_limit)); ?>";
           var currencyMaxAmount = "<?php echo e(getAmount($cardCharge->max_limit)); ?>";
           var currencyFixedCharge = "<?php echo e(getAmount($cardCharge->fixed_charge)); ?>";
           var currencyPercentCharge = "<?php echo e(getAmount($cardCharge->percent_charge)); ?>";


           return {
               currencyCode:currencyCode,
               currencyRate:currencyRate,
               currencyMinAmount:currencyMinAmount,
               currencyMaxAmount:currencyMaxAmount,
               currencyFixedCharge:currencyFixedCharge,
               currencyPercentCharge:currencyPercentCharge,


           };
       }
       function feesCalculation() {
           var currencyCode = acceptVar().currencyCode;
           var currencyRate = acceptVar().currencyRate;
           var sender_amount = $("input[name=card_amount]").val();
           sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);

           var fixed_charge = acceptVar().currencyFixedCharge;
           var percent_charge = acceptVar().currencyPercentCharge;

           if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(sender_amount)) {
               // Process Calculation
               var fixed_charge_calc = parseFloat(currencyRate * fixed_charge);

               var percent_charge_calc = (parseFloat(sender_amount) / 100) * parseFloat(percent_charge);
               var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
               total_charge = parseFloat(total_charge).toFixed(2);
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
           var currencyCode = acceptVar().currencyCode;
           var percent = acceptVar().currencyPercentCharge;
           var charges = feesCalculation();
           if (charges == false) {
               return false;
           }
           $(".fees-show").html( parseFloat(charges.fixed).toFixed(2) + " " + currencyCode + " + " + parseFloat(charges.percent).toFixed(2) + "% = " + parseFloat(charges.total).toFixed(2) + " " + currencyCode);
       }
       function getPreview() {
               var senderAmount = $("input[name=card_amount]").val();
               var charges = feesCalculation();
               var sender_currency = acceptVar().currencyCode;
               var sender_currency_rate = acceptVar().currencyRate;

               senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;
               // Sending Amount
               $('.request-amount').html("Card Amount: " + senderAmount + " " + sender_currency);

                 // Fees
                var charges = feesCalculation();
               var total_charge = 0;
               if(senderAmount == 0){
                   total_charge = 0;
               }else{
                   total_charge = charges.total;
               }
               $('.fees').html("Total Charge: " + total_charge + " " + sender_currency);
               var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
               var pay_in_total = 0;
               if(senderAmount == 0 ||  senderAmount == ''){
                    pay_in_total = 0;
               }else{
                    pay_in_total =  parseFloat(totalPay) + parseFloat(charges.total);
               }
               $('.payable-total').html( pay_in_total + " " + sender_currency);

       }
       function enterLimit(){
        var min_limit = parseFloat("<?php echo e(getAmount($cardCharge->min_limit)); ?>");
        var max_limit =parseFloat("<?php echo e(getAmount($cardCharge->max_limit)); ?>");
        var currencyRate = acceptVar().currencyRate;
        var sender_amount = parseFloat($("input[name=card_amount]").val());

        if( sender_amount < min_limit ){
            throwMessage('error',["Please follow the mimimum limit"]);
            $('.buyBtn').attr('disabled',true)
        }else if(sender_amount > max_limit){
            throwMessage('error',["Please follow the maximum limit"]);
            $('.buyBtn').attr('disabled',true)
        }else{
            $('.buyBtn').attr('disabled',false)
        }

       }
        modal.modal('show');
    });

    $('.fundCard').on('click', function () {
        var modal = $('#FundCardModal');
        modal.find('input[name=id]').val($(this).data('id'));
        $(document).ready(function(){
            getLimit();
            getFees();
            getPreview();
        });
        $("input[name=fund_amount]").keyup(function(){
            getFees();
            getPreview();
        });
        $("input[name=fund_amount]").focusout(function(){
            enterLimit();
        });

        function getLimit() {
            var currencyCode = acceptVar().currencyCode;
            var currencyRate = acceptVar().currencyRate;

            var min_limit = acceptVar().currencyMinAmount;
            var max_limit =acceptVar().currencyMaxAmount;
            if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
                var min_limit_calc = parseFloat(min_limit/currencyRate).toFixed(2);
                var max_limit_clac = parseFloat(max_limit/currencyRate).toFixed(2);
                $('.fund-limit-show').html("Limit " + min_limit_calc + " " + currencyCode + " - " + max_limit_clac + " " + currencyCode);

                return {
                    minLimit:min_limit_calc,
                    maxLimit:max_limit_clac,
                };
            }else {
                $('.fund-limit-show').html("--");
                return {
                    minLimit:0,
                    maxLimit:0,
                };
            }
        }
        function acceptVar() {

            var currencyCode = defualCurrency;
            var currencyRate = defualCurrencyRate;
            var currencyMinAmount ="<?php echo e(getAmount($cardCharge->min_limit)); ?>";
            var currencyMaxAmount = "<?php echo e(getAmount($cardCharge->max_limit)); ?>";
            var currencyFixedCharge = "<?php echo e(getAmount($cardCharge->fixed_charge)); ?>";
            var currencyPercentCharge = "<?php echo e(getAmount($cardCharge->percent_charge)); ?>";


            return {
                currencyCode:currencyCode,
                currencyRate:currencyRate,
                currencyMinAmount:currencyMinAmount,
                currencyMaxAmount:currencyMaxAmount,
                currencyFixedCharge:currencyFixedCharge,
                currencyPercentCharge:currencyPercentCharge,


            };
        }
        function feesCalculation() {
            var currencyCode = acceptVar().currencyCode;
            var currencyRate = acceptVar().currencyRate;
            var sender_amount = $("input[name=fund_amount]").val();
            sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);

            var fixed_charge = acceptVar().currencyFixedCharge;
            var percent_charge = acceptVar().currencyPercentCharge;
            if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(sender_amount)) {
                // Process Calculation
                var fixed_charge_calc = parseFloat(currencyRate * fixed_charge);
                var percent_charge_calc = parseFloat(currencyRate)*(parseFloat(sender_amount) / 100) * parseFloat(percent_charge);
                var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
                total_charge = parseFloat(total_charge).toFixed(2);
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
            var currencyCode = acceptVar().currencyCode;
            var percent = acceptVar().currencyPercentCharge;
            var charges = feesCalculation();
            if (charges == false) {
                return false;
            }
            $(".fund-fees-show").html( parseFloat(charges.fixed).toFixed(2) + " " + currencyCode + " + " + parseFloat(charges.percent).toFixed(2) + "% = " + parseFloat(charges.total).toFixed(2) + " " + currencyCode);
        }
        function getPreview() {
                var senderAmount = $("input[name=fund_amount]").val();
                var charges = feesCalculation();
                var sender_currency = acceptVar().currencyCode;
                var sender_currency_rate = acceptVar().currencyRate;

                senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;
                // Sending Amount


                    // Fees
                var charges = feesCalculation();

                var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
                var pay_in_total = 0;
                if(senderAmount == 0 ||  senderAmount == ''){
                    pay_in_total = 0;
                }else{
                    pay_in_total =  parseFloat(totalPay) + parseFloat(charges.total);
                }
                $('.fund-payable-total').html( pay_in_total + " " + sender_currency);

        }
        function enterLimit(){
            var min_limit = parseFloat("<?php echo e(getAmount($cardCharge->min_limit)); ?>");
            var max_limit =parseFloat("<?php echo e(getAmount($cardCharge->max_limit)); ?>");
            var currencyRate = acceptVar().currencyRate;
            var sender_amount = parseFloat($("input[name=fund_amount]").val());

            if( sender_amount < min_limit ){
                throwMessage('error',["Please follow the mimimum limit"]);
                $('.fund-btn').attr('disabled',true)
            }else if(sender_amount > max_limit){
                throwMessage('error',["Please follow the maximum limit"]);
                $('.fund-btn').attr('disabled',true)
            }else{
                $('.fund-btn').attr('disabled',false)
            }

        }
        modal.modal('show');
    });
    $('.withdrawBtn').on('click', function () {
        var modal = $('#WithdrowModal');
        var carrAmount = $(this).data('amount');
        modal.find('input[name=id]').val($(this).data('id'));
        $(' .withdraw-balance-show').html("Balance: " + carrAmount);
        $(document).ready(function(){
            getLimit();
            getFees();
            getPreview();
        });
        $("input[name=withdraw_amount]").keyup(function(){
            getFees();
            getPreview();
        });
        $("input[name=withdraw_amount]").focusout(function(){
            enterLimit();
        });

        function getLimit() {
            var currencyCode = acceptVar().currencyCode;
            var currencyRate = acceptVar().currencyRate;

            var min_limit = acceptVar().currencyMinAmount;
            var max_limit =acceptVar().currencyMaxAmount;
            if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
                var min_limit_calc = parseFloat(min_limit/currencyRate).toFixed(2);
                var max_limit_clac = parseFloat(max_limit/currencyRate).toFixed(2);
                $('.withdraw-limit-show').html("Limit " + min_limit_calc + " " + currencyCode + " - " + max_limit_clac + " " + currencyCode);

                return {
                    minLimit:min_limit_calc,
                    maxLimit:max_limit_clac,
                };
            }else {
                $('.withdraw-limit-show').html("--");
                return {
                    minLimit:0,
                    maxLimit:0,
                };
            }
        }
        function acceptVar() {

            var currencyCode = defualCurrency;
            var currencyRate = defualCurrencyRate;
            var currencyMinAmount ="<?php echo e(getAmount($cardWithdrawCharge->min_limit)); ?>";
            var currencyMaxAmount = "<?php echo e(getAmount($cardWithdrawCharge->max_limit)); ?>";
            var currencyFixedCharge = "<?php echo e(getAmount($cardWithdrawCharge->fixed_charge)); ?>";
            var currencyPercentCharge = "<?php echo e(getAmount($cardWithdrawCharge->percent_charge)); ?>";


            return {
                currencyCode:currencyCode,
                currencyRate:currencyRate,
                currencyMinAmount:currencyMinAmount,
                currencyMaxAmount:currencyMaxAmount,
                currencyFixedCharge:currencyFixedCharge,
                currencyPercentCharge:currencyPercentCharge,


            };
        }
        function feesCalculation() {
            var currencyCode = acceptVar().currencyCode;
            var currencyRate = acceptVar().currencyRate;
            var sender_amount = $("input[name=withdraw_amount]").val();
            sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);

            var fixed_charge = acceptVar().currencyFixedCharge;
            var percent_charge = acceptVar().currencyPercentCharge;
            if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(sender_amount)) {
                // Process Calculation
                var fixed_charge_calc = parseFloat(currencyRate * fixed_charge);
                var percent_charge_calc = parseFloat(currencyRate)*(parseFloat(sender_amount) / 100) * parseFloat(percent_charge);
                var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
                total_charge = parseFloat(total_charge).toFixed(2);
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
            var currencyCode = acceptVar().currencyCode;
            var percent = acceptVar().currencyPercentCharge;
            var charges = feesCalculation();
            if (charges == false) {
                return false;
            }
            $(".withdraw-fees-show").html( parseFloat(charges.fixed).toFixed(2) + " " + currencyCode + " + " + parseFloat(charges.percent).toFixed(2) + "% = " + parseFloat(charges.total).toFixed(2) + " " + currencyCode);
        }
        function getPreview() {
                var senderAmount = $("input[name=withdraw_amount]").val();
                var charges = feesCalculation();
                var sender_currency = acceptVar().currencyCode;
                var sender_currency_rate = acceptVar().currencyRate;

                senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;
                // Sending Amount
                $('.req-amount').html( senderAmount + " " + sender_currency);

                    // Fees
                var charges = feesCalculation();


                var willGet = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
                var will_get = 0;
                if(senderAmount == 0 ||  senderAmount == ''){
                    will_get = 0;
                }else{
                    will_get =  parseFloat(willGet) ;
                }
                $('.withdraw-will-get').html( will_get + " " + sender_currency);
                var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
                var pay_in_total = 0;
                if(senderAmount == 0 ||  senderAmount == ''){
                    pay_in_total = 0;
                }else{
                    pay_in_total =  parseFloat(totalPay) + parseFloat(charges.total);
                }
                $('.withdraw-payable-total').html( pay_in_total + " " + sender_currency);

        }
        function enterLimit(){
            var min_limit = parseFloat("<?php echo e(getAmount($cardWithdrawCharge->min_limit)); ?>");
            var max_limit =parseFloat("<?php echo e(getAmount($cardWithdrawCharge->max_limit)); ?>");
            var currencyRate = acceptVar().currencyRate;
            var sender_amount = parseFloat($("input[name=withdraw_amount]").val());

            if( sender_amount < min_limit ){
                throwMessage('error',["Please follow the mimimum limit"]);
                $('.withdrawConfirm').attr('disabled',true)
            }else if(sender_amount > max_limit){
                throwMessage('error',["Please follow the maximum limit"]);
                $('.withdrawConfirm').attr('disabled',true)
            }else{
                $('.withdrawConfirm').attr('disabled',false)
            }

        }
        modal.modal('show');
    });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/partials/card-modals.blade.php ENDPATH**/ ?>