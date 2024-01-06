@if (admin_permission_by_name("admin.setup.sections.faq.store"))
    <div id="faq-answer" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Answer Details") }}</h5>
            </div>
            <div class="modal-form-data">
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            <P class="info">-----</P>
                        </div>


                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Close") }}</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    @push("script")
        <script>
            $(document).ready(function(){
                $(document).on("click",".modal-btn-info",function(){
                    var oldData = $(this).parents("tr").attr("data-single");
                    var editModal = $("#faq-answer");
                    editModal.find(".info").text(oldData)
                    openModalBySelector("#faq-answer");

                });
            });
        </script>
    @endpush
@endif
