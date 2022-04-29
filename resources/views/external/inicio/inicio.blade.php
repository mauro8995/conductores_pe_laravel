  @extends('layout-home')
  @section('title', 'Inicio')
  @section('content')
    <div class="container">
      <div class="row">
        <div  id="fa1" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 access-direct">
          <center><i style="padding: 20px;" class="fa  fa-group fa-3x"></i></center>
          <center  id="s">Registro de FM<br>Fleet Manager</i></center>
        </div>

        <div id="fa2" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 access-direct">
          <center><i style="padding: 20px;" class="fa  fa-user-plus fa-3x"></i></center>
          <center>Registro de accionistas</i></center>
        </div>
        <div id="fa3" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 access-direct">
          <center><i style="padding: 20px;" class="fa  fa-cab fa-3x"></i></center>
          <center>Pre-Registro de conductores</i></center>
        </div>
      </div>
    </div>
  @endsection
  @section('script')

  <script src="{{ asset('js/External/inicio.js')}}"></script>
  </body>
  </html>
  @endsection
