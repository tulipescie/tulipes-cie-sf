import $ from 'jquery';

const form = $('.newsletter-form');
const email = form.find('.newsletter-email');
const submitBtn = form.find('.newsletter-submit');
const formMessage = $('.newsletter-message');
const emailFooter = $('.footer .newsletter-email');

function checkEmailInput() {
  const reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  email.keyup(() => {
    if (reg.test(email.val())) {
      formMessage.hide();
      $('.newsletter-email_valide').show();
      emailFooter.css('border', 'none');
    } else {
      formMessage.hide();
      $('.newsletter-email_no_valide').show();
      emailFooter.css('border', '1px solid red');
    }
  });
}

function sendFormNewsletterSuscriber() {
  form.on('submit', function (e) {

    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data: form.serialize(),

    }).done( function (response) {
      formMessage.hide();
      $('.newsletter-success').show();
      $('.modal-newletter__content').hide();
      $('.modal-newletter__confirmation').css('display', 'flex');
    }).fail( function (response) {
      formMessage.hide();
      $('.newsletter-error').show();
    });

  });
}

export default function () {
  checkEmailInput();
  sendFormNewsletterSuscriber();
};