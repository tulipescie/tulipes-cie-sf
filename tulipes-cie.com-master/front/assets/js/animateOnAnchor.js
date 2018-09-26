import $ from 'jquery';

function animateTarget(target, duration = "slow") {
  $("html, body").animate(
    {
      scrollTop: target.offset().top-68,
    },
    duration
  );
}

export default animateTarget;