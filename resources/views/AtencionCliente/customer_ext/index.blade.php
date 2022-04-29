<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Listado de tickets | WIN</title>
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

    <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
    <!-- JS -->
    <style>
          a.nounderline:link {text-decoration: none;}
     </style>
  </head>
  <body>

<div id="LoginForm" style="color:black;-webkit-text-stroke: 0.1px black; ">
  <div class="container" >
      <h1 class="form-heading"></h1>
      <div class="login-form"  >
        <div class="">
				      <section id="global-content" class="cf">
                <section id="main-content">
                  <div class="box-body">
                    <div class="hero-callout">
                      <table id="servicedesk"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th >Fecha</th>
                              <th >N° Ticket</th>
                              <th >Asunto</th>
                              <th >Estado</th>
                              <th >Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($registerat as $registerat)
                              <tr>
                                  <td>{{ $registerat->created_at }}</td>
                                  <td>{{ $registerat->nro_ticket }}</td>
                                  <td>{{ $registerat->subject }}</td>
                                  <td>{{ $registerat->getStatusT->description }}</td>
                                  <td>
                                      <a href="/servicedesk/details/7S2Cb$SBJF]BW]r]/{{$registerat->id}}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                  </td>
                              </tr>
                          @endforeach
                        </tbody>
                  </table>
                     </div>
                   </div>

                 </div>
                </section>
              </section>
      </div>
  </div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
  $('#servicedesk').DataTable({});
</script>
</body>
</html>
