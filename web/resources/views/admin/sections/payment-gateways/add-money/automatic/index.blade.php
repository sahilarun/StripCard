@extends('admin.layouts.master')


@push('css')
    <style>
        .fileholder {
            min-height: 194px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 150px !important;
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
    ], 'active' => __("Add Money")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Automatic Add Money") }}</h5>
                @env('local')
                    <div class="table-btn-area">
                        @include('admin.components.link.add-default',[
                            'href'          => "#p-gateway-automatic-add",
                            'class'         => "modal-btn",
                            'text'          => "Add New",
                            'permission'    => "admin.payment.gateway.store",
                        ])
                    </div>
                @endenv
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Gateway</th>
                            <th>Supported Currency</th>
                            <th>Enabled Currency</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payment_gateways as $item)


                            <tr>
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image,'payment-gateways') }}" alt="image"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ count($item->supported_currencies ?? []) }}</td>
                                <td>{{ count(@$item->currencies) }}</td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'          => 'status',
                                        'data_target'   => $item->id,
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1, 'Disabled' => 0],
                                        'onload'        => true,
                                        'permission'    => "admin.payment.gateway.status.update",
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'href'          => setRoute('admin.payment.gateway.edit',['add-money','automatic',$item->alias]),
                                        'permission'    => "admin.payment.gateway.edit",
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal START --}}
    @if (admin_permission_by_name("admin.payment.gateway.store"))
        @env('local')
            <div id="p-gateway-automatic-add" class="mfp-hide large">
                <div class="modal-data">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __("Add Automatic Gateway (Add Money)") }}</h5>
                    </div>
                    <div class="modal-form-data">
                        <form class="modal-form" method="POST" action="{{ setRoute('admin.payment.gateway.store',['add-money','automatic']) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                    <label for="gatewayImage">{{ __("Gateway Image") }}</label>
                                    <div class="col-12 col-sm-3 m-auto">
                                        @include('admin.components.form.input-file',[
                                            'label'         => false,
                                            'class'         => "file-holder m-auto",
                                            'name'          => "image",
                                        ])
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'         => "Gateway Name*",
                                        'name'          => "gateway_name",
                                        'data_limit'    => 60,
                                        'value'         => old('gateway_name'),
                                    ])
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.input',[
                                        'label'         => "Gateway Title*",
                                        'name'          => "gateway_title",
                                        'data_limit'    => 60,
                                        'value'         => old('gateway_title'),
                                    ])
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    @include('admin.components.form.select',[
                                        'label'     => "Supported Currencies*",
                                        'name'      => "supported_currencies[]",
                                        'multiple'  => true,
                                        'attribute' => "required",
                                        'class'     => "select2-auto-tokenize",
                                    ])
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group">
                                    <div class="custom-inner-card input-field-generator" data-source="add_money_automatic_gateway_credentials_field">
                                        <div class="card-inner-header">
                                            <h6 class="title">{{ __("Genarate Fields") }}</h6>
                                            <button type="button" class="btn--base add-row-btn"><i class="fas fa-plus"></i> {{ __("Add") }}</button>
                                        </div>
                                        <div class="card-inner-body">
                                            <div class="results">
                                                <div class="row align-items-end">
                                                    <div class="col-xl-3 col-lg-3 form-group">
                                                        @include('admin.components.form.input',[
                                                            'label'     => "Title*",
                                                            'name'      => "title[]",
                                                        ])
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 form-group">
                                                        @include('admin.components.form.input',[
                                                            'label'     => "Name*",
                                                            'name'      => "name[]",
                                                        ])
                                                    </div>

                                                    <div class="col-xl-5 col-lg-5 form-group">
                                                        @include('admin.components.form.input',[
                                                            'label'     => "Value",
                                                            'name'      => "value[]",
                                                        ])
                                                    </div>

                                                    <div class="col-xl-1 col-lg-1 form-group">
                                                        <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                    <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                                    <button type="submit" class="btn btn--base">{{ __("Add") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endenv
    @endif

@endsection

@push('script')
    <script>
        $(document).ready(function(){
            openModalWhenError("automatic-add-money","#p-gateway-automatic-add");
            switcherAjax("{{ setRoute('admin.payment.gateway.status.update') }}");
        });
    </script>
@endpush
