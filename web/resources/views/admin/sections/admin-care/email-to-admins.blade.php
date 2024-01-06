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
    ], 'active' => __("Admin Care")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Email To Admin") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.admins.send.email') }}" method="POST">
                @csrf
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Subject*",
                            'name'          => "subject",
                            'data_limit'    => 150,
                            'placeholder'   => "Write Subject...",
                            'value'         => old('subject'),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-text-rich',[
                            'label'         => "Details*",
                            'name'          => "message",
                            'value'         => old('message'),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'permission'    => "admin.admins.send.email",
                            'text'          => "Send Email",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    
@endpush