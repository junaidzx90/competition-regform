jQuery(function ($) {
  'use strict';
  // Form validation
  $('#comp__login_form').on('submit', function (e) {
    $(this)
      .find("input[type='text'], input[type='password']")
      .each(function () {
        if ($(this).val().length === 0) {
          e.preventDefault();
          $(this).css('border-color', 'red');
        }

        $(this).on('keyup, change', function () {
          if ($(this).val().length > 0) {
            $(this).css('border-color', '#00d4c6');
          }
        });
      });
  });
});
