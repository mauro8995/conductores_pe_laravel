$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$('#typegestion').select2();
$('#categories').select2();


$(".search").change(function(){
    categories = $('#categories').val();
    typegestion = $('#typegestion').val();
    dates = $('#reservation').val();

    $.ajax(
    {
      url: "/report/GetReportemergency",
      type:"GET",
      data : { typegestion: typegestion, categories: categories, dates: dates },
      dataType: "json",
      beforeSend: function () {
        //$('#load_inv').show(300);
      }
    }).done(function(d)
    {
      //$('#load_inv').hide(300);
      alertify.notify('Correcto','success',2, function(){});
      var geocoder;
      var map;
      $('#world-map-markers').html('');

      var latlng = new google.maps.LatLng(-11.9958973, -77.0781772);
      var mapOptions = {
        zoom: 10,
        center: latlng,
        disableDefaultUI: true
      }
      map = new google.maps.Map(document.getElementById('world-map-markers'), mapOptions);
      geocoder = new google.maps.Geocoder();

      var image = {
          url: 'https://icon-icons.com/icons2/882/PNG/32/1-70_icon-icons.com_68855.png',
          // This marker is 20 pixels wide by 32 pixels high.
          size: new google.maps.Size(30, 50),
          // The origin for this image is (0, 0).
          origin: new google.maps.Point(0, 0),
          // The anchor for this image is the base of the flagpole at (0, 32).
          anchor: new google.maps.Point(0, 32)
        };

      $.each( d.data, function( key, value ) {
          var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h4 id="firstHeading" class="firstHeading">'+value.subject+'</h4>'+
                '<div id="bodyContent"><p>'+value.description+'</p></div></div>';

            var infowindow = new google.maps.InfoWindow({
              content: contentString
            });
            var locat = value.ubication.split(',');
            var latitude = locat[0].substr(1);
            var longitude = locat[1].substr(1,11);
            var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(latitude, longitude),
                  map: map,
                  title: value.subject,
                  animation: google.maps.Animation.DROP,
                  icon: image,
            });
            marker.addListener('click', function() {
              infowindow.open(map, marker);
            });
      });

      $('.totalemerge').html(d.data.length);
      var charts = {
        init: function () {
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  			  Chart.defaults.global.defaultFontColor = '#292b2c';
          this.ajaxGetPostMonthlyData();
        },
    		ajaxGetPostMonthlyData: function () {
    				charts.createCompletedJobsChart(d.filter);
    		},
        createCompletedJobsChart: function (response) {
    			var ctx = document.getElementById("myAreaChart").getContext("2d");
    			var myLineChart = new Chart(ctx, {
    				type: 'line',
    				data: {
    					labels: response.months, // The response got from the ajax request containing all month names in the database
    					datasets: [{
    						label: "Sessions",
    						lineTension: 0.3,
    						backgroundColor: "rgba(2,117,216,0.2)",
    						borderColor: "rgba(2,117,216,1)",
    						pointRadius: 5,
    						pointBackgroundColor: "rgba(2,117,216,1)",
    						pointBorderColor: "rgba(255,255,255,0.8)",
    						pointHoverRadius: 5,
    						pointHoverBackgroundColor: "rgba(2,117,216,1)",
    						pointHitRadius: 20,
    						pointBorderWidth: 2,
    						data: response.post_count_data // The response got from the ajax request containing data for the completed jobs in the corresponding months
    					}],
    				},
    				options: {
    					scales: {
    						xAxes: [{
    							time: {
    								unit: 'date'
    							},
    							gridLines: {
    								display: false
    							},
    							ticks: {
    								maxTicksLimit: 7
    							}
    						}],
    						yAxes: [{
    							ticks: {
    								min: 0,
    								max: response.max, // The response got from the ajax request containing max limit for y axis
    								maxTicksLimit: 5
    							},
    							gridLines: {
    								color: "rgba(0, 0, 0, .125)",
    							}
    						}],
    					},
    					legend: {
    						display: false
    					}
    				}
    			});
    		}
    	};
      charts.init();
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });

});
