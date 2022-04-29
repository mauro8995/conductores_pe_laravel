@extends('layout-backend')
@section('title', 'Registrar conductor')
@section('css')
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js" ></script>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
@endsection

@section('content')
<section class="content">
  <div class="box" style="padding: 35px;">
    <div class="box-header">
      <h3>Registrar Conductor</h3>
      <code>Campos obligatorios ( * )</code>
    </div>
    <div class="box-body">
    <form class="form-horizontal" action="#" id="formuseroffices" enctype="multipart/form-data" autocomplete="off">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="seccion">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">USUARIO DE OFICINA VIRTUAL: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control input-number-letter" id="idoffice" placeholder="Ingresar el usuario" name="idoffice">
              </div>
            </div>
            <?php
              if ($rol->id != 7){
            ?>
            <div class="col-xs-12 col-md-6"><label for="Datos">Sponsor: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="sponsor" placeholder="Ingresar usuario del sponsor" name="sponsor">
              </div>
            </div>
            <?php
              }
            ?>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">Tipo de documento de identidad: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                {!! Form::select('tipdocid', $type_docs, null, ['id'=>'tipdocid','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
              </div>
            </div>
            <div class="col-xs-12 col-md-6 numid"><label for="Datos">Numero de documento de identidad: <code>*</code></label>
              <div class="input-group" style="display: flex;">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="dni" placeholder="12345678" name="dni"><button type="button" id="btn_search" class="btn btn-success">Buscar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-md-6"><label for="Datos">Nombres: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="first_name" placeholder="PEDROJOSE" name="first_name">
              </div>
            </div>
            <div class="col-xs-12 col-md-6"><label for="Datos">Apellidos: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type="text" class="form-control" id="last_name" placeholder="PEREZ DIAZ" name="last_name">
              </div>
            </div>
          </div>
        </div>
        <div class="form-group numtipdoc">
          <div class="row">
            <div  class="col-md-12 col-md-6 padd2"><label for="Datos">Fecha de nacimiento: <code>*</code></label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-birthday-cake"></i>
                </div>
                <input type="date" class="form-control" id="datebirth" placeholder="Ingresar fecha de nacimiento" name="datebirth">
              </div>
           </div>
          </div>
        </div>
        <div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-6"><label for="Datos">Provincia: <code>*</code></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <select class="form-control" id="provincia"  name="provincia" onchange="selectcity(this);">
                          <option>SELECCIONAR</option>
                          <option value="2825">Lima</option>
                          <option value="2815">Arequipa</option>
                          <option value="2822">Huancayo</option>
                          <option value="2824">Chiclayo</option>
                          <option value="2818">Cusco</option>
                          <option value="2823">Trujillo</option>
                          <option value="2820">Huanuco</option>
	                        <option value="2813">Chimbote</option>
                          <option value="2833">Tacna</option>
                          <option value="2821">Ica</option>
                          <option value="2831">Puno</option>
                          <option value="2828" data-city="32145">Ilo</option>
                          <option value="2828" data-city="32146">Moquegua</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-md-6"><label for="Datos">Dirección: <code>*</code></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  {!! Form::textarea('district', null,['id'=>'district', 'class'=>'form-control', 'value'=> old('district'),  'placeholder'=>'los olivos, Surco, SMP, Miraflores', 'rows'=>'2'] ) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-6"><label for="Datos">Teléfono: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="phone" placeholder="999666333" name="phone"><div id="codphonever"><button type="button" name="button" class="btn btn-success sendcodphone" id="sendvalphone" onclick="validatePhone(1)">Enviar SMS</button></div>
                </div><div><span class="help-block" id="error"></span><div id="clock" style="color: red;"></div></div>
              </div>
              <div class="col-xs-12 col-md-6" id="phonevaluser"><label for="Datos">Codigo verificación Telefono: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" id="valphonex" onclick="validateCodigoPhone()">Validar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-6"><label for="Datos">Correo: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="email" placeholder="CORREO@GMAIL.COM" name="email"><button type="button" name="button" class="btn btn-success validateEmailv" onclick="validateEmail()">Enviar</button>
                </div>
              </div>
              <div class="col-xs-12 col-md-6" id="emailvaluser"><label for="Datos">Codigo verificación correo: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="number" class="form-control" id="cod-email" placeholder="Ingrese el codigo de verificacion aqui" name="cod-email"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoEmail()">Validar</button>
                </div>
              </div>
            </div>
          </div>






          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-6"><label for="Datos">Licencia: <code>*</code></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="licence" placeholder="Q00000000" name="licence">
                </div>
              </div>
              <div class="col-xs-12 col-md-6"><label for="Datos">Placa/Matricula: <code>*</code></label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="placa" placeholder="WWW000" name="placa">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12 text-center">
              <button type="button" id="btn_ajax" class="btn btn-success">registrar</button>
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
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
<script src="{{ asset('js/External/Driver/useroffices.js?v=444')}} "></script>
<script src="{{ asset('js/External/Driver/jquery.countdown.js')}} "></script>
<script type="text/javascript">
  $('.input-number-letter').on('input', function () {
    this.value = this.value.replace(/[^a-z0-9\_]/,'');
  });

  window.showAlert = function(){
    alertify.alert('<h2 style="font-weight: bold;">En el campo de provincia, seleccionar en que provincia trabaja el conductor.</h2>').setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 !Advertencia! </h3>');
  }
  window.showAlert();
</script>
@endsection
