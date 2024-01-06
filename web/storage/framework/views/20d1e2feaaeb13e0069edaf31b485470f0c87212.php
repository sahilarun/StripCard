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
            <div class="modal-body">

                    <form class="card-form row g-4" action="<?php echo e(route('user.stripe.virtual.card.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                    <div class="col-12">
                        <div class="virtual-card-wrapper d-flex justify-content-center mb-20">
                            <div class="dash-payment-body">
                                <div class="card-custom">
                                    <div class="flip">
                                        <div class="front bg_img" data-background="<?php echo e(get_image(@$cardApi->image ,'card-api')); ?>">
                                            <img class="logo" src="<?php echo e(get_fav($basic_settings)); ?>"
                                            alt="site-logo">
                                            <div class="investor"><?php echo e(@$basic_settings->site_name); ?></div>
                                            <div class="chip">
                                                <div class="chip-line"></div>
                                                <div class="chip-line"></div>
                                                <div class="chip-line"></div>
                                                <div class="chip-line"></div>
                                                <div class="chip-main"></div>
                                            </div>
                                            <svg class="wave" viewBox="0 3.71 26.959 38.787" width="26.959" height="38.787" fill="white">
                                                <path d="M19.709 3.719c.266.043.5.187.656.406 4.125 5.207 6.594 11.781 6.594 18.938 0 7.156-2.469 13.73-6.594 18.937-.195.336-.57.531-.957.492a.9946.9946 0 0 1-.851-.66c-.129-.367-.035-.777.246-1.051 3.855-4.867 6.156-11.023 6.156-17.718 0-6.696-2.301-12.852-6.156-17.719-.262-.317-.301-.762-.102-1.121.204-.36.602-.559 1.008-.504z"></path>
                                                <path d="M13.74 7.563c.231.039.442.164.594.343 3.508 4.059 5.625 9.371 5.625 15.157 0 5.785-2.113 11.097-5.625 15.156-.363.422-1 .472-1.422.109-.422-.363-.472-1-.109-1.422 3.211-3.711 5.156-8.551 5.156-13.843 0-5.293-1.949-10.133-5.156-13.844-.27-.309-.324-.75-.141-1.114.188-.367.578-.582.985-.542h.093z"></path>
                                                <path d="M7.584 11.438c.227.031.438.144.594.312 2.953 2.863 4.781 6.875 4.781 11.313 0 4.433-1.828 8.449-4.781 11.312-.398.387-1.035.383-1.422-.016-.387-.398-.383-1.035.016-1.421 2.582-2.504 4.187-5.993 4.187-9.875 0-3.883-1.605-7.372-4.187-9.875-.321-.282-.426-.739-.266-1.133.164-.395.559-.641.984-.617h.094zM1.178 15.531c.121.02.238.063.344.125 2.633 1.414 4.437 4.215 4.437 7.407 0 3.195-1.797 5.996-4.437 7.406-.492.258-1.102.07-1.36-.422-.257-.492-.07-1.102.422-1.359 2.012-1.075 3.375-3.176 3.375-5.625 0-2.446-1.371-4.551-3.375-5.625-.441-.204-.676-.692-.551-1.165.122-.468.567-.785 1.051-.742h.094z"></path>
                                            </svg>
                                            <div class="card-number">
                                                <div class="section">0000</div>
                                                <div class="section">0000</div>
                                                <div class="section">0000</div>
                                                <div class="section">0000</div>
                                            </div>
                                            <div class="end"><span class="end-text">exp. end:</span><span class="end-date"> 00/00</span>
                                            </div>
                                            <div class="card-holder"><?php echo e(auth()->user()->fullname); ?></div>
                                            <div class="master">
                                                <h3 class="title"><?php echo e(__("VISA")); ?></h4>
                                            </div>
                                        </div>
                                        <div class="back">
                                            <div class="strip-black"></div>
                                            <div class="ccv">
                                                <label>ccv</label>
                                                <div>000</div>
                                            </div>
                                            <div class="terms">
                                                <?php
                                                echo @$cardApi->card_details;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label><?php echo e(__("Fund Amount")); ?><span>*</span></label>
                                <input type="number" class="form--control" required placeholder="<?php echo e(__("Enter Amount")); ?>" name="fund_amount" value="<?php echo e(old("fund_amount")); ?>">
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
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<?php $__env->startPush('script'); ?>


<script>
    var defualCurrency = "<?php echo e(get_default_currency_code()); ?>";
    var defualCurrencyRate = "<?php echo e(get_default_currency_rate()); ?>";
    $('.buyCard-stripe').on('click', function () {
        var modal = $('#BuyCardModalStripe');
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
           var sender_amount = $("input[name=fund_amount]").val();
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
               var senderAmount = $("input[name=fund_amount]").val();
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
        var sender_amount = parseFloat($("input[name=fund_amount]").val());

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



    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-2.0.0\full_project\resources\views/partials/stripe-card-modals.blade.php ENDPATH**/ ?>