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
  <style>
    .small-box{
      border: 2px gray solid;
      border-radius: 5px;
    }
    .inner{
      padding-left: 20px !important;
    }
    .inner p{
      color: rgba(0,0,0,0.36) !important;
      font-weight: bold !important;
    }
  </style>
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
          <label for="pwd">Areas:</label>
        </div>
        <div class="col-lg-3 col-xs-6">
          <label for="pwd">Agentes:</label>
        </div>
        <div class="col-lg-3 col-xs-6">
          <label for="pwd">Fecha:</label>
        </div>
      </div>
      <div class="row">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="col-lg-3 col-xs-6">
          {!! Form::select('groups', $groups, null,['id'=>'groups', 'class'=>'form-control select2 search',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
        </div>
        <div class="col-lg-3 col-xs-6">
          {!! Form::select('agents', $modified_by, null,['id'=>'agents', 'class'=>'form-control select2 search',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
        </div>
        <div class="col-lg-3 col-xs-6">
          <input type="text" class="form-control pull-right search" id="reservation" name="dates"><span></span>
        </div>
      </div>
    </div>
    <div class="box-body" id="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="#" class="small-box">
            <div class="inner">
              <h3 id="open">{{$open}}</h3>
              <h5>Abiertos</h5>
              <p>Estado</p>
            </div>
            <div class="icon">
              <i style="color: #0d436b;" class="ion ion-android-open"></i>
            </div>
          </a>
        </div>
        <!-- ./col -->
        <div id="divgroup">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="notassigned">{{$notassigned}}</h3>
                <h5>No asignado</h5>
                <p></p>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-ios-people"></i>
              </div>
            </a>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6" >
              <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="assigned">{{$assigned}}</h3>
                <h5>Asignado</h5>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-ios-person"></i>
              </div>
            </a>
          </div>
        </div>
          <!-- ./col -->
        <div class="divagents">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="opentimetrue"></h3>
                <h5>A tiempo</h5>
                <p>1ra Respuesta</p>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-android-alarm-clock"></i>
              </div>
            </a>

          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="opentimefalse"></h3>
                <h5>Vencido</h5>
                <p>1ra Respuesta</p>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-android-alarm-clock"></i>
              </div>
            </a>
          </div>
          <!-- ./col -->
      </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="#" class="small-box">
            <div class="inner">
              <h3 id="total">{{$total}}</h3>
              <h5>Total</h5>
              <p>Total de tickets</p>
            </div>
            <div class="icon">
              <i style="color: #222;" class="ion ion-pie-graph"></i>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="#" class="small-box">
            <div class="inner">
              <h3 id="waiting">{{$waiting}}</h3>
              <h5>En proceso</h5>
              <p>Estado</p>
            </div>
            <div class="icon">
              <i style="color: #0d436b;" class="ion ion-help-circled"></i>
            </div>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="#" class="small-box">
            <div class="inner">
              <h3 id="solved">{{$solved}}</h3>
              <h5>Resuelto</h5>
              <p>Estado</p>
            </div>
            <div class="icon">
              <i style="color: #0d436b;" class="ion ion-ios-checkmark"></i>
            </div>
          </a>
        </div>
        <!-- ./col -->

      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="#" class="small-box">
            <div class="inner">
              <h3 id="closed">{{$closed}}</h3>
              <h5>Cerrado</h5>
              <p>Estado</p>
            </div>
            <div class="icon">
              <i style="color: #0d436b;" class="ion ion-android-checkbox-outline-blank"></i>
            </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="divagents">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="closevenctrue"></h3>
                <h5>A tiempo</h5>
                <p>Resolucion</p>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-android-alarm-clock"></i>
              </div>
            </a>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
            <a href="#" class="small-box">
              <div class="inner">
                <h3 id="closevencfalse"></h3>
                <h5>Vencido</h5>
                <p>Resolucion</p>
              </div>
              <div class="icon">
                <i style="color: #ffe23c;" class="ion ion-android-alarm-clock"></i>
              </div>
            </a>
          </div>
          <!-- ./col -->
        </div>
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
    })
</script>
<script src="{{ asset('js/Report/servicedesk.js') }}"></script>
@endsection
