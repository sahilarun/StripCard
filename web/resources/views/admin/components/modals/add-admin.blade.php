@if (admin_permission_by_name("admin.admins.admin.store"))
    <div id="admin-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Add Admin") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.admins.admin.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label for="countryFlag">{{ __("Admin Profile Image") }}</label>
                            <div class="col-12 col-sm-3 m-auto">
                                @include('admin.components.form.input-file',[
                                    'label'         => false,
                                    'class'         => "file-holder m-auto",
                                    'name'          => "image",
                                ])
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => "First Name*",
                                'name'          => "firstname",
                                'placeholder'   => "First Name",
                                'value'         => old("firstname"),  
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Last Name*",
                                'name'          => "lastname",
                                'placeholder'   => "Last Name",
                                'value'         => old("lastname"),   
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Username*",
                                'name'          => "username",
                                'placeholder'   => "Username",
                                'value'         => old("username"),       
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Email*",
                                'name'          => "email",
                                'placeholder'   => "Email",
                                'value'         => old("email"),     
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            <label>{{ __("Password*") }}</label>
                            <div class="input-group">
                                <input type="text" class="form--control place_random_password @error("password") is-invalid @enderror" placeholder="Password" name="password">
                                <button class="input-group-text rand_password_generator" type="button">Generate</button>
                            </div>
                            @error("password")
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            @include('admin.components.form.input',[
                                'label'         => "Phone*",
                                'name'          => "phone",
                                'placeholder'   => "Phone",
                                'value'         => old("phone"),
                            ])
                        </div>
                        <div class="col-xl-6 col-lg-6 form-group">
                            <label>{{ __("Role*") }}</label>
                            <select class="form--control nice-select" name="role" data-old="{{ old("role") }}">
                                <option selected disabled>Select Role</option>
                                @foreach ($admin_roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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

    @push("script")
        <script>
            openModalWhenError("admin-add","#admin-add");
            function placeRandomPassword(clickedButton,placeInput) {
                $(clickedButton).click(function(){
                    var generateRandomPassword = makeRandomString(10);
                    $(placeInput).val(generateRandomPassword);
                });
            }
            placeRandomPassword(".rand_password_generator",".place_random_password");
        </script>
    @endpush
@endif