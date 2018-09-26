import $ from "jquery";

export default function bulbe() {
  //show video popin
  $(".bulbe-video").click(function(e) {
    e.preventDefault();
    let id = $(this).attr("href");
    $(id).show();
  });

  //hide video popin
  $(".bulbeList-video--iframe").click(function(e) {
    e.preventDefault();
    $(this).hide();
  });

  //active slideshow
  $(function() {
    setInterval(function() {
      const slideshow = $(".slideshow-list");
      for (let i = 0; i < slideshow.length; i++) {
        const slides = $(slideshow[i]).find(".slideshow-slide");
        const slidesList = Array.prototype.slice.call(slides);
        const slideActive = $(slideshow[i]).find(".slideshow-slide--active")[0];
        const indexSlideActive = slidesList.indexOf(slideActive);

        $(slideActive).removeClass("slideshow-slide--active");

        if (indexSlideActive < slidesList.length - 1) {
          $(slidesList[indexSlideActive + 1]).addClass(
            "slideshow-slide--active"
          );
        } else {
          $(slidesList[0]).addClass("slideshow-slide--active");
        }
      }
    }, 4000);
  });
}
