(function ($) {
"user strict";

//preloder
$(window).on('load', function() {
    $(".preloader").delay(1500).animate({
      "opacity": "0"
    }, 1500, function () {
        $(".preloader").css("display", "none");
    });
  });
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

// lightcase
 $(window).on('load', function () {
  $("a[data-rel^=lightcase]").lightcase();
})


// header-fixed
var fixed_top = $(".header-section");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 300){
        fixed_top.addClass("animated fadeInDown header-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown header-fixed");
    }
});

// navbar-click
$(".navbar li a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("show")) {
    element.removeClass("show");
    element.children("ul").slideUp(500);
  }
  else {
    element.siblings("li").removeClass('show');
    element.addClass("show");
    element.siblings("li").find("ul").slideUp(500);
    element.children('ul').slideDown(500);
  }
});

//Odometer
if ($(".counter").length) {
  $(".counter").each(function () {
    $(this).isInViewport(function (status) {
      if (status === "entered") {
        for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
          var el = document.querySelectorAll('.odometer')[i];
          el.innerHTML = el.getAttribute("data-odometer-final");
        }
      }
    });
  });
}

//toggle password

$(".toggle-password").click(function() {

  $(this).toggleClass("la-eye la-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
  input.attr("type", "text");
  } else {
  input.attr("type", "password");
  }
  });
//toggle password

$(document).ready(function() {
  $(".show_hide_password a").on('click', function(event) {
      event.preventDefault();
      if($('.show_hide_password input').attr("type") == "text"){
          $('.show_hide_password input').attr('type', 'password');
          $('.show_hide_password i').addClass( "fa-eye-slash" );
          $('.show_hide_password i').removeClass( "fa-eye" );
      }else if($('.show_hide_password input').attr("type") == "password"){
          $('.show_hide_password input').attr('type', 'text');
          $('.show_hide_password i').removeClass( "fa-eye-slash" );
          $('.show_hide_password i').addClass( "fa-eye" );
      }
  });
});
$(document).ready(function() {
    $(".show_hide_password-2 a").on('click', function(event) {
        event.preventDefault();
        if($('.show_hide_password-2 input').attr("type") == "text"){
            $('.show_hide_password-2 input').attr('type', 'password');
            $('.show_hide_password-2 i').addClass( "fa-eye-slash" );
            $('.show_hide_password-2 i').removeClass( "fa-eye" );
        }else if($('.show_hide_password-2 input').attr("type") == "password"){
            $('.show_hide_password-2 input').attr('type', 'text');
            $('.show_hide_password-2 i').removeClass( "fa-eye-slash" );
            $('.show_hide_password-2 i').addClass( "fa-eye" );
        }
    });
  });
  $(document).ready(function() {
    $(".show_hide_password-3 a").on('click', function(event) {
        event.preventDefault();
        if($('.show_hide_password-3 input').attr("type") == "text"){
            $('.show_hide_password-3 input').attr('type', 'password');
            $('.show_hide_password-3 i').addClass( "fa-eye-slash" );
            $('.show_hide_password-3 i').removeClass( "fa-eye" );
        }else if($('.show_hide_password-3 input').attr("type") == "password"){
            $('.show_hide_password-3 input').attr('type', 'text');
            $('.show_hide_password-3 i').removeClass( "fa-eye-slash" );
            $('.show_hide_password-3 i').addClass( "fa-eye" );
        }
    });
  });

// faq
$('.faq-wrapper .faq-title').on('click', function (e) {
  var element = $(this).parent('.faq-item');
  if (element.hasClass('open')) {
    element.removeClass('open');
    element.find('.faq-content').removeClass('open');
    element.find('.faq-content').slideUp(300, "swing");
  } else {
    element.addClass('open');
    element.children('.faq-content').slideDown(300, "swing");
    element.siblings('.faq-item').children('.faq-content').slideUp(300, "swing");
    element.siblings('.faq-item').removeClass('open');
    element.siblings('.faq-item').find('.faq-title').removeClass('open');
    element.siblings('.taq-item').find('.faq-content').slideUp(300, "swing");
  }
});

