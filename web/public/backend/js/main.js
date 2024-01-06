(function ($) {
"user strict";

//Create Background Image
(function background() {
  let img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
})();

// nice-select
$(".nice-select").niceSelect(),

// select-2 init
$('.select2-basic').select2();
$('.select2-multi-select').select2();
$(".select2-auto-tokenize").select2({
tags: true,
tokenSeparators: [',']
});

// sidebar
$(".sidebar-menu-item > a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("active")) {
    element.removeClass("active");
    element.children("ul").slideUp(500);
  }
  else {
    element.siblings("li").removeClass('active');
    element.addClass("active");
    element.siblings("li").find("ul").slideUp(500);
    element.children('ul').slideDown(500);
  }
});

//sidebar Menu
$(document).on('click', '.sidebar-menu-bar', function () {
  $('.header').toggleClass('active');
  $('.sidebar').toggleClass('active');
  $('.navbar-wrapper').toggleClass('active');
  $('.body-wrapper').toggleClass('active');
  $('.copyright-wrapper').toggleClass('active');
});

//dark version
$(document).on('click', '.header-version-bar', function () {
  $('body').toggleClass('dark-version');
});

$(document).on('click', '.header-version-bar', function() {
  setVersion(localStorage.getItem('page-wrapper'));
});


if (localStorage.getItem('page-wrapper') == 'light-version') {
  localStorage.setItem('page-wrapper', 'dark-version');
} else {
  localStorage.setItem('page-wrapper', 'light-version');
}

setVersion(localStorage.getItem('page-wrapper'));

function setVersion(version) {
  if (version == 'dark-version') {
    localStorage.setItem('page-wrapper', 'light-version');
    $('body').addClass(version);
    $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('dark_img'));
    $('.version-btn').html('<i class="las la-sun"></i>');

  } else {
    localStorage.setItem('page-wrapper', 'dark-version');
    $('body').removeClass('dark-version');
    if(localStorage.getItem('sidebar-theme') == 'dark-sidebar') {
      $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('dark_img'));
    }else {
      $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('white_img'));
    }
    $('.version-btn').html('<i class="las la-moon"></i>');
  }
}

$(".header-link").click(function(event){
  if($(this).next().hasClass("active") != true) {
    $('.header-link').next().removeClass("active");
  }
});

