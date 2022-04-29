@include('partials.top-index')
@include('partials.nav-index')
@section('title', 'Inicio de sesión | WIN')
<div class="container" id="LoginForm">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">
              <div class="p-5">
                  <div class="text-center"> <!-- Título de login -->
                      <h1 class="h3 text-gray-900 mb-4">Bienvenidos</h1>
                      <h4 class="h5 text-gray-900 mb-4">Sistema validacion de conductores</h4>
                  </div>
                  <form id="Login" action="{{ url('login') }}" method="POST">
                    {{ csrf_field() }}
                    @if(Session::has('error_message'))
                    <div class="alert alert-info">
                      {{ Session::get('error_message') }}
                    </div>
                    @endif
                    <div class="form-group {{ $errors->has('username')? 'has-error' :'' }}">
                        <label class="text-gray-600 small" for="username">Nombre de usuario</label>
                        <input id="username" name="username" class="form-control form-control-solid py-4" type="text" aria-label="Nombre de Usuario" value="{{ old('username') }}" />
                        {!! $errors->first ('username', '<div class="error"><span class="help-block">:message</span></div>') !!}
                    </div>
                    <div class="form-group">
                        <label class="text-gray-600 small" for="password">Contraseña</label>
                        <input id="password" name="password" class="form-control form-control-solid py-4" type="password" aria-label="Contraseña"/>
                        {!! $errors->first ('password', '<div class="error"><span class="help-block">:message</span></div>') !!}
                    </div>
                    @if (session()->has('flash') )
                      <div class="alert alert-info">{{ session('flash')}}</div>
                    @endif
                    <div class="form-group {{ $errors->has('datos')? 'has-error' :'' }}">
                      {!! $errors->first ('datos', '<div class="error"><span class="help-block">:message</span></div>') !!}
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mb-0">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="layoutDefault_footer">
    <footer class="footer pt-3 pb-2 mt-auto bg-dark footer-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 small">Copyright &copy; WIN RIDESHARE 2020</div>
                <div class="col-md-6 text-md-right small">
                    <a href="javascript:void(0);">Políticas de privacidad</a>
                    &middot;
                    <a href="javascript:void(0);">Terminos &amp; Condiciones</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/script-sb-ui-pro.js') }}"></script>
<script src="{{ asset('js/Driver/created.js') }}"></script>
<script src="{{ asset('plugins/JIC/dist/JIC.min.js')}} " type="text/javascript"></script>
<!-- Iserta js personalizado de cada vista -->
@yield('js')
<script>
feather.replace()
</script>
</body>
</html>
