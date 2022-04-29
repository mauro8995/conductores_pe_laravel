var codigoproceso        = 4;
var estatusproceso       = 1;

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var driver = false;

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un usuario.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 4);
  }

});

function validarProceso(id_office, idproceso){
  var respuesta;
  $.ajax({
    url: "/driver/externo/validarProceso",
    type:"post",
    data:{id_office:id_office, idproceso: idproceso},
    beforeSend: function () {
      $('#load_inv').show();
    },
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
  }).fail( function() {   alert("Ocurrio un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");   }).always( function() {  });
  return respuesta;
}

var valphone = 0;
var valemail = 0;
function getUser(){
  valor = $('#idoffice').val();
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show();
    }
    }).done(function(d)
    {
      console.log(d);
      $('#load_inv').hide();
      if(d.objet != "error")
      {
          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          if (d.data.first_name == "FALSO"){
            $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" >');
          }else{
            $('#nameuser').html(d.data.first_name);
          }

          if (d.data.last_name == "FALSO"){
            $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" >');

          }else{
            $('#apeuser').html(d.data.last_name);

          }

          if (d.data.phone == "FALSO"){
            $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" >');
          }else{
            $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'">');
          }

          if (d.data.email == "FALSO"){
            $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" >');
          }else{
            $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'">');
          }
          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        if (d.vali == 2){
          alert("El conductor no se encuentra registrado.");
        } else if (d.vali == 3){
          alert("El conductor no se ha registrado en el primer formulario.");
        }

        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
  });
}
var email;
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
          }else if (d.data == 2){
            valemail = 1;
            $('#emailvaluser').attr("style",'display:block;');
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
                  valemail = 1;
                  alert(d.menssage);
                  $('#cod-email').prop("disabled", true);
                  $('#email-user').prop("disabled", true);
                  $('#email-btn').prop("disabled", true);
                }
                else {
                  valemail = 0;
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




var phone;
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
          }else if (d.data == 2){
            valphone = 1;
            $('#phonevaluser').attr("style",'display:block;');
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
        alert("No se registró, intente nuevamente por favor.");
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
                        valphone = 1;
                        alert(d.menssage);
                        $('#cod-phone').prop("disabled", true);
                        $('#phone-user').prop("disabled", true);
                        $('#phone-btn').prop("disabled", true);
                      } else {
                        valphone = 0;
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
    var photoperfil = document.getElementById("photo_perfil");

    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
    }else if (iduser == 0){
      alert('ingrese un ID válido');
    }else  if ($('#phone-user').val() == ""){
      alert('Ingrese un telefono');
    }else if (phone == 1){
      alert('ingrese un telefono valido');
    }else  if ($('#email-user').val() == ""){
      alert('Ingrese un correo');
    }else if (email == 1){
      alert('ingrese un correo valido');
    }else if (photoperfil.files.length < 1){
      alert('Seleccione una foto de perfil');
    }else{
      register();
    }
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

function register(){
  $('#email-user').prop("disabled", false);
  $('#phone-user').prop("disabled", false);
  $.ajax(
    {
      url: "/users/exeterno/perfilSave",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show();
    }
    }).done(function(d)
    {
          $('#load_inv').hide();
          upimg(d.idfile,'photo_perfil','16','4', codigoproceso , estatusproceso);
          $('#idoffice').val("");
          $('#nameuser').html("");
          $('#apeuser').html("");
          $('#phoneuser').html("");
          $('#emailuser').html("");
          $('#photo_perfil').val("");
          $('#phonevaluser').html("");
          $('#emailvaluser').html("");
          $("#photo_perfil_img").attr('src', '/imagenes/perfil_img.png' );

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
  var uploadTask = storageRef.child('conductores_co/desarrollo/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
  $('#load_inv').show();
  if (progress == 100){
    alertify.notify('Se guardó la imágen correctamente', 'success', 3, function(){ });
    $('#load_inv').hide();
  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.');
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
        return  1;
      }).fail(function(error){
        console.log('No se enlaso la imagen con el ticket '+error);
        alert("No se enlazó la imágen, por favor intente de nuevo, si el problema persiste, por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
        return  2;
      });
      });
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
