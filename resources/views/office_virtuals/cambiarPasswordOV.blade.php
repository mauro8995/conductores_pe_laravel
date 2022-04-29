@extends('layout-backend')
@section('title', 'Cambiar Contrasena')
@section('css')
  <!-- Agregando Datos- -->
  <link rel="stylesheet" href="{{ asset('alertify/css/alertify.min.css') }}">

@endsection

@section('content')
<div class="content">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  {{ csrf_field() }}


  <div class="panel panel-default">
    <div class="panel panel-heading">
      <h1 class="panel-title">Contrasena | Usuario de Oficina Virtual</h1>
    </div>

    <div class="panel panel-body">


        <form method="POST" action="{{ route ('officeVirtuals.saveContrasenaOV') }}" id="formPassword">
          <meta name="csrf-token" content="{{ csrf_token() }}" />

          {{ csrf_field() }}

          <div class="row">
            <div class="col-md-4 col-md-offset-4">
              @include('flash::message')

              <div class="form-group {{ $errors->has('usuario')? 'has-error' : '' }} ">
                <label for=password>Usuario</label>
                <div class="input-group">
                  <input class="form-control" type="text" name="usuario" id="usuario"  placeholder="Ingresa el usuario" aria-required="true">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                </div><div><span class="help-block" id="error"></span></div>
                {!!  $errors->first('usuario', '<span class="help-block"><strong>:message</strong></span>' ) !!}
              </div>

              <div class="form-group {{ $errors->has('password')? 'has-error' : '' }} ">
                <label for=password>Contraseña Nueva</label>
                <div class="input-group">
                  <input class="form-control" type="password" name="password" id="password"  placeholder="Ingresa tu contrasena" aria-required="true">
                  <span class="input-group-addon"><a id="reveal-password" ><i class="glyphicon glyphicon-eye-open"></i></a></span>
                </div><div><span class="help-block" id="error"></span></div>
                {!!  $errors->first('password', '<span class="help-block"><strong>:message</strong></span>' ) !!}
              </div>

              <div class="form-group {{ $errors->has('password_confirm')? 'has-error' : '' }} ">
                <label for=password_confirm>Repetir Contraseña</label>
                <div class="input-group">
                  <input class="form-control" type="password" name="password_confirm" id="password_confirm"  placeholder="Ingresa tu contrasena" aria-required="true">
                  <span class="input-group-addon">
                    <a id="reveal-password2"><i class="glyphicon glyphicon-eye-open"></i></a>
                  </span>
                </div><div><span class="help-block" id="error"></span></div>
                {!!  $errors->first('password_confirm', '<span class="help-block"><strong>:message</strong></span>' ) !!}
              </div>

              <hr>
              <button class="btn btn-registro btn-primary btn-block">Guardar</button>
            </div>
          </div>


        </form>

      </div>

  </div>

</div>
@endsection

@section('js')
<script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>
<!-- alertify -->
<script src="{{ asset('alertify/js/alertify.min.js') }}"></script>
<script src="{{ asset('js/office_virtuals/password.js')}} "></script>

@endsection
