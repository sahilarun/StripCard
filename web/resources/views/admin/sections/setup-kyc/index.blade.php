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
    ], 'active' => __("Setup KYC")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">Setup KYC</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table two">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kycs as $item)
                            <tr>
                                <td>{{ ucwords($item->slug) }}</td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'label'         => false,
                                        'name'          => 'status',
                                        'options'       => ['Active' => 1 , 'Deactive' => 0],
                                        'onload'        => true,
                                        'value'         => $item->status,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.setup.kyc.status.update",   
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'href'          => setRoute('admin.setup.kyc.edit',$item->slug),
                                        'permission'    => "admin.setup.kyc.edit",
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 3])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        switcherAjax("{{ route('admin.setup.kyc.status.update') }}");
    </script>
@endpush