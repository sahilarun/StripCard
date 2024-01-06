@extends('admin.layouts.master')

@push('css')

@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("App Settings")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("App Urls") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.app.settings.urls.update') }}">
                @csrf
                @method("PUT")
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'             => "Title*",
                                'name'              => "url_title",
                                'value'             => old('url_title',$app_settings->url_title),
                                'attribute'         => "data-limit=255",
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'             => "Android App URL*",
                                'name'              => "android_url",
                                'value'             => old('android_url',$app_settings->android_url),
                                'attribute'         => "data-limit=255",
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'             => "iOS App URL",
                                'name'              => "iso_url",
                                'value'             => old('iso_url',$app_settings->iso_url),
                                'attribute'         => "data-limit=255",
                            ])
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <button type="submit" class="btn--base w-100 btn-loading">{{ __("Update") }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    
@endpush