$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
iduser = 0;
$('#divrevtecnica').attr("style",'display:none;');
$('#divseguro').attr("style",'display:none;');
revtecnica = 0;
typesafe = 0;
$("#year").select2();

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un ID.");
    $('#idoffice').css("border", "2px solid red");
  } else  {
    validarProceso($("#idoffice").val(), 3);
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
    },
  }).done( function(d) {
    $('#load_inv').hide(300);
    respuesta = d;
    if (respuesta == 'true'){
      alert("El ID Oficina todavia no pasa por este proceso!");
    }else if (respuesta == 'false'){
      alert("El ID Oficina no existe!");
    }else{
      getUser();
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  return respuesta;
}


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
          iduser = d.file.id;
          $('.customer-data-hide').hide();
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'" >');
          $('#dniuser').html('<input type="text" class="form-control" id="dni-user" name="dni-user" value="'+d.data.dni+'">');
          $('#name-user').prop("disabled", true);
          $('#ape-user').prop("disabled", true);
          //$('#btn_search').prop("disabled", true);
      } else {
          iduser = 0;
          $('#btn_search').attr("disabled", false);
          $('#idoffice').val("");
          $('#nameuser').html("");
          $('#apeuser').html("");
          $('#yearfile').html('');
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

$(document).on('change', '#placa', function(event) {
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
          }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});

$("#year").change(function(){

    var fecha = new Date();
    var ano = fecha.getFullYear();
    var op = $("#year option:selected").text();
    var numye = (ano - op);

    if (op != 'SELECCIONAR' && numye >= 4) {
      $('#divrevtecnica').attr("style",'display:block;');
      revtecnica = 1;
    }else{
      revtecnica = 0;
      $('#divrevtecnica').attr("style",'display:none;');
    }
});

$("#type-safe").change(function(){
    var op = $("#type-safe option:selected").text();

    if (op != 'SELECCIONAR' && op == 'CAT') {
      $('#divseguro').attr("style",'display:block;');
      typesafe = 1;
    }else{
      typesafe = 0;
      $('#divseguro').attr("style",'display:none;');
    }
});


function validateFileType(id){
    var fileName = document.getElementById(id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
    }else{
      alert("Solo se aceptan imágenes");
      $('#'+id).val("");
    }
}


$("#btn_ajax").click(function() {


  var tarjefront = document.getElementById("tarj-vehi-front");
  var tarjepost  = document.getElementById("tarj-vehi-back");
  var soatfront  = document.getElementById("soat-front");
  var revtec  = document.getElementById("revision_tecnica");
  var carinter1  = document.getElementById("carinterna1");
  var carinter2  = document.getElementById("carinterna2");
  var carexter1  = document.getElementById("carexterna1");

  if ($('#idoffice').val() == ""){
    alert('ingrese un id');
    $("#idoffice").focus();
  }else if (iduser == 0) {
    alert('ingrese un id valido');
    $("#idoffice").focus();
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
  } else  if ($('#color').val() == ""){
    alert('ingrese un color de auto');
    $("#color").focus();
  } else  if ($('#brand').val() == ""){
    alert('ingrese una marca');
    $("#brand").focus();
  } else  if ($('#model').val() == ""){
    alert('ingrese un modelo');
    $("#model").focus();
  } else  if ($('#status').val() == ""){
    alert('ingrese un estado');
    $("#status").focus();
  }else if (tarjefront.files.length < 1){
    alert('Seleccione una tarjeta vehicular frontal');
  }else if (tarjepost.files.length < 1){
    alert('Seleccione una tarjeta vehicular posterior');
  } else  if ($('#tarj-vehi-fec-emi').val() == ""){
    alert('ingrese una fecha de emision');
    $("#tarj-vehi-fec-emi").focus();
  }else  if ($("#type-safe option:selected").text() == "SELECCIONAR"){
    alert('seleccione un tipo de seguro');
    $("#type-safe").focus();
  } else  if (typesafe == 1 && $('#company').val() == ""){
    alert('ingrese una compañia');
    $("#company").focus();
  } else  if (typesafe == 1 && $('#status-safe').val() == ""){
    alert('ingrese una compañia');
    $("#status-safe").focus();
  } else  if (typesafe == 1 && $('#nro-poliza').val() == ""){
    alert('ingrese una compañia');
    $("#nro-poliza").focus();
  } else  if (typesafe == 1 && $('#type-use').val() == ""){
    alert('ingrese un tipo de uso');
    $("#type-use").focus();
  } else  if (typesafe == 1 && $('#safe-fec-emi').val() == ""){
    alert('ingrese una fecha de inicio');
    $("#safe-fec-emi").focus();
  } else  if (typesafe == 1 && $('#safe-fec-ven').val() == ""){
    alert('ingrese una fecha de fin');
    $("#safe-fec-ven").focus();
  }else if (soatfront.files.length < 1){
    alert('Seleccione un soat frontal');
  }else if (revtecnica == 1 && revtec.files.length < 1){
    alert('Seleccione una revision tecnica');
  } else  if (revtecnica == 1 && $('#rev-fec-emi').val() == ""){
    alert('ingrese una revision de fecha de emision');
    $("#rev-fec-emi").focus();
  } else  if (revtecnica == 1 && $('#rev-fec-ven').val() == ""){
    alert('ingrese una revision de fecha de vencimiento');
    $("#rev-fec-ven").focus();
  }else if (carinter1.files.length < 1){
    alert('Seleccione un foto del auto interna');
  }else if (carinter2.files.length < 1){
    alert('Seleccione un foto del auto interna');
  }else if (carexter1.files.length < 1){
    alert('Seleccione un foto del auto frontal');
  }else{
    register();
  }
});

