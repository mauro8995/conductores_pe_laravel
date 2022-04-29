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
    },
  }).done( function(d) {
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
function getUser(){
  valor = $('#idoffice').val();
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {
      $('#load_customer').show(300);
    }
    }).done(function(d)
    {
      $('#load_customer').hide(300);
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

          if (d.filemsj == "success"){
            if (d.file.placa != null){
              $('#placa').val(d.file.placa);
            }
            if (d.file.year == null){
              var  fila = '<select class="form-control select2" id="year" name="year">';
              $.each({ v : "SELECCIONAR", v1 : "2009", v2 : "2010", v3 : "2011" , v4 : "2012", v5 : "2013"}, function( k, v ) {
                fila += '<option>'+v+'</option>';
              });
              fila += '</select>';
              $('#yearfile').append(fila);
            }else{
              $('#yearfile').html('<input type="text" class="form-control" id="year" name="year" value="'+d.file.year+'">');
            }



          }
          if (d.file.marca != null){
            $('#marca').val(d.file.marca);
          }
          if (d.file.licencia != null){
            $('#licencia').val(d.file.licencia);
          }
          if (d.file.model != null){
            $('#model').val(d.file.model);
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
        $('#marca').val("");
        $('#licencia').val("");
        $('#model').val("");
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

$(document).on('blur', '#phone-user', function(event) {
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


$(document).on('blur', '#email-user', function(event) {
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
          email = 1;
        }else{
          email = 0;
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});

$(document).on('blur', '#licencia', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/licenciaval",
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
          licencia = 1;
        }else{
          licencia = 0;
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});




$("#marca").keyup(function(){
  var val = $("#marca").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/marcaval",
      type:"POST",
      data : { iduser : iduser, marca : val },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        marca = 1;
        alert(d.menssage);
      }else{
        alert(d.menssage);
        marca = 0;
      }
      console.log(d);
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }else{

  }
});
$("#licencia").keyup(function(){
  var val = $("#licencia").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/licenciaval",
      type:"POST",
      data : { iduser : iduser, licencia : val },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        licencia = 1;
        alert(d.menssage);
      }else{
        alert(d.menssage);
        licencia = 0;
      }
      console.log(d);
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }else{

  }
});

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

$("#model").keyup(function(){
  var val = $("#model").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/modelval",
      type:"POST",
      data : { iduser : iduser, model : val },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        model = 1;
        alert(d.menssage);
      }else{
        alert(d.menssage);
        model = 0;
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
  statusa = $(this).attr("data-val");

  if (statusa == 2){
    title = '¿Aprobar todo?';
    check = 0;

  }else{
    title = '¿Desaprobar todo?';
    check = 1;
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
     $("#formtechnicalreview2 input[name='light_low']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='light_high']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='light_brake']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='light_recoil']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='left_front_door']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='soft_top']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='left_front_glass']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='front_windshield']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='trunk']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='tire_status']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='dash_light']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='saloon_light']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='pilot_seat']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='belt']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='horn']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='gata']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='spare_tire']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='tool_kit']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='safety_triangle']:nth("+check+")").prop('checked',true);
     $("#formtechnicalreview2 input[name='extinguisher']:nth("+check+")").prop('checked',true);
     if (statusa == 1){
         alertify.prompt( "Observaciones", "Ingresar razon"
               , function(evt, value) {  $("#observacion").val(value);
                registercheck(statusa); }
               , function() { alert("Ingresar una observacion"); });
     }else{
          $("#observacion").val("");
          registercheck(statusa);
     }

   }, function(){
      alertify.error('Cancelar');
   });
 }
});

$(".btn_ajax").click(function() {

  status = $(this).attr("data-val");
//VALIDACIONES

  if ($('#idoffice').val() == ""){
    alert('ingrese un id');
  }else if (iduser == 0){
    alert('ingrese un id valido');
    //Datos del usuario
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
    //Datos del vehiculo
  }else if ($('#placa').val() == ""){
    alert('ingrese una placa');
  }else if (placa == 1){
    alert('la placa ya existe o es invalida');
  }else  if ($("#year option:selected").text() == "SELECCIONAR"){
    alert('seleccione un año');
  }else  if ($('#marca').val() == ""){
    alert('Ingrese la marca del automovil');
  }else  if ($('#model').val() == ""){
    alert('Ingrese el modelo del automovil');
    //luces
  }else if(!$("#formtechnicalreview2 input[name='light_low']").is(':checked')){
   	alert('Favor de seleccionar una opción de luz baja');
  }else if(!$("#formtechnicalreview2 input[name='light_high']").is(':checked')){
    alert('Favor de seleccionar una opción de luz alta');
  }else if(!$("#formtechnicalreview2 input[name='light_brake']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de freno');
  }else if(!$("#formtechnicalreview2 input[name='light_recoil']").is(':checked')){
    alert('Favor de seleccionar una opción de luz de retroceso');
    //carroceria
  }else if(!$("#formtechnicalreview2 input[name='left_front_door']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Puertas');
  }else if(!$("#formtechnicalreview2 input[name='left_front_glass']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de lunas (vidrios)');
  }else if(!$("#formtechnicalreview2 input[name='front_windshield']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Parabrisa');
  }else if(!$("#formtechnicalreview2 input[name='soft_top']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Capota');
  }else if(!$("#formtechnicalreview2 input[name='trunk']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Maletero');
  }else if(!$("#formtechnicalreview2 input[name='tire_status']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de llantas');
    //interior
  }else if(!$("#formtechnicalreview2 input[name='pilot_seat']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de asientos');
  }else if(!$("#formtechnicalreview2 input[name='saloon_light']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Luz de saloom');
  }else if(!$("#formtechnicalreview2 input[name='horn']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Bocina');
  }else if(!$("#formtechnicalreview2 input[name='belt']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de cinturones de seguridad');
  }else if(!$("#formtechnicalreview2 input[name='dash_light']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Luz de tablero');
    //herrmientas
  }else if(!$("#formtechnicalreview2 input[name='tool_kit']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Estuche de herramientas');
  }else if(!$("#formtechnicalreview2 input[name='gata']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de gata');
  }else if(!$("#formtechnicalreview2 input[name='extinguisher']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Extintor');
  }else if(!$("#formtechnicalreview2 input[name='safety_triangle']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de Triangulo de seguridad');
  }else if(!$("#formtechnicalreview2 input[name='spare_tire']").is(':checked')){
    alert('Favor de seleccionar una opción de estado de llanta extra');



  }else{
    registercheck(status);
  }

});


function registercheck(status){
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);
  $('#dni').prop("disabled", false);
  $.ajax(
    {
      url: "/users/externo/savetechnicalreview2",
      type:"POST",
      data :{ data : $('#formtechnicalreview2').serializeObject(), iduser : iduser, status: status,
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
        window.location.href = "/driver/externo/rtpdf2/"+d.idtec;
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
        $('#observacion1').val("");
        $('#observacion2').val("");
        $('#observacion3').val("");
        $('#observacion4').val("");
        $("#formtechnicalreview2 input[name='light_low']").prop('checked', false);
        $("#formtechnicalreview2 input[name='light_high']").prop('checked', false);
      $("#formtechnicalreview2 input[name='light_brake']").prop('checked', false);
      $("#formtechnicalreview2 input[name='light_recoil']").prop('checked', false);
      $("#formtechnicalreview2 input[name='left_front_door']").prop('checked', false);
      $("#formtechnicalreview2 input[name='left_front_glass']").prop('checked', false);
      $("#formtechnicalreview2 input[name='front_windshield']").prop('checked', false);
      $("#formtechnicalreview2 input[name='soft_top']").prop('checked', false);
      $("#formtechnicalreview2 input[name='trunk']").prop('checked', false);
      $("#formtechnicalreview2 input[name='tire_status']").prop('checked', false);
      $("#formtechnicalreview2 input[name='clutch_disc']").prop('checked', false);
      $("#formtechnicalreview2 input[name='collarin']").prop('checked', false);
      $("#formtechnicalreview2 input[name='crossbows']").prop('checked', false);
      $("#formtechnicalreview2 input[name='radiator']").prop('checked', false);
      $("#formtechnicalreview2 input[name='ventilators']").prop('checked', false);
      $("#formtechnicalreview2 input[name='fan_belt']").prop('checked', false);
      $("#formtechnicalreview2 input[name='water_hoses']").prop('checked', false);
      $("#formtechnicalreview2 input[name='board']").prop('checked', false);
      $("#formtechnicalreview2 input[name='dash_light']").prop('checked', false);
      $("#formtechnicalreview2 input[name='saloon_light']").prop('checked', false);
      $("#formtechnicalreview2 input[name='pilot_seat']").prop('checked', false);
      $("#formtechnicalreview2 input[name='belt']").prop('checked', false);
      $("#formtechnicalreview2 input[name='horn']").prop('checked', false);
      $("#formtechnicalreview2 input[name='gata']").prop('checked', false);
      $("#formtechnicalreview2 input[name='spare_tire']").prop('checked', false);
      $("#formtechnicalreview2 input[name='tool_kit']").prop('checked', false);
      $("#formtechnicalreview2 input[name='safety_triangle']").prop('checked', false);
      $("#formtechnicalreview2 input[name='extinguisher']").prop('checked', false);
      }else{
        alert(d.message);
      }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}
///////////////// INICIO BOTON TALLER /////////////////////////////////
$(".btn_ajax2").click(function() {

  status = $(this).attr("data-val");
//VALIDACIONES

  if ($('#idoffice').val() == ""){
    alert('ingrese un id');
  }else if (iduser == 0){
    alert('ingrese un id valido');
    //Datos del usuario
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
  }else  if ($('#licencia').val() == ""){
    alert('Ingrese un telefono');
    //Datos del vehiculo
  }else if ($('#placa').val() == ""){
    alert('ingrese una placa');
  }else if (placa == 1){
    alert('la placa ya existe o es invalida');
  }else  if ($("#year option:selected").text() == "SELECCIONAR"){
    alert('seleccione un año');
  }else  if ($('#marca').val() == ""){
    alert('Ingrese la marca del automovil');
  }else  if ($('#model').val() == ""){
    alert('Ingrese el modelo del automovil');
  }else  if ($('#observacion').val() == ""){

    alertify.prompt('Observacion','Ingresar las razones para enviar a taller.', ''
        ,function(evt, value ){ $("#observacion").val(value);
        alertify.success("se ha remitido al taller de (Pretel)");
        registercheck2(status);
      }
        ,function(){alertify.error('Cancelar');});
  }else{
  registercheck2(status);
  }

});//////////// FIN BOTON TALLER /////////////////////////////////////

function registercheck2(status){
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);
  $('#dni').prop("disabled", false);
  $.ajax(
    {
      url: "/users/externo/savetechnicalreview3",
      type:"POST",
      data :{ data : $('#formtechnicalreview2').serializeObject(), iduser : iduser, status: status,
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
        //window.location.href = "/driver/externo/rtpdf/"+d.idtec;
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

      }else{
        alert(d.message);
      }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}
// function oculta(elemento) {
//         ///// capturamos el elemento
//     item=$("#"+elemento);
//        ///// verificamos su estado
//     if($(item).hasClass('visible')) {
//
//     } else {
//         $(item).removeClass('invisible');
//         $(item).addClass('visible');
//         $(item).slideDown('fast');
//     }
// }

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
