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
    ], 'active' => __("Push Notification")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Send Notification") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute("admin.push.notification.send") }}">
                @csrf
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Title*",
                                'name'          => "title",
                                'value'         => old("title"),
                                'data_limit'    => 40,
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.textarea',[
                                'label'         => "Notification Body*",
                                'name'          => "body",
                                'data_limit'    => 80,
                            ])
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Send",
                            'permission'    => "admin.push.notification.send",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Latest Notifications") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table two">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $item)
                            <tr>
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ $item->message->icon ?? "" }}" alt="notification"></li>
                                    </ul>
                                </td>
                                <td>{{ Str::words($item->message->title,5,"...") ?? "" }}</td>
                                <td>{{ Str::words($item->message->body,10,"...") ?? "" }}</td>
                                <td>{{ $item->created_at->format("Y-m-d h:i A") }}</td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ get_paginate($notifications) }}
    </div>
@endsection

@push('script')
    
@endpush