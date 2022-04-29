@extends('layout-backend')
@section('title', 'ACTUALIZAR ID OFICINA')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
@endsection


@section('content')
<section class="content">
  <div class="box" style="padding: 35px;">
    <div class="box-header">
      <h3>ACTUALIZAR USUARIO O ID OFICINA VIRTUAL</h3>
      <code>Campos obligatorios ( * )</code>
    </div>
    <div class="box-body">
    <form class="form-horizontal" action="#" id="formuseroffices" enctype="multipart/form-data">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="seccion">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">USUARIO o NUMERO DE DOCUMENTO: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el usuario o numero de documento" name="idoffice">
              </div>
            </div>

          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">Nombres:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="first_name" name="first_name">
              </div>
            </div>
            <div class="col-xs-12 col-md-6"><label for="Datos">Apellidos:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="last_name" name="last_name">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
              <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">USUARIO OFICINA VIRTUAL: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="idofficenew" placeholder="Ingresar usuario" name="idofficenew">
              </div>
            </div>
          </div>
        </div>
          <div class="form-group">
            <div class="col-sm-12 text-center">
              <button type="button" id="btn_ajax" class="btn btn-success">Actualizar</button>
            </div>
          </div>
        </div>
   </form>
 </div>
</div>
</section>

<!-- Animación de carga de documento -->
<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 10; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
    {{--
      <div id="row">
          <div id="cantidadSubidas" style="color: blue">
              <h2>  0</h2>
          </div> de 10
      </div>
    --}}
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/External/Driver/idofficev.js?v=1')}} "></script>
@endsection
