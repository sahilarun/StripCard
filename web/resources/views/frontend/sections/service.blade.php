@php
    $lang = selectedLang();
    $service_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::SERVICE_SECTION);
    $service = App\Models\Admin\SiteSections::getData( $service_slug)->first();

@endphp
<section class="service-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 text-center">
                <div class="section-header">
                    <span class="text--base">{{ __(@$service->value->language->$lang->heading) }}</span>
                    <h2 class="section-title">{{ __(@$service->value->language->$lang->sub_heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row mb-30-none">

            @if(isset($service->value->items))
                @foreach($service->value->items ?? [] as $key => $item)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="service-item">
                        <div class="service-icon">
                            <img src="{{ get_image(@$item->image ,'site-section') }}" alt="icon">
                        </div>
                        <div class="service-content">
                            <h3 class="title">{{ __(@$item->language->$lang->title )}}</h3>
                            <p>{{ __(@$item->language->$lang->sub_title )}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

    </div>
</section>
