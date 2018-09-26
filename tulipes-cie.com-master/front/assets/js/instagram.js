import $ from 'jquery';

function getAccessToken() {
  let url = window.location.href;
  let token = url.split('#access_token=')[1];
  let routeSetAccessToken = $('.instagram-url-token').val();

  // console.log(routeSetAccessToken + '?token=' + token);
  window.location.replace(routeSetAccessToken + '?token=' + token );
}

export default function () {
  getAccessToken();
}