//Search Bar
$('.header-search-bar').on('click', function (e) {
  e.preventDefault();
  if($('.header-search-wrapper').hasClass('active')) {
    $('.header-search-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.header-search-wrapper').addClass('active');
    $('.body-overlay').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.header-search-wrapper').removeClass('active');
  $('.body-overlay').removeClass('active');
});

//Notification Bar
$('.header-notification-bar').on('click', function (e) {
  e.preventDefault();
  if($('.notification-wrapper').hasClass('active')) {
    $('.notification-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.notification-wrapper').addClass('active');
    $('.body-overlay').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.notification-wrapper').removeClass('active');
  $('.body-overlay').removeClass('active');
});

//User Bar
$('.header-user-bar').on('click', function (e) {
  e.preventDefault();
  if($('.header-user-wrapper').hasClass('active')) {
    $('.header-user-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.header-user-wrapper').addClass('active');
    $('.body-overlay').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.header-user-wrapper').removeClass('active');
  $('.body-overlay').removeClass('active');
});

//Settings
$('.header-settings-bar').on('click', function (e) {
  e.preventDefault();
  if($('.settings-sidebar-area').hasClass('active')) {
    $('.settings-sidebar-area').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.settings-sidebar-area').addClass('active');
    $('.body-overlay').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.settings-sidebar-area').removeClass('active');
  $('.body-overlay').removeClass('active');
});

//Support
$('.header-support-bar').on('click', function (e) {
  e.preventDefault();
  if($('.header-support-wrapper').hasClass('active')) {
    $('.header-support-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.header-support-wrapper').addClass('active');
    $('.body-overlay').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.header-support-wrapper').removeClass('active');
  $('.body-overlay').removeClass('active');
});

//layout-tab-switcher
$('#layout-tab-switcher').on('click', function () {
  $(this).toggleClass('active');
  $('body').toggleClass('dark-version');
  setVersion(localStorage.getItem('page-wrapper'));
});

//topbar-tab-switcher
$('#topbar-tab-switcher').on('click', function () {
  $(this).toggleClass('active');
  $('body').toggleClass('dark-topbar');
});

//sidebar-tab-switcher
$('#sidebar-tab-switcher').on('click', function () {
  $(this).toggleClass('active');
  if($(this).hasClass('active')) {
    $('body').addClass('dark-sidebar');
    localStorage.setItem('sidebar-theme','dark-sidebar');
    $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('dark_img'));
  }else {
    $('body').removeClass('dark-sidebar');
    localStorage.setItem('sidebar-theme','');
    if(localStorage.getItem('page-wrapper') == 'dark-version') {
      $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('white_img'));
    }else {
      $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('dark_img'));
    }
  }
});

// check side navbar theme color
function sideNavThemeColor(setItem) {
  if(setItem == 'dark-sidebar') {
    $('.sidebar-main-logo img').attr('src', $('.sidebar-main-logo img').data('dark_img'));
    $('body').addClass(setItem);
    $('#sidebar-tab-switcher').addClass('active');
  }else {
    localStorage.setItem('sidebar-theme','dark-sidebar');
  }
}

sideNavThemeColor(localStorage.getItem('sidebar-theme'));

//min-sidebar-tab-switcher
$('#min-sidebar-tab-switcher').on('click', function () {
  $(this).toggleClass('active');
  $('body').toggleClass('dark-min-sidebar');
});


var pageNavActive = $('.sidebar-menu a.nav-link.active');
if(pageNavActive.length > 0) {
  if(pageNavActive.first().parents(".sidebar-dropdown").length > 0) {
    pageNavActive.first().parents(".sidebar-dropdown").find(".sidebar-submenu").slideDown("slow");
  }
}

// page load active menu
setTimeout(() => {
  if ($('.sidebar-menu-item').hasClass('active')) {
      $('.sidebar').animate({
          scrollTop: $('.sidebar-menu-item.active').offset().top - 600
      }, 600);

  }
  if ($('.sidebar-dropdown').hasClass('active')) {
      $('.sidebar').animate({
          scrollTop: $('.sidebar-dropdown.active').offset().top - 600
      }, 600);
  }
}, 200);

$(document).ready(function(){
  $.each($(".switch-toggles"),function(index,item) {
    var firstSwitch = $(item).find(".switch").first();
    var lastSwitch = $(item).find(".switch").last();
    if(firstSwitch.attr('data-value') == null) {
      $(item).find(".switch").first().attr("data-value",true);
      $(item).find(".switch").last().attr("data-value",false);
    }
    if($(item).hasClass("active")) {
      $(item).find('input').val(firstSwitch.attr("data-value"));
    }else {
      $(item).find('input').val(lastSwitch.attr("data-value"));
    }
  });
});

$(document).on('click','.switch-toggles .switch', function () {
    if($(this).parents(".switch-toggles").attr("data-clickable") == undefined || $(this).parents(".switch-toggles").attr("data-clickable") == "false") {
      return false;
    }
    var dataValue = $(this).parents(".switch-toggles").find(".switch").first().attr("data-value");
    if($(this).parents(".switch-toggles").hasClass("active")) {
        dataValue = $(this).parents(".switch-toggles").find(".switch").last().attr("data-value");
    }
    $(this).parents(".switch-toggles.default").find("input").val(dataValue);
    $(this).parents(".switch-toggles.default").toggleClass('active');
});

// rte editor
function initRichEditor(element){
  if(document.querySelector(element) != null) {
    // new RichTextEditor(element);
  }
}
initRichEditor("#div_editor1");

// input-field-generator
$('.input-field-generator').on('click', '.add-row-btn', function() {
  var source = $('.input-field-generator').attr("data-source");
  $(this).closest('.input-field-generator').find('.results').children().removeClass("last-add");
  $(this).closest('.input-field-generator').find('.results').prepend(storedHtmlMarkup[source]);
  var lastAddedElement = $(this).closest('.input-field-generator').find('.results').children().first();
  lastAddedElement.addClass("last-add");

  var inputTypeField = lastAddedElement.find(".field-input-type");
  if(inputTypeField.length > 0) {
    inputFieldValidationRuleFieldsShow(inputTypeField);
  }
});

$(document).on('click','.row-cross-btn', function (e) {
  e.preventDefault();
  $(this).parent().parent().hide(300);
  setTimeout(timeOutFunc,300,$(this));
  function timeOutFunc(element) {
    $(element).parent().parent().remove();
  }
});

//dark version
$(document).on('click', '.info-btn', function () {
  $('.support-profile-wrapper').addClass('active');
});
$(document).on('click', '.chat-cross-btn', function () {
  $('.support-profile-wrapper').removeClass('active');
});

// Form Submit Guard
$("form button[type=submit], form input[type=submit]").on("click",function(event){
  var inputFileds = $(this).parents("form").find("input[type=text], input[type=number], input[type=email], input[type=password]");
  var mode = false;
  $.each(inputFileds,function(index,item) {
    if($(item).attr("required") != undefined) {
      if($(item).val() == "") {
        mode = true;
      }
    }
  });
  if(mode == false) {
    $(this).parents("form").find(".btn-ring").show();
    $(this).parents("form").find("button[type=submit],input[type=submit]").prop('disabled',true);
    $(this).parents("form").submit();
  }
});

$(document).ready(function(){
  $.each($(".btn-loading"),function(index,item){
    $(item).append(`<span class="btn-ring"></span>`);
  });
});

$(document).on("click",".switch",function() {
    if($(this).parents(".switch-toggles").attr("data-clickable") == undefined || $(this).parents(".switch-toggles").attr("data-clickable") == "false") {
        return false;
    }
    if($(this).parents(".switch-toggles").hasClass("active")) {
        $(this).parents(".switch-toggles").find(".switch").first().find(".btn-ring").show();
    }else {
        $(this).parents(".switch-toggles").find(".switch").last().find(".btn-ring").show();
    }
})


$(document).ready(function(){
  var elements = $(".add-row-btn").closest('.input-field-generator').find('.results').children();
  $.each(elements,function(index,item) {
      if($(item).find(".field-input-type").length > 0) {
          inputFieldValidationRuleFieldsShow($(item).find(".field-input-type"));
      }
  });
});

$(document).on("change",".field-input-type",function(){
  inputFieldValidationRuleFieldsShow($(this));
});

$(".currency_type").keyup(function(){
  if($(this).val().length <= $(this).attr("data-limit")) {
      $(".currency").text($(this).val().toUpperCase());
  }
});


$(document).ready(function() {
  $(".show_hide_password .show-pass").on('click', function(event) {
      event.preventDefault();
      if($(this).parent().find("input").attr("type") == "text"){
        $(this).parent().find("input").attr('type', 'password');
        $(this).find("i").addClass( "fa-eye-slash" );
        $(this).find("i").removeClass( "fa-eye" );
      }else if($(this).parent().find("input").attr("type") == "password"){
        $(this).parent().find("input").attr('type', 'text');
        $(this).find("i").removeClass( "fa-eye-slash" );
        $(this).find("i").addClass( "fa-eye" );
      }
  });
});

})(jQuery);


