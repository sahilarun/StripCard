
@extends('frontend.layouts.master')

@section('content')
    <section class="forgot-password ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5">
                    <div class="forgot-password-area">
                        <div class="account-wrapper">
                            <div class="account-logo text-center">
                                <a href="{{ setRoute('index') }}" class="site-logo">
                                    <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                                    data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                                        alt="site-logo">
                                </a>
                            </div>
                            <div class="forgot-password-content ptb-30">
                                <h3 class="title">{{ __("Forgot Password?") }}</h3>
                                <p>{{ __("Enter your email and we'll send you a otp to reset your password.") }}</p>
                            </div>
                            <form action="{{ setRoute('user.password.forgot.send.code') }}" class="card-form" method="POST">
                                @csrf
                                <div class="row ml-b-20">
                                    <div class="col-lg-12 form-group">

                                       <input type="email" required class="form-control form--control" name="user" placeholder="{{ __("Email") }}" value="{{old('user')}}">
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" class="btn--base btn w-100 btn-loading">{{ __("Send OTP") }}</button>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <div class="account-item">
                                            <label>{{ __("Already Have An Account?") }} <a href="javascript:void(0)" class="header-account-btn">{{ __("Login Now") }}</a></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush
