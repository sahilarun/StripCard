
@php
    $lang = selectedLang();
    $start_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::START_SECTION);
    $sartSection = App\Models\Admin\SiteSections::getData( $start_slug)->first();
@endphp
<section class="call-to-action-section ptb-80">
    <div class="container">
        <div class="baner-content bg_img" data-background="{{ get_image(@$sartSection->value->images->image ,'site-section') }}">
            <div class="baner-area ptb-120">
              <h2 class="title">
                {{ __(@$sartSection->value->language->$lang->heading) }}
               </h2>
                  <div class="baner-button">
                      <a href="{{ url('/').'/'.@$sartSection->value->language->$lang->button_link }}" class="btn btn--base ">{{ __(@$sartSection->value->language->$lang->button_name) }}<i class="las la-arrow-right"></i></a>
                  </div>
            </div>
         </div>
    </div>
</section>
