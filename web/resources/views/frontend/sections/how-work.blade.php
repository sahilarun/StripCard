@php
$lang = selectedLang();
$work_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::WORK_SECTION);
$work = App\Models\Admin\SiteSections::getData( $work_slug)->first();
@endphp
<section class="how-it-works-section ptb-80">
    <div class="container">
        <div class="row how-it-works-wrapper justify-content-center">
            <div class="how-its-work-title pb-5">
                <span class="text--base"> {{ __(@$work->value->language->$lang->title) }}</span>
                <h2 class="title pt-2">{{ __(@$work->value->language->$lang->sub_title) }}</h2>
            </div>
            @if(isset($work->value->items))
            @php
                $num =0
            @endphp
            @foreach($work->value->items ?? [] as $key => $item)
            @php
                $num += 1;
            @endphp
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="how-it-work-number">
                    <span>0{{  @$num }}</span>
                </div>
                <div class="how-it-work-area">
                    <div class="how-it-work-icon">
                        <i class="{{ @$item->language->$lang->icon }}"></i>
                    </div>
                    <div class="how-it-work-title">
                        <h3 class="title">{{ @$item->language->$lang->name }}</h3>
                        <p>{{ @$item->language->$lang->details }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</section>
