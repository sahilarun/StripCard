@isset($admin_roles)
    @if (admin_permission_by_name("admin.admins.admin.update"))
        <div id="admin-edit" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __("Edit Admin") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('admin.admins.admin.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="target" value="{{ old("target") }}">
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label for="countryFlag">{{ __("Admin Profile Image") }}</label>
                                <div class="col-12 col-sm-3 m-auto">
                                    @include('admin.components.form.input-file',[
                                        'label'             => false,
                                        'class'             => "file-holder m-auto",
                                        'name'              => "edit_image",
                                        'old_files_path'    => files_asset_path('admin-profile'),
                                        'old_files'         => old('old_image')
                                    ])
                                </div>
                            </div>
        
                            <div class="col-xl-6 col-lg-6 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "First Name*",
                                    'name'          => "edit_firstname",
                                    'placeholder'   => "First Name",
                                    'value'         => old("edit_firstname"),  
                                ])
                            </div>
                            <div class="col-xl-6 col-lg-6 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Last Name*",
                                    'name'          => "edit_lastname",
                                    'placeholder'   => "Last Name",
                                    'value'         => old("edit_lastname"),   
                                ])
                            </div>
                            <div class="col-xl-6 col-lg-6 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Username*",
                                    'name'          => "edit_username",
                                    'placeholder'   => "Username",
                                    'value'         => old("edit_username"),       
                                ])
                            </div>
                            <div class="col-xl-6 col-lg-6 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Email*",
                                    'name'          => "edit_email",
                                    'placeholder'   => "Email",
                                    'value'         => old("edit_email"),     
                                ])
                            </div>
                            <div class="col-xl-6 col-lg-6 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Phone*",
                                    'name'          => "edit_phone",
                                    'placeholder'   => "Phone",
                                    'value'         => old("edit_phone"),
                                ])
                            </div>
                            <div class="col-xl-6 col-lg-6 form-group role-select-wrp" data-admin-roles="{{ json_encode($admin_roles) }}">
                                <label>{{ __("Role*") }}</label>
                                <select class="form--control select2-auto-tokenize" name="edit_role[]" data-old="{{ old("edit_role") }}" multiple data-placeholder="Select Role">
                                    @foreach ($admin_roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
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
                openModalWhenError("admin-edit","#admin-edit");
                
                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                    var editModal = $("#admin-edit");

                    editModal.find("form").first().find("input[name=target]").val(oldData.username);
                    editModal.find("input[name=edit_firstname]").val(oldData.firstname);
                    editModal.find("input[name=edit_lastname]").val(oldData.lastname);
                    editModal.find("input[name=edit_username]").val(oldData.username);
                    editModal.find("input[name=edit_email]").val(oldData.email);
                    editModal.find("input[name=edit_phone]").val(oldData.phone);
                    editModal.find("input[name=edit_image]").attr("data-preview-name",oldData.image);

                    var admin_roles = editModal.find(".role-select-wrp").attr("data-admin-roles");
                    admin_roles = JSON.parse(admin_roles);

                    var available_roles = oldData.roles.map(pluck("admin_role_id"));

                    var options = "";
                    $.each(admin_roles,function(index,item) {
                        console.log(available_roles);
                        if(available_roles.includes(item.id)) {
                            options += `<option value="${item.id}" selected>${item.name}</option>`;
                        }else {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        }
                    });

                    var roleSelect = `<select class="form--control select2-auto-tokenize" name="edit_role[]" data-old="{{ old("edit_role") }}" multiple data-placeholder="Select Role">
                                        ${options}
                                    </select>`;

                    
                    editModal.find(".role-select-wrp select").remove();
                    editModal.find(".role-select-wrp .select2").remove();

                    editModal.find(".role-select-wrp").append(roleSelect);

                    editModal.find(".role-select-wrp select").select2();

                    fileHolderPreviewReInit("#admin-edit input[name=edit_image]");
                    openModalBySelector("#admin-edit");

                });
            </script>
        @endpush
    @endif
@endisset