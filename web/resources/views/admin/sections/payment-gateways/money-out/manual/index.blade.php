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
    ], 'active' => __("Money Out")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Money Out") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => setRoute('admin.payment.gateway.create',['money-out','manual']),
                        'text'          => "Add New",
                        'permission'    => "admin.payment.gateway.create",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Gateway</th>
                            <th>Currency Code</th>
                            <th>Currency Symbol</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payment_gateways as $item)
                            <tr data-target="{{ $item->id }}">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image,'payment-gateways') }}" alt="Image"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->currencies()->first()->currency_code }}</td>
                                <td>{{ $item->currencies()->first()->currency_symbol }}</td>
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
                                        'href'          => setRoute('admin.payment.gateway.edit',['money-out','manual',$item->alias]),
                                        'permission'    => "admin.payment.gateway.edit",
                                    ])

                                    @include('admin.components.link.delete-default',[
                                        'class'         => "gateway-delete-btn",
                                        'permission'    => "admin.payment.gateway.remove",
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
@endsection

@push('script')
    <script>
        switcherAjax("{{ setRoute('admin.payment.gateway.status.update') }}");

        // Delete Modal
        $(".gateway-delete-btn").click(function(){
            var targetElement = $(this).parents("tr").attr("data-target");
            var action = "{{ setRoute('admin.payment.gateway.remove') }}"
            var method = '@method("DELETE")';

            openModalByContent(
                {
                    content: `<div class="card modal-alert border-0">
                                <div class="card-body">
                                    <form method="POST" action="${action}">
                                        <input type="hidden" name="_token" value="${laravelCsrf()}">
                                        ${method}
                                        <div class="head mb-3">
                                            Are you sure to delete this <strong>gateway</strong> ?
                                            <input type="hidden" name="target" value="${targetElement}">
                                        </div>
                                        <div class="foot d-flex align-items-center justify-content-between">
                                            <button type="button" class="modal-close btn btn--info">Close</button>
                                            <button type="submit" class="alert-submit-btn btn btn--danger btn-loading">Remove</button>
                                        </div>    
                                    </form>
                                </div>
                            </div>`,
                },

            );
        });
    </script>
@endpush