// CODE BY Backend Dev

/**
 * Function for make ajax request for switcher
 * @param {HTML DOM} inputName
 * @param {AJAX URL} hitUrl
 * @param {URL METHOD} method
 */
function switcherAjax(hitUrl,method = "PUT") {
    $(document).on("click",".event-ready",function(event) {
      var inputName = $(this).parents(".switch-toggles").find("input").attr("name");
      if(inputName == undefined || inputName == "") {
        return false;
      }
      $(this).parents(".switch-toggles").find(".switch").removeClass("event-ready");
      var input = $(this).parents(".switch-toggles").find("input[name="+inputName+"]");
      var eventElement = $(this);
      if(input.length == 0) {
          alert("Input field not found.");
          $(this).parents(".switch-toggles").find(".switch").addClass("event-ready");
          $(this).find(".btn-ring").hide();
          return false;
      }
      var CSRF = $("head meta[name=csrf-token]").attr("content");
      var dataTarget = "";
      if(input.attr("data-target")) {
          dataTarget = input.attr("data-target");
      }
      var inputValue = input.val();
      var data = {
        _token: CSRF,
        _method: method,
        data_target: dataTarget,
        status: inputValue,
        input_name: inputName,
      };
      $.post(hitUrl,data,function(response) {
        console.log(response);
        throwMessage('success',response.message.success);
        // Remove Loading animation
        $(event.target).find(".btn-ring").hide();
      }).done(function(response){

        $(eventElement).parents(".switch-toggles").find(".switch").addClass("event-ready");
        $(eventElement).parents(".switch-toggles.btn-load").toggleClass('active');
        var dataValue = $(eventElement).parents(".switch-toggles").find(".switch").last().attr("data-value");
        if($(eventElement).parents(".switch-toggles").hasClass("active")) {
          dataValue = $(eventElement).parents(".switch-toggles").find(".switch").first().attr("data-value");

        }
        $(eventElement).parents(".switch-toggles.btn-load").find("input").val(dataValue);
        $(eventElement).parents(".switch-toggles").find(".switch").find(".btn-ring").hide();
      }).fail(function(response) {
          var response = JSON.parse(response.responseText);
          throwMessage(response.type,response.message.error);
          $(eventElement).parents(".switch-toggles").find(".switch").addClass("event-ready");
          $(eventElement).parents(".switch-toggles").find(".btn-ring").hide();
          return false;
      });
    });
  }

/**
 * Function For Open Modal With Element ID Dynamic mfp-move-horizontal, mfp-zoom-in, mfp-newspaper, mfp-move-from-top, mfp-3d-unfold, mfp-zoom-out
 * @param {Aniamtion} animation
 */
function openModalByElement(animation = "mfp-move-horizontal") {
  $.each($(".modal-btn"),function(index,item) {
      $($(item).attr("href")).addClass("white-popup mfp-with-anim");
      $(item).magnificPopup({
          removalDelay: 500,
          callbacks: {
              beforeOpen: function() {
              this.st.mainClass = animation;
              },
              elementParse: function(event) {
                var modalCloseBtn = $($(item).attr("href")).find(".modal-close");
                $(modalCloseBtn).click(function() {
                  $.magnificPopup.close();
                });
              }
          },
          midClick: true
      });
  });

  $.magnificPopup.instance._onFocusIn = function(e) {
    // Do nothing if target element is select2 input
    if( $(e.target).hasClass('select2-search__field') ) {
        return true;
    }
    // Else call parent method
    $.magnificPopup.proto._onFocusIn.call(this,e);
  }

}
openModalByElement('mfp-move-horizontal');


