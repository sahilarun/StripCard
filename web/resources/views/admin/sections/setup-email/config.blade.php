@extends('admin.layouts.master')

@push('css')

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
    ], 'active' => __("Setup Email")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Email Method") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.setup.email.config.update') }}">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row align-items-end">
                            <div class="col-xl-10 col-lg-10 form-group">
                                <label>{{ __("Email Send Method*") }}</label>
                                <select class="form--control nice-select" name="method">
                                    <option disabled selected>Select Method</option>
                                    <option value="smtp" @if (isset($email_config->method) && $email_config->method == "smtp")
                                        @selected(true)
                                    @endif>SMTP</option>
                                </select>
                                @error("method")
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-2 col-lg-2 form-group">
                                <!-- Open Modal For Test Email Send -->
                                @include('admin.components.link.custom',[
                                    'class'         => "btn--base modal-btn w-100",
                                    'href'          => "#test-mail",
                                    'text'          => "Send Mail",
                                    'permission'    => "admin.setup.email.test.mail.send",
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 form-group">
                        @include('admin.components.form.input',[
                            'label'     => "Host*",
                            'name'      => 'host',
                            'value'     => old('host',$email_config->host ?? ""),
                        ])
                    </div>
                    <div class="col-xl-5 col-lg-5 form-group">
                        @include('admin.components.form.input',[
                            'label'     => "Port*",
                            'name'      => 'port',
                            'type'      => 'number',
                            'value'     => old('port',$email_config->port ?? ""),
                        ])
                    </div>
                    <div class="col-xl-2 col-lg-2 form-group">
                        @include('admin.components.form.switcher',[
                            'label'     => "Encryption*",
                            'name'      => 'encryption',
                            'options'   => ['SSL' => "ssl",'TLS' => "tls"],
                            'value'     => old('encryption',$email_config->encryption ?? ""),
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'     => "Username*",
                            'name'      => 'username',
                            'value'     => old('username',$email_config->username ?? ""),
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group" id="show_hide_password">
                        @include('admin.components.form.input-password',[
                            'label'         => 'Password*',
                            'placeholder'   => 'Password' ,
                            'name'          => 'password',
                            'value'         => old('password',$email_config->password ?? ""),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.setup.email.config.update",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Test mail send modal --}}
    @include('admin.components.modals.send-text-mail')

@endsection

@push('script')

@endpush
