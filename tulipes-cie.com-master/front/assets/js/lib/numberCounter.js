import $ from 'jquery';

export default function numberCounter() {
  let a = 0;
  $(window).scroll(function() {

    let oTop = $(".animated-counter").offset().top - window.innerHeight;

    if (a == 0 && $(window).scrollTop() > oTop) {
      $('.count').each(function () {
        $(this).prop('Counter', 0).animate({
          Counter: $(this).text()
        }, {
          duration: 2000,
          easing: 'swing',
          step: function (now) {
            let number = Math.ceil(now);
            $(this).text(number.toLocaleString());
          }
        });
      });
      a = 1;
    }
  });
}