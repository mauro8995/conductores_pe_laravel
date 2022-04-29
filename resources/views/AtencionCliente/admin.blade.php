@extends('layout-backend')
@section('title', 'Service Desk')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
<section class="content-header"></section>
<section class="content">
    <div class="box box">
     <div class="box-header with-border">
       <h3 class="box-title">Configuracion general</h3>
     </div>
     <div class="box-body">
       <div class="hero-callout">
         <div class="form-group">
        <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="managed" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Gestionado</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="management_channel" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Canal de gestion</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="type_requirements" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Tipo requerimientos</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="priority" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-th-list"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Prioridad</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="groups_tickets" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Grupos</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="subjects" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Asuntos</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="statusT" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Estados</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="categories" class="small-box-footer">
          <div class="info-box">
            <span class="info-box-icon" style="background: white !important;"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <br>
              <span class="info-box-number">Categorias</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
      </div>
      </div>
         </div>
       </div>
     </div>
</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/admin.js') }}"></script>
@endsection
