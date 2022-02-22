(function ($) {
  "user strict";

  // preloader
  $(".preloader").delay(800).animate({
    "opacity": "0"
  }, 800, function () {
      $(".preloader").css("display", "none");
  });

// wow
if ($('.wow').length) {
  var wow = new WOW({
    boxClass: 'wow',
    // animated element css class (default is wow)
    animateClass: 'animated',
    // animation css class (default is animated)
    offset: 0,
    // distance to the element when triggering the animation (default is 0)
    mobile: false,
    // trigger animations on mobile devices (default is true)
    live: true // act on asynchronously loaded content (default is true)
  });
  wow.init();
}

//Create Background Image
(function background() {
  let img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
})();

$(document).ready(function () {
  $('.select').select2();
});


// header-fixed
var fixed_top = $(".header-section");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 100){  
        fixed_top.addClass("animated fadeInDown header-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown header-fixed");
    }
});

// navbar-click
$(".main-menu li a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("show")) {
    element.removeClass("show");
    element.find("li").removeClass("show");
  }
  else {
    element.addClass("show");
    element.siblings("li").removeClass("show");
    element.siblings("li").find("li").removeClass("show");
  }
});

// scroll-to-top
var ScrollTop = $(".scrollToTop");
$(window).on('scroll', function () {
  if ($(this).scrollTop() < 100) {
      ScrollTop.removeClass("active");
  } else {
      ScrollTop.addClass("active");
  }
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

// slider
var swiper = new Swiper('.client-slider', {
  slidesPerView: 2,
  spaceBetween: 30,
  loop: true,
  // autoplay: {
  //   speed: 1000,
  //   delay: 3000,
  // },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});


var swiper = new Swiper('.brand-wrapper', {
  slidesPerView: 7,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 2000,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 5,
    },
    767: {
      slidesPerView: 3,
    },
    575: {
      slidesPerView: 2,
    },
  }
});

//Odometer
if ($(".statistics-item").length) {
  $(".statistics-item").each(function () {
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

// sidebar
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

//sidebar Menu
$(document).on('click', '.sidebar-collapse-icon', function () {
  $('.page-container').toggleClass('show');
});

// Mobile Menu
$('.sidebar-mobile-menu').on('click', function () {
  $('.sidebar-main-menu').slideToggle();
});
  

})(jQuery);