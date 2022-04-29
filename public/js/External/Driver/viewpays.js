var table;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$('#users').select2();
$(document).ready(function(){
  table =  $('#drivers').DataTable({
    dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
            ]
    ,
    'ajax': {
      'url': "/getDriverAprovedListView",
      'type':"GET",
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
      {data:"action",
        "render": function ( data, type, full, meta) {
        return data;
      }},
      {data:"sponsor"},
      {data:"firstnamespon"},
      {data:"lastnamespon"},
      {data:"phonespon"},
      {data:"id_office"},
      {data:"dni"},
      {data:"first_name"},
      {data:"last_name"},
      {data:"status"},
      {data:"date_pay"},
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
    }
    ],
});

    $('#drivers tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });

    $('#paysponsor').click( function () {

      var a= [];
      var counter = 0;
      $.each(table.rows('.selected').data(), function() {
          a.push(this);
          counter++;
      });

      alertify.confirm('Confirmacion de pago', '¿Desea pagar? Ha seleccionado un total de '+counter+' conductores.', function(){
        if (counter > 0){
        $("#modal-cargando").modal('show');
       $.ajax({
         url: "/driverStatusPay",
         type:"POST",
         data:{ id_offices : a , cant : counter},
         beforeSend: function () {
         },
       }).done( function(d) {
         $("#modal-cargando").modal('hide');
         table.ajax.reload();
       }).fail( function() {   alert("Ocurrio un error en la operaciÃ³n");    $("#modal-cargando").modal('hide'); }).always( function() {   });

       }else{
          alert('Debes seleccionar al menos una opciÃ³n.');
        }

        //return false;
       }, function(){ alertify.error('Cancelo')});
    });

    $('#search').click( function () {
      var lider = $('#users').val();
      if (lider == null || lider == ""){
        alert("SELECCIONAR LIDER");
      }else{
      table =  $('#drivers').DataTable({
          dom: 'Bfrtip',
                  buttons: [
                      'excelHtml5',
                  ]
          ,
          'ajax': {
            'url': "/getDriverAprovedListViewbyCreated/"+lider,
            'type':"GET",
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
            {data:"action",
              "render": function ( data, type, full, meta) {
              return data;
            }},
            {data:"sponsor"},
      {data:"firstnamespon"},
      {data:"lastnamespon"},
      {data:"phonespon"},
      {data:"id_office"},
      {data:"dni"},
      {data:"first_name"},
      {data:"last_name"},
      {data:"status"},
      {data:"date_pay"},
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
          }
          ],
      });
      }

    });


});
