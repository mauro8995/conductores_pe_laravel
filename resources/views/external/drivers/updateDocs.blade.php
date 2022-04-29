<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ACTUALIZAR DOCUMENTOS VENCIDOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<style>
  .collapsible {
    background-color: #f0ad4e;
    color: white;
    cursor: pointer;
    padding: 10px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
  }

  .active, .collapsible:hover {
    background-color: #f0ad4e;
  }

  .collapsible:after {
    content: '\25BA';
    color: white;
    font-weight: bold;
    float: right;
    margin-left: 5px;
  }

  .active:after {
    content: "\25BC";
  }
</style>
</head>
<?php
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo.png?alt=media&token=c0d567df-b26c-43da-bf84-4ff4ab866889");
        $base64 = 'data:image/png;base64,' . base64_encode($data);
?>
<body style="font-family: 'Quicksand', sans-serif;">
  <script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyDQCZESZB5v0-ReeZYUcXWRbOb2IDaJR_8",
      authDomain: "voucher-img-fb702.firebaseapp.com",
      databaseURL: "https://voucher-img-fb702.firebaseio.com",
      projectId: "voucher-img-fb702",
      storageBucket: "voucher-img-fb702.appspot.com",
      messagingSenderId: "807276908227"
    };
    firebase.initializeApp(config);
  </script>
  <div class="container text-center">
    <div class="row">
      <center><img src="{{$base64}}" alt="logo" width="220" style="padding-top: 40px;"></center>
      <h3>ACTUALIZAR DOCUMENTOS</h3>
    </div>
  </div>
  <div class="container">
    <div class="row" style="padding-top: 30px;  padding-bottom: 30px;">
      <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
        <div id="divupdateview">
        <div class="row">
          <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
            <h4>Ingresar numero de licencia</h4>
            <code>Ejemplo: A12345678</code>
            {!! Form::text('licencia', null,['id'=>'licencia', 'class'=>'form-control','placeholder' => 'Ingresar licencia','maxlength'=>'20'] ) !!}
          </div>
        </div>
        <div class="row" style="padding-top: 20px;">
          <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
            <center><span style="font-size: 60px !important; color: #10436b;" class="fa fa-user"></span></center>
          </div>
        </div>
        <div class="form-group" style="padding-top: 20px;">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <label class="col-xs-12 col-sm-6 col-md-6 padd" for="dni">Nombres:</label>
              <div class="col-xs-12   col-sm-6 col-md-6 padd">
                  <label id="first_name"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <label class="col-xs-12 col-sm-6 col-md-6 padd" for="dni">Apellidos:</label>
              <div class="col-xs-12   col-sm-6 col-md-6 padd">
                  <label id="last_name"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <label class="col-xs-12 col-sm-6 col-md-6 padd" for="dni">Ciudad:</label>
              <div class="col-xs-12   col-sm-6 col-md-6 padd">
                  <label id="city"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <center><button type="button" class="btn btn-warning" id="updateview">Actualizar</button></center>
            </div>
          </div>
        </div>
        </div>
        <form action="#" id="myform" method="POST">
 	<div class="row" id="divvalsafe">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-top: 5px;  padding-bottom: 5px;">
              <button class="collapsible" type="button" id="updatesoat">Actualizar seguro </button>
              <div class="contentw"></div>
             </div>
          </div>
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div id="divsoat">
	    <div class="row" style="padding-top: 20px;">
              <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
                <center><h3 id="textsoat">ACTUALIZAR SEGURO</h3></center>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                    <div class="col-sm-offset-2 col-sm-4"><label for="Datos">Tipo de seguro:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <select id="type_safe" name="type_safe" class="form-control select2">
                          <option>Seleccionar</option>
                          <option value="SOAT">SOAT</option>
                          <option value="CAT">CAT</option>
                        </select>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-group" id="divafocat">
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-4"><label for="Datos">Compañia:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-map-marker"></i>
                      </div>
                      <input type='text' class="form-control" id="company" name="company">
                    </div>
                  </div>
                  <div class="col-sm-4"><label for="Datos">Uso del vehiculo:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-map-marker"></i>
                      </div>
                      <input type='text' class="form-control" id="type_soat" name="type_soat">
                    </div>
                  </div>
              </div>
           </div>
            <div class="form-group">
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-4"><label for="Datos">Fecha de emisión:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-map-marker"></i>
                      </div>
                      <input type='date' class="form-control" id="fec_emi_soat" name="fec_emi_soat">
                    </div>
                  </div>
                  <div class="col-sm-4"><label for="Datos">Fecha de vencimiento:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-map-marker"></i>
                      </div>
                      <input type='date' class="form-control" id="fec_ven_soat" name="fec_ven_soat">
                    </div>
                  </div>
              </div>
           </div>
          <div class="form-group">
            <div class="row" style="padding-top: 20px;">
              <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
                <center><span style="font-size: 60px !important; color: #10436b;" class="fa fa-camera"></span></center>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2"><label for="Datos">Foto Frontal:</label>
                <div class="input-group" style="display: flex;">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <input type='file' class="form-control" id="soat-front" name="soat-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('soat-front')"><div id="div_soat-front"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
	<div class="row" id="divvalrevtec">
           <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-top: 5px;  padding-bottom: 5px;">
             <button class="collapsible" id="updaterevtec" type="button">Actualizar revision tecnica</button>
             <div class="contentw"></div>
            </div>
         </div>
        <div id="divrevtec">
          <div class="row" style="padding-top: 20px;">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <center><h3 id="textrevtec">ACTUALIZAR REVISION TECNICA</h3></center>
            </div>
          </div>
          <div class="form-group">
              <div class="row">
                <div class="col-sm-offset-2 col-sm-4"><label for="Datos">Fecha de emisión:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-map-marker"></i>
                    </div>
                    <input type='date' class="form-control" id="fec_emi_rev" name="fec_emi_rev">
                  </div>
                </div>
                <div class="col-sm-4"><label for="Datos">Fecha de vencimiento:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-map-marker"></i>
                    </div>
                    <input type='date' class="form-control" id="fec_ven_rev" name="fec_ven_rev">
                  </div>
                </div>
            </div>
        </div>
        <div class="form-group">
          <div class="row" style="padding-top: 20px;">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" style="padding-left: 0;">
              <center><span style="font-size: 60px !important; color: #10436b;" class="fa fa-camera"></span></center>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2"><label for="Datos">Foto Frontal:</label>
              <div class="input-group" style="display: flex;">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                <input type='file' class="form-control" id="rev-front" name="rev-front" accept="image/x-png,image/gif,image/jpeg" onchange="validateFileType('rev-front')"><div id="div_rev-front"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" id="divupdatebtn">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <center><button type="button" id="updatebtn" class="btn btn-warning">Enviar</button></center>
            </div>
        </div>
      </div>
      </form>
      </div>
    </div>
  </div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/External/Driver/updateDocs.js')}}"></script>
</body>
</html>
