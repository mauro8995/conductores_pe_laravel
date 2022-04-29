@extends('layout-backend')
@section('title', 'Reportes')

@section('css')
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
@endsection

@section('content')
<section class="content-header">
      <h1>
        Panel de información
      </h1>
</section>
<section class="content" >
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <label for="pwd"></label>
        </div>
        <div class="col-lg-3 col-xs-6">
          <label for="pwd">Fecha:</label>
        </div>
        <div class="col-lg-3 col-xs-6">
          <label for="pwd"></label>
        </div>
      </div>
      <div class="row">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="col-lg-3 col-xs-6">

        </div>
        <div class="col-lg-3 col-xs-6">
          <input type="text" class="form-control pull-right search" id="reservation" name="dates"><span></span>
        </div>
        <div class="col-lg-3 col-xs-6">

        </div>
      </div>
    </div>
    <div class="box-body" id="content">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="pad">
                    <!-- Map will be created here -->
                    <canvas id="grafico"  width="100%" height="60"></canvas>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6 col-sm-6">
                  <canvas id="barChart" style="height:230px"></canvas>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
  $(function () {
      //$('#reservation').daterangepicker();
      $('#reservation').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Esta Semana' : [moment().subtract(6, 'days'), moment()],
          'Semana Pasada': [moment().subtract(14, 'days'), moment().subtract(6, 'days')],
          'Este mes'  : [moment().startOf('month'), moment()],
          'Mes Pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment(),
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " / ",
            "applyLabel": "Guardar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizar",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Setiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ]
        }
      },
      function (start, end) {
        $('#reservation span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    );
  });
</script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js"></script>
<script src="{{ asset('js/Report/servicedeskgeneral.js') }}"></script>
@endsection
