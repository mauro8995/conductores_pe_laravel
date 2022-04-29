

<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <style>
* {
  font-size: 11px;
  font-family: 'Times New Roman';
}
.header
{
width: 100%;
height: 100px;
}
.footer
{
width: 100%;
height: 50px;
 display: flex;
}
.hoja
{
width: 100%;
height: 932px;
}
.contenedor
{
    width: 100%;
    height: 100%;

}
.auxiliar
{
  width: 100%;
  height: 742px;
  padding: 15px;
  	margin: 0;
  	background-color: #fff;

}

.page-break {
page-break-after: always;
}

table {
   width: 100%;
   border: 1px solid #000;
}
th, td {
   width: 25%;
   text-align: left;
   vertical-align: top;
   border: 1px solid #000;
   border-collapse: collapse;
}


   </style>
</head>
<body>

          {{-- <div style="position: absolute; color: rgba(0, 0, 0, 0.3); z-index: -1; font-size: 75px; -webkit-transform: rotate(-65deg); -ms-transform: rotate(-65deg);      /* to support IE 9 */ transform: rotate(-65deg); top: 250px; left: -10px;letter-spacing: 0.3em"> WIN RIDESHARE</div> --}}
          <?php

                  $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
                  $base64 = 'data:image/png;base64,' . base64_encode($data);

//----------------------------------------------------------
                  $dataImg1 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fusuario.png?alt=media&token=90912901-d17d-498f-83d8-6151cbc6ca27");
                  $img1 = 'data:image/png;base64,' . base64_encode($dataImg1);
