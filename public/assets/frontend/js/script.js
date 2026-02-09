
$(document).ready(function () {
  var $niceSelect1 = $('.search-select'),
    $niceSelect2 = $('.filter-select'),
    $niceSelect3 = $('.mNiceSelect'),
    $niceSelectAll = $('.at-nice-select'),
    $select2 = $('.at-select2'),
    $btslider1 = $('.btSlider'),
    $btslider2 = $('.btSlider2'),
    $ua_slider = $('.ua-slider'),
    $tab_slider = $('.tab-slider'),
    $banner_slider = $('.banner-slider'),
    $mhtesti_slider = $('.mh-testimonial'),
    $gallery = $('.hoteldetails-gallery-list'),
    $venobox = $('.veno-gallery-img'),
    $player1 = $('.at-video-player'),
    $mixitup = $('.mixitup'),
    $counter = $('.at-counter');

  // Nice Select 
  if ($niceSelect1.length > 0) {
    $('.search-select').niceSelect();
  }
  if ($niceSelect2.length > 0) {
    $('.filter-select').niceSelect();
  }
  if ($niceSelect3.length > 0) {
    $($niceSelect3).niceSelect();
  }
  if ($niceSelectAll.length > 0) {
    $($niceSelectAll).niceSelect();
  }

  // bootstrap slider With JQuery
  if ($btslider1.length > 0) {
    $('.btSlider').slider({
      formatter: function (value) {
        return 'Value: ' + value + '$';
      }
    });
  }
  if ($btslider2.length > 0) {
    $('.btSlider2').slider({
      formatter: function (value) {
        return 'Value: ' + value;
      }
    });
  }


  // Hotel Details Magnific Popup
  if ($gallery.length > 0) {
    $('.hoteldetails-gallery-list').each(function () {
      $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        closeBtnInside: false,
        gallery: {
          enabled: true
        },
        zoom: {
          enabled: true,
          duration: 300,
          easing: 'ease-in-out',
        }
      });
    });
  }
  // Video Magnific Popup
  if ($('.video-popup').length > 0) {
    $('.video-popup').each(function () {
      new VenoBox({
        selector: '.video-popup',
      });
    });
  }
  // modal venobox popup
  if ($venobox.length > 0) {
    new VenoBox({
      selector: '.veno-gallery-img',
      numeration: true,
      navigation: true,
      infinigall: true,
      share: true,
      navTouch: true,
      spinner: "rotating-plane",
    });
  }



  // Click to Image Change 
  $('.small-image-view').click(function () {
    $(".big-image-view").attr("src", $(this).attr("src"));
  });



  // Video Player active 
  if (typeof Plyr !== 'undefined') {
    const playerElements = document.querySelectorAll('.at-video-player');
    if (playerElements.length > 0) {
      const player = new Plyr('.at-video-player');
    }
  }

  // Counter 
  if ($counter.length > 0) {
    $($counter).counterUp({
      delay: 10,
      time: 1200,
    });
  }

  // homepage menu class toggle
  // Handle focus event
  $('.at-home-search-input').on('focus', function () {
    $(".at-home-menu-wrap").addClass("search-focus-active");
  });
  // Handle blur event
  $('.at-home-search-input').on('blur', function () {
    $(".at-home-menu-wrap").removeClass("search-focus-active");
  });

  // For home page search 
  $('.at-home-search-btn').on('mouseover', function () {
    $('.at-home-search-input').addClass('highlighted');
  });
  $('.at-home-search-btn').on('mouseout', function () {
    $('.at-home-search-input').removeClass('highlighted');
  });


  // For Doctor home filter
  var dtfilterheight = $('.dt-banner-search-wrap').height();
  $('.dt-hero-banner').css('margin-bottom', -(dtfilterheight + 40) + 'px');


  // Password Toggle 
  $(".toggle-icons .password-icon").click(function () {
    $(this).siblings().removeClass('d-none');
    var $this = $(this);
    if (!$this.hasClass('d-none')) {
      $this.addClass('d-none');
    }
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  // Login slider 
  if ($ua_slider.length > 0) {
    var uaswiper = new Swiper(".ua-slider", {
      spaceBetween: 30,
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      effect: "fade",
    });
  }

  // tab slider 
  if ($tab_slider.length > 0) {
    var tabswiper = new Swiper(".tab-slider", {
      spaceBetween: 2,
      slidesPerView: "auto",
      speed: 500,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  // Main home page slider 
  if ($banner_slider.length > 0) {
    var bannerswiper = new Swiper(".banner-slider", {
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      effect: "fade",
    });
  }

  // Main home page Testimonial 
  if ($mhtesti_slider.length > 0) {
    var mhtestimonial = new Swiper(".mh-testimonial", {
      loop: true,
      speed: 1000,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      slidesPerView: 1.1,
      spaceBetween: 24,
      centeredSlides: true,
      breakpoints: {
        451: {
          slidesPerView: 1.1,
        },
        576: {
          slidesPerView: 1.5,
        },
        768: {
          slidesPerView: 2.5,
        },
        991: {
          slidesPerView: 3.1,
        },
        1200: {
          slidesPerView: 4,
        },
      },
    });
  }

  // Sidebar submenu 
  $(".sidebar-nav-link-sub").on("click", function () {
    $(this).parent().toggleClass("active");
    $(".sidebar-nav-item-sub").not($(this).parent()).removeClass("active");
    $(this).siblings(".sidebar-dropdown-menu").slideToggle();
    $(".sidebar-dropdown-menu").not($(this).siblings()).slideUp();
  });

  // Mobile First Accordion Menu 
  $('.have-sub-menu .first-a').click(function () {
    if (parseInt($(window).width()) < 1200) {
      $(this).parent().toggleClass("active-submenu");
      $(this).siblings(".first-sub-menu").slideToggle();
      $(".have-sub-menu").not($(this).parent()).removeClass("active-submenu");
      $(".first-sub-menu").not($(this).siblings()).slideUp();
    }
  });
  // Mobile Accordion Menu 
  $('.atn-nav-link-sub').click(function () {
    if (parseInt($(window).width()) < 1200) {
      $(this).parent().toggleClass("active");
      $(this).siblings(".atn-nav-link-drop").slideToggle();
      $(".atn-nav-item-sub").not($(this).parent()).removeClass("active");
      $(".atn-nav-link-drop").not($(this).siblings()).slideUp();
    }
  });

  // mixitup plugin
  if ($mixitup.length > 0) {
    var containerEl = document.querySelector('.mixitup');
    var mixer = mixitup(containerEl, {
      load: {
        filter: 'all'
      },
      animation: {
        effectsIn: 'fade translateY(-100%)',
        effects: 'fade translateZ(-100px)'
      }
    });
  }

  // if ($('.mixitup2').length > 0) {
  //   var containerEls = document.querySelector('.mixitup2');
  //   var mixers = mixitup(containerEls, {
  //     load: {
  //       filter: defaultFilter
  //     },
  //     animation: {
  //       effectsIn: 'fade translateY(-100%)',
  //       effects: 'fade translateZ(-100px)'
  //     }
  //   });
  // }
  if ($('.mixitup2').length > 0) {
        var containerEls = document.querySelector('.mixitup2');
        var defaultFilter = document.getElementById('defaultFilter').value; 

        var mixers = mixitup(containerEls, {
            load: {
                filter: defaultFilter 
            },
            animation: {
                effectsIn: 'fade translateY(-100%)',
                effects: 'fade translateZ(-100px)'
            }
        });
    }

  // Select 2
  if ($select2.length > 0) {
    $select = $(".at-select2").select2({});
    $($select).each(function () {
      $(this).data('select2').$dropdown.addClass('select2-drop-container');
    });
  }



  // Image Upload Start
  jQuery(document).ready(function () {
    ImgUpload();
  });
  function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function () {
      $(this).on('change', function (e) {
        imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        var maxLength = $(this).attr('data-max_length');

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        var iterator = 0;
        filesArr.forEach(function (f, index) {

          if (!f.type.match('image.*')) {
            return;
          }

          if (imgArray.length > maxLength) {
            return false
          } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i] !== undefined) {
                len++;
              }
            }
            if (len > maxLength) {
              return false;
            } else {
              imgArray.push(f);

              var reader = new FileReader();
              reader.onload = function (e) {
                // var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='upload-img-bg'><div class='upload__img-close'></div></div></div>";
                // imgWrap.append(html);
                iterator++;
              }
              reader.readAsDataURL(f);
            }
          }
        });
      });
    });
    $('body').on('click', ".upload__img-close", function (e) {
      var file = $(this).parent().data("file");
      for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
          imgArray.splice(i, 1);
          break;
        }
      }
      $(this).parent().parent().remove();
    });
  }
  // Image Upload End 



  // Flatpicker date time
  if ($('.flat-input-picker').length) {
    $(".flat-input-picker").flatpickr({
      enableTime: true,
      // dateFormat: "d M Y h:i K",
      dateFormat: "d M Y h:i K",
    });
  }
  if ($('.flat-date-picker').length) {
    // Flatpicker date
    $(".flat-date-picker").flatpickr({
    });
  }
  if ($('.flat-time-picker').length) {
    // Flatpicker time
    $(".flat-time-picker").flatpickr({
      enableTime: true,
      noCalendar: true,
      dateFormat: "h:i K",
    });
  }

  if ($('.flat-input-picker2').length) {
    // Flatpicker date time 2
    $(".flat-input-picker2").flatpickr({
      enableTime: true,
      dateFormat: "d M Y h:i K",
      onReady(_, __, fp) {
        fp.calendarContainer.classList.add("ht-flat-picker");
      }
    });
  }

  if ($('.flat-date-picker2').length) {
    // Flatpicker date 2
    $(".flat-date-picker2").flatpickr({
      onReady(_, __, fp) {
        fp.calendarContainer.classList.add("ht-flat-picker");
      }
    });
  }

  if ($('.flat-time-picker2').length) {
    // Flatpicker time 2
    $(".flat-time-picker2").flatpickr({
      enableTime: true,
      noCalendar: true,
      dateFormat: "h:i K",
      onReady(_, __, fp) {
        fp.calendarContainer.classList.add("ht-flat-picker");
      }
    });
  }





});




