@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 280px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 246px !important;
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
    ], 'active' => __("Admin Profile")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Admin Profile") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" enctype="multipart/form-data" action="{{ setRoute('admin.profile.update') }}">
                @csrf
                @method("PUT")
                <div class="row mb-10-none">
                    <div class="col-xl-3 col-lg-3 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => "Profile Image:",
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files_path'    => files_asset_path('admin-profile'),
                            'old_files'         => $profile->image,
                        ])
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'First Name*',
                                'name'          => 'firstname',
                                'value'         => old('firstname',$profile->firstname),
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Last Name*',
                                'name'          => 'lastname',
                                'value'         => old('lastname',$profile->lastname),
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Email*',
                                'type'          => 'email',
                                'name'          => 'email',
                                'value'         => old('email',$profile->email),
                                'attribute'     => (!auth_is_super_admin()) ? "readonly" : "",
                            ])
                        </div>
                        <div class="form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Phone Number',
                                'name'          => 'phone',
                                'value'         => old('phone',$profile->phone),
                            ])
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @php
                            $old_country = old('country',$profile->country);
                        @endphp
                        <label>{{ __("Country") }}</label>
                        <select name="country" class="form--control select2-auto-tokenize country-select">
                            <option selected disabled>Select Country</option>
                            @foreach ($countries as $item)
                                <option value="{{ $item->name }}" data-id="{{ $item->id }}" {{ ($old_country == $item->name) ? "selected" : "" }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @php
                            $old_state = old('state',$profile->state);
                        @endphp
                        <label>{{ __("State") }}</label>
                        <select name="state" class="form--control select2-auto-tokenize state-select">
                            <option selected disabled>Select State</option>
                            @if ($old_state)
                                <option selected value="{{ $old_state }}">{{ $old_state }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @php
                            $old_city = old('city',$profile->city);
                        @endphp
                        <label>{{ __("City") }}</label>
                        <select name="city" class="form--control select2-auto-tokenize city-select">
                            <option selected disabled>Select City</option>
                            @if ($old_city)
                                <option selected value="{{ $old_city }}">{{ $old_city }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => 'Zip/Postal',
                            'type'          => 'number',
                            'name'          => 'zip_postal',
                            'value'         => old('zip_postal',$profile->zip_postal),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input',[
                            'label'         => 'Address',
                            'name'          => 'address',
                            'value'         => old('address',$profile->address),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <button type="submit" class="btn--base w-100 btn-loading">{{ __("Save & Change") }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            countrySelect(".country-select",$(".country-select").siblings(".select2"));
            stateSelect(".state-select",$(".state-select").siblings(".select2"));
        })
    </script>
@endpush
