table = $('#audits').DataTable({
  dom: 'Bfrtip',
          buttons: [
              'excelHtml5',
          ]
  ,
  'responsive'  : true,
  'autoWidth': false,
  'destroy'   : true,
  'scrollX'  : true,
  "ajax": {
         "url": "/driver/externo/getAudits",
         "type": "GET",
         "dataType": 'json',
  },
  'language': {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ Entradas",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
    }
  },
  "columns"  : [
      {data:"action"},
      {data:"usuario"},
      {data:"accion"},
      {data:"proceso"},
      {data:"estado"},
      {data:"id_office"},
      {data:"datecreated"}
  ]
});

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function viewAudits(elem){
  var id_audits = elem;

  $.ajax({
    url: "/driver/externo/getAuditsbyID",
    type:"post",
    data:{id : id_audits},
    beforeSend: function () {
    },
  }).done( function(d) {
    console.log(d.data[0]);
    $("#modal-viewdetailsaudits").modal('show');
    var obj = JSON.parse(d.data[0].new_values);
    var estado;
    var desc;
    var accion;
    if (obj.approved == 1){
      estado = "APROBADO";
      desc = "";
    }else if (obj.approved == 0){
      estado = "DESAPROBADO";
      desc = obj.description;
    }else{
      estado = "EN EVALUACION";
      desc = "";
    }

    var objant = JSON.parse(d.data[0].old_values);
    var estadoant;
    var descant;
    if (objant.approved == 1){
      estadoant = "APROBADO";
      descant = "";
    }else if (objant.approved == 0){
      estadoant = "DESAPROBADO";
      descant = obj.description;
    }else{
      estadoant = "EN EVALUACION";
      descant = "";
    }

    if (d.data[0].event == "updated"){
      accion = "ACTUALIZADO";
    }else{
      accion = "CREADO";
    }


    $('#formaudits').html("<b>USUARIO</b>"+ "<br>" + d.data[0].usuario + "<br>" +"<b>PROCESO</b>"+ "<br>" + d.data[0].proceso +"<br>"+"<b>DATOS ANTERIORES</b>"+ "<br>" +"ESTADO: "+ estadoant +"<br>" +"DESCRIPCION: "+ descant + "<br>" +"<b>DATOS ACTUALES</b>"+ "<br>" +"ESTADO: "+ estado +"<br>" +"DESCRIPCION: "+ desc + "<br>" + "<b>ACCION REALIZADA</b>"+ "<br>" + accion+ "<br>" + "<b>FECHA</b>"+ "<br>" + d.data[0].datecreated);
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });

}
