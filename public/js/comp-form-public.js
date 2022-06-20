jQuery(function ($) {
  'use strict';
  // Form validation

  let submission = false;
  $("input[name='comp_conf_password']").on("input", function(){
    if($("input[name='comp_password']").val() !== $(this).val()){
      $(this).css("border-color", "red");
      document.querySelector("input[name='comp_conf_password']").reportValidity(true);
      submission = false;
    }
    if($("input[name='comp_password']").val() === $(this).val()){
      $(this).css("border-color", "#cccccc1f");
      document.querySelector("input[name='comp_conf_password']").setCustomValidity("");
      submission = true;
    }
  });


  $("#comp__registration_form").on("submit", function(e){
    if(!submission){
      e.preventDefault();
    }
  });

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


  $("#role_select").on("change", function(){
    switch ($(this).val()) {
      case 'student':
        $('#name_row').removeClass('noned');
        $('#team_row').addClass('noned');
        $('input[name="comp_first_name"]').prop('required', true);
        $('input[name="school_team_name"]').removeAttr('required');
        break;
      case 'school':
        $('#name_row').addClass('noned');
        $('#team_row').removeClass('noned');
        $('input[name="school_team_name"]').prop('required', true);
        $('input[name="comp_first_name"]').removeAttr('required');
        break;
    }
  })
});
