
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$('#groups').select2();
$('#agents').select2();
$('.divagents').hide();
$(".search").change(function(){
    agent = $('#agents').val();
    group = $('#groups').val();
    dates = $('#reservation').val();

    $.ajax(
    {
      url: "/report/GetReportGeneral",
      type:"GET",
      data : { agent: agent, group: group, dates: dates },
      dataType: "json",
      beforeSend: function () {
        //$('#load_inv').show(300);
      }
    }).done(function(d)
    {
      //$('#load_inv').hide(300);
      alertify.notify('Correcto','success',2, function(){});
      $('#unsolved').html(d.data[0].unsolved);
      $('#open').html(d.data[0].open);
      $('#waiting').html(d.data[0].waiting);

      $('#closed').html(d.data[0].closed);
      $('#solved').html(d.data[0].solved);
      $('#total').html(d.data[0].total);
      if (agent != ""){
        $('#divgroup').hide();
        $('.divagents').show();
        $('#opentimetrue').html(d.data[0].opentimetrue);
        $('#opentimefalse').html(d.data[0].opentimefalse);
        $('#closevenctrue').html(d.data[0].closevenctrue);
        $('#closevencfalse').html(d.data[0].closevencfalse);
      }else{
        $('.divagents').hide();
        $('#divgroup').show();
        $('#assigned').html(d.data[0].assigned);
        $('#notassigned').html(d.data[0].notassigned);
      }
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });

});


$("#groups").change(function(){
  var groupVal = $(this).val();
  if (groupVal == ""){

  }else{
    $.ajax(
      {
        url: "/atencion/freshdesk/GetAgentsByGroupID",
        type: "POST",
        data : { id : groupVal},
        dataType: "json",
      }).done(function(d)
      {
        console.log(d.data);
        $('#agents').empty();
        var fila = '<option value="">--</option>';
        $.each(d.data,function(key, registro)
        {
          fila += '<option value='+registro.id+'>'+registro.username.toUpperCase()+' - '+registro.name.toUpperCase()+' '+registro.lastname.toUpperCase()+'</option>';
        });
        $("#agents").append(fila);

      }).fail(function(d){
        console.log(d);//alerta del ticket no resgistrado
      });
  }
});
