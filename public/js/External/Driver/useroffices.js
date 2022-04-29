var codigoproceso        = 3;
var estatusproceso       = 1;
var placa;
var idoffice = 0;
var dni = 0;
var phone = 0;
var email = 0;
var licence = 0;
var tipoid = 0;
$('#btn_ajax').prop("disabled", true);
$('.numid').attr("style",'display:none;');
$('.numtipdoc').attr("style",'display:none;');
$('#phone').prop("maxlength", 9);
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
var city;
function selectcity(el){ // recibimos por parametro el elemento select
   // obtenemos la opción seleccionada .
  city = $('option:selected', el).attr('data-city');
}

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });


$("#tipdocid").change(function(){
    $('#dni').val("");
    $('#first_name').prop("disabled", false);
    $('#last_name').prop("disabled", false);
    $('#datebirth').prop("disabled", false);
    $('#first_name').val('');
    $('#last_name').val('');
    $('#datebirth').val('');
    var op = $("#tipdocid option:selected").text();
    if(op == 'DNI'){
      $('.numid').attr("style",'display:block;');
      $('#btn_search').attr("style",'display:block;');
      $('.numtipdoc').attr("style",'display:block;');
      tipoid = 1;
    }else if (op != 'DNI' && op != 'SELECCIONAR') {
      $('.numid').attr("style",'display:block;');
      $('#btn_search').attr("style",'display:block;');
      $('.numtipdoc').attr("style",'display:block;');
      tipoid = 0;
    }else{
      $('.numid').attr("style",'display:none;');
      tipoid = 0;
    }
});

$("#placa").change(function(){
    val = $('#placa').val();
    $.ajax(
    {
      url: "/driver/externo/placaval",
      type:"POST",
      data : { value : val },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.flag == false){
        alert(d.mensaje);
        placa = 0;
      }else{
        alert(d.mensaje);
        placa = 1;
      }
      $('#btn_ajax').prop("disabled", false);
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
});

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
     alertify.notify(d.menssage,d.object,5, function(){});
     if (d.object == "success"){
       if (d.data.nrolicencia != null){
        $("#licence").val(d.data.nrolicencia);
       }
      licence = 0;
    }else{
      licence = 1;
    }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}

$(document).on('change', '#idoffice', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/officeval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
      $('#load_inv').show(30);
    },
  }).done(function(d){
      $('#load_inv').hide(30);
    console.log(d);
    if (d.flag == true){
          alertify.alert(d.mensaje).setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
          idoffice = 1;
    }else{
          alertify.alert(d.mensaje).setHeader('<h3 style="color: green; font-weight: bold;">Correcto</h3>');
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
    }
  }).fail(function(error){
    console.log(error);
    $('#load_inv').hide(30);
    alert("No se registró, intente nuevamente por favor.");
  });
}
});

$(document).on('keypress', '#sponsor', function(event) {
    if (event.keyCode == 32){
        event.preventDefault();
        return false;
    }
});

