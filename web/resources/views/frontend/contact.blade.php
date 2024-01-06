@extends('frontend.layouts.master')
@php
    $lang = selectedLang();
    $contact_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::CONTACT_SECTION);
    $contact_sections = App\Models\Admin\SiteSections::getData( $contact_slug)->first();
@endphp
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start contact form
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="contact-section pt-150 pb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 mb-30">
                <div class="contact-form-area">
                    <div class="contact-header">
                        <span class="sub-title">{{ __(@$contact_sections->value->language->$lang->title) }}</span>
                        <h2 class="title">{{ __(@$contact_sections->value->language->$lang->heading) }}</h2>
                    </div>
                    <form class="contact-form" action="{{ setRoute('contact.store') }}"  method="POST" id="contact-form">
                        @csrf
                        <div class="row justify-content-center mb-10-none">
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>Name<span>*</span></label>
                                <input type="text" name="name" class="form--control" placeholder="Enter Name..." required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>Email<span>*</span></label>
                                <input type="email" name="email" class="form--control" placeholder="Enter Email..." required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>Phone<span>*</span></label>
                                <input type="number" name="mobile" class="form--control" placeholder="Enter Phone..." required>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                <label>Subject<span>*</span></label>
                                <input type="text" name="subject" class="form--control" placeholder="Enter Subject..." required>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label>Message<span>*</span></label>
                                <textarea class="form--control" name="message" placeholder="Write Here..." required></textarea>
                            </div>
                            <div class="col-lg-12 form-group">
                                <button type="submit" class="btn--base">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 mb-30">
                <div class="contact-information">
                    <h3 class="title">Information</h3>
                    <p>{{ __(@$contact_sections->value->language->$lang->infomation) }}</p>
                </div>
                <div class="contact-widget-box d-flex mt-3">
                    <div class="contact-icon">
                        <i class="las la-phone-volume"></i>
                    </div>
                    <div class="contact-containt">
                        <h4 class="title">Mobile Number</h4>
                        {{ __(@$contact_sections->value->language->$lang->phone) }}
                    </div>
                </div>
                <div class="contact-widget-box d-flex mt-3">
                    <div class="contact-icon">
                        <i class="las la-map-marker"></i>
                    </div>
                    <div class="contact-containt">
                        <h4 class="title">Address</h4>
                        {{ __(@$contact_sections->value->language->$lang->address) }}
                    </div>
                </div>
                <div class="contact-widget-box d-flex mt-3">
                    <div class="contact-icon">
                        <i class="las la-envelope"></i>
                    </div>
                    <div class="contact-containt">
                        <h4 class="title">Email Address</h4>
                        {{ __(@$contact_sections->value->language->$lang->email) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End contact form
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection

@push('script')
<script>

    //*************** Contact Form Submit Start ******************
    $(document).on('submit', '#contact-form', function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ setRoute('contact.store') }}",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function(){
                $('#contact-form .fa-spinner').removeClass('d-none');
            },
            complete: function(){
                $('#contact-form .fa-spinner').addClass('d-none');
            },
            success: function (data) {
                $('#contact-form')[0].reset();
                throwMessage('success',data.message.success);
                setTimeout(() => {
                location.reload();
            }, "1000");
            },
            error: function(xhr, ajaxOption, thrownError){
                var errorObj = JSON.parse(xhr.responseText);
                throwMessage(errorObj.type,errorObj.message.error.errors);
                setTimeout(() => {
                location.reload();
            }, "1000");
            },
        });
    });
    //*************** Contact Form Submit End ******************
</script>
@endpush
