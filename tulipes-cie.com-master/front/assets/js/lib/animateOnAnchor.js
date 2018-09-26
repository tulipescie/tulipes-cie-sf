import $ from 'jquery';

function animateTarget(target, duration = "slow") {
  $("html, body").animate(
    {
      scrollTop: target.offset().top,
    },
    duration
  );
}

export default animateTarget;
