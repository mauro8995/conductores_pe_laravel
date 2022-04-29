$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
//taxi win______-------------------------------------------------------------------------------
$("#e2_3").select2();
//llenar dataTable
function fillDataTableTaxiWin(data)
{
  $('#taxiWin').DataTable({  'responsive'  : true,
    'autoWidth': false,
    'destroy'   : true,
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
    data: data,
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'pdf',
        text: 'PDF',
        messageBottom: null,
        download: 'open',

      },

      {
        extend: 'excel',
        text :   'EXCEL',
        messageTop: null,

      },
      {   extend: 'copy',
          text: 'Copiar',

      },
      {
          extend: 'print',
          text : 'Imprimir',
          messageTop:null,
          messageBottom: null,

      }
      ],
    "columns":[
      {data:"dni"},
      {data:"id_office"},
      {data:"first_name"},
      {data:"last_name"},
      {data:"phone"},
      {data:"correo"},
      {data:"city"},
      {data:"marca"},
      {data:"placa"},
      {data:"modelo"},
      {data:"estado"},
      {data:"date_create.date"},
      {data:"created.username"}
    ]
    });
}

//filtrar por PRODUCTOS
function filterAdvance()
{
  var accion = document.getElementById("e2_3").value;
  var e = document.getElementById("rageTimes").value;
  $.ajax({
    url: "/report/customerTaxiwin",
    type:"POST",
    data:{fecha : e, estado:  accion},
    beforeSend: function () {
      $('.docs-example-modal-sm').modal('toggle');
    },
  }).done( function(d) {
    fillDataTableTaxiWin(d.data);
    $('.docs-example-modal-sm').modal('hide');
  }).fail( function() {
  aler("Error en el petición")
  }).always( function() {

  });
}

var table = $('#taxiWin').DataTable({  'responsive'  : true,
  'autoWidth': true,
  'destroy'   : false,
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
  dom: 'Bfrtip',
  buttons: [
    {
      extend: 'pdf',
      text: 'PDF',
      messageBottom: null,
      download: 'open',
    },

    {
      extend: 'excel',
      text :   'EXCEL',
      messageTop: null,

    },
    {   extend: 'copy',
        text: 'Copiar',

    },
    {
        extend: 'print',
        text : 'Imprimir',
        messageTop:null,
        messageBottom: null,
    }
    ],
});

$(function() {
 $('input[name="datetimes"]').daterangepicker({
   startDate: moment().startOf('hour'),
   endDate: moment().startOf('hour').add(32, 'hour'),
   locale: {
     format: 'Y-MM-DD'
   }
 });
});
//-------------------------------------------------------------------------------------fin de taxi // WARNING:
