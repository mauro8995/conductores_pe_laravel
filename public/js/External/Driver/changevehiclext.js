$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var idcustomer;
$("#myform").hide();
$('#updateview').prop("disabled", true);
$("#divafocat").hide();
$("#year").select2();
$(document).on('change', '#licencia', function(event) {
  if ($(this).val().length > 8){
    $.ajax(
    {
      url: "/driver/externo/validate/getDriver",
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
            idcustomer = 0;
            $('#updateview').prop("disabled", true);
      }else{
            alertify.alert(d.mensaje).setHeader('<h3 style="color: green; font-weight: bold;">Correcto</h3>');
            $('#first_name').html(d.customer.first_name);
            $('#last_name').html(d.customer.last_name);
            $('#city').html(d.customer.id_city);
            idcustomer = d.customer.id;
            $('#updateview').prop("disabled", false);
      }
    }).fail(function(error){
      console.log(error);
      $('#load_inv').hide(30);
      alert("No se registró, intente nuevamente por favor.");
    });
  }else{
    alert("Ingresar una licencia correcta");
  }
});

$("#updateview").click(function() {
  if (idcustomer == 0){
    $('#myform').hide();
    $('#divupdatebtn').hide();
    $('#divupdateview').show();
    alertify.alert("USUARIO NO TIENE REGISTRO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
  }else{
    alertify.confirm('Confirmar', 'Tipo se Seguro', function(){
               $("#type_safe").val("SOAT");
               $("#divafocat").show();
               typesafe = 0;
    }, function(){
               $("#type_safe").val("CAT");
               $("#divafocat").show();
               typesafe = 1;
    }).set('labels', {ok:'SOAT', cancel:'CAT'});
    $('#myform').show();
    $('#divupdatebtn').show();
    $('#divupdateview').hide();
  }
});

function validateFileType(id){
    var fileName = document.getElementById(id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
      $("#div_"+id).html("<span style='color: green; font-size: 30px;' class='fa fa-check-circle'></span>");
    }else{
      alert("Solo se aceptan imagenes");
      $('#'+id).val("");
      $("#div_"+id).html("<span style='color: red; font-size: 30px;' class='fa fa-times-circle'></span>");
    }
}

var placa;
$(document).on('change', '#placa', function(event) {
  var val = $("#placa").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/validate/placavalexi",
      type:"POST",
      data : { value : val },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(30);
      }
    }).done(function(d){
          $('#load_inv').hide(30);
          console.log(d);
          if (d.flag == true){
            alert(d.mensaje);
            placa = 1;
          }else{
            placa = 0;
          }
    }).fail(function(error){
      $('#load_inv').hide(30);
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});
var revtecnica;
var moreauto;
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

    if (op != 'SELECCIONAR' && numye >= 6) {
      $('.divcarro').attr("style",'display:block;');
      moreauto = 1;
    }else{
      moreauto = 1;
      $('.divcarro').attr("style",'display:block;');
    }
});

$("#updatebtn").click(function() {

  var tarjefront = document.getElementById("tarj-vehi-front");
  var tarjepost  = document.getElementById("tarj-vehi-back");
  var soatfront  = document.getElementById("soat-front");
  var revtec     = document.getElementById("rev-front");
  var carinter1  = document.getElementById("carinterna1");
  var carinter2  = document.getElementById("carinterna2");
  var carexter1  = document.getElementById("carexterna1");
  var carexter2  = document.getElementById("carexterna2");
  var carexter3  = document.getElementById("carexterna3");
  var carexter4  = document.getElementById("carexterna4");

  if (idcustomer == 0) {
    alert('ingrese un usuario valido');
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
  }else if (tarjefront.files.length < 1){
    alert('Seleccione una tarjeta vehicular frontal');
  }else if (tarjepost.files.length < 1){
    alert('Seleccione una tarjeta vehicular posterior');
  } else  if ($('#tarj-vehi-fec-emi').val() == ""){
    alert('ingrese una fecha de emision');
    $("#tarj-vehi-fec-emi").focus();
  } else  if (typesafe == 1 && $('#company').val() == ""){
    alert('ingrese una compañia');
    $("#company").focus();
  } else  if (typesafe == 1 && $('#type-use').val() == ""){
    alert('ingrese un tipo de uso');
    $("#type-use").focus();
  } else  if ($('#safe-fec-emi').val() == ""){
    alert('ingrese una fecha de inicio');
    $("#safe-fec-emi").focus();
  } else  if ($('#safe-fec-ven').val() == ""){
    alert('ingrese una fecha de fin');
    $("#safe-fec-ven").focus();
  }else if (soatfront.files.length < 1){
    alert('Seleccione un soat frontal');
  }else if (revtecnica == 1 && revtec.files.length < 1){
    alert('Seleccione una revision tecnica');
  } else  if (revtecnica == 1 && $('#fec_emi_rev').val() == ""){
    alert('ingrese una revision de fecha de emision');
    $("#fec_emi_rev").focus();
  } else  if (revtecnica == 1 && $('#fec_ven_rev').val() == ""){
    alert('ingrese una revision de fecha de vencimiento');
    $("#fec_ven_rev").focus();
  }else if (carinter1.files.length < 1){
    alert('Seleccione un foto del asiento del conductor');
  }else if (carinter2.files.length < 1){
    alert('Seleccione un foto del asiento del pasajero');
  }else if (carexter1.files.length < 1){
    alert('Seleccione un foto de la parte delantera del auto');
  } else  if (moreauto == 1 && carexter2.files.length < 1){
    alert('Seleccione un foto del lado derecho del auto');
  } else  if (moreauto == 1 && carexter3.files.length < 1){
    alert('Seleccione un foto del lado izquierdo del auto');
  } else  if (moreauto == 1 && carexter4.files.length < 1){
    alert('Seleccione un foto del parte trasera del auto');
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
      url: "/driver/validate/updateauto",
      type:"POST",
      data :{ users : $('#myform').serializeObject(), idcustomer : idcustomer},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
            },
    }).done(function(d)
    {

      var tarjefront = document.getElementById("tarj-vehi-front");
      var tarjepost  = document.getElementById("tarj-vehi-back");
      var soatfront  = document.getElementById("soat-front");
      var revtec     = document.getElementById("rev-front");
      var carinter1  = document.getElementById("carinterna1");
      var carinter2  = document.getElementById("carinterna2");
      var carexter1  = document.getElementById("carexterna1");
      var carexter2  = document.getElementById("carexterna2");
      var carexter3  = document.getElementById("carexterna3");
      var carexter4  = document.getElementById("carexterna4");

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
        upimg(d.idfile,'rev-front','7', '6' , codigoproceso , estatusproceso);
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

      if (carexter2.files.length >= 1){
        cc++;
        //2da foto car_externa
        upimg(d.idfile,'carexterna2','17', '6' , codigoproceso , estatusproceso);
      }

      if (carexter3.files.length >= 1){
        cc++;
        //3ra foto car_externa
        upimg(d.idfile,'carexterna2','18', '6' , codigoproceso , estatusproceso);
      }

      if (carexter4.files.length >= 1){
        cc++;
        //3ra foto car_externa
        upimg(d.idfile,'carexterna2','19', '6' , codigoproceso , estatusproceso);
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
              url: "/driver/externo/filesupdate",
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
