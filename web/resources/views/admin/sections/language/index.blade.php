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
    ], 'active' => __("Languages")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            @includeUnless($languages->where("status",1)->count(),'admin.components.alerts.warning',['message' => "There is no default language in your system. System will automatically select English as a default language."])
            <div class="table-header">
                <h5 class="title">{{ __($page_title) }}</h5>
                <div class="table-btn-area">
                    @include('admin.components.link.add-default',[
                        'href'          => "#language-add",
                        'class'         => "py-2 px-4 modal-btn",
                        'text'          => "Add New",
                        'permission'    => "admin.languages.store",
                    ])
                    @include('admin.components.link.custom',[
                        'href'          => "#language-import",
                        'class'         => "btn--base py-2 px-4 bg--info modal-btn",
                        'icon'          => "fas fa-upload me-1",
                        'text'          => "Import",
                        'permission'    => "admin.languages.import",
                    ])
                    @if (language_file_exists())
                        @include('admin.components.link.custom',[
                            'text'          => "Download",
                            'icon'          => "fas fa-download me-1",
                            'permission'    => "admin.languages.download",
                            'href'          => setRoute('admin.languages.download'),
                            'class'         => "btn--base py-2 px-4 bg--primary",
                        ])
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($languages as $item)
                            <tr data-item="{{ $item->editData }}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'          => 'status',
                                        'value'         => $item->status,
                                        'options'       => ['Default' => 1,'Selectable' => 0],
                                        'onload'     => true,
                                        'data_target'   => $item->id,
                                    ])
                                </td>
                                <td>
                                    @include('admin.components.link.info-default',[
                                        'href'          => setRoute('admin.languages.info',$item->code),
                                        'permission'    => "admin.languages.info",
                                    ])
                                    @include('admin.components.link.edit-default',[
                                        'class'         => "edit-modal-button",
                                        'permission'    => "admin.languages.update",
                                    ])
                                    @if (language_const()::NOT_REMOVABLE != $item->code)
                                        @include('admin.components.link.delete-default',[
                                            'class'         => "delete-modal-button",
                                            'permission'    => "admin.languages.delete",
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

    {{-- Language Add --}}
    @include('admin.components.modals.language.add')

    {{-- Language Edit --}}
    @include('admin.components.modals.language.edit')

    {{-- Import Language --}}
    @include('admin.components.modals.language.import',compact("languages"))

@endsection

@push('script')
    <script>
        $(".delete-modal-button").click(function() {
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.languages.delete') }}";
            var target      = oldData.id;
            var message     = "Are you sure to delete this language?";

            openDeleteModal(actionRoute,target,message);
        });
        // Switcher
        switcherAjax("{{ setRoute('admin.languages.status.update') }}");
    </script>
@endpush