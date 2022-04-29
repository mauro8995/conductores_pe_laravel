var table;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$(document).ready(function(){
  table =  $('#drivers').DataTable();
});


function getData()
{
 table =  $('#drivers').DataTable({
    dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
            ]
    ,
    'ajax': {
      'url': "/getDriverAprovedsView",
      'type':"GET",
	'data':
		{
			'id_office':$('#off_e').val()
		}
    },
    'responsive'  : true,
    'autoWidth'   : false,
    'destroy'     : true,
    'language'    : {
    "decimal"     : "",
    "emptyTable"  : "No hay informaciÃ³n",
    "info"        : "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty"   : "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix" : "",
    "thousands"   : ",",
    "lengthMenu"  : "Mostrar _MENU_ Entradas",
    "loadingRecords" : "Cargando...",
    "processing"     : "Procesando...",
    "search"         : "Buscar:",
    "zeroRecords"    : "Sin resultados encontrados",
    "paginate"       : {
        "first"   : "Primero",
        "last"    : "Ultimo",
        "next"    : "Siguiente",
        "previous": "Anterior"
      }
    },
    "columns":[
      {data:"sponsor"},
      {data:"id_office"},
      {data:"dni"},
      {data:"first_name"},
      {data:"last_name"},
	{data:"city"},

      {
         sortable: false,
         "render": function ( data, type, full, meta ) {
           return '<a  onclick="vehiculoGetForm('+full.id_office+', '+full.id+')"><i class="glyphicon glyphicon-th-list"></i><a>';
          }
      },
      {data:"documentos",
        "render": function ( data, type, full, meta) {
         return data;
      }},
      {data:"vehiculo",
        "render": function ( data, type, full, meta) {
        return data;

      }},
      {data:"driver",
        "render": function ( data, type, full, meta) {
          return data;

      }},
      {data:"estatusapi",
        "render": function ( data, type, full, meta) {
        return data;

      }},
      {data:"migrado"}

    ],
    'columnDefs': [
      {
          "targets":0, // your case first column
          "className": "text-center",
     },
     {
         "targets":1, // your case first column
         "className": "text-center",
    },
     {
         "targets": 2 , // your case first column
         "className": "text-left",
    },
    {
         "targets": 3,
         "className": "text-left",
    },
    {
         "targets": 4,
         "className": "text-center",
    },
    {
         "targets": 5,
         "className": "text-center",
    },
    {
         "targets": 6,
         "className": "text-center",
    },
    {
         "targets": 7,
         "className": "text-center",
    },
    {
         "targets": 8,
         "className": "text-center",
    },
    {
         "targets": 9,
         "className": "text-center",
    }
    ],
});
}

//ENTRAMOS EN LA SECCION DEL DOCUMENTO
  function vehiculoGetForm(id_office, id){

    $('#serviceAreaList').val(null).trigger('change');
    $('#serviceTypeList').val(null).trigger('change');
    $('#vehicleTypeList').val(null).trigger('change');

    $(".datosSend").show();
    $(".waiting").hide();

    $.ajax({
      url: "/getModalValidate",
      type:"post",
      beforeSend: function () {
      },
    }).done( function(data) {

        //CAMPO 1
        var options1= "";
        $.each(data.serviceAreaList,function(key,value){
          options1+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#serviceAreaList").find('option').remove().end().append(options1);

        //CAMPO 2
        var options2 = "";
        $.each(data.serviceTypeList,function(key,value){
          options2+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#serviceTypeList").find('option').remove().end().append(options2);

        //CAMPO 2
        var options3 = "";
        $.each(data.vehicleTypeList,function(key,value){
          options3+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#vehicleTypeList").find('option').remove().end().append(options3);


        $('#serviceAreaList').select2();
        $('#serviceTypeList').select2();
        $('#vehicleTypeList').select2();
        $('#tenantId').val(data.tenantId);
        $('#id_file_drivers_send').val(id);

        $('#serviceAreaList').val(null).trigger('change');
        $('#serviceTypeList').val(null).trigger('change');
        $('#vehicleTypeList').val(null).trigger('change');

        $("#modal-viewApiMeta").modal('show');


    }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}


//VER ESTA OPCION
function getModalValidate(){
  $.ajax({
    url: "/getModalValidate",
    type:"post",
    beforeSend: function () {
    },
  }).done( function(data) {

      //CAMPO 1
      var options1= "";
      $.each(data.serviceAreaList,function(key,value){
        options1+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#serviceAreaList").find('option').remove().end().append(options1);

      //CAMPO 2
      var options2 = "";
      $.each(data.serviceTypeList,function(key,value){
        options2+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#serviceTypeList").find('option').remove().end().append(options2);

      //CAMPO 2
      var options3 = "";
      $.each(data.vehicleTypeList,function(key,value){
        options3+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#vehicleTypeList").find('option').remove().end().append(options3);


      $('#serviceAreaList').select2();
      $('#serviceTypeList').select2();
      $('#vehicleTypeList').select2();
      $('#tenantId').val(data.tenantId);

      $('#serviceAreaList').val(null).trigger('change');
      $('#serviceTypeList').val(null).trigger('change');
      $('#vehicleTypeList').val(null).trigger('change');

      $("#modal-viewAprobarApi").modal('show');


  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}
