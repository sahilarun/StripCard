@if (admin_permission_by_name("admin.setup.sections.faq.store"))
    <div id="faq-add" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Add New Faq") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.setup.sections.faq.store') }}">
                    @csrf
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form--control" required>
                                @foreach ($allCategory as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            @include('admin.components.form.input',[
                                'label'         => "Question*",
                                'name'          => "question",
                                'value'         => old("question"),
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            @include('admin.components.form.textarea',[
                                'label'         => "Answer*",
                                'name'          => "answer",
                                'value'         => old("answer"),
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

    @push('script')
        <script>
            openModalWhenError("faq-add","#faq-add");
        </script>
    @endpush
@endif
