<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="BuyCardModalStripe" tabindex="-1" aria-labelledby="buycard-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title"><?php echo e(__("Add Card")); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body stripe-modal">

                    <form class="card-form row g-4" action="<?php echo e(route('user.stripe.virtual.card.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-checkbox d-flex">
                            <div class="radio-btn">
                                <div class="form-check">
                                    <input class="form-check-input" id="water" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                 </div>
                            </div>
                            <div class="modal-radio-content ps-2">
                                <h4 class="title">Virtual</h4>
                                <p>You can use virtual cards instantly.</p>
                            </div>
                            </div>
                        <button type="submit" class="btn btn--base w-100 btn-loading buyBtn"><?php echo e(__("Confirm")); ?></button>
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
    $('.buyCard-stripe').on('click', function () {
        var modal = $('#BuyCardModalStripe');
    //    $(document).ready(function(){
    //        getLimit();
    //        getFees();
    //        getPreview();
    //    });
    //    $("input[name=card_amount]").keyup(function(){
    //         getFees();
    //         getPreview();
    //    });
    //    $("input[name=card_amount]").focusout(function(){
    //         enterLimit();
    //    });
    //    function getLimit() {
    //        var currencyCode = acceptVar().currencyCode;
    //        var currencyRate = acceptVar().currencyRate;

    //        var min_limit = acceptVar().currencyMinAmount;
    //        var max_limit =acceptVar().currencyMaxAmount;
    //        if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
    //            var min_limit_calc = parseFloat(min_limit/currencyRate).toFixed(2);
    //            var max_limit_clac = parseFloat(max_limit/currencyRate).toFixed(2);
    //            $('.limit-show').html( "Limit: "+min_limit_calc + " " + currencyCode + " - " + max_limit_clac + " " + currencyCode);

    //            return {
    //                minLimit:min_limit_calc,
    //                maxLimit:max_limit_clac,
    //            };
    //        }else {
    //            $('.limit-show').html("--");
    //            return {
    //                minLimit:0,
    //                maxLimit:0,
    //            };
    //        }
    //    }
    //    function acceptVar() {

    //        var currencyCode = defualCurrency;
    //        var currencyRate = defualCurrencyRate;
    //        var currencyMinAmount ="<?php echo e(getAmount($cardCharge->min_limit)); ?>";
    //        var currencyMaxAmount = "<?php echo e(getAmount($cardCharge->max_limit)); ?>";
    //        var currencyFixedCharge = "<?php echo e(getAmount($cardCharge->fixed_charge)); ?>";
    //        var currencyPercentCharge = "<?php echo e(getAmount($cardCharge->percent_charge)); ?>";


    //        return {
    //            currencyCode:currencyCode,
    //            currencyRate:currencyRate,
    //            currencyMinAmount:currencyMinAmount,
    //            currencyMaxAmount:currencyMaxAmount,
    //            currencyFixedCharge:currencyFixedCharge,
    //            currencyPercentCharge:currencyPercentCharge,


    //        };
    //    }
    //    function feesCalculation() {
    //        var currencyCode = acceptVar().currencyCode;
    //        var currencyRate = acceptVar().currencyRate;
    //        var sender_amount = $("input[name=card_amount]").val();
    //        sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);

    //        var fixed_charge = acceptVar().currencyFixedCharge;
    //        var percent_charge = acceptVar().currencyPercentCharge;

    //        if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(sender_amount)) {
    //            // Process Calculation
    //            var fixed_charge_calc = parseFloat(currencyRate * fixed_charge);

    //            var percent_charge_calc = (parseFloat(sender_amount) / 100) * parseFloat(percent_charge);
    //            var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
    //            total_charge = parseFloat(total_charge).toFixed(2);
    //            // return total_charge;
    //            return {
    //                total: total_charge,
    //                fixed: fixed_charge_calc,
    //                percent: percent_charge,
    //            };
    //        } else {
    //            // return "--";
    //            return false;
    //        }
    //    }

    //    function getFees() {
    //        var currencyCode = acceptVar().currencyCode;
    //        var percent = acceptVar().currencyPercentCharge;
    //        var charges = feesCalculation();
    //        if (charges == false) {
    //            return false;
    //        }
    //        $(".fees-show").html( parseFloat(charges.fixed).toFixed(2) + " " + currencyCode + " + " + parseFloat(charges.percent).toFixed(2) + "% = " + parseFloat(charges.total).toFixed(2) + " " + currencyCode);
    //    }
    //    function getPreview() {
    //            var senderAmount = $("input[name=card_amount]").val();
    //            var charges = feesCalculation();
    //            var sender_currency = acceptVar().currencyCode;
    //            var sender_currency_rate = acceptVar().currencyRate;

    //            senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;
    //            // Sending Amount
    //            $('.request-amount').html("Card Amount: " + senderAmount + " " + sender_currency);

    //              // Fees
    //             var charges = feesCalculation();
    //            var total_charge = 0;
    //            if(senderAmount == 0){
    //                total_charge = 0;
    //            }else{
    //                total_charge = charges.total;
    //            }
    //            $('.fees').html("Total Charge: " + total_charge + " " + sender_currency);
    //            var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
    //            var pay_in_total = 0;
    //            if(senderAmount == 0 ||  senderAmount == ''){
    //                 pay_in_total = 0;
    //            }else{
    //                 pay_in_total =  parseFloat(totalPay) + parseFloat(charges.total);
    //            }
    //            $('.payable-total').html( pay_in_total + " " + sender_currency);

    //    }
    //    function enterLimit(){
    //     var min_limit = parseFloat("<?php echo e(getAmount($cardCharge->min_limit)); ?>");
    //     var max_limit =parseFloat("<?php echo e(getAmount($cardCharge->max_limit)); ?>");
    //     var currencyRate = acceptVar().currencyRate;
    //     var sender_amount = parseFloat($("input[name=card_amount]").val());

    //     if( sender_amount < min_limit ){
    //         throwMessage('error',["Please follow the mimimum limit"]);
    //         $('.buyBtn').attr('disabled',true)
    //     }else if(sender_amount > max_limit){
    //         throwMessage('error',["Please follow the maximum limit"]);
    //         $('.buyBtn').attr('disabled',true)
    //     }else{
    //         $('.buyBtn').attr('disabled',false)
    //     }

    //    }
        modal.modal('show');
    });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\adcard-update\resources\views/partials/stripe-card-modals.blade.php ENDPATH**/ ?>