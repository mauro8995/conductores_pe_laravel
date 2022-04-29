$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function registerticketfreshdesk(yourdomain,api_key)
{
      var prioridad;
      if ($('#tipo').val() == 'Peticion'){
          prioridad = 4;
      }else{
          prioridad = 3;
      }
// console.log($('#group_id').val());

// Ref: https://support.freshdesk.com/support/solutions/articles/215517-how-to-find-your-api-key
    var formdata = new FormData();
      formdata.append('email', $('#email').val());
      formdata.append('name', $('#name').val());
      formdata.append('subject', $('#subject').val());
      formdata.append('priority', prioridad);
      formdata.append('status', '2');
      if ($('#myFile').val() != "") {
        var array=[];

        for (var i = 0; i < $('#myFile')[0].files.length; i++) {
          formdata.append('attachments[]',$('#myFile')[0].files[i]);
        }

      }
      formdata.append('type', $('#tipo').val());
      formdata.append('source', '2');
      formdata.append('group_id', $('#group_id').val());
      formdata.append('phone', '+'+$('#prefpais').val()+$('#telefono').val());
      formdata.append('description', $('#description').val()+'<br><br><br>'+"Nombre Completo: "+$('#name').val()+'<br>'+"Numero Telefonico: "+'+'+$('#prefpais').text()+$('#telefono').val());
    $.ajax(
          {
            url: "https://"+yourdomain+".freshdesk.com/api/v2/tickets",
            type: 'POST',
            contentType: false,
            processData: false,
            headers: {
              "Authorization": "Basic " + btoa(api_key + ":x")
            },
            data: formdata,
            success: function(data, textStatus, jqXHR) {
              $('#load_inv').hide(30);
              $('#result').text('Success');
              $('#code').text(jqXHR.status);
              $('#response').html(JSON.stringify(data, null, "<br/>"));
              alert('El ticket ya fue enviado');
              alertify.success('EL TICKET FUE ENVIADO CON EXITO!');
              location.reload();
            },
            error: function(jqXHR, tranStatus) {
              $('#result').text('Error');
              $('#code').text(jqXHR.status);
              x_request_id = jqXHR.getResponseHeader('X-Request-Id');
              response_text = jqXHR.responseText;
              $('#response').html(" Error Message : <b style='color: red'>"+response_text+"</b>.<br/> Your X-Request-Id is : <b>" + x_request_id + "</b>. Please contact support@freshdesk.com with this id for more information.");
            }
          }
        );
}
function validateData(){
$('.error').html('');
$('.error').removeClass('alert alert-danger');
  $.ajax(
  {
    url: "/reclamaciones/create",
    type:"POST",
    data : { pais : $("#group_id").val(),
            codigo:$("#prefpais").val(),
            nombre : $("#name").val(),
            tipo : $("#tipo").val(),
            motivo : $("#subject").val() ,
            email : $("#email").val(),
            telefono : $("#telefono").val(),
            descripcion : $("#description").val(),

          },

    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
registerticketfreshdesk(d.dominio,d.key);
  }).fail(function(error){
    $('#load_inv').hide(30);
$(".paisvalidate").html(error.responseJSON.errors.pais).css("color", "#FF0000");
$(".codigvalidate").html(error.responseJSON.errors.codigo).css("color", "#FF0000");
$(".tipovalidate").html(error.responseJSON.errors.tipo).css("color", "#FF0000");
$(".namevalidate").html(error.responseJSON.errors.nombre).css("color", "#FF0000");
$(".motivovalidate").html(error.responseJSON.errors.motivo).css("color", "#FF0000");
$(".emailvalidate").html(error.responseJSON.errors.email).css("color", "#FF0000");
$(".telefonovalidate").html(error.responseJSON.errors.telefono).css("color", "#FF0000");
$(".descripvalidate").html(error.responseJSON.errors.descripcion).css("color", "#FF0000");

 });

}