$(document).on('change', '#dni', function(event) {
  valnumid = $("#dni").val();
  tipdocids = $("#tipdocid option:selected").val();
  if (tipoid == 0 && valnumid != ""){
    $.ajax(
    {
      url: "/driver/externo/dnival",
      type:"POST",
      data : { value : valnumid , tipdoc : tipdocids},
      dataType: "json",
    }).done(function(d){
      if (d.flag == true){
        alertify.alert(d.mensaje).setHeader('<h3 style="color: green; font-weight: bold;"> \u26A0 ¡Correcto! </h3>');
        dni = 1;
      }else{
        dni = 0;
      }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});


function validatePhone(vari) {
  if ($('#phone').val().length == 9){
    alertify.confirm('vamos a verificar el numero de telefono', '+51 ('+$('#phone').val()+') <br> ¿es correcto o quieres modificarlo?', function(){
    $.ajax(
    {
      url: "/driver/externo/phoneval",
      type:"POST",
      data : { value : $('#phone').val() },
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
    }, function(){ $('#phone').focus(); }).set('labels', {ok:'Correcto', cancel:'Editar'});
  }else{
    alert("Ingresar numero de telefono.");
  }
}

var codigoGenePhone;
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
          alert(d.menssage);
          if (d.data == 0){
            valphone = 0;
            $('#phonevaluser').attr("style",'display:block;');
            sendcodphoneval();
            $('.sendcodphone').prop("disabled", false);
          }else{
            valphone = 1;
            $('#phonevaluser').attr("style",'display:none;');
            $('.sendcodphone').prop("disabled", true);
          }
        } else {
          alert(d.menssage);
          valphone = 1;
        }
      }).fail(function(error){
        console.log(error);
        alert("No se registró, intente nuevamente por favor.");
      });

  }else {
    alert('ES UN NUMERO INVALIDO.');
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
        alert('La dirección de correo no es válida');
        email = 1;
    }
  }else{
    alert('Ingresar un correo electronico');
  }
}

var contrasenia ="1";
var codigoGene;
var valemail;
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
        if (d.object=='success'){
          alert(d.menssage);
          if (d.data == 0){
            valemail = 0;
            $('#emailvaluser').attr("style",'display:block;');
            $('.validateEmailv').prop("disabled", false);
          }else if (d.data == 2){
            valemail = 0;
            $('#emailvaluser').attr("style",'display:block;');
            $('.validateEmailv').prop("disabled", false);
          }else{
            valemail = 1;
            $('#emailvaluser').attr("style",'display:none;');
            $('.validateEmailv').prop("disabled", true);
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


$(document).on('keyup', '#dni', function(event) {
  if(event.keyCode == 8){
    $("#first_name").val("");
    $("#last_name").val("");
  }
});



$("#btn_ajax").click(function() {
  if ($("#idoffice").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE ID OFICINA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#idoffice").focus();
  }else if (idoffice == 1){
    alertify.alert("EL USUARIO YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#idoffice").focus();
  }else if ($("#sponsor").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE SPONSOR").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#sponsor").focus();
  }else if (/\s/.test($("#sponsor").val())){
    alertify.alert("EL USUARIO DEL SPONSOR TIENE ESPACIOS").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#sponsor").focus();
  }else if ($("#tipdocid option:selected").text() == "SELECCIONAR"){
    alertify.alert("SELECCIONAR TIPO DE DOCUMENTO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#tipdocid").focus();
  }else if ($("#dni").val() == ''){
    alertify.alert("COMPLETE NUMERO DE DOCUMENTO DE IDENTIDAD").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#dni").focus();
  }else if (dni == 1){
    alertify.alert("EL DNI YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#dni").focus();
  }else if ($("#first_name").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE NOMBRES").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#first_name").focus();
  }else if ($("#last_name").val() == '') {
    alertify.alert("COMPLETE CAMPOS DE APELLIDOS").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#last_name").focus();
  }else  if (tipoid != 1 && $("#datebirth").val() == ""){
    alert('ingrese una fecha de nacimiento');
    $("#datebirth").focus();
  }else  if (tipoid != 1 && $("#datebirth").val() > today){
    alert("tiene que ser mayor de edad");
    $("#datebirth").focus();
  }else if ($("#provincia option:selected").text() == "SELECCIONAR"){
    alertify.alert("SELECCIONAR PROVINCIA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#provincia").focus();
  }else if ($("#district").val() == ""){
    alertify.alert("COMPLETE CAMPOS DE DIRECCION").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#district").focus();
  }else if  ($("#phone").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE TELEFONO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#phone").focus();
  }else if (phone == 1){
    alertify.alert("EL TELEFONO YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#phone").focus();
  }else if (valphone == 0){
    alertify.alert("¡ERROR! INGRESE UN CODIGO DE TELEFONO VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#cod-phone").focus();
  }else if  ($("#email").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE CORREO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#email").focus();
  }else if (email == 1){
    alertify.alert("EL CORREO YA EXISTE O ES UN CORREO INVALIDO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#email").focus();
  }else if (valemail == 0){
    alertify.alert("¡ERROR! INGRESE UN CODIGO DE EMAIL VALIDO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#cod-email").focus();
  }else if  ($("#licence").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE LICENCIA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#licence").focus();
  }else if (licence == 1){
    alertify.alert("LA LICENCIA YA EXISTE O ES INCORRECTA").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#licence").focus();
  }else if  ($("#placa").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE PLACA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#placa").focus();
  }else if (placa == 1){
    alertify.alert("LA PLACA YA EXISTE O ES INCORRECTA").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#placa").focus();
  }else{
    register();
  }
});

