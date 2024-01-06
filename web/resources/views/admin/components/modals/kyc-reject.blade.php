@if (admin_permission_by_name("admin.users.kyc.reject"))
    @isset($user)
        @if ($user->kyc_verified != global_const()::REJECTED)
            {{-- KYC Reject Modal --}}
            <div id="reject-modal" class="mfp-hide large">
                <div class="modal-data">
                    <div class="modal-header px-0">
                        <h5 class="modal-title">{{ __("Rejejct KYC ") }} {{ "@" . $user->username }}</h5>
                    </div>
                    <div class="modal-form-data">
                        <form class="modal-form" method="POST" action="{{ setRoute('admin.users.kyc.reject',$user->username) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="target" value="{{ $user->username }}">
                            <div class="row mb-10-none">
                                <div class="col-xl-12 col-lg-12 form-group">
                                        @include('admin.components.form.textarea',[
                                            'label'     => "Explain Rejection Reason*",
                                            'name'      => "reason",
                                            'value'     => old("reason"),
                                        ])
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                    <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                                    <button type="submit" class="btn btn--base">{{ __("Submit") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @push("script")
            <script>
                $(".reject-btn").click(function(){
                    openModalBySelector($("#reject-modal"))
                });
            </script>
        @endpush
    @endisset
@endif