@extends('layout-backend')
@section('title', 'Service Desk - Agente')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

  <link href="{{ asset('dist/css/smart_wizard.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('dist/css/smart_wizard_theme_arrows.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('dist/css/smart_wizard_theme_dots.css') }}" rel="stylesheet" type="text/css" />
  <script src="http://code.responsivevoice.org/responsivevoice.js"></script>
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <style>
    .efecto-bajo-div {
      position: relative;
      background: #fcbe00;
      border: 2px solid #000000;
      width: 25%;
      padding: 20px 20px;
      margin-left: 30%;
      text-align: center;
      color: white;
      font-weight: bold;
      font-size: 20px;
    }

    .efecto-div{
      position: relative;
      background: white;
      border: 2px solid #000000;
      width: 30%;
      padding: 20px 20px;
      text-align: center;
      color: black;
      font-size: 20px;
    }

    .efecto-bajo-div:after, .efecto-bajo-div:before {
      top: 100%;
      left: 55%;
      border: solid transparent;
      content: " ";
      height: 0;
      width: 0;
      position: absolute;
      pointer-events: none;
    }

    .efecto-bajo-div:after {
      border-top-color: #fcbe00;
      border-width: 18px;
      margin-left: -30px;
    }
    .efecto-bajo-div:before {
      border-top-color: #000000;
      border-width: 24px;
      margin-left: -36px;
    }

    .switch input {
      display: none;
    }

    .switch {
      display: inline-block;
      width: 60px; /*=w*/
      height: 30px; /*=h*/
      margin: 8px;
      transform: translateY(50%);
      position: relative;
    }

    .slider {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      border-radius: 30px;
      box-shadow: 0 0 0 2px #777, 0 0 4px #777;
      cursor: pointer;
      border: 4px solid transparent;
      overflow: hidden;
      transition: 0.4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background-color: #777;
      border-radius: 30px;
      transform: translateX(-30px); /*translateX(-(w-h))*/
      transition: 0.4s;
    }

    input:checked + .slider:before {
      transform: translateX(30px); /*translateX(w-h)*/
      background-color: limeGreen;
    }

    input:checked + .slider {
      box-shadow: 0 0 0 2px limeGreen, 0 0 8px limeGreen;
    }

    .switch200 .slider:before {
      width: 200%;
      transform: translateX(-82px); /*translateX(-(w-h))*/
    }

    .switch200 input:checked + .slider:before {
      background-color: red;
    }

    .switch200 input:checked + .slider {
      box-shadow: 0 0 0 2px red, 0 0 8px red;
    }

    .timeline,
.timeline-horizontal {
  list-style: none;
  padding: 20px;
  position: relative;
}
.timeline:before {
  top: 40px;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #fcbe00;
  left: 50%;
  margin-left: -1.5px;
}
.timeline .timeline-item {
  margin-bottom: 20px;
  position: relative;
}
.timeline .timeline-item:before,
.timeline .timeline-item:after {
  content: "";
  display: table;
}
.timeline .timeline-item:after {
  clear: both;
}
.timeline .timeline-item .timeline-badge {
  color: #08426a;
  width: 54px;
  height: 54px;
  line-height: 52px;
  font-size: 22px;
  text-align: center;
  position: absolute;
  top: 18px;
  left: 50%;
  margin-left: -25px;
  background-color: #fcbe00;
  border: 3px solid #fcbe00;
  z-index: 100;
  border-top-right-radius: 20%;
  border-top-left-radius: 20%;
  border-bottom-right-radius: 20%;
  border-bottom-left-radius: 20%;
}
.timeline .timeline-item .timeline-badge i,
.timeline .timeline-item .timeline-badge .fa,
.timeline .timeline-item .timeline-badge .glyphicon {
  top: 2px;
  left: 0px;
}
.timeline .timeline-item .timeline-badge.primary {
  background-color: #1f9eba;
}
.timeline .timeline-item .timeline-badge.info {
  background-color: #5bc0de;
}
.timeline .timeline-item .timeline-badge.success {
  background-color: #59ba1f;
}
.timeline .timeline-item .timeline-badge.warning {
  background-color: #fcbe00;
}
.timeline .timeline-item .timeline-badge.danger {
  background-color: #ba1f1f;
}
.timeline .timeline-item .timeline-panel {
  position: relative;
  width: 46%;
  float: left;
  right: 16px;
  border: 1px solid #08426a;
  background: none;
  color: #08426a;
  border-radius: 2px;
  padding: 5px;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline .timeline-item .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -16px;
  display: inline-block;
  border-top: 16px solid transparent;
  border-left: 16px solid #08426a;
  border-right: 0 solid #08426a;
  border-bottom: 16px solid transparent;
  content: " ";
}
.timeline .timeline-item .timeline-panel .timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline .timeline-item .timeline-panel .timeline-body > p,
.timeline .timeline-item .timeline-panel .timeline-body > ul {
  margin-bottom: 0;
}
.timeline .timeline-item .timeline-panel .timeline-body > p + p {
  margin-top: 5px;
}
.timeline .timeline-item:last-child:nth-child(even) {
  float: right;
}
.timeline .timeline-item:nth-child(even) .timeline-panel {
  float: right;
  left: 16px;
}
.timeline .timeline-item:nth-child(even) .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-horizontal {
  list-style: none;
  position: relative;
  padding: 20px 0px 20px 0px;
  display: inline-block;
}
.timeline-horizontal:before {
  height: 3px;
  top: auto;
  bottom: 26px;
  left: 56px;
  right: 0;
  width: 100%;
  margin-bottom: 20px;
}
.timeline-horizontal .timeline-item {
  display: table-cell;
  height: 190px;
  width: 10%;
  min-width: 160px;
  float: none !important;
  padding-left: 0px;
  padding-right: 10px;
  margin: 0 auto;
  vertical-align: bottom;
}
.timeline-horizontal .timeline-item .timeline-panel {
  top: auto;
  bottom: 64px;
  display: inline-block;
  float: none !important;
  left: 0 !important;
  right: 0 !important;
  width: 80%;
  margin-bottom: 10px;
}
.timeline-horizontal .timeline-item .timeline-panel:before {
  top: auto;
  bottom: -16px;
  left: 28px !important;
  right: auto;
  border-right: 16px solid transparent !important;
  border-top: 16px solid #08426a !important;
  border-bottom: 0 solid #08426a !important;
  border-left: 16px solid transparent !important;
}
.timeline-horizontal .timeline-item:before,
.timeline-horizontal .timeline-item:after {
  display: none;
}
.timeline-horizontal .timeline-item .timeline-badge {
  top: auto;
  bottom: 0px;
  left: 43px;
}