function validatedni(val){
  tipdocids = $("#tipdocid option:selected").val();
  $.ajax(
  {
    url: "/driver/externo/dnival",
    type:"POST",
    data : { value : val, tipdoc : tipdocids },
    dataType: "json",
  }).done(function(d){
    if (d.flag == true){
      dni = 1;
      alert(d.mensaje);
    }else{
      dni = 0;
      getValDNI(val);
    }
    console.log(d.flag);
    console.log(dni);
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}

$( "#btn_search" ).click(function() {
  var d = $('#dni').val();
  validatedni(d);
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
        $('#load_inv').hide(30);
        alertify.alert('<h2 style="font-weight: bold;">'+d.data.message+'</h2>').setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡ADVERTENCIA! </h3>');
        $('#first_name').val(d.data.first_name);
        $('#last_name').val(d.data.last_name);
        $('#datebirth').val(d.data.date_birth);
        if (d.data.object == true){
          $('#first_name').prop("disabled", true);
          $('#last_name').prop("disabled", true);
          $('#datebirth').prop("disabled", true);
        }else{
          $('#first_name').prop("disabled", false);
          $('#last_name').prop("disabled", false);
          $('#datebirth').prop("disabled", false);
        }
        validatelicencia();
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
    }else{
      alertify.notify('COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS', 'success',2, function(){});
      $('#first_name').prop("disabled", false);
      $('#last_name').prop("disabled", false);
      $('#load_inv').hide(30);
    }
}




function register(){
  $('#first_name').prop("disabled", false);
  $('#last_name').prop("disabled", false);
  $('#phone').prop("disabled", false);
  $('#email').prop("disabled", false);
  $('#datebirth').prop("disabled", false);
  $.ajax(
    {
      url: "/conductores/oficinaRegister",
      type:"POST",
      data :{ users : $('#formuseroffices').serializeObject(), id_office : idoffice, city : city},
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.flag=='true'){
        alertify.notify(d.mensaje, 'success',2, function(){});
        location.reload(true);
      }else{
        alertify.notify(d.mensaje, 'error',2, function(){});
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




function validateCodigoEmail(){
        if($('#cod-email').val().length == 4)
        {
          $.ajax(
              {
                url: "/driver/externo/confir/email/confirm",
                type:"POST",
                data :{ num : $('#cod-email').val(), token_generado: $('#email').val()},
                dataType: "json",
                beforeSend: function () {
                $('#load_inv').show(30);
                }
              }).done(function(d){
                $('#load_inv').hide(30);
                if (d.object=='success'){
                  valemail = 1;
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", true);
                  $('#email').prop("disabled", true);
                  $('#clock').html('');
                } else {
                  valemail = 0;
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
                        valphone = 1;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", true);
                        $('#phone').prop("disabled", true);
                        $('#valphonex').prop("disabled", true);
                        $('#sendvalphone').prop("disabled", true);
                      } else {
                        valphone = 0;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", false);
                        $('#phone').prop("disabled", false);
                        $('#valphonex').prop("disabled", false);
                        $('#sendvalphone').prop("disabled", true);
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
