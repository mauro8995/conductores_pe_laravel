<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registrar Pasajeros</title>
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
  <script src="http://code.jquery.com/jquery-1.12.1.js"></script>
  <script src="http://code.responsivevoice.org/responsivevoice.js"></script>
  <?php
      $data2 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2FWhatsApp%20Image%202020-02-27%20at%203.33.23%20PM.jpeg?alt=media&token=46ebf26e-96aa-47dd-903e-690aa5101a41");
      $base642 = 'data:image/png;base64,' . base64_encode($data2);
  ?>
  <style>
    .zoom{
      animation-name: parpadeo;
      animation-duration: 5s;
      animation-timing-function: linear;
      animation-iteration-count: infinite;

      -webkit-animation-name:parpadeo;
      -webkit-animation-duration: 6s;
      -webkit-animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
    }

    .zoomt {
      animation-name: parpadeo;
      animation-duration: 5s;
      animation-timing-function: linear;
      animation-iteration-count: infinite;

      -webkit-animation-name:parpadeo;
      -webkit-animation-duration: 6s;
      -webkit-animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
    }

    .zoom:before {
        content: " ";
        display: block;
        width: 0;
        height: 0;
        border-top: 92px solid transparent;
               /* Go big on the size, and let overflow hide */
        border-bottom: 92px solid transparent;
        border-left: 80px dashed #ffe23c;
        position: absolute;
        top: 24.5%;
        margin-top: -50px;
        margin-left: 1px;
        left: 100%;
        z-index: 1;
    }

    .zoom:after{
      content: " ";
      display: block;
      width: 0;
      height: 0;
      border-top: 80px solid transparent;
      border-bottom: 80px solid transparent;
      border-left: 75px solid #fcbe00;
      position: absolute;
      top: 33%;
      margin-top: -50px;
      left: 100%;
      z-index: 2;
    }

    @-moz-keyframes parpadeo{
    0% {
      -webkit-transform:scale(1.15);
      -moz-transform:scale(1.15);
      -ms-transform:scale(1.15);
      -o-transform:scale(1.15);
      transform:scale(1.15);
    }
    50% { -webkit-transform:scale(1);
    -moz-transform:scale(1);
    -ms-transform:scale(1);
    -o-transform:scale(1);
    transform:scale(1); }
    100% { -webkit-transform:scale(1.15);
    -moz-transform:scale(1.15);
    -ms-transform:scale(1.15);
    -o-transform:scale(1.15);
    transform:scale(1.15);}
    }

    @-webkit-keyframes parpadeo {
      0% {
        -webkit-transform:scale(1.15);
        -moz-transform:scale(1.15);
        -ms-transform:scale(1.15);
        -o-transform:scale(1.15);
        transform:scale(1.15);
      }
      50% { -webkit-transform:scale(1);
      -moz-transform:scale(1);
      -ms-transform:scale(1);
      -o-transform:scale(1);
      transform:scale(1); }
      100% { -webkit-transform:scale(1.15);
      -moz-transform:scale(1.15);
      -ms-transform:scale(1.15);
      -o-transform:scale(1.15);
      transform:scale(1.15);}
    }

    @keyframes parpadeo {
      0% {
        -webkit-transform:scale(1.15);
        -moz-transform:scale(1.15);
        -ms-transform:scale(1.15);
        -o-transform:scale(1.15);
        transform:scale(1.15);
      }
      50% { -webkit-transform:scale(1);
      -moz-transform:scale(1);
      -ms-transform:scale(1);
      -o-transform:scale(1);
      transform:scale(1); }
      100% { -webkit-transform:scale(1.15);
      -moz-transform:scale(1.15);
      -ms-transform:scale(1.15);
      -o-transform:scale(1.15);
      transform:scale(1.15);}
    }

    body{
      background-image:  url('{{$base642}}');
    }


    .modatentioncss{
      text-align: center;
      padding:25px;
      margin: 30px;
      background: #08426a;
      font-size: 80px;
      color: #e6e6e6 !important;
      border-top-left-radius: 45px;
      border-top-right-radius: 45px;
      border: 4px solid #e6e6e6;
    }

    .modatentionfinan{
      font-family: 'Quicksand', sans-serif;
      text-align: center;
      padding:25px;
      margin: 50px;
      width: 780px;
      background: #ffe22b;
      font-size: 100px;
      color: black !important;
      border-top-left-radius: 45px;
      border-top-right-radius: 45px;
      font-weight:bold;
      border: 4px solid black;
    }

    .modatentionadmin{
      font-family: 'Quicksand', sans-serif;
      text-align: center;
      padding:25px;
      margin-left: 50px;
      margin-right: 0px;
      margin-top: 50px;
      margin-bottom: 50px;
      background: #ffe22b;
      font-size: 100px;
      color: black !important;
      border-top-left-radius: 45px;
      border-top-right-radius: 45px;
      font-weight: bold;
      border: 4px solid black;
    }

    .atentionsopen{
      width: 750px;
      text-align: center;
      padding:10px;
      margin-top: 20px;
      font-size: 60px;
      color: black !important;
      border-radius: 55px;
      background: #e0e0e0;
    }

    .atentionsopenactive {
      width: 750px;
      text-align: center;
      padding:10px;
      margin-top: 20px;
      font-size: 60px;
      color: black !important;
      border-radius: 55px;
      background: #fcbe00;
    }

    .atentionspends{
      text-align: center;
      width: 720px;
      padding:10px;
      margin: 0px;
      background: #08426a;
      font-size: 60px;
      color: #fcbe00 !important;
      border-top: 4px solid #fcbe00;
      border-left: 4px solid #fcbe00;
      border-right: 4px solid #fcbe00;
    }

    .atentionpendmods {
      text-align: center;
      width: 750px;
      padding:10px;
      margin: 0px;
      background: #08426a;
      font-size: 95px;
      color: #e6e6e6 !important;
      border-bottom:  4px solid #fcbe00;
      border-left: 4px solid #fcbe00;
      border-right: 4px solid #fcbe00;
    }

    .atentionsfinancssblock{
      text-align: left;
      padding:25px;
      margin: 30px 0px 0px 0px;
      width: 780px;
      background: #0d436b;
      font-size: 70px;
      color: #fcbe00 !important;
      border: 6px dashed #ffe23c;
    }

    .atentionsfinancss{
      text-align: left;
      padding:25px;
      margin: 0px;
      width: 790px;
      background: rgba(255,255,255,0.5);
      font-size: 80px;
      color: black !important;
      border: 6px dashed #ffe23c;
    }

    .atentionsfinancssactive{
      z-index: 1;
      text-align: left;
      padding:25px;
      margin: 30px 0px 0px 0px;
      width: 800px;
      background: #fcbe00;
      font-size: 80px;
      color: white !important;
      border: 6px dashed #ffe23c;
    }

    .atentionsadmincss{
      text-align: left;
      padding:25px;
      margin: 0px 0px 0px 0px;
      width: 880px;
      background: rgba(255,255,255,0.5);
      font-size: 80px;
      color: black !important;
      border: 6px dashed #ffe23c;
    }

    .atentionsadmincssblock{
      text-align: left;
      padding:25px;
      margin: 0px 0px 0px 0px;
      width: 880px;
      background: #0d436b;
      font-size: 80px;
      color: #fcbe00 !important;
      border: 6px dashed #ffe23c;
    }


    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (max-width: 1366px) {
      .modatentioncss{
        font-size: 15px !important;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding:5px;
        margin: 10px;
      }

      .modatentionfinan{
        width: auto;
        font-size: 20px;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding:5px;
        margin: 10px;
      }

      .modatentionadmin {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        width: auto;
        font-size: 15px;
        padding:5px;
        margin: 10px;
      }

      .atentionsopen{
        width: auto;
        font-size: 15px;
      }

      .atentionsopenactive {
        width: auto;
        font-size: 15px;
      }

      .atentionspends{
        font-size: 12px;
        padding:2px;
      }

      .atentionpendmods {
        font-size: 25px;
      }

      .atentionsfinancss{
        width: auto;
        font-size: 15px;
        border: 2px dashed #ffe23c;
        padding:12px;
      }

      .atentionsfinancssblock{
        width: auto;
        font-size: 13px;
        border: 2px dashed #ffe23c;
        padding:12px;
      }

      .atentionsfinancssactive{
        width: auto;
        font-size: 15px;
        border: 2px dashed #ffe23c;
      }

      .zoom:before {
          border-top: 47px solid transparent;
                 /* Go big on the size, and let overflow hide */
          border-bottom: 47px solid transparent;
          border-left: 50px dashed #ffe23c;
          top: 54%;
      }

      .zoom:after{
        border-top: 42px solid transparent;
        border-bottom: 42px solid transparent;
        border-left: 45px solid #fcbe00;
        top: 60%;
      }

      .atentionsadmincss{
        font-size: 20px;
        border: 2px dashed #ffe23c;
        padding:12px;
      }

      .atentionsadmincssblock{
        font-size: 17px;
        border: 2px dashed #ffe23c;
        padding:12px;
      }

      .videocssbod{
        height: 260px;
      }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1367px) and (max-width: 2000px){
      .modatentioncss{
        font-size: 30px;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
      }

      .modatentionfinan{
        width: auto;
        font-size: 40px;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
      }

      .modatentionadmin {
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        width: auto;
        font-size: 40px;
      }

      .atentionsopen{
        width: auto;
        font-size: 40px;
      }

      .atentionsopenactive {
        width: auto;
        font-size: 40px;
      }

      .atentionspends{
        font-size: 25px;
        padding:2px;
      }

      .atentionpendmods {
        font-size: 40px;
      }

      .atentionsfinancss{
        border: 3px dashed #ffe23c;
        font-size: 40px;
      }

      .atentionsfinancssblock{
        font-size: 35px;
        border: 3px dashed #ffe23c;
      }

      .atentionsfinancssactive{
        font-size: 35px;
        border: 3px dashed #ffe23c;
      }

      .zoom:before {
          border-top: 60px solid transparent;
                 /* Go big on the size, and let overflow hide */
          border-bottom: 60px solid transparent;
          border-left: 50px dashed #ffe23c;
          top: 40%;
      }

      .zoom:after{
        border-top: 50px solid transparent;
        border-bottom: 50px solid transparent;
        border-left: 45px solid #fcbe00;
        top: 48%;
      }

      .atentionsadmincss{
        border: 3px dashed #ffe23c;
        font-size: 40px;
      }

      .atentionsadmincssblock{
        border: 3px dashed #ffe23c;
        font-size: 40px;
      }

    }

  </style>
