@extends('layout-backend')
@section('title', 'Buscar')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
@endsection

@section('content')

<section class="content">

  <div class="box box-primary">

      <div class="box-body">
        <form  id="myform">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="num_ticket" class="control-label">LIDER USUARIO</label>
                    <div class="input-group" style="display: flex;">
                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                        {!! Form::select('users', $users, null, ['id'=>'users','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                        <button type="button" class="btn btn-info pull-right" id="search">Buscar</button>
                    </div>
                    <div><span class="help-block" id="error"></span></div>
                </div>
            </div>
          </div>
      </div>
      </form>
    </div>

    <div class="box box-primary">
        <div class="box-footer">
           <button type="button" class="btn btn-default" id="paysponsor">Pagar</button>
        </div>
        </form>
      </div>

  <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">CONDUCTORES APROBADOS POR PAGAR</h3>
        </div>
        <div class="box-body">
           <div class="table table-striped w-auto">
             <table id="drivers" class="table table-striped compact">
                  <thead>
                    <tr>
                      <th>ACCION</th>
                      <th>USUARIO SPON.</th>
                      <th>NOMBRE SPON.</th>
                      <th>APELLIDOS SPON.</th>
                      <th>TELEFONO SPON.</th>
                      <th>ID OV COND.</th>
                      <th>DNI COND.</th>
                      <th>NOMBRES COND.</th>
                      <th>APELLIDOS COND.</th>
                      <th>ESTADO</th>
                      <th>FECHA DE PAGO</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ACCION</th>
                      <th>USUARIO SPON.</th>
                      <th>NOMBRE SPON.</th>
                      <th>APELLIDOS SPON.</th>
                      <th>TELEFONO SPON.</th>
                      <th>ID OV COND.</th>
                      <th>DNI COND.</th>
                      <th>NOMBRES COND.</th>
                      <th>APELLIDOS COND.</th>
                      <th>ESTADO</th>
                      <th>FECHA DE PAGO</th>
                    </tr>
                  </tfoot>
              </table>
           </div>
        </div>
    </div>

<div class="modal fade" id="modal-cargando" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-body">
          <div class="box-body">

          <div class="row" align="center">
            <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image">
            <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
</section>

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

  <script src="{{ asset('js/External/Driver/viewpays.js')}} "></script>

@endsection
