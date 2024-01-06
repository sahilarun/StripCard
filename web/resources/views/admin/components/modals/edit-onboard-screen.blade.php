@if (admin_permission_by_name("admin.app.settings.onboard.screen.update"))
    <div id="onboard-screen-edit" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Edit Screen") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.app.settings.onboard.screen.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    @include('admin.components.form.hidden-input',[
                        'name'      => 'target',
                    ])
                    <div class="row mb-10-none">
                        <div class="card-body">
                            <div class="row mb-10-none">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 form-group">
                                    @include('admin.components.form.input-file',[
                                        'label'             => 'Image: <span class="text--danger">(577*433)</span>',
                                        'class'             => "file-holder",
                                        'name'              => "screen_image",
                                        'old_files_path'    => files_asset_path('app-images'),
                                        'old_files'         => old('old_image'),
                                    ])
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-6">

                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => "Title",
                                            'name'      => "screen_title",
                                            'attribute' => "data-limit=120",
                                            'value'     => old('screen_title'),
                                        ])
                                    </div>

                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => "Sub Title",
                                            'name'      => "screen_sub_title",
                                            'attribute' => "data-limit=255",
                                            'value'     => old('screen_sub_title'),
                                        ])
                                    </div>

                                </div>
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

    @push("script")
        <script>
            openModalWhenError("onboard-screen-edit","#onboard-screen-edit");

            $(".onboard-screen-edit-modal-btn").click(function(){
                var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                var editModal = $("#onboard-screen-edit");

                editModal.find("form").first().find("input[name=target]").val(oldData.target);
                editModal.find("input[name=screen_image]").attr("data-preview-name",oldData.image);
                editModal.find("input[name=screen_title]").val(oldData.title);
                editModal.find("input[name=screen_sub_title]").val(oldData.sub_title);

                fileHolderPreviewReInit("#onboard-screen-edit input[name=screen_image]");
                openModalBySelector("#onboard-screen-edit");

            });
        </script>
    @endpush
@endif
