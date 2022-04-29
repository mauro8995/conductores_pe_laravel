@extends('layout-backend')
@section('title', 'Listado de Clientes')
@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
@endsection

@section('content')
<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Listado de Clientes</h3>
      <?php
      echo $permisocrear == true || $rolid == 4 ? '<div style="display: block;"><a href="/customer/new" class="btn btn-info pull-right">Registrar Cliente</a></div>' : '';
      ?>
      <input type="hidden" id="permiso" name="permiso" value="{{ $permisoverdet }}">
      <input type="hidden" id="rolid" name="rolid" value="{{ $rolid }}">
    </div>

    <div class="box-body">
      <div class="hero-callout">
        <table id="customers" name="customers" class="table table-bordered table-striped">
        <thead>
          <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Teléfono</th>
           <th width="5%">Correo</th>
           <th width="5%">Estatus</th>
         </tr>
        </thead>
        <tbody>
          @foreach($customers as $customer)
           <tr>
             <td align="center" width="5%">
               <?php
               echo $permisoverdet == true || $rolid == 4 ?
               '<div class="customers" style="display:none"><a href="'.route('customer.show',  ['id' => $customer->id]) .'"><i class="fa fa-cog" title="Detalles del Cliente"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
               <div class="admin"     style="display:none"><a href="'.route('customerAd.show', ['id' => $customer->id]) .'"><i class="fa fa-cog" title="Detalles del Cliente"></i></a></div>
               <div class="atencion"  style="display:none"><a href="'. route('customerAt.show', ['id' => $customer->id]) .'"><i class="fa fa-cog" title="Detalles del Cliente"></i></a></div>' : 'No tiene permiso';
               ?>
            </td>
             <td width="5%">{{  $customer->first_name }}</td>
             <td width="5%">{{  $customer->last_name }}</td>
             <td width="5%">{{  $customer->dni }}</td>
             <td width="5%">{{  $customer->phone }}</td>
             <td width="5%">{{  $customer->email }}</td>
             <td width="5%" align="center">{{ $customer->getStatus->description }}</i></td>
           </tr>
           @endforeach
        </tbody>
        <tfoot>
         <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Teléfono</th>
           <th width="5%">Correo</th>
           <th width="5%">Estatus</th>
         </tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</section>
@endsection
@section('js')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="{{ asset('js/Customer/index.js')}} "></script>
<script src="{{ asset('plugins/jquery/jquery.print.js') }}"></script>
@endsection
