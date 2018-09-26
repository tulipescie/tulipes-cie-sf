import $ from 'jquery';

$.validator.addMethod('require-one', function(value) {
  return $('.require-one:checked').size() > 0;
});

$.extend( $.validator.messages, Config.ERRORS);

module.exports = {
  focusInvalid: false,
  validClass: 'success',
  showErrors: function (errorMap, errorList) {
    for (var i = 0; i < errorList.length; i++) {
      var tagName = errorList[i].element.tagName;
      var element = $(errorList[i].element);
      var message = errorList[i].message;
      var labelTemplate = '<label for=' + element.attr('id') + ' class="error-label">' + message + '</label>';

      var label = $('.error-label[for="' + element.attr('id') + '"]')
      var labelExists = label.length > 0;

      if (labelExists) {
        label.text(message);
      }

      if (tagName === 'SELECT') {
        element.addClass('error');
        var select2Container = $(element).next('.select2-container');
        select2Container.addClass('error');
        element.removeClass('success');
        if (!labelExists) {
          element.before(labelTemplate);
        }
      }
      else if (element.attr('type') === 'radio') {
        if (!labelExists) {
          parent = element.closest('.form-row');
          element.addClass('error');
          element.removeClass('success');
          parent.prepend(labelTemplate);
        }
      }
      else {
        element.addClass('error');
        element.removeClass('success');
        if (!labelExists) {
          element.before(labelTemplate);
        }
      }
    }

    this.successList = $.grep( this.successList, function( element ) {
      return !( element.name in errorMap );
    });

    for (var i = 0; i < this.successList.length; i++) {
      var element = this.successList[i];
      $('.error-label[for="' + element.id + '"]').remove();
      if (element.tagName === 'SELECT') {
        var select2Container = $(element).next('.select2-container');
        select2Container.removeClass('error');
      }
      $(element).removeClass('error');
      $(element).addClass('success');
    }
  }
};

export default validateconfig();
