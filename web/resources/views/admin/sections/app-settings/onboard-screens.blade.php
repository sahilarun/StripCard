@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 448px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 404px !important;
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
    ], 'active' => __("App Settings")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Onboard Screen") }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => "#onboard-screen-add",
                        'class'         => "modal-btn",
                        'text'          => "Add New Screen",
                        'permission'    => "admin.app.settings.onboard.screen.store",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{__("Title")}}</th>
                            <th>{{ __("Sub Title") }}</th>
                            <th>{{ __("Status") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($onboard_screens as $key=> $item)
                            <tr data-item="{{ $item->editData }}">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image,'app-images') }}" alt="onboard-image"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ textLength($item->sub_title ?? "",20) }} </td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'label'         => false,
                                        'name'          => 'status',
                                        'value'         => old('status',$item->status),
                                        'options'       => ['Enable' => 1,'Disable' => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.app.settings.onboard.screen.status.update",
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'class'         => "onboard-screen-edit-modal-btn",
                                        'permission'    => "admin.app.settings.onboard.screen.update",
                                    ])
                                    @if($key != 0 &&  $key != 1)
                                    @include('admin.components.link.delete-default',[
                                        'class'         => "onboard-screen-delete-modal-btn",
                                        'permission'    => "admin.app.settings.onboard.screen.delete",
                                    ])
                                    @endif

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

    {{-- Modal Section --}}
    @include('admin.components.modals.add-onboard-screen')

    {{-- Edit Modal --}}
    @include('admin.components.modals.edit-onboard-screen')
@endsection

@push('script')
    <script>
        $(document).ready(function(){

            switcherAjax("{{ setRoute('admin.app.settings.onboard.screen.status.update') }}");

            $(".onboard-screen-delete-modal-btn").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

                var actionRoute =  "{{ setRoute('admin.app.settings.onboard.screen.delete') }}";
                var target      = oldData.target;
                var message     = "Are you sure to <strong>delete</strong> this screen?";

                openDeleteModal(actionRoute,target,message);
            });

        });
    </script>
@endpush
