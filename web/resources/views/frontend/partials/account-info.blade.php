@php
    $app_mode = strtolower(env('APP_MODE'));

@endphp
<section class="account-section">
    <div class="account-bg"></div>
    <div class="account-area change-form">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-center">
                <a href="{{ setRoute('index') }}" class="site-logo">
                    <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                    data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                        alt="site-logo">
                </a>
            </div>
            <h5 class="title">{{ __("Login Information") }}</h5>
            <form action="{{ setRoute('user.login.submit') }}" method="POST" class="account-form">
                @csrf
                <div class="row ml-b-20">
                    <div class="col-lg-12 form-group">
                        <input type="email" required class="form-control form--control" name="credentials" placeholder="{{__("Email")}}" spellcheck="false" data-ms-editor="true" value="{{@$app_mode == 'demo' ? 'user@appdevs.net': old('credentials') }}">
                    </div>
                    <div class="col-lg-12 form-group show_hide_password">
                        <input type="password" name="password" class="form-control form--control  "  placeholder="{{ __("Password") }}" required value="{{ @$app_mode == 'demo' ? 'appdevs':'' }}">
                        <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>

                    </div>
                    <div class="col-lg-12 form-group">
                        <div class="forgot-item">
                            <label><a href="{{ setRoute('user.password.forgot') }}">{{ __("Forgot Password?") }}</a></label>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100 btn-loading">{{ __("Login Now") }}</button>
                    </div>
                    <div class="or-area">
                        <span class="or-line"></span>
                        <span class="or-title">Or</span>
                        <span class="or-line"></span>
                    </div>
                    @if($basic_settings->user_registration)
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label>{{ __("Don't Have An Account?") }} <a href="javascript:void(0)" class="account-control-btn">{{ __("Register Now") }}</a></label>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="account-area">
        <div class="account-close"></div>
        <div class="account-form-area">
            <div class="account-logo text-center">
                <a class="site-logo" href="index.html"><img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                    data-dark_img="{{ get_logo($basic_settings,'dark') }}" alt="logo"></a>
            </div>
            <h5 class="title">{{__("Register Information")}}</h5>
            <p>{{ __("Please input your details and register to your account to get access to your dashboard.") }}</p>
            <form class="account-form" action="{{ setRoute('user.register.submit') }}" method="POST">
                @csrf
                <div class="row ml-b-20">
                    <div class="col-lg-6 form-group">

                            <input type="text" class="form-control form--control" name="firstname" placeholder="{{ __("First Name") }}" required value="{{ old('firstname') }}">
                    </div>
                    <div class="col-lg-6 form-group">
                    <input type="text" class="form-control form--control" name="lastname" placeholder="{{ __("Last Name") }}" required value="{{ old('lastname') }}">
                    </div>
                    <div class="col-lg-12 form-group">
                            <input type="email" class="form-control form--control" name="register_email" placeholder="{{ __("Email") }}" required value="{{ old('register_email') }}">
                    </div>
                    <div class="col-lg-12 form-group show_hide_password">
                            <input type="password" name="register_password" class="form-control form--control" required placeholder="{{ __("Password") }}">
                            <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    </div>
                        @if($basic_settings->agree_policy)
                    <div class="col-lg-12 form-group">
                        <div class="custom-check-group">
                            <input type="checkbox" id="level-1" name="agree" required>
                            <label for="level-1">{{ __("I have agreed with") }} <a href="javascript:void(0)">{{ __("Terms Of Use & Privacy Policy") }}</a></label>
                        </div>

                    </div>
                    @endif
                    <div class="col-lg-12 form-group text-center">
                        <button type="submit" class="btn--base w-100 btn-loading">{{__("Register Now")}}</button>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="account-item">
                            <label>{{ __("Already Have An Account?") }} <a href="javascript:void(0)" class="account-control-btn">{{ __("Login Now") }}</a></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@push('script')
@php
     $errorName ='';
@endphp
@if($errors->any())
@php
    $error = (object)$errors;
    $msg = $error->default;
    $messageNames  = $msg->keys();
    $errorName = $messageNames[0];
@endphp
@endif
<script>
    var error = "{{  $errorName }}";
  if(error == 'credentials' ){
    $('.account-section').addClass('active');
  }
  if(
    error == 'firstname' ||
    error == 'agree' ||
    error == 'register_password' ||
    error == 'register_email' ||
    error == 'lastname'
  ){
    $('.account-section').addClass('active');
    $('.account-area').toggleClass('change-form');
  }
</script>
@endpush
