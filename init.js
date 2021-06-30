$(document).ready(function(){
  $("input[name='contact_number']").mask("+7(999) 999-9999");
  $('#suggest').on('input', function() { 
    if ($("#suggest").val().length != 0){ 
       $('#reg-btn').attr("disabled", true);
    } else {
       $('#reg-btn').attr("disabled", false);
    }
    $("input[type='hidden']").each(function() {
      $(this).attr('value', '');
    });
  });
  $('form[id="register"]').validate({
    rules: {
      firstname: 'required',
      lastname: 'required',
      contact_number: 'required',
      address: 'required',
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 8,
      }
    },
    messages: {
      firstname: 'Введите имя',
      lastname: 'Введите фамилию',
      contact_number: 'Введите номер',
      address: 'Введите адрес',
      email: 'Введите email',
      password: {
        required: 'Введите пароль обязательно',
        minlength: 'Пароль слишком короткий. Рекомендуемая длина - 8.'
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});