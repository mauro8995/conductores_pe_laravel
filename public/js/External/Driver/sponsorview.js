var idoffice = 0;
var iduser = 0;
$('#first_name').prop("disabled", true);
$('#last_name').prop("disabled", true);
$('#first_name_inv').prop("disabled", true);
$('#last_name_inv').prop("disabled", true);
$('#btn_ajax').attr("disabled", true);

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).on('blur', '#idoffice', function(event) {
  valor = $('#idoffice').val();
  if ($(this).val().length > 0){
    $.ajax(
      {
        url: "/users/exeterno/id/validateUserOffice",
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
          idoffice = d.data.id;
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#btn_ajax').attr("disabled", false);
        } else {
          idoffice = 0;
          $('#btn_ajax').attr("disabled", true);
          $('#idoffice').val("");
          $('#first_name').val("");
          $('#last_name').val("");
          alert("EL USUARIO NO ESTA REGISTRADO.");
        }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });
  }
});

$(document).on('blur', '#sponsor', function(event) {
  valor = $('#sponsor').val();
  if ($(this).val().length > 0){
    $.ajax(
      {
        url: "/users/exeterno/id/validateUser",
        type:"POST",
        data : { user : valor },
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(300);
      }
      }).done(function(d)
      {
        $('#load_inv').hide(300);
        if(d.objet != "error")
        {
          iduser = d.data.id;
          $('#first_name_inv').val(d.data.name);
          $('#last_name_inv').val(d.data.lastname);
          $('#btn_ajax').attr("disabled", false);
        } else {
          iduser = 0;
          $('#btn_ajax').attr("disabled", true);
          $('#sponsor').val("");
          $('#first_name_inv').val("");
          $('#last_name_inv').val("");
          alert("EL USUARIO NO ESTA REGISTRADO.");
        }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });
  }
});

$("#btn_ajax").click(function() {
  if ($("#idoffice").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE USUARIO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#idoffice").focus();
  }else if (idoffice == 0){
    alertify.alert("EL USUARIO NO ESTA REGISTRADO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#idoffice").focus();
  }else if ($("#sponsor").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE SPONSOR").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#sponsor").focus();
  }else if (iduser == 0){
    alertify.alert("EL USUARIO NO ESTA REGISTRADO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#sponsor").focus();
  }else{
    register();
  }
});


function register(){
  $.ajax(
    {
      url: "/users/externo/updateSponsorDriver",
      type:"POST",
      data :{ iduser : iduser, idoffice : idoffice},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide();
      $('#sponsor').val("");
      $('#first_name_inv').val("");
      $('#last_name_inv').val("");
      $('#idoffice').val("");
      $('#first_name').val("");
      $('#last_name').val("");
      idoffice = 0;
      iduser = 0;
      alertify.alert(d.message).setHeader('<h3 style="color: green; font-weight: bold;"> \u2713 ¡Exito! </h3>');
    }).fail(function(error){
      console.log(error);
      alertify.alert("No se registró, intente nuevamente por favor.").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    });

}
