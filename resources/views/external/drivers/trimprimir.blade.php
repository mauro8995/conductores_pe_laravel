


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
                    <td></td>
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
                    <td colspan="2">  @if($luz_baja == 1)  <p>Buen estado / Tiene</p>  @elseif($luz_baja == 2)  <p>Reparacion</p> @elseif($luz_baja == 3)  <p> Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz Alta:</b></td>
                      <td colspan="2">  @if($luz_alta == 1) <p>Buen estado / Tiene</p>  @elseif($luz_alta == 2) <p>Reparacion</p> @elseif($luz_alta == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz de freno:</b></td>
                    <td colspan="2">  @if($luz_freno == 1) <p>Buen estado / Tiene</p>  @elseif($luz_freno == 2) <p>Reparacion</p> @elseif($luz_freno == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz de emergencia:</b></td>
                    <td colspan="2">  @if($luz_emergencia == 1) <p>Buen estado / Tiene</p>  @elseif($luz_emergencia == 2) <p>Reparacion</p> @elseif($luz_emergencia == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz de retroceso:</b></td>
                    <td colspan="2">  @if($luz_retroceso == 1) <p>Buen estado / Tiene</p>  @elseif($luz_retroceso == 2) <p>Reparacion</p> @elseif($luz_retroceso == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz intermitente:</b></td>
                    <td colspan="2">  @if($luz_intermitente == 1) <p>Buen estado / Tiene</p>  @elseif($luz_intermitente == 2) <p>Reparacion</p> @elseif($luz_intermitente == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz antiniebla:</b></td>
                    <td colspan="2">  @if($luz_antiniebla == 1) <p>Buen estado / Tiene</p>  @elseif($luz_antiniebla == 2) <p>Reparacion</p> @elseif($luz_antiniebla == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz de placa:</b></td>
                      <td colspan="2">  @if($luz_placa == 1) <p>Buen estado / Tiene</p>  @elseif($luz_placa == 2) <p>Reparacion</p> @elseif($luz_placa == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>ARRANQUE DE MOTOR:</b></td>
                  </tr>
                  <tr>
                    <td><b>Arrancador:</b></td>
                      <td colspan="2">  @if($arrancador == 1) <p>Buen estado / Tiene</p>  @elseif($arrancador == 2) <p>Reparacion</p> @elseif($arrancador == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Alternador:</b></td>
                      <td colspan="2">  @if($alternador == 1) <p>Buen estado / Tiene</p>  @elseif($alternador == 2) <p>Reparacion</p> @elseif($alternador == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Bujias:</b></td>
                      <td colspan="2">  @if($bujias == 1) <p>Buen estado / Tiene</p>  @elseif($bujias == 2) <p>Reparacion</p> @elseif($bujias == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Cable de Bujias:</b></td>
                      <td colspan="2">  @if($cable_bujias == 1) <p>Buen estado / Tiene</p>  @elseif($cable_bujias == 2) <p>Reparacion</p> @elseif($cable_bujias == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Bobinas:</b></td>
                      <td colspan="2">  @if($bobinas == 1) <p>Buen estado / Tiene</p>  @elseif($bobinas == 2) <p>Reparacion</p> @elseif($bobinas == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Inyectores:</b></td>
                      <td colspan="2">  @if($inyectores == 1) <p>Buen estado / Tiene</p>  @elseif($inyectores == 2) <p>Reparacion</p> @elseif($inyectores == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Bateria:</b></td>
                      <td colspan="2">  @if($bateria == 1) <p>Buen estado / Tiene</p>  @elseif($bateria == 2) <p>Reparacion</p> @elseif($bateria == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>FRENOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Pastillas delanteras:</b></td>
                      <td colspan="2">  @if($past_del == 1) <p>Buen estado / Tiene</p>  @elseif($past_del == 2) <p>Reparacion</p> @elseif($past_del == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Pastillas Posterior:</b></td>
                      <td colspan="2">  @if($past_tras == 1) <p>Buen estado / Tiene</p>  @elseif($past_tras == 2) <p>Reparacion</p> @elseif($past_tras == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Discos delanteros:</b></td>
                      <td colspan="2">  @if($disc_del == 1) <p>Buen estado / Tiene</p>  @elseif($disc_del == 2) <p>Reparacion</p> @elseif($disc_del == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Discos Posterior:</b></td>
                      <td colspan="2">  @if($disc_tras == 1) <p>Buen estado / Tiene</p>  @elseif($disc_tras == 2) <p>Reparacion</p> @elseif($disc_tras == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Tambores Posterior:</b></td>
                      <td colspan="2">  @if($tamb_tras == 1) <p>Buen estado / Tiene</p>  @elseif($tamb_tras == 2) <p>Reparacion</p> @elseif($tamb_tras == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Zapatas Posterior:</b></td>
                      <td colspan="2">  @if($zapatas_tras == 1) <p>Buen estado / Tiene</p>  @elseif($zapatas_tras == 2) <p>Reparacion</p> @elseif($zapatas_tras == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Freno de emergencia:</b></td>
                      <td colspan="2">  @if($freno_emerg == 1) <p>Buen estado / Tiene</p>  @elseif($freno_emerg == 2) <p>Reparacion</p> @elseif($freno_emerg == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Liquido de freno:</b></td>
                      <td colspan="2">  @if($liq_freno == 1) <p>Buen estado / Tiene</p>  @elseif($liq_freno == 2) <p>Reparacion</p> @elseif($liq_freno == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>NEUMATICOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Estado de neumaticos:</b></td>
                      <td colspan="2">  @if($est_neumaticos == 1) <p>Buen estado / Tiene</p>  @elseif($est_neumaticos == 2) <p>Reparacion</p> @elseif($est_neumaticos == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Revision de tuercas:</b></td>
                      <td colspan="2">  @if($rev_tuercas == 1) <p>Buen estado / Tiene</p>  @elseif($rev_tuercas == 2) <p>Reparacion</p> @elseif($rev_tuercas == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Presion de neumaticos:</b></td>
                      <td colspan="2">  @if($pres_neumat == 1) <p>Buen estado / Tiene</p>  @elseif($pres_neumat == 2) <p>Reparacion</p> @elseif($pres_neumat == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>LLanta de repuesto:</b></td>
                      <td colspan="2">  @if($llanta_resp == 1) <p>Buen estado / Tiene</p>  @elseif($llanta_resp == 2) <p>Reparacion</p> @elseif($llanta_resp == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>CARROCERIA Y CHASIS:</b></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>MOTOR:</b></td>
                  </tr>
                  <tr>
                    <td><b>Fuga de aceite:</b></td>
                      <td colspan="2">  @if($fuga_aceite == 1) <p>Buen estado / Tiene</p>  @elseif($fuga_aceite == 2) <p>Reparacion</p> @elseif($fuga_aceite == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Fuga de refrigerante:</b></td>
                      <td colspan="2">  @if($fuga_refrig == 1) <p>Buen estado / Tiene</p>  @elseif($fuga_refrig == 2) <p>Reparacion</p> @elseif($fuga_refrig == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Fuga de combustible:</b></td>
                      <td colspan="2">  @if($fuga_combust == 1) <p>Buen estado / Tiene</p>  @elseif($fuga_combust == 2) <p>Reparacion</p> @elseif($fuga_combust == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Filtro de aceite:</b></td>
                      <td colspan="2">  @if($filt_aceite == 1) <p>Buen estado / Tiene</p>  @elseif($filt_aceite == 2) <p>Reparacion</p> @elseif($filt_aceite == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Filtro de aire:</b></td>
                      <td colspan="2">  @if($filt_aire == 1) <p>Buen estado / Tiene</p>  @elseif($filt_aire == 2) <p>Reparacion</p> @elseif($filt_aire == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Filtro de combustible:</b></td>
                      <td colspan="2">  @if($filt_combus == 1) <p>Buen estado / Tiene</p>  @elseif($filt_combus == 2) <p>Reparacion</p> @elseif($filt_combus == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>

                  </tr>
                  <tr>
                    <td><b>Filtro de cabina:</b></td>
                      <td colspan="2">  @if($filt_cabina == 1) <p>Buen estado / Tiene</p>  @elseif($filt_cabina == 2) <p>Reparacion</p> @elseif($filt_cabina == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Bomba de direccion:</b></td>
                      <td colspan="2">  @if($filt_cabina == 1) <p>Buen estado / Tiene</p>  @elseif($filt_cabina == 2) <p>Reparacion</p> @elseif($filt_cabina == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>SUSPENSION:</b></td>
                  </tr>
                  <tr>
                    <td><b>Amortiguadores Delanteros:</b></td>
                      <td colspan="2">  @if($amorti_del == 1) <p>Buen estado / Tiene</p>  @elseif($amorti_del == 2) <p>Reparacion</p> @elseif($amorti_del == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Amortiguadores Posteriores:</b></td>
                      <td colspan="2">  @if($amorti_post == 1) <p>Buen estado / Tiene</p>  @elseif($amorti_post == 2) <p>Reparacion</p> @elseif($amorti_post == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Palieres:</b></td>
                      <td colspan="2">  @if($palieres == 1) <p>Buen estado / Tiene</p>  @elseif($palieres == 2) <p>Reparacion</p> @elseif($palieres == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Rotulas:</b></td>
                      <td colspan="2">  @if($rotulas == 1) <p>Buen estado / Tiene</p>  @elseif($rotulas == 2) <p>Reparacion</p> @elseif($rotulas == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Terminales de direccion:</b></td>
                      <td colspan="2">  @if($termin_direc == 1) <p>Buen estado / Tiene</p>  @elseif($termin_direc == 2) <p>Reparacion</p> @elseif($termin_direc == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Trapezios:</b></td>
                      <td colspan="2">  @if($trapezios == 1) <p>Buen estado / Tiene</p>  @elseif($trapezios == 2) <p>Reparacion</p> @elseif($trapezios == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Resortes:</b></td>
                      <td colspan="2">  @if($resortes == 1) <p>Buen estado / Tiene</p>  @elseif($resortes == 2) <p>Reparacion</p> @elseif($resortes == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>TRANSMISION:</b></td>
                  </tr>
                  <tr>
                    <td><b>Aceite de caja:</b></td>
                      <td colspan="2">  @if($aceite_caja == 1) <p>Buen estado / Tiene</p>  @elseif($aceite_caja == 2) <p>Reparacion</p> @elseif($aceite_caja == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Filtro de caja:</b></td>
                      <td colspan="2">  @if($filtro_caja == 1) <p>Buen estado / Tiene</p>  @elseif($filtro_caja == 2) <p>Reparacion</p> @elseif($filtro_caja == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Caja de transferencia:</b></td>
                      <td colspan="2">  @if($caja_transf == 1) <p>Buen estado / Tiene</p>  @elseif($caja_transf == 2) <p>Reparacion</p> @elseif($caja_transf == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Cardan:</b></td>
                      <td colspan="2">  @if($cardan == 1) <p>Buen estado / Tiene</p>  @elseif($cardan == 2) <p>Reparacion</p> @elseif($cardan == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Diferencial:</b></td>
                      <td colspan="2">  @if($diferencial == 1) <p>Buen estado / Tiene</p>  @elseif($diferencial == 2) <p>Reparacion</p> @elseif($diferencial == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Disco de embrague:</b></td>
                      <td colspan="2">  @if($disco_embrague == 1) <p>Buen estado / Tiene</p>  @elseif($disco_embrague == 2) <p>Reparacion</p> @elseif($disco_embrague == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Collarin:</b></td>
                      <td colspan="2">  @if($collarin == 1) <p>Buen estado / Tiene</p>  @elseif($collarin == 2) <p>Reparacion</p> @elseif($collarin == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Cruzetas:</b></td>
                      <td colspan="2">  @if($cruzetas == 1) <p>Buen estado / Tiene</p>  @elseif($cruzetas == 2) <p>Reparacion</p> @elseif($cruzetas == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>SISTEMA DE ENFRIAMIENTO:</b></td>
                  </tr>
                  <tr>
                    <td><b>Radiador:</b></td>
                      <td colspan="2">  @if($radiador == 1) <p>Buen estado / Tiene</p>  @elseif($radiador == 2) <p>Reparacion</p> @elseif($radiador == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Ventiladores:</b></td>
                      <td colspan="2">  @if($ventiladores == 1) <p>Buen estado / Tiene</p>  @elseif($ventiladores == 2) <p>Reparacion</p> @elseif($ventiladores == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Correa de ventilador:</b></td>
                      <td colspan="2">  @if($correa_vent == 1) <p>Buen estado / Tiene</p>  @elseif($correa_vent == 2) <p>Reparacion</p> @elseif($correa_vent == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Mangueras de agua:</b></td>
                      <td colspan="2">  @if($mangueras_agua == 1) <p>Buen estado / Tiene</p>  @elseif($mangueras_agua == 2) <p>Reparacion</p> @elseif($mangueras_agua == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>INTERIORES:</b></td>
                  </tr>
                  <tr>
                    <td><b>Luz de tablero:</b></td>
                      <td colspan="2">  @if($luz_tablero == 1) <p>Buen estado / Tiene</p>  @elseif($luz_tablero == 2) <p>Reparacion</p> @elseif($luz_tablero == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Luz de saloom:</b></td>
                      <td colspan="2">  @if($luz_saloom == 1) <p>Buen estado / Tiene</p>  @elseif($luz_saloom == 2) <p>Reparacion</p> @elseif($luz_saloom == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>ACCESORIOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Gata:</b></td>
                      <td colspan="2">  @if($gata == 1) <p>Buen estado / Tiene</p>  @elseif($gata == 2) <p>Reparacion</p> @elseif($gata == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Llave de ruedas:</b></td>
                      <td colspan="2">  @if($llave_ruedas == 1) <p>Buen estado / Tiene</p>  @elseif($llave_ruedas == 2) <p>Reparacion</p> @elseif($llave_ruedas == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Estuche de herramientas:</b></td>
                      <td colspan="2">  @if($estuche_herra == 1) <p>Buen estado / Tiene</p>  @elseif($estuche_herra == 2) <p>Reparacion</p> @elseif($estuche_herra == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Triangulo de seguridad:</b></td>
                      <td colspan="2">  @if($triangulo_seg == 1) <p>Buen estado / Tiene</p>  @elseif($triangulo_seg == 2) <p>Reparacion</p> @elseif($triangulo_seg == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td><b>Extintor:</b></td>
                      <td colspan="2">  @if($extintor == 1) <p>Buen estado / Tiene</p>  @elseif($extintor == 2) <p>Reparacion</p> @elseif($extintor == 3)  <p>Mal estado / No tiene</p> @else <p>Falta Colocar</p> @endif </td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>OBSERVACIONES: </b>  @if($note == null) <p>No hay ninguna observacion</p> @else {{$note}} @endif </td>
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
