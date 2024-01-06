
@php
    $lang = selectedLang();
    $footer_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FOOTER_SECTION);
    $footer = App\Models\Admin\SiteSections::getData( $footer_slug)->first();
    $type =  Illuminate\Support\Str::slug(App\Constants\GlobalConst::USEFUL_LINKS);
    $policies = App\Models\Admin\SetupPage::orderBy('id')->where('type', $type)->where('status',1)->get();

@endphp
<footer class="footer-section pt-80 ">
    <div class="container">
        <div class="footer-top-area">
            <div class="footer-widget-wrapper">
                        <div class="futter-logo">
                            <a class="site-logo site-title" href="{{ setRoute('index') }}">
                                <img src="{{ get_logo($basic_settings) }}"  data-white_img="{{ get_logo($basic_settings,'white') }}"
                                data-dark_img="{{ get_logo($basic_settings,'dark') }}"
                                    alt="site-logo">
                            </a>
                        </div>
                    <div class="col-lg-6">
                        <P>{{ __(@$footer->value->language->$lang->details) }}</P>
                    </div>
                    <div class="col-lg-3">
                        <ul class="footer-list">
                            @foreach ($policies ?? [] as $key=> $data)
                            <li><a href="{{ setRoute('useful.link',$data->slug) }}">{{ @$data->title->language->$lang->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
              </div>
         </div>
        <div class="footer-bottom-area d-flex justify-content-between">
            <div class="copyright-area">
                <p>{{ __(@$footer->value->language->$lang->footer_text) }} <a class="fw-bold" href="{{ setRoute('index') }}"><span>{{ $basic_settings->site_name }}</span></a></p>
            </div>
            <div class="social-area">
                <ul class="footer-social">
                    @if(isset($footer->value->items))
                    @foreach($footer->value->items ?? [] as $key => $item)
                    <li><a href="{{ @$item->language->$lang->link }}" target="_blank"><i class="{{ @$item->language->$lang->social_icon }}"></i></a></li>
                    @endforeach
                @endif
                </ul>
            </div>
        </div>
    </div>
</footer>
