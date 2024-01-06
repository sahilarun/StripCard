@extends('frontend.layouts.master')

@section('content')

    <section class="new-password ptb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5">
                    <div class="new-password-area">
                        <div class="account-wrapper">
                            <span class="account-cross-btn"></span>
                            <div class="account-logo text-center">
                                <a class="site-logo" href="{{ setRoute('index') }}">
                                    <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                                    data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                                        alt="site-logo">
                                </a>
                            </div>
                            <form action="{{ setRoute('user.password.reset',$token) }}" class="account-form" method="POST">
                                @csrf
                                <div class="row ml-b-20">
                                    <label>{{ __("New Password") }}</label>
                                    <div class="col-lg-12 form-group show_hide_password">
                                        <input type="password" required name="password" class="form-control form--control"  placeholder="{{__("Enter Password")}}">
                                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    <label>{{ __("Confirm Password") }}</label>
                                    <div class="col-lg-12 form-group show_hide_password-2">
                                        <input type="password" required name="password_confirmation" class="form-control form--control"  placeholder="{{ __("Enter Confirm Password") }}">
                                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col-lg-12 form-group text-center pt-3">
                                        <button type="submit" class="btn--base w-100 btn-loading">{{ __("Reset") }}</button>
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
