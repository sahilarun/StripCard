@if (admin_permission_by_name("admin.setup.sections.blog.store"))
<div id="blog-add" class="mfp-hide large">
    <div class="modal-data">
        <div class="modal-header px-0">
            <h5 class="modal-title">{{ __("Add Blog") }}</h5>
        </div>
        <div class="modal-form-data">
            <form class="modal-form" method="POST" action="{{ setRoute('admin.setup.sections.blog.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-10-none mt-3">

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" id="category" class="form--control nice-select"
                            required>
                            <option disabled selected value="">Select Category</option>
                            @foreach ($categories ??[] as $key => $cat)
                                <option value="{{ $cat->id }}" >{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif" id="modal-english-tab" data-bs-toggle="tab" data-bs-target="#modal-english" type="button" role="tab" aria-controls="modal-english" aria-selected="false">English</button>
                                @foreach ($languages as $item)
                                    <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="modal-{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#modal-{{$item->name}}" type="button" role="tab" aria-controls="modal-{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
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
                                        'label'     => "Name*",
                                        'name'      => $default_lang_code . "_name",
                                        'value'     => old($default_lang_code . "_name",$data->value->language->$default_lang_code->name ?? "")
                                    ])
                                </div>

                                <div class="form-group">
                                     @include('admin.components.form.input-text-rich',[
                                        'label'     => "Description*",
                                        'name'      => $default_lang_code . "_details",
                                        'value'     => old($default_lang_code . "_details",$data->value->language->$default_lang_code->details ?? "")
                                    ])
                                </div>

                            </div>

                            @foreach ($languages as $item)
                                @php
                                    $lang_code = $item->code;
                                @endphp
                                <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="modal-{{ $item->name }}" role="tabpanel" aria-labelledby="modal-{{$item->name}}-tab">

                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => "Name*",
                                            'name'      => $lang_code . "_name",
                                            'value'     => old($lang_code . "_name",$data->value->language->$lang_code->name ?? "")
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input-text-rich',[
                                            'label'     => "Description*",
                                            'name'      => $lang_code . "_details",
                                            'value'     => old($lang_code . "_details",$data->value->language->$lang_code->details ?? "")
                                        ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group">
                        <label>{{ __("Tags*") }}</label>
                        <select name="tags[]" class="form-control select2-auto-tokenize"  multiple="multiple" required>
                            <option disabled>Select Blog Tags</option>
                        </select>
                    </div>

                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => "Image:",
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files_path'    => files_asset_path("site-section"),
                            'old_files'         => $data->value->items->image ?? "",
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
@endif
