import $ from 'jquery';

function reloadVideoOnResieze() {
  window.addEventListener('resize',() => {
    waitLoadingVideo
  });
}

function waitLoadingVideo() {
  let video;
  if ($(".home-video__desktop.home-video--active").css('display') == 'block') {
    video = document.querySelector(".home-video__desktop.home-video--active");
  } else {
    video = document.querySelector(".home-video__mobile.home-video--active");
  }
  
  const spinner = $('.home .spinner');

  video.onwaiting = function () {
    spinner.show();
  };

  video.oncanplay = function () {
    spinner.hide();
  };
}

function loadNextVideo() {
  const videosDesktopList = Array.prototype.slice.call($(".home-video__desktop"));
  const videosMobileList = Array.prototype.slice.call($(".home-video__mobile"));

  videosDesktopList.forEach(function (videoDesk) {
    videoDesk.addEventListener("ended", function () {

      if ($(this).hasClass("home-video--active")){
        endedVideo(videosDesktopList, $(this)[0] );
      }
    });
  });

  videosMobileList.forEach(function (videoMobile) {
    videoMobile.addEventListener("ended", function () {

      if ($(this).hasClass("home-video--active")){
        endedVideo(videosMobileList, $(this)[0] );
      }
    });
  });

}

function endedVideo(videosList, videoActive) {
  // videoActive.onended = function () {
    const indexVideoActive = videosList.indexOf(videoActive);

    $(videoActive).removeClass("home-video--active");

    if (indexVideoActive < videosList.length - 1) {
      $(videosList[indexVideoActive + 1]).addClass("home-video--active");
      videosList[indexVideoActive + 1].play();
    } else {
      $(videosList[0]).addClass("home-video--active");
      videosList[0].play();
    }
  // };
}

function openModalNewsletter() {
  $(".open-modal-newsletter").click(function() {
    $(".modal-newletter").show();
  });

  $(".close-modal-newsletter").click(function() {
    $(".modal-newletter").hide();
  });

  $(window).click(function(event) {
    if ($(event.target).is(".modal-newletter")) {
      $(".modal-newletter").hide();
    }
  });
}

export default function () {
  openModalNewsletter();
  waitLoadingVideo();
  loadNextVideo();
}