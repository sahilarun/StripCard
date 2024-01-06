@extends('frontend.layouts.master')

@php
$lang = selectedLang();
@endphp

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section style-01 ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-4 col-lg-5 mb-30">
                <div class="blog-sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Categories") }}</h4>
                        <div class="category-widget-box">
                            <ul class="category-list">
                                @foreach ($categories ?? [] as $cat)
                                @php
                                    $blogCount = App\Models\Blog::active()->where('category_id',$cat->id)->count();

                                @endphp
                                    @if( $blogCount > 0)
                                    <li><a href="{{ setRoute('blog.by.category',[$cat->id, slug(@$cat->name)]) }}"> {{ __(@$cat->name) }}<span>{{ @$blogCount }}</span></a></li>
                                    @else
                                    <li><a href="javascript:void(0)"> {{ __(@$cat->name) }}<span>{{ @$blogCount }}</span></a></li>
                                    @endif

                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Recent Posts") }}</h4>
                        <div class="popular-widget-box">
                            @foreach ($recentPost as $post)
                            <div class="single-popular-item d-flex flex-wrap align-items-center">
                                <div class="popular-item-thumb">
                                    <a href=" "><img src="{{ get_image(@$post->image,'blog') }}" alt="blog"></a>
                                </div>
                                <div class="popular-item-content">
                                    <span class="date">{{ $post->created_at->diffForHumans() }}</span>
                                    <h5 class="title"><a href="{{route('blog.details',[$post->id, @$post->slug])}}">{{ @$post->name->language->$lang->name }}</a></h5>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="widget-box">
                        <h4 class="widget-title">{{ __("Tags") }}</h4>

                        <div class="tag-widget-box">
                            <ul class="tag-list">
                                @foreach ($blog->tags as $tag)
                                <li><a href="javascript:void(0)">{{ @$tag }}</a></li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb-img">
                                <img src="{{ get_image(@$blog->image,'blog') }}" alt="blog">
                                <span class="category">{{ @$blog->short_title->language->$lang->short_title }}</span>
                            </div>
                            <div class="blog-content">
                                <h4 class="title mb-30">{{ @$blog->name->language->$lang->name }}</h4>
                                @php
                                    echo @$blog->details->language->$lang->details;
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push("script")

@endpush
