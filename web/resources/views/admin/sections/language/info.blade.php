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
            <div class="table-header">
                <h5 class="title">{{ __("Language Keywords of English") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table two">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Key</th>
                            <th>{{ ucwords($language->name) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($key_value as $key => $item)
                            @php
                                $array = [$key => $item];
                            @endphp
                            @foreach ($array as $innerKey => $innerValue)
                                <tr>
                                    <td></td>
                                    <td>{{ $innerKey }}</td>
                                    <td>{{ $innerValue }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Language Add --}}
    <div id="language-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Add Language") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.languages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none mt-2">
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Language Name*',
                                'name'          => 'name',
                                'value'         => old('name')
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Language Code*',
                                'name'          => 'code',
                                'value'         => old('code')
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn btn--base">{{ __("Add") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Language Edit --}}
    <div id="language-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Language") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.languages.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="target">
                    <div class="row mb-10-none mt-2">
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Language Name*',
                                'name'          => 'edit_name',
                                'value'         => old('edit_name')
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Language Code*',
                                'name'          => 'edit_code',
                                'value'         => old('edit_code')
                            ])
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
        openModalWhenError("language-add","#language-add");
        openModalWhenError("language-edit","#language-edit");

        $(".edit-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var editModal = $("#language-edit");

            editModal.find("form").first().find("input[name=target]").val(oldData.id);
            editModal.find("input[name=edit_name]").val(oldData.name);
            editModal.find("input[name=edit_code]").val(oldData.code);

            openModalBySelector("#language-edit");
        });

        // Switcher
        switcherAjax("{{ setRoute('admin.languages.status.update') }}");
    </script>
@endpush
