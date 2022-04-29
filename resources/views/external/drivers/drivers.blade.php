@extends('layout-backend')
@section('title', 'Fotos del auto')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/semantic.min.css"/>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
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
  <h4>Subir fotos del auto:</h4>
  <code>Campos obligatorios ( * )</code>
  <hr>
  <form class="form-horizontal" action="#" id="formfiledrivers" enctype="multipart/form-data">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="seccion">
          <div  class="col-lg-12 padd2">
              <label class="col-xs-12 col-sm-4 col-md-3 padd" for="idoffice">Usuario:<code>*</code></label>
              <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
                <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el usuario" name="idoffice">
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
                <button type="button" id="btn_search" class="btn btn-success">Buscar</button>
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="nameuser">Nombres:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="nameuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="apeuser">Apellidos:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="apeuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Teléfono:<code>*</code> <div id="clock" style="color: red;"></div></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="phoneuser" style="display: flex;"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Codigo verificacion Teléfono:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="phonevaluser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="emailuser" >Correo:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8  padd" id="emailuser" style="display: flex;">
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="emailvaluser">Codigo verificación correo:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="emailvaluser"></div>
          </div>
      </div>
     <hr>
     <div class="seccion">
       <div  class="col-md-12 col-md-6 padd2">
         <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">Tipo de documento de identidad: <code>*</code></label>
         <div class="col-xs-12 col-sm-9 col-md-8 padd">
             {!! Form::select('tipdocid', $type_docs, null, ['id'=>'tipdocid','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
         </div>
      </div>
       <div  class="col-md-12 col-md-6 padd2">
         <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">Numero de documento de identidad: <code>*</code></label>
         <div class="col-xs-12 col-sm-9 col-md-8 padd">
             <input type="text" class="form-control" id="dni" placeholder="Ingresar DNI" name="dni">
         </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">Placa:<code>* Ingresar solo letras, números y sin espacios</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
            <input type="text" class="form-control" id="placa" placeholder="Ingresar placa" name="placa">
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">Año carro:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd" id="yearfile">
          </div>
      </div>
     </div>
     <hr>
    <div class="seccion">
        <p class="col-xs-12"><b>Fotos internas</b> <code>*</code></p>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carinterna1">ASIENTO DEL COPILOTO:</label>
            <div id="divcarinterna1"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carinterna1" name="carinterna1" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carinterna1')" > -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_driver_img.png')}}" id="carinterna1_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carinterna1" name="carinterna1" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carinterna1"></span>
                  </label>
                </div>

            </div>

        </div>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carinterna2">ASIENTO DEL PASAJERO:</label>
	          <div id="divcarinterna2"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carinterna2" name="carinterna2" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carinterna2')" > -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_passenger_img.png')}}" id="carinterna2_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carinterna2" name="carinterna2" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carinterna2"></span>
                  </label>
                </div>

            </div>
        </div>
    </div>
    <div class="seccion">
        <p class="col-xs-12"><b>Fotos externas</b> <code>*</code></p>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carexterna1">PARTE DELANTERA AUTO:</label>
	          <div id="divcarexterna1"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carexterna1" name="carexterna1" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carexterna1')"> -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_frontal_img.png')}}" id="carexterna1_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carexterna1" name="carexterna1" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carexterna1"></span>
                  </label>
                </div>
            </div>
        </div>
        <div id="divcarro">
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carexterna2">LADO DERECHO AUTO:</label>
            <div id="divcarexterna2"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carexterna2" name="carexterna2" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carexterna2')" > -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_right_img.png')}}" id="carexterna2_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carexterna2" name="carexterna2" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carexterna2"></span>
                  </label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carexterna2">LADO IZQUIERDO AUTO:</label>
            <div id="divcarexterna3"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carexterna3" name="carexterna3" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carexterna3')"> -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_left_img.png')}}" id="carexterna3_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carexterna3" name="carexterna3" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carexterna3"></span>
                  </label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carexterna2">PARTE TRASERA AUTO:</label>
            <div id="divcarexterna4"></div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <!-- <input type='file' class="form-control" id="carexterna4" name="carexterna4" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carexterna4')"> -->
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/car_back_img.png')}}" id="carexterna4_img" alt="">
                <div class="input-group">
                  <label class="input-group-btn text-center" style="width: 100%;">
                    <span class="btn btn-primary btn-file radioD">
                    Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="carexterna4" name="carexterna4" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-carexterna4"></span>
                  </label>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-12 text-center">
        <button type="button" id="btn_ajax" class="btn btn-success">Enviar</button>
      </div>
    </div>
  </form>


</section>


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

<div id="la" style="display: none">
    <form id="loginForm">
      <h4>Esta persona no cuenta con DNI</h4>
      <div  class="col-lg-12 padd2">
        <label class="col-xs-12 col-sm-4 col-md-3 padd" for="dni_usuario">Ingrese DNI porfavor:<code>*</code> </label>
        <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
            <input type="text" class="form-control" id="dni_usuario" placeholder="DNI" name="dni_usuario">
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
            <button type="button" id="btn_dni_buscar" class="btn btn-success" onclick="getDataDni()">Buscar</button>
        </div>
      </div>
      <div  class="col-lg-12 padd2">
          <div class="col-xs-12 padd" style="display: flex;">
              Nombres:<span id="nombre_dni">-</span>
          </div>
          <div class="col-xs-12 padd" style="display: flex;">
              Apellidos :<span id="apellido_dni">-</span>
          </div>
      </div>
      <div class="col-xs-12 padd" style="display: flex;">
          <button type="button" id="btn_dni_save" class="btn btn-success" onclick="saveDNI()">Guardar</button>
      </div>
    </form>
</div>

@endsection

@section('js')
<script src="{{ asset('plugins/JIC/dist/JIC.min.js')}} " type="text/javascript"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
<script src="{{ asset('js/External/Driver/drivers.js?v=222')}} "></script>
@endsection
