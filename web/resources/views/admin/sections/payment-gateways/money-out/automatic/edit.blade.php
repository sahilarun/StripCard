@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 200px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 156px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Money Out")])
@endsection

@section('content')
    <form action="{{ setRoute('admin.payment.gateway.update',['money-out','automatic',$gateway->alias]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="custom-card credentials">
            <div class="card-header">
                <h6 class="title">{{ __("Update Gateway") }} : {{ $gateway->name }}</h6>
            </div>
            <div class="card-body">
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => "Gateway Image*",
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files'         => $gateway->image,
                            'old_files_path'    => files_asset_path('payment-gateways'),
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        @include('admin.components.payment-gateway.automatic.credentials',['gateway' => $gateway])
                         {{-- Production/Sandbox Switcher --}}
                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                            @include('admin.components.form.switcher', [
                                'label'         => 'Gateway Environment',
                                'value'         => old('mode',$gateway->env),
                                'name'          => "mode",
                                'options'       => ['Production' => payment_gateway_const()::ENV_PRODUCTION, 'Sandbox' => payment_gateway_const()::ENV_SANDBOX],
                            ])
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        @include('admin.components.payment-gateway.automatic.supported-currencies',compact('gateway'))
                    </div>
                </div>
            </div>
        </div>


        @include('admin.components.payment-gateway.automatic.gateway-currency',compact('gateway'))

        <div class="custom-card mt-15">
            <div class="card-body">
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.payment.gateway.update",
                        ])
                    </div>
                </div>
            </div>
        </div>

    </form>
    {{-- @if($gateway->name == "Flutterwave")
        <div class="row">
            <div class="custom-card mt-15">
                <div class="card-header"><h6 class="title">Supported Banks</h6></div>
                @php
                    $credentials = $gateway->credentials;
                    $secret_key = getPaymentCredentials($credentials,'Secret key');
                    $banks = getFlutterwaveBanks($secret_key)??[];
                @endphp
                <div class="card-body">
                    @foreach ($banks as $bank)
                    <span class="badge badge--success"><span class="text-dark">{{ $bank['name'] }}</span></span>
                    @endforeach


                </div>
            </div>
        </div>
    @endif --}}

@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(".payment-gateway-currency").change(function(event){
                event.preventDefault();
                var currency = $(this).attr("data-currency");
                var defaultCurrency = $(this).attr("data-default-currency");

                if($(this).is(":checked")) {
                    var credentialsElement = $(".credentials");
                    var paymentGatewayCurrencyContent = ``;
                    var paymentGatewayCurrenciesWrapper = getHtmlMarkup().payment_gateway_currencies_wrapper;
                    var paymentGatewayCurrencyBlock     = getHtmlMarkup().payment_gateway_currency_block;

                    if(credentialsElement.siblings(".payment-gateway-currencies-wrapper").length > 0) {
                        $(".payment-gateway-currencies-wrapper").prepend(paymentGatewayCurrencyBlock);

                        $(".payment-gateway-currencies-wrapper .gateway-currency").removeClass("last-added");

                        var firstGatewayCurrencyItem = $(".payment-gateway-currencies-wrapper .gateway-currency").first();
                        firstGatewayCurrencyItem.addClass('last-added');

                        var generateId = currency.toLowerCase()+"-block";
                        if($("#"+generateId).length > 0) {
                            return false;
                        }

                        firstGatewayCurrencyItem.slideDown(300);
                        firstGatewayCurrencyItem.attr("id",generateId);
                        firstGatewayCurrencyItem.find(".currency").text(currency);
                        firstGatewayCurrencyItem.find(".default-currency").text(defaultCurrency);

                        setInputFieldsName(firstGatewayCurrencyItem,currency);
                        fileHolderPreviewReInit(".gateway-currency .file-holder");

                    }else {
                        credentialsElement.after(paymentGatewayCurrenciesWrapper);
                        $(".payment-gateway-currencies-wrapper").prepend(paymentGatewayCurrencyBlock);
                        var firstGatewayCurrencyItem = $(".payment-gateway-currencies-wrapper .gateway-currency").first();

                        var generateId = currency.toLowerCase()+"-block";
                        if($("#"+generateId).length > 0) {
                            return false;
                        }

                        firstGatewayCurrencyItem.slideDown(300);
                        firstGatewayCurrencyItem.attr("id",generateId);
                        firstGatewayCurrencyItem.find(".currency").text(currency);
                        firstGatewayCurrencyItem.find(".default-currency").text(defaultCurrency);

                        setInputFieldsName(firstGatewayCurrencyItem,currency);
                        fileHolderPreviewReInit(".gateway-currency .file-holder");

                    }
                }else {
                    var selector = "#"+currency.toLowerCase()+"-block";
                    var paymentGatewayCurrencyBlock = $(selector);
                    var target = paymentGatewayCurrencyBlock.attr("data-target");

                    if(target == undefined) {
                        paymentGatewayCurrencyBlock.slideUp(300);
                        setTimeout((element) => {
                            element.remove();
                        }, 300,paymentGatewayCurrencyBlock);
                    }else {
                        var checkbox = $(this);
                        checkbox.prop("checked",true);

                        var alertHtmlMarkup = getHtmlMarkup().modal_default_alert;
                        var alertMessage = "Are you sure to remove <strong>" + paymentGatewayCurrencyBlock.find(".currency-title").html() + "</strong> ?";
                        var alertHtmlMarkup = replaceText(alertHtmlMarkup,alertMessage);
                        openModalByContent({
                            content: alertHtmlMarkup,
                        });
                        $(".alert-submit-btn").addClass("gateway-remove-btn");
                        btnLoadingRefresh();

                        $(".gateway-remove-btn").click(function(){
                            // Make Ajax Request And Delete Item From Database
                            var CSRF = laravelCsrf();
                            $.post("{{ setRoute('admin.payment.gateway.currency.remove') }}",{_method:"DELETE",_token:CSRF,data_target:target},function(response) {
                                throwMessage('success',response.message.success);
                            }).done(function(response){
                                checkbox.prop("checked",false);
                                currentModalClose();
                                paymentGatewayCurrencyBlock.slideUp(300);
                                setTimeout((element) => {
                                    element.remove();
                                }, 300,paymentGatewayCurrencyBlock);
                            }).fail(function(response) {
                                var response = JSON.parse(response.responseText);
                                throwMessage('error',response.message.error);
                            });
                        });
                    }
                }
            });
        });

        function setInputFieldsName(firstGatewayCurrencyItem,currency){
            firstGatewayCurrencyItem.find(".image").attr("name",generateInputName(currency,"image"));
            firstGatewayCurrencyItem.find(".min-limit").attr("name",generateInputName(currency,"min_limit"));
            firstGatewayCurrencyItem.find(".max-limit").attr("name",generateInputName(currency,"max_limit"));
            firstGatewayCurrencyItem.find(".fixed-charge").attr("name",generateInputName(currency,"fixed_charge"));
            firstGatewayCurrencyItem.find(".percent-charge").attr("name",generateInputName(currency,"percent_charge"));
            firstGatewayCurrencyItem.find(".rate").attr("name",generateInputName(currency,"rate"));
            firstGatewayCurrencyItem.find(".symbol").attr("name",generateInputName(currency,"currency_symbol"));
        }

        function generateInputName(currency,keyword) {
            // return "gateway_currency['"+currency+"']['"+keyword+"']";
            return 'gateway_currency['+currency+']['+keyword+']';
        }
    </script>
@endpush
