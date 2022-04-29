<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
	
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema interno de personal administrativo de WIN TECNOLOGIES INC S.A."/>
        <meta name="author" content="Diseño: Susana Piñero. Desarrollo: Mauro Gomez, Brenda Atto, Gloribel Delgado, Victor Pérez." />
        <title>WIN RIDESHARE</title>
        <link href="{{ asset('css/style-sb-ui-pro.css') }}" rel="stylesheet" />
        <link rel="icon" href="{{ asset('imagenes/favicon.png') }}">
        <!-- FUENTES Oficiales -->
        <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
        <!-- Iserta css personalizado de cada vista -->
        @yield('css')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        <!-- FUENTES Oficiales -->
        <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
        <!-- CSS del tema personalizado -->
        <link href="{{ asset('css/style-index.css') }}" rel="stylesheet" />
        <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
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
    </head>
    <!-- Integrción de HubSpot -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/6883387.js"></script>
    <!-- FIN Integrción de HubSpot -->
    <body>
        <div id="layoutDefault">
            <div id="layoutDefault_content">
