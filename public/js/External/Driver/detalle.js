$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var id;
var data;
var id_tecnical;
var linckAntecendetes;
var id_user_office;
var linkRecord;
var tableprocess;
var placav = 1;
var city;
function selectcity(el){ // recibimos por parametro el elemento select
   // obtenemos la opción seleccionada .
  city = $('option:selected', el).attr('data-city');
}
$( document ).ready(function() {
  id = $('#id').val();
  getData();
  getDataProceso(id);
});

$('#tableprocesoValidacion').DataTable({
  'responsive'  : true,
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
});

function getData(){
  $.ajax({
    url: "/driver/externo/get",
    type:"post",
    data:{dar:id,campo:"id_office"},
    beforeSend: function () {
          },
  }).done( function(d) {
    console.log(d);
    if(d.object == "success"){
      data              = d.data;
      id_tecnical       = d.data[0].get_tecnical.id;
      linckAntecendetes = d.data[0].url_antecedentes;
      linkRecord        = d.statusrecord;
      id_user_office    = data[0].get_customer.id;

      $('#puntos').html(d.points);
      if(d.dataapi){
        $("#buttondesactivar").show();
        $("#buttonaprobar").hide();
        console.log(dataapi);
      }else{
        $("#buttondesactivar").hide();
        $("#buttonaprobar").show();
      }

    }else {

        alert(d.message);
      }

  }).fail( function() {
  alert("Ocurrio un error en la operación");
  }).always( function() {  });
}

function openFile(url) {
  if (url){
    abrirNuevoTab(url);
  }else{
        alert("No existe este archivo");
  }

}
// PROCESOS DEL CONDUCTOR
function getDataProceso(id){
  var migrad = $("#driverid").val();
  $.ajax({
    url: "/driver/externo/getDataProceso",
    type:"post",
    data:{ id:id},
    beforeSend: function () {
          },
  }).done( function(d) {
  var full = d;
  console.log(full);
    if(d){
      tableprocess = $('#tableprocesoValidacion').DataTable({
      'responsive'  : true,
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
    "data": d,
    "columns":[
      {data:"get_proceso.nombre"},
      {data: "estatus_proceso",
        "render": function (data, type, row) {
        console.log(data);
        if (data === true) {
        return '<i class="glyphicon glyphicon-ok-circle"></i>';}  else {return '<i class="glyphicon glyphicon-ban-circle"></i>'};

      }},
      {data:"get_modify_by.username"},
      {data:"created_at"},
      {data:"updated_at"},
      {data: "approved",
        "render": function (data, type, row) {
          if (data === true) {
            return '<a onclick="validarPermisos('+row.id_proceso_validacion+', 1, '+row.id_file_drivers+')"><i style="color: #8CFD04 !important; font-size: 20px" class="glyphicon glyphicon-ok-circle"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+',null, '+row.id_file_drivers+')"><i style="color: #000000 !important" class="glyphicon glyphicon-warning-sign"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+', 0, '+row.id_file_drivers+')"><i style="color: #000000 !important;" class="glyphicon glyphicon-remove-circle"></i><a>';
          }
          else if (data === false) {
            return '<a onclick="validarPermisos('+row.id_proceso_validacion+', 1, '+row.id_file_drivers+')"><i style="color: #000000 !important;" class="glyphicon glyphicon-ok-circle"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+',null, '+row.id_file_drivers+')"><i style="color: #000000 !important;" class="glyphicon glyphicon-warning-sign"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+', 0, '+row.id_file_drivers+')"><i style="color: #FC0F00 !important; font-size: 20px" class="glyphicon glyphicon-remove-circle"></i><a>';
          }else{
            return '<a onclick="validarPermisos('+row.id_proceso_validacion+', 1, '+row.id_file_drivers+')"><i style="color: #000000 !important;" class="glyphicon glyphicon-ok-circle"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+',null, '+row.id_file_drivers+')"><i style="color: #FFB705 !important; font-size: 20px;" class="glyphicon glyphicon-warning-sign"></i><a><a onclick="validarPermisos('+row.id_proceso_validacion+', 0, '+row.id_file_drivers+')"><i style="color: #000000 !important;" class="glyphicon glyphicon-remove-circle"></i><a>';
         }
      }},
      {data:"get_created_by.username"},
      {data: "description"},
      {data: "estatus_proceso",
        "render": function (data, type, row) {
          return '<a onclick="deleteprocess('+row.id+')"><i class="glyphicon glyphicon-trash"></i><a>';
      }}
    ],
    'columnDefs': [
     {
         "targets": 0, // your case first column
         "className": "text-center",
    },
    {
         "targets": 1,
         "className": "text-center",
    },
    {
         "targets": 2,
         "className": "text-center",
    },
    {
         "targets": 3,
         "className": "text-center",
    },
    {
         "targets": 4,
         "className": "text-center",
    },
    {
         "targets": 5,
         "className": "text-center",
    },
    ],

  });

  if (migrad == 'null'){

  }else{
    //var columndeta = tableprocess.column(5);
    //columndeta.visible(!columndeta.visible());
  }


    }else {
      alert("Ocurrio un error en la operación");
    }

}).fail( function() {
alert("Ocurrio un error en la operación");
}).always( function() {


  });}

