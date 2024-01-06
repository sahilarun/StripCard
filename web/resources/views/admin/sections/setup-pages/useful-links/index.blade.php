@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp

@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/backend/css/fontawesome-iconpicker.css') }}">
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
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
    ], 'active' => __("Setup Section")])
@endsection

@section('content')

    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header">
                <h6 class="title">{{ __($page_title) }}</h6>
                <div class="table-btn-area">
                    <a href="#useful-link-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i> {{ __("Add Page") }}</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data ?? [] as $key => $item)
                            <tr data-item="{{ json_encode($item) }}">
                                <td>
                                    {{ $item->title->language->$system_default_lang->title ?? "" }}
                                </td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'          => 'campaign_status',
                                        'value'         => $item->status,
                                        'options'       => ['Enable' => 1,'Disable' => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.campaigns.items.status.update",
                                    ])
                                </td>
                                <td>
                                    <a href="{{ setRoute('admin.useful.links.edit', $item->id) }}" class="btn btn--base"><i
                                        class="las la-pencil-alt"></i></a>
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
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

    @include('admin.components.modals.site-section.useful-link-add')


    {{--  Item Edit Modal --}}
    <div id="useful-link-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Campaign") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.useful.links.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="target" value="{{ old('target') }}">
                    <div class="row mb-10-none mt-3">
                        <div class="language-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif" id="modal-english-tab" data-bs-toggle="tab" data-bs-target="#modal-english" type="button" role="tab" aria-controls="edit-modal-english" aria-selected="false">English</button>
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="edit-modal-{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#edit-modal-{{$item->name}}" type="button" role="tab" aria-controls="edit-modal-{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane @if (get_default_language_code() == language_const()::NOT_REMOVABLE) fade show active @endif" id="modal-english" role="tabpanel" aria-labelledby="modal-english-tab">
                                    @php
                                        $default_lang_code = language_const()::NOT_REMOVABLE;
                                    @endphp
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => "Page Name*",
                                            'name'      => $default_lang_code . "_title",
                                            'value'     => old($default_lang_code . "_title")
                                        ])
                                    </div>
                                    <div class="form-group">
                                        <label>{{ "Details*" }}</label>
                                        <textarea name="{{ $default_lang_code . "_details" }}" class="form--control"></textarea>
                                    </div>

                                </div>

                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="edit-modal-{{ $item->name }}" role="tabpanel" aria-labelledby="edit-modal-{{$item->name}}-tab">
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     => "Page Name*",
                                                'name'      => $lang_code . "_title",
                                                'value'     => old($lang_code . "_title")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            <label>{{ "Details*" }}</label>
                                            <textarea name="{{ $lang_code . "_details" }}" class="form--control d-none"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn btn--base">{{ __("Update") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('script')

    <script>
        openModalWhenError("useful-link-add","#useful-link-add");
        openModalWhenError("useful-link-edit","#useful-link-edit");

        var default_language = "{{ $default_lang_code }}";
        var system_default_language = "{{ $system_default_lang }}";
        var languages = "{{ $languages_for_js_use }}";
        languages = JSON.parse(languages.replace(/&quot;/g,'"'));

        $(".edit-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var editModal = $("#useful-link-edit");

            editModal.find("form").first().find("input[name=target]").val(oldData.id);
            editModal.find("input[name="+default_language+"_title]").val(oldData.title.language[default_language].title);
            editModal.find("textarea[name="+default_language+"_details]").val(oldData.details.language[default_language].details);

            richTextEditorReinit(document.querySelector("#useful-link-edit textarea[name="+default_language+"_details]"));

            $.each(languages,function(index,item) {
                editModal.find("input[name="+item.code+"_title]").val(oldData.title.language[item.code].title);
                editModal.find("textarea[name="+item.code+"_details]").val(oldData.details.language[item.code].details);

                richTextEditorReinit(document.querySelector("#useful-link-edit textarea[name="+item.code+"_details]"));
            });

            openModalBySelector("#useful-link-edit");

        });

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.useful.links.delete') }}";
            var target = oldData.id;

            var message     = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute,target,message);
        });

        // Switcher
        switcherAjax("{{ setRoute('admin.useful.links.status.update') }}");

    </script>
@endpush
