import $ from 'jquery';
import slick from 'slick-carousel';

function selectViewAgency() {
  const vision = $(".view-name");
  vision.click(function () {
    let idVision = $(this).attr("href");
    $(".view-describe__active").removeClass("view-describe__active");
    $(".view-describe" + idVision).addClass("view-describe__active");
    $(".view-name__active").removeClass("view-name__active");
    $(this).addClass("view-name__active");
    return false;
  });
}

function sliderViewInMobile() {

  $(".view-for").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    asNavFor: ".view-nav",
    autoplay: false,
    arrows: false,
    dots: true,
  });
  $(".view-nav").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".view-for",
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    arrows: true,
    prevArrow: $('.view .slider-prev'),
    nextArrow: $('.view .slider-next'),
  });
}

function viewAgencyInResponsive() {
  if (window.matchMedia("(min-width: 991px)").matches) {
    selectViewAgency();
  } else {
    sliderViewInMobile();
  }
}

function sliderJobInMobile() {
  $('.job-text').addClass('in');

  $('.job-number').click(function () {
    let numberActive = $(this).find('span').text();
    $('.job-text__active').removeClass('job-text__active');
    $('#job-' + numberActive).addClass('job-text__active');
    $('.job-number__active').removeClass('job-number__active');
    $(this).addClass('job-number__active');
  });
}

function sliderNumbers() {
  $('.numbers-slider').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    prevArrow: $('.numbers .slider-prev'),
    nextArrow: $('.numbers .slider-next'),
    responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 1,
      },
    }
  ],
  });
}

function sliderCustomers() {
  $('.customers-slider').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    prevArrow: $('.customers .slider-prev'),
    nextArrow: $('.customers .slider-next'),
    responsive: [
    {
      breakpoint: 991,
      settings: {
        arrows: false,
        slidesToShow: 5,
        centerMode: true,
      },
      breakpoint: 768,
      settings: {
        arrows: false,
        slidesToShow: 3,
        centerMode: true,
        centerPadding: '40px',
      },
    }
  ],
  });
}

export default function () {
  viewAgencyInResponsive();
  sliderJobInMobile();
  sliderNumbers();
  sliderCustomers();
}