@if (admin_permission_by_name("admin.extension.update"))
    <div id="edit-modal" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Update Extension") }}: <span class="extension-name"></h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" action="" method="POST">

                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            (function($) {
                "use strict";
                $('.edit-button').on('click', function(e) {
                    e.preventDefault();
                    var modal = $('#edit-modal');
                    var shortcode = $(this).data('shortcode');
                    modal.find('.extension-name').text($(this).data('name'));
                    modal.find('form').attr('action', $(this).data('action'));

                    var html = '';
                    $.each(shortcode, function(key, item) {
                        html += `<div class="col-xl-12 col-lg-12 form-group">
                                    <label>${item.title}*</label>
                                    <div class="col-md-12">
                                        <input type="text" name="${key}" class="form--control" placeholder="${item.title}" value='${item.value}' required />
                                    </div>
                                </div>`;
                    })

                    var markup = `<input type="hidden" name="_token" value=" ${laravelCsrf()}"/> <div class="modal-body">
                                    <div class="row mb-10-none">
                                        ${html}
                                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                            <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                                            <button type="submit" class="btn btn--base">{{ __("Update") }}</button>
                                        </div>
                                    </div>
                                </div>`;

                    modal.find('.modal-form').html(markup);
                    openModalBySelector("#edit-modal");
                });
            })(jQuery);
        </script>
    @endpush
@endif