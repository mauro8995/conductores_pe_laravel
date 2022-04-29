var valorAccion = 0;
$( "#dni_inv" ).prop( "disabled", true );
$( "#lastname_inv" ).prop( "disabled", true );
$( "#name_inv" ).prop( "disabled", true );
$('#cont_voucher_pago').hide();
$('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
var numberOrperation = false;
$(document).ready(function()
{
  //
  $('input:radio[name="customer"]').filter('[value="T"]').attr('checked', true);
  $('input:radio[name="invited_by"]').filter('[value="T"]').attr('checked', true);
  $("#myform").attr('autocomplete', 'off');//desactiva el auto completado
  $('.no').attr("style",'display:none;');
  $('#cont_voucher_pago').attr("style",'display:none;');
  $("#pagar").prop('disabled', true);
  if($('#pagar').val() == 0) {
      $('#btnCreateShareholder').attr("disabled", true);
  }

  $('.depval').hide();
  $('.proval').hide();
  var f = new Date();


  $('#date_pay').datepicker({
      today: "Today",
      clear: "Clear",
      autoclose: true,
      format: "yyyy/mm/dd",
      startDate: "2018/02/01",
      endDate: f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate()
    });
  //Timepicker
  $('.timepicker').timepicker({
      showMeridian: false,
      showInputs: false,
      format: 'HH:mm:ss',
      minuteStep: 1,
      showSeconds: true,
      maxDate : 'now'

    }).on('changeTime.timepicker', function(e) {
    var h= e.time.hours;
    var m= e.time.minutes;
    var mer= e.time.meridian;
    //convert hours into minutes
    m+=h*60;
    //10:15 = 10h*60m + 15m = 615 min
    if(mer=='AM' && m<615)
        $('.timepicker').timepicker('setTime', '10:15:14');
  });;

  $("#id_customer").change(function(){
      $('.alertaccionista').remove();
  });
  $("#id_invited_by").change(function(){
      $('.alertinvitado').remove();
  });

  $("#id_country_invs").change(function(){
      $('.alertpais').remove();
  });
  $("#cod_pago").change(function(){
      $('.alertpago').remove();
  });


  $('.select2').select2();
  fillTable();
  function fillTable()//Inicio Fill
  {
    $.ajax({
      url: "/tickets/products",
      type:"get",
      beforeSend: function () {
            },
    }).done( function(d) {
      $('#tbProducts').DataTable({
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
        {data:"cod_product"},
        {data:"name_product"},
        {data:"cant"},
        {data:"sale_price"},
        {data:"money"},
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {
                   return '<button type="button" class="btn btn-primary btn_agregarCarrito fa fa-opencart"></button>';
               }
        }
    ]
    });

  }).fail( function() {

  }).always( function() {

    });
  }//fin de fillTable

  //Obtener Pais
  var codigoPais;
  var ip;
  $.getJSON('https://api.ipify.org?format=json', function (data) {
      ip = data.ip;
  });

  $.getJSON('http://www.geoplugin.net/json.gp?ip='+ip, function (data) {
      codigoPais = data.geoplugin_countryCode;
  });

//recorrer un div
function valNull(variable)
{
  var id;
  var respuesta = false;
  $( variable ).each(function( index )
  {
    id = '#'+$(this).attr('id');
    if($( this ).val()=="")
    {
      $(id).attr('style',  'border:5px solid red');
      $(id).focus();
      respuesta = false;
    }
    else
    {
      if($(id).attr("style"))
      $(id).removeAttr('style',  'border:5px solid red');
      respuesta = true;
    }
  });
  return respuesta;
}

function valiteCompra()
{
      var respuesta = false;
      if($('#cod_pago').val()=="")
      {
        alert("Selecciona el tipo de pago");
        $("#cod_pago").focus();
          $('#id_country_invs').removeAttr('style',  'border:5px solid red');
       return respuesta = false;
      }

      else if($('#id_country_invs').val()=="")
      {
        alert("Seleccione pais a invertir");
        $("#id_country_invs").focus();
          $('#id_country_invs').removeAttr('style',  'border:5px solid red');
        return respuesta = false;
      }
      else
      {
        if($("#cont_voucher_pago").is(':visible') && document.getElementById("voucher").files.length == 0 )
        {
          alert('Sube el Vaucher');
            $('#cont_voucher_pago').focus();
              $('#cont_voucher_pago').removeAttr('style',  'border:5px solid red');
            return respuesta = false;
        }

        else if ($("#number_operation").is(':visible') && $("#number_operation").val() == "")
        {
            alert('Llene el número de operación');
            $('#number_operation').focus();
            $('#number_operation').css("border", "2px solid red");
            return respuesta = false;
        }
        else if(!numberOrperation && $("#number_operation").is(':visible'))
        {
          alert('Número operación ya existe');
          $('#number_operation').focus();
          return respuesta = false;
        }
        else
        {
            return respuesta = true;
        }
          return respuesta = true;
      }

}


function registerTicket()
{
  //----------------------
  $( "#first_name" ).prop( "disabled", false );
  $( "#last_name" ).prop( "disabled", false );
  $( "#phone" ).prop( "disabled", false );
  $( "#email" ).prop( "disabled", false );
  $( "#name_inv" ).prop( "disabled", false );
  $( "#lastname_inv" ).prop( "disabled", false );
  $( "#dni_inv" ).prop( "disabled", false );
  //agregar

  //------
  $.ajax(
    {
      url: "/customer/store",
      type:"POST",
      data : {  customer : $( '#myform' ).serializeObject(), codigoPais :codigoPais},//
      dataType: "json",
      beforeSend: function () {
        $('.docs-example-modal-sm').modal('toggle');
            },
    }).done(function(d)
    {
      console.log(d);
      if(d.answer)
      {
        if(upimg(d.id_ticket))
        {
          $("form select").each(function() { this.selectedIndex = 0 });
          $("form input[type=text] , form textarea").each(function() { this.value = '' });
          $("form input[type=email] , form textarea").each(function() { this.value = '' });
          $("#cod_city" ).empty();
          $("#cod_state" ).empty();

          $(".select2").select2({
              placeholder: "Seleciona"
          });
          $(".cuerpo").empty();
          $('.btn_shoping').attr("disabled", false);
          document.getElementById("voucher").value = "";
          alertify.confirm('Registrado', '¡El accionista ha sido registrado exitosamente! Desea Descargar el Ticket generado', function(){
              alertify.success('Procesando');
              window.location.href = "/tickets/pdf/"+d.id_ticket+"";
          },function(){

          }).set({labels:{ok:'Descargar Ticket', cancel: 'No Descargar'}, padding: false});
        }else
        {
          alert("No se pudo subir la imagen.");
        }
      }else
      {
        alert("no se pudo resgistrar Correctamente el ticket");
      }
      $('.docs-example-modal-sm').modal('hide');
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });

    $( "#name_inv" ).prop( "disabled", true );
    $( "#lastname_inv" ).prop( "disabled", true );
    $( "#dni_inv" ).prop( "disabled", true );
}

        $('.btn_ajax').on('click',function(){
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          var dni = $('#dni').val().length;
          var dniinv = $('#dni_inv').val().length;
          var nFilas = $("#tabla tbody tr").length;
          if(nFilas!=0)
          {
            if($('#user_inv').val() == "")
           {
             alert("Ingrese el Invitado");
             $("#dni_inv").focus();
           }else
           {

                if($('input:radio[name=customer]:checked').val() == 'F' )
               {
                 if(validateDNIShareholder())
                 {
                   if(valNull(".customer input"))
                   {
                     if($( "#cod_country" ).val() == "")
                     {
                       alert("Ingrese El pais");
                       $("#cod_country").focus();
                     }

                     else if($("#cod_state").val() =="Seleccionar departamento")
                     {
                       alert("Ingrese Departamento");
                       $("#cod_state").focus();
                     }
                     else if($("#cod_city").val() =="Seleccionar provincia")
                     {
                       alert("Ingrese Provincia ");
                       $("#cod_city").focus();
                     }
                     else if($("#district").val()=="")
                     {
                       alert("Ingrese lugar donde vive(Dirección)");
                       $("#cod_city").focus();
                     }
                     else if(valiteCompra())
                     {
                       registerTicket();
                     }
                   }
                 }
                 else{
                   alert("El DNI ya está registrado.");
                 }

               }else if($('input:radio[name=customer]:checked').val() == 'T' && $("#id_customer").val()=="")
               {
                 alert("Ingresa Accionista");
               }else if(valiteCompra())
               {
                   registerTicket();
               }

           }

          }else
          {
            alert("Ingresa Un Producto");
            $("#tabla").focus();
          }



        });


//-----------------------------------
$(document).on('click', '.btn_eliminar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
    getMontoPagar();
    $('.btn_shoping').prop('disabled', false);
});

