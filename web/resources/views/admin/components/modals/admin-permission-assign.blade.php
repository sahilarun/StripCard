@if (admin_permission_by_name("admin.admins.role.permission.assign"))
    <div id="permission-assign-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Add New Permission") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.admins.role.permission.assign',$permission->slug) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none">

                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            <label for="selectRole">{{ __("Assign Permission Page/Task") }}</label>
                            <select name="title[]" id="selectTitle" class="select2-auto-tokenize form--control" data-placeholder="Select Pages" multiple>
                                @foreach ($routes as $item)
                                    <option value="{{ $item['route'] }}">{{ $item['text'] }}</option>
                                @endforeach
                            </select>

                            @error("title")
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
            openModalWhenError("permission-assign-add","#permission-assign-add");
        </script>
    @endpush
@endif