//----------------------------------------------------------
          ?>

    <div class="hoja">

      <div class="header">
      <img src="{{$base64}}" alt="logo">
      </div>

      <div class=".contenedor">
        <div class="auxiliar">
            <table class="table table-sm">
                <tbody>
                  <tr>
                    <td colspan="3">FECHA: {{$fecha}}</span></td>
                  </tr>
                  <tr>
                    <td colspan="3" >NOMBRE COMPLETO: <b>{{$first_name}} {{$last_name}}</b></td>
                  </tr>
                  <tr>
                    <td colspan="3">DNI: {{$dni}}</td>
                  </tr>
                  <tr>
                    <td><b>MARCA:</b> {{$marca}}</td>
                    <td ><b>MODELO:</b> {{$modelo}}</td>
                    <td ><b>PLACA:</b> {{$placa}}</td>
                  </tr>
                  <tr>
                    <td><b>AÑO:</b> {{$year}}</td>
                    <td><b>COLOR:</b> {{$color}}</td>
                    <td><b>KILOMETRAJE:</b></td>
                  </tr>
                  <tr>
                    <td><b>VIN#:</b> {{$nro_vin}}</td>
                    <td><b>MOTOR#:</b> {{$nro_motor}}</td>
                    <td><b>LICENCIA#</b> {{$licencia}}</td>
                  </tr>
                  <tr>
                    <td>DESCRIPCION</td>
                    <td colspan="2">VALOR</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>LUCES:</b></td>
                  </tr>
                  <tr>
                    <td><b>Luz Baja:</b></td>
                    <td colspan="2"> @if($luz_baja == 1) <p>Buen estado / Tiene</p>  @elseif($luz_baja == 2) <p>Reparacion</p> @elseif($luz_baja == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Luz Alta:</b></td>
                    <td colspan="2"> @if($luz_alta == 1) <p>Buen estado / Tiene</p>  @elseif($luz_alta == 2) <p>Reparacion</p> @elseif($luz_alta == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Luz de Freno:</b></td>
                    <td colspan="2"> @if($luz_freno == 1) <p>Buen estado / Tiene</p>  @elseif($luz_freno == 2) <p>Reparacion</p> @elseif($luz_freno == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Luz de Retroceso:</b></td>
                    <td colspan="2"> @if($luz_retroceso == 1) <p>Buen estado / Tiene</p>  @elseif($luz_retroceso == 2) <p>Reparacion</p> @elseif($luz_retroceso == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>Observacion: </b> @if($obser_luces == null) <p>No hay ninguna observacion</p> @else {{$obser_luce}} @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>CARROCERIA:</b></td>
                  </tr>
                  <tr>
                    <td><b>Puertas:</b></td>
                    <td colspan="2"> @if($puert_del_izq == 1) <p>Buen estado / Tiene</p>  @elseif($puert_del_izq == 2) <p>Reparacion</p> @elseif($puert_del_izq == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Lunas(vidrios):</b></td>
                    <td colspan="2"> @if($vid_del_izq == 1) <p>Buen estado / Tiene</p>  @elseif($vid_del_izq == 2) <p>Reparacion</p> @elseif($vid_del_izq == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Parabrisa:</b></td>
                    <td colspan="2"> @if($parab_del == 1) <p>Buen estado / Tiene</p>  @elseif($parab_del == 2) <p>Reparacion</p> @elseif($parab_del == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Capota:</b></td>
                    <td colspan="2"> @if($capota == 1) <p>Buen estado / Tiene</p>  @elseif($capota == 2) <p>Reparacion</p> @elseif($capota == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Maletero:</b></td>
                    <td colspan="2"> @if($maletero == 1) <p>Buen estado / Tiene</p>  @elseif($maletero == 2) <p>Reparacion</p> @elseif($maletero == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Llanta:</b></td>
                    <td colspan="2"> @if($est_neumaticos == 1) <p>Buen estado / Tiene</p>  @elseif($est_neumaticos == 2) <p>Reparacion</p> @elseif($est_neumaticos == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>Observación: </b> @if($obser_carroceria == null) <p>No hay ninguna observacion</p> @else {{$obser_carroceria}} @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>INTERIOR:</b></td>
                  </tr>
                  <tr>
                    <td><b>Asientos:</b></td>
                    <td colspan="2"> @if($asiento_piloto == 1) <p>Buen estado / Tiene</p>  @elseif($asiento_piloto == 2) <p>Reparacion</p> @elseif($asiento_piloto == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Luz de saloom:</b></td>
                    <td colspan="2"> @if($luz_saloom  == 1) <p>Buen estado / Tiene</p>  @elseif($luz_saloom  == 2) <p>Reparacion</p> @elseif($luz_saloom == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Bocina:</b></td>
                    <td colspan="2"> @if($claxon == 1) <p>Buen estado / Tiene</p>  @elseif($claxon == 2) <p>Reparacion</p> @elseif($claxon == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Cinturones de Seguridad:</b></td>
                    <td colspan="2"> @if($cinturon == 1) <p>Buen estado / Tiene</p>  @elseif($cinturon == 2) <p>Reparacion</p> @elseif($cinturon == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                    </tr>
                  <tr>
                    <td><b>Luz de tablero:</b></td>
                    <td colspan="2"> @if($luz_tablero == 1) <p>Buen estado / Tiene</p>  @elseif($luz_tablero == 2) <p>Reparacion</p> @elseif($luz_tablero == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>Observación: </b> @if($obser_interior == null) <p>No hay ninguna observacion</P> @else {{$obser_interior}} @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>HERRAMIENTAS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Estuche de herramientas:</b></td>
                    <td colspan="2"> @if($estuche_herra == 1) <p>Buen estado / Tiene</p>  @elseif($estuche_herra == 2) <p>Reparacion</p> @elseif($estuche_herra == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                    </tr>
                  <tr>
                    <td><b>Gata:</b></td>
                    <td colspan="2"> @if($gata == 1) <p>Buen estado / Tiene</p>  @elseif($gata == 2) <p>Reparacion</p> @elseif($gata == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p>  @endif</td>
                  </tr>
                  <tr>
                    <td><b>Extintor:</b></td>
                    <td colspan="2"> @if($extintor == 1) <p>Buen estado / Tiene</p>  @elseif($extintor == 2) <p>Reparacion</p> @elseif($extintor == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                    </tr>
                    <tr>
                      <td><b>Triangulo de seguridad:</b></td>
                      <td colspan="2"> @if($triangulo_seg == 1) <p>Buen estado / Tiene</p>  @elseif($triangulo_seg == 2) <p>Reparacion</p> @elseif($triangulo_seg == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                      </tr>
                  <tr>
                    <td><b>LLanta Extra:</b></td>
                    <td colspan="2"> @if($llanta_resp == 1) <p>Buen estado / Tiene</p>  @elseif($llanta_resp == 2) <p>Reparacion</p> @elseif($llanta_resp == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td><b>Botiquin de Primeros Auxilios:</b></td>
                    <td colspan="2"> @if($botiquin == 1) <p>Buen estado / Tiene</p>  @elseif($botiquin == 2) <p>Reparacion</p> @elseif($botiquin == 3) <p>Mal estado / No tiene </p> @else <p>Falta Colocar</p> @endif</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>Observación: </b> @if($obser_herramienta == null) <p>No hay ninguna observacion</p> @else {{$obser_herramienta}} @endif</td>
                  </tr>
                </tbody>
            </table>
        </div>
      </div>

      <div class="footer">
        <div class="cc" style=" float: right;">
            <h4>--</h4>
        </div>
      </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>
