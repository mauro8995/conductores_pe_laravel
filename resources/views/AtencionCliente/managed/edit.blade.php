@extends('layout-backend')
@section('title', 'Service Desk')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
<section class="content-header">
        <h1>
            Editar Gestionado
        </h1>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($CustomerTypes, ['route' => ['managed.update', 'id' => $CustomerTypes->id], 'method' => 'POST']) !!}
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <!-- Description Field -->
                      <div class="form-group col-sm-6">
                      {!! Form::label('description', 'Description:') !!}
                      {!! Form::text('description', null, ['class' => 'form-control']) !!}
                      </div>

                      <!-- Submit Field -->
                      <div class="form-group col-sm-12">
                      {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                      <a href="{{ route('managed.index') }}" class="btn btn-default">Cancelar</a>
                      </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('js')
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
