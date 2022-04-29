@extends('layout-backend')
@section('title', 'EVENTO WIN')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-md-12">
      {{-- DATOS PERSONALES --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">BIENVENIDO ENVENTO WIN - 2019 BUSCAR</h3>
            <div class="box-tools pull-right">
            {{-- <button type="button" class="btn btn-box-tool btn-expand" data-widget="collapse" id="ids" vergene = "{{ $permisover }}" verespe = "{{ $permisoverespe }}" rolid="{{ $rolid }}"><i class="fa fa-minus"></i></button> --}}
            </div>
          </div>
          <div class="box-body">
            <form  id=formPersonal>
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div  class="col-md-12 col-md-6 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="id_office">ID: <code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd">
                    <input type="text" class="form-control" id="id_office" placeholder="ID DE OFFICINA" name="id_office">
                </div>
             </div>


             <div  class="col-md-12 col-md-6 padd2">
               <label class="col-xs-12 col-sm-3 col-md-4 padd" for="tipo_doc">TIPO DE DOCUMENTO: <code>*</code></label>
               <div class="col-xs-12 col-sm-9 col-md-8 padd">
                   {!! Form::select('tipo_doc', [], null, ['id'=>'tipo_doc','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
               </div>
            </div>
            <div  class="col-md-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">NUMERO DE DOCUMENTO: <code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd">
                  <input type="text" class="form-control" id="dni" placeholder="INGRESE DOCUMENTO DE IDENTIDAD" name="dni">
              </div>
           </div>
           <div  class="col-md-12 col-md-6 padd2">
             <label class="col-xs-12 col-sm-3 col-md-4 padd" for="first_name">NOMBRES: <code>*</code></label>
             <div class="col-xs-12 col-sm-9 col-md-8 padd">
                 <input type="text" class="form-control" id="first_name" placeholder="INGRESE NOMBRES" name="first_name">
             </div>
          </div>
          <div  class="col-md-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="last_name">APELLIDOS: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type="text" class="form-control" id="last_name" placeholder="INGRESE APELLIDOS" name="last_name">
            </div>
         </div>

         <div  class="col-md-12 col-md-6 padd2">
           <label class="col-xs-12 col-sm-3 col-md-4 padd" for="email">CORREO: <code>*</code></label>
           <div class="col-xs-12 col-sm-9 col-md-8 padd">
               <input type="text" class="form-control" id="email" placeholder="INGRESE CORREO" name="email">
           </div>
        </div>

        <div  class="col-md-12 col-md-6 padd2">
          <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phone">TELEFONO: <code>*</code></label>
          <div class="col-xs-12 col-sm-9 col-md-8 padd">
              <input type="text" class="form-control" id="phone" placeholder="INGRESAR TELEFONO" name="phone">
          </div>
       </div>

       <div  class="col-md-12 col-md-6 padd2">
         <label class="col-xs-12 col-sm-3 col-md-4 padd" for="id_viaje">ID VIAJE: <code>*</code></label>
         <div class="col-xs-12 col-sm-9 col-md-8 padd">
             <input type="text" class="form-control" id="id_viaje" placeholder="ID VIAJE" name="id_viaje">
         </div>
      </div>

      <div  class="col-md-12 col-md-6 padd2">
        <label class="col-xs-12 col-sm-3 col-md-4 padd" for="id_viaje">-: <code>*</code></label>
        <div class="col-xs-12 col-sm-9 col-md-8 padd">
            <button type="button" name="button" class="btn btn-default" onclick="create()">CREAR USUARIO</button>
        </div>
     </div>

            </form>

          </div>

        </div>
      {{-- DATOS PERSONALES --}}







    </div>

  </div>
</section>



  <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
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

  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>



  <script src="{{ asset('js/External/Driver/evento.js')}} "></script>

  @endsection
