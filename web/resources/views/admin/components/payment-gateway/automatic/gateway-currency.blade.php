@isset($gateway)
    <div class="payment-gateway-currencies-wrapper">
        @foreach ($gateway->currencies as $item)
            <div class="custom-card mt-15 gateway-currency" id="{{ Str::lower($item->currency_code) . "-block" }}" data-target="{{ $item->id }}">
                <div class="card-header">
                    <h6 class="currency-title">{{ $item->name }}</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 form-group">
                            @include('admin.components.form.input-file',[
                                'label'             => "Gateway Image",
                                'name'              => "gateway_currency[".$item->currency_code."][image]",
                                'class'             => "file-holder",
                                'old_files_path'    => files_asset_path('payment-gateways'),
                                'old_files'         => $item->image,
                            ])
                        </div>
                        <div class="col-xl-3 col-lg-3 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title">{{ __("Amount Limit") }}</h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                @include('admin.components.form.input-amount',[
                                                    'label'         => "Minimum",
                                                    'name'          => "gateway_currency[".$item->currency_code."][min_limit]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".min_limit",$item->min_limit),
                                                    'currency'      => $item->currency_code,            
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                @include('admin.components.form.input-amount',[
                                                    'label'         => "Maximum",
                                                    'name'          => "gateway_currency[".$item->currency_code."][max_limit]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".max_limit",$item->max_limit),
                                                    'currency'      => $item->currency_code,            
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title">{{ __("Charge") }}</h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                @include('admin.components.form.input-amount',[
                                                    'label'         => "Fixed",
                                                    'name'          => "gateway_currency[".$item->currency_code."][fixed_charge]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".fixed_charge",$item->fixed_charge),
                                                    'currency'      => $item->currency_code,          
                                                ])
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                @include('admin.components.form.input-amount',[
                                                    'label'         => "Percent",
                                                    'name'          => "gateway_currency[".$item->currency_code."][percent_charge]",
                                                    'value'         => old("gateway_currency.".$item->currency_code.".percent_charge",$item->percent_charge),
                                                    'currency'      => "%",          
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 mb-10">
                            <div class="custom-inner-card">
                                <div class="card-inner-header">
                                    <h5 class="title">{{ __("Rate") }}</h5>
                                </div>
                                <div class="card-inner-body">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <label>{{ __("Rate") }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text append ">1 &nbsp; <span class="default-currency">{{ get_default_currency_code($default_currency) }}</span> = </span>
                                                    <input type="number" class="form--control" value="{{ old("gateway_currency.".$item->currency_code.".rate",$item->rate) }}" name="{{ "gateway_currency[".$item->currency_code."][rate]" }}">
                                                    <span class="input-group-text">{{ $item->currency_code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                @include('admin.components.form.input',[
                                                    'label'     => "Symbol",
                                                    'name'      => "gateway_currency[".$item->currency_code."][currency_symbol]",
                                                    'value'     => old("gateway_currency.".$item->currency_code.".currency_symbol",$item->currency_symbol),
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endisset