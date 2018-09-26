import $ from 'jquery';
import slick from 'slick-carousel';

function sliderothersProject() {
  $('.othersProjects-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    centerMode: false,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          arrows: false,
          slidesToShow: 3,
          centerMode: true,
          variableWidth: true,
        },
        breakpoint: 768,
        settings: {
          arrows: false,
          slidesToShow: 1,
          centerMode: true,
          variableWidth: true,
        },
      }
    ],
  });
}

function showSocialIcon() {
  const activateBtn = $('.project-share');
  const iconGroup = $('.details-social, .customerVideo-social');
  activateBtn.click(() => {
    iconGroup.slideDown();
    iconGroup.css("display", "flex");

    return false;
  });
}

export default function () {
  sliderothersProject();
  showSocialIcon();
}