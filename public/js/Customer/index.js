$(document).ready(function(){

  var url = window.location.pathname;
      url = url.split("/")[1];

  $.fn.btnSee(url);

    var permiso = $('#permiso').val();
    var rolid = $('#rolid').val();
    var vista;
    function getData(){
      if (permiso == 1 || rolid == 4){
        vista = {
           dom: 'Bfrtip',
           buttons: [
               'copy', 'excel', 'pdf'
           ],
            'responsive'  : true,
            'autoWidth': false,
            'destroy'   : true,
            'language': {
              'buttons': {
                     copyTitle: 'Realizado exitosamente',
                     copySuccess: {
                         _: '%d lineas copiadas',
                         1: '1 linea copiada'
                     },
                   },
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
        }
      }else{
        vista = {
            'responsive'  : true,
            'autoWidth': false,
            'destroy'   : true,
            'language': {
              'buttons': {
                     copyTitle: 'Realizado exitosamente',
                     copySuccess: {
                         _: '%d lineas copiadas',
                         1: '1 linea copiada'
                     },
                   },
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
        }
      }
    }

    getData();
    var table = $('#customers').DataTable(vista);

});

$.fn.btnSee = function(url){

  if (url == 'customers'){
    $(".customers").css('display','block');
  }
  if (url == 'atencion') {
    $(".atencion").css('display','block');
  }
  if (url == 'admin')    {
    $(".admin").css('display','block');
  }

};
