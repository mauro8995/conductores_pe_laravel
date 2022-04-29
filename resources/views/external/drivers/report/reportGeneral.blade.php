<table>
    <thead>
      <tr>
          <th colspan="16">CAPACITACION DE LIDERES</th>
          <th colspan="2">ANTECEDENTES</th>
          <th colspan="4">RECORD C.</th>
          <th colspan="3">FOTO DE PERFIL</th>
          <th colspan="8">DOCUMENTOS</th>
          <th colspan="3">FOTO AUTO</th>
          <th colspan="5">CONTROL Y VERIFICACIÓN VEHÍCULAR</th>
      </tr>
    <tr>
        <th>ESTADO FINAL</th>
        <th>FECHA</th>
        <th>SPONSOR</th>
        <th>ID</th>
	<th>USUSARIO</th>
        <th>TIPO DOCUMENTO</th>
	<th>DNI</th>
        <th>NOMBRES</th>
        <th>APELLIDOS</th>
	<th>CUIDAD</th>
	<th>DIRECCION</th>
        <th>CELULAR</th>
        <th>EMAIL</th>
	<th>FECHA VEN SOAT</th>
        <th>FECHA VEN LICEN</th>
	<th>FECHA VEN REV_TECNICA</th>
        <th>ANTECEDENTES</th>
        <th>OBSERVACION</th>
        <th>ESTADO_RECORD</th>
        <th>PUNTOS_RECORD</th>
        <th>CATEGORIA_RECORD</th>
        <th>OBSERVACION</th>
      	<th>FOTO PERFIL</th>
      	<th>ESTADO</th>
      	<th>OBSERVACION</th>
        <th>DNI</th>
        <th>LICENCIA</th>
      	<th>TARJETA_VEHICULAR</th>
      	<th>SOAT</th>
      	<th>USO SOAT</th>
      	<th>REVICION TECNICA</th>
      	<th>ESTADO</th>
      	<th>OBSERVACION</th>
      	<th>DOCUMENTO</th>
      	<th>ESTADO</th>
        <th>OBSERVACION</th>
        <th>EVALUACION</th>
        <th>PLACA</th>
	<th>MARCA</th>
	<th>MODEL</th>
        <th>ANIO</th>
        <th>ESTADO</th>
        <th>OBSERVACION</th>
    </tr>
    </thead>
    <tbody>
      <?php


	function recordStatus($id,$status) {
              if($id === null)
              {
                return "SIN PROCESO";

              }
              elseif($id === 1)
              {
                if($status)
                  return "APROBADO";
                 else {
                   return "DETENIDO";
                 }
              }
              elseif($id === 3)
              {
                 return "EN EVALUACION";
              }
              elseif($id === 0){
                  return "DESAPROBADO";
              }else {
                return "INDEFINIDO";
              }
        }


	function finalOlo($a)
	{
		$status = "I";
		$cantidad = 0;
			foreach ($a as $rs) {
			if ($rs === 0){
            	 	$status = "D";
			 break;
			}
			if($rs === 1)
				{
				$cantidad++;
				if($cantidad == 6)
					{
            	 			$status = "A";
			 		break;
					}
        if($a[0] == 1 && $a[1] == 1 && $a[2] == 1)
          {
            $status = "CL";
          }
				}

        if($a[0] == 3 && $a[1] ==3 && $a[2] == 3)
        {
          $status = "CL";
        }

        if(($a[0] == 3 || $a[0] == 1 ) && ($a[1] ==3 || $a[1] ==1) && ($a[2] == 3 || $a[2] == 1))
        {
          $status = "CL";
        }


          	}
		return $status;
	}

	function ControlVerificacionStatus($id) {
            if($id === null)
            {
              return "SIN PROCESO";

            }
            elseif($id === 1)
            {
                return "APROBADO";
            }
            elseif($id === 0){
                return "DESAPROBADO";
            }else {
              return "PENDIENTE";
            }
        }

	function antecedentesStatus($id,$status) {
              if($id === null)
              {
                return "SIN PROCESO";

              }
              elseif($id === 1)
              {
                if($status)
                  return "APROBADO";
                 else {
                   return "DETENIDO";
                 }
              }elseif($id === 3){
                  return "EN AVALUACION";
              }
              elseif($id === 0){
                  return "DESAPROBADO";
              }else {
                return "INDEFINIDO";
              }
        }

        function documentosStatus($id) {
                    if($id === null)
                    {
                      return "SIN PROCESO";

                    }
                    elseif($id === 1)
                    {
                        return "APROBADO";

                    }
                    elseif($id === 0){
                        return "DESAPROBADO";
                    }else {
                      return "PENDIENTE";
                    }
              }

              function vehiculoStatus($id) {
                        if($id === null)
                        {
                          return "SIN PROCESO";

                        }
                        elseif($id === 1)
                        {
                            return "APROBADO";

                        }
                        elseif($id === 0){
                            return "DESAPROBADO";
                        }else {
                          return "PENDIENTE";
                        }
                    }

                    function perfilStatus($id) {
                              if($id === null)
                              {
                                return "SIN PROCESO";
                              }
                              elseif($id === 1)
                              {
                                  return "APROBADO";

                              }
                              elseif($id === 0){
                                  return "DESAPROBADO";
                              }else {
                                return "PENDIENTE";
                              }
                          }



	// ----------------------------------------------------------------------------------
	//


  function perfil2Status($dni_front)
  {
    if($dni_front != null)
    {
      return "SI";
    }elseif ($dni_front == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

	function dniStatus($dni_front,$dni_back)
  {
    if($dni_front != null && $dni_back != null)
    {
      return "SI";
    }elseif ($dni_front == null && $dni_back == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function licenciaStatus($dni_front,$dni_back)
  {
    if($dni_front != null && $dni_back != null)
    {
      return "SI";
    }elseif ($dni_front == null && $dni_back == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function targetaStatus($dni_front,$dni_back)
  {
    if($dni_front != null && $dni_back != null)
    {
      return "SI";
    }elseif ($dni_front == null && $dni_back == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function soatStatus($dni_front)
  {
    if($dni_front != null)
    {
      return "SI";
    }elseif ($dni_front == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function revicionStatus($dni_front)
  {
    if($dni_front != null)
    {
      return "SI";
    }elseif ($dni_front == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function autoStatus($dni_front,$dni_front2,$dni_front3)
  {
    if($dni_front != null && $dni_front2 != null && $dni_front3 != null )
    {
      return "SI";
    }elseif ($dni_front == null && $dni_front2 == null && $dni_front3 == null) {
      return "NO";
    }else {
      return "INCOMPLETO";
    }
  }

  function control_visual_Statuse($d)
  {
    $anio = date("Y");
    if($d != null)
    {
      $diferenciaYear = $anio - $d;

      if($diferenciaYear > 0 && $diferenciaYear <= 4)
      {
        return "VISUAL";
      }elseif ($diferenciaYear > 4 && $diferenciaYear <= 9) {
        return "ORDINARIA";
      }else {
        return "MECANICA";
      }
    }else {
      return "SIN PROCESO.";
    }

  }
//
        ?>
    @foreach($pendientes as $u)
        <tr>
          {{-- <td>{{ date("d-m-Y",strtotime($u->created_at))       }}</td> --}}
          	<td>P</td>
            <td>{{ ($u->created_at == null ) ? "15-08-2019":$u->created_at }}</td>
        		<td>{{ ($u->username  == null ) ? "admin":$u->username }}</td>
        		<td>{{ $u->id_office }}</td>
			<td>{{ $u->user}}</td>
            <td>{{ $u->description }}</td>
        		<td>{{ $u->dni }}</td>
        		<td>{{ $u->first_name }}</td>
        		<td>{{ $u->last_name }}</td>
			<td>{{ $u->city }}</td>
			<td>{{ $u->address }}</td>
            <td>{{ $u->phone }}</td>
        		<td>{{ $u->email }}</td>
			<td>{{ $u->soatfecven}}</td>
        		<td>{{ $u->licfecven}}</td>
			<td>{{ $u->revfecven}}</td>
        		<td><?php echo antecedentesStatus(null,1); ?> </td>
            <td>{{ "" }} </td>
        		<td>{{ recordStatus(null,1) }}</td>
        		<td>{{ $u->points }}</td>
        		<td>{{ $u->classcategoria }}</td>
            <td>{{ "" }} </td>
        		{{-- <td>{{ $u->licfecven }}</td> --}}
        		<td>{{ perfil2Status(null) }}</td>
            <td>{{ perfilStatus(null) }}</td>
            <td>{{ "" }}</td>
        		<td>{{ dniStatus(null,null) }}</td>
        		<td>{{ licenciaStatus(null,null) }}</td>
        		<td>{{ targetaStatus(null,null ) }}</td>
        		{{-- <td>{{ $u->car_interna }}</td>
        		<td>{{ $u->car_interna2 }}</td>
        		<td>{{ $u->car_externa }}</td> --}}
        		{{-- <td>{{ $u->revision_tecnica }}</td> --}}
        		<td>{{ soatStatus(null) }}</td>
        		<td>{{ $u->type_soat }}</td>
        		<td>{{ revicionStatus(null) }}</td>
            <td>{{ documentosStatus(null) }}</td>
            <td>{{  "" }}</td>
            <td>{{ autoStatus(null,null,null) }}</td>
            <td>{{ vehiculoStatus(null) }}</td>
            <td>{{ "" }}</td>
            <td>{{ control_visual_Statuse($u->year) }}</td>
        		<td>{{ $u->placa }}</td>
        		<td>{{ $u->marca }}</td>
			<td>{{ $u->model }}</td>
			<td>{{ $u->year }}</td>
        		<td>{{ ControlVerificacionStatus(null) }}</td>
            <td>{{ "" }}</td>
        </tr>
    @endforeach

@foreach($proceso as $u)
        <tr>
          {{-- <td>{{ date("d-m-Y",strtotime($u->created_at))       }}</td> --}}
          	<td>
		<?php
			$b = [
        $u->fotos_auto,
        $u->documentos,
        $u->foto_perfil_a,
 $u->control_vehi,
 $u->antecedentes,
 $u->record_con,
			];
			echo finalOlo($b);
		 ?>
	</td>
		<td>{{ ($u->created_at == null ) ? "15-08-2019":$u->created_at }}</td>
		<td>{{ ($u->username  == null ) ? "admin":$u->username }}</td>
		<td>{{ $u->id_office }}</td>
		<td>{{ $u->user}}</td>
    <td>{{ $u->description }}</td>
		<td>{{ $u->dni }}</td>
		<td>{{ $u->first_name }}</td>
		<td>{{ $u->last_name }}</td>
		<td>{{ $u->city }}</td>
<td>{{ $u->address }}</td>
    <td>{{ $u->phone }}</td>
    <td>{{ $u->email }}</td>
<td>{{ $u->soatfecven}}</td>
        		<td>{{ $u->licfecven}}</td>
			<td>{{ $u->revfecven}}</td>
		<td><?php echo antecedentesStatus($u->antecedentes,$u->antecedentes_val); ?> </td>
    <td>{{ $u->descrip_antecedentes }} </td>
		<td>{{ recordStatus($u->record_con,$u->record_con_val) }}</td>
		<td>{{ $u->points }}</td>
		<td>{{ $u->classcategoria }}</td>
    <td>{{ $u->descrip_record_con }} </td>
		{{-- <td>{{ $u->licfecven }}</td> --}}
		<td>{{ perfil2Status($u->photo_perfil) }}</td>
    <td>{{ perfilStatus($u->foto_perfil_a) }}</td>
    <td>{{ $u->descrip_foto_perfil }}</td>
		<td>{{ dniStatus($u->dni_frontal,$u->dni_back) }}</td>
		<td>{{ licenciaStatus($u->lic_frontal,$u->lic_back) }}</td>
		<td>{{ targetaStatus($u->tar_veh_frontal,$u->tar_veh_back ) }}</td>
		{{-- <td>{{ $u->car_interna }}</td>
		<td>{{ $u->car_interna2 }}</td>
		<td>{{ $u->car_externa }}</td> --}}
		{{-- <td>{{ $u->revision_tecnica }}</td> --}}
		<td>{{ soatStatus($u->soat_frontal) }}</td>
		<td>{{ $u->type_soat }}</td>
		<td>{{ revicionStatus($u->revision_tecnica) }}</td>
    <td>{{ documentosStatus($u->documentos) }}</td>
    <td>{{ $u->descrip_documentos }}</td>
    <td>{{ autoStatus($u->car_externa,$u->car_interna,$u->car_interna2) }}</td>
    <td>{{ vehiculoStatus($u->fotos_auto) }}</td>
    <td>{{ $u->descrip_fotos_auto }}</td>
    <td>{{ control_visual_Statuse($u->year) }}</td>
		<td>{{ $u->placa }}</td>
        	<td>{{ $u->marca }}</td>
		<td>{{ $u->model }}</td>
		<td>{{ $u->year }}</td>
		<td>{{ ControlVerificacionStatus($u->control_vehi) }}</td>
    <td>{{ $u->descrip_control_vehi_val }}</td>
        </tr>
    @endforeach

@foreach($migrado as $u)
        <tr>
          {{-- <td>{{ date("d-m-Y",strtotime($u->created_at))       }}</td> --}}
          	<td>M</td>
            <td>{{ ($u->created_at == null ) ? "15-08-2019":$u->created_at }}</td>
        		<td>{{ ($u->username  == null ) ? "admin":$u->username }}</td>
        		<td>{{ $u->id_office }}</td>
.			<td>{{ $u->user}}</td>
            <td>{{ $u->description }}</td>
        		<td>{{ $u->dni }}</td>
        		<td>{{ $u->first_name }}</td>
        		<td>{{ $u->last_name }}</td>
			<td>{{ $u->city }}</td>
<td>{{ $u->address }}</td>
            <td>{{ $u->phone }}</td>
            <td>{{ $u->email }}</td>
<td>{{ $u->soatfecven}}</td>
        		<td>{{ $u->licfecven}}</td>
			<td>{{ $u->revfecven}}</td>
        		<td><?php echo antecedentesStatus($u->antecedentes,1); ?> </td>
            <td>{{ "" }} </td>
        		<td>{{ recordStatus($u->record_con,1) }}</td>
        		<td>{{ $u->points }}</td>
        		<td>{{ $u->classcategoria }}</td>
            <td>{{ "" }} </td>
        		{{-- <td>{{ $u->licfecven }}</td> --}}
        		<td>{{ perfil2Status($u->photo_perfil) }}</td>
            <td>{{ perfilStatus(1) }}</td>
            <td>{{ "" }}</td>
        		<td>{{ dniStatus($u->dni_frontal,$u->dni_back) }}</td>
        		<td>{{ licenciaStatus($u->lic_frontal,$u->lic_back) }}</td>
        		<td>{{ targetaStatus($u->tar_veh_frontal,$u->tar_veh_back ) }}</td>
        		{{-- <td>{{ $u->car_interna }}</td>
        		<td>{{ $u->car_interna2 }}</td>
        		<td>{{ $u->car_externa }}</td> --}}
        		{{-- <td>{{ $u->revision_tecnica }}</td> --}}
        		<td>{{ soatStatus($u->soat_frontal) }}</td>
        		<td>{{ $u->type_soat }}</td>
        		<td>{{ revicionStatus("-") }}</td>
            <td>{{ documentosStatus(1) }}</td>
            <td>{{ "" }}</td>
            <td>{{ autoStatus("-","-","-") }}</td>
            <td>{{ vehiculoStatus(1) }}</td>
            <td>{{ "" }}</td>
            <td>{{ control_visual_Statuse($u->year) }}</td>
        		<td>{{ $u->placa }}</td>
        		<td>{{ $u->marca }}</td>
			<td>{{ $u->model }}</td>
        		<td>{{ $u->year }}</td>
        		<td>{{ ControlVerificacionStatus(1) }}</td>
            <td>{{ "" }}</td>
        </tr>
    @endforeach


    </tbody>
</table>
