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
                            <form class="card-form" action="{{ setRoute("user.transfer.money.confirmed") }}" method="POST">
                             @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __("Receiver Email") }}<span>*</span></label>
                                    <input type="email" required class="form--control checkUser" placeholder="{{ __("Enter Email") }}" name="email" value="{{ old("email") }}">
                                    <label class="exist text-start"></label>
                                </div>
                                <div class="form-group">
                                    <label>{{ __("Enter Amount") }}<span>*</span></label>
                                    <input type="number" required class="form--control" placeholder="{{ __("Enter Amount") }}" name="amount" value="{{ old("amount") }}">
                                    <div class="currency">
                                        <p>{{ get_default_currency_code() }}</p>
                                    </div>
                                    <code class="d-block mt-10 text-end fw-bold balance-show">{{ __("Available Balance") }} {{ authWalletBalance() }} {{ get_default_currency_code() }}</code>
                                </div>
                                <div class="note-area d-flex justify-content-between">
                                    <div class="d-block limit-show">--</div>
                                    <div class="d-block fees-show">--</div>
                                </div>
                                  <div class="button pt-3">
                                    <button type="submit" class="btn--base w-100 btn-loading transferBtn">{{ __("Confirm") }}</i></button>
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
                                <p>{{__("Transfer Fee")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="fees">--</p>
                            </div>
                        </div>
                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{__("Recipient Received")}}</p>
                            </div>
                            <div class="preview-content">
                                <p class="recipient-get">--</p>
                            </div>
                        </div>

                        <div class="preview-item d-flex justify-content-between">
                            <div class="preview-content">
                                <p>{{ __("Total Payable Amount") }}</p>
                            </div>
                            <div class="preview-content">
                                <p class="payable-total">--</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-area mt-20">
        <div class="dashboard-header-wrapper">
            <h4 class="title">{{ __("Transfer Money Log") }}</h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn mb-2">
                    <a href="{{ setRoute('user.transactions.index','transfer-money') }}" class="btn--base">{{__("View More")}}</a>
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
      $('.checkUser').on('keyup',function(e){
            var url = '{{ route('user.transfer.money.check.exist') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            if ($(this).attr('name') == 'email') {
                var data = {email:value,_token:token}

            }
            $.post(url,data,function(response) {
                if(response.own){
                    if($('.exist').hasClass('text--success')){
                        $('.exist').removeClass('text--success');
                    }
                    $('.exist').addClass('text--danger').text(response.own);
                    $('.transferBtn').attr('disabled',true)
                    return false
                }
                if(response['data'] != null){
                    if($('.exist').hasClass('text--danger')){
                        $('.exist').removeClass('text--danger');
                    }
                    $('.exist').text(`Valid user for transfer money.`).addClass('text--success');
                    $('.transferBtn').attr('disabled',false)
                } else {
                    if($('.exist').hasClass('text--success')){
                        $('.exist').removeClass('text--success');
                    }
                    $('.exist').text('User doesn\'t  exists.').addClass('text--danger');
                    $('.transferBtn').attr('disabled',true)
                    return false
                }

            });
        });
</script>
    <script>
    var defualCurrency = "{{ get_default_currency_code() }}";
    var defualCurrencyRate = "{{ get_default_currency_rate() }}";
    $(document).ready(function(){
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
    function getLimit() {
        var currencyCode = acceptVar().currencyCode;
        var currencyRate = acceptVar().currencyRate;

        var min_limit = acceptVar().currencyMinAmount;
        var max_limit =acceptVar().currencyMaxAmount;
        if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
            var min_limit_calc = parseFloat(min_limit/currencyRate).toFixed(2);
            var max_limit_clac = parseFloat(max_limit/currencyRate).toFixed(2);
            $('.limit-show').html("Limit " + min_limit_calc + " " + currencyCode + " - " + max_limit_clac + " " + currencyCode);

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
        var currencyMinAmount ="{{getAmount($transferMoneyCharge->min_limit)}}"
        var currencyMaxAmount = "{{getAmount($transferMoneyCharge->max_limit)}}"
        var currencyFixedCharge = "{{getAmount($transferMoneyCharge->fixed_charge)}}"
        var currencyPercentCharge = "{{getAmount($transferMoneyCharge->percent_charge)}}"
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
        var sender_amount = $("input[name=amount]").val();
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
        $(".fees-show").html("Transfer Fee: " + parseFloat(charges.fixed).toFixed(2) + " " + currencyCode + " + " + parseFloat(charges.percent).toFixed(2) + "%  ");
    }
    function getPreview() {
            var senderAmount = $("input[name=amount]").val();
            var sender_currency = acceptVar().currencyCode;
            var sender_currency_rate = acceptVar().currencyRate;
            senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;
            // Sending Amount
            $('.request-amount').text(senderAmount + " " + defualCurrency);

            // Fees
            var charges = feesCalculation();
            var total_charge = 0;
            if(senderAmount == 0){
                total_charge = 0;
            }else{
                total_charge = charges.total;
            }

            $('.fees').text(total_charge + " " + sender_currency);
            // // recipient received
            var recipient = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
            var recipient_get = 0;
            if(senderAmount == 0){
                recipient_get = 0;
            }else{
                recipient_get =  parseFloat(recipient);
            }
            $('.recipient-get').text(parseFloat(recipient_get).toFixed(2) + " " + sender_currency);

            // Pay In Total
            var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
            var pay_in_total = 0;
            if(senderAmount == 0){
                pay_in_total = 0;
            }else{
                pay_in_total =  parseFloat(totalPay) + parseFloat(charges.total);
            }
            $('.payable-total').text(parseFloat(pay_in_total).toFixed(2) + " " + sender_currency);

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
            $('.transferBtn').attr('disabled',true)
        }else if(sender_amount > max_limit_clac){
            throwMessage('error',["Please follow the maximum limit"]);
            $('.transferBtn').attr('disabled',true)
        }else{
            $('.transferBtn').attr('disabled',false)
        }

    }
    </script>
@endpush
