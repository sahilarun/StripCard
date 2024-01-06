@if (admin_permission_by_name("admin.setup.sections.faq.update"))
    <div id="edit-faq" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Edit Faq") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.setup.sections.faq.update') }}">
                    @csrf
                    @method("PUT")
                    @include('admin.components.form.hidden-input',[
                        'name'          => 'target',
                        'value'         => old('target'),
                    ])
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            @php
                                $faqCategories = App\Models\CategoryType::where('type',1)->orderByDesc('id')->get();

                            @endphp
                            <label for="category_id">Category Type</label>
                            <select name="category_id" id="category_id" class="form--control" required>
                               @foreach ($faqCategories as $cat)
                               <option value="{{  $cat->id }}">{{ $cat->name }}</option>

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
                openModalWhenError("edit-faq","#edit-faq");
                $(document).on("click",".edit-modal-button",function(){
                    var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
                    var editModal = $("#edit-faq");
                    var category = oldData.category_id;
                    editModal.find("select[name=category_id]").val(category);
                    editModal.find("form").first().find("input[name=target]").val(oldData.id);
                    editModal.find("input[name=question]").val(oldData.question)
                    editModal.find("textarea[name=answer]").val(oldData.answer)
                    openModalBySelector("#edit-faq");

                });
            });
        </script>
    @endpush
@endif
