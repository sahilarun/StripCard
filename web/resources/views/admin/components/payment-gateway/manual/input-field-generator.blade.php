<div class="custom-inner-card input-field-generator" data-source="manual_gateway_input_fields">
    <div class="card-inner-header">
        <h6 class="title">{{ __("Collect Data") }}</h6>
        <button type="button" class="btn--base add-row-btn"><i class="fas fa-plus"></i> {{ __("Add") }}</button>
    </div>
    <div class="card-inner-body">
        <div class="results">
            <div class="row add-row-wrapper align-items-end">
                <div class="col-xl-3 col-lg-3 form-group">
                    @include('admin.components.form.input',[
                        'label'     => "Field Name*",
                        'name'      => "label[]",
                        'attribute' => "required",
                    ])
                </div>
                <div class="col-xl-2 col-lg-2 form-group">
                    <label>{{ __("Field Types*") }}</label>
                    <select class="form--control nice-select field-input-type" name="input_type[]">
                        <option value="text" selected>Input Text</option>
                        <option value="file">File</option>
                        <option value="textarea">Textarea</option>
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
        </div>
    </div>
</div>