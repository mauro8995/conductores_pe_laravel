var idoffice = 0;
var idofficenew = 0;
$('#first_name').prop("disabled", true);
$('#last_name').prop("disabled", true);
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


$(document).on('blur', '#idofficenew', function(event) {
  valor = $('#idofficenew').val();
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
        idofficenew = 0;
        $('#btn_ajax').attr("disabled", false);
        alert("EL USUARIO ESTA DISPONIBLE.");
        
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
  }else if ($("#idofficenew").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE NUEVO USUARIO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#idofficenew").focus();
  }else if (idofficenew == 1){
    alertify.alert("EL USUARIO YA ESTA REGISTRADO").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#idofficenew").focus();
  }else{
    register();
  }
});

function register(){
  var idofficenews = $("#idofficenew").val();
  $.ajax(
    {
      url: "/users/externo/updateidofficeDriver",
      type:"POST",
      data :{ idofficenew : idofficenews, idofficeact : idoffice},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide();
      if (d.object == "success"){
        $('#idofficenew').val("");
        $('#idoffice').val("");
        $('#first_name').val("");
        $('#last_name').val("");
        idoffice = 0;
        idofficenew = 0;
        alertify.alert(d.message).setHeader('<h3 style="color: green; font-weight: bold;"> \u2713 ¡Exito! </h3>');
      }else{
        alertify.alert(d.message).setHeader('<h3 style="color: red; font-weight: bold;"> \u2715 Error! </h3>');
      }


    }).fail(function(error){
      console.log(error);
      alertify.alert("No se registró, intente nuevamente por favor.").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    });

}