// Sidebar Accordion 
function accordion2() {
  var Accordion2 = function (el, multiple) {
    this.el = el || {};
    this.multiple = multiple || false;
    var links = this.el.find('.sidebar-accordion-li > a');
    links.on('click', { el: this.el, multiple: this.multiple }, this.dropdown)
  }

  Accordion2.prototype.dropdown = function (e) {
    var $el = e.data.el,
      $this = $(this),
      $next = $this.next();

    $next.slideToggle();
    $this.parent().toggleClass('active');

    if (!e.data.multiple) {
      $el.find('.sidebar-accordion-menu').not($next).slideUp().parent().removeClass('active');
      $el.find('.sidebar-accordion-menu').not($next).slideUp();
    };
  }
  var accordion2 = new Accordion2($('.sidebar-accordion'), false);
}
accordion2();
// Sidebar Accordion 


// Grid Banner Slider 
var swiper1 = new Swiper(".grid-banner-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    // type: "fraction",
    dynamicBullets: true,
  },
  keyboard: true,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,

  on: {
    slideChange: function () {
      var that = this; // Capture the correct context
      setTimeout(function () {
        var currentSlide = that.realIndex + 1;
        if (currentSlide <= 9) {
          var currentSlide1 = '0'.concat(currentSlide);
        } else {
          var currentSlide1 = currentSlide;
        }
        $(that.wrapperEl).parent().find(".current-slide").html(currentSlide1);
        var totalSlide = $(that.wrapperEl).find(".swiper-slide").length;
        if (totalSlide <= 11) {
          var totalSlide1 = '0'.concat(totalSlide - 2);
        } else {
          var totalSlide1 = totalSlide - 2;
        }
        $(that.wrapperEl).parent().find(".total-slides").html(totalSlide1);

      });
    },

  },

});


