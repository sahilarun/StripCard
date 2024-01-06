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
            <h6 class="title">{{ __("Browser Push Notification Configuration") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.push.notification.update') }}">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            <label>{{ __("Method*") }}</label>
                            @php
                                $selectOptions = ['pusher' => "Pusher (Message Bird)"];
                                $old_value = old('method',$push_notification->method ?? "");
                            @endphp
                            <select class="form--control nice-select mb-10" name="method">
                                <option selected disabled>Select Method</option>
                                @foreach ($selectOptions as $value => $name)
                                    <option value="{{ $value }}" @if ($old_value == $value)
                                        @selected(true)
                                    @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pusher-view input-field-group" style="display: none">
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Instance ID*",
                                    'name'          => "instance_id",
                                    'value'         => old("instance_id", $push_notification->instance_id ?? ""),
                                ])
                            </div>
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Primary key*",
                                    'name'          => "primary_key",
                                    'value'         => old("primary_key", $push_notification->primary_key ?? ""),
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.push.notification.update",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="custom-card mt-3">
        <div class="card-header">
            <h6 class="title">{{ __("Broadcasting/ Internal Notification Configuration") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.broadcast.config.update') }}">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="form-group">
                            <label>{{ __("Method*") }}</label>
                            @php
                                $selectOptions = ['pusher' => "Pusher (Message Bird)"];
                                $old_value = old('broadcast_method',$broadcast_config->method ?? "");
                            @endphp
                            <select class="form--control nice-select mb-10" name="broadcast_method">
                                <option selected disabled>Select Method</option>
                                @foreach ($selectOptions as $value => $name)
                                    <option value="{{ $value }}" @if ($old_value == $value)
                                        @selected(true)
                                    @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pusher-view input-field-group" style="display: none">
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "APP ID*",
                                    'name'          => "broadcast_app_id",
                                    'value'         => old("broadcast_app_id", $broadcast_config->app_id ?? ""),
                                ])
                            </div>
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Primary key*",
                                    'name'          => "broadcast_primary_key",
                                    'value'         => old("broadcast_primary_key", $broadcast_config->primary_key ?? ""),
                                ])
                            </div>
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Secret key*",
                                    'name'          => "broadcast_secret_key",
                                    'value'         => old("broadcast_secret_key", $broadcast_config->secret_key ?? ""),
                                ])
                            </div>
                            <div class="form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Cluster*",
                                    'name'          => "broadcast_cluster",
                                    'value'         => old("broadcast_cluster", $broadcast_config->cluster ?? ""),
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Update",
                            'permission'    => "admin.broadcast.config.update",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $("select[name=method],select[name=broadcast_method]").change(function(){
            var selectedValue = $(this).val();
            $(this).parents("form").find(".input-field-group").slideUp(300);
            $(this).parents("form").find("."+selectedValue+"-view").delay(300).slideDown();
        });
        $(document).ready(function(){
            var selectedMethod = $("select[name=method] :selected").val();
            $("select[name=method]").parents("form").find("."+selectedMethod+"-view").slideDown();

            var selectedMethodTwo = $("select[name=broadcast_method] :selected").val();
            $("select[name=broadcast_method]").parents("form").find("."+selectedMethodTwo+"-view").slideDown();
        });
    </script>
@endpush