var cantidadUpdateImg = 0;
var cc = 0;
var codigoproceso        = 2;
var estatusproceso       = 1;

function register(){
  $.ajax(
    {
      url: "/driver/updateauto",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), idfile : iduser},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
            },
    }).done(function(d)
    {

      var tarjefront = document.getElementById("tarj-vehi-front");
      var tarjepost  = document.getElementById("tarj-vehi-back");
      var soatfront  = document.getElementById("soat-front");
      var revtec  = document.getElementById("revision_tecnica");
      var carinter1  = document.getElementById("carinterna1");
      var carinter2  = document.getElementById("carinterna2");
      var carexter1  = document.getElementById("carexterna1");

      //tarjeta vehicular frontal
      if(tarjefront.files.length >= 1){
        cc++;
        upimg(d.idfile,'tarj-vehi-front','3', '6' , codigoproceso , estatusproceso);
      }

      //tarjeta vehicular posterior
      if(tarjepost.files.length >= 1){
        cc++;
        upimg(d.idfile,'tarj-vehi-back','4', '6' , codigoproceso , estatusproceso);
      }

      //soat Frontal
      if(soatfront.files.length >= 1){
        cc++;
        upimg(d.idfile,'soat-front','5', '6' , codigoproceso , estatusproceso);
      }


      //soat posterior
      if (revtec.files.length >= 1){
        //revision tecnica
        cc++;
        upimg(d.idfile,'revision_tecnica','7', '6' , codigoproceso , estatusproceso);
      }

      if (carinter1.files.length >= 1){
        cc++;
        //1 foto car_interna
        upimg(d.idfile,'carinterna1','8', '6' , codigoproceso , estatusproceso);
      }

      if (carinter2.files.length >= 1){
        cc++;
        //2 foto car_interna
        upimg(d.idfile,'carinterna2','9', '6' , codigoproceso , estatusproceso);
      }

      if (carexter1.files.length >= 1){
        cc++;
        //1ra foto car_externa
        upimg(d.idfile,'carexterna1','10', '6' , codigoproceso , estatusproceso);
      }


    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

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
     alertify.notify('se guardo la imagen', 'success', 3, function(){ });

   }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net'+error);
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
              console.log('exito '+downloadURL);

              cantidadUpdateImg++;
              $('#cantidadSubidas').html("");
              $('#cantidadSubidas').html("Se subieron : "+cantidadUpdateImg+ "");
              if(cantidadUpdateImg>3)
              {
                $("#cantidadSubidas").css("background-color", "#FFFF00");
              }
              if(cantidadUpdateImg == cc)
              {
                $("#cantidadSubidas").css("background-color", "#008000");
                  alert("Excelente, se registro correctamente.");
                  $('#load_inv').hide();
                  location.reload();
              }

            }).fail(function(error){
              console.log('No se enlaso la imagen con el ticket '+error);
              alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net"+error);
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
