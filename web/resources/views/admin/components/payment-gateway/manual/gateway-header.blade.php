<div class="custom-card">
    <div class="card-header">
        <h6 class="title">
            @isset($title)
                {{ __($title) }}
            @endisset
        </h6>
    </div>
    <div class="card-body">
        <div class="row mb-10-none">
            <div class="col-xl-3 col-lg-3 form-group">
                @include('admin.components.form.input-file',[
                    'label'             => "Gateway Image",
                    'class'             => "file-holder",
                    'name'              => "image",
                ])
            </div>
            <div class="col-xl-9 col-lg-9">
                <div class="form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Gateway Name*",
                        'name'          => "gateway_name",
                        'placeholder'   => "ex: Paypal",
                        'value'         => old("gateway_name"),
                        'data_limit'    => 60,
                        'attribute'     => "required",
                    ])  
                </div>
                <div class="form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Currency Name*",
                        'name'          => "currency_name",
                        'placeholder'   => "ex: United State Dollar",
                        'value'         => old("currency_name"),
                        'data_limit'    => 60,
                    ])  
                </div>
                <div class="form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Currency Code*",
                        'name'          => "currency_code",
                        'placeholder'   => "ex: USD",
                        'value'         => old("currency_code"),
                        'class'         => "currency_type",
                        'data_limit'    => 8,
                        'attribute'     => "required",
                    ]) 
                </div>
                <div class="form-group">
                    @include('admin.components.form.input',[
                        'label'         => "Currency Symbol*",
                        'name'          => "currency_symbol",
                        'placeholder'   => "ex: $",
                        'value'         => old("currency_symbol"),
                        'data_limit'    => 10,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>