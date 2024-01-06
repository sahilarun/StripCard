<div class="settings-sidebar-area" id="settings-sidebar-area">
    <div class="settings-sidebar-header">
        <h5 class="title">{{ __("Settings") }}</h5>
    </div>
    <div class="settings-sidebar-body">
        <div class="language-area">
            <h5 class="title">{{ __("Language") }}</h5>
            <div class="radio-wrapper">
                <div class="radio-item">
                    <input type="radio" id="test-default" value="en" name="lang_switch" @if (app()->currentLocale() == language_const()::NOT_REMOVABLE) checked @endif>
                    <label for="test-default">English</label>
                </div>
                @foreach ($__languages->where("code","!=",language_const()::NOT_REMOVABLE) as $key => $item)
                    <div class="radio-item">
                        <input type="radio" id="test{{$key}}" value="{{ $item->code }}" name="lang_switch" @if (app()->currentLocale() == $item->code) checked @endif>
                        <label for="test{{$key}}">{{ $item->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="layout-area">
            <h5 class="title">{{ __("Layout Mode") }}</h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span>{{ __("Dark Mode") }}</span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="layout-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area topbar-layout-area">
            <h5 class="title">{{ __("Topbar Color") }}</h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span>{{ __("Light Mode") }}</span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="topbar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area sidebar-layout-area">
            <h5 class="title">{{ __("Sidebar Color") }}</h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span>{{ __("Dark Mode") }}</span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="sidebar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area min-sidebar-layout-area">
            <h5 class="title">{{ __("Min Sidebar Color") }}</h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span>{{ __("Dark Mode") }}</span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="min-sidebar-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-area direction-layout-area">
            <h5 class="title">{{ __("Direction") }}</h5>
            <div class="layout-wrapper">
                <div class="layout-content">
                    <span>{{ __("RTL Support") }}</span>
                </div>
                <div class="layout-tab">
                    <span class="layout-tab-switcher" id="direction-tab-switcher"></span>
                </div>
            </div>
        </div>
        <div class="layout-btn">
            
        </div>
    </div>
</div>

@push('script')
    <script>
        $("input[name=lang_switch]").change(function(){
            var submitForm = `<form action="{{ setRoute('admin.languages.switch') }}" id="local_submit" method="POST"> @csrf <input type="hidden" name="target" value="${$(this).val()}" ></form>`;
            $("body").append(submitForm);
            $("#local_submit").submit();
        });
    </script>
@endpush
