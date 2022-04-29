@extends('layout-backend')
@section('title', 'Cambiar de vehiculo')
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
      </div>
     <hr>
     <div class="seccion">
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">PLACA:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
            <input type="text" class="form-control" id="placa" placeholder="Ingresar placa" name="placa">
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">AÑO CARRO:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd">
              <select class="form-control select2" id="year" name="year">
                <option>SELECCIONAR</option>
                <option>2000</option>
                <option>2001</option>
                <option>2002</option>
                <option>2003</option>
                <option>2004</option>
                <option>2005</option>
                <option>2006</option>
                <option>2007</option>
                <option>2008</option>
                <option>2009</option>
                <option>2010</option>
                <option>2011</option>
                <option>2012</option>
                <option>2013</option>
                <option>2014</option>
                <option>2015</option>
                <option>2016</option>
                <option>2017</option>
                <option>2018</option>
                <option>2019</option>
              </select>
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">COLOR:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
            <input type="text" class="form-control" id="color" placeholder="Ingresar color" name="color">
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">MARCA:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd">
            <input type="text" class="form-control" id="brand" placeholder="Ingresar marca" name="brand">
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">MODELO:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
            <input type="text" class="form-control" id="model" placeholder="Ingresar modelo" name="model">
          </div>
      </div>
      <div  class="col-xs-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">ESTADO:<code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd">
            <input type="text" class="form-control" id="status" placeholder="Ingresar estado" name="status">
          </div>
      </div>
     </div>
<hr>
<div class="seccion">
  <label class="col-xs-12 padd"><b>Tarjeta vehicular</b></label>
    <div class="col-xs-12 col-md-6 padd2">
        <label class="col-xs-12 col-sm-3 col-md-4 padd" for="tarj-vehi-front">Tarjeta vehicular Frontal:<code>*</code></label>
        <div id="div_tarj-vehi-front">

        </div>
        <div class="col-xs-12 col-sm-9 col-md-8 padd">
          <input type='file' class="form-control" id="tarj-vehi-front" name="tarj-vehi-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('tarj-vehi-front')">
        </div>
    </div>
    <div class="col-xs-12 col-md-6 padd2">
        <label class="col-xs-12 col-sm-3 col-md-4 padd" for="tarj-vehi-back">Tarjeta vehicular Posterior:<code>*</code></label>
        <div class="col-xs-12 col-sm-9 col-md-8 padd">
          <div id="div_tarj-vehi-back">

          </div>
          <input type='file' class="form-control" id="tarj-vehi-back" name="tarj-vehi-back" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('tarj-vehi-back')">
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 padd2">
        <label class="col-xs-12 col-sm-6 col-md-4 padd" for="tarj-vehi-fec-emi">Fecha de Emisión:<code>*</code></label>
        <div class="col-xs-12 col-sm-6 col-md-8 padd">
          <input type='date' class="form-control" id="tarj-vehi-fec-emi" name="tarj-vehi-fec-emi">
        </div>
    </div>
</div>
<hr>
<div class="seccion">
<label class="col-xs-12 padd"><b>Soat</b></label>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">TIPO DE SEGURO:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
       <select class="form-control select2" id="type-safe" name="type-safe">
          <option>SELECCIONAR</option>
          <option value="CAT">CAT</option>
          <option value="SOAT">SOAT</option>
       </select>
     </div>
 </div>
 <div id ="divseguro">
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">COMPAÑIA:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd">
       <input type="text" class="form-control" id="company" placeholder="Ingresar compañia" name="company">
     </div>
 </div>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">ESTADO:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
       <input type="text" class="form-control" id="status-safe" placeholder="Ingresar estado" name="status-safe">
     </div>
 </div>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">NRO POLIZA:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd">
       <input type="text" class="form-control" id="nro-poliza" placeholder="Ingresar poliza" name="nro-poliza">
     </div>
 </div>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">TIPO DE USO:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
       <input type="text" class="form-control" id="type-use" placeholder="Ingresar tipo de uso" name="type-use">
     </div>
 </div>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">FECHA DE INICIO:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd">
       <input type='date' class="form-control" id="safe-fec-emi" name="safe-fec-emi">
     </div>
 </div>
 <div  class="col-xs-12 col-md-6 padd2">
     <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">FECHA DE FIN:<code>*</code></label>
     <div class="col-xs-12 col-sm-9 col-md-8 padd">
       <input type='date' class="form-control" id="safe-fec-ven" name="safe-fec-ven">
     </div>
 </div>
</div>
 <div class="col-xs-12 col-md-6 padd2">
   <label class="col-xs-12 col-sm-3 col-md-4 padd" for="soat-front">Foto Soat Frontal:<code>*</code></label>
   <div class="col-xs-12 col-sm-9 col-md-8 padd">
   <input type='file' class="form-control" id="soat-front" name="soat-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('soat-front')">
   </div>
 </div>
</div>
<hr>
<div class="seccion" id="divrevtecnica">
    <div class="col-xs-12 padd2">
        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="revision_tecnica"><b>Revisión tecnica: </b></label>
        <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
            <input type='file' class="form-control" id="revision_tecnica" name="revision_tecnica" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('revision_tecnica')">
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 padd2">
        <label class="col-xs-12 col-sm-6 col-md-4 padd" for="rev-fec-emi">Fecha de Emisión:</label>
        <div class="col-xs-12 col-sm-6 col-md-8 padd">
          <input type='date' class="form-control" id="rev-fec-emi" name="rev-fec-emi" >
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 padd2">
        <label class="col-xs-12 col-sm-6 col-md-4 padd" for="rev-fec-ven">Fecha de vencimiento:</label>
        <div class="col-xs-12 col-sm-6 col-md-8 padd">
          <input type='date' class="form-control" id="rev-fec-ven" name="rev-fec-ven" >
        </div>
    </div>
</div>
<hr>

    <div class="seccion">
        <p class="col-xs-12"><b>Fotos internas</b> <code>*</code></p>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carinterna1">1ra Foto interna Auto:</label>
            <div id="divcarinterna1">

            </div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type='file' class="form-control" id="carinterna1" name="carinterna1" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carinterna1')" >
            </div>
        </div>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carinterna2">2da Foto interna Auto:</label>
            <div id="divcarinterna2">

            </div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type='file' class="form-control" id="carinterna2" name="carinterna2" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carinterna2')" >
            </div>
        </div>
    </div>
    <div class="seccion">
        <p class="col-xs-12"><b>Fotos externas</b> <code>*</code></p>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="carexterna1">1ra Foto externa Auto:</label>
            <div id="divcarexterna1">

            </div>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type='file' class="form-control" id="carexterna1" name="carexterna1" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('carexterna1')">
            </div>
        </div>
    </div>

    <div class="form-group">
      <div class="col-sm-12 text-center">
        <button type="button" id="btn_ajax" class="btn btn-success">Actualizar</button>
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
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
<script src="{{ asset('js/External/Driver/changevehicle.js')}} "></script>
@endsection
