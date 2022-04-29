var table = $('#driver').DataTable();
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function alldrivers(){
  table = $('#driver').DataTable({
  dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
            ]
    ,
  "ajax": {
         "url": "/ov/getuserslist",
         "type": "GET",
         "dataType": 'json',
         'data': $('#myform').serializeObject(),
  },
  "order": [[ 1, "desc" ]],
  'autoWidth': true,
  'destroy'  : true,
  "scrollX"  : true,
  'buttons'  : [
    {
      'extend': 'pdf',
      'text': 'PDF',
      'messageBottom': null,
      'download': 'open',

    },

    {
      'extend': 'excel',
      'text' :   'EXCEL',
      'messageTop': null,

    },
    {   'extend': 'copy',
        'text': 'Copiar',

    },

    {
        'extend': 'print',
        'text' : 'Imprimir',
        'messageTop':null,
        'messageBottom': null,

    }
    ],
  'language' : {
    "decimal": "",
    "emptyTable": "No hay informaciÃ³n",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de MAX total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar MENU Entradas",
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
      {data:"id_office"},
      {data:"site_name_office"},
      {data:"first_name"},
      {data:"last_name"},
      {data:"phone"},
      {data:"phone_public"},
      {data:"email"},
      {data:"email_public"},
      {data:"country"}
  ],
  });
}


//GET ARRAY FORM
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
