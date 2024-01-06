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
                <h5 class="title">{{ $permission->name }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => "#permission-assign-add",
                        'class'         => "modal-btn",
                        'text'          => "Add New",
                        'permission'    => "admin.admins.role.permission.assign",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>URI</th>
                            <th>Title</th>
                            <th>Role Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permission->hasPermissions as $key => $item)
                            <tr data-item="{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td><span>{{ get_route_info($item->route)->uri() }}</span></td>
                                <td><span>{{ $item->title }}</span></td>
                                <td>{{ $item->permission->role->name }}</td>
                                <td>
                                    @include('admin.components.link.delete-default',[
                                        'class'         => "permission-delete-btn",
                                        'permission'    => "admin.admins.role.permission.assign.delete"
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
    @include('admin.components.modals.admin-permission-assign',compact("routes"));

@endsection

@push('script')
    <script>
        $(".permission-delete-btn").click(function(){
            var oldData = $(this).parents("tr").attr("data-item");

            var actionRoute =  "{{ setRoute('admin.admins.role.permission.assign.delete',$permission->slug) }}";
            var target      = oldData;
            var message     = "Are you sure to delete this permission?";

            openDeleteModal(actionRoute,target,message);
        });
    </script>
@endpush