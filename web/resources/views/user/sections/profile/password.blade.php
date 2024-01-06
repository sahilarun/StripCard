@extends('user.layouts.master')

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __($page_title)])
@endsection

@section('content')
<div class="card-area pt-60">
    <div class="row justify-content-center mb-30-none">
        <div class="col-xl-8 col-lg-12 mb-30">
            <div class="card custom--card mb-30">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h4 class="card-title mb-0">{{ __("Change Password") }}</h4>
                </div>
                <div class="card-body">
                    <div class="card-form-wrapper">
                        <form action="{{ setRoute('user.profile.password.update') }}" method="POST" role="form">
                            @csrf
                            @method("PUT")
                            <div class="row justify-content-center mb-10-none">
                                <div class="col-xl-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'     => "Current Password<span>*</span>",
                                        'name'      => "current_password",
                                        'type'      => "password",
                                        'placeholder'   => "Enter Password...",
                                    ])
                                </div>
                                <div class="col-xl-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'     => "New Password<span>*</span>",
                                        'name'      => "password",
                                        'type'      => "password",
                                        'placeholder'   => "Enter Password...",
                                    ])
                                </div>
                                <div class="col-xl-12 form-group">
                                    @include('admin.components.form.input',[
                                    'label'     => "Confirm Password<span>*</span>",
                                    'name'      => "password_confirmation",
                                    'type'      => "password",
                                    'placeholder'   => "Enter Password...",
                                ])
                                </div>
                                <div class="col-xl-12 form-group">
                                    <button type="submit" class="btn--base mt-10">{{ __("Change") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
