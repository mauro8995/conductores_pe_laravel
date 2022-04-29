$('#cod_country').select2();
$('#cod_state').select2();
$('#cod_city').select2();
$('#cod_pago').select2();
$( "#lastname_inv" ).prop( "disabled", true );
$( "#name_inv" ).prop( "disabled", true );
$( "#dni_inv" ).prop( "disabled", true );
$( "#search_inv" ).prop( "disabled", true );
$('.customer-data-hide').hide();
$('#divoperacion').hide();
$('#cont_voucher_pago').hide();
$('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
var accionista = false;
var sponsorinv = false;
var actulizarinv = false;

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });



$( "#search_customer" ).click(function() {
  var d = $('#dni').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese de documento de identidad nacional o DNI o Cédula de identidad o CURP.");
    $('#dni').css("border", "2px solid red");
  }
  else
  {
    getCustomer();
  }

});

$( "#search_inv" ).click(function() {
  var d = $('#dni_inv').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese de documento de identidad nacional o DNI o Cédula de identidad o CURP.");
    $('#dni_inv').css("border", "2px solid red");

  }
  else
  {
    getCustomerInv();
  }

});


//buscar invitado
function getCustomerInv()
{
  valor= $('#dni_inv').val();

  $.ajax(
  {
    url: "/customer/register/get",
    type:"POST",
    data : { dni: valor },//
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(300);
  }
  }).done(function(d)
  {
    $('#load_inv').hide(300);
    if(d.objet != "error")
    {
      //customer
      $('#name_inv').val(d.data.first_name);
      $('#lastname_inv').val(d.data.last_name);
      sponsorinv = true;
    }
    else
    {
      sponsorinv = false;

      $('#name_inv').val("");
      $('#lastname_inv').val("");

      alert("El usuario no se encuentra registrado.");
    }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  });
}//fin del customer invitado