function deleteprocess(id){
    alertify.confirm('Eliminar proceso','¿Esta seguro de eliminar el proceso?',
     function(evt, value) {
      $.ajax({
        url: "/deleteProcessValid",
        type:"post",
        data:{
          id : id
        },
        beforeSend: function () {        },
        }).done( function(d) {
          id = $('#id').val();
          getDataProceso(id);
          alert(d.mensaje);
        }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });
    }, function() {
       alertify.error('Cancelo');
    });
}

//VALIDAR PERMISOS
function validarPermisos(id, estatus, idfiledrivers) {

  if (estatus > 0){
    desc = "";
    $.ajax({
      url: "/permisosProcessValid",
      type:"post",
      data:{
        id : id, estatus : estatus, idfiledrivers : idfiledrivers, descri : desc
      },
      beforeSend: function () {        },
      }).done( function(d) {
        id = $('#id').val();
        getDataProceso(id);
        alert(d.mensaje);
      }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });
  }else{
             alertify.prompt('Descripcion de validacion','','',
                function(evt, value) {
                 if (value.length > 5){
                 $.ajax({
                   url: "/permisosProcessValid",
                   type:"post",
                   data:{
                     id : id, estatus : estatus, idfiledrivers : idfiledrivers, descri : value
                   },
                   beforeSend: function () {        },
                   }).done( function(d) {
                     id = $('#id').val();
                     getDataProceso(id);
                     alert(d.mensaje);
                   }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });
                 }else{
                   alertify.alert('ERROR!','Tienes que escribir la razon');
                 }
               }, function() {
                 alertify.error('Tienes que escribir la razon');
                 razo = 1;
               });
  }
}
//GESTION DE EDITAR
function editarButtonPersonal (id) {
  if ($('.verPersonal').is(':visible')) {
    $(".verPersonal").hide();
    $(".editarPersonal").show();
  } else {
    $(".verPersonal").show();
    $(".editarPersonal").hide();
  }
}
function editarButtonConductor(id) {

  if ($('.verConductor').is(':visible')) {
    $(".verConductor").hide();
    $(".editarConductor").show();

  } else {
    $(".verConductor").show();
    $(".editarConductor").hide();

  }
}
function editarButtonVehiculo (id) {

  if ($('.verVehiculo').is(':visible')) {
    $(".verVehiculo").hide();
    $(".editarVehiculo").show();

  } else {
    $(".verVehiculo").show();
    $(".editarVehiculo").hide();

  }
}

function editarButtonRevision (id) {
  if ($('.verRevision').is(':visible')) {
    $(".verRevision").hide();
    $(".editarRevision").show();
  } else {
    $(".verRevision").show();
    $(".editarRevision").hide();
  }
}

function editarButtonAtu (id) {
  if ($('.verAtu').is(':visible')) {
    $(".verAtu").hide();
    $(".editarAtu").show();
  } else {
    $(".verAtu").show();
    $(".editarAtu").hide();
  }
}

