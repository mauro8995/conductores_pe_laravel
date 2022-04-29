@extends('layout-backend')
@section('title', 'Service Desk')

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
        <h1>
            Asuntos
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
              <div class="clearfix"></div>
              @include('flash::message')
              <div class="clearfix"></div>
                <div class="row">
                    {!! Form::open(['route' => 'subjects.store']) !!}
                        <!-- Description Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('description', 'Descripcion:') !!}
                            {!! Form::text('description', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- idGroupTickets Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('id_groups_tickets', 'Grupo:') !!}
                            {!! Form::select('id_groups_tickets', $groupsTickets, null, ['id'=>'id_groups_tickets','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('subjects.index') }}" class="btn btn-default">Cancelar</a>
                        </div>
                      {!! Form::close() !!}
                    </form>
                </div>
            </div>
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