//sidebar Menu
$(document).on('click', '.sidebar-collapse-icon', function () {
    $('.page-container').toggleClass('show');
  });
  // sidebar sub
  $(".has-sub > a").on("click", function () {
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
  // Mobile Menu
  $('.sidebar-mobile-menu').on('click', function () {
    $('.sidebar-main-menu').slideToggle();
  });
  //sidebar Menu
  $('.sidebar-menu-bar').on('click', function (e) {
    e.preventDefault();
    if($('.sidebar, .navbar-wrapper, .body-wrapper').hasClass('active')) {
      $('.sidebar, .navbar-wrapper, .body-wrapper').removeClass('active');
      $('.body-overlay').removeClass('active');
    }else {
      $('.sidebar, .navbar-wrapper, .body-wrapper').addClass('active');
      $('.body-overlay').addClass('active');
    }
  });
  $('#body-overlay').on('click', function (e) {
    e.preventDefault();
    $('.sidebar, .navbar-wrapper, .body-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  });
  //sidebar Menu
  $(document).on('click', '.notification-icon', function () {
    $('.notification-wrapper').toggleClass('active');
  });


// slider
var swiper = new Swiper(".brand-slider", {
  slidesPerView: 5,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    1199: {
    slidesPerView: 5,
    },
    991: {
    slidesPerView: 4,
    },
    767: {
    slidesPerView: 3,
    },
    575: {
    slidesPerView: 2,
    },
  }
});

var swiper = new Swiper(".testimonial-slider", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    1199: {
    slidesPerView: 1,
    },
    991: {
    slidesPerView: 1,
    },
    767: {
    slidesPerView: 1,
    },
    575: {
    slidesPerView: 1,
    },
  }
});

var swiper = new Swiper(".card-slider", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  speed: 1000,
  breakpoints: {
    1199: {
    slidesPerView: 1,
    },
    991: {
    slidesPerView: 1,
    },
    767: {
    slidesPerView: 1,
    },
    575: {
    slidesPerView: 1,
    },
  }
});

$(document).ready(function () {
  var AFFIX_TOP_LIMIT = 300;
  var AFFIX_OFFSET = 110;

  var $menu = $("#menu"),
  $btn = $("#menu-toggle");

  $("#menu-toggle").on("click", function () {
      $menu.toggleClass("open");
      return false;
  });


  $(".docs-nav").each(function () {
      var $affixNav = $(this),
    $container = $affixNav.parent(),
    affixNavfixed = false,
    originalClassName = this.className,
    current = null,
    $links = $affixNav.find("a");

      function getClosestHeader(top) {
          var last = $links.first();

          if (top < AFFIX_TOP_LIMIT) {
              return last;
          }

          for (var i = 0; i < $links.length; i++) {
              var $link = $links.eq(i),
        href = $link.attr("href");

              if (href.charAt(0) === "#" && href.length > 1) {
                  var $anchor = $(href).first();

                  if ($anchor.length > 0) {
                      var offset = $anchor.offset();

                      if (top < offset.top - AFFIX_OFFSET) {
                          return last;
                      }

                      last = $link;
                  }
              }
          }
          return last;
      }


      $(window).on("scroll", function (evt) {
          var top = window.scrollY,
        height = $affixNav.outerHeight(),
        max_bottom = $container.offset().top + $container.outerHeight(),
        bottom = top + height + AFFIX_OFFSET;

          if (affixNavfixed) {
              if (top <= AFFIX_TOP_LIMIT) {
                  $affixNav.removeClass("fixed");
                  $affixNav.css("top", 0);
                  affixNavfixed = false;
              } else if (bottom > max_bottom) {
                  $affixNav.css("top", (max_bottom - height) - top);
              } else {
                  $affixNav.css("top", AFFIX_OFFSET);
              }
          } else if (top > AFFIX_TOP_LIMIT) {
              $affixNav.addClass("fixed");
              affixNavfixed = true;
          }

          var $current = getClosestHeader(top);

          if (current !== $current) {
              $affixNav.find(".active").removeClass("active");
              $current.addClass("active");
              current = $current;
          }
      });
  });
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
// active menu JS
function splitSlash(data) {
  return data.split('/').pop();
}
function splitQuestion(data) {
  return data.split('?').shift().trim();
}
var pageNavLis = $('.sidebar-menu a');
var dividePath = splitSlash(window.location.href);
var divideGetData = splitQuestion(dividePath);
var currentPageUrl = divideGetData;

// find current sidevar element
$.each(pageNavLis,function(index,item){
    var anchoreTag = $(item);
    var anchoreTagHref = $(item).attr('href');
    var index = anchoreTagHref.indexOf('/');
    var getUri = "";
    if(index != -1) {
      // split with /
      getUri = splitSlash(anchoreTagHref);
      getUri = splitQuestion(getUri);
    }else {
      getUri = splitQuestion(anchoreTagHref);
    }
    if(getUri == currentPageUrl) {
      var thisElementParent = anchoreTag.parents('.sidebar-menu-item');
      (anchoreTag.hasClass('nav-link') == true) ? anchoreTag.addClass('active') : thisElementParent.addClass('active');
      (anchoreTag.parents('.sidebar-dropdown')) ? anchoreTag.parents('.sidebar-dropdown').addClass('active') : '';
      (thisElementParent.find('.sidebar-submenu')) ? thisElementParent.find('.sidebar-submenu').slideDown("slow") : '';
      return false;
    }
});

// dashboard-list
$(document).on('click','.dashboard-list-item',function (e) {
    if(e.target.classList.contains("select-btn")) {
      $(".dashboard-list-item-wrapper .select-btn").text("Select");
      $(e.target).text("Selected");
      return false;
    }
    var element = $(this).parent('.dashboard-list-item-wrapper');
    if (element.hasClass('show')) {
      element.removeClass('show');
      element.find('.preview-list-wrapper').removeClass('show');
      element.find('.preview-list-wrapper').slideUp(300, "swing");
    } else {
      element.addClass('show');
      element.children('.preview-list-wrapper').slideDown(300, "swing");
      element.siblings('.dashboard-list-item-wrapper').children('.preview-list-wrapper').slideUp(300, "swing");
      element.siblings('.dashboard-list-item-wrapper').removeClass('show');
      element.siblings('.dashboard-list-item-wrapper').find('.dashboard-list-item').removeClass('show');
      element.siblings('.dashboard-list-item-wrapper').find('.preview-list-wrapper').slideUp(300, "swing");
    }
  });
  $(document).on("click",".dashboard-list-item-wrapper .select-btn",function(){
    $(".dashboard-list-item-wrapper").removeClass("selected");
    $(this).parents(".dashboard-list-item-wrapper").toggleClass("selected");
  });

// invoice-form
$('.invoice-form').on('click', '.add-row-btn', function() {
  $('.add-row-btn').closest('.invoice-form').find('.add-row-wrapper').last().clone().show().appendTo('.results');
});

$(document).on('click','.invoice-cross-btn', function (e) {
e.preventDefault();
$(this).parent().parent().hide(300);
});

//pdf
$('.pdf').on('click', function (e) {
  e.preventDefault();
  $('.pdf-area').addClass('active');
  $('.body-overlay').addClass('active');
});
$('#body-overlay, #pdf-area').on('click', function (e) {
  e.preventDefault();
  $('.pdf-area').removeClass('active');
  $('.body-overlay').removeClass('active');
})

//Profile Upload
function proPicURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          var preview = $(input).parents('.preview-thumb').find('.profilePicPreview');
          $(preview).css('background-image', 'url(' + e.target.result + ')');
          $(preview).addClass('has-image');
          $(preview).hide();
          $(preview).fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
  }
}
$(".profilePicUpload").on('change', function () {
  proPicURL(this);
});

$(".remove-image").on('click', function () {
  $(".profilePicPreview").css('background-image', 'none');
  $(".profilePicPreview").removeClass('has-image');
});


//info-btn
$(document).on('click', '.info-btn', function () {
  $('.support-profile-wrapper').addClass('active');
});
$(document).on('click', '.chat-cross-btn', function () {
  $('.support-profile-wrapper').removeClass('active');
});


$(document).on("click",".card-custom",function(){
  $(this).toggleClass("active");
});

//account-toggle
$('.header-account-btn').on('click', function () {
    $('.account-section').addClass('active');
  });
  $('.account-close, .account-bg').on('click', function () {
    $('.account-section').addClass('duration');
    setTimeout(signupRemoveClass, 200);
    setTimeout(signupRemoveClass2, 200);
  });
  function signupRemoveClass() {
    $('.account-section').removeClass("active");
  }
  function signupRemoveClass2() {
    $('.account-section').removeClass("duration");
  }
  $('.account-control-btn').on('click', function () {
    $('.account-area').toggleClass('change-form');
  })


$(".buy-btn").click(function(){
  $("#sell").addClass("d-none");
  $("#buy").removeClass("d-none");
  $(this).addClass("active");
  $(".sell-btn").removeClass("active");
});
$(".sell-btn").click(function(){
  $("#sell").removeClass("d-none");
  $("#buy").addClass("d-none");
  $(this).addClass("active");
  $(".buy-btn").removeClass("active");
});


$("form button[type=submit], form input[type=submit]").on("click", function (event) {
    var inputFileds = $(this).parents("form").find("input[type=text], input[type=number], input[type=email], input[type=password]");
    var mode = false;
    $.each(inputFileds, function (index, item) {
        if ($(item).attr("required") != undefined) {
            if ($(item).val() == "") {
                mode = true;
            }
        }
    });
    if (mode == false) {
        $(this).parents("form").find(".btn-ring").show();
        $(this).parents("form").find("button[type=submit],input[type=submit]").prop("disabled", true);
        $(this).parents("form").submit();
    }
});

$(document).ready(function () {
    $.each($(".btn-loading"), function (index, item) {
        $(item).append(`<span class="btn-ring"></span>`);
    });
});

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


})(jQuery);

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
          options += `<option value="${item.name}" data-id="${item.id}" data-mobile-code="${item.mobile_code}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
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
  // select-2 init
  $('.select2-basic').select2();
  $('.select2-multi-select').select2();
  $(".select2-auto-tokenize").select2({
  tags: true,
  tokenSeparators: [',']
  });
  function placePhoneCode(code) {
    if(code != undefined) {
        code = code.replace("+","");
        code = "+" + code;
        $("input.phone-code").val(code);
        $("div.phone-code").html(code);
    }
  }
  /**
 * Refresh all button that have "btn-loading" class
 */
function btnLoadingRefresh() {
    $.each($(".btn-loading"), function (index, item) {
        if ($(item).find(".btn-ring").length == 0) {
            $(item).append(`<span class="btn-ring"></span>`);
        }
    });
}
// switch-toggles
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

        $(eventElement).parents(".switch-toggles").find(".switch").find(".btn-ring").hide();

        $(eventElement).parents(".switch-toggles.btn-load").toggleClass('active');
        var dataValue = $(eventElement).parents(".switch-toggles").find(".switch").last().attr("data-value");
        if($(eventElement).parents(".switch-toggles").hasClass("active")) {
          dataValue = $(eventElement).parents(".switch-toggles").find(".switch").first().attr("data-value");
          $(eventElement).parents(".switch-toggles").find(".switch").first().find(".btn-ring").hide();
        }
        $(eventElement).parents(".switch-toggles.btn-load").find("input").val(dataValue);
        $(eventElement).parents(".switch-toggles").find(".switch").last().find(".btn-ring").hide();


      }).fail(function(response) {
          var response = JSON.parse(response.responseText);
          throwMessage(response.type,response.message.error);

          $(eventElement).parents(".switch-toggles").find(".switch").addClass("event-ready");
          $(eventElement).parents(".switch-toggles").find(".btn-ring").hide();
          return false;
      });

    });
}

$('textarea').keydown(function (e) {
    const keyCode = e.which || e.keyCode;
    if (keyCode === 13 && !e.shiftKey) {
      e.preventDefault();
    }
  });





