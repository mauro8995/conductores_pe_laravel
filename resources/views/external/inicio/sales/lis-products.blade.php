@extends('layout-simple')
@section('title', 'Productos')
@section('content')
        <div class="container">
          <div class="row">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @foreach ($product as $key => $value)
              <form method="get" action="/producto/registro-pago/{{$value->precio->id}}" enctype="multipart/form-data">
                <div id="fa2" style=" padding: 40px; font-weight: bold; font-size: x-large" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 btn-loquiero">
                    <center>
                      <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fx-10acc-1-100x100.png?alt=media&token=7e2d9b3c-5278-445d-8e05-3669fef59b52" alt="Card image cap">
                        <div class="card-body">
                          <h5 class="card-title"><p>{{$value->product->description}}</p></h5>
                          <p class="card-text">{{$value->moneda->symbol}}  {{$value->precio->price}}</p>
                          <button class="btn btn-primary" type="submit">Lo quiero</button>
                        </div>
                      </div>
                  </center>
                </div>
              </form>
            @endforeach
            {{--
            --}}
          </div>
        </div>
@endsection
