@extends('layout-backend')
@section('title', 'Buscar')

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
@endsection

@section('content')
<section class="content">
    <div class="box box-primary">
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Itéms de Busqueda</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool btn-expand" data-widget="collapse" id="ids" vergene="" verespe="" rolid=""><i class="fa fa-minus"></i></button>
            </div>
        </div> --}}
      <div class="box-body">
        <form  id="myform">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="num_ticket" class="control-label">Usuario/ Telefono/ Email</label>
                    <div class="input-group" style="display: flex;">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        {!! Form::text('off_e', null,['id'=>'off_e', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                    </div>
                    <div><span class="help-block" id="error"></span></div>
                </div>
            </div>
        </div>
      <div class="box-footer">
           <button type="button" class="btn btn-default pull-right" onclick="alldrivers()">BUSCAR</button>
     </div>
     </form>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Listado de usuarios ov</h3>
        </div>
        <div class="box-body">
           <div class="table table-striped w-auto">
              <table id="driver"  class="table" >
                  <thead>
                    <tr>
                      <th>ID OFFICE</th>
                      <th>USUARIO</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>CELULAR PRIVADO</th>
                      <th>CELULAR PUBLICO</th>
                      <th>CORREO PRIVADO</th>
                      <th>CORREO PUBLICO</th>
                      <th>PAIS</th>
                    </tr>
                  </thead>
                  <tbody id="viewov">
                     
                  </tbody>
                  <tfoot>
                    <tr>
	              <th>ID OFFICE</th>
                      <th>USUARIO</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>CELULAR PRIVADO</th>
                      <th>CELULAR PUBLICO</th>
                      <th>CORREO PRIVADO</th>
                      <th>CORREO PUBLICO</th>
                      <th>PAIS</th>            
                    </tr>
                  </tfoot>
              </table>
           </div>
        </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-viewHistorico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="modal-content">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">PROCESO DE VALIDACION</h3>
            </div>
            <div class="box-body">
              <div class="table table-striped w-auto">
                 <table id="tableprocesoValidacion"  class="table" >
                     <thead>
                       <tr>
                         <th>PROCESO</th>
                         <th>ESTATUS</th>
                         <th>USUARIO RESP.</th>
                         <th>DESCRIPCION</th>
                         <th>CREADO</th>
                         <th>ACTUALIZACION</th>
                       </tr>
                     </thead>
                     <tbody>

                     </tbody>
                     <tfoot>
                       <tr>
                         <th>PROCESO</th>
                         <th>ESTATUS</th>
                         <th>USUARIO RESP.</th>
                         <th>DESCRIPCION</th>
                         <th>CREADO</th>
                         <th>ACTUALIZACION</th>
                       </tr>
                     </tfoot>
                 </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Salir</button>
      </div>
    </div>
  </div>
</div>



<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
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
  <script src="{{ asset('js/office_virtuals/index.js?v=1')}} "></script>
@endsection