//-------------------inicio del select
//-------------------
        $('#service').delayPasteKeyUp(function()
       {
            if($('#service').val().length > 0)
            {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
              var listar = $.ajax(
            {
                type: "POST",
                url: "/searchShareholder",
                data: {dato: $('#service').val()},
                success: function(d)
                {
                  console.log(d.shareholder);
                  if(d != "")
                  {
                    $("#Usuario-lista").empty();
                    //Escribimos las sugerencias que nos manda la consulta
                        $.each(d.shareholder, function(id,value)
                        {
                          $("#Usuario-lista").append('<option value="'+value.cod_shareholder+'">'+
                          value.first_name+ " - "+
                          value.last_name+" - "+
                          value.dni+
                          '</option>');
                        });
                  }
                  else console.log("Cadena vacia");


                }
            });
            }
            else{console.log("No hay datos");}

        }, 500);//fin del buscar accionista

        $( "#Usuario-lista" ).click(function()
           {
              var s = $.trim($( "#Usuario-lista option:selected" ).val());//obtiene el usuario
              $("#cod_shareholder").val(s);

           });


// ---------------------------------




// ---------------------------------


});//fin del document

function getCustomerWinIstoShare()
{
  var valor = $("#dni").val();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerWinIstoShareAndTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_shareholder').show(300);
            }
    }).done(function(d)
    {
      $('#load_shareholder').hide(300);

      if(d.mensaje.length === 0)
      {
        alert("No se encontro Datos en Winistoshare.com ni en taxiwin.in");
      }
      $.each(d.mensaje, function( k, v )
      {
         $("#first_name").val(v.first_name);
         $("#last_name").val(v.last_name);
         $("#phone").val(v.phone);
         $("#email").val(v.email);
      });
      $( "#first_name" ).prop( "disabled", true );
      $( "#last_name" ).prop( "disabled", true );
      $( "#phone" ).prop( "disabled", true );
      $( "#email" ).prop( "disabled", true );
      action = 0;
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}
//obtener el invitado desde taxiwin.in
function getCustomerTaxiWin()
{
  var valor = $("#user_inv").val();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerRedTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_inv').show(300);
            }
    }).done(function(d)
    {
      $('#load_inv').hide(300);

      if(d.mensaje.length === 0)
      {
        alert("No se encontro Datos en taxiwin.in");
      }
      else
      {
        $.each(d.mensaje, function( k, v )
        {
           $("#dni_inv").val(v.dni);
           $("#name_inv").val(v.first_name);
           $("#lastname_inv").val(v.last_name);
        });
        $( "#dni_inv" ).prop( "disabled", true );
        $( "#name_inv" ).prop( "disabled", true );
        $( "#lastname_inv" ).prop( "disabled", true );
      }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}
//al precionar borrar
jQuery(function($) {
  var input = $('#dni');
  input.on('keydown', function() {
    var key = event.keyCode || event.charCode;
      $( "#first_name" ).prop( "disabled", false );
      $( "#last_name" ).prop( "disabled", false );
      $( "#phone" ).prop( "disabled", false );
      $( "#email" ).prop( "disabled", false );
      $("#first_name").val("");
      $("#last_name").val("");
      $("#phone").val("");
      $("#email").val("");

  });

  var input_inv = $('#user_inv');
  input_inv.on('keydown', function() {
    if(event.keyCode == 9)
    {

    }else{
      var key = event.keyCode || event.charCode;
        $("#dni_inv").val("");
        $("#name_inv").val("");
        $("#lastname_inv").val("");
    }

  });


});



function onKeyDownHandler(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      getCustomerWinIstoShare();
    }

}
function onKeyDownHandlerInv(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      getCustomerTaxiWin()
    }

}


