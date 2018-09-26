import $ from 'jquery';
import cookie from 'cookie';

function cookiesDisclaimer() {
  const cookiesDisclaimer = $(".cookies-disclaimer");
  const cookies = cookie.parse(document.cookie);

  if (!cookies.accept_cookies) {
    cookiesDisclaimer.show();
  } else {
    cookiesDisclaimer.remove();
  }

  cookiesDisclaimer
    .find(".cookies-disclaimer-accept")
    .on("click", function(e) {
      e.preventDefault();
      cookiesDisclaimer.hide();
      document.cookie = cookie.serialize("accept_cookies", true, { path: "/" });
    });
}

export default cookiesDisclaimer;

