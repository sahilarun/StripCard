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
    ], 'active' => __("Setup Email")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">Default Template</h6>
        </div>
        <div class="card-body">
            <form class="card-form">
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>Email Body*</label>
                        <div id="div_editor1"></div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <button type="submit" class="btn--base w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    
@endpush