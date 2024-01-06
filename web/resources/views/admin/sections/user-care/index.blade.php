@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('User Care'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Users") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.search-input',[
                        'name'  => 'user_search',
                    ])
                </div>
            </div>
            <div class="table-responsive">
                @include('admin.components.data-table.user-table',compact('users'))
            </div>
        </div>
        {{ get_paginate($users) }}
    </div>
@endsection

@push('script')
    <script>
        itemSearch($("input[name=user_search]"),$(".user-search-table"),"{{ setRoute('admin.users.search') }}");
    </script>
@endpush
