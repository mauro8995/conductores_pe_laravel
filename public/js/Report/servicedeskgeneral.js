$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(".search").change(function(){
    dates = $('#reservation').val();
    $.ajax(
    {
      url: "/report/GetReportRequirements",
      type:"GET",
      data : { dates: dates },
      dataType: "json",
      beforeSend: function () {
        //$('#load_inv').show(300);
      }
    }).done(function(d)
    {
      //$('#load_inv').hide(300);
      alertify.notify('Correcto','success',2, function(){});
      console.log(d);
      var mi_primer_grafico ={
        type:"doughnut",//seleccionamos el tipo de grafico, en este caso es un grafico estilo pie, en esta parte podemos cambiar el tipo de grafico por el que deseamos
        data:{//le pasamos la data
          datasets:[{
            data:d.data.post_count_data,//esta es la data, podemos pasarle variables directamente desde el backend usando blade de la siguiente forma {{$dato1}},
            backgroundColor: [//seleccionamos el color de fondo para cada dato que le enviamos
              "#04B404","#FFBF00","#FF0000","#04B4AE","#2e4053","#7d3c98","#ba4a00"
             ],
          }],
          labels: d.data.requeriments
        },
        options:{//le pasamos como opcion adicional que sea responsivo
          responsive: true,
        }
      }
      var primer_grafico = document.getElementById('grafico').getContext('2d');//seleccionamos el canvas
      window.pie = new Chart(primer_grafico,mi_primer_grafico);//le pasamos el grafico y la data para representarlo

      //segundo grafico
      var mi_segundo_grafico ={
        type:"horizontalBar",//seleccionamos el tipo de grafico, en este caso es un grafico estilo pie, en esta parte podemos cambiar el tipo de grafico por el que deseamos
        data:{//le pasamos la data
          datasets:[{
            label: "Rendimiento de los agentes",
            data:d.data2.time_resolve,//esta es la data, podemos pasarle variables directamente desde el backend usando blade de la siguiente forma {{$dato1}},
            backgroundColor: [//seleccionamos el color de fondo para cada dato que le enviamos
              "#04B404","#FFBF00","#FF0000","#04B4AE","#2e4053","#7d3c98","#ba4a00"
             ],
          }],
          labels: d.data2.agent
        },
        options:{//le pasamos como opcion adicional que sea responsivo
          responsive: true,
          scales: {
            xAxes: [{
              gridLines: {
                display: false,
                color: "black"
              },
              scaleLabel: {
                display: true,
                labelString: "Tiempo en horas",
                fontColor: "red"
              }
            }],
            yAxes: [{
              gridLines: {
                color: "black",
                borderDash: [2, 5],
              },
              scaleLabel: {
                display: true,
                labelString: "Agentes",
                fontColor: "green"
              }
            }]
          }
        }
      }
      var segundo_grafico = document.getElementById('barChart').getContext('2d');//seleccionamos el canvas
      window.pie = new Chart(segundo_grafico,mi_segundo_grafico);//le pasamos el grafico y la data para representarlo

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });

});