//validar números
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;
}

//no permite copiar
$(document).ready(function(){
  $("#dni").on('paste', function(e){
    //e.preventDefault();
  })

  $("#dni").on('copy', function(e){
    e.preventDefault();
  })

  //validar valideEmail
  $('.keyup-email').keyup(function() {
      $('span.error-keyup-7').remove();
      var inputVal = $(this).val();
      var emailReg = /^([\w-+\.]+@([\w-]+\.)+[\w-+]{2,4})?$/;
      if(!emailReg.test(inputVal)) {
          //$(this).after('<span class="error error-keyup-7">Formato Inválido</span>');
          $('#btnCreateShareholder').attr("disabled", true);
          $(this).css("border", "2px solid red");
      }else{
        $(this).css("border", "2px solid green");
        $('#btnCreateShareholder').attr("disabled", false);
      }
  });

  //validar registro







//vaidar tipo Pago
$("#cod_pago").change(function(){
                var op = $("#cod_pago option:selected").text();
                if(op == "DEPÓSITO")
                {
                  $('#textCodigoOperacion').html("Número de oparación");
                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                  $('#number_operation').attr("onkeypress",'return validaNumericos(event)');
                  $('.no').removeAttr("style",'display:none;');
                }
                else if(op == "POCKET")
                {
                  $('#textCodigoOperacion').html("Número de oparación");
                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                }
                else if(op == "TRANSFERENCIA")
                {

                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                }
                else if(op == "EFECTIVO")
                {
                  $('.no').attr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');
                }
                else{
                  $('#textCodigoOperacion').html("Hash");
                  $('#number_operation').removeAttr("onkeypress");
                  $('.no').removeAttr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');
                }
                $('#number_operation').val("");
        });

})

