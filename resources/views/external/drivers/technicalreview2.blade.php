@extends('layout-backend')
@section('title', 'Revisión Checklist')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
@endsection


@section('content')
<section class="content">
  <h4>Revisión Checklist:</h4>
  <code>Campos obligatorios ( * )</code>
  <hr>
  <form class="form-horizontal" action="#" id="formtechnicalreview2" enctype="multipart/form-data">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="seccion" style="background-color:#FFFFFF">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-12 col-sm-4 col-md-3 padd" for="idoffice">ID de la oficina virtual:<code>*</code></label>
            <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
              <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el ID" name="idoffice">
            </div>
              <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
                <button type="button" id="btn_search" class="btn btn-success"><b>Buscar</b></button>
              </div>
          </div>
          <div  class="col-xs-12 col-md-12 padd2">
          <div align="center" style="background-color:yellow">
            <h3><b>DATOS DEL CONDUCTOR</b></h3>
          </div>
        </div>

          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="nameuser">Nombres:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="nameuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="apeuser">Apellidos:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="apeuser"></div>
          </div>

          <div  class="col-md-12 col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">Tipo de documento de identidad: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                {!! Form::select('tipdocid', $type_docs, null, ['id'=>'tipdocid','placeholder'=>'SELECCIONAR','class'=>'form-control select2 ', 'style'=>'width: 100%'] ) !!}
            </div>
         </div>
          <div  class="col-md-12 col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni">Numero de documento de identidad: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type="text" class="form-control" id="dni" placeholder="Ingresar DNI" name="dni">
            </div>
         </div>

         <div  class="col-xs-12 col-md-6 padd2">
           <label class="col-xs-12 col-sm-3 col-md-4 padd" for="licencia">Licencia:<code>*</code></label>
           <div class="col-xs-12 col-sm-9 col-md-8 padd" >
             <input type="text" class="form-control" id="licencia" placeholder="Ingresar la Licencia" name="licencia">
           </div>
         </div>
         <div  class="col-xs-12 col-md-6 padd2">
             <label class="col-xs-12 col-sm-3 col-md-4 padd" for="emailuser">Correo:<code>*</code></label>
             <div class="col-xs-12 col-sm-9 col-md-8 padd" id="emailuser">
             </div>
         </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Telefono:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="phoneuser"></div>
          </div>

          <div  class="col-xs-12 col-md-12 padd2">
            <div align="center" style="background-color:lightblue"  >
              <h3><b>DATOS DEL VEHÍCULO</b></h3>
            </div>
          </div>


          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">Placa / Matricula:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" >
                <input type="text" class="form-control" id="placa" name="placa" placeholder="Ingresar la Placa del vehículo" >
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">Año Vehículo:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="yearfile">
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="marca">Marca:<code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd" >
              <input type="text" class="form-control" id="marca" placeholder="Ingresar la Marca del vehiculo" name="licuser">
            </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
             <label class="col-xs-12 col-sm-3 col-md-4 padd" for="model">Modelo:<code>*</code></label>
             <div class="col-xs-12 col-sm-9 col-md-8 padd" >
               <input type="text" class="form-control" id="model" placeholder="Ingresar el Modelo del vehiculo" name="licuser">
             </div>
           </div>
      </div>
      <hr>
      <div class="seccion">
        <div  class="col-lg-12 padd2">
          <div class="col-xs-12" align="center"><button class="btn btn-success" type="button"  data-toggle="collapse"   data-target="#reviewtec" aria-expanded="false" aria-controls="reviewtec"><b>REVISAR</b></button></div>
        </div>
      </div>
      <div class="seccion collapse" id="reviewtec">
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>LUCES:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#luces" aria-expanded="false" aria-controls="luces"><b>Desplegar</b></button></div>
          </div>
      </div>
      <div class="seccion collapse " id="luces" >
          <div class="col-xs-12 col-sm-12 impar b-bottom  b-top">
              <label class="col-xs-12"><b><b>Luz baja: </b><code>*</code></label>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="light_low" id="light_low" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="4">Falta colocar</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Luz Alta: </b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="light_high" id="light_high" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="4">Falta colocar</label>
              </div>

          </div>
          <div class="col-xs-12 col-sm-12  b-bottom b-top" >
              <label class="col-xs-12"><b>Luz de freno: </b><code>*</code></label>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="light_brake" id="light_brake" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="4">Falta colocar</label>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Luz de retroceso: </b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="light_recoil" id="light_recoil" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="4">Falta colocar</label>
              </div>

          </div>


                   <div  class="col-xs-12  b-top">
                     <label class="col-xs-6" for="observacion1"><b>Observacion:</b></label>
                     <div class="col-xs-12 padd" >
                       <textarea  id="observacion1" name="observacion1" class="form-control"> </textarea>

                     </div>
                   </div>



      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>CARROCERIA:</b><code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#chasis" aria-expanded="false" aria-controls="chasis"><b>Desplegar</b></button></div>
          </div>
      </div>
      <div class="seccion collapse" id="chasis">

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Puertas:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_door" id="left_front_door" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_door" id="left_front_door" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="left_front_door" id="left_front_door" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_door" id="left_front_door" value="4">Falta colocar</label>
            </div>

        </div>
        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Lunas(vidrios):</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_glass" id="left_front_glass" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_glass" id="left_front_glass" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="left_front_glass" id="left_front_glass" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="left_front_glass" id="left_front_glass" value="4">Falta colocar</label>
            </div>


        </div>

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Parabrisa:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="front_windshield" id="front_windshield" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="front_windshield" id="front_windshield" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="front_windshield" id="front_windshield" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="front_windshield" id="front_windshield" value="4">Falta colocar</label>
            </div>

        </div>


        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Capota:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="soft_top" id="soft_top" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="soft_top" id="soft_top" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="soft_top" id="soft_top" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="soft_top" id="soft_top" value="4">Falta colocar</label>
            </div>


        </div>

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Maletero:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="trunk" id="trunk" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="trunk" id="trunk" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="trunk" id="trunk" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="trunk" id="trunk" value="4">Falta colocar</label>
            </div>


        </div>

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Llanta:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="tire_status" id="tire_status" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="tire_status" id="tire_status" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="tire_status" id="tire_status" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="tire_status" id="tire_status" value="4">Falta colocar</label>
            </div>


        </div>
          <div  class="col-xs-12  b-top">
            <label class="col-xs-6" for="observacion2"><b>Observacion:</b></label>
            <div class="col-xs-12 padd" >
              <textarea  id="observacion2" name="observacion2" class="form-control"> </textarea>

            </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8"><b>INTERIOR:</b><code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#interiores" aria-expanded="false" aria-controls="interiores"><b>Desplegar</b></button></div>
          </div>
      </div>
      <div class="seccion collapse" id="interiores">

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Asientos:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="pilot_seat" id="pilot_seat" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="pilot_seat" id="pilot_seat" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="pilot_seat" id="pilot_seat" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="pilot_seat" id="pilot_seat" value="4">Falta colocar</label>
            </div>
        </div>


        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Luz de saloom:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="saloon_light" id="saloon_light" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="saloon_light" id="saloon_light" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="saloon_light" id="saloon_light" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="saloon_light" id="saloon_light" value="4">Falta colocar</label>
            </div>


        </div>

        <div class="col-xs-12 col-sm-12 impar b-top">
            <label class="col-xs-12"><b>Bocina:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="horn" id="horn" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="horn" id="horn" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="horn" id="horn" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="horn" id="horn" value="4">Falta colocar</label>
            </div>


        </div>

        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Cinturones de seguridad:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="belt" id="belt" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="belt" id="belt" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="belt" id="belt" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="belt" id="belt" value="4">Falta colocar</label>
            </div>


        </div>


          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Luz de tablero:</b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="dash_light" id="dash_light" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="dash_light" id="dash_light" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="dash_light" id="dash_light" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="dash_light" id="dash_light" value="4">Falta colocar</label>
              </div>


          </div>




          <div  class="col-xs-12  b-top">
            <label class="col-xs-6" for="observacion3"><b>Observacion:</b></label>
            <div class="col-xs-12 padd" >
              <textarea  id="observacion3" name="observacion3" class="form-control"> </textarea>

            </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8"><b>HERRAMIENTAS:</b><code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#accesorios" aria-expanded="false" aria-controls="accesorios"><b>Desplegar</b></button></div>
          </div>
      </div>
      <div class="seccion collapse" id="accesorios">


        <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
            <label class="col-xs-12"><b>Estuche de herramientas:</b><code>*</code></label>

            <div class="col-xs-6 radio">
                <label><input type="radio" name="tool_kit" id="tool_kit" value="1">Buen estado/ Tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="tool_kit" id="tool_kit" value="2">Reparación</label>
            </div>
            <div class="col-xs-6 radio">
              <label><input type="radio" name="tool_kit" id="tool_kit" value="3">Mal estado/ no tiene</label>
            </div>
            <div class="col-xs-6 radio">
                <label><input type="radio" name="tool_kit" id="tool_kit" value="4">Falta colocar</label>
            </div>


        </div>

          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Gata:</b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="gata" id="gata" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="gata" id="gata" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="gata" id="gata" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="gata" id="gata" value="4">Falta colocar</label>
              </div>

          </div>

          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Extintor:</b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="extinguisher" id="extinguisher" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="extinguisher" id="extinguisher" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="extinguisher" id="extinguisher" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="extinguisher" id="extinguisher" value="4">Falta colocar</label>
              </div>


          </div>

          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Triangulo de seguridad:</b><code>*</code></label>

              <div class="col-xs-6 radio">
                  <label><input type="radio" name="safety_triangle" id="safety_triangle" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="safety_triangle" id="safety_triangle" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="safety_triangle" id="safety_triangle" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="safety_triangle" id="safety_triangle" value="4">Falta colocar</label>
              </div>


          </div>
          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Llanta extra:</b><code>*</code></label>


              <div class="col-xs-6 radio">
                  <label><input type="radio" name="spare_tire" id="spare_tire" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="spare_tire" id="spare_tire" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="spare_tire" id="spare_tire" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="spare_tire" id="spare_tire" value="4">Falta colocar</label>
              </div>


          </div>
          <div class="col-xs-12 col-sm-12 impar b-bottom b-top">
              <label class="col-xs-12"><b>Botiquin de Primeros Auxilios:</b><code>*</code></label>


              <div class="col-xs-6 radio">
                  <label><input type="radio" name="kit" id="kit" value="1">Buen estado/ Tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="kit" id="kit" value="2">Reparación</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="kit" id="kit" value="3">Mal estado/ no tiene</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="kit" id="kit" value="4">Falta colocar</label>
              </div>


          </div>






          <div  class="col-xs-12  b-top" >
            <label class="col-xs-6" for="observacion4"><b>Observacion:</b></label>
            <div class="col-xs-12 padd" >
              <textarea  id="observacion4" name="observacion4" class="form-control"> </textarea>
            </div>
          </div>


      </div>
      <hr>

      <div class="seccion">
          <div class="col-sm-4 col-xs-4 text-left">
            <button type="button" data-val="2" class="btn btn-success btn_ajax"><b>APROBADO</b></button>
          </div>
          <div class="col-sm-4 col-xs-4 text-center">
            <button type="button" data-val="1" class="btn btn-success btn_ajax"><b>VERIFICACION OFICINA</b></button>
          </div>
          <div class="col-sm-4 col-xs-4 text-right">
            <button type="button"  data-val="3" class="btn btn-success btn_ajax2" href="#" onclick="javascript:oculta('item1')"><b>TALLER</b></button>
          </div>
      </div>
      <div class="seccion invisible">
          <label class="col-xs-12">Observaciones:<code>*</code></label>
          <div class="col-xs-12 padd">
            <textarea id="observacion" name="observacion"  placeholder="Ingresa una observacion general" class="form-control" ></textarea>
          </div>
        </div>

    </div>

  </form>
</section>
<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
    {{--
      <div id="row">
          <div id="cantidadSubidas" style="color: blue">
              <h2>  0</h2>
          </div> de 10
      </div>
    --}}
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/External/Driver/technicalreview2.js')}} "></script>
@endsection
