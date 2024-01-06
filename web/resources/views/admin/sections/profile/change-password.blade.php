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
    ], 'active' => __("Password Change")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">Password Change</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.profile.change.password.update') }}" method="POST">
                @csrf
                @method("PUT")
                <div class="row">
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-password',[
                            'label'         => 'Current Password*',
                            'placeholder'   => '********' ,
                            'name'          => 'current_password',
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-password',[
                            'label'         => 'New Password*',
                            'placeholder'   => '********' ,
                            'name'          => 'password',
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-password',[
                            'label'         => 'Confirm Password*',
                            'placeholder'   => '********' ,
                            'name'          => 'password_confirmation',
                        ])
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <button type="submit" class="btn--base w-100 btn-loading">{{ __("Save & Change") }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
        
@endpush