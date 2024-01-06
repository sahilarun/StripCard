@if (admin_permission_by_name("admin.users.send.mail"))
    <div id="email-send" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title">{{ __("Send Email") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('admin.users.send.mail',$user->username) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none">
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input',[
                                'label'         => 'Subject*',
                                'name'          => 'subject',
                                'value'         => old('subject'),
                                'placeholder'   => "Write Here...",
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group">
                            @include('admin.components.form.input-text-rich',[
                                'label'         => 'Message*',
                                'name'          => 'message',
                                'value'         => old('message'),
                                'placeholder'   => "Write Here...",
                            ])
                        </div>
                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn--danger modal-close">{{ __("Close") }}</button>
                            <button type="submit" class="btn btn--base">{{ __("Send") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif