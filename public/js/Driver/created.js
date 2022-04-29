$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$('#title').html('¡Unete a la comunidad de conductores WIN!');
$('#subtitle').html('');
$('#form-inicio').show();
$('#form-newuseregister').hide();
$('#form-registerdriver').hide();
$('#la').hide();
$('#form-val-user').hide();
$('#form-val-user2').hide();
$('#form-datos').hide();
$('#form-rememberusers').hide();
$('#form-validate-datos').hide();
$('#form-validate-datos2').hide();
$('#form-documentos-driver').hide();
$('#form-dni').hide();
$('#form-soat').hide();
$('#form-atu').hide();
$('#form-licencia').hide();
$('#form-tarjvehi').hide();
$('#form-revision').hide();
$('#form-documentos-vehicle').hide();
$('#form-externas').hide();
$('#form-laterales').hide();
$('#form-internas').hide();
$('#form-perfil').hide();
$('#form-register').hide();
$('#phonevaluser').hide();
$('.sendcodphone').prop("disabled", true);
$('#num_doc').prop("disabled", true);
$('#emailvaluser').hide();
// $('.validateEmailv').prop("disabled", true);
$('#btn-datos').prop("disabled", true);
$('#btn-documentos-driver').prop("disabled", true);
$('#btn-documentos-vehicle').prop("disabled", true);
$('#licencia').prop("disabled", true);
$('#email').prop("disabled", false);
$('#phone').prop("disabled", false);
var city;
function selectcity(el){ // recibimos por parametro el elemento select
   // obtenemos la opción seleccionada .
  city = $('option:selected', el).attr('data-city');
}

$('.input-number').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});

$('.input-letter').on('input', function () {
    this.value = this.value.replace(/[^a-zA-Z�-�\u00f1\u00d1]/,'');
});

$('.input-letter-space').bind('keypress', function () {
  var regex = new RegExp("^[a-zA-Z �-�\u00f1\u00d1]+$");
  var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
  if (!regex.test(key)) {
    event.preventDefault();
    return false;
  }
});

$('.input-number-letter').on('input', function () {
    this.value = this.value.replace(/[^a-zA-Z�-�\u00f1\u00d1-0-9\_]/,'');
});

$('.input-number-letter-m').on('input', function () {
    this.value = this.value.replace(/[^a-z�-�\u00f1\u00d1-0-9\_]/,'');
});

$("#valphone1").keyup(function(){
    $("#valphone2").focus();
  });

  $("#valphone2").keyup(function(){
    $("#valphone3").focus();
  });

  $("#valphone3").keyup(function(){
    $("#valphone4").focus();
  });


  $("#valemail1").keyup(function(){
    $("#valemail2").focus();
  });

  $("#valemail2").keyup(function(){
    $("#valemail3").focus();
  });

  $("#valemail3").keyup(function(){
    $("#valemail4").focus();
  });


var statusdni = 0;
var statuslicencia = 0;
var statustarjevehi = 0;
var statusoat = 0;
var statusexternas = 0;
var statuslaterales = 0;
var statusinternas = 0;

$("#empezarregister").click(function() {
  $('#form-inicio').hide();
  $('#form-registerdriver').show();
  $('#form-newuseregister').show();
  $('#title').html('Ingrese su usuario');
});

$("#rememberuser").click(function() {
  $('#rememberemail').removeClass('is-valid');
  $('#rememberemail').removeClass('is-invalid');
  $("#rememberuservalidate").html('');
  $('#form-newuseregister').hide();
  $('#form-rememberusers').show();
  $('#title').html('¿No recuerdas tu usuario?');
});


function validarmeprinci(){
  $('#form-newuseregister').show();
  $('#form-rememberusers').hide();
  $('#title').html('Ingrese su usuario');
}

var idfiledrivers;
var idoffice;
$("#btn-userregister").click(function() {
  if ($('#user').val().length > 0){
  $.ajax(
  {
    url: "/validateoffice",
    type:"POST",
    data : { value : $('#user').val() },
    dataType: "json",
    beforeSend: function () {
      $('#load_inv').show(30);
    },
  }).done(function(d){
    $('#load_inv').hide(30);
    if (d.flag == true){
      idoffice = 0;
      if (d.oficinav == true){
        idfiledrivers = d.id;
        $('#title').html('Subir fotos de documentos');
        $('#form-newuseregister').hide();
        $('#form-documentos-driver').show();
      }else{
        $('#user').removeClass('is-valid').addClass('is-invalid');
        $("#uservalidate").html(d.mensaje).css("color", "#FF0000");
        $("#userexitsvalidate").html('');
      }
    }else{
          $('#form-newuseregister').hide();
          $('#title').html('Inicia completando tus datos');
          $('#form-datos').show();
          $('#user').removeClass('is-invalid').addClass('is-valid');
          $("#uservalidate").html('');
          $('#first_name').val(d.oficinav.datos.first_name);
          $('#last_name').val(d.oficinav.datos.last_name);
          var tphone = d.oficinav.datos.phone;
	        if (tphone.length == 9){
                $('#phone').val(tphone);
          }else if (tphone.length == 11){
                $('#phone').val(tphone.substring(2, 11));
          }else{
                $('#phone').val(tphone.substring(3, 12));
          }
          $('#email').val(d.oficinav.datos.email);
          idoffice = d.oficinav.datos.userid;
          //idoffice = 1;
          $("#userexitsvalidate").hide();
    }
  }).fail(function(error){
    console.log(error);
    $('#load_inv').hide(30);
    alert("No se registró, intente nuevamente por favor.");
  });
 }else{
    $('#user').removeClass('is-valid').addClass('is-invalid');
    $("#uservalidate").html('ingrese un usuario valido').css("color", "#FF0000");
 }
});

$("#btn-rememberuser").click(function() {
  if ($('#rememberemail').val().length > 0){
  $.ajax(
  {
    url: "/validateuserphoneemail",
    type:"POST",
    data : { value : $('#rememberemail').val() },
    dataType: "json",
    beforeSend: function () {
      $('#load_inv').show(30);
    },
  }).done(function(d){
    $('#load_inv').hide(30);
    if (d.flag == true){
        $('#rememberemail').removeClass('is-valid').addClass('is-invalid');
        $("#rememberuservalidate").html(d.mensaje);
    }else{
      $('#rememberemail').removeClass('is-invalid').addClass('is-valid');
      $('#user').val(d.oficinav.username);
      $('#uservalidate').html('<input type="text" class="form-control form-control-user" disabled="disabled" value="'+d.oficinavss.datos.first_name+' '+d.oficinavss.datos.last_name+'">');
      $('#title').html('El dato ingresado se encuentra registrado con el usuario:');
      $('#form-newuseregister').show();
      $('#form-rememberusers').hide();
      $('#rememberuser').html('¿Este no eres tú?');
      $('#validaruseregs').hide();
      $("#rememberuservalidate").html(d.mensaje);
    }
  }).fail(function(error){
    console.log(error);
    $('#load_inv').hide(30);
    alert("No se registró, intente nuevamente por favor.");
  });
 }else{
    $('#rememberemail').removeClass('is-valid').addClass('is-invalid');
    $("#rememberuservalidate").html('ingrese un usuario valido').css("color", "#FF0000");
 }
});

$('#btn-newuseregister').click(function(){
  alertify.confirm('Confirmar', '¿Usted ah sido invitado a win por un usuario?', function(){
       location.reload('https://winrideshareapp.page.link/KbdTHoJSMs8nk5n57');
    }, function(){

    }).set('labels', {ok:'SI', cancel:'NO'});
});

$("#type_docs").change(function(){
    if($('#type_docs').val() == ""){
      $('#type_docs').removeClass('is-valid').addClass('is-invalid');
      $("#typedocsvalidate").html('Seleccione un tipo de documento').css("color", "#FF0000");
      $('#num_doc').prop("disabled", true);
      $('#num_doc').val("");
      $('#num_doc').removeClass('is-valid');
      $('#num_doc').removeClass('is-invalid');
      $('#first_name').val("");
      $('#first_name').removeClass('is-valid');
      $('#first_name').removeClass('is-invalid');
      $('#last_name').val("");
      $('#last_name').removeClass('is-valid');
      $('#last_name').removeClass('is-invalid');
      $('#licencia').val("");
      $('#licencia').removeClass('is-valid');
      $('#licencia').removeClass('is-invalid');
    }else{
      $('#num_doc').prop("disabled", false);
      $('#type_docs').removeClass('is-invalid').addClass('is-valid');
      $("#typedocsvalidate").html('');
      $('#num_doc').val("");
      $('#num_doc').removeClass('is-valid');
      $('#num_doc').removeClass('is-invalid');
      $('#first_name').val("");
      $('#first_name').removeClass('is-valid');
      $('#first_name').removeClass('is-invalid');
      $('#first_name').prop("disabled", false);
      $('#last_name').val("");
      $('#last_name').removeClass('is-valid');
      $('#last_name').removeClass('is-invalid');
      $('#last_name').prop("disabled", false);
      $('#licencia').val("");
      $('#licencia').removeClass('is-valid');
      $('#licencia').removeClass('is-invalid');
    }
});

$("#city").change(function(){
    if($('#city').val() == ""){
      $('#city').removeClass('is-valid').addClass('is-invalid');
    }else{
      $('#city').removeClass('is-invalid').addClass('is-valid');
    }
});

var dni;
$(document).on('change', '#num_doc', function(event) {
  tipdocids = $("#type_docs option:selected").val();
  val = $(this).val()
  if (val == ""){
    $("#numdocvalidate").html('Ingrese un número de documento').css("color", "#FF0000");
  }else{
  $.ajax(
  {
    url: "/validatedni",
    type:"POST",
    data : { value : val, tipdoc : tipdocids },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
    $('#load_inv').hide();
    if (d.flag == true){
      dni = 1;
      $("#numdocvalidate").html(d.mensaje).css("color", "#FF0000");
      $('#num_doc').removeClass('is-valid').addClass('is-invalid');
    }else{
      dni = 0;
      $('#num_doc').removeClass('is-invalid').addClass('is-valid');
      $("#numdocvalidate").html('');
      getValDNI(val);
    }
  }).fail(function(error){
    $('#load_inv').hide();
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});

$(document).on('change', '#first_name', function(event) {
  val = $(this).val();
  if (val == ""){
    $('#first_name').removeClass('is-valid').addClass('is-invalid');
  }else{
    $('#first_name').removeClass('is-invalid').addClass('is-valid');
  }
});

$(document).on('change', '#last_name', function(event) {
  val = $(this).val();
  if (val == ""){
    $('#last_name').removeClass('is-valid').addClass('is-invalid');
  }else{
    $('#last_name').removeClass('is-invalid').addClass('is-valid');
  }
});

function getValDNI(d) {
  tipdocids = $("#type_docs option:selected").val();
  if (tipdocids == 1){
  $.ajax(
    {
      url: "/reniecValidate",
      type:"POST",
      data : {  dni : d },//
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d)
    {
      $('#load_inv').hide();
      alertify.notify(d.data.message,'success',2, function(){});
      if (d.data.first_name != null){
        $('#first_name').val(d.data.first_name);
        $('#last_name').val(d.data.last_name);
        $('#first_name').removeClass('is-invalid').addClass('is-valid');
        $('#last_name').removeClass('is-invalid').addClass('is-valid');
      }
      if (d.data.object == true){
        $('#first_name').prop("disabled", true);
        $('#last_name').prop("disabled", true);
      }else{
        $('#first_name').prop("disabled", false);
        $('#last_name').prop("disabled", false);
      }
      $('#licencia').prop("disabled", false);
    }).fail(function(){
      alert("error");//alerta del ticket no resgistrado
    });
  }else{
    alertify.notify('COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS', 'success',2, function(){});
    $('#first_name').prop("disabled", false);
    $('#last_name').prop("disabled", false);
    $('#licencia').prop("disabled", false);
  }
}

$(document).on('blur', '#licencia', function(event) {
  var str = $(this).val();
  var numdo = $('#num_doc').val().length;
  var res = str.substring(1, numdo+1);
  if ($(this).val().length > 0){
    if ($('#num_doc').val() != res && $('#type_docs').val() == 1){
      $("#licenciavalidate").html('Esta licencia no coincide con tus datos').css("color", "#FF0000");
    }else{
  $.ajax(
  {
    url: "/validateexitslicence",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
        $('#load_inv').hide();
        if (d.flag == true){
          licence = 1;
          $('#licencia').removeClass('is-valid').addClass('is-invalid');
          $("#licenciavalidate").html(d.mensaje).css("color", "#FF0000");
        }else{
          licence = 0;
          validatelicencia();
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
}else{
  $("#licenciavalidate").html('Ingrese numero de licencia').css("color", "#FF0000");
}
});

var vallicencia;
function validatelicencia(){
  var val = $('#num_doc').val();
  var tipdocidv = $("#type_docs option:selected").val();
  $.ajax(
  {
    url: "/validatelicence",
    type:"POST",
    data : { licencia : val, tipodoc : tipdocidv},
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
    $('#load_inv').hide();
    console.log(d);
    if (d.object == "success"){
      if(d.data != null){
        $("#licencia").val(d.data);
      }
      vallicencia = 0;
      $('#licencia').removeClass('is-invalid').addClass('is-valid');
      $("#licenciavalidate").html('');
    }else{
      vallicencia = 1;
      $('#licencia').removeClass('is-valid').addClass('is-invalid');
      $("#licenciavalidate").html(d.menssage).css("color", "#FF0000");
    }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}

var placa;
$('#placa').prop("maxlength", 6);
$(document).on('change', '#placa', function(event) {
  var val = $(this).val();
  $.ajax(
  {
    url: "/validateexitsplaca",
    type:"POST",
    data : { value : val },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
    $('#load_inv').hide();
    if (d.flag == true){
      placa = 0;
      $('#placa').removeClass('is-valid').addClass('is-invalid');
      $("#placavalidate").html(d.mensaje).css("color", "#FF0000");
    }else{
      $("#placavalidate").html('');
      validateplaca(val);
      placa = 1;
    }
  }).fail(function(error){
    $('#load_inv').hide();
    console.log(error);
    alert("No se registrÃ³, intente nuevamente por favor.");
  });
});

var valplaca;
function validateplaca(val) {
    $.ajax(
    {
      url: "/validateplaca",
      type:"POST",
      data : { placa : val },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.object == "success"){
        valplaca = 0;
        $('#placa').removeClass('is-invalid').addClass('is-valid');
        $("#placavalidate").html('');
      }else{
        $('#placa').removeClass('is-valid').addClass('is-invalid');
        $("#placavalidate").html(d.menssage).css("color", "#FF0000");
        valplaca = 1;
      }
    }).fail(function(error){
      $('#load_inv').hide();
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

$('#customCheck').on('change', function() {
    if ($(this).is(':checked') ) {
      if (idoffice == 3){
        $("#uservalidate").html('Este usuario ya se encuentra registrado').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#user').val() == ""){
        $("#uservalidate").html('Complete el campo del usuario').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#type_docs').val() == ""){
        $("#typedocsvalidate").html('Seleccione el tipo de documento').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#num_doc').val() == ""){
        $("#numdocvalidate").html('Complete el campo de numero de documento').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if (dni == 1){
        $("#numdocvalidate").html('Este numero de documento ya se encuentra registrado').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#first_name').val() == ""){
        $("#firstnamevalidate").html('Complete el campo del nombre').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#last_name').val() == ""){
        $("#lastnamevalidate").html('Complete el campo del apellido').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#placa').val() == ""){
        $("#placavalidate").html('Complete la placa').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#licencia').val() == ""){
        $("#licenciavalidate").html('Complete la licencia').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else if ($('#city').val() == ""){
        $("#cityvalidate").html('Seleccione la ciudad donde conduce').css("color", "#FF0000");
        $("#customCheck").prop("checked", false);
      }else{
        $('#btn-datos').prop("disabled", false);
      }
    } else {
      $("#termcondvalidate").html('Para continuar debe aceptar terminos y condiciones').css("color", "#FF0000");
      $('#btn-datos').prop("disabled", true);
    }
});


$("#termnicondi").click(function() {
  var pre = document.createElement('pre');
  //custom style.
  pre.style.maxHeight = "400px";
  pre.style.margin = "0";
  pre.style.padding = "24px";
  pre.style.whiteSpace = "pre-wrap";
  pre.style.textAlign = "justify";
  pre.appendChild(document.createTextNode($('#la').text()));
  //show as confirm
  alertify.confirm(pre, function(){
    $("#customCheck").prop("checked", true);
    
  },function(){
    $("#customCheck").prop("checked", false);
    
  }).set({labels:{ok:'Entiendo y estoy de acuerdo', cancel: 'Cancelar'}, padding: false}).setHeader('Términos y condiciones');
});


$("#btn-datos").click(function() {
  if (idoffice == 0){
    $("#uservalidate").html('Este usuario ya se encuentra registrado').css("color", "#FF0000");
  }else if ($('#user').val() == ""){
    $("#uservalidate").html('Complete el campo del usuario').css("color", "#FF0000");
  }else if ($('#type_docs').val() == ""){
    $("#typedocsvalidate").html('Seleccione el tipo de documento').css("color", "#FF0000");
  }else if ($('#num_doc').val() == ""){
    $("#numdocvalidate").html('Complete el campo de numero de documento').css("color", "#FF0000");
  }else if (dni == 1){
    $("#numdocvalidate").html('Este numero de documento ya se encuentra registrado').css("color", "#FF0000");
  }else if ($('#first_name').val() == ""){
    $("#firstnamevalidate").html('Complete el campo del nombre').css("color", "#FF0000");
  }else if ($('#last_name').val() == ""){
    $("#lastnamevalidate").html('Complete el campo del apellido').css("color", "#FF0000");
  }else if ($('#city').val() == ""){
    $("#cityvalidate").html('Seleccione la ciudad donde conduce').css("color", "#FF0000");
  }else if (vallicencia == 1){
    $("#licenciavalidate").html('Complete la licencia').css("color", "#FF0000");
  }else if (valplaca == 1){
    $("#placavalidate").html('Complete la placa').css("color", "#FF0000");
  }else if ($('#customCheck').prop('checked') == false){
    $("#termcondvalidate").html('Para continuar debe aceptar terminos y condiciones').css("color", "#FF0000");
  }else{
    $('#title').html('Vamos a validar tus datos');
    $("#userexitsvalidate").show();
    $('#form-datos').hide();
    $('#form-validate-datos').show();
  }
});

function validatePhone(vari) {
  if ($('#phone').val().length == 9){
    alertify.confirm('vamos a verificar el numero de telefono', '+51 ('+$('#phone').val()+') <br> ¿es correcto?', function(){
    $.ajax(
    {
      url: "/driver/externo/phoneval",
      type:"POST",
      data : { value : $('#phone').val() },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.flag == true){
        $("#phonevalidate").html(d.mensaje).css("color", "#FF0000");
        phone = 1;
        $('#phone').removeClass('is-valid').addClass('is-invalid');
      }else{
        phone = 0;
        validatePhoneExits(vari);
      }
    }).fail(function(error){
      $('#load_inv').hide();
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }, function(){ $('#phone').focus(); }).set('labels', {ok:'Correcto', cancel:'Cancelar'});
  }else{
    $("#phonevalidate").html("Ingrese número de telefono valido").css("color", "#FF0000");
  }
}

var codigoGenePhone;
var contrasenia;
var valphone;
function validatePhoneExits(vari)
{
  if($('#phone').val().length == 9)
  {
    var caracteres = "123456789";
    for (i=0; i<6; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
    $.ajax(
      {
        url: "/driver/externo/confir/phone/new",
        type:"POST",
        data :{ token_generado : contrasenia, phone:$('#phone').val(), var: vari},
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d){
        $('#load_inv').hide(30);
        if (d.object=='success'){
         $("#phonevalidate").html(d.menssage).css("color", "green");
         if (d.data == 0){
            valphone = 0;
            $('.sendcodphone').prop("disabled", false);
            $('.sendvalphone').prop("disabled", false);
            $('#phonevaluser').show();
            $('#codphonever').html('');
            sendcodphoneval();
            $('#valenviartelefono').html('<button type="button" onclick="vericatephone()" class="btn btn-primary btn-user btn-block">Verificar</button>');
          }else{
            valphone = 1;
            $('#phonevaluser').hide();
            $('.sendcodphone').prop("disabled", true);
            $('.sendvalphone').prop("disabled", true);
            $('#phone').removeClass('is-invalid').addClass('is-valid');
            $('#codphonever').html('');
            $('#valenviartelefono').html('<button type="button" id="btn-validate-datos" class="btn btn-primary btn-user btn-block" onclick="validatedatos()">Continuar</button>');
          }
        } else {
          $("#phonevalidate").html(d.menssage).css("color", "green");
          valphone = 1;
        }
      }).fail(function(error){
        $('#load_inv').hide(30);
        console.log(error);
        alert("No se registró, intente nuevamente por favor.");
      });
  }else {
    $("#phonevalidate").html('El numero es invalido').css("color", "#FF0000");
  }
}

var timerUpdate;

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

      timerUpdate = setInterval( () => {
      let t = getRemainingTime(deadline);
      el.innerHTML = `${t.remainMinutes}m:${t.remainSeconds}s`;
      //$('.sendcodphone').prop("disabled", true);
      //$('.sendcallphone').prop("disabled", true);
      if(t.remainTime <= 1) {
        clearInterval(timerUpdate);
        el.innerHTML = '';
        $('.sendcodphone').prop("disabled", false);
        $('#codphonever').html('<button type="button" name="button" class="btn btn-secondary btn-sm sendvalphone" onclick="validatePhone(2)">Llamada</button>');
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

function vericatephone() {
  var codigo = $('#valphone1').val()+''+$('#valphone2').val()+''+$('#valphone3').val()+''+$('#valphone4').val();
  if(codigo.length == 4)
  {
      $.ajax(
        {
          url: "/driver/externo/confir/phone/confirm",
          type:"POST",
          data :{ num : codigo, token_generado:$('#phone').val()},
          dataType: "json",
          beforeSend: function () {
          $('#load_inv').show(30);
          }
        }).done(function(d){
          $('#load_inv').hide(30);
          console.log(d);
          if (d.object=='success'){
            valphone = 1;
            $("#phonevalidate").html(d.menssage).css("color", "green");
            $('#phone').prop("disabled", true);
            $('.sendcodphone').prop("disabled", true);
            $('.sendvalphone').prop("disabled", true);
            clearInterval(timerUpdate);
            document.getElementById('clock').innerHTML = '';
            $('#phone').removeClass('is-invalid').addClass('is-valid');
            $('#valenviartelefono').html('<button type="button" id="btn-validate-datos" class="btn btn-primary btn-user btn-block" onclick="validatedatos()">Continuar</button>');
          } else {
            valphone = 0;
            $("#phonevalidate").html(d.menssage).css("color", "#FF0000");
            $('#phone').prop("disabled", false);
            $('.sendcodphone').prop("disabled", false);
            $('.sendvalphone').prop("disabled", false);
            clearInterval(timerUpdate);
            document.getElementById('clock').innerHTML = '';
            $('#phone').removeClass('is-valid').addClass('is-invalid');
          }
        }).fail(function(error){
          $('#load_inv').hide(30);
          console.log(error);
          alert("intente nuevamente por favor.");
        });
  }else{
      $("#phonevalidate").html("Ingrese un codigo valido").css("color", "#FF0000");
  }
}

var email;
function validateEmail() {
  if ($('#email').val().length > 0){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test($('#email').val().trim())) {
        $.ajax(
        {
          url: "/driver/externo/emailval",
          type:"POST",
          data : { value : $('#email').val().toUpperCase() },
          dataType: "json",
          beforeSend: function () {
          $('#load_inv').show(30);
          }
        }).done(function(d){
          $('#load_inv').hide(30);
          if (d.flag == true){
            $("#emailvalidate").html(d.mensaje).css("color", "#FF0000");
            email = 1;
            $('#email').removeClass('is-valid').addClass('is-invalid');
            valemail = 0;
          }else{
            email = 0;
            validateEmailExits();
          }
        }).fail(function(error){
          $('#load_inv').hide(30);
          console.log(error);
          alert("No se registró, intente nuevamente por favor.");
        });

    } else {
      $("#emailvalidate").html("La dirección de correo no es válida").css("color", "#FF0000");
      email = 1;
      $('#email').removeClass('is-valid').addClass('is-invalid');
    }
  }else{
    $("#emailvalidate").html("Ingresar un correo electronico").css("color", "#FF0000");
    $('#email').removeClass('is-valid').addClass('is-invalid');
  }
}

var valemail;
var contrasenia ="1";
var codigoGene;
function validateEmailExits()
{
  if($('#email').val().length > 0)
  {
    var caracteres = "123456789";
    for (i=0; i<4; i++) contrasenia +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));
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
        if (d.object=='success'){
          $("#emailvalidate").html(d.menssage).css("color", "green");
          if (d.data == 0){
            valemail = 0;
            $('#emailvaluser').show();
            $('.validateEmailv').prop("disabled", false);
            $('#email').prop("disabled", false);
            $('.sendcodemail').prop("disabled", false);
            $('#email').removeClass('is-valid');
            $('#email').removeClass('is-invalid');
            $('#valenviar').html('<button type="button" onclick="vericatemail()" class="btn btn-primary btn-user btn-block">Verificar</button>');
          }else if (d.data == 2){
            valemail = 0;
            $('#emailvaluser').show();
            $('.validateEmailv').prop("disabled", false);
            $('#email').prop("disabled", false);
            $('.sendcodemail').prop("disabled", false);
            $('#email').removeClass('is-valid').addClass('is-invalid');
            $('#valenviar').html('<button type="button" onclick="vericatemail()" class="btn btn-primary btn-user btn-block">Verificar</button>');
            $('#sendverification').html('');
          }else{
            valemail = 1;
            $('#emailvaluser').hide();
            $('.validateEmailv').prop("disabled", true);
            $('#email').prop("disabled", true);
            $('.sendcodemail').prop("disabled", true);
            $('#email').removeClass('is-invalid').addClass('is-valid');
            $('#sendverification').html('');
            $('#valenviar').html('<button type="button" class="btn btn-primary btn-user btn-block" onclick="validatecorreo()">Continuar</button>');
          }
        } else {
          $("#emailvalidate").html(d.menssage).css("color", "#FF0000");
          valemail = 1;
          $('#emailvaluser').show();
        }
      }).fail(function(error){
        $('#load_inv').hide(30);
        console.log(error);
        alert("No se registró, intente nuevamente por favor.");
      });
  }else {
    valemail = 0;
    $('#email').removeClass('is-valid').addClass('is-invalid');
    $("#emailvalidate").html("El correo electronico ya existe o es un correo invalido").css("color", "#FF0000");
  }
}

var valemail;
function vericatemail() {
  var codigoemail = $('#valemail1').val()+''+$('#valemail2').val()+''+$('#valemail3').val()+''+$('#valemail4').val();
  if(codigoemail.length == 4)
  {
    $.ajax(
        {
          url: "/driver/externo/confir/email/confirm",
          type:"POST",
          data :{ num : codigoemail, token_generado: $('#email').val()},
          dataType: "json",
          beforeSend: function () {
          $('#load_inv').show(30);
          }
        }).done(function(d){
          $('#load_inv').hide(30);
          if (d.object=='success'){
            valemail = 1;
            $("#emailvalidate").html(d.menssage).css("color", "green");
            $('#email').prop("disabled", true);
            $('.validateEmailv').prop("disabled", true);
            $('#emailvaluser').show();
            $('.sendcodemail').prop("disabled", true);
            $('#email').removeClass('is-invalid').addClass('is-valid');
            $('#valenviar').html('<button type="button" class="btn btn-primary btn-user btn-block" onclick="validatecorreo()">Continuar</button>');
          } else {
            valemail = 0;
            $("#emailvalidate").html(d.menssage).css("color", "#FF0000");
            $('#email').prop("disabled", false);
            $('.validateEmailv').prop("disabled", false);
            $('#emailvaluser').show();
            $('.sendcodemail').prop("disabled", false);
            $('#email').removeClass('is-valid').addClass('is-invalid');
          }
        }).fail(function(error){
          console.log(error);
          alert("intente nuevamente por favor.");
        });
  }else{
    $("#emailvalidate").html("Ingrese un codigo valido").css("color", "#FF0000");
  }
}

function validatecorreo(){
  $('#form-validate-datos').hide();
  $('#title').html('Verifica tu telefono');
  $('#form-validate-datos2').show();
}


function validatedatos() {
  $('#first_name').prop("disabled", false);
  $('#last_name').prop("disabled", false);
  $('#phone').prop("disabled", false);
  $('#email').prop("disabled", false);
  $('#licencia').prop("disabled", false);
  $('#placa').prop("disabled", false);
  $.ajax(
    {
      url: "/registerdriver",
      type:"POST",
      data :{ users : $('#form-datos').serializeObject(), id_office : idoffice, phone: $('#phone').val(), email: $('#email').val(), user: $('#user').val(),city:city},
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.flag=='true'){
        idfiledrivers = d.id;
        $('#title').html('Subir fotos de documentos');
        $('#form-validate-datos2').hide();
        $('#form-documentos-driver').show();
      }else{
        idfiledrivers = 0;
        alertify.notify(d.mensaje, 'error',2, function(){});
      }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

$("#btn-subir-dni").click(function() {
  $('#title').html('DOCUMENTO DE IDENTIDAD');
  $('#form-documentos-driver').hide();
  $('#form-dni').show();
});

$("#btn-subir-licencia").click(function() {
  $('#form-documentos-driver').hide();
  $('#form-licencia').show();
  $('#title').html('LICENCIA DE CONDUCIR');
});

$("#btn-subir-tarjvehi").click(function() {
  $('#form-documentos-driver').hide();
  $('#form-tarjvehi').show();
  $('#title').html('TARJETA VEHICULAR');
});
$("#btn-subir-soat").click(function() {
  $('#form-documentos-driver').hide();
  $('#form-soat').show();
  $('#title').html('SEGURO VEHICULAR (SOAT/CAT)');
});
$("#btn-subir-atu").click(function() {
  $('#form-documentos-driver').hide();
  $('#form-atu').show();
  $('#title').html('TARJETA UNICA DE CIRCULACION (ATU)');
});

$("#btn-subir-revision").click(function() {
  $('#form-documentos-driver').hide();
  $('#form-revision').show();
  $('#title').html('REVISION TECNICA');
});

$("#btn-subir-externas").click(function() {
  $('#form-documentos-vehicle').hide();
  $('#form-externas').show();
  $('#title').html('FOTOS EXTERNAS');
});

$("#btn-subir-laterales").click(function() {
  $('#form-documentos-vehicle').hide();
  $('#form-laterales').show();
  $('#title').html('FOTOS LATERALES');
});
$("#btn-subir-internas").click(function() {
  $('#form-documentos-vehicle').hide();
  $('#form-internas').show();
  $('#title').html('FOTOS INTERNAS');
});



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

$("#btn-dni").click(function() {
  var dniback = document.getElementById("dni_back");
  var dnifrontal = document.getElementById("dni_frontal");
  if (dniback.files.length < 1 && dnifrontal.files.length < 1){
    alertify.alert('Aun no subido la foto del dni frontal y dni posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#title').html('FOTOS DE DOCUMENTOS');
    $('#form-dni').hide();
    $('#form-documentos-driver').show();
  } else if (dniback.files.length < 1 && dnifrontal.files.length >= 1){
    $('#load_inv').show(30);
    alertify.alert('Aun no ha subido la foto del dni frontal').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    if (dnifrontal.files.length >= 1){
      cc++;
      upimg(idfiledrivers,'dni_frontal','12', '3' ,3,1,'dni');
    }
  }else if (dnifrontal.files.length < 1 && dniback.files.length >= 1){
    alertify.alert('Aun no ha subido la foto del dni posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (dniback.files.length >= 1){
      cc++;
      //dni posterior
      upimg(idfiledrivers,'dni_back','13', '3' ,3,1, 'dni');
    }
  }else{
    $('#load_inv').show(30);
    //dni frontal
    if (dnifrontal.files.length >= 1){
      cc++;
      upimg(idfiledrivers,'dni_frontal','12', '3' ,3,1,'dni');
    }

    if (dniback.files.length >= 1){
      cc++;
      //dni posterior
      upimg(idfiledrivers,'dni_back','13', '3' ,3,1, 'dni');
    }
    $('.valid-dni').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});


$("#btn-licencia").click(function() {
  var licencia_back = document.getElementById("lic_frontal");
  var licencia_frontal = document.getElementById("lic_back");
  if (licencia_back.files.length < 1 && licencia_frontal.files.length < 1){
    alertify.alert('Aun no subido la foto de la licencia frontal y la licencia posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else if (licencia_back.files.length < 1 && licencia_frontal.files.length >= 1){
    alertify.alert('Aun no ha subido la foto de la licencia frontal').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (licencia_frontal.files.length >= 1){
      cc++;
      //dni posterior
      upimg(idfiledrivers,'lic_frontal','1', '3' ,3,1, 'licencia');
    }
  }else if (licencia_frontal.files.length < 1 && licencia_back.files.length >= 1){
    alertify.alert('Aun no ha subido la foto de la licencia posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (licencia_back.files.length >= 1){
      cc++;
      //dni posterior
      upimg(idfiledrivers,'lic_back','2', '3' ,3,1, 'licencia');
    }
  }else{
    $('#load_inv').show(30);
    if (licencia_frontal.files.length >= 1){
      cc++;
      //licencia frontal
      upimg(idfiledrivers,'lic_frontal','1', '3' ,3,1, 'licencia');
    }

    if (licencia_back.files.length >= 1){
      cc++;
      //licencia posterior
      upimg(idfiledrivers,'lic_back','2', '3' ,3,1, 'licencia');
    }
    $('.valid-licencia').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

$("#btn-tarjvehi").click(function() {
  var tarjveh_back = document.getElementById("tarjveh_back");
  var tarjveh_frontal = document.getElementById("tarjveh_frontal");
  if (tarjveh_back.files.length < 1 && tarjveh_frontal.files.length < 1){
    alertify.alert('Aun no subido la foto de la tarjeta vehicular frontal y la tarjeta vehicular posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else if (tarjveh_back.files.length < 1 && tarjveh_frontal.files.length >= 1){
    alertify.alert('Aun no ha subido la foto de la tarjeta vehicular frontal').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (tarjveh_frontal.files.length >= 1){
      cc++;
      //tarjeta vehicular frontal
      upimg(idfiledrivers,'tarjveh_frontal','3', '3' ,3,1, 'tarjvehi');
    }
  }else if (tarjveh_frontal.files.length < 1){
    alertify.alert('Aun no ha subido la foto de la tarjeta vehicular posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (tarjveh_back.files.length >= 1){
      cc++;
      //tarjeta vehicular posterior
      upimg(idfiledrivers,'tarjveh_back','4', '3' ,3,1, 'tarjvehi');
    }
  }else{
    $('#load_inv').show(30);
    if (tarjveh_frontal.files.length >= 1){
      cc++;
      //tarjeta vehicular frontal
      upimg(idfiledrivers,'tarjveh_frontal','3', '3' ,3,1, 'tarjvehi');
    }

    if (tarjveh_back.files.length >= 1){
      cc++;
      //tarjeta vehicular posterior
      upimg(idfiledrivers,'tarjveh_back','4', '3' ,3,1, 'tarjvehi');
    }
    $('.valid-tarjvehi').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

$("#btn-soat").click(function() {
  var soat = document.getElementById("soat_back");
  if (soat.files.length < 1){
    alertify.alert('Aun no ha subido la foto del soat').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else{
    $('#load_inv').show(30);
    if (soat.files.length >= 1){
      cc++;
      //soat
      upimg(idfiledrivers,'soat_back','5', '3' ,3,1, 'soat');
    }
    $('.valid-soat').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

$("#btn-atu").click(function() {
  var atu = document.getElementById("atu_back");
  if (atu.files.length < 1){
    alertify.alert('Aun no ha subido la foto de la tarjeta de circulación').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else{
    $('#load_inv').show(30);
    if (atu.files.length >= 1){
      cc++;
      //atu
      upimg(idfiledrivers,'atu_back','20', '3' ,3,1, 'atu');
    }
    $('.valid-atu').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});


$("#btn-revision").click(function() {
  var revision = document.getElementById("revision");
  if (revision.files.length < 1){
    alertify.alert('Aun no ha subido la foto de la revision tecnica').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else{
    $('#load_inv').show(30);
    if (revision.files.length >= 1){
      cc++;
      //soat
      upimg(idfiledrivers,'revision','7', '3' ,3,1, 'revision');
    }
    $('.valid-revision').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});


$("#btn-externas").click(function() {
  var car_frontal = document.getElementById("car_frontal");
  var car_back = document.getElementById("car_back");
  if (car_back.files.length < 1 && car_frontal.files.length < 1){
    alertify.alert('Aun no subido la foto del vehiculo frontal y la del vehiculo posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else if (car_back.files.length < 1 && car_frontal.files.length >= 1){
    alertify.alert('Aun no ha subido la foto del vehiculo frontal').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (car_frontal.files.length >= 1){
      cc++;
      //carro frontal
      upimg(idfiledrivers,'car_frontal','10','2', 2 ,1, 'externas');
    }
  }else if (car_frontal.files.length < 1 && car_back.files.length >= 1){
    alertify.alert('Aun no ha subido la foto del vehiculo posterior').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (car_back.files.length >= 1){
      cc++;
      //carro posterior
      upimg(idfiledrivers,'car_back','17', '2' , 2 ,1, 'externas');
    }
  }else{
    $('#load_inv').show(30);
    if (car_frontal.files.length >= 1){
      cc++;
      //carro frontal
      upimg(idfiledrivers,'car_frontal','10','2', 2 ,1, 'externas');
    }

    if (car_back.files.length >= 1){
      cc++;
      //carro posterior
      upimg(idfiledrivers,'car_back','17', '2' , 2 ,1, 'externas');
    }
    $('.valid-externas').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});
$("#btn-laterales").click(function() {
  var car_left = document.getElementById("car_left");
  var car_right = document.getElementById("car_right");
  if (car_left.files.length < 1 && car_right.files.length < 1){
    alertify.alert('Aun no subido la foto del vehiculo derecho y la del vehiculo izquierdo').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else if (car_left.files.length < 1 && car_right.files.length >= 1){
    $('#load_inv').show(30);
    alertify.alert('Aun no ha subido la foto del vehiculo derecho').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    if (car_right.files.length >= 1){
      cc++;
      //carro derecha
      upimg(idfiledrivers,'car_right','19', '2' , 2 ,1, 'laterales');
    }
  }else if (car_right.files.length < 1 && car_left.files.length >= 1){
    $('#load_inv').show(30);
    alertify.alert('Aun no ha subido la foto del vehiculo izquierdo').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    if (car_left.files.length >= 1){
      cc++;
      //carro izquierda
      upimg(idfiledrivers,'car_left','18','2', 2 ,1, 'laterales');
    }
  }else{
    $('#load_inv').show(30);
    if (car_left.files.length >= 1){
      cc++;
      //carro izquierda
      upimg(idfiledrivers,'car_left','18','2', 2 ,1, 'laterales');
    }

    if (car_right.files.length >= 1){
      cc++;
      //carro derecha
      upimg(idfiledrivers,'car_right','19', '2' , 2 ,1, 'laterales');
    }
    $('.valid-laterales').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

$("#btn-internas").click(function() {
  var car_passenger = document.getElementById("car_passenger");
  var car_driver = document.getElementById("car_driver");
  if (car_passenger.files.length < 1 && car_driver.files.length < 1){
    alertify.alert('Aun no subido la foto de lado del pasajero y el lado del copiloto').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else if (car_passenger.files.length < 1 && car_driver.files.length >= 1){
    alertify.alert('Aun no ha subido la foto del lado del pasajero').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (car_driver.files.length >= 1){
      cc++;
      //carro interna conductor
      upimg(idfiledrivers,'car_driver','9', '2' , 2 ,1, 'internas');
    }
  }else if (car_driver.files.length < 1 && car_passenger.files.length >= 1){
    alertify.alert('Aun no ha subido la foto del lado del copiloto').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
    $('#load_inv').show(30);
    if (car_passenger.files.length >= 1){
      cc++;
      //carro interna pasajero
      upimg(idfiledrivers,'car_passenger','8','2', 2 ,1, 'internas');
    }
  }else{
    $('#load_inv').show(30);
    if (car_passenger.files.length >= 1){
      cc++;
      //carro interna pasajero
      upimg(idfiledrivers,'car_passenger','8','2', 2 ,1, 'internas');
    }

    if (car_driver.files.length >= 1){
      cc++;
      //carro interna conductor
      upimg(idfiledrivers,'car_driver','9', '2' , 2 ,1, 'internas');
    }
    $('.valid-internas').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

$("#btn-perfil").click(function() {
  var perfil = document.getElementById("perfil");
  if (perfil.files.length < 1){
    alertify.alert('Aun no ha subido la foto de perfil').setHeader('<h5 style="color: orange; font-weight: bold;"> \u26A0 ¡Alerta! </h5>');
  }else{
    $('#load_inv').show(30);
    if (perfil.files.length >= 1){
      cc++;
      //soat
      upimg(idfiledrivers,'perfil','16','4',4,1,'perfil');
    }
    $('.valid-perfil').append('<i style="float: right;" class="text-success fas fa-check"></i>');
  }
});

var cantidadUpdateImg = 0;
var cc = 0;
function upimg(idfiledriver,id,tipo,proceso,codigopro,statusproceso,nameform){
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
        url: "/driverfileSave",
        data : data,
        dataType: "json",
      }).done(function(d){
        respuesta = true;
        console.log('exito '+downloadURL);
        cantidadUpdateImg++;
        //$('#cantidadSubidas').html("");
        //$('#cantidadSubidas').html("Se subieron : "+cantidadUpdateImg+ "");
        if(cantidadUpdateImg>cc)
        {
          //$("#cantidadSubidas").css("background-color", "#FFFF00");
        }
        if(cantidadUpdateImg == cc)
        {
            //$("#cantidadSubidas").css("background-color", "#008000");
            alertify.notify('Excelente, se guardaron las fotos correctamente', 'success', 3, function(){ });
            $('#title').html('FOTOS DE DOCUMENTOS');
            $('#form-'+nameform).hide();

            if (nameform == 'dni'){
              statusdni = 1;
            }

            if (nameform == 'licencia'){
              statuslicencia = 1;
            }
            if (nameform == 'tarjvehi'){
              statustarjevehi = 1;
            }

            if (nameform == 'soat'){
              statusoat = 1;
            }

            if (nameform == 'externas'){
              statusexternas = 1;
            }

            if (nameform == 'laterales'){
              statuslaterales = 1;
            }

            if (nameform == 'internas'){
              statusinternas = 1;
            }

            if (proceso == 3){
              $('#title').html('FOTOS DE DOCUMENTOS');
              $('#form-documentos-driver').show();
            }else if (proceso == 2){
              $('#title').html('FOTOS DEL VEHICULO');
              $('#form-documentos-vehicle').show();
            }else{
              $('#title').html('¡Registro exitoso!');
              $('#form-register').show();
            }

            if (statusdni == 1 && statuslicencia == 1 && statustarjevehi == 1 && statusoat == 1){
              $('#btn-documentos-driver').prop("disabled", false);
            }

            if (statusexternas == 1 && statuslaterales == 1 && statusinternas == 1){
              $('#btn-documentos-vehicle').prop("disabled", false);
            }
            $('#load_inv').hide();
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

$("#btn-documentos-driver").click(function() {
  $('#form-documentos-driver').hide();
  $('#title').html('Subir fotos del auto');
  $('#form-documentos-vehicle').show();
});

$("#btn-documentos-vehicle").click(function() {
   $('#form-documentos-vehicle').hide();
  $('#title').html('Foto de perfil');
  $('#form-perfil').show();
});


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
