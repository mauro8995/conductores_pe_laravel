@extends('layout-backend')
@section('title', 'Fotos de documentos')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
  <h4>Subir documentos del conductor:</h4>
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
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-front">Nombres:<code>*</code> </label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="nameuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-back">Apellidos:<code>*</code> </label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="apeuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Teléfono:<code>*</code> <div id="clock" style="color: red;"></div></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="phoneuser" style="display: flex;"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Codigo verificación Teléfono:<code>*</code></label>
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
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">Placa:<code>* Ingresar solo letras, números</code> </label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
                <input type="text" class="form-control" id="placa" placeholder="Ingresar placa" name="placa">
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">Año carro:<code>*</code> </label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="yearfile">
              </div>
          </div>
          <div  class="col-md-12 col-md-6 padd2 numtipdoc">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">Fecha de nacimiento: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type="date" class="form-control" id="datebirth" placeholder="Ingresar fecha de nacimiento" name="datebirth">
            </div>
         </div>
      </div>
      <hr>
    <div class="seccion">
          <div class="col-xs-12 padd2">
              <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="revision_tecnica"><b>Tarjeta Unica de Circulación del vehiculo (ATU): <code><div id="div_atu"></div></code></b></label>
              <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
                  <!-- <input type='file' class="form-control" id="atu" name="atu" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('atu')"> -->
                  <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/atu_back_img.png')}}" id="atu_img" alt="">
                  <div class="input-group">
                    <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                      <span class="btn btn-primary btn-file radioD">
                      Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="atu" name="atu" accept="image/x-png,image/gif,image/jpeg">
                      </span><span style="margin: 5px;" class="help-block-dni_frontal"></span>
                    </label>
                  </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 padd2">
              <label class="col-xs-12 col-sm-6 col-md-4 padd" for="rev-fec-emi">Fecha de Emisión:</label>
              <div class="col-xs-12 col-sm-6 col-md-8 padd">
                <input type='date' class="form-control" id="atu-fec-emi" name="atu-fec-emi" >
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 padd2">
              <label class="col-xs-12 col-sm-6 col-md-4 padd" for="rev-fec-ven">Fecha de vencimiento:</label>
              <div class="col-xs-12 col-sm-6 col-md-8 padd">
                <input type='date' class="form-control" id="atu-fec-ven" name="atu-fec-ven" >
              </div>
          </div>
      </div>
    <div class="seccion">
        <label class="col-xs-12 padd"><b>DNI</b></label>
        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="dni-front">DNI Frontal:<code>* <div id="div_dni_front"></div></code></label>
        <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
            <!-- <input type='file' class="form-control" id="dni-front" name="dni-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('dni-front')"> -->
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/dni_frontal_img.png')}}" id="dni-front_img" alt="">
            <div class="input-group">
              <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                <span class="btn btn-primary btn-file radioD">
                Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="dni-front" name="dni-front" accept="image/x-png,image/gif,image/jpeg">
                </span><span style="margin: 5px;" class="help-block-dni_frontal"></span>
              </label>
            </div>

        </div>
        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="dni-back">DNI Posterior:<code>* <div id="div_dni_back"></div></code></label>
        <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
            <!-- <input type='file' class="form-control" id="dni-back" name="dni-back" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('dni-back')"> -->
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/dni_back_img.png')}}" id="dni-back_img" alt="">
            <div class="input-group">
              <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                <span class="btn btn-primary btn-file radioD">
                Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="dni-back" name="dni-back" accept="image/x-png,image/gif,image/jpeg">
                </span><span style="margin: 5px;" class="help-block-dni_back"></span>
              </label>
            </div>
        </div>
    </div>
    <div class="seccion">
      <div  class="col-lg-12 padd2">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="dni"><b>Licencia:</b><code>*</code> </label>
          <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
              <input type="text" class="form-control" id="licencia" placeholder="Ingresar licencia" name="licencia">
          </div>
          <div class="col-sm-6 col-lg-6 padd"></div>
      </div>
      <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="lic-front">Licencia Frontal:<code>* <div id="div_lic-front"></div></code></label>
      <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
          <!-- <input type='file' class="form-control" id="lic-front" name="lic-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('lic-front')"> -->
          <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/lic_frontal_img.png')}}" id="lic-front_img" alt="">
          <div class="input-group">
            <label class="input-group-btn btn-lg text-center" style="width: 100%;">
              <span class="btn btn-primary btn-file radioD">
              Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="lic-front" name="lic-front" accept="image/x-png,image/gif,image/jpeg">
              </span><span style="margin: 5px;" class="help-block-lic-front"></span>
            </label>
          </div>
      </div>
      <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="lic-back">Licencia Posterior:<code>* <div id="div_lic-back"></div></code></label>
        <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
          <!-- <input type='file' class="form-control" id="lic-back" name="lic-back" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('lic-back')"> -->
          <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/lic_back_img.png')}}" id="lic-back_img" alt="">
          <div class="input-group">
            <label class="input-group-btn btn-lg text-center" style="width: 100%;">
              <span class="btn btn-primary btn-file radioD">
              Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="lic-back" name="lic-back" accept="image/x-png,image/gif,image/jpeg">
              </span><span style="margin: 5px;" class="help-block-lic-back"></span>
            </label>
          </div>

        </div>
    </div>
    <div class="seccion">
      <label class="col-xs-12 padd"><b>Tarjeta vehicular</b></label>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="tarj-vehi-front">Tarjeta vehicular Frontal:<code>* <div id="div_tarj-vehi-front"></div></code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
              <!-- <input type='file' class="form-control" id="tarj-vehi-front" name="tarj-vehi-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('tarj-vehi-front')"> -->
              <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/tarjveh_frontal_img.png')}}" id="tarj-vehi-front_img" alt="">
              <div class="input-group">
                <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                  <span class="btn btn-primary btn-file radioD">
                  Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="tarj-vehi-front" name="tarj-vehi-front" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-tarj-vehi-front"></span>
                </label>
              </div>


            </div>
        </div>
        <div class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="tarj-vehi-back">Tarjeta vehicular Posterior:<code>* <div id="div_tarj-vehi-back"></div></code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
              <!-- <input type='file' class="form-control" id="tarj-vehi-back" name="tarj-vehi-back" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('tarj-vehi-back')"> -->
              <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/tarjveh_frontal_img.png')}}" id="tarj-vehi-back_img" alt="">
              <div class="input-group">
                <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                  <span class="btn btn-primary btn-file radioD">
                  Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="tarj-vehi-back" name="tarj-vehi-back" accept="image/x-png,image/gif,image/jpeg">
                  </span><span style="margin: 5px;" class="help-block-tarj-vehi-back"></span>
                </label>
              </div>

            </div>
        </div>
        <div class="col-xs-12 col-sm-6 padd2">
            <label class="col-xs-12 col-sm-6 col-md-4 padd" for="tarj-vehi-fec-emi">Fecha de Emisión:<code>*</code></label>
            <div class="col-xs-12 col-sm-6 col-md-8 padd">
              <input type='date' class="form-control" id="tarj-vehi-fec-emi" name="tarj-vehi-fec-emi">
            </div>
        </div>
    </div>
    <div class="seccion">
        <label class="col-xs-12 padd"><b>Soat</b></label>
        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="soat-front">Soat Frontal:<code>* <div id="div_soat-front"></div></code></label>
        <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
          <!-- <input type='file' class="form-control" id="soat-front" name="soat-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('soat-front')"> -->
          <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/soat_back_img.png')}}" id="soat-front_img" alt="">
          <div class="input-group">
            <label class="input-group-btn btn-lg text-center" style="width: 100%;">
              <span class="btn btn-primary btn-file radioD">
              Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="soat-front" name="soat-front" accept="image/x-png,image/gif,image/jpeg">
              </span><span style="margin: 5px;" class="help-block-soat-front"></span>
            </label>
          </div>

        </div>
    </div>
    <div class="seccion">
          <div class="col-xs-12 padd2">
              <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="revision_tecnica"><b>Revisión tecnica: <code><div id="div_rev_tec"></div></code></b></label>
              <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
                  <!-- <input type='file' class="form-control" id="revision_tecnica" name="revision_tecnica" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('revision_tecnica')"> -->
                  <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 img-responsive" src="{{asset('imagenes/revision_img.png')}}" id="revision_tecnica_img" alt="">
                  <div class="input-group">
                    <label class="input-group-btn btn-lg text-center" style="width: 100%;">
                      <span class="btn btn-primary btn-file radioD">
                      Subir <i class="fa fa-camera"></i><input type='file' class="form-control" id="revision_tecnica" name="revision_tecnica" accept="image/x-png,image/gif,image/jpeg">
                      </span><span style="margin: 5px;" class="help-block-revision_tecnica"></span>
                    </label>
                  </div>


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
      <div class="seccion" style="display:none;">
          <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 padd" for="recibo"><b>Recibo de Luz o Agua:</b> </label>
          <div id="div_recibo">

          </div>
          <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 padd">
              <input type='file' class="form-control" id="recibo" name="recibo" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('recibo')">
          </div>
      </div>
      <div class="form-group">
          <div class="col-sm-12 text-center">
              <button type="button" id="btn_ajax" class="btn btn-success">Enviar</button>
          </div>
      </div>
  </form>

</section>
<!-- Animación de carga de fotos -->
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
<!-- Form para cuando el conductor no cuente con DNI registrado. -->
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
<script src="{{ asset('js/External/Driver/documentos.js?v=222')}} "></script>
@endsection
