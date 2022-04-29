@extends('layout-simple')
@section('title', 'verificar contacto.')
@section('content')
<div id="LoginForm">
  <div class="container">
      <h1 class="form-heading"></h1>
      <div class="login-form">
      <p><div class="">
          <div class="panel"><h2>Validar datos de contacto.<br></h2></div>
		{{ csrf_field() }}


		<div class="box box-primary">

      <div class="box-body">
        <form  id="myform">
          <meta name="csrf-token" content="{{ csrf_token() }}">
		
	<div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-6">
		<label for="Datos">Usuario: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="id_office" placeholder="usuario" name="id_office"><button type="button" name="button" class="btn btn-success" onclick="enviar()">Buscar</button>
                </div>
              </div>


		<div class="col-xs-12 col-md-6"><label for="Datos">Codigo verificación Telefono: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="text" class="form-control" id="info" placeholder="informacion." name="info">
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
                  <input type="text" class="form-control" id="phone" placeholder="999666333" name="phone"><button type="button" name="button" class="btn btn-success" onclick="validatePhone()">Enviar</button>
                </div>
              </div>
              <div class="col-xs-12 col-md-6"><label for="Datos">Codigo verificación Telefono: <code>*</code></label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type="number" class="form-control" id="cod-phone" placeholder="Ingrese el codigo de verificacion aqui" name="cod-phone"><button type="button" name="button" class="btn btn-success" onclick="validateCodigoPhone()">Validar</button>
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
                  <input type="text" class="form-control" id="email" placeholder="CORREO@GMAIL.COM" name="email"><button type="button" name="button" class="btn btn-success" onclick="validateEmail()">Enviar</button>
                </div>
              </div>
              <div class="col-xs-12 col-md-6"><label for="Datos">Codigo verificación correo: <code>*</code></label>
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
            
                 
                <div class="input-group" style="display: flex;">
                  <button type="button" name="button" class="btn btn-success" onclick="guardar()">Guardar Cambios</button>
                </div>
              </div>
           
          </div>

           </form>
    </div>

 
<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>
 </div>




          </div>
      </div>
  </div>
</div>


@endsection