<div class="col-xl-4 col-lg-4 mb-10">
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
                            'name'          => "min_limit",
                            'value'         => old("min_limit",0),
                            'currency'      => "-",
                        ])
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                    <div class="form-group">
                        @include('admin.components.form.input-amount',[
                            'label'         => "Maximum",
                            'name'          => "max_limit",
                            'value'         => old("max_limit",0),
                            'currency'      => "-",
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
            <h5 class="title">{{ __("Charge") }}</h5>
        </div>
        <div class="card-inner-body">
            <div class="row">
                <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                    <div class="form-group">
                        @include('admin.components.form.input-amount',[
                            'label'         => "Fixed",
                            'name'          => "fixed_charge",
                            'value'         => old("fixed_charge",0),
                            'currency'      => "-",
                        ])
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                    <div class="form-group">
                        @include('admin.components.form.input-amount',[
                            'label'         => "Percent",
                            'name'          => "percent_charge",
                            'value'         => old("percent_charge",0),
                            'currency'      => "-",
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
                <div class="col-xxl-12 col-xl-12 col-lg-12 form-group">
                    <div class="form-group">
                        <label>{{ __("Rate") }}</label>
                        <div class="input-group">
                            <span class="input-group-text append ">1 &nbsp; <span class="default-currency">{{ get_default_currency_code($default_currency) }}</span>&nbsp; = </span>
                            <input type="number" class="form--control" value="{{ old("rate",0) }}" name="rate" placeholder="Type Here...">
                            <span class="input-group-text currency">-</span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                    <div class="form-group">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
