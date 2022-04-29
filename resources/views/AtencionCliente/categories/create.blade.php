@extends('layout-backend')
@section('title', 'Categorias | Service Desk')

@section('css')
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Groups Tickets
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
              <div class="clearfix"></div>
              @include('flash::message')
              <div class="clearfix"></div>
                <div class="row">
                    {!! Form::open(['route' => 'categories.store']) !!}
                        <!-- Description Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Nombre:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Description Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('description', 'Descripcion:') !!}
                            {!! Form::text('description', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- idTypeRequirements Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('id_type_requeriments', 'Tipo de requerimiento:') !!}
                            {!! Form::select('id_type_requeriments', $typeRequirements, null, ['id'=>'id_rol','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('categories.index') }}" class="btn btn-default">Cancelar</a>
                        </div>
                      {!! Form::close() !!}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/show.js') }}"></script>
@endsection