function editarButtonSeguro   (id) {

  if ($('.verSeguro').is(':visible')) {
    $(".verSeguro").hide();
    $(".editarSeguro").show();

  } else {
    $(".verSeguro").show();
    $(".editarSeguro").hide();

  }
}
// GETSION DE FOTOS
function viewModal            (div){
  limpiar();
  var driverid   = $("#driverid").val();
  var vehicleid  = $("#vehicleid").val();
  $("#buttonphoto").val('');
  $("#buttonphoto").val(div);
  $(".carusel").hide();
  $('#'+div).show();
  $('#mymodal').modal('show');
  switch (div) {

    case 'personal':
    var a = data[0].dni_frontal;
    var b = data[0].dni_back;
    if(a  === null || b === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        $('#updbutton').show().find('button').prop('disabled', false);
      }
    }
    break;
    case 'perfil':
    var a = data[0].photo_perfil;
    if(a  === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");
	$('#updbutton').show().find('button').prop('disabled', false);
      }
    }
    break;
    case 'conductor':
    var a = data[0].lic_frontal;
    var b = data[0].lic_back;
    if(a  === null || b === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");
	$('#updbutton').show().find('button').prop('disabled', false);
      }
    }
    break;
    case 'seguro':
    var a = data[0].soat_frontal;
    if(a  === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(vehicleid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");
        $('#updbutton').show().find('button').prop('disabled', false);
      }
    }

    break;
    case 'vehiculo':
    var a = data[0].car_interna;
    var b = data[0].car_interna2;
    var d = data[0].car_externa;

    if(a  === null || b === null ||  d === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(vehicleid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");
        $('#updbutton').show().find('button').prop('disabled', false);
      }
    }

    break;
    default:
    $('#updbutton').show().find('button').prop('disabled', false);
  }

  // if ((div ==='personal' || div === 'perfil' || div === 'condutor') && (driverid === 'null')){
  //   $('#updbutton').show().find('button').prop('disabled', false);
  // }else if ( (div ==='vehiculo' || div === 'seguro') && ( vehicleid === 'null') ){
  //   $('#updbutton').show().find('button').prop('disabled', false);
  // }else{
  //   $('#updbutton').hide().find('button').prop('disabled', true);
  // }

}
function verPhoto() {
  $('#modalupdphoto').modal('hide');
  var div = $("#buttonphoto").val();
  viewModal(div)
}
function limpiar () {
  $("#buttonphoto").val('');
  $("#dni_frontal").val('');  $("#dni_back").val('');
  $("#dni_frontal_cap").val('');  $("#dni_back_cap").val('');

  $("#lic_frontal").val('');  $("#lic_back").val('');
  $("#lic_frontal_cap").val('');  $("#lic_back_cap").val('');


  $("#car_interna").val('');  $("#car_interna2").val('');
  $("#car_externa").val('');


  $("#car_interna_cap").val('');  $("#car_interna2_cap").val('');
  $("#car_externa_cap").val('');

  $("#soat_frontal").val('');
  $("#soat_frontal_cap").val('');

  $("#photo_perfil").val('');      $("#photo_perfil_cap").val('');
}