//validar solo letras
function validaLetras(event) {
    if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
      return true;
     }
     return false;
}

//maximo de caracteres..

var inputs = "input[maxlength], textarea[maxlength]";
    $(document).on('keyup', "[maxlength]", function (e) {
        var este = $(this),
            maxlength = este.attr('maxlength'),
            maxlengthint = parseInt(maxlength),
            textoActual = este.val(),
            currentCharacters = este.val().length;
            // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
            if (document.addEventListener && !window.requestAnimationFrame) {
                if (remainingCharacters <= -1) {
                    remainingCharacters = 0;
                }
            }
            if (!!maxlength) {
                var texto = este.val();
                if (texto.length >= maxlength) {
                    e.preventDefault();
                }
                else if (texto.length < maxlength) {
                }
            }
        });

//-------- Obtener stado
$(document).on('change', '#cod_country', function(event) {
     var id = $("#cod_country option:selected").val();
     $('.alertpaisacc').remove();
     $('.depval').show();
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getState",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_state').empty();
         var fila = '<option>Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state").append(fila);

       }).fail(function(){
         alert("No trajo datos de los estados ");//alerta del ticket no resgistrado
       });
});
//---------------------

//-------- Obtener Cuidad
$(document).on('change', '#cod_state', function(event) {
     var id = $("#cod_state option:selected").val();
     $('.alertdepacc').remove();
     $('.proval').show();
     //alert("entre");
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getCity",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_city').empty();
         var filas = '<option>Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city").append(filas);

       }).fail(function(){
         alert("No se Registro Intente Nueva Mente");//alerta del ticket no resgistrado
       });
});
//---------------------

$(document).on('change', '#cod_city', function(event) {
   $('.alertprovacc').remove();
});

function getInvited(){
  if ($('input:radio[name=invited_by]:checked').val() == 'F'){
      $('.invited').show(1000);      $('.invite_true').hide(1000);
      $(document).ready(function() {
        $('.invited').find('input:text').val('');
        $('#id_invited_by').select2().val('');
        $('#id_invited_by').select2().val('');

      });

  }
  if ($('input:radio[name=invited_by]:checked').val() == 'T'){
     $('.invited').hide(1000);      $('.invite_true').show(1000);
     $('#id_invited_by').select2().val('');      $('#id_invited_by').select2().val('');

  }
}
function getCustomer(){
  if ($('input:radio[name=customer]:checked').val() == 'F'){
    $('.dniselect').hide(1000);
    $('.customer').show(1000);
    $(document).ready(function()
    {
      $('.customer').find('input:text').val('');
      $("form input[type=email] , form textarea").each(function() { this.value = '' });
      $('#id_customer').select2().val('');
      $('#id_customer').select2().val('');

    });

  }
  if ($('input:radio[name=customer]:checked').val() == 'T'){
     $('.dniselect').show(1000);
     $('.customer').hide(1000);
     $('#id_customer').select2().val('');
     $('#id_customer').select2().val('');
  }
}



$('.valOperation').keyup(function() {
     var id = $(this).val();
     var fecha = $('#date_pay').val();
     var hora = $('#hour_pay').val();


     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/valiteOperation",
         type:"POST",
         data : {  cod: id , date:fecha,hour:hora},//
         dataType: "json",
       }).done(function(d)
       {
         if(d.mensaje){
           numberOrperation = false;
           console.log(numberOrperation);
           $('.alertoperation').remove();
          $('.valOperation').css("border", "2px solid Red");
          $('.valOperation').after("<span  class='alertoperation' style='color: red;'>*Existe ese numero de operación</span>");
        }else{
          numberOrperation = true;
          console.log(numberOrperation);
        $('.valOperation').css("border", "2px solid green");
        $('.alertoperation').remove();
      }
       }).fail(function(){

       });
});

$('#first_name').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#first_name').css("border", "2px solid green");
  }
});

$('#district').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#district').css("border", "2px solid green");
  }
});

