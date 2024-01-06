<!-- notify js -->
<script src='{{ asset('public/backend/js/bootstrap-notify.js') }}'></script>

<script>
    // Show Laravel Error Messages----------------------------------------------
    $(function () {
        $(document).ready(function(){
            @if (session('error'))
                @if (is_array(session('error')))
                    @foreach (session('error') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "danger",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('success'))
                @if (is_array(session('success')))
                    @foreach (session('success') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-check-circle',
                            },
                            {
                                type: "success",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('warning'))
                @if (is_array(session('warning')))
                    @foreach (session('warning') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "warning",
                                allow_dismiss: true,
                                delay: 500000000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif ($errors->any())
                @foreach ($errors->all() as $item)
                    $.notify(
                        {
                            title: "",
                            message: "{{ __($item) }}",
                            icon: 'las la-exclamation-triangle',
                        },
                        {
                            type: "danger",
                            allow_dismiss: true,
                            delay: 5000,
                            placement: {
                            from: "top",
                            align: "right"
                            },
                        }
                    );
                @endforeach
            @endif
        });
    });
    //--------------------------------------------------------------------------

    // Function for throw error messages from javascript------------------------
    function throwMessage(type,errors = []) {
        if(type == 'error') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-exclamation-triangle',
                    },
                    {
                        type: "danger",
                        allow_dismiss: true,
                        delay: 5000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }else if(type == 'success') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-check-circle',
                    },
                    {
                        type: "success",
                        allow_dismiss: true,
                        delay: 5000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }else if(type == 'warning') {
            $.each(errors,function(index,item) {
                $.notify(
                    {
                        title: "",
                        message: item,
                        icon: 'las la-check-circle',
                    },
                    {
                        type: "warning",
                        allow_dismiss: true,
                        delay: 500000000,
                        placement: {
                        from: "top",
                        align: "right"
                        },
                    }
                );
            });
        }

    }
    //--------------------------------------------------------------------------

    // Function for set modal session value --------------------
    var validationSession = null;
    function getSessionValue(sesesionValue = null) {
        validationSession = sessionValue;
    }

    @if (session('modal'))
        var sessionValue = "{{ session('modal') }}";
        getSessionValue(sessionValue);
    @endif

    // Function for open modal/popup when have backend session
    function openModalWhenError(sessionValue,modalSelector) {
        if(validationSession != sessionValue) {
            return false;
        }
        openModalBySelector(modalSelector);
    }
    //----------------------------------------------------------


    function countrySelect(element,errorElement) {
        $(document).on("change",element,function(){
            var targetElement = $(this);
            var countryId = $(element+" :selected").attr("data-id");
            if(countryId != "" || countryId != null) {
                var CSRF = $("meta[name=csrf-token]").attr("content");
                var data = {
                    _token      : CSRF,
                    country_id  : countryId,
                };
                $.post("{{ setRoute('global.country.states') }}",data,function() {
                    // success
                    $(errorElement).removeClass("is-invalid");
                    $(targetElement).siblings(".invalid-feedback").remove();
                }).done(function(response){
                    // Place States to States Field
                    var options = "<option selected disabled>Select State</option>";
                    $.each(response,function(index,item) {
                        options += `<option value="${item.name}" data-id="${item.id}">${item.name}</option>`;
                    });
                    $(".state-select").html(options);
                }).fail(function(response) {
                    if(response.status == 422) { // Validation Error
                        var faildMessage = "Please select a valid Country.";
                        var faildElement = `<span class="invalid-feedback" role="alert">
                                                <strong>${faildMessage}</strong>
                                            </span>`;
                        $(errorElement).addClass("is-invalid");
                        if($(targetElement).siblings(".invalid-feedback").length != 0) {
                            $(targetElement).siblings(".invalid-feedback").text(faildMessage);
                        }else {
                            errorElement.after(faildElement);
                        }
                    }else {
                        var faildMessage = "Something went worng! Please try again.";
                        var faildElement = `<span class="invalid-feedback" role="alert">
                                                <strong>${faildMessage}</strong>
                                            </span>`;
                        $(errorElement).addClass("is-invalid");
                        if($(targetElement).siblings(".invalid-feedback").length != 0) {
                            $(targetElement).siblings(".invalid-feedback").text(faildMessage);
                        }else {
                            errorElement.after(faildElement);
                        }
                    }

                });
            }else {
                // Push Error
            }
        });
    }

    // State Select Get Cities
    function stateSelect(element,errorElement) {
        $(document).on("change",element,function(){
            var targetElement = $(this);
            var stateId = $(element+" :selected").attr("data-id");
            if(stateId != "" || stateId != null) {
                var CSRF = $("meta[name=csrf-token]").attr("content");
                var data = {
                    _token      : CSRF,
                    state_id  : stateId,
                };
                $.post("{{ setRoute('global.country.cities') }}",data,function() {
                    // success
                    $(errorElement).removeClass("is-invalid");
                    $(targetElement).siblings(".invalid-feedback").remove();
                }).done(function(response){
                    
                    // Place States to States Field
                    var options = "<option selected disabled>Select City</option>";
                    $.each(response,function(index,item) {
                        options += `<option value="${item.name}" data-id="${item.id}">${item.name}</option>`;
                    });

                    $(".city-select").html(options);
                }).fail(function(response) {
                    if(response.status == 422) { // Validation Error
                        var faildMessage = "Please select a valid state.";
                        var faildElement = `<span class="invalid-feedback" role="alert">
                                                <strong>${faildMessage}</strong>
                                            </span>`;
                        $(errorElement).addClass("is-invalid");
                        if($(targetElement).siblings(".invalid-feedback").length != 0) {
                            $(targetElement).siblings(".invalid-feedback").text(faildMessage);
                        }else {
                            errorElement.after(faildElement);
                        }
                    }else {
                        var faildMessage = "Something went worng! Please try again.";
                        var faildElement = `<span class="invalid-feedback" role="alert">
                                                <strong>${faildMessage}</strong>
                                            </span>`;
                        $(errorElement).addClass("is-invalid");
                        if($(targetElement).siblings(".invalid-feedback").length != 0) {
                            $(targetElement).siblings(".invalid-feedback").text(faildMessage);
                        }else {
                            errorElement.after(faildElement);
                        }
                    }
                });
            }else {
                // Push Error
            }
        });
    }

</script>
