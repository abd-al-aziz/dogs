(function ($) {
    "user strict";

    // preloader
    $("#loader")
        .delay(500)
        .animate(
            {
                opacity: "0",
            },
            500,
            function () {
                $("#loader").css("display", "none");
            }
        );

    // wow
    if ($(".wow").length) {
        var wow = new WOW({
            boxClass: "wow",
            // animated element css class (default is wow)
            animateClass: "animated",
            // animation css class (default is animated)
            offset: 0,
            // distance to the element when triggering the animation (default is 0)
            mobile: false,
            // trigger animations on mobile devices (default is true)
            live: true, // act on asynchronously loaded content (default is true)
        });
        wow.init();
    }

    // navbar-click
    $(".navbar li a").on("click", function () {
        var element = $(this).parent("li");
        if (element.hasClass("show")) {
            element.removeClass("show");
            element.find("li").removeClass("show");
        } else {
            element.addClass("show");
            element.siblings("li").removeClass("show");
            element.siblings("li").find("li").removeClass("show");
        }
    });

    // scroll-to-top
    $(".scrollToTop").on("click", function () {
        $(window).scrollTop(0);
    });

    // faq
    $(".faq-wrapper .faq-title").on("click", function (e) {
        var element = $(this).parent(".faq-item");
        if (element.hasClass("open")) {
            element.removeClass("open");
            element.find(".faq-content").removeClass("open");
            element.find(".faq-content").slideUp(300, "swing");
        } else {
            element.addClass("open");
            element.children(".faq-content").slideDown(300, "swing");
            element
                .siblings(".faq-item")
                .children(".faq-content")
                .slideUp(300, "swing");
            element.siblings(".faq-item").removeClass("open");
            element
                .siblings(".faq-item")
                .find(".faq-title")
                .removeClass("open");
            element
                .siblings(".taq-item")
                .find(".faq-content")
                .slideUp(300, "swing");
        }
    });

    // slider
    var swiper = new Swiper(".testimonial-slider", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            speed: 1000,
            delay: 3000,
        },
        speed: 1000,
        breakpoints: {
            1199: {
                slidesPerView: 2,
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
            420: {
                slidesPerView: 1,
            },
        },
    });

    var swiper = new Swiper(".category-slider", {
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
                slidesPerView: 4,
            },
            991: {
                slidesPerView: 3,
            },
            767: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 1,
            },
            420: {
                slidesPerView: 1,
            },
        },
    });
    //upload
    function proPicURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = $(input)
                    .parents(".preview-thumb")
                    .find(".profilePicPreview");
                $(preview).css(
                    "background-image",
                    "url(" + e.target.result + ")"
                );
                $(preview).addClass("has-image");
                $(preview).hide();
                $(preview).fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".profilePicUpload").on("change", function () {
        proPicURL(this);
    });

    $(".remove-image").on("click", function () {
        $(".profilePicPreview").css("background-image", "none");
        $(".profilePicPreview").removeClass("has-image");
    });

    // User Dashboard Right Menu 

    $(".dashboard-user").on("click", function () {
        $(".mobile-menu-dashboard").toggleClass("show");
        $(".hide-overlay").addClass("show");
    });

    $(".hide-overlay").on("click", function () {
        $(".mobile-menu-dashboard").removeClass("show");
        $(".hide-overlay").removeClass("show");
    });

      // User Dashboard Left Menu 

    $(".submenu-wrap").on("click", function () {
        $(".submenu").toggleClass("show");
        $(".hide-overlay").addClass("show");
    });

    $(".hide-overlay").on("click", function () {
        $(".submenu").removeClass("show");
        $(".hide-overlay").removeClass("show");
    });

    /*============** Mgnific Popup **============*/
    $(".image-popup").magnificPopup({
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    $(".popup_video").magnificPopup({
        type: "iframe",
    });

  
    /*============** Number Increment Decrement **============*/
    $(".add").on("click", function () {
        if ($(this).prev().val() < 999) {
          $(this)
            .prev()
            .val(+$(this).prev().val() + 1);
        }
      });
      
      $(".sub").on("click", function () {
        if ($(this).next().val() > 1) {
          if ($(this).next().val() > 1)
            $(this)
            .next()
            .val(+$(this).next().val() - 1);
        }
      });

          /*================== Show Login Toggle Js ==========*/
    $('#showlogin').on('click', function () {
        $('#checkout-login').slideToggle(700);
      });
  
      /*================== Show Coupon Toggle Js ==========*/
      $('#showcupon').on('click', function () {
        $('#coupon-checkout').slideToggle(400);
      });


})(jQuery);