#timelineul {
  background: rgba(8, 66, 106,0.8) !important;
  color: #9e9e9e !important;
  font-size: 25px !important;
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (max-width: 1366px) {
  #timelineul {
    font-size: 13px !important;
  }

  #imgul{
    width: 40px;
  }
}

  </style>
@endsection

@section('content')
<section class="content-header"></section>
<?php
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo.png?alt=media&token=c0d567df-b26c-43da-bf84-4ff4ab866889");
        $base64 = 'data:image/png;base64,' . base64_encode($data);
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary" style="margin-bottom: 0px !important; background: #08426a; border-top: 0px !important;">
        <div class="box-header with-border" style="color: white !important;">
          <center><h2 class="box-title">Sistema de gestion de atencion</h2></center>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-primary" style="background: #e6e6e6;">
        <div class="box-header with-border" style="display: flex;">
          <div class="efecto-bajo-div">{{'Modulo '.$user->nro_modulo}}</div><div class="efecto-div">{{$user->lastname.' '.$user->name}}</div>
        </div>
      </div>
      <div class="box-body" style="background: #e6e6e6;">
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul id="timelineul">
                <li><a href="#step-1"><img id="imgul" src="{{$base64}}" alt="logo" width="80"></a></li>
                <li><a href="#step-1">Visualizacion de turno</a></li>
                <li><a href="#step-2">2 Portal de atencion</a></li>
                <li><a href="#step-3">3 Registro de clientes</a></li>
                <li><a href="#step-4">4 Reportes</a></li>
            </ul>
            <div style="border: 15px;">
                <div id="step-1" class="">
                  <iframe width="100%" height="600" src="http://127.0.0.1:8000/atencion/viewatencions" frameborder="0" style="border:0;" allowfullscreen="">
                  </iframe>
                </div>
                <div id="step-2" class="">
                  <table id="servicedesk"  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th >Cliente/Usuario</th>
                          <th >Tipo Cliente</th>
                          <th >Tipo de Gestion</th>
                          <th >Codigo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="thead-dark">
                      <tr>
                        <th >Cliente/Usuario</th>
                        <th >Tipo Cliente</th>
                        <th >Tipo de Gestion</th>
                        <th >Codigo</th>
                      </tr>
                    </tfoot>
                </table>
            </div>
            <div id="step-3" class="">
              <table id="registerserviced"  class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th >Cliente/Usuario</th>
                      <th >Tipo Cliente</th>
                      <th >Tipo de Gestion</th>
                      <th >Estado</th>
                      <th >Codigo</th>
                      <th >Fecha</th>
                      <th >Detalles</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="thead-dark">
                  <tr>
                    <th >Cliente/Usuario</th>
                    <th >Tipo Cliente</th>
                    <th >Tipo de Gestion</th>
                    <th >Estado</th>
                    <th >Codigo</th>
                    <th >Fecha</th>
                    <th >Detalles</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div id="step-4" class=""><h2>Step 4</h2></div>
            </div>
        </div>

      </div>
    </div>
    <div class="col-md-3">
      <div class="box box-primary" style="background: #e6e6e6;">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-xs-6 col-md-12">
              <center><h1 style="color: #08426a;">Estado: </h1></center>
            </div>
            <div class="col-xs-6 col-md-12">
              <div>
                <label class="switch">
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <input type="checkbox" id="availability" name="availability" {{$checked}}>
                  <span class="slider"></span>
                </label>
              </div>
            </div>
         </div>
        </div>
      </div>
        <div class="box-body" style="background: #e6e6e6; padding: 15px;">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <div class="col-sm-12">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-search"></i></div>
                    {!! Form::text('num_ticket', null,['id'=>'num_ticket', 'class'=>'form-control', 'style'=>'width: 100%','placeholder'=> 'Buscar cliente...'] ) !!}
                    </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <center><label style="border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 10px; width: 150px; background: #9e9e9e; color: black; text-align: center;">Area</label><label style="border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 10px; width: 150px; background: #fcbe00; color: black; text-align: center;">Atencion al Publico</label></center>
            </div>
            <div class="col-xs-12" style="padding: 15px;">
              <table id="modatention"  class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th >MODULO</th>
                      <th >CLIENTE</th>
                      <th >VER</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="thead-dark">
                  <tr>
                    <th >MODULO</th>
                    <th >CLIENTE</th>
                    <th >VER</th>
                  </tr>
                </tfoot>
            </table>
            </div>
          </div>
          <div class="col-xs-6 col-md-12" style="padding: 15px;">
            <button type="button" class="btn btn-info pull-left callatention" style="background: rgba(252, 190, 0,0.2) !important; color: #08426a !important; font-size: 18px;"><i class="fa fa-phone"></i> Llamar</button>
          </div>
          <div class="col-xs-6 col-md-12" style="padding: 15px;">
            <button type="button" class="pull-right nextatention" style="font-weight: bold; background: #0d436b; padding-left: 20px;  padding-right: 20px; font-size: 18px; font-weight: 400;color: white !important; border: 3px solid #fcbe00; border-radius: 15px;">Siguiente</button>
          </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="background: #ecf0f5 !important;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="modal-content" style="background: #ecf0f5 !important;">
          <div class="row">
            <div class="col-xs-9">
              <div class="sw-main sw-theme-arrows" style="border: 0px !important;">
                <ul class="nav nav-tabs step-anchor" style="background: #ecf0f5 !important; color: #08426a !important; font-size: 25px !important;">
                    <li class="nav-item detailss"><a style="background: rgba(8, 66, 106,0.8) !important; color: #fcbe00 !important;" href="#" class="nav-link codetic"></a></li>
                    <li class="nav-item detailssdone"><a style="background: #e6e6e6 !important; color: #08426a !important;" href="#" class="nav-link typegest"></a></li>
                </ul>
              </div>
            </div>
            <div class="col-xs-3"  style="padding: 15px; color: #08426a !important; font-size: 25px !important;">
              <label id="dateatencion"></label>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4" for="pwd">Nombre Completo:</label>
            <div class="col-md-8">
              <label class="form-control" id="namecompleteview" style="width: 80%;"></label>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4" for="pwd">Tipo de documento:</label>
            <div class="col-md-8">
              <label class="form-control" id="typedocument" style="width: 80%;"></label>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4" for="pwd">Numero de documento:</label>
            <div class="col-md-8">
              <label class="form-control" id="numberdocs" style="width: 80%;"></label>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4" for="pwd">Tipo de gestión:</label>
            <div class="col-md-8">
              <label class="form-control" id="typegestions" style="width: 80%;"></label>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 fa fa-pencil-square-o" for="pwd">Añadir Nota</label>
            <div class="col-md-8">
              <textarea class="form-control" style="width: 80%;"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-4">
            <center><button type="button" class="btn btn-danger" style="background: none !important; font-size: 20px;" data-dismiss="modal"><i style="color: #d9534f !important;" class="fa  fa-mail-reply"></i> REGRESAR</button></center>
          </div>
          <div class="col-md-4">
            <center><button type="button" class="btn btn-danger fa fa-plus-circle createdTK" style="background: none !important; border: 0; padding: 0px; margin: 0px; font-size: 50px; color: #fcbe00 !important;"></button></center>
            <center><label>CREAR TICKET</label></center>
          </div>
          <div class="col-md-4">
            <center><button type="button" class="btn btn-danger updateStatus" style="background: none !important; font-size: 20px;"><i style="color: #629c44 !important;" class="fa fa-check-square"></i> ATENDIDO</button></center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-view-regs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="background: #ecf0f5 !important;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="modal-content" style="background: #ecf0f5 !important;">
          <div class="row">
            <div class="col-xs-9">
              <div class="sw-main sw-theme-arrows" style="border: 0px !important;">
                <ul class="nav nav-tabs step-anchor" style="background: #ecf0f5 !important; color: #08426a !important; font-size: 25px !important;">
                    <li class="nav-item detailss"><a style="background: rgba(8, 66, 106,0.8) !important; color: #fcbe00 !important;" href="#" class="nav-link codeticr">A2241</a></li>
                    <li class="nav-item detailssdone"><a style="background: #e6e6e6 !important; color: #08426a !important;" href="#" class="nav-link typecustr">ACCIONISTA</a></li>
                </ul>
              </div>
            </div>
            <div class="col-xs-3"  style="padding: 15px; color: #08426a !important; font-size: 25px !important;">
              <label id="dateatencionr"></label>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <h2>DATOS CLIENTE:</h2>
              <div class="row">
                <label class="col-md-4" for="pwd">Nombres:</label>
                <div class="col-md-8">
                  <label class="form-control" id="namer" style="width: 100%;"></label>
                </div>
              </div>
              <div class="row">
                <label class="col-md-4" for="pwd">Apellidos:</label>
                <div class="col-md-8">
                  <label class="form-control" id="lastnamer" style="width: 100%;"></label>
                </div>
              </div>
              <div class="row">
                <label class="col-md-4" for="pwd">Tipo de documento:</label>
                <div class="col-md-8">
                  <label class="form-control" id="typedocumentr" style="width: 100%;"></label>
                </div>
              </div>
              <div class="row">
                <label class="col-md-4" for="pwd">Numero de documento:</label>
                <div class="col-md-8">
                  <label class="form-control" id="numberdocr" style="width: 100%;"></label>
                </div>
              </div>
              <div class="row">
                <label class="col-md-4" for="pwd">Correo:</label>
                <div class="col-md-8">
                  <label class="form-control" id="correor" style="width: 100%;"></label>
                </div>
              </div>
              <div class="row">
                <label class="col-md-4" for="pwd">Telefono:</label>
                <div class="col-md-8">
                  <label class="form-control" id="telephoner" style="width: 100%;"></label>
                </div>
              </div>
          </div>
          <div class="col-xs-6">
            <h2>DATOS ATENCIÓN:</h2>
            <div class="row">
              <label class="col-md-4" for="pwd">Agente:</label>
              <div class="col-md-8">
                <label class="form-control" id="Agentr" style="width: 80%;"></label>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4" for="pwd">Modulo:</label>
              <div class="col-md-8">
                <label class="form-control" id="moduler" style="width: 80%;"></label>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4" for="pwd">Tipo de gestión:</label>
              <div class="col-md-8">
                <label class="form-control" id="typegestionr" style="width: 80%;"></label>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4" for="pwd">N° ticket de gestion:</label>
              <div class="col-md-8">
                <label class="form-control" id="tgestionr" style="width: 80%;"></label>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4" for="pwd">Area de gestion:</label>
              <div class="col-md-8">
                <label class="form-control" id="areagestionr" style="width: 80%;"></label>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4 fa fa-pencil-square-o" for="pwd">Añadir Nota</label>
              <div class="col-md-8">
                <textarea class="form-control" name="noter" id="noter" style="width: 80%;"></textarea>
              </div>
            </div>
          </div>
          <div class="col-xs-12">
					<div style="display:inline-block;width:100%;overflow-y:auto;">
					<ul class="timeline timeline-horizontal" id="timelineid" style="margin: 10px;">
					</ul>
          </div>
          </div>
        </div>
      </div>
    </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-6">
            <button type="button" class="btn btn-danger" style="background: none !important; font-size: 20px; float: left;" data-dismiss="modal"><i style="color: #d9534f !important;" class="fa  fa-mail-reply"></i> REGRESAR</button>
          </div>
          <div class="col-md-6" id="statert">

          </div>
        </div>
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

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="{{ asset('dist/js/jquery.smartWizard.min.js') }}"></script>
<script type="text/javascript">
        $(document).ready(function(){
            // Smart Wizard
            $('#smartwizard').smartWizard({
                    selected: 2,
                    theme: 'arrows',
                    transitionEffect:'fade',
                    toolbarSettings: {toolbarPosition: 'bottom'}
            });
        });
    </script>

<script src="{{ asset('js/AtencionCliente/indexbackend.js') }}"></script>
@endsection
