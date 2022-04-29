var codigoproceso        = 1;
var estatusproceso       = 1;
var dni = 0;
var phone = 0;
var email = 0;
$('#dni').prop("disabled", true);
$('#placa').prop("maxlength", 6);


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$( "#btn_search" ).click(function() {

  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un usuario.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 1);
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
var valphone ;
var valemail ;
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
          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user"  value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'" >');
          if(d.data.phone != null)
          $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'">');
          else $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="">');
          if(d.data.email != null)
          $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'">');
          else $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="">');
          $('#dni').val(d.data.dni);
          $('#yearfile').html('');


          if (d.data.dni == null){
            $("#tipdocid").val("");
            $('#name-user').prop("disabled", false);
            $('#ape-user').prop("disabled", false);
          }else{
            $('#tipdocid').val(d.data.id_type_documents);
            $('#name-user').prop("disabled", true);
            $('#ape-user').prop("disabled", true);
          }

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
              var  fila1 = '<select class="form-control select2" id="year" name="year">';
              $.each({ v : d.file.year ,v1 : "2000", v2 : "2001",v3 : "2002",v4 : "2003",v5 : "2004",v6 : "2005",v7 : "2006",v8 : "2007",v9 : "2008",  v10 : "2009", v11 : "2010", v12 : "2011" , v13 : "2012", v14 : "2013", v15 : "2014", v16 : "2015", v17 : "2016", v18 : "2017", v19 : "2018" , v20 : "2019", v21 : "2020"}, function( k, v ) {
                fila1 += '<option>'+v+'</option>';
              });
              fila1 += '</select>';
              $('#yearfile').append(fila1);
            }

            $('#year').select2();
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

$("#tipdocid").change(function(){
    $('#dni').val("");
    var op = $("#tipdocid option:selected").text();
    if (op != 'SELECCIONAR') {
      $('#dni').prop("disabled", false);
      $('#name-user').prop("disabled", false);
      $('#ape-user').prop("disabled", false);
      $('#name-user').val("");
      $('#ape-user').val("");
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
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
}



$(document).on('change', '#email-user', function(event) {
  if ($(this).val().length > 0){
   $.ajax(
   {
     url: "/driver/externo/emailval",
     type:"POST",
     data : { value : $(this).val() },
     dataType: "json",
     beforeSend: function () {
     $('#load_inv').show(30);
     }
   }).done(function(d){
         $('#load_inv').hide();
         if (d.flag == true){
           alert(d.mensaje);
           valemail = 1;
         }else{
           valemail = 0;
         }
   }).fail(function(error){
     console.log(error);
     alert("No se registrÃ³, intente nuevamente por favor.");
   });
   }
 });


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
     if (d.object=='success'){
          alert(d.menssage);
          $('#load_inv').hide(30);
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
     $('#emailvaluser').prop("style", "display: flex");
     $('#emailvaluser').html('<input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()" id="email-btn">Validar</button>');
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
        if($('#cod-email').val().length == 6)
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

$(document).on('change', '#phone-user', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/phoneval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
        $('#load_inv').hide();
        if (d.flag == true){
          alert(d.mensaje);
          phone = 1;
        }else{
          phone = 0;
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
           }else if (d.data == 2){
             valphone = 1;
             $('#phonevaluser').attr("style",'display:block;');
             $('#phonevaluser').prop("style", "display: flex");
             $('#phonevaluser').html('<input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()" id="phone-btn">Validar</button>');
           }else{
             valphone = 0;
             $('#phonevaluser').attr("style",'display:none;');
           }
         } else {
           alert(d.menssage);
           valphone = 1;
         }
       }).fail(function(error){
         console.log(error);
         alert("intente nuevamente por favor.");
       });

   }else {
     alert('EL NUMERO DE TELEFONO YA EXISTE O ES UN NUMERO INVALIDO.');
   }
 }

function validateCodigoPhone(){
              if($('#cod-phone').val().length == 6)
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


$("#placa").keyup(function(){
  var val = $("#placa").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/placaval",
      type:"POST",
      data : { iduser : iduser, placa : val },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        placa = 1;
        alert(d.menssage);
      }else{
        alert(d.menssage);
        placa = 0;
      }
      console.log(d);
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }else{

  }
});

