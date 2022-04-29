@extends('layout-backend')
@section('title', 'Categorias | Service Desk')

@section('css')
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
  <section class="content-header">
      <h1 class="pull-left">Categorias</h1>
      <h1 class="pull-right">
         <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('categories.create') }}">Agregar</a>
      </h1>
  </section>
  <div class="content">
      <div class="clearfix"></div>
      @include('flash::message')
      <div class="clearfix"></div>
      <div class="box box-primary">
          <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="categories-table">
                  <thead>
                      <tr>
                          <th>Nombre</th>
                          <th>Descripcion</th>
                          <th>Tipo de requerimiento</th>
                          <th colspan="3">Accion</th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach($category as $category)
                      <tr>
                          <td>{{ $category->name }}</td>
                          <td>{{ $category->description }}</td>
                          <td>{{ $category->getTypeRequirements->description }}</td>
                          <td>
                              {!! Form::open(['route' => ['categories.destroy', 'id' => $category->id], 'method' => 'POST']) !!}
                              <div class='btn-group'>
                                  <a href="{{ route('categories.edit', [$category->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/show.js') }}"></script>
@endsection
