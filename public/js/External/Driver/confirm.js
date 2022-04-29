$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var phone = 0;
var email = 0;
var licence = 0;
var tipoid = 0;
var valphone = 0;
var valemail = 0;
var valor;




function validatePhone()
{
  if ($('#phone').val().length == 9){
  $.ajax(
  {
    url: "/driver/externo/phoneval",
    type:"POST",
    data : { value : $('#phone').val(),id_office:$('#id_office').val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          phone = 1;
        }else{
          phone = 0;
          validatePhoneExits();
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registrÃ³, intente nuevamente por favor.");
  });
  }

}

function validateEmailExits()
{
  if($('#email').val().length > 0)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
    $.ajax(
      {
        url: "/driver/externo/confir/email/new",
        type:"POST",
        data :{ token_generado : contrasenia, email:$('#email').val()},
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d){
$('#load_inv').hide(30);
	if(d.object=='success' && d.data == 1){
		alert("este correo ya fue validado.");
	}
        else if (d.object=='success'){
          
          codigoGene = d.data;
          alert("Se envio un codigo de verificaciÃ³n a su correo por favor verifique e ingrese el codigo.");
        }
        else {
          alert(d.menssage)
        }
      }).fail(function(error){
        console.log(error);
        alert("No se registrÃ³, intente nuevamente por favor.");
      });


  }else {
    alert('EL CORREO YA EXISTE O ES UN CORREO INVALIDO.');
  }
}


function validateEmail()
{
  if ($('#email').val().length > 0){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($('#email').val().trim())) {
        $.ajax(
        {
          url: "/driver/externo/emailval",
          type:"POST",
          data : { value : $('#email').val(),id_office:$('#id_office').val() },
          dataType: "json",
        }).done(function(d){
              if (d.flag == true){
                alert(d.mensaje);
                email = 1;
              }else{
                email = 0;
                validateEmailExits();
              }
        }).fail(function(error){
          console.log(error);
          alert("No se registrÃ³, intente nuevamente por favor.");
        });

    } else {
        alert('La direcciÃ³n de correo no es válida');
        email = 1;
    }
  }
}

var codigoGenePhone;
var contrasenia;
function validatePhoneExits()
{
  if($('#phone').val().length == 9)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));

    $.ajax(
      {
        url: "/driver/externo/confir/phone/new",
        type:"POST",
        data :{ token_generado : contrasenia, phone:$('#phone').val(),id_office:$('#id_office').val()},
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d){
        if (d.object=='success'){
          $('#load_inv').hide(30);
          codigoGenePhone = d.data;
          alert(d.menssage);
        } else {
          alert(d.menssage)
        }
      }).fail(function(error){
        console.log(error);
        alert("No se registrÃ³, intente nuevamente por favor.");
      });

  }else {
    alert('EL NUMERO DE TELEFONO YA EXISTE O ES UN NUMERO INVALIDO.');
  }
}


function validateCodigoEmail(){
        if($('#cod-email').val().length == 4)
        {
          $.ajax(
              {
                url: "/driver/externo/confir/email/confirm",
                type:"POST",
                data :{ num : $('#cod-email').val(), token_generado: $('#email').val(),id_office:$('#id_office').val()},
                dataType: "json",
                beforeSend: function () {
                $('#load_inv').show(30);
                }
              }).done(function(d){
                $('#load_inv').hide(30);
                if (d.object=='success'){
                  valemail = 0;
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", true);
                  $('#email').prop("disabled", true);
                }
                else {
                  valemail = 1;
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", false);
                  $('#email').prop("disabled", false);
                }
              }).fail(function(error){
                console.log(error);
                alert("intente nuevamente por favor.");
              });
        }else{
          alert("Ingrese un codigo valido");
          $('#cod-email').focus();
        }

}

function validateCodigoPhone(){
              if($('#cod-phone').val().length == 4)
              {

                  $.ajax(
                    {
                      url: "/driver/externo/confir/phone/confirm",
                      type:"POST",
                      data :{ num : $('#cod-phone').val(), token_generado:$('#phone').val()},
                      dataType: "json",
                      beforeSend: function () {
                      $('#load_inv').show(30);
                      }
                    }).done(function(d){
                      $('#load_inv').hide(30);
                      if (d.object=='success'){
                        valphone = 0;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", true);
                        $('#phone').prop("disabled", true);
                      } else {
                        valphone = 1;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", false);
                        $('#phone').prop("disabled", false);
                      }
                    }).fail(function(error){
                      console.log(error);
                      alert("intente nuevamente por favor.");
                    });

              }else{
                alert("Ingrese un codigo valido");
                $('#cod-phone').focus();
              }
}

function guardar()
{
valor = $('#id_office').val();
	 $.ajax(
    {
      url: "/users/update/driver/validate",
      type:"POST",
      data : { id : valor,email:$('#email').val(),phone:$('#phone').val()},
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(300);
    }
    }).done(function(d)
    {
      console.log(d);
      $('#load_inv').hide(300);
      if(d.objet != "error")
      {
        alert(d.menssage);
	location.reload();
      }
  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
  });

}

function enviar(){
  valor = $('#id_office').val();
  $.ajax(
    {
      url: "/driver/externo/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(300);
    }
    }).done(function(d)
    {
      console.log(d);
      $('#load_inv').hide(300);
      if(d.objet != "error")
      {
        $('#email').val(d.data.email);
	$('#phone').val(d.data.phone);
	$('#info').val(d.data.last_name+", "+d.data.first_name);
      }
      else
	{
		alert('el usuario no existe');
	}
  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
  });
}