$(".btn-rev").click(function() {
  var title;
  var check;
  status = $(this).attr("data-val");

  if (status == 2){
    title = '¿Aprobar todo?';
    check = 0;

  }else{
    title = '¿Desaprobar todo?';
    check = 2;
  }


  if ($('#idoffice').val() == ""){
    alert('ingrese un id');
  }else if (iduser == 0){
    alert('ingrese un id valido');
  }else  if ($('#phone-user').val() == ""){
    alert('Ingrese un telefono');
  }else if (phone == 1){
    alert('ingrese un telefono valido');
  }else  if ($('#email-user').val() == ""){
    alert('Ingrese un correo');
  }else if (email == 1){
    alert('ingrese un telefono valido');
  }else  if ($('#dni').val() == ""){
    alert('ingrese dni');
  }else  if (dni == 1){
    alert('el documento de identidad ya existe');
  }else if ($('#placa').val() == ""){
    alert('ingrese una placa');
  }else if (placa == 1){
    alert('la placa ya existe o es invalida');
  }else  if ($("#year option:selected").text() == "SELECCIONAR"){
    alert('seleccione un año');
  }else {
  alertify.confirm('Alerta', title , function(){
     $("#formtechnicalreview input[name='light_low']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_high']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_brake']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_emergency']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_recoil']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_intermittent']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_fog']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='light_plate']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='engine_start']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='alternator']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='plugs']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='cable_plugs']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='coils']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='injectors']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='drums']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='front_pads']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='rear_pads']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='front_discs']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='rear_discs']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='rear_drums']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='rear_shoes']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='emergency_break']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='brake_fluid']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='tire_status']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='nut_revision']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='tire_pressure']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='spare_tire']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='hoops']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='front_bumper']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='rear_bumper']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='left_front_door']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='right_front_door']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='left_rear_door']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='right_rear_door']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='left_fender']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='right_fender']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='soft_top']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='left_front_glass']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='right_front_glass']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='left_rear_glass']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='right_rear_glass']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='front_windshield']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='rear_windshield']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='trunk']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='ceiling']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='oil_leak']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='refrigerant_leak']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='fuel_leak']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='oil_filter']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='air_filter']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='fuel_filter']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='cabin_filter']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='steering_pump']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='front_shock_absorbers']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='rear_shock_absorbers']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='pallets']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='pads']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='terminal_blocks']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='trapezios']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='springs']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='box_oil']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='case_filter']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='transfer_case']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='cardan']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='differential']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='clutch_disc']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='collarin']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='crossbows']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='radiator']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='ventilators']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='fan_belt']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='water_hoses']:nth("+check+")").prop('checked',true);
     //$("#formtechnicalreview input[name='board']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='dash_light']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='saloon_light']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='pilot_seat']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='passenger_seat']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='rear_seats']:nth("+check+")").prop('checked',true);
     // $("#formtechnicalreview input[name='horn']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='gata']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='wheel_wrench']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='tool_kit']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='safety_triangle']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview input[name='extinguisher']:nth("+check+")").prop('checked',true);
     if (status == 1){
         alertify.prompt( 'Observaciones', 'Ingresar razon'
               , function(evt, value) {  $("#observacion").val(value);
                registercheck(status);}
               , function() { alert("Ingresar una observacion"); });
     }else{
          //$("#observacion").val("");
          alertify.prompt( 'Observaciones', 'Ingresa alguna observacion'
                , function(evt, value) {  $("#observacion").val(value);
                 registercheck(status);}
                , function() { alert("Ingresar una observacion"); });
          // registercheck(status);
     }

   }, function(){
      alertify.error('Cancelar');
   });
 }
});

