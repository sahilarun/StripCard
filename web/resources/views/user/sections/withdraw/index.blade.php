@extends('user.layouts.master')

@push('css')

@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __(@$page_title)])
@endsection

@section('content')

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 pb-30">
                    <div class="deposit-form">
                        <div class="form-title text-center">
                            <h3 class="title">{{ __($page_title) }}</h3>
                        </div>
                        <div class="row justify-content-center">
                            <form class="card-form" action="{{ setRoute("user.withdraw.submit") }}" method="POST">
                             @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __("Enter Amount") }}<span>*</span></label>
                                    <input type="number" required class="form--control" placeholder="{{ __("Enter Amount") }}" name="amount" value="{{ old("amount") }}">
                                    <div class="currency">
                                        <p>{{ get_default_currency_code() }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __("Payment Gateway") }}<span>*</span></label>
                                     <div class="method">
                                        <select class="form--control nice-select gateway-select" name="gateway">
                                            @foreach ($payment_gateways ?? [] as $item)
                                                <option
                                                    value="{{ $item->alias  }}"
                                                    data-currency="{{ $item->currency_code }}"
                                                    data-min_amount="{{ $item->min_limit }}"
                                                    data-max_amount="{{ $item->max_limit }}"
                                                    data-percent_charge="{{ $item->percent_charge }}"
                                                    data-fixed_charge="{{ $item->fixed_charge }}"
                                                    data-rate="{{ $item->rate }}"
                                                    >
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                     </div>
                                     <code class="d-block mt-10 text-end fw-bold balance-show">{{ __("Available Balance") }} {{ authWalletBalance() }} {{ get_default_currency_code() }}</code>
                                </div>
                                <div class="note-area d-flex justify-content-between">
                                    <div class="d-block limit-show">--</div>
                                    <div class="d-block fees-show">--</div>
                                </div>
                                  <div class="button pt-3">
                                    <button type="submit" class="btn--base w-100 btn-loading sendBtn">{{ __("Confirm") }}</i></button>
                                  </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8">
                    <div class="deposit-form">
                        <div class="form-title text-center pb-4">
                            <h3 class="title">{{ __($page_title) }} {{ __("Preview") }}</h3>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Enter Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="request-amount"> </p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Exchange Rate") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="rate-show">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Fees & Charges")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="fees">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Conversion Amount")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="conversionAmount">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Will Get")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="will-get">--</p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Total Payable Amount") }}</p>
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
            <h4 class="title">{{ __("Withdraw Money Log") }}</h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn mb-2">
                    <a href="{{ setRoute('user.transactions.index','withdraw-money') }}" class="btn--base">{{__("View More")}}</a>
                </div>
            </div>
        </div>
        <div class="dashboard-list-wrapper">
            @include('user.components.transaction-log',compact("transactions"))
        </div>
    </div>

</div>
@endsection

@push('script')
    <script>
         var defualCurrency = "{{ get_default_currency_code() }}";
         var defualCurrencyRate = "{{ get_default_currency_rate() }}";

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
            $('.rate-show').html("1 " + defualCurrency + " = " + parseFloat(currencyRate).toFixed(4) + " " + currencyCode);
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
                var min_limit_calc = parseFloat(min_limit/sender_currency_rate).toFixed(4);
                var max_limit_clac = parseFloat(max_limit/sender_currency_rate).toFixed(4);

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
                $('.conversionAmount').text(parseFloat(conversionAmount).toFixed(4) + " " + sender_currency);
                // will get amount
                var willGetAmount = parseFloat(senderAmount) * parseFloat(sender_currency_rate);
                var willGet = parseFloat(willGetAmount).toFixed(4);
                $('.will-get').text(willGet + " " + sender_currency);

                // Pay In Total
                var totalPay = parseFloat(senderAmount);
                 var pay_in_total = parseFloat(charges.total) + parseFloat(totalPay);
                $('.pay-in-total').text(parseFloat(pay_in_total).toFixed(4) + " " + defualCurrency);

        }


    </script>
@endpush