// List Banner Slider 
var swiper2 = new Swiper(".list-banner-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  keyboard: true,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,

  on: {
    slideChange: function () {
      var that = this; // Capture the correct context
      setTimeout(function () {
        var currentSlide = that.realIndex + 1;
        if (currentSlide <= 9) {
          var currentSlide1 = '0'.concat(currentSlide);
        } else {
          var currentSlide1 = currentSlide;
        }
        $(that.wrapperEl).parent().find(".current-slide").html(currentSlide1);
        var totalSlide = $(that.wrapperEl).find(".swiper-slide").length;
        if (totalSlide <= 11) {
          var totalSlide1 = '0'.concat(totalSlide - 2);
        } else {
          var totalSlide1 = totalSlide - 2;
        }
        $(that.wrapperEl).parent().find(".total-slides").html(totalSlide1);

      });
    },

  },

});

// Real Estate Floor Plans
var swiper3 = new Swiper(".floor-plans-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  keyboard: true,
  slidesPerView: 2,
  spaceBetween: 28,
  loop: true,
  breakpoints: {
    451: {
      slidesPerView: 3,
    },
    576: {
      slidesPerView: 4,
    },
    768: {
      slidesPerView: 5,
    },
    991: {
      slidesPerView: 4,
    },
    1200: {
      slidesPerView: 5,
    },
  },
});

// Restaurant Details Banner Slider 
var swiper4 = new Swiper(".resdetails-banner-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    //   type: "fraction",
  },
  keyboard: true,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
});

// Details Banner Slider 
var atnbannerslider = new Swiper(".atn-banner-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    //   type: "fraction",
  },
  keyboard: true,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
});

// Car Details Banner Slider 
var swiper5 = new Swiper(".cardetails-banner-slider", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    //   type: "fraction",
  },
  keyboard: true,
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
});




// Player js 
if (typeof Plyr !== 'undefined') {
  const playerElements = document.querySelectorAll('#player');
  if (playerElements.length > 0) {
    const player = new Plyr('#player');
  }
}


jQuery(document).ready(function ($) {
  $(window).scroll(function () {
    let scrollPosition = $(window).scrollTop();
    // Show button when scrolled down 1000px from the top
    if (scrollPosition > 1000) {
      $('.scroll-icon-area').fadeIn();
    } else {
      $('.scroll-icon-area').fadeOut();
    }
  });

  $(".scroll-btn").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 2000);
    return false;
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});