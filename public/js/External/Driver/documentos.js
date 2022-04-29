var codigoproceso        = 3;
var estatusproceso       = 1;
var email                = 0;
var phone                = 0;
$('#dni').prop("disabled", true);
$('#placa').prop("maxlength", 6);
$('#phone-user').prop("maxlength", 9);
$('.numtipdoc').attr("style",'display:none;');
    let today = new Date(),
    day = today.getDate(),
    month = today.getMonth()+1, //January is 0
    year = today.getFullYear();
    mayoyear = (year - 18);
         if(day<10){
                day='0'+day
            }
        if(month<10){
            month='0'+month
        }
        today = mayoyear+'-'+month+'-'+day;
$("#datebirth").attr({"max" : today});


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var iduser = 0;
var dni = 0;
var licence = 0;

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un usuario.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 3);
  }

});

$("#tipdocid").change(function(){
    $('#dni').val("");
    $('#name-user').prop("disabled", false);
    $('#ape-user').prop("disabled", false);
    $('#name-user').val('');
    $('#ape-user').val('');
    $('#datebirth').val('');
    var op = $("#tipdocid option:selected").text();
    if(op == 'DNI'){
      $('#dni').prop("disabled", false);
      $('.numtipdoc').attr("style",'display:none;');
      tipoid = 1;
    }else if (op != 'DNI' && op != 'SELECCIONAR') {
      $('#dni').prop("disabled", false);
      $('.numtipdoc').attr("style",'display:block;');
      tipoid = 0;
    }else{
      $('#dni').prop("disabled", true);
      $('.numtipdoc').attr("style",'display:none;');
      tipoid = 0;
    }
});

