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
                <h5 class="title">{{ __("All Permissions") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => "#permission-add",
                        'class'         => "modal-btn",
                        'permission'    => "admin.admins.role.permission.store",
                        'text'          => "Add New",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Permission Name</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $key => $item)
                            <tr data-item="{{ $item->editData }}">
                                <td>{{ $key + 1 }}</td>
                                <td><span>{{ $item->name }}</span></td>
                                <td><span>{{ $item->role->name }}</span></td>
                                <td>{{ $item->stringStatus }}</td>
                                <td>
                                    @include('admin.components.link.info-default',[
                                        'href'          => setRoute('admin.admins.role.permission',$item->slug),
                                        'permission'     => "admin.admins.role.permission",
                                    ])
                                    @include('admin.components.link.edit-default',[
                                        'class'         => "edit-modal-button",
                                        'permission'    => "admin.admins.role.permission.update",
                                    ])
                                    @include('admin.components.link.delete-default',[
                                        'class'         => "permission-delete-btn",
                                        'permission'    => "admin.admins.role.permission.dalete",
                                    ])
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

    {{-- Add Admin Role Permission Modal --}}
    @include('admin.components.modals.admin-permission-add',compact('roles'))

    {{-- Edit Admin Role Permission Modal --}}
    @include('admin.components.modals.admin-permission-edit')

@endsection

@push('script')
    <script>
        $(".permission-delete-btn").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.admins.role.permission.dalete') }}";
            var target      = oldData.id;
            var message     = "Are you sure to delete this permission? It will also delete all permissions against this role.";

            openDeleteModal(actionRoute,target,message);
        });
    </script>
@endpush