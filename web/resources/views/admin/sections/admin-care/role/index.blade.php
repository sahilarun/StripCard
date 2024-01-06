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
    ], 'active' => __("Admin Care")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Admin Roles") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => "#role-add",
                        'class'         => "modal-btn",
                        'text'          => "Add New",
                        'permission'    => "admin.admins.role.store",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Role Name</th>
                            <th>Asign Admin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $key => $item)
                            <tr data-item="{{ $item->editData }}">
                                <td>{{ $key + 1 }}</td>
                                <td><span>{{ $item->name }}</span></td>
                                <td>{{ $item->assignRole->count() }}</td>
                                <td>
                                    @if ($item->name != admin_role_const()::SUPER_ADMIN)
                                        @include('admin.components.link.edit-default',[
                                            'class'         => "edit-modal-button",
                                            'permission'    => "admin.admins.role.update",
                                        ])
                                        @include('admin.components.link.delete-default',[
                                            'class'         => "role-delete-btn",
                                            'permission'    => "admin.admins.role.delete",
                                        ])
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Admin Role Modal --}}
    @include('admin.components.modals.admin-role-add')

    {{-- Edit Admin Role Modal --}}
    @include('admin.components.modals.admin-role-edit')

@endsection

@push('script')
    <script>

        $(".role-delete-btn").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.admins.role.delete') }}";
            var target      = oldData.id;
            var message     = "Are you sure to delete this role?";

            openDeleteModal(actionRoute,target,message);
        });

    </script>
@endpush