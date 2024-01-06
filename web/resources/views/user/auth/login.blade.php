
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
                <h3 class="title">Login Information</h3>
                <p>Please input your username and password and login to your account to get access to your dashboard.</p>
                <form action="{{ setRoute('user.login.submit') }}" method="POST">
                    @csrf
                    <div class="row ml-b-20">
                        <div class="col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'name'          => "credentials",
                                'placeholder'   => "Username OR Email Address",
                                'required'      => true,
                            ])
                        </div>
                        <div class="col-lg-12 form-group">
                            <input type="password" class="form-control form--control" name="password" placeholder="Password">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="forgot-item">
                                <label><a href="{{ setRoute('user.password.forgot') }}" class="text--base">Forgot Password?</a></label>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group text-center">
                            <button type="submit" class="btn--base w-100">Login Now</button>
                        </div>
                        <div class="or-area">
                            <span class="or-line"></span>
                            <span class="or-title">Or</span>
                            <span class="or-line"></span>
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="account-form-btn">
                                <a href="{{ setRoute('user.social.auth.facebook') }}" class="facebook">
                                    <svg viewBox="0 0 24 24" width="24" height="24" class="SvgIcon__SvgIconStyled-sc-1fos6oe-0 hbbopy"><path d="M13.213 5.22c-.89.446-.606 3.316-.606 3.316h3.231v2.907h-3.23v10.359H8.773V11.444H6.39V8.536h2.423c-.221 0 .12-2.845.146-3.114.136-1.428 1.19-2.685 2.544-3.153 1.854-.638 3.55-.286 5.385.17l-.484 2.504s-2.585-.455-3.191.277z"></path></svg>
                                </a>
                                <a href="{{ setRoute('user.social.auth.google') }}" class="google">
                                    <svg viewBox="0 0 24 24" width="24" height="24" class="SvgIcon__SvgIconStyled-sc-1fos6oe-0 hbbopy"><path d="M15.303 8.287l2.26-2.206C16.174 4.791 14.368 4 12.206 4a8 8 0 0 0-7.151 4.412l2.588 2.01c.65-1.93 2.446-3.326 4.563-3.326 1.504 0 2.518.649 3.096 1.191zm4.59 3.897c0-.659-.054-1.139-.17-1.637h-7.516v2.97h4.412c-.089.74-.569 1.851-1.636 2.598l2.526 1.957c1.512-1.396 2.384-3.451 2.384-5.888zm-12.24 1.405a4.928 4.928 0 0 1-.267-1.583c0-.552.098-1.086.258-1.584l-2.588-2.01a8.013 8.013 0 0 0-.854 3.594c0 1.29.311 2.508.854 3.593l2.597-2.01zm4.554 6.422c2.162 0 3.976-.711 5.302-1.939l-2.526-1.957c-.676.472-1.584.8-2.776.8-2.117 0-3.914-1.396-4.554-3.326l-2.588 2.01c1.316 2.615 4.011 4.412 7.142 4.412z"></path></svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="account-item mt-10">
                                <label>
                                    {{ __("Don't Have An Account?") }} <a href="{{ setRoute('user.register') }}" class="text--base">{{ __("Register Now") }}</a>
                                    </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="account-footer text-center">
            <p>{{ __(@$auth->value->language->$defualt->footer_text) }} <a href="{{route('index')}}" class="text--base">{{ $basic_settings->site_name }}.</a></p>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')

@endpush