$(".btn_ajax").click(function() {
  var title;
  status = $(this).attr("data-val");
  if (status == 2){
    title = '¿Aprobar todo?';
  }else{
    title = '¿Desaprobar todo?';
  }
  if ($('#idoffice').val() == ""){
    alert('ingrese un id');
  }else if (iduser == 0){
    alert('ingrese un id valido');
  }else  if ($('#phone-user').val() == ""){
    alert('Ingrese un telefono');
  }else if (phone == 1){
    alert('ingrese un telefono valido');
  }else if (valphone != 0){
    alertify.alert("¡ERROR! INGRESE UN CODIGO DE TELEFONO VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#cod-phone").focus();
  }else  if ($('#email-user').val() == ""){
    alert('Ingrese un correo');
  }else if (email == 1){
    alert('ingrese un telefono valido');
  }else if (valemail != 0){
    alertify.alert("¡ERROR! INGRESE UN CODIGO DE EMAIL VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#cod-email").focus();
  }else  if ($('#dni').val() == ""){
    alert('ingrese dni');
  }else  if (dni == 1){
    alert('el documento de identidad ya existe');
  }else if ($('#placa').val() == ""){
    alert('ingrese una placa');
  }else if (placa == 1){
    alert('la placa ya existe o es invalida');
  }else  if ($("#year option:selected").text() == "SELECCIONAR"){
    alert('seleccione un año');
  }else if(!$("#formtechnicalreview input[name='light_low']").is(':checked')){
   	alert('Favor de seleccionar una opción de luz baja');
  }else if(!$("#formtechnicalreview input[name='light_high']").is(':checked')){
    alert('Favor de seleccionar una opción de luz alta');
  }else if(!$("#formtechnicalreview input[name='light_brake']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de freno');
  }else if(!$("#formtechnicalreview input[name='light_emergency']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de emergencia');
  }else if(!$("#formtechnicalreview input[name='light_recoil']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de retroceso');
  }else if(!$("#formtechnicalreview input[name='light_intermittent']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de intermitente');
  }else if(!$("#formtechnicalreview input[name='light_fog']").is(':checked')){
    alert('Favor de seleccionar una opción de luz Antiniebla');
  }else if(!$("#formtechnicalreview input[name='light_plate']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de placa');
  }else if(!$("#formtechnicalreview input[name='engine_start']").is(':checked')){
    alert('Favor de seleccionar una opción de arrancador');
  }else if(!$("#formtechnicalreview input[name='alternator']").is(':checked')){
    alert('Favor de seleccionar una opción de alternador');
  }else if(!$("#formtechnicalreview input[name='plugs']").is(':checked')){
    alert('Favor de seleccionar una opción de bujías');
  }else if(!$("#formtechnicalreview input[name='cable_plugs']").is(':checked')){
    alert('Favor de seleccionar una opción de cable de bujías');
  }else if(!$("#formtechnicalreview input[name='coils']").is(':checked')){
    alert('Favor de seleccionar una opción de bobinas');
  }else if(!$("#formtechnicalreview input[name='injectors']").is(':checked')){
    alert('Favor de seleccionar una opción de inyectores');
  }else if(!$("#formtechnicalreview input[name='drums']").is(':checked')){
    alert('Favor de seleccionar una opción de bateria');
  }else if(!$("#formtechnicalreview input[name='front_pads']").is(':checked')){
    alert('Favor de seleccionar una opción de pastillas delanteras');
  }else if(!$("#formtechnicalreview input[name='rear_pads']").is(':checked')){
    alert('Favor de seleccionar una opción de pastillas Traseras');
  }else if(!$("#formtechnicalreview input[name='front_discs']").is(':checked')){
    alert('Favor de seleccionar una opción de discos delanteros');
  }else if(!$("#formtechnicalreview input[name='rear_discs']").is(':checked')){
    alert('Favor de seleccionar una opción de discos traseros');
  }else if(!$("#formtechnicalreview input[name='rear_drums']").is(':checked')){
    alert('Favor de seleccionar una opción de tambores traseros');
  }else if(!$("#formtechnicalreview input[name='rear_shoes']").is(':checked')){
    alert('Favor de seleccionar una opción de zapatas traseros');
  }else if(!$("#formtechnicalreview input[name='emergency_break']").is(':checked')){
    alert('Favor de seleccionar una opción de freno de emergencia');
  }else if(!$("#formtechnicalreview input[name='brake_fluid']").is(':checked')){
    alert('Favor de seleccionar una opción de liquido de freno');
  }else if(!$("#formtechnicalreview input[name='tire_status']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de neumaticos');
  }else if(!$("#formtechnicalreview input[name='nut_revision']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de revision de tuercas');
  }else if(!$("#formtechnicalreview input[name='tire_pressure']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de presion de neumaticos');
  }else if(!$("#formtechnicalreview input[name='spare_tire']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de llanta de repuesto');
  // }else if(!$("#formtechnicalreview input[name='hoops']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de aros');
  // }else if(!$("#formtechnicalreview input[name='front_bumper']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Parachoque Delantero');
  // }else if(!$("#formtechnicalreview input[name='rear_bumper']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Parachoque Posterior');
  // }else if(!$("#formtechnicalreview input[name='left_front_door']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Puerta Del. Izquierda');
  // }else if(!$("#formtechnicalreview input[name='right_front_door']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Puerta Del. Derecha');
  // }else if(!$("#formtechnicalreview input[name='left_rear_door']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Puerta Post. Izquierda');
  // }else if(!$("#formtechnicalreview input[name='right_rear_door']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Puerta Post. Derecha');
  // }else if(!$("#formtechnicalreview input[name='left_fender']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Guardafango Izquierda');
  // }else if(!$("#formtechnicalreview input[name='right_fender']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Guardafango Derecho');
  // }else if(!$("#formtechnicalreview input[name='soft_top']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Capota');
  // }else if(!$("#formtechnicalreview input[name='left_front_glass']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Vidrio Del. Izquierdo');
  // }else if(!$("#formtechnicalreview input[name='right_front_glass']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Vidrio Del. derecho');
  // }else if(!$("#formtechnicalreview input[name='left_rear_glass']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Vidrio Post. Izquierdo');
  // }else if(!$("#formtechnicalreview input[name='right_rear_glass']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Vidrio Post. Derecho');
  // }else if(!$("#formtechnicalreview input[name='front_windshield']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Parabrisa Delantero');
  // }else if(!$("#formtechnicalreview input[name='rear_windshield']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Parabrisa Trasera');
  // }else if(!$("#formtechnicalreview input[name='trunk']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Maletero');
  // }else if(!$("#formtechnicalreview input[name='ceiling']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de techo');
  }else if(!$("#formtechnicalreview input[name='oil_leak']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de fuga de aceite');
  }else if(!$("#formtechnicalreview input[name='refrigerant_leak']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Fuga de refrigerante');
  }else if(!$("#formtechnicalreview input[name='fuel_leak']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Fuga de combustible');
  }else if(!$("#formtechnicalreview input[name='oil_filter']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Filtro de aceite');
  }else if(!$("#formtechnicalreview input[name='air_filter']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Filtro de aire');
  }else if(!$("#formtechnicalreview input[name='fuel_filter']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Filtro de combustible');
  }else if(!$("#formtechnicalreview input[name='cabin_filter']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Filtro de cabina');
  }else if(!$("#formtechnicalreview input[name='steering_pump']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Bomba de direccion');
  }else if(!$("#formtechnicalreview input[name='front_shock_absorbers']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Amortiguadores Delanteros');
  }else if(!$("#formtechnicalreview input[name='rear_shock_absorbers']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Amortiguadores Posteriores');
  }else if(!$("#formtechnicalreview input[name='pallets']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Palieres');
  }else if(!$("#formtechnicalreview input[name='pads']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Rotulas');
  }else if(!$("#formtechnicalreview input[name='terminal_blocks']").is(':checked')){
    alert('Favor de seleccionar una opción de terminales de direccion');
  }else if(!$("#formtechnicalreview input[name='trapezios']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Trapezios');
  }else if(!$("#formtechnicalreview input[name='springs']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Resortes');
  }else if(!$("#formtechnicalreview input[name='box_oil']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Aceite de caja');
  }else if(!$("#formtechnicalreview input[name='case_filter']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Filtro de caja');
  }else if(!$("#formtechnicalreview input[name='transfer_case']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Caja de transferencia');
  }else if(!$("#formtechnicalreview input[name='cardan']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de cardan');
  }else if(!$("#formtechnicalreview input[name='differential']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Diferencial');
  }else if(!$("#formtechnicalreview input[name='clutch_disc']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Disco de embrague');
  }else if(!$("#formtechnicalreview input[name='collarin']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Collarin');
  }else if(!$("#formtechnicalreview input[name='crossbows']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Cruzetas');
  }else if(!$("#formtechnicalreview input[name='radiator']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Radiador');
  }else if(!$("#formtechnicalreview input[name='ventilators']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Ventiladores');
  }else if(!$("#formtechnicalreview input[name='fan_belt']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Correa de ventilador');
  }else if(!$("#formtechnicalreview input[name='water_hoses']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Mangueras de agua');
  // }else if(!$("#formtechnicalreview input[name='board']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Tablero');
  }else if(!$("#formtechnicalreview input[name='dash_light']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Luz de tablero');
  }else if(!$("#formtechnicalreview input[name='saloon_light']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Luz de saloom');
  // }else if(!$("#formtechnicalreview input[name='pilot_seat']").is(':checked')){
  //   alert('Favor de seleccionar una opción de estado de Luz de saloom');
  // }else if(!$("#formtechnicalreview input[name='passenger_seat']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Asiento copiloto');
  // }else if(!$("#formtechnicalreview input[name='rear_seats']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Asientos traseros');
  // }else if(!$("#formtechnicalreview input[name='horn']").is(':checked')){
    // alert('Favor de seleccionar una opción de estado de Claxon');
  }else if(!$("#formtechnicalreview input[name='gata']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de gata');
  }else if(!$("#formtechnicalreview input[name='wheel_wrench']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Llave de ruedas');
  }else if(!$("#formtechnicalreview input[name='tool_kit']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Estuche de herramientas');
  }else if(!$("#formtechnicalreview input[name='safety_triangle']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Triangulo de seguridad');
  }else if(!$("#formtechnicalreview input[name='extinguisher']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Extintor');
  }else{
      alertify.confirm('Alerta', title , function(){
    if (status == 1){
         alertify.prompt( 'Observaciones', 'Ingresar razon'
               , function(evt, value) {  $("#observacion").val(value);
                registercheck(status);}
               , function() { alert("Ingresar una observacion"); });
     }else{
          //$("#observacion").val("");
          alertify.prompt( 'Observaciones', 'Ingresa alguna observacion'
                , function(evt, value) {  $("#observacion").val(value);
                 registercheck(status);}
                , function() { alert("Ingresar una observacion"); });
          // registercheck(status);
     }
     }, function(){
      alertify.error('Cancelar');
   });
  }

});


function registercheck(status){
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);
  $('#email-user').prop("disabled", false);
  $('#phone-user').prop("disabled", false);
  $('#dni').prop("disabled", false);
  $.ajax(
    {
      url: "/users/externo/savetechnicalreview",
      type:"POST",
      data :{ data : $('#formtechnicalreview').serializeObject(), iduser : iduser, status: status,
      proceso :  1, codigoproceso: codigoproceso
    },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide();
      if (d.object == "success"){
        alert(d.message);
        window.location.href = "/driver/externo/rtpdf/"+d.idtec;
        $('#idoffice').val("");
        $("#tipdocid").val("");
        $('#dni').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
        $('#placa').val("");
        $('#year').val("");
        $('#observacion').val("");

        $("#formtechnicalreview input[name='light_low']").prop('checked', false);
        $("#formtechnicalreview input[name='light_high']").prop('checked', false);
      $("#formtechnicalreview input[name='light_brake']").prop('checked', false);
      $("#formtechnicalreview input[name='light_emergency']").prop('checked', false);
      $("#formtechnicalreview input[name='light_recoil']").prop('checked', false);
      $("#formtechnicalreview input[name='light_intermittent']").prop('checked', false);
      $("#formtechnicalreview input[name='light_fog']").prop('checked', false);
      $("#formtechnicalreview input[name='light_plate']").prop('checked',false);
      $("#formtechnicalreview input[name='engine_start']").prop('checked', false);
      $("#formtechnicalreview input[name='alternator']").prop('checked', false);
      $("#formtechnicalreview input[name='plugs']").prop('checked', false);
      $("#formtechnicalreview input[name='cable_plugs']").prop('checked', false);
      $("#formtechnicalreview input[name='coils']").prop('checked', false);
      $("#formtechnicalreview input[name='injectors']").prop('checked', false);
      $("#formtechnicalreview input[name='drums']").prop('checked', false);
      $("#formtechnicalreview input[name='front_pads']").prop('checked', false);
      $("#formtechnicalreview input[name='rear_pads']").prop('checked', false);
      $("#formtechnicalreview input[name='front_discs']").prop('checked', false);
      $("#formtechnicalreview input[name='rear_discs']").prop('checked', false);
      $("#formtechnicalreview input[name='rear_drums']").prop('checked', false);
      $("#formtechnicalreview input[name='rear_shoes']").prop('checked', false);
      $("#formtechnicalreview input[name='emergency_break']").prop('checked', false);
      $("#formtechnicalreview input[name='brake_fluid']").prop('checked', false);
      $("#formtechnicalreview input[name='tire_status']").prop('checked', false);
      $("#formtechnicalreview input[name='nut_revision']").prop('checked', false);
      $("#formtechnicalreview input[name='tire_pressure']").prop('checked', false);
      $("#formtechnicalreview input[name='spare_tire']").prop('checked', false);
      // $("#formtechnicalreview input[name='hoops']").prop('checked', false);
      // $("#formtechnicalreview input[name='front_bumper']").prop('checked', false);
      // $("#formtechnicalreview input[name='rear_bumper']").prop('checked', false);
      // $("#formtechnicalreview input[name='left_front_door']").prop('checked', false);
      // $("#formtechnicalreview input[name='right_front_door']").prop('checked', false);
      // $("#formtechnicalreview input[name='left_rear_door']").prop('checked', false);
      // $("#formtechnicalreview input[name='right_rear_door']").prop('checked', false);
      // $("#formtechnicalreview input[name='left_fender']").prop('checked', false);
      // $("#formtechnicalreview input[name='right_fender']").prop('checked', false);
      // $("#formtechnicalreview input[name='soft_top']").prop('checked', false);
      // $("#formtechnicalreview input[name='left_front_glass']").prop('checked', false);
      // $("#formtechnicalreview input[name='right_front_glass']").prop('checked', false);
      // $("#formtechnicalreview input[name='left_rear_glass']").prop('checked', false);
      // $("#formtechnicalreview input[name='right_rear_glass']").prop('checked', false);
      // $("#formtechnicalreview input[name='front_windshield']").prop('checked', false);
      // $("#formtechnicalreview input[name='rear_windshield']").prop('checked', false);
      // $("#formtechnicalreview input[name='trunk']").prop('checked', false);
      // $("#formtechnicalreview input[name='ceiling']").prop('checked', false);
      $("#formtechnicalreview input[name='oil_leak']").prop('checked', false);
      $("#formtechnicalreview input[name='refrigerant_leak']").prop('checked', false);
      $("#formtechnicalreview input[name='fuel_leak']").prop('checked', false);
      $("#formtechnicalreview input[name='oil_filter']").prop('checked', false);
      $("#formtechnicalreview input[name='air_filter']").prop('checked', false);
      $("#formtechnicalreview input[name='fuel_filter']").prop('checked', false);
      $("#formtechnicalreview input[name='cabin_filter']").prop('checked', false);
      $("#formtechnicalreview input[name='steering_pump']").prop('checked', false);
      $("#formtechnicalreview input[name='front_shock_absorbers']").prop('checked', false);
      $("#formtechnicalreview input[name='rear_shock_absorbers']").prop('checked', false);
      $("#formtechnicalreview input[name='pallets']").prop('checked', false);
      $("#formtechnicalreview input[name='pads']").prop('checked', false);
      $("#formtechnicalreview input[name='terminal_blocks']").prop('checked', false);
      $("#formtechnicalreview input[name='trapezios']").prop('checked', false);
      $("#formtechnicalreview input[name='springs']").prop('checked', false);
      $("#formtechnicalreview input[name='box_oil']").prop('checked', false);
      $("#formtechnicalreview input[name='case_filter']").prop('checked', false);
      $("#formtechnicalreview input[name='transfer_case']").prop('checked', false);
      $("#formtechnicalreview input[name='cardan']").prop('checked', false);
      $("#formtechnicalreview input[name='differential']").prop('checked', false);
      $("#formtechnicalreview input[name='clutch_disc']").prop('checked', false);
      $("#formtechnicalreview input[name='collarin']").prop('checked', false);
      $("#formtechnicalreview input[name='crossbows']").prop('checked', false);
      $("#formtechnicalreview input[name='radiator']").prop('checked', false);
      $("#formtechnicalreview input[name='ventilators']").prop('checked', false);
      $("#formtechnicalreview input[name='fan_belt']").prop('checked', false);
      $("#formtechnicalreview input[name='water_hoses']").prop('checked', false);
      // $("#formtechnicalreview input[name='board']").prop('checked', false);
      $("#formtechnicalreview input[name='dash_light']").prop('checked', false);
      $("#formtechnicalreview input[name='saloon_light']").prop('checked', false);
      // $("#formtechnicalreview input[name='pilot_seat']").prop('checked', false);
      // $("#formtechnicalreview input[name='passenger_seat']").prop('checked', false);
      // $("#formtechnicalreview input[name='rear_seats']").prop('checked', false);
      // $("#formtechnicalreview input[name='horn']").prop('checked', false);
      $("#formtechnicalreview input[name='gata']").prop('checked', false);
      $("#formtechnicalreview input[name='wheel_wrench']").prop('checked', false);
      $("#formtechnicalreview input[name='tool_kit']").prop('checked', false);
      $("#formtechnicalreview input[name='safety_triangle']").prop('checked', false);
      $("#formtechnicalreview input[name='extinguisher']").prop('checked', false);
      }else{
        alertify.notify(d.message, 'success', 5, function(){ });
      }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
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