/**
 * Function For Get All Country list by AJAX Request
 * @param {HTML DOM} targetElement
 * @param {Error Place Element} errorElement
 * @returns
 */
var allCountries = "";
function getAllCountries(hitUrl,targetElement = $(".country-select"),errorElement = $(".country-select").siblings(".select2")) {
  if(targetElement.length == 0) {
    return false;
  }
  var CSRF = $("meta[name=csrf-token]").attr("content");
  var data = {
      _token      : CSRF,
  };
  $.post(hitUrl,data,function() {
      // success
      $(errorElement).removeClass("is-invalid");
      $(targetElement).siblings(".invalid-feedback").remove();
  }).done(function(response){
      // Place States to States Field
      var options = "<option selected disabled>Select Country</option>";
      var selected_old_data = "";
      if($(targetElement).attr("data-old") != null) {
          selected_old_data = $(targetElement).attr("data-old");
      }
      $.each(response,function(index,item) {
          options += `<option value="${item.name}" data-id="${item.id}" data-mobile-code="${item.mobile_code}" data-currency-name="${item.currency_name}" data-currency-code="${item.currency_code}" data-currency-symbol="${item.currency_symbol}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
      });

      allCountries = response;

      $(targetElement).html(options);
  }).fail(function(response) {
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
  });
}
// getAllCountries();


/**
 * Function for reload the all countries that already loaded by using getAllCountries() function.
 * @param {string} targetElement
 * @param {string} errorElement
 * @returns
 */
function reloadAllCountries(targetElement,errorElement = $(".country-select").siblings(".select2")) {
  if(allCountries == "" || allCountries == null) {
    // alert();
    return false;
  }
  var options = "<option selected disabled>Select Country</option>";
  var selected_old_data = "";
  if($(targetElement).attr("data-old") != null) {
    selected_old_data = $(targetElement).attr("data-old");
  }
  $.each(allCountries,function(index,item) {
    options += `<option value="${item.name}" data-id="${item.id}" data-currency-name="${item.currency_name}" data-currency-code="${item.currency_code}" data-currency-symbol="${item.currency_symbol}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
  });
  $(targetElement).html(options);
}


/**
 * Function For Open Modal Instant by pushing HTML Element
 * @param {Object} data
 */
function openModalByContent(data = {
  content:"",
  animation: "mfp-move-horizontal",
  size: "medium",
}) {
  $.magnificPopup.open({
    removalDelay: 500,
    items: {
      src: `<div class="white-popup mfp-with-anim ${data.size ?? "medium"}">${data.content}</div>`, // can be a HTML string, jQuery object, or CSS selector
    },
    callbacks: {
      beforeOpen: function() {
        this.st.mainClass = data.animation ?? "mfp-move-horizontal";
      },
      open: function() {
        var modalCloseBtn = this.contentContainer.find(".modal-close");
        $(modalCloseBtn).click(function() {
          $.magnificPopup.close();
        });
      },
    },
    midClick: true,
  });
}

/**
 * Function For Open Modal with CSS Selector Ex: "#modal-popup"
 * @param {String} selector
 * @param {String} animation
 */
function openModalBySelector(selector,animation = "mfp-move-horizontal") {
    $(selector).addClass("white-popup mfp-with-anim");
    if(animation == null) {
      animation = "mfp-zoom-in"
    }
    $.magnificPopup.open({
      removalDelay: 500,
      items: {
        src: $(selector), // can be a HTML string, jQuery object, or CSS selector
        type: 'inline',
      },

      callbacks: {
        beforeOpen: function() {
          this.st.mainClass = animation;
        },
        elementParse: function(item) {
          var modalCloseBtn = $(selector).find(".modal-close");
          $(modalCloseBtn).click(function() {
            $.magnificPopup.close();
          });
        },
      },
    });
  $.magnificPopup.instance._onFocusIn = function(e) {
    // Do nothing if target element is select2 input
    if( $(e.target).hasClass('select2-search__field') ) {
        return true;
    }
    // Else call parent method
    $.magnificPopup.proto._onFocusIn.call(this,e);
  }
}


function currentModalClose() {
  return $.magnificPopup.instance.close();
}

/**
 * Function For Get All TimeZone list by AJAX Request
 * @param {HTML DOM} targetElement
 * @param {Error Place Element} errorElement
 * @returns
 */
function getTimeZones(hitUrl,targetElement = $(".timezone-select"),errorElement = $(".timezone-select").siblings(".select2")) {
  if(targetElement.length == 0) {
    return false;
  }
  var CSRF = $("meta[name=csrf-token]").attr("content");
  var data = {
      _token      : CSRF,
  };
  $.post(hitUrl,data,function() {
      // success
      $(errorElement).removeClass("is-invalid");
      $(targetElement).siblings(".invalid-feedback").remove();
  }).done(function(response){
      // Place States to States Field
      var options = "<option selected disabled>Select Timezone</option>";
      var selected_old_data = "";
      if($(targetElement).attr("data-old") != null) {
          selected_old_data = $(targetElement).attr("data-old");
      }
      $.each(response,function(index,item) {
          options += `<option value="${item.name}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
      });

      $(targetElement).html(options);
  }).fail(function(response) {
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
  });
}


/**
 * Fucntion for check limit of input field attr is 'data-limit'
 */
function inputLimitGuard() {
  var inputElement = $("input,textarea");
  $.each(inputElement,function(index,item) {
      if($(item).attr("data-limit") != undefined) {
          var charLimit = $(this).attr("data-limit");
          var limitShow = `<code class="float-end text-success">${$(item).val().length}/${charLimit}</code>`;
          $(item).after(limitShow);
          $(item).keyup(function() {
              var updateText = `${$(this).val().length}/${charLimit}`;
              var errorSms = "Please follow the input limit.";
              $(this).siblings("code").text(updateText);
              if($(this).val().length > charLimit) {
                  $(this).parent().addClass("limit-error");
                  $(this).parents('form').find("input[type=submit],button[type=submit]").attr("disabled",true);
                  if($(this).siblings(".limit-error-sms").length > 0) {
                      $(this).siblings(".limit-error-sms").text(errorSms);
                  }else {
                      $(this).parent().append(
                          `<div class="limit-error-sms text-danger mt-1 fw-bold" style="font-size:12px">${errorSms}</div>`
                      );
                  }
              }else {
                  $(this).parent().removeClass("limit-error");
                  $(this).parents('form').find("input[type=submit],button[type=submit]").attr("disabled",false);
                  $(this).siblings(".limit-error-sms").remove();
              }
          });
          var updateText = `${$(item).val().length}/${charLimit}`;
          var errorSms = "Please follow the input limit.";
          $(item).siblings("code").text(updateText);
          if($(item).val().length > charLimit) {
              $(item).parent().addClass("limit-error");
              $(item).parents('form').find("input[type=submit],button[type=submit]").attr("disabled",true);
              if($(item).siblings(".limit-error-sms").length > 0) {
                  $(item).siblings(".limit-error-sms").text(errorSms);
              }else {
                  $(item).parent().append(
                      `<div class="limit-error-sms text-danger mt-1 fw-bold" style="font-size:12px">${errorSms}</div>`
                  );
              }
          }else {
              $(item).parent().removeClass("limit-error");
              $(item).parents('form').find("input[type=submit],button[type=submit]").attr("disabled",false);
              $(item).siblings(".limit-error-sms").remove();
          }
      }
  });
}
inputLimitGuard();


/**
 * Function for re init switcher. If exists parent element the it's find under parent otherwise it's find hole body
 * @param {string} parentElement
 */
function refreshSwitchers(parentElement = null) {
  if(parentElement == null) {
      parentElement = "body";
  }

  parentElement = $(parentElement);
  var switchers = parentElement.find(".switch-toggles");
  $.each(switchers,function(index,item) {
      var switcherInput = $(item).find("input").first();
      var switcherInputValue = switcherInput.val();
      var firstSwitcherBtn =  $(item).find(".switch").first().attr("data-value");
      if(switcherInputValue == firstSwitcherBtn) {
          $(item).addClass("active");
      }else {
          $(item).removeClass("active");
      }
  });

}

/**
 * Function for making a form hidden input
 * @param {string} value
 * @returns input field
 */
function formHiddenInput(value,name="target") {
  return `<input type="hidden" name="${name}" value="${value}">`;
}

/**
 * Function for select radio button that already you have a value
 * @param {string} selector
 * @param {string} oldValue
 */
function selectFormRadio(selector,oldValue) {
  var radioInputs = $(selector);
  $.each(radioInputs,function(index,item) {
    if(oldValue == "") {
      $(item).prop("checked",false);
    }

    if($(item).val() == oldValue) {
      $(item).prop("checked",true);
    }
  });
}

/**
 * Function for initialize rich text editor (CKEditor 5)
 * @param {String} element_class
 */
function richTextEditorInit(element_class) {
  var richTextElements = document.querySelectorAll(element_class);
  richTextElements.forEach((element) => {
    CKEDITOR.ClassicEditor.create(element, {
      toolbar: {
          items: [
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
          ],
          shouldNotGroupWhenFull: true
      },
      placeholder: 'Type Here...',
      removePlugins: [
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType'
      ]
    });
  });
}

$(document).ready(function(){
  richTextEditorInit(".rich-text-editor");
});
function richTextEditorReinit(element) {
    $(element).siblings(".ck-editor").remove();
    CKEDITOR.ClassicEditor.create(element, {
      toolbar: {
          items: [
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
          ],
          shouldNotGroupWhenFull: true
      },
      placeholder: 'Type Here...',
      removePlugins: [
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType'
      ]
    });
}
// Stored HTML Markup
var storedHtmlMarkup = {
  add_money_automatic_gateway_credentials_field: `<div class="row align-items-end">
    <div class="col-xl-3 col-lg-3 form-group">
        <label>Title*</label>
        <input type="text" class="form--control" placeholder="Type Here..." name="title[]">
    </div>
    <div class="col-xl-3 col-lg-3 form-group">
        <label>Name*</label>
        <input type="text" class="form--control" placeholder="Type Here..." name="name[]">
    </div>
    <div class="col-xl-5 col-lg-5 form-group">
        <label>Value</label>
        <input type="text" class="form--control" placeholder="Type Here..." name="value[]">
    </div>

    <div class="col-xl-1 col-lg-1 form-group">
        <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
    </div>
  </div>`,
  payment_gateway_currency_block: `<div class="custom-card mt-15 gateway-currency" style="display:none;">
  <div class="card-header">
      <h6 class="currency-title"></h6>
  </div>
  <div class="card-body">
    <div class="row align-items-center">
        <div class="col-xl-2 col-lg-2 form-group">
            <label>Gateway Image</label>
            <input type="file" class="file-holder image" name="" accept="image/*">
        </div>
        <div class="col-xl-3 col-lg-3 mb-10">
            <div class="custom-inner-card">
                <div class="card-inner-header">
                    <h5 class="title">Amount Limit*</h5>
                </div>
                <div class="card-inner-body">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Minimum</label>
                                <div class="input-group">
                                    <input type="number" class="form--control min-limit" value="0" name="" step="any">
                                    <span class="input-group-text currency"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Maximum</label>
                                <div class="input-group">
                                    <input type="number" class="form--control max-limit" value="0" name="" step="any">
                                    <span class="input-group-text currency"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 mb-10">
            <div class="custom-inner-card">
                <div class="card-inner-header">
                    <h5 class="title">Charge*</h5>
                </div>
                <div class="card-inner-body">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Fixed*</label>
                                <div class="input-group">
                                    <input type="number" class="form--control fixed-charge" value="0" name="" step="any">
                                    <span class="input-group-text currency"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Percent*</label>
                                <div class="input-group">
                                    <input type="number" class="form--control percent-charge" value="0" name="" step="any">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 mb-10">
            <div class="custom-inner-card">
                <div class="card-inner-header">
                    <h5 class="title">Rate*</h5>
                </div>
                <div class="card-inner-body">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Rate*</label>
                                <div class="input-group">
                                    <span class="input-group-text append ">1 &nbsp; <span class="default-currency"></span> = </span>
                                    <input type="number" class="form--control rate" value="" name="" step="any">
                                    <span class="input-group-text currency"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12 col-xl-6 col-lg-6 form-group">
                            <div class="form-group">
                                <label>Symbol</label>
                                <div class="input-group">
                                    <input type="text" class="form--control symbol" value="" name="" placeholder="Symbol">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>`,
  payment_gateway_currencies_wrapper: `<div class="payment-gateway-currencies-wrapper"></div>`,
  modal_default_alert: `<div class="card modal-alert border-0">
    <div class="card-body">
        <div class="head mb-3">
            {{replace}}
        </div>
        <div class="foot d-flex align-items-center justify-content-between">
            <button type="button" class="modal-close btn btn--info">Close</button>
            <button type="button" class="alert-submit-btn btn btn--danger btn-loading">Remove</button>
        </div>
    </div>
  </div>
  `,
  manual_gateway_input_fields:`<div class="row add-row-wrapper align-items-end">
  <div class="col-xl-3 col-lg-3 form-group">
    <label>Field Name*</label>
    <input type="text" class="form--control" placeholder="Type Here..." name="label[]" value="" required>
  </div>

  <div class="col-xl-2 col-lg-2 form-group">
      <label>Field Types*</label>
      <select class="form--control nice-select field-input-type" name="input_type[]">
          <option value="text" selected>Input Text</option>
          <option value="file">File</option>
          <option value="textarea">Textarea</option>
      </select>
  </div>

  <div class="field_type_input col-lg-4 col-xl-4">

  </div>

  <div class="col-xl-2 col-lg-2 form-group">
    <label for="fieldnecessity">Field Necessity*</label>
    <div class="toggle-container">
      <div data-clickable="true" class="switch-toggles default two active">
        <input type="hidden" name="field_necessity[]" value="1">
        <span class="switch " data-value="1">Required</span>
        <span class="switch " data-value="0">Optional</span>
      </div>
    </div>
  </div>

  <div class="col-xl-1 col-lg-1 form-group">
      <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
  </div>
</div>
  `,
  kyc_input_fields:`<div class="row add-row-wrapper align-items-end">
  <div class="col-xl-3 col-lg-3 form-group">
    <label>Field Name*</label>
    <input type="text" class="form--control" placeholder="Type Here..." name="label[]" value="" required>
  </div>

  <div class="col-xl-2 col-lg-2 form-group">
      <label>Field Types*</label>
      <select class="form--control nice-select field-input-type" name="input_type[]">
          <option value="text" selected>Input Text</option>
          <option value="file">File</option>
          <option value="textarea">Textarea</option>
          <option value="select">Select</option>
      </select>
  </div>

  <div class="field_type_input col-lg-4 col-xl-4">

  </div>

  <div class="col-xl-2 col-lg-2 form-group">
    <label for="fieldnecessity">Field Necessity*</label>
    <div class="toggle-container">
      <div data-clickable="true" class="switch-toggles default two active">
        <input type="hidden" name="field_necessity[]" value="1">
        <span class="switch " data-value="1">Required</span>
        <span class="switch " data-value="0">Optional</span>
      </div>
    </div>
  </div>

  <div class="col-xl-1 col-lg-1 form-group">
      <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
  </div>
</div>
  `,
  manual_gateway_input_text_validation_field:`<div class="row">
  <div class="col-xl-6 col-lg-6 form-group">
      <label>Min Character*</label>
      <input type="number" class="form--control" placeholder="ex: 6" name="min_char[]" value="0" required>
  </div>
  <div class="col-xl-6 col-lg-6 form-group">
      <label>Max Character*</label>
      <input type="number" class="form--control" placeholder="ex: 16" name="max_char[]" value="30" required>
  </div>
</div>`,
  manual_gateway_input_file_validation_field: `<div class="row">
  <div class="col-xl-6 col-lg-6 form-group">
    <label>Max File Size (mb)*</label>
    <input type="number" class="form--control" placeholder="ex: 10" name="file_max_size[]" value="10" required>
  </div>
  <div class="col-xl-6 col-lg-6 form-group">
    <label>File Extension*</label>
    <input type="text" class="form--control" placeholder="ex: jpg, png, pdf" name="file_extensions[]" value="" required>
  </div>
</div>`,
manual_gateway_select_validation_field: `<div class="row">
<div class="col-xl-12 col-lg-12 form-group">
  <label>Options*</label>
  <input type="text" class="form--control" placeholder="Type Here..." name="select_options[]" required>
</div>
</div>`,
};

function getHtmlMarkup() {
  return storedHtmlMarkup;
}
// getHtmlMarkup();

function replaceText(htmlMarkup,updateText) {
  return htmlMarkup.replace("{{replace}}",updateText);
}

// Generate Unique String ----- START ------------
function dec2hex (dec) {
  return dec.toString(16).padStart(2, "0");
}

function generateUniqueId (len) {
  var arr = new Uint8Array((len || 40) / 2);
  window.crypto.getRandomValues(arr);
  return Array.from(arr, dec2hex).join('');
}
// Generate Unique String ----- END ------------


/**
 * Function for make AJAX request with URL, Data and Method
 * @param {string} URL
 * @param {object} data
 * @param {string} method
 */
function makeAjaxRequest(URL,data,method = "DELETE") {
    //
}

/**
 * Refresh all button that have "btn-loading" class
 */
function btnLoadingRefresh() {
  $.each($(".btn-loading"),function(index,item){
    if($(item).find(".btn-ring").length == 0) {
      $(item).append(`<span class="btn-ring"></span>`);
    }
  });
}

/**
 * Function for getting CSRF token for form submit in laravel
 * @returns string
 */
function laravelCsrf() {
  return $("head meta[name=csrf-token]").attr("content");
}

/**
 * Function for help to add new input field in manual payment gateway
 */
function inputFieldValidationRuleFieldsShow(element) {
  if($(element).attr("data-show-db") != undefined) {
    return false;
  }
  var value = element.val();
  var validationFieldsPlaceElement = $(element).parents(".add-row-wrapper").find(".field_type_input");
  if(value == "text" || value == "textarea") {
    var textValidationFields = getHtmlMarkup().manual_gateway_input_text_validation_field;
    validationFieldsPlaceElement.html(textValidationFields);
  }else if(value == "file") {
    var textValidationFields = getHtmlMarkup().manual_gateway_input_file_validation_field;
    validationFieldsPlaceElement.html(textValidationFields);
    var select2Input = validationFieldsPlaceElement.find(".select2-auto-tokenize");
    $(select2Input).select2();
  }else if(value == "select") {
    var textValidationFields = getHtmlMarkup().manual_gateway_select_validation_field;
    validationFieldsPlaceElement.html(textValidationFields);
  }

  // Refresh all file extension input name
  var fileExtenionSelect = $(element).parents(".results").find(".add-row-wrapper").find(".file-ext-select");
  $.each(fileExtenionSelect,function(index,item) {
    var fileExtSelectFieldName = "file_extensions["+index+"][]";
    $(item).attr("name",fileExtSelectFieldName);
  });
}


// Generate Random Password
function makeRandomString(length,type = "alpha_speacial") {
  var result           = '';
  var characters       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  if(type == "alpha_speacial") {
    var characters       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
  }else if(type == "alpha") {
    var characters       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  }else if(type == "alpha_speacial_number") {
    var characters       = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
  }
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}


/**
 * Function for open delete modal with method DELETE
 * @param {string} URL
 * @param {string} target
 * @param {string} message
 * @returns
 */
function openDeleteModal(URL,target,message,actionBtnText = "Remove",method = "DELETE"){
  if(URL == "" || target == "") {
      return false;
  }

  if(message == "") {
      message = "Are you sure to delete ?";
  }
  var method = `<input type="hidden" name="_method" value="${method}">`;
  openModalByContent(
      {
          content: `<div class="card modal-alert border-0">
                      <div class="card-body">
                          <form method="POST" action="${URL}">
                              <input type="hidden" name="_token" value="${laravelCsrf()}">
                              ${method}
                              <div class="head mb-3">
                                  ${message}
                                  <input type="hidden" name="target" value="${target}">
                              </div>
                              <div class="foot d-flex align-items-center justify-content-between">
                                  <button type="button" class="modal-close btn btn--info">Close</button>
                                  <button type="submit" class="alert-submit-btn btn btn--danger btn-loading">${actionBtnText}</button>
                              </div>
                          </form>
                      </div>
                  </div>`,
      },

  );
}

const pluck = property => element => element[property];

function allowNegetiveNumber() {
  $("input[type=number],.input-number").on("keydown",function(e){
    if($(this).attr("type") != undefined && $(this).attr("type") == "number") {
      $(this).attr("step","any");
    }
    var numeric_key_codes = [8,9,13,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,110];
    if(numeric_key_codes.includes(e.which)) {
      return true;
    }
    return false;
  });
}

allowNegetiveNumber();

/**
 * Function for search admin panel sidebar menu item
 */
function sideBarSearch(){
  var menuLinks = $(".sidebar-menu a");
  var filterMenuItem = [];
  $.each(menuLinks,function(index,item) {
      if($(item).attr("href") != "javascript:void(0)") {
        filterMenuItem.push(item);
      }
  });

  $(".sidebar-search-input").keyup(function(){
    sideBarSearchWithInput($(this),filterMenuItem);
  })
}
sideBarSearch();


function sideBarSearchWithInput(input,navItems) {
  var inputValue = input.val().toLowerCase();
  var searchResult = [];
  $.each(navItems,function(index,item) {
    var title = $(item).find("span").text().toLowerCase();
    var result = title.match(inputValue)
    if(result != null) {
      searchResult.push(item);
    }
  });
  $(".sidebar-search-result").html("");
  $.each(searchResult,function(index,item){
    var link = $(item).attr("href");
    var title = $(item).find("span").text();
    var iconClass = $(item).find("i").attr("class");
    var singleItem = `<div class="single-item">
            <a href="${link}">
              <i class="${iconClass}"></i>
              <span style="position:inherit">${title}</span>
            </a>
    </div>`
    $(".sidebar-search-result").append(singleItem);
  });

}

// Internal Search Section
var timeOut;
function itemSearch(inputElement,tableElement,URL,minTextLength = 3) {
  $(inputElement).bind("keyup",function(){
    clearTimeout(timeOut);
    timeOut = setTimeout(executeItemSearch, 500,$(this),tableElement,URL,minTextLength);
  });
}

function executeItemSearch(inputElement,tableElement,URL,minTextLength) {
  $(tableElement).parent().find(".search-result-table").remove();
  var searchText = inputElement.val();
  if(searchText.length > minTextLength) {
    $(tableElement).addClass("d-none");
    makeSearchItemXmlRequest(searchText,tableElement,URL);
  }else {
    $(tableElement).removeClass("d-none");
  }
}

function makeSearchItemXmlRequest(searchText,tableElement,URL) {
  var data = {
    _token      : laravelCsrf(),
    text        : searchText,
  };
  $.post(URL,data,function(response) {
    //response
  }).done(function(response){
    itemSearchResult(response,tableElement);
    //
  }).fail(function(response) {
    throwMessage('error',["Something went worng! Please try again."]);
  });
}

function itemSearchResult(response,tableElement) {
  if(response == "") {
    throwMessage('error',["No data found!"]);
  }
  if($(tableElement).siblings(".search-result-table").length > 0) {
    $(tableElement).parent().find(".search-result-table").html(response);
  }else{
    $(tableElement).after(`<div class="search-result-table"></div>`);
    $(tableElement).parent().find(".search-result-table").html(response);
  }
}

function placePhoneCode(code) {
  if(code != undefined) {
      code = code.replace("+","");
      code = "+" + code;
      $("input.phone-code").val(code);
      $("div.phone-code").html(code);
  }
}

function postFormAndSubmit(action,target) {
  var postForm = `<form id="post-form-dy" action="${action}" method="POST">
    <input type="hidden" name="_token" value="${laravelCsrf()}" />
    <input type="hidden" name="target" value="${target}" />
  </form>`;
  $("body").append(postForm);
  $("#post-form-dy").submit();
}