</head>
<body style="background-repeat: no-repeat, repeat; background-size: cover; font-family: 'Quicksand', sans-serif;">
  <audio src="" hidden class=speech></audio>
  <section class="content">
    <div class="row" >
      <div class="col-xs-3" style="z-index: 1;">
        <center><h1 class="modatentionfinan" style="">FINANZAS</h1></center>
        <div id="divfinanzasTK">
        </div>
      </div>
      <div class="col-xs-6" style="border-left: 5px solid #fcbe00; border-right: 5px solid #fcbe00;">
        <div class="row" style="border-bottom: 5px solid #fcbe00">
          <iframe class="videocssbod" width="100%" height="420"  src="https://www.youtube.com/embed/lAX5K_n6fk4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="row">
          <div class="row">
            <center><label class="modatentioncss" >MODULO DE ATENCION</label></center>
          </div>
          <div class="row" id="atencionspends">
          </div>
          <div class="row" id="atencionsopens">
          </div>
        </div>
      </div>
      <div class="col-xs-3" style="z-index: 1;">
        <center><h1 class="modatentionadmin">ADMINISTRACION</h1></center>
        <div id="divadministracionTK">
        </div>
      </div>
    </div>
  </section>


<!-- /.register-box -->
<!-- jQuery 3 -->
<!-- <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script> -->
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
<script src="{{ asset('js/push/bin/push.min.js') }}"></script>
<script src="{{ asset('js/AtencionCliente/viewatencions.js')}}"></script>
</body>
</html>
