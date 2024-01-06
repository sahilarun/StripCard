@php
 $lang = selectedLang();
 $statistics_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::STATISTICS_SECTION);
 $statistics = App\Models\Admin\SiteSections::getData( $statistics_slug)->first();

@endphp
<section class="statistics-section ptb-20">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="counter">
                    <i class="las la-users"></i>
                    <div class="odo-area">
                        <h2 class="odo-title odometer" data-odometer-final="{{ @$statistics->value->language->$lang->total_users }}">0</h2>
                    </div>
                    <h4 class="title">{{ __("Total User") }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="counter">
                    <i class="las la-smile"></i>
                    <div class="odo-area">
                        <h2 class="odo-title odometer" data-odometer-final="{{ @$statistics->value->language->$lang->happy_users }}">0</h2>
                    </div>
                    <h4 class="title">{{ __("Happy User") }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="counter">
                    <i class="las la-share-alt"></i>
                    <div class="odo-area">
                        <h2 class="odo-title odometer" data-odometer-final="{{ @$statistics->value->language->$lang->total_service }}">0</h2>
                    </div>
                    <h4 class="title">{{ __("Service") }}</h6>
                </div>
            </div>
        </div>
    </div>
</section>
