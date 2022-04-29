$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$('input').prop('readonly', false);
type();
function type()
{
  $.ajax({
    url: "/evento/get/documento",
    type:"post",
    beforeSend: function () {
    },
  }).done( function(d) {
    if(d.object == "success")
    {
      var carrera = document.getElementById("tipo_doc"); /* Para no tener que llamar a cada rato a getElementById */
      for(var i=0;i<d.data.length;i++){
        carrera.options[i] = new Option(d.data[i].description,d.data[i].id);
       }
    }

  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {


  });
}

function data_id()
{
  if($("#id_office").val().length > 0)
{
  $.ajax({
    url: "/evento/get/id",
    type:"post",
    data:{id_office:$('#id_office').val()},
    beforeSend: function () {
    },
  }).done( function(d) {
    if(d.object == "success")
    {
      $('#first_name').val(d.data.first_name);
      $('#last_name').val(d.data.last_name);
      $('#phone').val(d.data.phone);
      $('#email').val(d.data.email);
      $('#dni').val(d.data.dni);
      $('#id_viaje').val(d.data.id_viaje);
      document.getElementById("tipo_doc").value = d.data.id_type_documents;
    }else {
      alert(d.menssage);
    }

  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {
  });
}else {
  alert('ingrese ID.');
}


}

function data_dni()
{
    if($("#dni").val().length > 0)
    {
      var select = document.getElementById("tipo_doc");
      var index = select.selectedIndex;
      $.ajax({
        url: "/evento/get/dni",
        type:"post",
        data:{dni:$('#dni').val(),
              id_type_documents:select.options[index].value
      },
        beforeSend: function () {
        },
      }).done( function(d) {
        if(d.object == "success")
        {
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#phone').val(d.data.phone);
          $('#email').val(d.data.email);
          $('#dni').val(d.data.dni);
          $('#id_viaje').val(d.data.id_viaje);
          document.getElementById("tipo_doc").value = d.data.id_type_documents;
        }else {
          alert(d.menssage);
        }

      }).fail( function() {
        alert("Ocurrio un error en la operación");
      }).always( function() {


      });
    }
    else {
      alert('Ingrese el DNI.');
    }

}

function data_email()
{
  if($("#email").val().length > 0)
  {
  var select = document.getElementById("tipo_doc");
  var index = select.selectedIndex;
  $.ajax({
    url: "/evento/get/email",
    type:"post",
    data:{email:$('#email').val(),
          id_type_documents:select.options[index].value
  },
    beforeSend: function () {
    },
  }).done( function(d) {
    if(d.object == "success")
    {
      $('#first_name').val(d.data.first_name);
      $('#last_name').val(d.data.last_name);
      $('#phone').val(d.data.phone);
      $('#email').val(d.data.email);
      $('#dni').val(d.data.dni);
      $('#id_viaje').val(d.data.id_viaje);
      document.getElementById("tipo_doc").value = d.data.id_type_documents;
    }else {
      alert(d.menssage);
    }

  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {

  });
}else {
    alert('Ingrese el email.');
}

}

function data_phone()
{
  if($("#email").val().length > 0)
  {
    var select = document.getElementById("tipo_doc");
    var index = select.selectedIndex;
    $.ajax({
      url: "/evento/get/phone",
      type:"post",
      data:{phone:$('#phone').val(),
    },
      beforeSend: function () {
      },
    }).done( function(d) {
      if(d.object == "success")
      {
        $('#first_name').val(d.data.first_name);
        $('#last_name').val(d.data.last_name);
        $('#phone').val(d.data.phone);
        $('#email').val(d.data.email);
        $('#dni').val(d.data.dni);
        $('#id_viaje').val(d.data.id_viaje);
        document.getElementById("tipo_doc").value = d.data.id_type_documents;
      }else {
        alert(d.menssage);
      }

    }).fail( function() {
      alert("Ocurrio un error en la operación");
    }).always( function() {


    });
  }else {
    alert('Ingrese el email.');
  }

}

function create()
{
  if($("#id_office").val().length > 0)
  {
    var select = document.getElementById("tipo_doc");
    var index = select.selectedIndex;
    $.ajax({
      url: "/evento/create",
      type:"post",
      data:{

        id_office:$('#id_office').val(),
        first_name:$('#first_name').val(),
        last_name:$('#last_name').val(),
        phone:$('#phone').val(),
        email:$('#email').val(),
        dni:$('#dni').val(),
        id_type_documents: select.options[index].value,
        id_viaje:$('#id_viaje').val()
      },
      beforeSend: function () {
      },
    }).done( function(d) {
      if(d.object == "success")
      {
        alert(d.menssage);
        location.reload();
      }else {
        alert(d.menssage);
      }

    }).fail( function() {
      alert("Ocurrio un error en la operación");
    }).always( function() {


    });
  }else {
    alert('ingrese id office');
  }

}

function update()
{
  var select = document.getElementById("tipo_doc");
  var index = select.selectedIndex;
  $.ajax({
    url: "/evento/update",
    type:"post",
    data:{
      id_office:$('#id_office').val(),
      first_name:$('#first_name').val(),
      last_name:$('#last_name').val(),
      phone:$('#phone').val(),
      email:$('#email').val(),
      dni:$('#dni').val(),
      id_type_documents:select.options[index].value,
      id_viaje:$('#id_viaje').val()
    },
    beforeSend: function () {
    },
  }).done( function(d) {
    if(d.object == "success")
    {
      alert(d.menssage);
      location.reload();
    }
    else {
      alert(d.menssage);
    }

  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {


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
