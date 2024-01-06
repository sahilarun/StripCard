@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder-image {
            object-fit: contain;
        }

        .image-dark .fileholder-single-file-view {
            background: #bfbfbf;
        }

        .fileholder {
            min-height: 280px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 236px !important;
        }
    </style>
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
    ], 'active' => __("Web Settings")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.web.settings.image.assets.update') }}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group" style="height: 300px">
                        @include('admin.components.form.input-file',[
                            'label'             => "Logo (Light Version)",
                            'class'             => "file-holder",
                            'name'              => "site_logo",
                            'old_files'         => $basic_settings->site_logo,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group image-dark">
                        @include('admin.components.form.input-file',[
                            'label'             => "Logo (Dark Version)",
                            'class'             => "file-holder",
                            'name'              => "site_logo_dark",
                            'old_files'         => $basic_settings->site_logo_dark,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => "Favicon (Light Version)",
                            'class'             => "file-holder",
                            'name'              => "site_fav",
                            'old_files'         => $basic_settings->site_fav,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group image-dark">
                        @include('admin.components.form.input-file',[
                            'label'             => "Favicon (Dark Version)",
                            'class'             => "file-holder",
                            'name'              => "site_fav_dark",
                            'old_files'         => $basic_settings->site_fav_dark,
                            'old_files_path'    => files_asset_path('image-assets'),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.web.settings.image.assets.update",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    
@endpush