$('#answerticket').hide();

$("#respdiv").click(function() {
  $('#answerticket').show();
  $('#respdiv').hide();
});

$("#respdelete").click(function() {
  $('#answerticket').hide();
  $('#respdiv').show();
});

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$("#enviarresp").click(function() {
  var idti = $('#tic').attr('data-id');
  var editor = CKEDITOR.instances['editor'].getData();
  var formData = new FormData($("#myform")[0]);
  formData.append("idti", idti);
  formData.append("desc", editor);
  $.ajax(
    {
      url: "/servicedesk/reply",
      type: "POST",
      data : formData,
      processData: false,
      contentType: false,
    }).done(function(d)
    {
      alert('Se agrego exitosamente la respuesta!');
      location.reload();
    }).fail(function(d){
      console.log(d);//alerta del ticket no resgistrado
      alert('el ticket no se registro');
    });
});
