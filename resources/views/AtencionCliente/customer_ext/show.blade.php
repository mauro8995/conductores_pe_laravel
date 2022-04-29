<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ver ticket | WIN</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS FRAMEWORK -->
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/skins/_all-skins.min.css') }}">
    <!-- ICONS -->
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <link href="{{  asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
    <!-- JS -->
    <style>
          a.nounderline:link {text-decoration: none;}
     </style>
  </head>
  <body>

<div id="LoginForm" style="color:black;-webkit-text-stroke: 0.1px black; ">
  <div class="container" >
      <h1 class=""></h1>
      <div class=""  >
        <div class="">
				      <section id="" class="cf">
                <section id="">
                  <section class="content">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title"><label>{{$subject}}</label></h3>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-9">
                        <div class="box box-primary">
                         <div class="box-header with-border">
                           <h3 class="box-title" style="font-size: 15px !important;">{{$tocreateNL}}<span> informado vía {{$canalgestion}} | Creado por {{$tocreateNL}}</span></h3>
                         </div>
                         <div class="box-body">
                           <div class="row">
                                <div class="col-md-12" >
                                  <!-- Box Comment -->
                                  <div class="box box-widget" style="border-color: #bbdcfe; background-image: linear-gradient(#e5f2fd,#e5f2fd); border-radius: 4px;">
                                    <div class="box-header with-border" style="border-bottom: 1px solid #bbdcfe !important;">
                                      <div class="user-block">
                                        <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                                        <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$tocreateNL}}</label> informado vía {{$canalgestion}}, hace {{$times}}</a></span>
                                            <span class="description"><b>cc:</b> {{$ccs}}</span>
                                      </div>
                                      <!-- /.user-block -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                                      <div style="font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; font-size:14px">
                                      <?php
                                        echo $desc;
                                      ?>

                                      </div>
                                    </div>
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col -->

                                @foreach ($convs as $conv)
                                <?php

                                  $datebys = new \DateTime();
                                  $fechaFinal1   = $datebys->format('d-m-Y H:i:s');
                                  $fechaInicial1 = $conv['created_at'];
                                  $seg = strtotime($fechaFinal1) - strtotime($fechaInicial1);

                                  $d = floor($seg / 86400);
                                  $h = floor(($seg - ($d * 86400)) / 3600);
                                  $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
                                  $s = $seg % 60;
                                  $timeres = '';
                                  if ($d > 0){
                                    $timeres = ($d == 1) ? $d." Día " : $d." Días ";
                                  }else if ($h > 0){
                                    $timeres = ($h == 1) ? $h." hora " : $h." horas ";
                                  }else if ($m > 0){
                                    $timeres = ($m == 1) ? $m." minuto " : $m." minutos ";
                                  }else{
                                    $timeres = ($s == 1) ? $s." segundo " : $s." segundos ";
                                  }
                                ?>
                                  <div class="col-md-12" >
                                    <!-- Box Comment -->
                                    <div class="box box-widget" style="border-color: #ebeff3; background-image: linear-gradient(#f5f7f9,#f5f7f9); border-radius: 4px;">
                                      <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important;">
                                        <div class="user-block">
                                          <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                                          <?php
                                          if ($conv->getCreatedBy->id > 1){
                                          ?>
                                          <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$conv->getCreatedBy->name.' '.$conv->getCreatedBy->lastname}}</label></a></span>
                                          <span class="description">Para: {{$ccs}} - Respondió, hace {{$timeres}}</span>
                                          <?php
                                          }else{
                                          ?>
                                          <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$name}}</label></a></span>
                                          <span class="description">Para: {{$toresp}} - Respondió, hace {{$timeres}}</span>
                                          <?php
                                          }
                                          ?>
                                        </div>
                                        <!-- /.user-block -->
                                      </div>
                                      <!-- /.box-header -->
                                      <div class="box-body">
                                        <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                                        <?php
                                          echo $conv['description'];
                                        ?>
                                      </div>
                                    </div>
                                    <!-- /.box -->
                                  </div>
                                  <!-- /.col -->
                                @endforeach
                                <div class="col-md-12" >
                                  <div class="box box-widget">
                                    <div class="box-header with-border">
                                      <button class="btn btn-primary" id="respdiv" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-mail-reply"></i> Responder</button>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-12" id="answerticket">
                                  <!-- Box Comment -->
                                  <div class="box box-widget" style="border-color: #ebeff3; border-radius: 4px;">
                                    <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important; background-image: linear-gradient(#f5f7f9,#f5f7f9);">
                                      <div class="user-block">
                                        <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                                        <span class="username"><a href="#">De <label>{{$name}}</label></a></span>
                                        <span class="description" id="tic" data-id="{{$idregt}}">Para: <label>{{$toresp}}</label></span>
                                      </div>
                                      <!-- /.user-block -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="background-image: linear-gradient(#fff,#fff);">
                                      <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                                      <div style="font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; font-size:14px">
                                        <meta name = "csrf-token" content = "{{csrf_token ()}}" />
                                        <form action="#" id="myform" method="post">

                                          <!-- .img-push is used to add margin to elements next to floating images -->
                                          <div class="img-push">

                                            <textarea class="form-control" id="editor" name="editor" rows="10" cols="80" style="font-size: 14px !important;"></textarea>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                    <!-- /.box-footer -->
                                    <div class="box-footer">
                                      <form method="post">
                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                        <div class="img-push">
                                          <button type="button" class="btn btn-primary" id="enviarresp" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-trash"></i> Enviar</button>
                                          <button type="button" class="btn btn-primary" id="respdelete" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-trash"></i></button>
                                        </div>
                                      </form>
                                    </div>
                                    <!-- /.box-footer -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col -->
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title"><label>Propiedades</label></h3>
                          </div>
                          <div class="box-body">
                                <div class="row">
                                  <label class="col-md-12" for="pwd">Estado:</label>
                                  <div class="col-md-12">
                                    <label><b>{{ $status }}</b></label>
                                  </div>
                                </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </section>
              </section>
              <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
                <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
                  <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
                </div>
              </div>
      </div>
  </div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('js/AtencionCliente/listindex.js')}} "></script>
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor');
</script>
</body>
</html>
