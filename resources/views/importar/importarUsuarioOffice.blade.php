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
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="form-group">
	  <label for="files">Upload a CSV formatted file:</label>
	  <input type="file" id="files"  class="form-control" accept=".csv" required />
	</div>
	<div class="form-group">
	 <button type="submit" id="submit-file" class="btn btn-primary">Upload File</button>
	 </div>

   
    </div>
  </section>
<!--  -->



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


<script src="{{ asset('js/importar/papaparse.js')}} "></script>
  <script src="{{ asset('js/importar/importarUsuarioOffice.js')}} "></script>

@endsection
