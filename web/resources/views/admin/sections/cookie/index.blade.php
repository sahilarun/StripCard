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
    ], 'active' => __("GDPR Cookie")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("GDPR Cookie") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.cookie.update') }}" method="POST">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-8 form-group">
                        <label>{{ __("Policy Link*") }}</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">{{ url('/') }}/</span>
                            <input type="text" class="form--control" placeholder="link" name="link" value="{{ $site_cookie->value->link }}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 form-group">
                        @include('admin.components.form.switcher',[
                            'label'     => "Status*",
                            'name'      => "status",
                            'options'   => ["Enable" => 1, "Disabled" => 0],
                            'value'     => old('status',$site_cookie->value->status),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-text-rich',[
                            'label'     => "Description*",
                            'name'      => "desc",
                            'value'     => $site_cookie->value->desc,
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Submit",
                            'permission'    => "admin.cookie.update"
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