function getCustomer()
{
  valor= $('#dni').val();
  getCustomerByApi(valor);

  $.ajax(
    {
      url: "/customer/register/get",
      type:"POST",
      data : { dni: valor },//
      dataType: "json",
      beforeSend: function () {
        $('#load_customer').show(300);
      }
    }).done(function(d)
    {
      $('#load_customer').hide(300);
      $('#search_inv').attr("disabled", true);
      if(d.objet != "error")
      {
        //customer
        $('.customer-data-hide').hide();
        $('#first_name').val(d.data.first_name);
        $('#last_name').val(d.data.last_name);
        $('#first_name').prop( "disabled", true );
        $('#last_name').prop( "disabled", true );
        accionista = true;
        //invitado
        if(d.inv != null)
        {
          $( "#dni_inv" ).prop( "disabled", true );
          $('#dni_inv').val(d.inv.dni);
          $('#lastname_inv').val(d.inv.last_name);
          $('#name_inv').val(d.inv.first_name);
          $('#lastname_inv').val(d.inv.last_name);
          sponsorinv = true;
        }
        else
        {
          actulizarinv = true;
          $( "#dni_inv" ).prop( "disabled", false );
          $('#search_inv').attr("disabled", false);
          $('#dni_inv').val("");
          $('#lastname_inv').val("");
          $('#name_inv').val("");
          $('#lastname_inv').val("");
          sponsorinv = false;
        }

      }
      else
      {
        $('#first_name').prop( "disabled", false );
        $('#last_name').prop( "disabled", false );
        $('.customer-data-hide').show();
        $( "#dni_inv" ).prop( "disabled", false );
        $('#first_name').val("");
        $('#last_name').val("");
        $('#phone').val("");
        $('#email').val("");
        $("#cod_country").val("").change();
        $('#cod_state').val("").change();
        $('#cod_city').val("").change();
        $('#district').val("");
        $('#dni_inv').val("");
        $('#lastname_inv').val("");
        $('#name_inv').val("");
        $('#lastname_inv').val("");

        $('#search_inv').attr("disabled", false);
        alert("El usuario no se encuentra registrado.");
        accionista = false;
      }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
  }//fin del customer invitado

function getCustomerByApi(dni){
  $.ajax(
  {
    url: "/customer/getCustomerByApi",
    type:"POST",
    data : { dni: dni },//
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(300);
  }
  }).done(function(d)
  {
    $('#load_inv').hide(300);
    if(d.objet != "error")
    {
      //customer
      $('#name_inv').val(d.data.first_name);
      $('#lastname_inv').val(d.data.last_name);
      sponsorinv = true;
    }
    else
    {
      sponsorinv = false;

      $('#name_inv').val("");
      $('#lastname_inv').val("");

      alert("El usuario no se encuentra registrado.");
    }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  });
}


//
$("#dni_inv").keydown(function(event){
      $('#name_inv').val("");
      $('#lastname_inv').val("");
	});

  var respuestaDniInvValidate = false;
  var respuestaDniShareValidate = false;

   $('#dni').keyup(function() {
   validateDNIShareholder();
  });

  function validateDNIShareholder()
  {
    var id = $('#dni').val();
    numcar = id.length;

    if (numcar > 5){
    $.ajax(
      {
        url: "/customer/register/valiteDNI",
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
  }
  //-------- Obtener stado
  $(document).on('change', '#cod_country', function(event) {
       var id = $("#cod_country option:selected").val();
       $('.alertpaisacc').remove();
       $('.depval').show();

       $.ajax(
         {
           url: "/customer/register/getState",
           type:"POST",
           data : {  id: id},//
           dataType: "json",
         }).done(function(d)
         {

           $('#cod_state').empty();
           var fila = '<option value="">Seleccione...</option>';
           $.each(d,function(key, registro)
           {
             fila += '<option value='+registro.id+'>'+registro.description+'</option>';
           });
           $("#cod_state").append(fila);

         }).fail(function(){
           alert("No se cargaron los datos para el departamento, por favor intente de nuevo.");//alerta del ticket no resgistrado
         });
  });
  //obtener city
  $(document).on('change', '#cod_state', function(event) {
       var id = $("#cod_state option:selected").val();
       $.ajax(
         {
           url: "/customer/register/getCity",
           type:"POST",
           data : {  id: id},//
           dataType: "json",
         }).done(function(d)
         {

           $('#cod_city').empty();
           var filas = '<option value="">Seleccione...</option>';
           $.each(d,function(key, registro)
           {
             filas += '<option value='+registro.id+'>'+registro.description+'</option>';

          });
            $("#cod_city").append(filas);

         }).fail(function(){
           alert("No se cargaron los datos para la provincia, por favor intente de nuevo.");//alerta del ticket no resgistrado
         });
  });
  //validar tipo de Pago
  $(document).on('change', '#cod_pago', function(event) {
       var id = $("#cod_pago option:selected").val();
       $('#number_operation').val("");
       if (id == 2 || id == 9 || id == ""){
         $("#divoperacion").hide();
       }else{
         $("#divoperacion").show();
         $('#cont_voucher_pago').removeAttr("style",'display:none;');
       }
  });

//validar letras
function validaLetras(event) {
      if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
        return true;
       }
       return false;
  }
  //al borar el dni borrar los daots
  var input_inv = $('#dni');
  input_inv.on('keydown', function() {
    if(event.keyCode == 9){
    }else{
      var key = event.keyCode || event.charCode;
        $("#last_name").val("");
        $("#first_name").val("");
        $("#dni_inv").val("");
        $("#name_inv").val("");
        $("#lastname_inv").val("");
    }
  });
  //accion comprar
  function comprar()
  {
   var registrar = false;
   if (accionista == false){
     var validar = validarcustomer();
     if (validar == true){
        if ($("#cod_pago option:selected").val() != ""){
          if ($("#cod_pago option:selected").val() == 2 || $("#cod_pago option:selected").val() == 9){
             registrar = true;
          }else if ($("#number_operation").val() != ""){
             if ($("#voucher_pago").val() != null){
               registrar = true;
             }else{
               alert('Falta seleccionar voucher de pago');
               $("#voucher_pago").focus();
             }
          }else{
            alert('¡Falta completar codigo de operación!');
            $("#number_operation").focus();
          }
        }else{
          alert('Por favor, seleccione tipo de pago.');
          $("#cod_pago").focus();
        }
     }else{
       validar;
     }
   }else if (accionista == true && sponsorinv == true){
     if ($("#cod_pago option:selected").val() != ""){
         if ($("#cod_pago option:selected").val() == 2 || $("#cod_pago option:selected").val() == 9){
            registrar = true;
         }else if ($("#number_operation").val() == ""){
            alert('¡Falta completar el código de operación!');
            $("#number_operation").focus();
         }else if ($("#date_pay").val() == ""){
           alert('¡Falta completar fecha de pago!');
           $("#date_pay").focus();
         }else{
           registrar = true;
         }
     }else{
       alert('Por favor, seleccione tipo de pago.');
       $("#cod_pago").focus();
     }
   }else{
     alert('El patrocinador o sponsor debe estar registrado.');
     $("#dni_inv").focus();
   }

    $( "#dni" ).prop( "disabled", false );
    $( "#first_name" ).prop( "disabled", false );
    $( "#last_name" ).prop( "disabled", false );
    $( "#phone" ).prop( "disabled", false );

    var dni = $('#dni').val();
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var cod_country = $('#cod_country').val();
    var cod_state = $('#cod_state').val();
    var cod_city = $('#cod_city').val();
    var district = $('#district').val();
    var cod_product = $('#cod_product').attr("data-id");
    var id_price = $('#id_price').attr("data-id");
    var id_pay = $("#cod_pago option:selected").val();
    var nro_ope = $("#number_operation").val();
    var note = $("#note").val();
    var date_pay = $("#date_pay").val();

    var customer =
    {
      dni:dni,
      first_name:first_name,
      last_name:last_name,
      phone:phone,
      email:email,
      id_country:cod_country,
      id_state:cod_state,
      id_city:cod_city,
      district:district,
      actulizar:false,
      note: note
    };

    var pay =
    {
      id_pay: id_pay,
      nro_ope: nro_ope,
      date_pay: date_pay
    }

    var product =
    {
      cod_product: cod_product,
      id_price: id_price
    };


    var dniInv = $('#dni_inv').val();

    var invitado =
    {
      dni: dniInv,
      actulizar: actulizarinv
    };

    if (registrar == true){
      $.ajax(
        {
          url: "/customer/register/exeterno",
          type:"POST",
          data : {  customer: customer,invitado:invitado,product:product,pay:pay},
          dataType: "json",
        }).done(function(d)
        {
          if(upimg(d.id_ticket))
          {
           window.location.href = "/checkout/ticket/"+d.id_ticket;
          }
        }).fail(function(error){
          console.log(error);
          alert("No se registró, intente nuevamente por favor.");
        });
    }
  }



  function validarcustomer(){
    alert($("#date_pay").val());

    if ($("#dni").val() != ""){
      if ($("#first_name").val() != ""){
        if ($("#last_name").val() != ""){
          if ($("#phone").val() != ""){
             if ($("#email").val() != ""){
               if ($("#cod_country option:selected").val() != ""){
                 if ($("#cod_state option:selected").val() != "Seleccione..."){
                   if ($("#cod_city option:selected").val() != "Seleccione..."){
                     if ($("#district").val() != ""){
                       if (sponsorinv == true){
                          return true;
                       }else{
                          alert('El sponsor tiene que estar registrado');
                          $("#dni_inv").focus();
                       }
                     }else{
                       alert('!Falta completar la dirección!');
                       $("#district").focus();
                     }
                   }else{
                     alert('¡Falta indicar la provincia!');
                     $("#cod_city").focus();
                   }
                 }else{
                   alert('¡Falta indicar el departamento!');
                   $("#cod_state").focus();
                 }
               }else{
                 alert('¡Falta indicar el país!');
                 $("#cod_country").focus();
               }
             }else{
               alert('¡Falta completar su correo electrónico!');
               $("#email").focus();
             }
          }else{
            alert('¡Falta completar su teléfono!');
            $("#phone").focus();
          }
        }else{
          alert('¡Falta completar sus apellidos!');
          $("#last_name").focus();
        }
      }else{
        alert('¡Falta completar sus nombres!');
        $("#first_name").focus();
      }
    }else{
      alert('¡Falta completar su DNI!');
      $("#dni").focus();
    }
  }

  fichero = document.getElementById("voucher");
  function upimg(id_ticket)
  {//inicio up img

    if($("#voucher").is(':visible'))
    {
      var respuesta = false;
      if (fichero.files.length >= 1){
        var metadata = {
          contentType: 'image/jpeg'
        };
      storageRef = firebase.storage().ref();
      var imagenASubir = fichero.files[0];
      var uploadTask = storageRef.child('imgPago/' + id_ticket).put(imagenASubir, metadata);
      uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
      function(snapshot){
      //se va mostrando el progreso de la subida de la imagenASubir
      var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
      console.log('Upload is ' + progress + '% done');

      }, function(error) {
        console.log('Ha ocurrido un inconveniente al tratar de subir la imágen '+error);
        //gestionar el error si se produce
        alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
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
            console.log('exito '+downloadURL);
          }).fail(function(error){
            console.log('No se enlazo la imágen con el ticket '+error);
            alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
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
  }
