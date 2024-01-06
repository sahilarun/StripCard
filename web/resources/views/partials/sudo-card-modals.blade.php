<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="BuyCardModalSudo" tabindex="-1" aria-labelledby="buycard-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title">{{__("Add Card")}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <div class="modal-body">

                    <form class="card-form row g-4" action="{{ route('user.sudo.virtual.card.create') }}" method="POST">
                        @csrf
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group">
                                <label>{{__("Card Amount")}}<span>*</span></label>
                                <input type="number" class="form--control" required placeholder="{{ __("Enter Amount") }}" name="card_amount" value="{{ old("card_amount") }}">
                                <div class="currency">
                                    <p>{{ get_default_currency_code() }}</p>
                                </div>
                               <div class="d-flex justify-content-between">
                                <code class="d-block mt-3  text--base fw-bold balance-show limit-show">--</code>
                                <code class="d-block mt-3  text--base fw-bold balance-show">{{ __(" Balance: ") }} {{ authWalletBalance() }} {{ get_default_currency_code() }}</code>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="ps-4">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; {{ __("Total Charge") }} :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize fees-show">--</h3>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize">&bull; {{__("Total Pay")}} :
                                </h3>
                                <h3 class="fs-6 fw-lighter py-1 text-capitalize payable-total">--</h3>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100 btn-loading buyBtn">{{ __("Confirm") }}</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@push('script')
    <script>
    var defualCurrency = "{{ get_default_currency_code() }}";
    var defualCurrencyRate = "{{ get_default_currency_rate() }}";
    $('.buyCard-sudo').on('click', function () {
        var modal = $('#BuyCardModalSudo');
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
           var currencyMinAmount ="{{getAmount($cardCharge->min_limit)}}";
           var currencyMaxAmount = "{{getAmount($cardCharge->max_limit)}}";
           var currencyFixedCharge = "{{getAmount($cardCharge->fixed_charge)}}";
           var currencyPercentCharge = "{{getAmount($cardCharge->percent_charge)}}";


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
        var min_limit = parseFloat("{{getAmount($cardCharge->min_limit)}}");
        var max_limit =parseFloat("{{getAmount($cardCharge->max_limit)}}");
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
    </script>
@endpush
