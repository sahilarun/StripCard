@php
    $lang = selectedLang();
    $feature_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::OUR_FEATURE);
    $feature = App\Models\Admin\SiteSections::getData( $feature_slug)->first();
@endphp
<section class="feature-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="feature-content-wrapper">
                    <div class="feature-content-header">
                        <span class="text--base">{{ __(@$feature->value->language->$lang->heading) }}</span>
                        <h2 class="title pt-3">{{ __(@$feature->value->language->$lang->sub_heading) }}</h2>
                        <p>{{ __(@$feature->value->language->$lang->details) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="row">
                    @if(isset($feature->value->items))
                        @foreach($feature->value->items ?? [] as $key => $item)
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="feature-item">
                                <div class="feature-content">
                                    <h3 class="title">{{ @$item->language->$lang->title }}</h3>
                                    <p>{{ @$item->language->$lang->sub_title }}</p>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
