@extends('layout-backend')
@section('title', 'Prioridades | Service Desk')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
  <section class="content-header">
      <h1 class="pull-left">Prioridades</h1>
      <h1 class="pull-right">
         <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('priority.create') }}">Agregar</a>
      </h1>
  </section>
  <div class="content">
      <div class="clearfix"></div>
      @include('flash::message')
      <div class="clearfix"></div>
      <div class="box box-primary">
          <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="priority-table">
                  <thead>
                      <tr>
                          <th>Descripcion</th>
                          <th>Tiempo de primera respuesta (Minutos)</th>
                          <th>Tiempo de resolucion (Horas)</th>
                          <th colspan="3">Accion</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach($Priority as $Priority)
                      <tr>
                          <td>{{ $Priority->description }}</td>
                          <td>{{ $Priority->response_time }}</td>
                          <td>{{ $Priority->solution_time }}</td>
                          <td>
                              {!! Form::open(['route' => ['priority.destroy', 'id' => $Priority->id], 'method' => 'POST']) !!}
                              <div class='btn-group'>
                                  <a href="{{ route('priority.edit', [$Priority->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                  {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Estas seguro?')"]) !!}
                              </div>
                              {!! Form::close() !!}
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
            </div>
          </div>
      </div>
      <div class="text-center">

      </div>
  </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/show.js') }}"></script>
@endsection
