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
                <h5 class="title">{{ $page_title }}</h5>
            </div>
            <div class="table-responsive">
                <div class="table-area">
                    <div class="table-wrapper">
                        <div class="table-header">
                            <h5 class="title">{{ __("User Login Logs") }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>IP</th>
                                        <th>MAC</th>
                                        <th>Location</th>
                                        <th>Browser | OS</th>
                                        <th>Login at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $key => $item)
                                        <tr>
                                            <td>{{ $key + $logs->firstItem() }}</td>
                                            <td>{{ $item->ip }}</td>
                                            <td>{{ $item->mac }}</td>
                                            <td>{{ $item->country }},{{ $item->city }}</td>
                                            <td>{{ $item->browser }} ,{{ $item->os }}</td>
                                            <td>{{ $item->created_at->format("d-m-Y H:i:s") }}</td>
                                        </tr>
                                    @empty
                                        @include('admin.components.alerts.empty',['colspan' => 6])
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ get_paginate($logs) }}
    </div>
@endsection

@push('script')
@endpush