$('#name_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#name_inv').css("border", "2px solid green");
  }
});

$('#lastname_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#lastname_inv').css("border", "2px solid green");
  }
});

$('#dni_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#dni_inv').css("border", "2px solid green");
  }
});



$('#last_name').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#last_name').css("border", "2px solid green");
  }
});

$('#phone').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#phone').css("border", "2px solid green");
  }

});



var respuestaDniInvValidate = false;
var respuestaDniShareValidate = false;
 $('#dni').keyup(function() {
 validateDNIShareholder();
});


$('#dni_inv').keyup(function(e) {
     //valDNI();
});

function validateDNIShareholder()
{
  var id = $('#dni').val();
  numcar = id.length;

  if (numcar > 5){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/customer/valiteDNI",
      type:"POST",
      data : {cod: id },
      dataType: "json",
    }).done(function(d)
    {
      if(d.mensaje){
         $('.alertdni').remove();
         $('#dni').css("border", "2px solid red");
         $('#dni').focus();
       respuestaDniShareValidate = false;
     }else{
       $('#dni').css("border", "2px solid green");
       $('.alertdni').remove();
       respuestaDniShareValidate = true;
   }
    }).fail(function(){

    });
  }
  return respuestaDniShareValidate;
}

$(document).on('click', '.btn_agregarCarrito', function() {

//valores obtendra el dato del td por posciones [0]
var valor0 = $(this).parents("tr").find("td").eq(0).text();
var valor1 = $(this).parents("tr").find("td").eq(1).text();
var valor2 = $(this).parents("tr").find("td").eq(2).text();
var valor3 = $(this).parents("tr").find("td").eq(3).text();
var valor4 = $(this).parents("tr").find("td").eq(4).text();

valorAccion = valor2;
var fila = '<tr>'+
          '<td>'+valor0+'</td>'+
          '<td>'+valor1+'</td>'+
          '<td>'+valor2+'</td>'+
          '<td>'+valor3+'</td>'+
          '<td>'+valor4+'</td>'+
          '<td>'+"1"+'</td>'+
          '<td><button type="button" class="btn btn-danger btn_eliminar" monto="'+valor4+'">Eliminar</button>'+
          '<div class="input-group"><input  id="cod_product" name="cod_product" class="form-control" type="hidden" value="'+valor0+'"></div></td>'
          +'</tr>';

$("#tabla").append(fila);
$('#myModal').modal('toggle');
getMontoPagar();
$('#btnCreateShareholder').attr("disabled", false);
$('.btn_shoping').prop('disabled', true);
});
function getMontoPagar() {
  var arreglo = [];
  $('#tabla tr').each(function ()
    {
       arreglo.push($(this).find("td").eq(3).html());

     });
   n   = arreglo.length,
   sum = 0;
   while(n--)
  sum += parseFloat(arreglo[n]) || 0;

   $("#pagar").val("");
   $('#pagar').val(sum);
}


// -------------------------------------------------------------------------------------------------------------------------------------

fichero = document.getElementById("voucher");
function upimg(id_ticket)
{//inicio up img

  if($("#voucher").is(':visible'))
  {
    var respuesta = false;
    if (fichero.files.length >= 1){
    storageRef = firebase.storage().ref();
    var imagenASubir = fichero.files[0];
    var uploadTask = storageRef.child('imgVoucher/' + id_ticket).put(imagenASubir);
    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
    function(snapshot){
    //se va mostrando el progreso de la subida de la imagenASubir
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    console.log('Upload is ' + progress + '% done');

    }, function(error) {
      //gestionar el error si se produce
      alert('Exite un error al tratar de subir la imagen');
    }, function() {
      //cuando se ha subido exitosamente la imagen
      pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
        var data = {
        'id_ticket': id_ticket,
        'voucherURL': downloadURL,
        'voucherName': imagenASubir.name};

        $.ajax({
          type: "POST",
          url: "/tickets/imgSave",
          type:"POST",
          data : data,
          dataType: "json",
        }).done(function(d){
          respuesta = true
        }).fail(function(){
          alert("No se enlaso la imagen con el ticket");
          respuesta = false;
        });


        });
      });


      respuesta = true;
    }else{
  respuesta = false;
    }
  }
  else respuesta = true;

  return respuesta;
}//fin de up img



// ----------------------------------------------------------------------------------------------------------------------------------------

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

$.fn.delayPasteKeyUp = function(fn, ms)
{
 var timer = 0;
 $(this).on("keyup paste", function()
 {
 clearTimeout(timer);
 timer = setTimeout(fn, ms);
 });
};
