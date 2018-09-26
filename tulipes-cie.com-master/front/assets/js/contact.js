import $ from 'jquery';
import animateTarget from './animateOnAnchor.js'

const formContact  = $('.formContact-form');
const formResponse = $('.formContact-response');

function selectObjectRecruitment() {
  const url = location.href;
  if (url.indexOf("#recruitment") !== -1) {
    $(".select-object").val("canditature").change();
    const target = $(".formContact");
    animateTarget(target);
  }
}

function sendFormContact() {

  $('.formContact-form__submit').on('click', function (e) {

    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: formContact.attr('action'),
      data: new FormData(formContact.get(0)),
      async: false,
      cache: false,
      contentType: false,
      processData: false,

    }).done( function (response) {
      if (response.success) {
        formResponse.removeClass('formContact-response__error');
        formResponse.addClass('formContact-response__success');
      } else {
        formResponse.removeClass('formContact-response__success');
        formResponse.addClass('formContact-response__error');
      }

      formResponse.html(response.message)

    }).fail( function (response) {
      formResponse.html("Problème sur l'envoi du formulaire. Veuillez ressayer ultérieurement.");
    });
    return false;
  });
}

export default function () {
  selectObjectRecruitment();
  sendFormContact();
}