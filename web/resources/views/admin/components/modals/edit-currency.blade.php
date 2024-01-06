@if (admin_permission_by_name("admin.currency.update"))
    <div id="currency-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Currency") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.currency.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    @include('admin.components.form.hidden-input',[
                        'name'          => 'target',
                        'value'         => old('target'),
                    ])
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label for="countryFlag">{{ __("Country Flag") }}</label>
                            <div class="col-12 col-sm-3 m-auto">
                                @include('admin.components.form.input-file',[
                                    'label'             => false,
                                    'class'             => "file-holder m-auto",
                                    'name'              => "currency_flag",
                                    'old_files_path'    => files_asset_path('currency-flag'),
                                    'old_files'         => old('old_flag'),
                                ])
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __("Country*") }}</label>
                            <select name="currency_country" class="form--control select2-auto-tokenize country-select" data-old="{{ old('currency_country') }}">
                                <option selected disabled>Select Country</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Name*',
                                'name'          => 'currency_name',
                                'value'         => old('currency_name'),
                            ])
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Code*',
                                'name'          => 'currency_code',
                                'value'         => old('currency_code'),
                            ])
                        </div>
                        <div class="col-xl-3 col-lg-3 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Symbol*',
                                'name'          => 'currency_symbol',
                                'value'         => old('currency_symbol'),
                            ])
                        </div>
                        {{-- <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __("Rate*") }}</label>
                            <div class="input-group">
                                <span class="input-group-text append">1 {{ get_default_currency_code($default_currency) }} = </span>
                                <input type="number" class="form--control" value="{{ old('currency_rate') }}" name="currency_rate">
                                <span class="input-group-text selcted-currency-edit">{{ old('currency_code') }}</span>
                            </div>
                        </div> --}}
                        {{-- <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.radio-button',[
                                'label'         => 'Role*',
                                'name'          => 'currency_role',
                                'value'         => old('currency_role'),
                                'options'       => ['Both' => 'both', 'Sender' => 'sender', 'Receiver' => 'receiver'],
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.switcher',[
                                'label'         => 'Option*',
                                'name'          => 'currency_option',
                                'value'         => old('currency_option'),
                                'options'       => ['Optional' => 0,'Default' => 1],
                            ])
                        </div> --}}

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn btn--base">{{ __("Update") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push("script")
        <script>
            $(document).ready(function(){
                reloadAllCountries("select[name=currency_country]");
                openModalWhenError("currency_edit","#currency-edit");
                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                    var editModal = $("#currency-edit");

                    var readOnly = true;
                    if(oldData.type == "CRYPTO") {
                        readOnly = false;
                    }

                    editModal.find(".invalid-feedback").remove();
                    editModal.find(".form--control").removeClass("is-invalid");

                    editModal.find("form").first().find("input[name=target]").val(oldData.code);
                    editModal.find("input[name=currency_code]").val(oldData.code).prop("readonly",readOnly);
                    editModal.find("input[name=currency_name]").val(oldData.name).prop("readonly",readOnly);
                    editModal.find("input[name=currency_symbol]").val(oldData.symbol).prop("readonly",readOnly);
                    editModal.find("input[name=currency_rate]").val(oldData.rate);
                    editModal.find("input[name=currency_type]").val(oldData.type);
                    editModal.find("input[name=currency_flag]").attr("data-preview-name",oldData.flag);
                    editModal.find("input[name=currency_option]").val(oldData.option);
                    editModal.find(".selcted-currency-edit").text(oldData.code);
                    editModal.find("select[name=currency_country]").attr("data-old",oldData.country);

                    selectFormRadio("#currency-edit input[name=currency_role]",oldData.role);
                    reloadAllCountries("select[name=currency_country]");
                    fileHolderPreviewReInit("#currency-edit input[name=currency_flag]");
                    refreshSwitchers("#currency-edit");
                    openModalBySelector("#currency-edit");

                });
            });
        </script>
    @endpush
@endif
