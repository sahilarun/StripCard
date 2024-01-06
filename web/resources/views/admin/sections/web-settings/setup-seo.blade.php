@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder,.fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            min-height: 300px !important;
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
            <h6 class="title">{{ __("Search Engine Optimization (SEO)") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.web.settings.setup.seo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => "Thumbnail Image:",
                            'class'             => "file-holder",
                            'name'              => "image",
                            'old_files'         => $setup_seo->image,
                            'old_files_path'    => files_asset_path('seo'),
                        ])
                    </div>
                    <div class="col-xl-8 col-lg-8">
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Social Title*",
                                'type'          => "text",
                                'class'         => "form--control",
                                'placeholder'   => "Title Here...",
                                'name'          => "title",
                                'attribute'     => "data-limit=120",
                                'value'         => old('title',$setup_seo->title)
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.textarea',[
                                'label'         => "Social Description*",
                                'class'         => "form--control",
                                'value'         => "Write Here...",
                                'name'          => "desc",
                                'attribute'     => "data-limit=255",
                                'value'         => old('desc',$setup_seo->desc)
                            ])
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>{{ __("Tags*") }}</label>
                        <select name="tags[]" class="form-control select2-auto-tokenize"  multiple="multiple" required>
                            @foreach ($setup_seo->tags ?? [] as $item)
                                <option value="{{ $item }}" selected>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.web.settings.setup.seo.update",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        
    </script>
@endpush