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
    ], 'active' => __("Setup KYC")])
@endsection

@section('content')
    <form action="{{ setRoute('admin.setup.kyc.update',$kyc->slug) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="custom-card kyc-form input-field-generator" data-source="kyc_input_fields">
            <div class="card-header">
                <h6 class="title">{{ __("KYC Data Form") }}</h6>
                @include('admin.components.button.custom',[
                    'type'          => "button",
                    'class'         => "add-row-btn",
                    'text'          => "Add",
                    'icon'          => "fas fa-plus",
                    'permission'    => "admin.setup.kyc.update",
                ])
            </div>
            <div class="card-body">
                <div class="results">
                    @foreach ($kyc->fields ?? [] as $key => $item)
                        <div class="row add-row-wrapper align-items-end">
                            <div class="col-xl-3 col-lg-3 form-group">
                                @include('admin.components.form.input',[
                                    'label'     => "Field Name*",
                                    'name'      => "label[]",
                                    'attribute' => "required",
                                    'value'     => old('label[]',$item->label),
                                ])
                            </div>
                            <div class="col-xl-2 col-lg-2 form-group">
                                @php
                                    $selectOptions = ['text' => "Input Text", 'file' => "File", 'textarea' => "Textarea",'select' => "Select"];
                                @endphp
                                <label>{{ __("Field Types*") }}</label>
                                <select class="form--control nice-select field-input-type" name="input_type[]" data-old="{{ $item->type }}" data-show-db="true">
                                    @foreach ($selectOptions as $key => $value)
                                        <option value="{{ $key }}" {{ ($key == $item->type) ? "selected" : "" }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="field_type_input col-lg-4 col-xl-4">
                                @if ($item->type == "file")
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => "Max File Size (mb)*",
                                                'name'          => "file_max_size[]",
                                                'type'          => "number",
                                                'attribute'     => "required",
                                                'value'         => old('file_max_size[]',$item->validation->max),
                                                'placeholder'   => "ex: 10",
                                            ])
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => "File Extension*",
                                                'name'          => "file_extensions[]",
                                                'attribute'     => "required",
                                                'value'         => old('file_extensions[]',implode(",",$item->validation->mimes)),
                                                'placeholder'   => "ex: jpg, png, pdf",
                                            ])
                                        </div>
                                    </div>
                                @elseif ($item->type == "select")
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 form-group">
                                            @include('admin.components.form.input',[
                                                'label'     => "Options*",
                                                'name'      => "select_options[]",
                                                'attribute' => "required=true",
                                                'value'     => old("select_options[]",implode(",",$item->validation->options)),
                                            ])
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => "Min Character*",
                                                'name'          => "min_char[]",
                                                'type'          => "number",
                                                'attribute'     => "required",
                                                'value'         => old('min_char[]',$item->validation->min),
                                                'placeholder'   => "ex: 6",
                                            ])
                                        </div>
                                        <div class="col-xl-6 col-lg-6 form-group">
                                            @include('admin.components.form.input',[
                                                'label'         => "Max Character*",
                                                'name'          => "max_char[]",
                                                'type'          => "number",
                                                'attribute'     => "required",
                                                'value'         => old('max_char[]',$item->validation->max),
                                                'placeholder'   => "ex: 16",
                                            ])
                                        </div>
                                    </div>
                                @endif

                            </div>
            
                            <div class="col-xl-2 col-lg-2 form-group">
                                @include('admin.components.form.switcher',[
                                    'label'     => "Field Necessity*",
                                    'name'      => "field_necessity[]",
                                    'options'   => ['Required' => "1",'Optional' => "0"],
                                    'value'     => old("field_necessity[]",$item->required),
                                ])
                            </div>
                            <div class="col-xl-1 col-lg-1 form-group">
                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    @endforeach

                    {{-- Default Field Row --}}
                    @if (count($kyc->fields ?? []) == 0)
                        <div class="row add-row-wrapper align-items-end">
                            <div class="col-xl-3 col-lg-3 form-group">
                                @include('admin.components.form.input',[
                                    'label'     => "Field Name*",
                                    'name'      => "label[]",
                                    'attribute' => "required",
                                    'value'     => old('label[]'),
                                ])
                            </div>
                            <div class="col-xl-2 col-lg-2 form-group">
                                @php
                                    $selectOptions = ['text' => "Input Text", 'file' => "File", 'textarea' => "Textarea",'select' => "Select"];
                                @endphp
                                <label>{{ __("Field Types*") }}</label>
                                <select class="form--control nice-select field-input-type" name="input_type[]" data-old="file">
                                    @foreach ($selectOptions as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="field_type_input col-lg-4 col-xl-4">
            
                            </div>
            
                            <div class="col-xl-2 col-lg-2 form-group">
                                @include('admin.components.form.switcher',[
                                    'label'     => "Field Necessity*",
                                    'name'      => "field_necessity[]",
                                    'options'   => ['Required' => "1",'Optional' => "0"],
                                    'value'     => old("field_necessity[]","1"),
                                ])
                            </div>
                            <div class="col-xl-1 col-lg-1 form-group">
                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => "Save & Change",
                            'permission'    => "admin.setup.kyc.update",
                        ])
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    
@endpush