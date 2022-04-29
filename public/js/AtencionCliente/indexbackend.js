$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var nameatencion;
var nroatencion;
var apeatencion;
$('#availability').on('click', function() {
    var valor;
    if($(this).is(':checked')){
        // Hacer algo si el checkbox ha sido seleccionado
      valor = 1;
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
       valor = 0;
    }
    $.ajax(
      {
        url  : "/atencion/availability",
        type : "POST",
        data : {  id: valor},
        dataType: "json",
        beforeSend: function () {
          $('#load_inv').show(300);
        }
      }).done(function(d)
      {
        $('#load_inv').hide(300);
        alertify.notify(d.message,d.object,2, function(){});
        $('.efecto-bajo-div').html('Modulo '+d.nro_modulo);
      }).fail(function(d){
        $('#load_inv').hide(300);
        console.log(d);//alerta del ticket no resgistrado
      });
});
$('.createdTK').on('click', function() {
  var idt = $(this).attr("data-id");
  window.location.href = '/atencion/registerservice/'+idt;
});

$('.updateStatus').on('click', function() {
  var idface =  $(this).attr("data-id");
  $.ajax(
    {
      url  : "/atencion/updateStatusT",
      type : "POST",
      data : {  id: idface, status : 5 },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
      $.fn.getData();
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
    });
});

$('.updateRG').on('click', function() {
  var idface =  $(this).attr("data-id");
  $.ajax(
    {
      url  : "/atencion/updateStatusT",
      type : "POST",
      data : {  id: idface, status : 2 },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
      $.fn.getData();
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
    });
});




$('.nextatention').on('click', function() {
  $.ajax(
    {
      url  : "/atencion/getNextAtention",
      type : "POST",
      data : {},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
      $.fn.getData();
      $.fn.getData1();
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
  });
});

function viewModal(elem){
  var id_face = elem;
  var status = 3;
  $("#modal-view").modal('show');
  $.ajax(
    {
      url  : "/atencion/updateStatusT",
      type : "POST",
      data : {  id: id_face, status: status},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
  });
}

$(document).ready(function() {
  $.fn.getData();
  $.fn.getData1();
  $.fn.getData2();
});

$.fn.getData  = function() {
  $.ajax({
    url: "/atencion/listatentionmoduls",
    type:"GET",
    data:{ datos      : $( '#myform' ).serializeObject()},
    beforeSend: function () {
    },
  }).done( function(d) {
    $.fn.fillDataTable(d.data);
    if (d.atencioncall != null){
      nroatencion = d.atencioncall.nro_modulo;
      nameatencion = d.atencioncall.get_customer.first_name;
      apeatencion = d.atencioncall.get_customer.last_name;
      var pizza1 = d.atencioncall.created_at;
      var porciones1 = pizza1.split(' ');
      $('#dateatencion').html(porciones1[0]+' <i class="fa fa-calendar"></i>');
      $('#namecompleteview').html(nameatencion+' '+apeatencion);
      $('#numberdocs').html(d.atencioncall.get_customer.dni);
      $('#typedocument').html(d.typedocid.description);
      $('#typegestions').html(d.atencioncall.get_type_requirements.description);
      $('.codetic').html(d.atencioncall.nro_ticket);
      $('.typegest').html(d.atencioncall.get_customer_type.description);
      $('.createdTK').attr("data-id",d.atencioncall.id);
      $('.updateStatus').attr("data-id",d.atencioncall.id);
    }
  }).fail( function(error) {
    console.log(error);
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });
}

$('.callatention').on('click', function(e) {
  $.ajax(
    {
      url  : "/atencion/updateStatusT",
      type : "POST",
      data : {  id: nroatencion, status : 6 },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
      $.fn.getData();
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
    });
});

$.fn.getData1  = function() {
  $.ajax({
    url: "/atencion/listatentionsopen",
    type:"GET",
    data:{ datos : $( '#myform' ).serializeObject()},
    beforeSend: function () {
    },
  }).done( function(d) {
    $.fn.fillDataTable1(d.data);
  }).fail( function(error) {
    console.log(error);
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });
}

$.fn.getData2  = function() {
  $.ajax({
    url: "/atencion/registerserviced",
    type:"GET",
    data:{},
    beforeSend: function () {
    },
  }).done( function(d) {
    $.fn.fillDataTable2(d.data);
  }).fail( function(error) {
    console.log(error);
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });
}

function viewModal1(elem){
  $.ajax(
    {
      url  : "/atencion/getReportAtention",
      type : "POST",
      data : {  id: elem},
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      $("#modal-view-regs").modal('show');
      $('.codeticr').html(d.data.nro_ticket);
      $('.typecustr').html(d.data.get_customer_type.description);
      var pizza = d.data.created_at;
      var porciones = pizza.split(' ');
      $('#dateatencionr').html(porciones[0]+' <i style="background: rgba(255, 226, 43,0.5)  "class="fa fa-calendar"></i>');
      $('#namer').html(d.data.get_customer.first_name);
      $('#lastnamer').html(d.data.get_customer.last_name);
      $('#typedocumentr').html(d.typedocu.description);
      $('#numberdocr').html(d.data.get_customer.dni);
      $('#correor').html(d.data.get_customer.email);
      $('#telephoner').html(d.data.get_customer.phone);
      $('#Agentr').html(d.data.get_assigned.name+' '+d.data.get_assigned.lastname);
      $('#moduler').html(d.data.nro_modulo);
      if (d.data3 != null){
        $('#typegestionr').html(d.data3.get_type_requirements.description);
        $('#tgestionr').html('#'+d.data3.nro_ticket);
        $('#areagestionr').html(d.data3.get_groups.description);
      }else{
        $('#typegestionr').html('');
        $('#tgestionr').html('');
        $('#areagestionr').html('');
      }
      if (d.data.id_status_att == 7){
        $('#statert').html('<button type="button" data-id="'+d.data.id+'" class="btn btn-danger updateRG" style="background: none !important; font-size: 20px;"><i style="color: #629c44 !important;" class="fa fa-times-circle"></i> ESTADO</button>');
      }else{
        $('#statert').html('<button type="button" class="btn btn-danger" style="background: none !important; font-size: 20px;"><i style="color: #5cb85c !important;" class="fa fa-check-square"></i> ESTADO</button>');
      }
      $('#timelineid').html(d.timeline);
      alertify.notify(d.message,d.object,2, function(){});
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
  });
}

$.fn.fillDataTable    = function(data) {
  var table= $('#modatention').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      "scrollX": true,
      "scrollY": true,
      "bFilter": false,
      "bPaginate": false,
      "bInfo": false,
      data: data,
      "columns":[
          {data:"nromodulo"},
          {data:"name"},
          {data:"view"}
    ]
  });
}

$.fn.fillDataTable1    = function(data) {
  var table= $('#servicedesk').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      "scrollX": true,
      "scrollY": true,
      "bFilter": false,
      "bPaginate": false,
      "bInfo": false,
      data: data,
      "columns":[
          {data:"name"},
          {data:"typename"},
          {data:"typegestion"},
          {data:"code"},
    ]
  });
}

$.fn.fillDataTable2    = function(data) {
  var table= $('#registerserviced').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      "scrollX": true,
      "scrollY": true,
      "bFilter": false,
      "bInfo": false,
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
      data: data,
      "columns":[
          {data:"name"},
          {data:"typename"},
          {data:"typegestion"},
          {data:"status"},
          {data:"code"},
          {data:"date"},
          {data:"details"},
    ]
  });
}

$.fn.serializeObject  = function(){
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
