$('#divsoat').hide();
$('#divrevtec').hide();
$('#divupdatebtn').hide();
$('#updateview').prop("disabled", true);
$("#divafocat").hide();
$("#myform").hide();
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var soatval;
var revtecval;
var idcustomer;
$(document).on('change', '#licencia', function(event) {
  if ($(this).val().length > 8){
    $.ajax(
    {
      url: "/driver/externo/validate/getbylicence",
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
            soatval = d.valisoat;
            revtecval = d.valirevtec;
            $('#updateview').prop("disabled", true);
      }else{
            alertify.alert(d.mensaje).setHeader('<h3 style="color: green; font-weight: bold;">Correcto</h3>');
            $('#first_name').html(d.customer.first_name);
            $('#last_name').html(d.customer.last_name);
            $('#city').html(d.customer.id_city);
            idcustomer = d.customer.id;
            soatval = d.valisoat;
            revtecval = d.valirevtec;
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
  if (soatval == false && revtecval == false){
    $('#divupdatebtn').hide();
    $('#divupdateview').show();
    $('#textsoat').html('');
    alertify.alert("USUARIO NO TIENE DOCUMENTOS VENCIDOS").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
  }else{
    $('#divupdatebtn').show();
    $('#divupdateview').hide();
    if (soatval == true && revtecval == true){
      soatval = false;
      revtecval = false;
      $("#myform").show();
      $('#divupdatebtn').hide();
      $('#divupdateview').hide();
      $('#divsoat').hide();
      $('#divrevtec').hide();
      $("#div-updatesoat").addClass("fa-caret-right");
      $("#div-updaterevtec").addClass("fa-caret-right");
      $('#divvalsafe').show();
      $('#divvalrevtec').show();
    }else{
     $("#myform").show();
      $('#divupdatebtn').show();
      $('#divupdateview').hide();
      $('#divvalsafe').hide();
      $('#divvalsafe').hide();
      $('#divvalrevtec').hide();
    if (soatval == true){
        $('#divsoat').show();
        $('#textsoat').html('ACTUALIZAR SEGURO');
    }else{
        $('#divsoat').hide();
        $('#textsoat').html('');
    }

    if (revtecval == true){
        $('#divrevtec').show();
    }else{
        $('#divrevtec').hide();
    }
   }
  }
});

$("#updaterevtec").click(function() {
  this.classList.toggle("active");
  var content = this.nextElementSibling;
  if (content.style.maxHeight){
    content.style.maxHeight = null;
    $('#divrevtec').hide();
    revtecval = false;
  } else {
    content.style.maxHeight = content.scrollHeight + "px";
    $('#divrevtec').show();
    $('#divupdatebtn').show();
    revtecval = false;
  }
});

$("#type_safe").change(function(){
  var op = $("#type_safe option:selected").text();
  if(op == 'SOAT'){
    $("#divafocat").hide();
  }else if (op == 'CAT'){
    $("#divafocat").show();
  }else{
    $("#divafocat").hide();
  }
});

$("#updatesoat").click(function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
      $('#divsoat').hide();
      $('#textsoat').html('');
      soatval = false;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
      $('#divsoat').show();
      $('#textsoat').html('ACTUALIZAR SEGURO');
      $('#divupdatebtn').show();
      soatval = true;
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

$("#updatebtn").click(function() {
   var soatfront = document.getElementById("soat-front");
   var revtecfront = document.getElementById("rev-front");

   if (soatval == true && $("#type_safe").val() == "" ){
     alertify.alert("Seleccionar tipo de soat").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (soatval == true && $("#type_safe").val() == "CAT" && $("#company").val() == ""){
     alertify.alert("Ingresar nombre de compañia").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (soatval == true && $("#type_safe").val() == "CAT" && $("#type_soat").val() == ""){
     alertify.alert("Ingresar uso de vehiculo").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (soatval == true && $("#fec_emi_soat").val() == ""){
     alertify.alert("Ingresar fecha de emision del soat").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (soatval == true && $("#fec_ven_soat").val() == ""){
     alertify.alert("Ingresar fecha de vencimiento del soat").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (soatval == true && soatfront.files.length < 1){
     alertify.alert("Ingresar foto frontal del soat").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (revtecval == true && $("#fec_emi_rev").val() == ""){
     alertify.alert("Ingresar fecha de emision de revision tecnica").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (revtecval == true && $("#fec_ven_rev").val() == ""){
     alertify.alert("Ingresar fecha de vencimiento de revision tecnica").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else if (revtecval == true && revtecfront.files.length < 1){
     alertify.alert("Ingresar foto frontal de revision tecnica").setHeader('<h3 style="color: red; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
   }else{
     register();
     $("#updatebtn").prop("disabled", true);
   }
});

function register(){
  $.ajax(
    {
      url: "/driver/update/documents",
      type:"POST",
      data :{ users : $('#myform').serializeObject(), iduser : idcustomer},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
      },
    }).done(function(d)
    {
      var soatfront = document.getElementById("soat-front");
      var revision_ = document.getElementById("rev-front");
      var codigoproceso        = 7;
      var estatusproceso       = 1;

      //soat Frontal
      if(soatfront.files.length >= 1){
        cc++;
        upimg(d.idfile,'soat-front','5', '7' , codigoproceso , estatusproceso);
      }

      //revision tecnica
      if (revision_.files.length >= 1){
        cc++;
        upimg(d.idfile,'rev-front','7', '7' , codigoproceso , estatusproceso);
      }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
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
    alertify.notify('se guardo la imagen', 'success', 3, function(){ });

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
        url: "/driver/externo/filesupdate",
        data : data,
        dataType: "json",
      }).done(function(d){
        respuesta = true
        console.log('exito '+downloadURL);


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
            alertify.notify('Excelente, se actualizo correctamente', 'success', 3, function(){ });
            $("#updatebtn").prop("disabled", false);
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
