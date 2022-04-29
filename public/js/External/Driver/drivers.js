var codigoproceso        = 2;
var estatusproceso       = 1;
var phone = 0;
var email = 0;
$('#dni').prop("disabled", true);
$('#placa').prop("maxlength", 6);
$('#phone-user').prop("maxlength", 9);


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var iduser = 0;
var fila = 0;
var dni = 0;
var phone = 0;
var email = 0;
$("#tipdocid").change(function(){
    $('#dni').val("");
    var op = $("#tipdocid option:selected").text();
    if (op != 'SELECCIONAR') {
      $('#dni').prop("disabled", false);
    }else{
      $('#dni').prop("disabled", true);
    }
});

$(document).on('blur', '#dni', function(event) {
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
    alert("No se registrÃ³, intente nuevamente por favor.");
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
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
}

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un usuario.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 2);
  }

});

function validarProceso(id_office, idproceso){
  var respuesta;
  $.ajax({
    url: "/driver/externo/validarProceso",
    type:"post",
    data:{id_office:id_office, idproceso: idproceso},
    beforeSend: function () {
      $('#load_inv').show(30);
    }
  }).done( function(d) {
    $('#load_inv').hide();
    respuesta = d;
    if (respuesta == 'true'){
      getUser();
    }else if (respuesta == 'false'){
      alert("El usuario no existe!");
    }else{
      alert("El usuario ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operaciÃ³n");   }).always( function() {  });
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
      console.log(d);
      $('#load_inv').hide(300);
      if(d.objet != "error")
      {

          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'">');
          if(d.data.phone != null)
          $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'"><div id="codphonever"><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(1)">Enviar SMS</button></div>');
          else $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value=""><div id="codphonever"><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(1)">Enviar SMS</button></div>');
          if(d.data.email != null)
          $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'"><button type="button" name="button" class="btn btn-success validateEmailv" onclick="validateEmail()">Enviar</button>');
          else $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value=""><button type="button" name="button" class="btn btn-success validateEmailv" onclick="validateEmail()">Enviar</button>');

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
             //alert("Ya se envio un codigo de validacion a su correo");
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



          $('#dni').val(d.data.dni);
          if (d.data.dni == null){
            $("#tipdocid").val("");
            $('#dni').prop("disabled",false);
            $('#name-user').prop("disabled", false);
            $('#ape-user').prop("disabled", false);
          }else{
            $('#tipdocid').val(d.data.id_type_documents);
            $('#dni').prop("disabled", true);
            $('#name-user').prop("disabled", true);
            $('#ape-user').prop("disabled", true);
          }

          $('#yearfile').html('');
          if (d.filemsj == "success"){
            if (d.file.placa != null){
              $('#placa').val(d.file.placa);
            }

            if (d.file.year == null){
              var  fila = '<select class="form-control select2" id="year" name="year">';
              $.each({ v : "SELECCIONAR",v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
                fila += '<option>'+v+'</option>';
              });
              fila += '</select>';
              $('#yearfile').append(fila);
            }else{
              var today1 = new Date();
              var year1 = today1.getFullYear();
              var yearcar1 = d.file.year;
              var diferenyear1 = (year1 - yearcar1);
              if (diferenyear1 >= 6){
                $('#divcarro').show();
              }else{
                $('#divcarro').hide();
              }

              var  fila1 = '<select class="form-control select2" id="year" name="year">';
              $.each({ v : d.file.year ,v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
                fila1 += '<option>'+v+'</option>';
              });
              fila1 += '</select>';
              $('#yearfile').append(fila1);
            }

            $('#year').select2();

	         if (d.file.car_interna != null){
              $("#divcarinterna1").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarinterna1").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }


            if (d.file.car_interna2 != null){
              $("#divcarinterna2").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarinterna2").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }

            if (d.file.car_externa != null){
              $("#divcarexterna1").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarexterna1").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }

            if (d.file.car_externa2 != null){
              $("#divcarexterna2").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarexterna2").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }

            if (d.file.car_externa3 != null){
              $("#divcarexterna3").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarexterna3").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }

            if (d.file.car_externa4 != null){
              $("#divcarexterna4").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
            }else{
              $("#divcarexterna4").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
            }
          }else{
            var  fila = '<select class="form-control select2" id="year" name="year">';
            $.each({ v : "SELECCIONAR",v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019"}, function( k, v ) {
              fila += '<option>'+v+'</option>';
            });
            fila += '</select>';
            $('#yearfile').append(fila);
            $('#placa').val("");
          }

          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        alert("El conductor no se encuentra registrado.");
        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
        $('#placa').val("");
        $('#dni').val("");
        $('#year').val("");
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

function validateEmail() {
  if ($('#email-user').val().length > 0){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($('#email-user').val().trim())) {
        $.ajax(
        {
          url: "/driver/externo/emailval",
          type:"POST",
          data : { value : $('#email-user').val() },
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
          alert("No se registró, intente nuevamente por favor.");
        });

    } else {
        alert('La direccÃ³n de correo no es vÃ¡lida');
        email = 1;
    }
  }else{
    alert('ingresar un correo electronico');
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
        alert("intente nuevamente por favor.");
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
                  valemail = 0;
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", true);
                  $('#email-user').prop("disabled", true);
                  $('#email-btn').prop("disabled", true);
                }
                else {
                  valemail = 1;
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





function validatePhone(vari) {
  if ($('#phone-user').val().length == 9){
    alertify.confirm('vamos a verificar el numero de telefono', '+51 ('+$('#phone-user').val()+') <br> ¿es correcto o quieres modificarlo?', function(){
    $.ajax(
    {
      url: "/driver/externo/phoneval",
      type:"POST",
      data : { value : $('#phone-user').val() },
      dataType: "json",
    }).done(function(d){
          if (d.flag == true){
            alert(d.mensaje);
            phone = 1;
          }else{
            phone = 0;
            validatePhoneExits(vari);
          }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
    }, function(){ $('#phone-user').focus(); }).set('labels', {ok:'Correcto', cancel:'Editar'});
  }else{
    alert("Ingresar numero de telefono.");
  }
}

function validatePhoneExits(vari)
{
  if($('#phone-user').val().length == 9)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));

    $.ajax(
      {
        url: "/driver/externo/confir/phone/new",
        type:"POST",
        data :{ token_generado : contrasenia, phone:$('#phone-user').val(), var: vari},
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
        alert("intente nuevamente por favor.");
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
                        valphone = 0;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", true);
                        $('#phone-user').prop("disabled", true);
                        $('#phone-btn').prop("disabled", true);
                      } else {
                        valphone = 1;
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
      alert("No se registrÃ³, intente nuevamente por favor.");
    });
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

$(document).on('change', '#year', function(event) {
  var today = new Date();
  var year = today.getFullYear();
  var yearcar = $(this).val();

  var diferenyear = (year - yearcar);
  // if (diferenyear >= 6){
  //   $('#divcarro').show();
  // }else{
  //   $('#divcarro').hide();
  // }
});

$("#btn_ajax").click(function() {
    var carinterna1 = document.getElementById("carinterna1");
    var carinterna2 = document.getElementById("carinterna2");
    var carexterna1 = document.getElementById("carexterna1");
    var carexterna2 = document.getElementById("carexterna2");
    var carexterna3 = document.getElementById("carexterna3");
    var carexterna4 = document.getElementById("carexterna4");


    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
      $("#idoffice").focus();
    }else if (iduser == 0){
      alert('ingrese un id valido');
      $("#idoffice").focus();
    }else  if ($('#phone-user').val() == ""){
      alert('Ingrese un telefono');
      $("#phone-user").focus();
    }else if (phone == 1){
      alert('ingrese un telefono valido');
      $("#phone-user").focus();
    }else if (valphone == 1){
      alertify.alert("¡ERROR! INGRESE UN CODIGO DE TELEFONO VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
      $("#cod-phone").focus();
    }else  if ($('#email-user').val() == ""){
      alert('Ingrese un correo');
      $("#email-user").focus();
    }else if (email == 1){
      alert('ingrese un correo valido');
      $("#email-user").focus();
    }else if (valemail == 1){
      alertify.alert("¡ERROR! INGRESE UN CODIGO DE EMAIL VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
      $("#cod-email").focus();
    }else  if ($('#dni').val() == ""){
      alert('ingrese dni');
      $("#dni").focus();
    }else  if (dni == 1){
      alert('el documento de identidad ya existe');
      $("#dni").focus();
    }else if ($('#placa').val() == ""){
      alert('ingrese una placa');
      $("#placa").focus();
    }else if (placa == 1){
      alert('la placa ya existe o es invalida');
      $("#placa").focus();
    }else if ($("#placa").val().length > 6) {
      alert('Ingresar solo letras, nÃºmeros y sin espacios');
      $("#placa").focus();
    }else if ($("#placa").val().length < 6) {
      alert('Ingresar placa valida');
      $("#placa").focus();
    }else  if ($("#year option:selected").text() == "SELECCIONAR"){
      alert('seleccione un aÃ±o');
      $("#year").focus();
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

  $.ajax(
    {
      url: "/users/exeterno/register/docs",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
      },
    }).done(function(d)
    {

      var vcarinterna1 = document.getElementById("carinterna1");
      var vcarinterna2 = document.getElementById("carinterna2");
      var vcarexterna1 = document.getElementById("carexterna1");
      var vcarexterna2 = document.getElementById("carexterna2");
      var vcarexterna3 = document.getElementById("carexterna3");
      var vcarexterna4 = document.getElementById("carexterna4");

      if(d.object == "success")
      {

	      if (vcarinterna1.files.length < 1){
          alertify.notify('Queda pendiente subir foto interna asiento conductor', 'warning', 5, function(){ });
        }

        if (vcarinterna2.files.length < 1){
          alertify.notify('Queda pendiente subir foto interna asiento pasajero', 'warning', 5, function(){ });
        }

        if (vcarexterna1.files.length < 1){
          alertify.notify('Queda pendiente subir subir foto parte delantera del auto', 'warning', 5, function(){ });
        }

        var today1 = new Date();
        var year1 = today1.getFullYear();
        var yearcar1 = $("year").val();

        var diferenyear1 = (year1 - yearcar1);

        if (diferenyear1 >= 6){
          if (vcarexterna2.files.length < 1){
            alertify.notify('Queda pendiente subir subir foto lado derecho del auto', 'warning', 5, function(){ });
          }

          if (vcarexterna3.files.length < 1){
            alertify.notify('Queda pendiente subir subir foto lado izquierdo del auto', 'warning', 5, function(){ });
          }

          if (vcarexterna4.files.length < 1){
            alertify.notify('Queda pendiente subir subir foto parte trasera del auto', 'warning', 5, function(){ });
          }
        }

        if (vcarinterna1.files.length >= 1){
          cc++;
          //1 foto car_interna
          upimg(d.idfile,'carinterna1','8', '2' , codigoproceso , estatusproceso);
        }

        if (vcarinterna2.files.length >= 1){
          cc++;
          //2 foto car_interna
          upimg(d.idfile,'carinterna2','9', '2' , codigoproceso , estatusproceso);
        }

        if (vcarexterna1.files.length >= 1){
          cc++;
          //1ra foto car_externa
          upimg(d.idfile,'carexterna1','10', '2' , codigoproceso , estatusproceso);
        }

        if (vcarexterna2.files.length >= 1){
          cc++;
          //1ra foto car_externa
          upimg(d.idfile,'carexterna2','17', '2' , codigoproceso , estatusproceso);
        }

        if (vcarexterna3.files.length >= 1){
          cc++;
          //1ra foto car_externa
          upimg(d.idfile,'carexterna2','18', '2' , codigoproceso , estatusproceso);
        }

        if (vcarexterna4.files.length >= 1){
          cc++;
          //1ra foto car_externa
          upimg(d.idfile,'carexterna4','19', '2' , codigoproceso , estatusproceso);
        }

      }else{
        $('#load_inv').hide();
        alert(d.menssage);
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
   progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
   if (progress == 100){
     // alertify.notify('se guardo la imagen', 'success', 3, function(){ });

   }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imÃ¡gen, por favor intente de nuevo, si el problema persiste, por favor comunÃ­quese con soporteusuario@winhold.net'+error);
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
      'estatusproceso' : statusproceso};




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
              if(cantidadUpdateImg>6)
              {
                $("#cantidadSubidas").css("background-color", "#FFFF00");
              }
              if(cantidadUpdateImg == cc)
              {
                $("#cantidadSubidas").css("background-color", "#008000");
                  alertify.notify('Excelente, se registro correctamente', 'success', 5, function(){ });
                  $('#load_inv').hide();
                  location.reload();
              }

            }).fail(function(error){
              console.log('No se enlaso la imagen con el ticket '+error);
              alert("No se enlazo la imÃ¡gen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comunÃ­quese con soporteusuario@winhold.net"+error);
              respuesta = false;
            });
      });
    });
    return true;
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


var last_name;
var first_name;
var stateSave= false;
function getDataDni(){
dni =$('#dni_usuario').val()
    $.ajax(
    {
      url: "/customer/externo/reniecPeruValidate",
      type:"POST",
      data : { dni:$('#dni_usuario').val() },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.data.object){
        $('#apellido_dni').html(d.data.last_name);
        $('#nombre_dni').html(d.data.first_name);
        last_name = d.data.last_name;
        first_name = d.data.first_name;
        alert(d.data.message);
      }
    }).fail(function(error){
      console.log(error);
      alert("La pÃ¡gina de dni no esta disponible");
    });

};

 function saveDNI(){

    $.ajax(
    {
      url: "/conductores/documentos/validate/save/dni",
      type:"POST",
      data : { id:iduser,last_name:last_name,first_name:first_name,dni:dni },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show();
    },
    }).done(function(d){
      if (d.object == "success"){
        alert(d.message);
        stateSave = true;
        alertify.closeAll();
        getUser();
      }else{
        alert(d.message);
      }
        $('#load_inv').hide();
    }).fail(function(error){
      alert("Error al guardar");
    });

};
