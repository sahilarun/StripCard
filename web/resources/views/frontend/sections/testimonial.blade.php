
@php
    $lang = selectedLang();
    $testimonial_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TESTIMONIAL_SECTION);
    $testimonial = App\Models\Admin\SiteSections::getData( $testimonial_slug)->first();
    $testimonial_items = (array)@$testimonial->value->items;
    $totalTestimonial = count(@$testimonial_items);

@endphp
<section class="testimonial-section ptb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="customer-says">
                  <h2 class="title">{{ __(@$testimonial->value->language->$lang->title) }}</h2>
                  <p>{{ __(@$testimonial->value->language->$lang->sub_heading) }}</p>
                  <div class="client-img d-flex">
                    @if(isset($testimonial->value->items))
                    @foreach($testimonial->value->items ?? [] as $key => $item)
                    @if($loop->iteration <= 3)
                    <div class="img-1 ps-2">
                        <img src="{{ get_image(@$item->image ,'site-section') }}">
                    </div>
                    @endif
                    @endforeach
                    @endif

                  </div>
                  <div class="comment pt-2">
                    <P><span class="text--base">{{ @$totalTestimonial }}+</span> Customer Reviews</P>
                  </div>
                </div>
             </div>
              <div class="col-lg-6 col-md-6">
                 <div class="testimonial-section">
                     <div class="testimonial-slider">
                         <div class="swiper-wrapper">
                            @if(isset($testimonial->value->items))
                            @foreach($testimonial->value->items ?? [] as $key => $item)
                             <div class="swiper-slide">
                                 <div class="testimonial-wrapper">
                                    <div class="testimonial-ratings">
                                        @php
                                            $rating = $item->language->$lang->rating??"5";
                                        @endphp
                                         @for($i = 0; $i <  $rating ; $i++)
                                         <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                     <p>{{ __(@$item->language->$lang->details )}}</p>
                                     <div class="client-details d-flex justify-content-between">
                                         <div class="client-img">
                                             <img src="{{ get_image(@$item->image ,'site-section') }}" alt="client">
                                         </div>
                                         <div class="client-title text--base">
                                             <h4 class="title text--base">{{ __(@$item->language->$lang->name )}}</h4>
                                             <P>{{ __(@$item->language->$lang->designation )}}</P>
                                         </div>
                                    </div>
                                 </div>
                             </div>
                             @endforeach
                             @endif
                         </div>
                      <div class="swiper-pagination"></div>
                  </div>
              </div>
        </div>
    </div>
</section>
