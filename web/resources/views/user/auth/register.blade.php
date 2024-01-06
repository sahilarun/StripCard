@extends('frontend.layouts.auth')
@php
    $defualt = get_default_language_code()??'en';
    $auth_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::AUTH_SECTION);
    $auth = App\Models\Admin\SiteSections::getData( $auth_slug)->first();

@endphp

@section('content')
   <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section bg_img" data-background="{{ get_image(@$auth->value->images->auth_image,'site-section') }}">
    <div class="account-shape">
        <img src="{{ asset('public/frontend/') }}/images/banner/bottom-shape.png" alt="shape">
    </div>
    <div class="right float-end">
        <div class="account-header text-center">
            <a class="site-logo" href="{{ setRoute('index') }}">
                <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                    alt="site-logo">
            </a>
        </div>
        <div class="account-middle">
            <div class="account-form-area">
                <h3 class="title">Register Information</h3>
                <p>Please input your details and register to your account to get access to your dashboard.</p>
                <form class="account-form" action="{{ setRoute('user.register.submit') }}" method="POST">
                    @csrf
                    <div class="row ml-b-20">
                        <div class="col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'name'          => "firstname",
                                'placeholder'   => "First Name",
                                'value'         => old("firstname"),
                            ])
                        </div>
                        <div class="col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'name'          => "lastname",
                                'placeholder'   => "Last Name",
                                'value'         => old("lastname"),
                            ])
                        </div>
                        <div class="col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'type'          => "email",
                                'name'          => "email",
                                'placeholder'   => "Email",
                                'value'         => old("email"),
                            ])
                        </div>
                        <div class="col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'type'          => "password",
                                'name'          => "register_password",
                                'placeholder'   => "password",
                                'value'         => old("register_password"),
                            ])
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="form-group custom-check-group mb-0">
                                <input type="checkbox" id="level-1" name="agree">
                                <label for="level-1" class="mb-0">{{ __("I have read agreed with the") }} <a href="javascrip:void(0)" class="text--base">{{ __("Terms Of Use , Privacy Policy & Warning") }}</a></label>
                            </div>
                            @error("agree")
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-12 form-group text-center">
                            <button type="submit" class="btn--base w-100">Register Now</button>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="account-item mt-10">
                                <label>Already Have An Account? <a href="{{ route('user.login') }}" class="text--base">Login
                                        Now</a></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="account-footer text-center">
            <p>{{ __(@$auth->value->language->$defualt->footer_text) }} <a href="{{route('index')}}" class="text--base">{{ $basic_settings->site_name }}</a></p>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
    <script>
        getAllCountries("{{ setRoute('global.countries') }}",$(".country-select"));
        $(document).ready(function(){
            $("select[name=country]").change(function(){
                var phoneCode = $("select[name=country] :selected").attr("data-mobile-code");
                placePhoneCode(phoneCode);
            });

            setTimeout(() => {
                var phoneCodeOnload = $("select[name=country] :selected").attr("data-mobile-code");
                placePhoneCode(phoneCodeOnload);
            }, 400);
        });
    </script>

@endpush
