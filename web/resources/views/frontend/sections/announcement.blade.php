@php
    $lang = selectedLang();
    $blog_section_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BLOG_SECTION);
    $blog_section = App\Models\Admin\SiteSections::getData( $blog_section_slug)->first();
    $latestBlogs = App\Models\Blog::active()->orderBy('id',"DESC")->limit(3)->get();
@endphp
<section class="blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 text-center">
                <div class="section-header">
                    <span class="text--base">{{ __(@$blog_section->value->language->$lang->title) }}</span>
                    <h2 class="section-title">{{ __(@$blog_section->value->language->$lang->heading) }}</h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
                <div class="row justify-content-center mb-30-none">
                    @foreach ($latestBlogs??[] as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ get_image(@$blog->image,'blog') }}" alt="blog">
                            </div>
                            <div class="blog-content">
                                <h4 class="title"><a href="{{route('blog.details',[$blog->id,$blog->slug])}}">{{ @$blog->name->language->$lang->name }}</a></h4>
                                <p>
                                    {{textLength(strip_tags(@$blog->details->language->$lang->details,120))}}
                                </p>
                                <div class="blog-btn d-flex justify-content-between">
                                    <span><i class="las la-history"></i> {{showDate(@$blog->created_at)}}</span>
                                    <a href="{{route('blog.details',[$blog->id,$blog->slug])}}">Read More <i class="las la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                 @endforeach

                </div>
            </div>

        </div>
    </div>
</section>
