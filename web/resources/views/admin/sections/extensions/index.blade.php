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
        'active' => __('Extensions'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Extensions") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($extensions as $key => $item)
                            <tr data-image="{{ $item->support_image }}">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image, 'extensions') }}" alt="image"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->name ? $item->name : '' }}</td>
                                <td>
                                    @include('admin.components.form.switcher', [
                                        'name' => 'status',
                                        'data_target' => $item->id,
                                        'value' => $item->status,
                                        'options' => ['Enable' => 1, 'Disabled' => 0],
                                        'onload' => true,
                                        'permission' => "admin.extension.status.update",
                                    ])
                                </td>
                                <td>
                                    @if (admin_permission_by_name("admin.extension.update"))
                                        <button type="button" class="btn btn--base edit-button" data-name="{{ __($item->name) }}"
                                            data-shortcode="{{ json_encode($item->shortcode) }}"
                                            data-action="{{ setRoute('admin.extension.update', $item->id) }}">
                                            <i class="las la-pencil-alt"></i>
                                        </button>
                                    @endif

                                    <button class="btn btn--base helpButton" data-description="{{ __($item->description) }}" data-support="{{ __($item->support) }}"><i class="las la-info-circle"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    @include('admin.components.modals.extension-edit')

    {{-- Info Modal --}}
    <div id="instruction-modal" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Instructions") }}</h5>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            
            $('.helpButton').on('click', function() {
                var modal = $('#instruction-modal');
                var image = $(this).parents("tr").attr('data-image');
                var path = "{{ files_asset_path('extensions') }}";
                var imgLink = path + "/" + image;
                modal.find('.modal-body').html(`<div class="mb-2">${$(this).data('description')}</div>`);
                if ($(this).data('support') != 'na') {
                    modal.find('.modal-body').append(`<img src="${imgLink}">`);
                }
                openModalBySelector("#instruction-modal");
            });

        })(jQuery);
        switcherAjax("{{ setRoute('admin.extension.status.update') }}");
    </script>
@endpush
