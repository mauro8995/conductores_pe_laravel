@extends('layout-backend')
@section('title', 'Reportes')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- Estulos personalizados --}}
  {{-- <link rel="stylesheet" href="{!! asset('css/Report/report.css') !!}"> --}}
@endsection

@section('content')
<section class="content">
  <div class="box">
    <div class="box-header">
    </div>
    <div class="box-body" id="content">
      {{-- inicio de filtros --}}
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Filtros :</h3>
              </div>
              <div class="box-body">
                <!-- Date range -->
                <meta name="csrf-token" content="{{ csrf_token() }}" />

                  <div class="row">
                    <div class="col-xs-6">
                      <!-- /.form group -->
                      <!-- Date range -->
                      <div class="form-group">
                        <label>Rangos de Fechas:</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" name="datetimes" id="rageTimes">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
                    </div>
                    <div class="col-xs-6">
                      <!-- /.form group -->
                      <!-- Date range -->
                      <div class="form-group">
                        <label>Estado:</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-list-alt"></i>
                          </div>
                          <select id="e2_3">
                              <option value="sales">Ventas</option>
                              <option value="onHold">En Espera</option>
                          </select>
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
                    </div>
                  </div>
                <div class="form-group">
                  <div class="input-group">
                    <button type="button" class="btn btn-primary" id="salesToDay" onclick="filterAdvance()">Procesar</button>
                  </div>
                  <!-- /.input group -->
                </div>

              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
          </div>
        {{-- fin de filtros --}}
        <div class="table table-striped">
          <table id="taxiWin"  class="responsive">
          <thead>
            <tr>
              <th>DNI</th>
              <th>USUARIO</th>
              <th>NOMBRES</th>
              <th>APELLIDOS</th>
              <th>PHONE</th>
              <th>CORREO</th>
              <th>CIUDAD</th>
              <th>MARCA</th>
              <th>PLACA</th>
              <th>MODELO</th>
              <th>ESTADO</th>
              <th>FECHA</th>
              <th>CREADO</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <th>DNI</th>
              <th>USUARIO</th>
              <th>NOMBRES</th>
              <th>APELLIDOS</th>
              <th>PHONE</th>
              <th>CORREO</th>
              <th>CIUDAD</th>
              <th>MARCA</th>
              <th>PLACA</th>
              <th>MODELO</th>
              <th>ESTADO</th>
              <th>FECHA</th>
              <th>CREADO</th>
            </tr>
          </tfoot>
        </table>
        </div>
      {{--  --}}
    </div>
    {{-- fin del contendor  --}}

    {{-- Inicio del modal --}}
    <div class="modal fade docs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content ">
          <div class="bg-successe">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Obteniendo datos, por favor espere ...</h5>
                    </div>
                    <div class="modal-body">
                      {{--  --}}
                              @include('load.loading')
                    {{--  --}}
                    </div>
          </div>

        </div>
      </div>
    </div>
    {{--FIn del modal  --}}
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="{{ asset('js/Report/report.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
