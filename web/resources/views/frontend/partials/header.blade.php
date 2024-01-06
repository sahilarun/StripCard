<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@php
    $type = App\Constants\GlobalConst::SETUP_PAGE;
    $menues = DB::table('setup_pages')
            ->where('status', 1)
            ->where('type', Str::slug($type))
            ->get();
@endphp
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container custom-container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ setRoute('index') }}">
                            <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                            data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                                alt="site-logo">
                        </a>

                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto">
                                @php
                                $current_url = URL::current();
                            @endphp
                            @foreach ($menues as $item)
                                @php
                                    $title = json_decode($item->title);
                                @endphp
                                <li><a href="{{ url($item->url) }}" class="@if ($current_url == url($item->url)) active @endif">{{ __($title->title) }}</a></li>
                            @endforeach
                            </ul>
                            <select class="language-select langSel">
                                @foreach($__languages as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{$item->name }}</option>
                                @endforeach
                            </select>
                            <div class="header-action">
                                @auth
                                    @if(auth()->user()->email_verified == 0)
                                    <button class="btn--base header-account-btn">{{ __("Login Now") }}</button>
                                    @else
                                     <a href="{{ setRoute('user.dashboard') }}" class="btn--base">{{__("Dashboard")}}</a>
                                    @endif

                                @else
                                <button class="btn--base header-account-btn">{{ __("Login Now") }}</button>
                                @endauth
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