//GESTION DE GUARDAR
function guardarButton (id, form) {
  var dni   = $('[name=dni]').val();
  var placa = $('[name=placa]').val();
  placa     = placa.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'');
  var tpdocuments =  $('[name=id_type_documents]').val();

  if (form == 'formPersonal'){
    $("#personaltodo").hide();
    $("#personalcargando").show();
    sendData(id, form);

  }
  else if (form == 'formConductor' ){
    $("#conductortodo").hide();
    $("#conductorcargando").show();
    $.ajax({
      url: "/driver/externo/validatelice",
      type:"POST",
      data : { licencia : dni, tipodoc : tpdocuments},
      dataType: "json",
    }).done(function(d){
      if (d.object === 'success'){

        if (d.data != null){
          var licencia           = d.data.nrolicencia;
          var clasecategoria     = d.data.clasecategoria;
          var fechaemision       = d.data.fechaemision;
          var fecharevalidacion  = d.data.fecharevalidacion;

          $('[name=licencia]' ).val(licencia);
          $('[name=classcategoria]').val(clasecategoria);
          $('[name=licfecemi]').val(fechaemision.substr(6,4)+'-'+fechaemision.substr(3,2)+'-'+fechaemision.substr(0,2));
          $('[name=licfecven]').val(fecharevalidacion.substr(6,4)+'-'+fecharevalidacion.substr(3,2)+'-'+fecharevalidacion.substr(0,2));

        }
        alert(d.menssage);
      }else{
        alert(d.menssage);
        $('[name=licencia]').val('');
      }
      sendData(id, form);
    }).fail(function(error){    });

  }
  else if (form == 'formVehiculo'  ){
    $("#vehiculotodo").hide();
    $("#vehiculocargando").show();
    sendData(id, form);
  }
  else if (form == 'formSeguro'  ){
    $("#segurotodo").hide();
    $("#segurocargando").show();

    alertify.confirm('Confirmar', 'Que tipo se Seguro', function(){
      $.ajax({
        url: "/apiSoatPlaca",
        type:"POST",
        data : { placa : placa },
        dataType: "json",
      }).done(function(d){
        if (d.object === 'sucesss'){
          alert(d.message);
          if (d.data != null){
            var enterprisesoat  = d.data.nombrecompania;
            var est_soat        = d.data.estado;
            var soatfecemi      = d.data.fechainicio;
            var soatfecven      = d.data.fechafin;
            var type_soat       = d.data.nombreusovehiculo;
            var nro_poliza      = d.data.numeropoliza;
            var type_safe       = 'SOAT';

            $('[name=enterprisesoat]').val(enterprisesoat);
            $('[name=est_soat]').val(est_soat);
            $('[name=type_soat]').val(type_soat);
            $('[name=type_safe]').val(type_safe);
            $('[name=nro_poliza]').val(nro_poliza);
            $('[name=soatfecemi]').val(soatfecemi.substr(6,4)+'-'+soatfecemi.substr(3,2)+'-'+soatfecemi.substr(0,2));
            $('[name=soatfecven]').val(soatfecven.substr(6,4)+'-'+soatfecven.substr(3,2)+'-'+soatfecven.substr(0,2));
          }
          sendData(id, form);
        }else{
          $("#segurotodo").show();
          $("#segurocargando").hide();
          alert(d.message);
        }
      }).fail(function(error){    });


    }, function(){//cuendo le dan cancelar
       var type_safe1       = 'AFOCAT';
       $('[name=type_safe]').val(type_safe1);
       sendData(id, form);


                     }).set('labels', {ok:'SOAT', cancel:'CAT'});






  }else if (form == 'formATU'){
    $("#atutodo").hide();
    $("#atucargando").show();
       sendData(id, form);
  }else if (form == 'formRevision'){
    $("#revisiontodo").hide();
    $("#revisioncargando").show();
       sendData(id, form);
  }

}
function sendData      (id, form) {
  $.ajax({
    url: "/updateFormDriver",
    type:"post",
    data:{ data : $("#"+form).serializeObject() , id : id, form : form,city:city },
    beforeSend: function () {
    },
  }).done( function(data) {
      console.log(data);
      alert(data.mensaje);
      if (data.observaciones != null){
       alert(data.observaciones);
      }

      if(data.flag == 'true'){
        location.reload(true);
      }else{
       $("#vehiculotodo").show();
       $("#vehiculocargando").hide();
      }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}
//VER FORM DE UPDATE PHOTO
function updatePhotoButton (d){

  $('#mymodal').modal('hide');
  $(".caruselphoto").hide();
  var div;
  if (d != 'null'){
    div = d;
    $(".nophoto").hide();
    $("#buttonphoto").val(d);
  }
  else{    div = $("#buttonphoto").val();   }

  $('#'+div+'upd').show();
  $('#modalupdphoto').modal('show');
}
//UPDATE PHOTO
var ccimg;
function updatePhoto(id, alterno){
  ccimg = 0;
  var div = $("#buttonphoto").val();
  var driverid   = $("#driverid").val();
  var vehicleid  = $("#vehicleid").val();
  var mensaje    = "No podemos continuar con su solicitud este usuario ya ha sido migrado al aplicativo";

  switch(div) {
    case 'personal':
    if ( ($('#dni_frontal').get(0).files.length === 0) && ($('#dni_back').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
    }
    else{
      if  ($('#dni_frontal').get(0).files.length != 0) { ccimg++; }
      if  ($('#dni_back'   ).get(0).files.length != 0) { ccimg++; }

      if  ($('#dni_frontal').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'dni_frontal', 'dni_frontal', 'PERU', 3);  }
      if  ($('#dni_back').get(0).files.length    != 0) {upImgDni(id,'file_drivers', 'dni_back',   'dni_back',     'PERU', 3);  }
      $(".caruselphoto").hide();
      $("#cargando").show();
    }

    break;
    case 'conductor':
      if ( ($('#lic_frontal').get(0).files.length === 0) && ($('#lic_back').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }
      else{
        if  ($('#lic_frontal').get(0).files.length != 0) { ccimg++; }
        if  ($('#lic_back'   ).get(0).files.length != 0) { ccimg++; }

        if  ($('#lic_frontal').get(0).files.length != 0) { upImgDni(id,'file_drivers', 'lic_frontal', 'lic_frontal', 'PERU',3); }
        if  ($('#lic_back').get(0).files.length    != 0) { upImgDni(id,'file_drivers', 'lic_back',   'lic_back',     'PERU',3); }
        $(".caruselphoto").hide();
        $("#cargando").show();
      }


    break;
    case 'vehiculo':

      if ( ($('#car_interna').get(0).files.length  === 0) && ($('#car_interna2').get(0).files.length    === 0)
        && ($('#car_externa').get(0).files.length  === 0) && ($('#tar_veh_frontal').get(0).files.length === 0)
        && ($('#tar_veh_back').get(0).files.length === 0) && ($('#car_externa2').get(0).files.length === 0)
        && ($('#car_externa3').get(0).files.length === 0) && ($('#car_externa4').get(0).files.length === 0)) {
        alert("No has cargado ningun archivo aun");
      }else{

        if  ($('#car_interna' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_interna2').get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa2' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa3' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa4' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#tar_veh_frontal').get(0).files.length  != 0) {ccimg++; }
        if  ($('#tar_veh_back'   ).get(0).files.length  != 0) {ccimg++; }

        if  ($('#car_interna' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_interna', 'car_interna', 'PERU',2);  }
        if  ($('#car_interna2').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_interna2','car_interna2','PERU',2);  }
        if  ($('#car_externa' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa', 'car_externa', 'PERU',2);  }
        if  ($('#car_externa2' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa2', 'car_externa2', 'PERU',2);  }
        if  ($('#car_externa3' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa3', 'car_externa3', 'PERU',2);  }
        if  ($('#car_externa4' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa4', 'car_externa4', 'PERU',2);  }

        if  ($('#tar_veh_frontal').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'tar_veh_frontal','tar_veh_frontal','PERU', 3); }
        if  ($('#tar_veh_back'   ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'tar_veh_back','tar_veh_back','PERU', 3);       }

        $(".caruselphoto").hide();
        $("#cargando").show();


        }


    break;
    case 'seguro':

      if ( ($('#soat_frontal').get(0).files.length === 0)) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#soat_frontal').get(0).files.length != 0) { ccimg++; }
        if  ($('#soat_frontal').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'soat_frontal', 'soat_frontal', 'PERU', 3); }
          $(".caruselphoto").hide();
          $("#cargando").show();
        }


    break;
    case 'perfil':

      if ( ($('#photo_perfil').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#photo_perfil').get(0).files.length != 0) { ccimg++; }

        if  ($('#photo_perfil').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'photo_perfil', 'photo_perfil', 'PERU', 4);}
        $(".caruselphoto").hide();
        $("#cargando").show();

        }


    break;
    case 'antecedente':

      if ( ($('#url_antecedentes').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
      }else{

      if  ($('#url_antecedentes').get(0).files.length != 0) {upPdf(id,'file_drivers', 'url_antecedentes', 'url_antecedentes', 'PERU'); validarPermisos(5, true, id);}
      $(".caruselphoto").hide();
      $("#cargando").show();

      setTimeout(function(){
        $('#modalupdphoto').modal('hide');
        alert("Actualizado de forma correcta!");
        location.reload();
      }, 20000);
    }

    break;
    case 'revisiontecnica':

      if ( ($('#revision_tecnica').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#revision_tecnica').get(0).files.length != 0) { ccimg++;  }
        if  ($('#revision_tecnica').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'revision_tecnica', 'revision_tecnica', 'PERU',1); }
        $(".caruselphoto").hide();
        $("#cargando").show();

      }



    break;
    case 'reciboluz':

    if ( ($('#recibo_luz').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
    }else{
      if  ($('#recibo_luz').get(0).files.length != 0) { ccimg++;  }

      if  ($('#recibo_luz').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'recibo_luz', 'recibo_luz', 'PERU',3); }
      $(".caruselphoto").hide();
      $("#cargando").show();

    }

        break;
        case 'atu':

          if ( ($('#atuimg').get(0).files.length === 0) ) {
            alert("No has cargado ningun archivo aun");
          }else{
            if  ($('#atuimg').get(0).files.length != 0) { ccimg++; }

            if  ($('#atuimg').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'atuimg', 'atu', 'PERU', 3);}
            $(".caruselphoto").hide();
            $("#cargando").show();

            }

    break;
    default:
    alert("Ocurrio un error en la operación------");
  }

}
//SUBIENDO PHOTO
var ccimgup;
function upImgDni(id,table, idinput, nameFile, country, id_process_validacion){
  ccimgup = 0;

  var array     = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);
  var metadata  = {  contentType: 'image/jpeg'  };

  ficherodni       = document.getElementById(idinput);
  storageRef       = firebase.storage().ref();
  var imagenASubir = ficherodni.files[0];
  var uploadTask   = storageRef.child('imgUsersDriver/Peru/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);

  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,  function(snapshot){
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    if (progress == 100){      alertify.notify('se guardo la imagen', 'success', 3, function(){ });   }

  }, function(error) {
    console.log('error '+error);
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
          'id': id,
          'url': downloadURL,
          'name': nameFile,
          'table':table,
          'idinput':idinput,
          'voucherName': imagenASubir.name
        };

      $.ajax({
        url: "/driver/saveFile",
        type:"post",
        data:{
          data : data
        },
        beforeSend: function () {        },
        }).done( function(d) {

          if(d == 'true'){
            ccimgup++;

            if(ccimgup == ccimg){
                alert("Excelente, se registro correctamente.");
                validarPermisos(id_process_validacion, null, id);
                location.reload();
            }

          }

        }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });


      });
    });
}

function upPdf(id,table, idinput, nameFile, country){

  var array      = new Uint32Array(1);
  var aleatorio  = window.crypto.getRandomValues(array);
      fichero    = document.getElementById(idinput);
  var metadata   = {    contentType: 'pdf'  };
      storageRef = firebase.storage().ref();

  var imagenASubir = fichero.files[0];
  var uploadTask   = storageRef.child('imgUsersDriver/Peru/'+aleatorio+''+imagenASubir.name).put(imagenASubir);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){

    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    if (progress == 100){      alertify.notify('Registro exitoso', 'success', 3, function(){ });    }

  }, function(error) {
    console.log('error '+error);
    alert('Ha ocurrido un inconveniente al tratar de subir el documento, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {

       data = {
        'id': id,
        'url': downloadURL,
        'name': nameFile,
        'table':table,
        'idinput':idinput,
        'voucherName': imagenASubir.name
      };

      $.ajax({
        url: "/driver/saveFile",
        type:"post",
        data:{
          data : data
        },
        beforeSend: function () {        },
        }).done( function(d) {     }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });

      });
    });
}

function fechaTecnicas(){
  if(id_tecnical==0)
  alert("No tiene revisión técnica.");
  else
   abrirNuevoTab("/driver/externo/rtpdf/"+id_tecnical);
}

function abrirNuevoTab(url) {
        // Abrir nuevo tab
        var win = window.open(url, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus();
}

function reporte(){
   abrirNuevoTab(url="/driver/externo/details/reporte/"+id);
}

function record(){
  if(linkRecord == false)
    alert("No tiene record.");
  else
  abrirNuevoTab(url="/driver/externo/report/record/"+id_user_office);
}

function revisiontecnica() {
  if(id_tecnical){
    window.location.href = "/driver/externo/rtpdf/"+id_tecnical;
  }else{
    alert("No posee REVISION TECNICA");
  }

}
function revisiontecnica2() {
  if(id_tecnical){
    window.location.href = "/driver/externo/rtpdf2/"+id_tecnical;
  }else{
    alert("No posee REVISION TECNICA");
  }

}


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

$(document).on('change','.btn-file :file',function(){
  var input = $(this);
  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);
});

$(document).ready(function(){
  $('.btn-file :file').on('fileselect',function(event,numFiles,label){
    var input = $(this).parents('.input-group').find(':text');
    var log = numFiles > 1 ? numFiles + ' files selected' : label;
    if(input.length){ input.val(log); }else{ if (log) alert(log); }
  });
});
