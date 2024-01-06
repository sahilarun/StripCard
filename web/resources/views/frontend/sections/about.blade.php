
@php
    $lang = selectedLang();
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about_sections = App\Models\Admin\SiteSections::getData( $about_slug)->first();
@endphp
<section class="about-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-thumb">
                    <img src="{{ get_image(@$about_sections->value->images->image,'site-section') }}" alt="element">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-content-wrapper">
                    <div class="about-content-header">
                        <span class="text--base">{{ __(@$about_sections->value->language->$lang->section_title) }}</span>
                        <h2 class="title pt-3">{{ __(@$about_sections->value->language->$lang->heading) }}</h2>
                        <p>{{ __(@$about_sections->value->language->$lang->sub_heading) }}</p>
                        <div class="about-item pt-4">
                            <div class="row">
                                @if(isset($about_sections->value->items))
                                @foreach($about_sections->value->items ?? [] as $key => $item)
                                <div class="col-lg-6">
                                    <div class="item d-flex">
                                        <div class="item-icon">
                                            <i class="{{ @$item->language->$lang->icon }}"></i>
                                        </div>
                                        <div class="item-name">
                                            <P>{{ __(@$item->language->$lang->title )}}</P>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>