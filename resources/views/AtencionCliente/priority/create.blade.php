@extends('layout-backend')
@section('title', 'Service Desk')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Agregar prioridades
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
              <div class="clearfix"></div>
              @include('flash::message')
              <div class="clearfix"></div>
                <div class="row">
                    {!! Form::open(['route' => 'priority.store']) !!}
                        <!-- Description Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('description', 'Descripcion:') !!}
                            {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>

                        <!-- Response time Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('response_time', 'Tiempo de 1ra respuesta:') !!}
                            {!! Form::text('response_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>

                        <!-- Solution time Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('solution_time', 'Tiempo de solucion:') !!}
                            {!! Form::text('solution_time', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('priority.index') }}" class="btn btn-default">Cancelar</a>
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
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
@endsection
