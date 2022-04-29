@extends('layout-backend')
@section('title', 'Foto de perfil')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyDQCZESZB5v0-ReeZYUcXWRbOb2IDaJR_8",
    authDomain: "voucher-img-fb702.firebaseapp.com",
    databaseURL: "https://voucher-img-fb702.firebaseio.com",
    projectId: "voucher-img-fb702",
    storageBucket: "voucher-img-fb702.appspot.com",
    messagingSenderId: "807276908227"
  };
  firebase.initializeApp(config);
</script>
@endsection

@section('content')
<section class="content">
  <h4>Subir foto del conductor:</h4>
    <code>Campos obligatorios ( * )</code>
  <hr>
  <form class="form-horizontal" action="#" id="formfiledrivers" enctype="multipart/form-data">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="seccion">
        <div class="col-xs-12 padd">
          <label class="col-xs-12 col-sm-4 col-md-3 padd" for="idoffice">Usuario:<code>*</code></label>
          <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
            <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el usuario" name="idoffice">
          </div>
            <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
              <button type="button" id="btn_search" class="btn btn-success">Buscar</button>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 padd">
            <label class="col-xs-12 col-sm-4 padd" for="dni-front">Nombres:<code>*</code> </label>
            <div class="col-xs-12 col-sm-8 padd" id="nameuser"></div>
        </div>
        <div class="col-xs-12 col-md-6 padd">
            <label class="col-xs-12 col-sm-4 padd" for="dni-back">Apellidos:<code>*</code> </label>
            <div class="col-xs-12 col-sm-8 padd" id="apeuser"></div>
        </div>
        <div class="col-xs-12 col-md-6 padd">
            <label class="col-xs-12 col-sm-4 padd" for="dni-front">Teléfono: </label>
            <div class="col-xs-12 col-sm-8 padd" id="phoneuser"></div>
        </div>
        <div class="col-xs-12 col-md-6 padd">
            <label class="col-xs-12 col-sm-4 padd" for="dni-back">Correo: </label>
            <div class="col-xs-12 col-sm-8 padd" id="emailuser"></div>
        </div>
        <div class="col-xs-12 padd">
            <label class="col-xs-12 col-sm-4 padd" for="photo_perfil">Foto de perfil:<code>*</code></label>
            <div class="col-xs-12 col-sm-8 padd">
                <!-- <input type='file' class="form-control" id="photo_perfil" name="photo_perfil" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('photo_perfil')"> -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" style="width: 30%;" src="{{asset('imagenes/perfil_img.png')}}" id="photo_perfil_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="photo_perfil" name="photo_perfil" accept="image/x-png,image/gif,image/jpeg">
                    </span><span style="margin: 5px;" class="help-block-photo_perfil"></span>
                  </label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 padd">
            <center><button type="button" id="btn_ajax" class="btn btn-success">Enviar</button></center>
        </div>
    </div>
  </form>

  <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1000; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
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
  <script src="{{ asset('plugins/JIC/dist/JIC.min.js')}} " type="text/javascript"></script>
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
  <script src="{{ asset('js/External/Driver/photoperfil.js?v=222')}} "></script>
  @endsection
