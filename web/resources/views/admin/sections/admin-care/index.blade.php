@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 194px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 150px !important;
        }

        .select2-results__option.select2-results__option--selectable.select2-results__option--selected {
            display: none;
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
    ], 'active' => __("Admin Care")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Admin") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.search-input',[
                        'name'  => 'admin_search',
                    ])
                    @include('admin.components.link.add-default',[
                        'href'          => "#admin-add",
                        'class'         => "modal-btn",
                        'text'          => "Add Admin",
                        'permission'    => "admin.admins.admin.store"
                    ])
                </div>
            </div>
            <div class="table-responsive">
                @include('admin.components.data-table.admin-table',compact("admins"))
            </div>
        </div>
        {{ get_paginate($admins) }}
    </div>
    
    {{-- Admin Add Modal --}}
    @include('admin.components.modals.add-admin')

    {{-- Admin Edit Modal --}}
    @include('admin.components.modals.edit-admin',compact('admin_roles'))

@endsection

@push('script')
    <script>

        $(document).on("click",".delete-modal-button",function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var actionRoute =  "{{ setRoute('admin.admins.admin.delete') }}";
            var target      = oldData.username;
            var message     = `Are you sure to remove @<strong>${oldData.username}</strong>?`;
            openDeleteModal(actionRoute,target,message);
        });

        // Switcher
        switcherAjax("{{ route('admin.admins.admin.status.update') }}");

        itemSearch($("input[name=admin_search]"),$(".admin-search-table"),"{{ setRoute('admin.admins.search') }}");
    </script>
@endpush