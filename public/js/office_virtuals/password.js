$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {

  $("#formPassword").validate({
    rules: {
      usuario :         {  required: true, minlength: 4, maxlength: 15},
      password:         {  required: true, minlength: 6,  },
      password_confirm: {  required: true, minlength: 6, equalTo: "#password" },
    },
    onkeyup :false,
    errorPlacement : function(error, element) {
     $(element).closest('.form-group').find('.help-block').html(error.html());
     },
     highlight : function(element) {
     $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
     },
     unhighlight: function(element, errorClass, validClass) {
     $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
     $(element).closest('.form-group').find('.help-block').html('');
     },
     submitHandler: function(form) {
       alertify.confirm('<div align="center"><b>Cambiar Contraseña</div>', '<div align="center">¡Confirmas que deseas continuar con la operación!</div>',         function(){
         form.submit();
      }, function(){  alertify.error('Cancelar')  }).set({labels:{ok:'Guardar', cancel: 'Cancelar'}, padding: false});
   }


  });

});

$("#reveal-password_old" ).on('click',function(e){
  var i = $(this).find('i');
  i.attr('class', i.hasClass('glyphicon glyphicon-eye-open') ? ' glyphicon glyphicon-eye-close' : 'glyphicon glyphicon-eye-open');
  $('#password_old').attr('type',i.hasClass('glyphicon glyphicon-eye-close') ? 'text' : 'password');
});

$("#reveal-password" ).on('click',function(e){
  var i = $(this).find('i');
  i.attr('class', i.hasClass('glyphicon glyphicon-eye-open') ? ' glyphicon glyphicon-eye-close' : 'glyphicon glyphicon-eye-open');
  $('#password').attr('type',i.hasClass('glyphicon glyphicon-eye-close') ? 'text' : 'password');
});
$("#reveal-password2").on('click',function(e){
  var i = $(this).find('i');
  i.attr('class', i.hasClass('glyphicon glyphicon-eye-open') ? ' glyphicon glyphicon-eye-close' : 'glyphicon glyphicon-eye-open');
  $('#password_confirm').attr('type',i.hasClass('glyphicon glyphicon-eye-close') ? 'text' : 'password');
});


$.extend( $.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida.",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    extension: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
    minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
    rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
    range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
    max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
    min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
    nifES: "Por favor, escribe un NIF válido.",
    nieES: "Por favor, escribe un NIE válido.",
    cifES: "Por favor, escribe un CIF válido.",
});