function validarProceso(id_office, idproceso){
  var respuesta;
  $.ajax({
    url: "/driver/externo/validarProceso",
    type:"post",
    data:{id_office:id_office, idproceso: idproceso},
    beforeSend: function () {
    $('#load_inv').show(300);
  }
  }).done( function(d) {
    $('#load_inv').hide(300);
    respuesta = d;
    if (respuesta == 'true'){
      getUser();
    }else if (respuesta == 'false'){
      alert("El usuario no existe!");
    }else{
      alert("El usuario ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  return respuesta;
}

var placa = 0;
var valphone;
var valemail;
function getUser(){
  valor = $('#idoffice').val();
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(300);
    }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      if(d.objet != "error")
      {

          console.log(d);

          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'" >');
          if(d.data.phone != null)
          $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'"><div id="codphonever"><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(1)">Enviar SMS</button></div>');
          else $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value=""><div id="codphonever"><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(1)">Enviar SMS</button></div>');
          if(d.data.email != null)
          $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'"><button type="button" name="button" class="btn btn-success validateEmailv" onclick="validateEmail()">Enviar</button>');
          else $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value=""><button type="button" name="button" class="btn btn-success validateEmailv" onclick="validateEmail()">Enviar</button>');
          $('#yearfile').html('');

          if(d.valphone == 'error'){
             valphone = 1;
             if (d.data.phone != null){
               $('#phonevaluser').prop("style", "display: flex");
               $('#phonevaluser').attr("style",'display:block;');
               $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
               $('#sendvalphone').prop("disabled", false);
             }
          }else if (d.valphone == 0){
            //alert("Ya se envio un codigo de validacion a su telefono");
            $('#phonevaluser').prop("style", "display: flex");
            $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
            $('#phonevaluser').attr("style",'display:block;');
            $('#sendvalphone').prop("disabled", false);
            valphone = 1;
          }else{
            alertify.notify('Ya se valido su telefono', 'success', 5, function(){ });
            $('#phonevaluser').attr("style",'display:none;');
            valphone = 0;
            $('#sendvalphone').prop("disabled", true);
          }

          if(d.valemail == 'error'){
             valemail = 1;
             if (d.data.email != null){
               $('#emailvaluser').prop("style", "display: flex");
               $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
               $('#emailvaluser').attr("style",'display:block;');
              $('.validateEmailv').prop("disabled", false);
               //validateEmailExits();
             }
           }else if (d.valemail == 0){
             alertify.notify('Ya se envio un codigo de validacion a su correo', 'success', 5, function(){ });
             valemail = 1;
             $('#emailvaluser').prop("style", "display: flex");
             $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
             $('#emailvaluser').attr("style",'display:block;');
             $('.validateEmailv').prop("disabled", false);
           }else{
             alertify.notify('Ya se valido su correo', 'success', 5, function(){ });
             $('#emailvaluser').attr("style",'display:none;');
             valemail = 0;
             $('.validateEmailv').prop("disabled", true);
           }

          if (d.data.dni == null){
            $("#tipdocid").val("");
            $('#dni').prop("disabled",false);
            $('#name-user').prop("disabled", false);
            $('#ape-user').prop("disabled", false);
            dni = 1;
          }else{
            dni = 0;
            $('#tipdocid').val(d.data.id_type_documents);
            $('#dni').prop("disabled", true);
            $('#name-user').prop("disabled", true);
            $('#ape-user').prop("disabled", true);
            $('#dni').val(d.data.dni);
            if (d.data.id_type_documents != 1){
              $('.numtipdoc').attr("style",'display:block;');
              $('#datebirth').val(d.data.date_birth);
              tipoid = 0;
            }else{
              tipoid = 1;
            }
          }


          if (d.filemsj == "error"){
            var  fila = '<select class="form-control select2" id="year" name="year">';
            $.each({ v : "SELECCIONAR",v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
              fila += '<option>'+v+'</option>';
            });
            fila += '</select>';
            $('#yearfile').append(fila);
          }else{
              if (d.file.placa != null){
                $('#placa').val(d.file.placa);
                placa = 0;
              }else{
                placa = 1;
                $('#placa').val("");
              }

              if (d.file.year == null){
                var  fila = '<select class="form-control select2" id="year" name="year">';
                $.each({ v : "SELECCIONAR",v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
                  fila += '<option>'+v+'</option>';
                });
                fila += '</select>';
                $('#yearfile').append(fila);
              }else{
                var  fila1 = '<select class="form-control select2" id="year" name="year">';
                $.each({ v : d.file.year ,v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
                  fila1 += '<option>'+v+'</option>';
                });
                fila1 += '</select>';
                $('#yearfile').append(fila1);
              }

              $('#year').select2();

              if (d.file.licencia == null){
                $('#licencia').val("");
              }else{
                $('#licencia').val(d.file.licencia);
              }


              $("#div_dni_front").html("");
              $("#div_dni_back").html("");
              $("#div_lic-front").html("");
              $("#div_lic-back").html("");
              $("#div_tarj-vehi-front").html("");
              $("#div_tarj-vehi-back").html("");
              $("#div_soat-front").html("");
              $("#div_recibo").html("");

              if (d.file.dni_frontal != null){
                $("#div_dni_front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_dni_front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.dni_back != null){
                $("#div_dni_back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_dni_back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.lic_frontal != null){
                $("#div_lic-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_lic-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.lic_back != null){
                $("#div_lic-back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_lic-back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.tar_veh_frontal != null){
                $("#div_tarj-vehi-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_tarj-vehi-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.tar_veh_back != null){
                $("#div_tarj-vehi-back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_tarj-vehi-back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.soat_frontal != null){
                $("#div_soat-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_soat-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }


              if (d.file.recibo_luz != null){
                $("#div_recibo").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("div_#recibo").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

	     if (d.file.atu != null){
                $("#div_atu").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_atu").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }
          }

          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
        $('#placa').val("");
        $('#licencia').val("");
        $('#year').val("");
        if (d.vali == 2){
          alert("El conductor no se encuentra registrado.");
        } else if (d.vali == 3){
          alert("El conductor no se ha registrado en el primer formulario.");
        }
      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");
  });
}

$(document).on('keydown', '#phone-user', function(event) {
    if (event.keyCode == 8){
      $('#sendvalphone').prop("disabled", false);
      valphone = 1;
    }
});

$(document).on('keydown', '#email-user', function(event) {
    if (event.keyCode == 8){
      $('.validateEmailv').prop("disabled", false);
      valemail = 1;
    }
});

$(document).on('change', '#email-user', function(event) {
  if ($(this).val().length > 0){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($(this).val().trim())) {
        $.ajax(
        {
          url: "/driver/externo/emailval",
          type:"POST",
          data : { value : $(this).val() },
          dataType: "json",
        }).done(function(d){
              if (d.flag == true){
                alert(d.mensaje);
                email = 1;
              }else{
                email = 0;
                $('#emailvaluser').prop("style", "display: flex");
                $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
                validateEmailExits();
              }
        }).fail(function(error){
          console.log(error);
          alert("No se registró, intente nuevamente por favor.");
        });

    } else {
        alert('La direccón de correo no es válida');
        email = 1;
    }
  }
});

function validateEmail() {
  if ($('#email-user').val().length > 0){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($('#email-user').val().trim())) {
        $.ajax(
        {
          url: "/driver/externo/emailval",
          type:"POST",
          data : { value : $('#email-user').val().toUpperCase() },
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
          alert("No se registr�, intente nuevamente por favor.");
        });

    } else {
        alert('La direcci�n de correo no es v�lida');
        email = 1;
    }
  }else{
    alert('Ingresar un correo electronico');
  }
}

var codigoGenePhone;
var contrasenia ="1";
var codigoGene;

function validateEmailExits()
{
  if($('#email-user').val().length > 0)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
    $.ajax(
      {
        url: "/driver/externo/confir/email/new",
        type:"POST",
        data :{ token_generado : contrasenia, email:$('#email-user').val()},
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d){
        $('#load_inv').hide(30);
        if (d.object=='success'){
          alert(d.menssage);
          if (d.data == 0){
            valemail = 1;
            $('#emailvaluser').attr("style",'display:block;');
	          $('#emailvaluser').prop("style", "display: flex");
            $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
          }else if (d.data == 2){
            valemail = 1;
            $('#emailvaluser').attr("style",'display:block;');
	          $('#emailvaluser').prop("style", "display: flex");
            $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
          }else{
            valemail = 0;
            $('#emailvaluser').attr("style",'display:none;');
          }
        } else {
          alert(d.menssage);
          valemail = 1;
          $('#emailvaluser').attr("style",'display:block;');
        }
      }).fail(function(error){
        console.log(error);
        alert("No se registró, intente nuevamente por favor.");
      });


  }else {
    alert('EL CORREO YA EXISTE O ES UN CORREO INVALIDO.');
  }
}

function validateCodigoEmail(){
        if($('#cod-email').val().length == 4)
        {
          $.ajax(
              {
                url: "/driver/externo/confir/email/confirm",
                type:"POST",
                data :{ num : $('#cod-email').val(), token_generado: $('#email-user').val()},
                dataType: "json",
                beforeSend: function () {
                $('#load_inv').show(30);
                }
              }).done(function(d){
                $('#load_inv').hide(30);
                if (d.object=='success'){
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", true);
                  $('#email-user').prop("disabled", true);
                  $('#email-btn').prop("disabled", true);
                } else {
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", false);
                  $('#email-user').prop("disabled", false);
                  $('#email-btn').prop("disabled", false);
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


$(document).on('change', '#phone-user', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/phoneval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          phone = 1;
        }else{
          phone = 0;
          $('#phonevaluser').prop("style", "display: flex");
          $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
          validatePhoneExits();
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});

function validatePhoneExits()
{
  if($('#phone-user').val().length == 9)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));

    $.ajax(
      {
        url: "/driver/externo/confir/phone/new",
        type:"POST",
        data :{ token_generado : contrasenia, phone:$('#phone-user').val()},
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d){
        $('#load_inv').hide(30);
        if (d.object=='success'){
          alert(d.menssage);
          if (d.data == 0){
            valphone = 1;
            $('#phonevaluser').attr("style",'display:block;');
            $('#phonevaluser').prop("style", "display: flex");
            $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
            sendcodphoneval();
            $('.sendcodphone').prop("disabled", false);
          }else{
            valphone = 0;
            $('#phonevaluser').attr("style",'display:none;');
            $('.sendcodphone').prop("disabled", true);
          }
        } else {
          alert(d.menssage);
          valphone = 1;
          $('#phonevaluser').attr("style",'display:block;');
	        $('#phonevaluser').prop("style", "display: flex");
          $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
        }
      }).fail(function(error){
        console.log(error);
        alert("No se registró, intente nuevamente por favor.");
      });

  }else {
    alert('EL NUMERO DE TELEFONO YA EXISTE O ES UN NUMERO INVALIDO.');
  }
}

function sendcodphoneval(){
  const getRemainingTime = deadline => {
    let now = new Date(),
        remainTime = (new Date(deadline) - now + 1000) / 1000,
        remainSeconds = ('0' + Math.floor(remainTime % 60)).slice(-2),
        remainMinutes = ('0' + Math.floor(remainTime / 60 % 60)).slice(-2),
        remainHours = ('0' + Math.floor(remainTime / 3600 % 24)).slice(-2),
        remainDays = Math.floor(remainTime / (3600 * 24));

    return {
      remainSeconds,
      remainMinutes,
      remainHours,
      remainDays,
      remainTime
    }
  };

  const countdown = (deadline,elem,finalMessage) => {
    const el = document.getElementById(elem);

    const timerUpdate = setInterval( () => {
      let t = getRemainingTime(deadline);
      el.innerHTML = `${t.remainMinutes}m:${t.remainSeconds}s`;
      $('.sendcodphone').prop("disabled", true);
      //$('.sendcallphone').prop("disabled", true);
      if(t.remainTime <= 1) {
        clearInterval(timerUpdate);
        el.innerHTML = '';
        $('.sendcodphone').prop("disabled", false);
        $('#codphonever').html('<button type="button" name="button" class="btn btn-success sendcodphone" onclick="sendcodphone(1)" id="sendvalphone" onclick="validatePhone(1)">Reenviar SMS</button><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(2)">llamame</button>');
        $('#codphonever').prop("style", "display: flex");
      }

    }, 1000)
  };

  var meses = new Array ("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
  var f=new Date();
  var horas= f.getHours();
  var minutos = f.getMinutes()+1;
  var segundos = f.getSeconds();

  countdown(''+meses[f.getMonth()]+' '+f.getDate()+' '+f.getFullYear()+' '+horas+':'+minutos+':'+segundos+' GMT-0500', 'clock', '¡Ya empezó!');
}

function validateCodigoPhone(){
              if($('#cod-phone').val().length == 4)
              {

                  $.ajax(
                    {
                      url: "/driver/externo/confir/phone/confirm",
                      type:"POST",
                      data :{ num : $('#cod-phone').val(), token_generado:$('#phone-user').val()},
                      dataType: "json",
                      beforeSend: function () {
                      $('#load_inv').show(30);
                      }
                    }).done(function(d){
                      $('#load_inv').hide(30);
                      if (d.object=='success'){
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", true);
                        $('#phone-user').prop("disabled", true);
                        $('#phone-btn').prop("disabled", true);
                      } else {
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", false);
                        $('#phone-user').prop("disabled", false);
                        $('#phone-btn').prop("disabled", false);
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

$("#placa").keyup(function(){
  var val = $("#placa").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/placavalexi",
      type:"POST",
      data : { value : val },
      dataType: "json",
    }).done(function(d){
          console.log(d);
          if (d.flag == true){
            alert(d.mensaje);
            placa = 1;
          }else{
            placa = 0;
            //validateplaca(val);
          }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});

function validateplaca(val) {
    $.ajax(
    {
      url: "/driver/externo/placaval",
      type:"POST",
      data : { placa : val },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.object == "success"){
        alert(d.menssage);
        placa = 0;
      }else{
        alert(d.menssage);
        placa = 1;
      }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

$(document).on('change', '#dni', function(event) {
  valnumid = $(this).val();
  tipdocids = $("#tipdocid option:selected").val();
  $.ajax(
  {
    url: "/driver/externo/dnival",
    type:"POST",
    data : { value : valnumid, tipdoc : tipdocids },
    dataType: "json",
  }).done(function(d){
    if (d.flag == true){
      dni = 1;
      alert(d.mensaje);
      $('#name-user').val("");
      $('#ape-user').val("");
    }else{
      dni = 0;
      getValDNI(valnumid);
    }

  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
});

function getValDNI(d){
  tipdocids = $("#tipdocid option:selected").val();
  if (tipdocids == 1){
    $.ajax(
      {
        url: "/customer/externo/reniecPeruValidate",
        type:"POST",
        data : {  dni : d },//
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d)
      {
        $('#load_inv').hide();
        alert(d.data.message);
        $('#name-user').val(d.data.first_name);
        $('#ape-user').val(d.data.last_name);
        if (d.data.object == true){
          $('#name-user').prop("disabled", true);
          $('#ape-user').prop("disabled", true);
          $('#dni').prop("disabled", true);
        }else{
          $('#name-user').prop("disabled", false);
          $('#ape-user').prop("disabled", false);
          $('#dni').prop("disabled", false);
        }
        validatelicencia();
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
}

function validatelicencia(){
  val = $('#dni').val();
  tipdocidv = $("#tipdocid option:selected").val();

  $.ajax(
  {
    url: "/driver/externo/validatelice",
    type:"POST",
    data : { licencia : val, tipodoc : tipdocidv},
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
    $('#load_inv').hide();
    if (d.object == "success"){
      alert(d.menssage);
      if (d.data.nrolicencia != null){
        $("#licencia").val(d.data.nrolicencia);
      }
      licence = 0;
    }else{
      alert(d.menssage);
      licence = 1;
    }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}





var first_name;
var last_name;
var dni;
function getDataDni(){
dni =$('#dni_usuario').val()
    $.ajax(
    {
      url: "/customer/externo/reniecPeruValidate",
      type:"POST",
      data : { dni:$('#dni_usuario').val() },
      dataType: "json",
    }).done(function(d){
      if (d.data.object){
        $('#apellido_dni').html(d.data.last_name);
        $('#nombre_dni').html(d.data.first_name);
        last_name = d.data.last_name;
        first_name = d.data.first_name;
        alert(d.data.message);
      }else{
      }
    }).fail(function(error){
      console.log(error);
      alert("La página de dni no esta disponible");
    });

};
var stateSave = false;
 function saveDNI(){

    $.ajax(
    {
      url: "/conductores/documentos/validate/save/dni",
      type:"POST",
      data : { id:iduser,last_name:last_name,first_name:first_name,dni:dni },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        alert(d.message);
        stateSave = true;
        alertify.closeAll();
        getUser();
      }else{
        alert(d.message);
      }
    }).fail(function(error){
      alert("Error al guardar");
    });

};

$(document).on('change', '#licence', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/licencevalexi",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          licence = 1;
        }else{
          licence = 0;
          validatelicencia();
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});



$("#btn_ajax").click(function() {
    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
      $("#idoffice").focus();
    }else if (iduser == 0) {
      alert('ingrese un id valido');
      $("#idoffice").focus();
    }else  if ($("#tipdocid option:selected").text() == "SELECCIONAR"){
      alert('seleccione tipo de documento');
      $("#tipdocid").focus();
    }else  if ($('#dni').val() == ""){
      alert('ingrese una numero de documento');
      $("#dni").focus();
    }else if (dni == 1) {
      alert('el DNI ya existe');
      $("#dni").focus();
    }else  if ($('#phone-user').val() == ""){
      alert('Ingrese un telefono');
      $("#phone-user").focus();
    }else if (phone == 1){
      alertify.alert("EL TELEFONO YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
      $("#phone-user").focus();
    }else if (valphone == 1){
      alertify.alert("¡ERROR! INGRESE UN CODIGO DE TELEFONO VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
      $("#cod-phone").focus();
    }else  if ($('#email-user').val() == ""){
      alert('Ingrese un correo');
      $("#email-user").focus();
    }else if (email == 1){
      alertify.alert("EL CORREO YA EXISTE O ES UN CORREO INVALIDO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
      $("#email").focus();
    }else if (valemail == 1){
      alertify.alert("¡ERROR! INGRESE UN CODIGO DE EMAIL VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
      $("#cod-email").focus();
    } else  if ($('#placa').val() == ""){
      alert('ingrese una placa');
      $("#placa").focus();
    }else if (placa == 1) {
      alert('la placa ya existe o es invalida');
      $("#placa").focus();
    }else if ($("#placa").val().length > 6) {
      alert('Ingresar solo letras, números y sin espacios');
      $("#placa").focus();
    }else if ($("#placa").val().length < 6) {
      alert('Ingresar placa valida');
      $("#placa").focus();
    }else  if ($("#year option:selected").text() == "SELECCIONAR"){
      alert('seleccione un año');
      $("#year").focus();
    }else  if (tipoid != 1 && $("#datebirth").val() == ""){
      alert('ingrese una fecha de nacimiento');
      $("#datebirth").focus();
    }else  if (tipoid != 1 && $("#datebirth").val() > today){
      alert("tiene que ser mayor de edad");
      $("#datebirth").focus();
    }else if ($('#licencia').val() == ""){
      alert('ingrese licencia');
      $("#licencia").focus();
    }else if (licence == 1){
      alert('el numero de documento no tiene licencia');
      $("#licencia").focus();
    }else{
      register();
    }
});

function register(){
  $('#dni').prop("disabled",false);
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);
  $('#email-user').prop("disabled", false);
  $('#phone-user').prop("disabled", false);
  var dnifront = document.getElementById("dni-front");
  var dniback = document.getElementById("dni-back");
  var licfront = document.getElementById("lic-front");
  var licback  = document.getElementById("lic-back");
  var tarjvehifront = document.getElementById("tarj-vehi-front");
  var tarjvehiback = document.getElementById("tarj-vehi-back");
  var soatfront = document.getElementById("soat-front");
  var reciboluz = document.getElementById("recibo");
  var atu = document.getElementById("atu");

  if (atu.files.length < 1){
    alert('Queda pendiente subir documento atu');
  }


  if (licfront.files.length < 1){
    alert('Queda pendiente subir licencia frontal');
  }

  if (licback.files.length < 1){
    alert('Queda pendiente subir licencia posterior');
  }

  if (tarjvehifront.files.length < 1){
    alert('Queda pendiente subir tarjeta vehicular frontal');
  }

  if (tarjvehiback.files.length < 1){
    alert('Queda pendiente subir tarjeta vehicular posterior');
  }

  if ($('#tarj-vehi-fec-emi').val() == ""){
    alert('Queda pendiente fecha de emision');
  }

  if (soatfront.files.length < 1){
    alert('Queda pendiente subir soat frontal');
  }


  if (dnifront.files.length < 1){
    alert('Queda pendiente subir DNI frontal');
  }

  if (dniback.files.length < 1){
    alert('Queda pendiente subir DNI Posterior');
  }

  $.ajax(
    {
      url: "/users/exeterno/register",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
            },
    }).done(function(d)
    {

      var dnifront = document.getElementById("dni-front");
      var dniback = document.getElementById("dni-back");
      var licfront = document.getElementById("lic-front");
      var licback  = document.getElementById("lic-back");
      var tarjvehifront = document.getElementById("tarj-vehi-front");
      var tarjvehiback = document.getElementById("tarj-vehi-back");
      var soatfront = document.getElementById("soat-front");
      var reciboluz = document.getElementById("recibo");
      var revision_ = document.getElementById("revision_tecnica");
      var atus = document.getElementById("atu");

      //atu
        if (atus.files.length >= 1){
          cc++;
          upimg(d.idfile,'atu','20', '3' , codigoproceso , estatusproceso);

        }

      //licencia frontal
        if (licfront.files.length >= 1){
          cc++;
          upimg(d.idfile,'lic-front','1', '3' , codigoproceso , estatusproceso);

        }
      //licencia posterior
        if(licback.files.length >= 1){
          cc++;
      upimg(d.idfile,'lic-back','2', '3' , codigoproceso , estatusproceso);
    }
      //tarjeta vehicular frontal
      if(tarjvehifront.files.length >= 1){
        cc++;
      upimg(d.idfile,'tarj-vehi-front','3', '3' , codigoproceso , estatusproceso);
    }
      //tarjeta vehicular posterior
      if(tarjvehiback.files.length >= 1){
        cc++;
      upimg(d.idfile,'tarj-vehi-back','4', '3' , codigoproceso , estatusproceso);
    }
      //soat Frontal
      if(soatfront.files.length >= 1){
        cc++;
      upimg(d.idfile,'soat-front','5', '3' , codigoproceso , estatusproceso);
    }
      //soat posterior

      if (revision_.files.length >= 1){
        //revision tecnica
        cc++;
        upimg(d.idfile,'revision_tecnica','7', '3' , codigoproceso , estatusproceso);
      }
      //dni frontal
      if (dnifront.files.length >= 1){
        cc++;
      upimg(d.idfile,'dni-front','12', '3' , codigoproceso , estatusproceso);
    }
    if (dniback.files.length >= 1){
      cc++;
      //dni posterior
      upimg(d.idfile,'dni-back','13', '3' , codigoproceso , estatusproceso);
    }
      //recibo
      if (reciboluz.files.length >= 1){
        cc++;
      upimg(d.idfile,'recibo','15', '3' , codigoproceso , estatusproceso);
      }





    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

function validateFileType(id){
    var fileName = document.getElementById(id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
    }else{
      alert("Solo se aceptan imagenes");
      $('#'+id).val("");
    }
}
var cantidadUpdateImg = 0;
var cc = 0;
function upimg(idfiledriver,id,tipo,proceso,codigopro,statusproceso){
  var array = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);

  fichero = document.getElementById(id);
  var metadata = {
    contentType: 'image/jpeg'
  };
  storageRef = firebase.storage().ref();
  var imagenASubir = fichero.files[0];
  var uploadTask = storageRef.child('imgUsersDriver/Pruebas/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;

  if (progress == 100){
    //alertify.notify('se guardo la imagen', 'success', 3, function(){ });

  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
      'id_file': idfiledriver,
      'voucherURL': downloadURL,
      'tipo' : tipo,
      'voucherName': imagenASubir.name,
      'proceso' : proceso,
      'codigoproceso' : codigopro,
      'estatusproceso' : statusproceso };

      $.ajax({
        type: "POST",
        url: "/users/exeterno/fileSave",
        data : data,
        dataType: "json",
      }).done(function(d){
        respuesta = true;
        alertify.notify('se guardo la imagen', 'success', 3, function(){ });


        cantidadUpdateImg++;
        $('#cantidadSubidas').html("");
        $('#cantidadSubidas').html("Se subieron : "+cantidadUpdateImg+ "");
        if(cantidadUpdateImg>cc)
        {
          $("#cantidadSubidas").css("background-color", "#FFFF00");
        }
        if(cantidadUpdateImg == cc)
        {
          $("#cantidadSubidas").css("background-color", "#008000");
            alertify.notify('Excelente, se registro correctamente', 'success', 3, function(){ });
            $('#load_inv').hide();
            location.reload();
        }

      }).fail(function(error){
        console.log('No se enlaso la imagen con el ticket '+error);
        alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
        respuesta = false;
      });
      });
    });

    return true;
}

$(document).on('change','.btn-file :file',function(){
  validarFile(this);

  var input                  = $(this);
  var file                   = event.target.files[0];
  var output_format          = file.name.split(".").pop();
  var extensiones_permitidas = ["png", "bmp", "jpg", "jpeg"];

  if (this.files && this.files[0]) {
    $('.help-block-'+this.id).addClass('text-success');
    $('.help-block-'+this.id).html('<i class="fas fa-check"></i>');
  }

  if(extensiones_permitidas.indexOf(output_format) != -1){
    readFile(event, this.name+'_img',this.name);
  }

  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label    = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);

});

function validarFile(all){
    //EXTENSIONES Y TAMANO PERMITIDO.
    var extensiones_permitidas = [".png", ".bmp", ".jpg", ".jpeg"];
    var tamano = 5; // EXPRESADO EN MB.
    var rutayarchivo = all.value;
    var ultimo_punto = all.value.lastIndexOf(".");
    var extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length);

    if(extensiones_permitidas.indexOf(extension) == -1)
    {
        alertify.alert('Solo se aceptan imagen').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
        $("#"+all.name+"_img").attr('src', '/imagenes/'+all.name+'_img.png' );

        document.getElementById(all.id).value = "";
        return; // Si la extension es no válida ya no chequeo lo de abajo.
    }
    console.log((all.files[0].size / 1048576));
    // if((all.files[0].size / 1048576) > tamano)
    // {
    //     alert("El archivo no puede superar los "+tamano+"MB");
    //     document.getElementById(all.id).value = "";
    //     return;
    // }
}

var output_format = null;
var file_name     = null;
function readFile(evt, input, fileupd) {

  //$("#btn_ajax").attr("disabled", true);

  var file      = evt.target.files[0];
  var reader    = new FileReader();

	reader.onload = function(event) {
    var i = document.getElementById(input);
        i.src = event.target.result;
        i.onload = function(){
        }
  };
	output_format = file.name.split(".").pop();
	file_name     = file.name;

  // console.log("Filesize:" + (parseInt(file.size) / 1024) + " Kb");
  // console.log("Filename:" + file.name);
  // console.log("Fileformat:" + output_format);
  // console.log("Type:" + file.type);



  reader.readAsDataURL(file);
  setTimeout( function() {

    var source_image = document.getElementById(input);
    if (source_image.src == "") {
      return false;
    }
    var quality;
    console.log("process start compress ...");
    var qualityMB = (parseInt(file.size) / 1048576);
    if (qualityMB < 5){
      quality = 10;
    }else if (qualityMB > 5 && qualityMB < 10){
      quality = 30;
    }else if (qualityMB > 10 && qualityMB < 20){
      quality = 40;
    }else {
      quality = 60;
    }
    source_image.src = jic.compress(source_image,quality,output_format).src;
    //$("#btn_ajax").attr("disabled", false);

  }, 3000);

	return false;
}

$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
