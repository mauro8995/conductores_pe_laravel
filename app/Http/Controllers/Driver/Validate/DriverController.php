<?php

namespace App\Http\Controllers\Driver\Validate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\External\listClass;
use App\Models\General\User;
// use App\Models\Customer\Customer;
// use App\Models\customer\ImgCustomer;
// use App\Models\Driver\Driver;
// use App\Models\Driver\ImgDriver;
// use App\Models\Driver\ImgVehicles;
use App\Models\General\Type_document_identy;
use App\Models\External\ProcessTrace;
use App\Models\External\ProcesoValidacion;
use App\Models\External\ProcesoValCond;
use App\Models\General\Main;
// use App\Models\Driver\seguro;
// use App\Models\Driver\Vehicle;
use App\Models\General\Rol_permissions;
// use App\Models\General\code_email;
// use App\Models\External\Record_Driver;
use Mail;
use \PDF;
use \stdClass;
use Dompdf\Autoloader;
class DriverController extends Controller
{
    public function  listDriver_all()
    {
      $formulario    = request()->formulario;
      $d = new listClass();
      $rol= Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id')
        ->first();

        if ($rol->id == 7){
          if($formulario{'off_e'}) { $data = $d->getAllDrivers("and u.id_office ='".$formulario{'off_e'}."' "."and us.id =".auth()->user()->id."; "  );}
          if($formulario{'dni'}) { $data =  $d->getAllDrivers("and u.dni ='".$formulario{'dni'}."' "."and us.id =".auth()->user()->id."; "  );}
          if($formulario{'name'}) { $data = $d->getAllDrivers("and u.first_name ='".$formulario{'name'}."' "."and us.id =".auth()->user()->id."; "  );}
          if($formulario{'lastname'}) {$data =  $d->getAllDrivers("and u.last_name ='".$formulario{'lastname'}."' "."and us.id =".auth()->user()->id."; " );}


        } else {

          // if($formulario{'idstatususeroffices'})
          // {
          //   if($formulario{'idstatususeroffices'} == "MIGRADO")
          //   {
          //     $data = $d->getAllDrivers(";",false,false,true);//$pendiente = true,$proceso = true,$migrado = true
          //
          //   }elseif ($formulario{'idstatususeroffices'} == "EN EVALUACION") {
          //     $data = $d->getAllDrivers(";",true,false,false);//$pendiente = true,$proceso = true,$migrado = true
          //
          //   }else {
          //     $data = $d->getAllDrivers(";",true,true,false);//$pendiente = true,$proceso = true,$migrado = true
          //
          //   }
          // }
          // else
          // {
          //   if($formulario{'off_e'}) { $data = $d->getAllDrivers("and u.id_office ='".$formulario{'off_e'}."'; " );}
          //   if($formulario{'dni'}) { $data =  $d->getAllDrivers("and u.dni ='".$formulario{'dni'}."'; " );}
          //   if($formulario{'phone'}) { $data =  $d->getAllDrivers("and u.phone ='".$formulario{'phone'}."'; " );}
          //   if($formulario{'email'}) {$data =  $d->getAllDrivers("and u.email ='".$formulario{'email'}."'; " );}
          //   if($formulario{'name'}) { $data = $d->getAllDrivers("and u.first_name ='".$formulario{'name'}."'; " );}
          //   if($formulario{'lastname'}) {$data =  $d->getAllDrivers("and u.last_name ='".$formulario{'lastname'}."'; " );}
          //   if($formulario{'search'}) {$data =  $d->getAllDrivers("and us.username ='".$formulario{'search'}."'; " );}
          // }

          if($formulario{'off_e'}) { $data = $d->getAllDrivers("and u.id_office ='".$formulario{'off_e'}."'; " );}
        }



      $a = $this->styleDrivers($data);
      return response()->json([
          "object"   => "success",
          "data" =>$a
        ]);
    }
    public function  listDriver_id_office()
    {

      if(Customer::where('id_office', request()->dar)->exists())
      {
        $d = new listClass();
        $data = $d->getAllDrivers("and u.id_office ='".request()->dar."'; " );
        $a = $this->styleDrivers($data);
        return response()->json([
            "object"   => "success",
            "data" =>$a
          ]);
      }
      return response()->json([
          "object"   => "warning",
          "message" =>"El id No existe."
        ]);
    }
    public function  listDriver_username()
    {
      if(User::where('username',request()->user)->exists())
      {
        $u = User::where('username',request()->user)->first();
        $d = new listClass();
        $data = $d->getAllDrivers("and u.created_by =".$u->id."; " );
        $a = $this->styleDrivers($data);
        return response()->json([
            "object"   => "success",
            "data" =>$a
          ]);
      }else {
        return response()->json([
            "object"   => "warning",
            "message" =>"usuario no registrado."
          ]);
      }
    }

    function styleDrivers($array)
    {
      $d = [];




        foreach ($array{'pendientes'} as $key2 => $value2)
        {
              $action   =  '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$value2->id_office.')"></button>';
             //
              $reporte   =  '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$value2->id_office.'" target="_blank"></a>';
             //
              $resumen = '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$value2->id_office.')"></button>';

               $status = "PENDIENTE";


             $driver   = [
               'accion'         => $action,
               'resumen'        => $resumen,
               'reporte'        => $reporte,
               'dni'            => $value2->dni,
               'id_office'      => $value2->id_office,
               'first_name'     => $value2->first_name,
               'last_name'      =>$value2->last_name,
               'phone'          => $value2->phone,
               'correo'         => $value2->email,
               'estado'         => $status,
               'marca'          => $value2->marca,
               'placa'         => $value2->placa,
               'modelo'         => $value2->model,
               'date_create'    => $value2->created_at,
               'created'    => $value2->username,
             ];

             array_push($d, $driver);
        }







        foreach ($array{'proceso'} as $key2 => $value2)
        {
              $action   =  '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$value2->id_office.')"></button>';
             //
              $reporte   =  '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$value2->id_office.'" target="_blank"></a>';
             //
              $resumen = '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$value2->id_office.')"></button>';

              $b = [
  $value2->fotos_auto,
  $value2->documentos,
  $value2->foto_perfil,
  $value2->control_vehi,
  $value2->antecedentes,
  $value2->record_con,
  ];
              $status = $this->evaluacion($b);

             $driver   = [
               'accion'         => $action,
               'resumen'        => $resumen,
               'reporte'        => $reporte,
               'dni'            => $value2->dni,
               'id_office'      => $value2->id_office,
               'first_name'     => $value2->first_name,
               'last_name'      =>$value2->last_name,
               'phone'          => $value2->phone,
               'correo'         => $value2->email,
               'estado'         => $status,
               'marca'          => $value2->marca,
               'placa'         => $value2->placa,
               'modelo'         => $value2->model,
               'date_create'    => $value2->created_at,
               'created'    => $value2->username,
             ];

             array_push($d, $driver);
        }




        foreach ($array{'migrado'} as $key2 => $value2)
        {
              $action   =  '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$value2->id_office.')"></button>';
             //
              $reporte   =  '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$value2->id_office.'" target="_blank"></a>';
             //
              $resumen = '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$value2->id_office.')"></button>';




               $status = "MIGRADO";

             $driver   = [
               'accion'         => $action,
               'resumen'        => $resumen,
               'reporte'        => $reporte,
               'dni'            => $value2->dni,
               'id_office'      => $value2->id_office,
               'first_name'     => $value2->first_name,
               'last_name'      =>$value2->last_name,
               'phone'          => $value2->phone,
               'correo'         => $value2->email,
               'estado'         => $status,
               'marca'          => $value2->marca,
               'placa'         => $value2->placa,
               'modelo'         => $value2->model,
               'date_create'    => $value2->created_at,
               'created'    => $value2->username,
             ];
             array_push($d, $driver);
        }




      return $d;
    }

    function evaluacion($a)
	{
		$status = "EN EVALUACIÓN";
		$cantidad = 0;
			foreach ($a as $rs) {
			if ($rs === 0){
            	 	$status = "DESAPROBADO";
			 break;
			}
			if($rs === 1)
				{
				$cantidad++;
				if($cantidad == 6)
					{
            	 			$status = "APROBADO";
			 		break;
					}
        if($a[0] === 1 && $a[1] === 1 && $a[2] === 1)
          {
              $status = "COMPLETADO POR LIDER";
          }
				}


          	}
		return $status;
	}


    public function getDriver_id_office()
    {
      //return
      if(Customer::where('id_office',request()->dar)->exists())
      {
        $c = Customer::where('id_office',request()->dar)->with('getTypeDocument')->first();
        $data = new stdClass();
        $data->customer = $c;
        $data->imgCustomer = $c->getImgCustomer;
        $data->papeletas = $c->getRecord;
        $data->driver = $c->getDriver;
        $data->countryDriver = $c->getDriver->getCountry;
        $data->imgDriver = $data->driver->getImgDriver;
        $data->vehicle = $data->driver->getVehicle;
        $data->imgVehicle = $data->vehicle->getImgVehicle;
        $data->seguro = $data->vehicle->getSeguro;
        $arr = [];
        foreach ($c->getProceso as $key => $value) {
          $p = [
            "id"=>$value->id,
            "customer"=>$data->customer,
            "approved"=>$value->approved,
            "name_proceso"=>$value->getProcesoNombre,
            "getModifyBy"=>$value->getModifyBy,
            "getCreateyBy"=>$value->getCreateyBy,
            'description'=>$value->description,
            'created_at'=>$value->created_at,
            'updated_at'=>$value->updated_at,
            "statusTrace"=>ProcessTrace::where('id_customer',$value->id_customer)->where('id_process_model',$value->id_proceso_validacion)->first()
          ];
          array_push($arr, $p);
        }
        $data->proceso = $arr;
        return response()->json([
            "object"   => "success",
            "data" =>$data
          ]);
      }
      else{
        return response()->json([
            "object"   => "error",
            "message" =>"No existe el ID de office."
          ]);
      }
    }
    public function showImg()
    {
      $id_office = request()->id_office;
      $vista = request()->vista;
      return view('external.drivers.edidImg.edidImg',compact('id_office','vista'));
    }

    public function uploarAntecedente()
    {
      $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
      $pv = ProcesoValCond::where('id_proceso_validacion',5)->where('id_customer', $c->id)->first();
      $pv->modified_by = auth()->user()->id;
      $pv->approved = request()->approved;
      $pv->save();
      $this->processDriver($c->id_office);
      return response()->json([
          "object"   => "success"
        ]);
    }
    public function getTypeDocument()
    {
      $data = Type_document_identy::all();
      return response()->json([
          "object"   => "success",
          "data" =>$data
        ]);
    }
    public function editImgCustomer()
    {
      $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
      $data = new stdClass();
      $data->customer = $c;

      if($c->getImgCustomer->id == 0)
      {
        $b = new ImgCustomer();
        $b->id_customer = $c->id;
        $b->created_by = auth()->user()->id;
      }
      else {
        $b = $c->getImgCustomer;
      }

      $b->modified_by = auth()->user()->id;
      if(request()->campo == "url_dni_back")
      $b->url_dni_back = request()->data{'voucherURL'};
      elseif (request()->campo == "url_dni_front") {
        $b->url_dni_front = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_perfil") {
        $b->url_perfil = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_luz") {
        $b->url_luz = request()->data{'voucherURL'};
      }
      if (request()->campo == "url_antecedentes") {
        $b->url_antecedentes = request()->data{'voucherURL'};
      }
      $b->save();
      $this->processDriver(request()->id_office);

      return response()->json([
          "object"   => "success"
        ]);

    }
    public function editImgDriver()
    {
      $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
      $data = new stdClass();
      $data->customer = $c;
      $data->driver = $c->getDriver;
      $data->imgDriver = $data->driver->getImgDriver;
      if($data->imgDriver->id ==0)
      {
        $b = new   ImgDriver();
        $b->id_driver = $data->driver->id;
        $b->created_by = auth()->user()->id;
      }else {
        $b =$data->imgDriver;
      }
      $b->modified_by = auth()->user()->id;
      if(request()->campo == "url_licen_front")
      $b->url_licen_front = request()->data{'voucherURL'};
      elseif (request()->campo == "url_licen_back") {
        $b->url_licen_back = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_revision_tecnica") {
        $b->url_revision_tecnica = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_tar_front") {
        $b->url_tar_front = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_tar_back") {
        $b->url_tar_back = request()->data{'voucherURL'};
      }

      $b->save();

      $this->processDriver(request()->id_office);

      return response()->json([
          "object"   => "success"
        ]);

    }

    public function editImgVehicle()
    {
      $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
      $data = new stdClass();
      $data->customer = $c;
      $data->driver = $c->getDriver;
      $data->imgDriver = $data->driver->getImgDriver;
      $data->vehicle = $data->driver->getVehicle;
      $data->imgVehicle = $data->vehicle->getImgVehicle;

      if($data->imgVehicle->id == 0)
      {
        $b = new  ImgVehicles();
        $b->id_vehicle = $data->vehicle->id;
        $b->created_by = auth()->user()->id;
      }else {
        $b = $data->imgVehicle;

      }
      $b->modified_by = auth()->user()->id;
      if(request()->campo == "url_image1")
      $b->url_image1 = request()->data{'voucherURL'};
      elseif (request()->campo == "url_image2") {
        $b->url_image2 = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_image3") {
        $b->url_image3 = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_image4") {
        $b->url_image4 = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_image5") {
        $b->url_image5 = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_tar_front") {
        $b->url_tar_front = request()->data{'voucherURL'};
      }elseif (request()->campo == "url_tar_back") {
        $b->url_tar_back = request()->data{'voucherURL'};
      }
      elseif (request()->campo == "url_revision_tecnica") {
        $b->url_tar_back = request()->data{'voucherURL'};
      }


      $b->save();

      $this->processDriver($c->id_office);

      return response()->json([
          "object"   => "success",
          "menssage"=>"Datos ingresados."
        ]);

    }
    public function editImgSeguro()
    {
      $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
      $data = new stdClass();
      $data->customer = $c;
      $data->imgCustomer = $c->getImgCustomer;
      $data->papeletas = $c->getRecord;
      $data->driver = $c->getDriver;
      $data->countryDriver = $c->getDriver->getCountry;
      $data->imgDriver = $data->driver->getImgDriver;
      $data->vehicle = $data->driver->getVehicle;
      $data->imgVehicle = $data->vehicle->getImgVehicle;
      $data->seguro = $data->vehicle->getSeguro;
      if($data->seguro->id == 0)
      {
        $b = new seguro();
        $b->id_vehicle = $data->vehicle->id;
        $b->created_by = auth()->user()->id;
      }else {
        $b = $data->seguro;
      }
      $b->modified_by = auth()->user()->id;
      if(request()->campo == "url_soat")
      {
        $b->url_soat = request()->data{'voucherURL'};

        $b->save();
      }

      $this->processDriver(request()->id_office);


      return response()->json([
          "object"   => "success"
        ]);

    }


    public function permisosProcessValid(){
     $id_proceso_validacion    =  request()->id;
     $estatus                  =  request()->estatus;
     $id_customer            =  request()->id_customer;
     $ProcesoValidacionCond  = ProcesoValCond::where('id',$id_proceso_validacion)->where('id_customer', $id_customer)->first();
     $ProcesoValidacion  = ProcesoValidacion::where('id',$ProcesoValidacionCond->id_proceso_validacion)->first();
     $permiso            = $ProcesoValidacion->id_permissions;
     $rol                = Main::where('users.id', '=', auth()->user()->id)
       ->where('main.status_user', '=', 'TRUE')
       ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
       ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
       ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
       ->join('users',    'users.id',              '=',   'rol_user.id_user')
       ->select('roles.id','rol_user.id as id_roluser')
       ->first();
     $roluser            = $rol{'id_roluser'};

     $rol_permiso        = Rol_permissions::where('id_roluser', '=', $roluser)->where('id_permission', $permiso)->first();

     if($rol_permiso || $rol{'id'}== 4){
       //$ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',$id_proceso_validacion)

       if ($ProcesoValidacionCond->id_proceso_validacio == 1){
         $c = Customer::where('id',$id_customer)->with('getTypeDocument')->first();
         $data = new stdClass();
         $data->customer = $c;
         $data->imgCustomer = $c->getImgCustomer;
         $data->papeletas = $c->getRecord;
         $data->driver = $c->getDriver;
         $data->countryDriver = $c->getDriver->getCountry;
         $data->imgDriver = $data->driver->getImgDriver;
         $data->vehicle = $data->driver->getVehicle;
         $data->imgVehicle = $data->vehicle->getImgVehicle;
         $data->seguro = $data->vehicle->getSeguro;

         $tecnica     = technical_review::where('id_customer', $id_customer)->first();

         $anioactual  = date('Y');
         $aniocar     = $data->vehicle->year;
         $diferenciaYear = ($anioactual - $aniocar);


         if ($diferenciaYear > 3 && $diferenciaYear <= 5) {

           if (!$data->imgVehicle->url_revision_tecnica){
             $mensaje = "El vehiculo esta entre 3 y 4 años debe tener un documento tecnico cargado";
             $estatus = null;
           }else{
             $mensaje = "El vehiculo esta entre 3 y 4 años actualizado de forma satisfactoria";
           }

         } else if ($diferenciaYear > 5) {

           if (!$tecnica && !$data->imgVehicle->url_revision_tecnica){
             $mensaje=  "El vehiculo es mayor a 6 años debe poseer revision tecnica WIN y debe poseer un documento tecnico cargado";
             $estatus = null;
           }else if (!$tecnica && $data->imgVehicle->url_revision_tecnica){
             $mensaje=  "El vehiculo es mayor a 6 años debe poseer revision tecnica WIN";
             $estatus = null;
           }else if (!$data->imgVehicle->url_revision_tecnica && $tecnica){
             $mensaje=  "El vehiculo es mayor a 6 años debe poseer un documento tecnico cargado";
             $estatus = null;
           }else{
             $mensaje=  "Actualizado de forma satisfactoria";
           }

         } else {

           $mensaje = "Actualizado de forma satisfactoria";

         }


       }else {
         $mensaje = "Actualizado de forma satisfactoria";
       }

       $datos = ['id_customer' => $id_customer, 'id_proceso_validacion' => $ProcesoValidacionCond->id_proceso_validacion,
                 'estatus_proceso' => 1, 'approved' => $estatus ];
       if ($ProcesoValidacionCond){
         ProcesoValCond::find($ProcesoValidacionCond->id)->update($datos);
       }else {
        // ProcesoValCond::create($datos);
       }

       return response()->json([
           "object"   => 'sucess',
           "mensaje"  => $mensaje,
         ]);

     }

     return response()->json([
         "object"   => 'sucess',
         "mensaje"  => "Si desea que este proceso sea aprobado debe contactar con un usuario autorizado",
       ]);

    }


    function reportPDF()
    {
          $id = request()->id_office;
          if(Customer::where('id_office',$id)->exists())
          {
            $c = Customer::where('id_office',$id)->with('getTypeDocument')->first();
            $data = new stdClass();
            $data->customer = $c;
            $data->imgCustomer = $c->getImgCustomer;
            $data->papeletas = $c->getRecord;
            $data->driver = $c->getDriver;
            $data->countryDriver = $c->getDriver->getCountry;
            $data->imgDriver = $data->driver->getImgDriver;
            $data->vehicle = $data->driver->getVehicle;
            $data->imgVehicle = $data->vehicle->getImgVehicle;
            $data->seguro = $data->vehicle->getSeguro;

              $point = 0;

              foreach ($data->papeletas as $key => $value) {
                $point += $value->points_firmes;
              }


              $dp= $data->customer;
              $dni = $data->customer->dni;
              $first_name = $dp->first_name;
              $last_name = $dp->last_name;
              $licencia = $data->driver->licencia;
              $licfecven = $data->driver->date_expiration;
              $placa = $data->vehicle->number_enrollment;
              $marca = $data->vehicle->brand;
              $color = $data->vehicle->color;
              $year = $data->vehicle->model_year;
              $soatfecemi = $data->seguro->fec_emi;
              $soatfecven = $data->seguro->fec_expi;
              $enterprisesoat = $data->seguro->company;
              $classcategoria =$data->driver->category;
              $lic_frontal = $data->imgDriver->url_licen_front;
              $lic_back = $data->imgDriver->url_licen_back;

              $car_externa = $data->imgVehicle->url_image1;
              $car_externa2 = $data->imgVehicle->url_image2;
              $car_externa3 = $data->imgVehicle->url_image3;
              $car_interna = $data->imgVehicle->url_image4;
              $car_interna2 = $data->imgVehicle->url_image5;
              $tar_veh_back = $data->imgVehicle->url_tar_back;
              $tar_veh_frontal = $data->imgVehicle->url_tar_front;
              $dni_frontal = $data->imgCustomer->url_dni_front;
              $dni_back = $data->imgCustomer->url_dni_back;
              $photo_perfil = $data->imgCustomer->url_perfil;
              $soat_frontal = $data->seguro->url_soat;
              $recibo_luz = $data->imgCustomer->url_luz;
              $revision_tecnica =$data->imgDriver->url_revision_tecnica;
              $revfecemi = $data->imgCustomer->fech_emi_tecnica;
              $revfecven = $data->imgCustomer->fech_ven_tecnica;

              $pdf = PDF::loadView('external.drivers.reportDriver',compact(
                'dni',
                'first_name',
                'last_name',
                'licencia',
                'licfecemi',
                'licfecven',
                'year',
                'color',
                'placa',
                'marca',
                'enterprisesoat',
                'classcategoria',
                'soatfecemi',
                'soatfecven',
                'dni_frontal',
                'dni_back',
                'lic_frontal',
                'lic_back',
                'car_externa',
                'car_externa2',
                'car_externa3',
                'car_interna',
                'car_interna2',
                'tar_veh_back',
                'tar_veh_frontal',
                'photo_perfil',
                'soat_frontal',
                'soat_back',
                'point',
                'recibo_luz',
                'revision_tecnica',
                'revfecemi',
                'revfecven'
              ));
              return $pdf->stream('reporte.pdf');



          }else
          {
            return response()->json([
                "object"=> "error",
                "message"=>"No se encontro el ID"
            ]);
          }


      }

      public function reportePDFRecord(){
            if(Customer::where('id_office',request()->id)->exists())
            {
              $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();
              $data = new stdClass();
              $data->customer = $c;
              $data->imgCustomer = $c->getImgCustomer;
              $data->papeletas = $c->getRecord;
              $data->driver = $c->getDriver;
              $data->countryDriver = $c->getDriver->getCountry;
              $data->imgDriver = $data->driver->getImgDriver;
              $data->vehicle = $data->driver->getVehicle;
              $data->imgVehicle = $data->vehicle->getImgVehicle;
              $data->seguro = $data->vehicle->getSeguro;

              $dp = $data->customer;

              $point = 0;
              foreach ($data->papeletas as $key => $value) {
                $point +=$value->points_firmes;
              }
              $records = $data->papeletas;

              $first_name = $dp->first_name;
              $last_name = $dp->last_name;
              $dni = $dp->dni;
              $licence = $data->driver->number_license;
              $clasecate = $data->driver->category;
              $estadolic = $data->driver->status;
              $licfecven = $data->driver->date_expiration;

              $pdf = PDF::loadView('external.drivers.reportRecordDriver',compact(
                'dni',
                'first_name',
                'last_name',
                'licence',
                'clasecate',
                'estadolic',
                'licfecven',
                'records',
                'point'
              ));
              return $pdf->stream('reporteRecord.pdf');
            }else {
              return response()->json([
                  "object"=> "error",
                  "message"=>"El id no tiene record"
              ]);
            }
      }

      function saveCustomer()
      {
        $v_c = Customer::where('id_office',request()->id)->exists();
        if($v_c)
        {
          $v_c_1 = Customer::where('dni',request()->data{'dni'})->where('id_type_documents',request()->select)->where('id_office','<>', request()->id)->exists();
          if(!$v_c_1)
          {
            $v_c_2 = Customer::where('email',request()->data{'email'})->where('id_office','<>', request()->id)->exists();
            if(!$v_c_2)
            {

                $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();


              $c->first_name = request()->data{'first_name'};
              $c->last_name = request()->data{'last_name'};
              $c->id_type_documents = request()->select;
              $c->dni = request()->data{'dni'};
              $c->phone = request()->data{'phone'};
              $c->email = request()->data{'email'};
              $c->modified_by = auth()->user()->id;
              $c->save();
              return response()->json([
                  "object"=> "success",
                  "message"=>"Datos personales actualizados."
              ]);
            }else {
              return response()->json([
                  "object"=> "error",
                  "message"=>"El correo ya existe."
              ]);
            }

          }else {
            return response()->json([
                "object"=> "error",
                "message"=>"el DNI ya existe."
                ]);
          }


        }else {
          return response()->json([
              "object"=> "error",
              "message"=>"No existe el id de officina."
          ]);
        }
      }

      function saveDriver()
      {
        if(Customer::where('id_office',request()->id)->exists())
        {
          $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();
          $data = new stdClass();
          $data->customer = $c;
          $data->imgCustomer = $c->getImgCustomer;
          $data->papeletas = $c->getRecord;
          $data->driver = $c->getDriver;

          if($data->driver->id == 0)
          {
            $d = new Driver();
            $d->id_customer = $data->customer->id;
            $d->created_by = auth()->user()->id;
          }
          else {
            $d = $data->driver;
          }
          $d->modified_by = auth()->user()->id;
          $d->number_license = request()->data{'number_license'};
          $d->category = request()->data{'category'};
          $d->date_expiration = request()->data{'date_expiration'};
          $d->save();
          return response()->json([
              "object"=> "success",
              "message"=>"Datos Actulizados"
          ]);
        }else {
          return response()->json([
              "object"=> "error",
              "message"=>"No existe el id de officina."
          ]);
        }
      }

      function saveVehiculo()
      {
        if(Customer::where('id_office',request()->id)->exists())
        {
          $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();
          $data = new stdClass();
          $data->customer = $c;
          $data->imgCustomer = $c->getImgCustomer;
          $data->papeletas = $c->getRecord;
          $data->driver = $c->getDriver;
          $data->vehicle = $data->driver->getVehicle;
          if(!Vehicle::where('number_enrollment',request()->data{'number_enrollment'})->where('id_driver', '<>',$data->driver->id)->exists())
          {
            //$c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();

            if($data->vehicle->id == 0)
            {
              $d = new Vehicle();
              $d->id_driver = $data->driver->id;
              $d->created_by = auth()->user()->id;
            }else {

              $d = $data->vehicle;
            }
            $d->modified_by = auth()->user()->id;
            $d->number_enrollment = request()->data{'number_enrollment'};
            $d->brand = request()->data{'brand'};
            $d->color = request()->data{'color'};
            $d->model_year = request()->data{'model_year'};
            $d->model = request()->data{'model'};
            $d->save();

            $this->processDriver($c->id_office);

            return response()->json([
                "object"=> "success",
                "menssage"=>"Datos Actulizados"
            ]);
          }else {
            return response()->json([
                "object"=> "error",
                "menssage"=>"Ya esta registrado la placa."
            ]);
          }

        }else {
          return response()->json([
              "object"=> "error",
              "message"=>"No existe el id de officina."
          ]);
        }
      }

      function saveSeguro()
      {
        if(Customer::where('id_office',request()->id)->exists())
        {
          $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();
          $data = new stdClass();
          $data->customer = $c;
          $data->imgCustomer = $c->getImgCustomer;
          $data->papeletas = $c->getRecord;
          $data->driver = $c->getDriver;
          $data->vehicle = $data->driver->getVehicle;
          $data->vehicle = $data->driver->getVehicle;
          $data->imgVehicle = $data->vehicle->getImgVehicle;
          $data->seguro = $data->vehicle->getSeguro;

          if($data->seguro->id == 0)
          {
            $d = new seguro();
            $d->id_vehicle = $data->vehicle->id;
            $d->created_by = auth()->user()->id;
          }else {
            $d = $data->seguro;
          }
          $d->modified_by = auth()->user()->id;
          $d->company = request()->data{'company'};
          $d->number_poliza = request()->data{'number_poliza'};
          $d->seguro_by = request()->data{'seguro_by'};
          $d->state = request()->data{'state'};
          if(request()->data{'type_safe'} == "SOAT")
          {
            $d->type_safe = 1;
          }else {
            $d->type_safe = 2;
          }

          $d->fec_emi = request()->data{'fec_emi'};
          $d->fec_expi = request()->data{'fec_expi'};
          $d->save();

          return response()->json([
              "object"=> "success",
              "message"=>"Datos Actulizados"
          ]);
        }else {
          return response()->json([
              "object"=> "error",
              "message"=>"No existe el id de officina."
          ]);
        }
      }


      function createDriver()
      {
        if(!Customer::where('id_office',request()->data{'id'})->exists())
        {
          if(!Vehicle::where('number_enrollment',request()->data{'placa'})->exists())
          {
            $c = new  Customer();
            $c->id_office = request()->data{'id'};
            $c->first_name = request()->data{'first_name'};
            $c->last_name = request()->data{'last_name'};
            $c->dni = request()->data{'dni'};
            $c->id_type_documents = request()->select;
            $c->phone = request()->data{'phone'};
            $c->email = request()->data{'email'};
            $c->created_by = auth()->user()->id;
            $c->modified_by = auth()->user()->id;
            $c->save();
              $d = new Driver();
              $d->id_customer = $c->id;
              $d->id_country_driving =172;
              $d->number_license = request()->data{'number_license'};
              $d->created_by = auth()->user()->id;
              $d->modified_by = auth()->user()->id;
              $d->save();
                $v = new Vehicle();
                $v->id_driver = $d->id;
                $v->number_enrollment = request()->data{'placa'};
                $v->created_by = auth()->user()->id;
                $v->modified_by = auth()->user()->id;
                $v->save();
                return response()->json([
                    "object"=> "success",
                    "menssage"=>"se ingreso correctamente Gracias."
                ]);
          }else {
            return response()->json([
                "object"=> "error",
                "menssage"=>"La placa esta registrada."
            ]);
          }


        }else {
          return response()->json([
              "object"=> "error",
              "menssage"=>"ya existe el id de offica."
          ]);
        }
      }

      function saveDocumentos()
      {
        if(Customer::where('id_office',request()->id)->exists())
        {
          $c = Customer::where('id_office',request()->id)->with('getTypeDocument')->first();
          $data = new stdClass();
          $data->customer = $c;
          $data->imgCustomer = $c->getImgCustomer;
          $data->papeletas = $c->getRecord;
          $data->driver = $c->getDriver;
          $data->countryDriver = $c->getDriver->getCountry;
          $data->imgDriver = $data->driver->getImgDriver;
          $data->vehicle = $data->driver->getVehicle;
          $data->imgVehicle = $data->vehicle->getImgVehicle;
          $data->seguro = $data->vehicle->getSeguro;
          if($data->vehicle->id != 0)
          {
            $v = $data->vehicle;
            $v->number_enrollment = request()->data{'placa'};
            $v->model_year = request()->data{'model_year'};
            $v->created_by = auth()->user()->id;
            $v->modified_by = auth()->user()->id;
            $v->save();
            if($data->imgVehicle->id != 0)
            {
              $d = $data->imgVehicle;
              $d->date_emi_tecnica = request()->data{'date_emi_tecnica'};
              $d->date_ven_tecnica = request()->data{'date_ven_tecnica'};
              $d->date_emi_tar = request()->data{'date_emi_tar'};
              $d->created_by = auth()->user()->id;
              $d->modified_by = auth()->user()->id;
              $d->save();
            }
          }

          $this->processDriver($c->id_office);
          return response()->json([
              "object"=> "success",
              "menssage"=>"se registro correctamente."
          ]);

        }else {
          return response()->json([
              "object"=> "error",
              "menssage"=>"El id officenia no existe."
          ]);
        }
      }


      function processDriver($id_office)
      {
        $c = Customer::where('id_office',$id_office)->with('getTypeDocument')->first();
        $data = new stdClass();
        $data->customer = $c;
        $data->imgCustomer = $c->getImgCustomer;
        $data->papeletas = $c->getRecord;
        $data->driver = $c->getDriver;
        $data->countryDriver = $c->getDriver->getCountry;
        $data->imgDriver = $data->driver->getImgDriver;
        $data->vehicle = $data->driver->getVehicle;
        $data->imgVehicle = $data->vehicle->getImgVehicle;
        $data->seguro = $data->vehicle->getSeguro;
            //PROCESOS
            //foto de perfil
            if($data->imgCustomer->id != 0)
            {
              if($data->imgCustomer->url_perfil != null)
              {
                if(!ProcesoValCond::where('id_proceso_validacion',4)->where('id_customer', $c->id)->exists())
                {
                  $pv = new ProcesoValCond();
                  $pv->id_customer = $c->id;
                  $pv->id_proceso_validacion = 4;
                  $pv->id_file_driver = 23;
                  $pv->modified_by = auth()->user()->id;
                  $pv->created_by = auth()->user()->id;
                  $pv->save();
                }else {
                  $pv = ProcesoValCond::where('id_proceso_validacion',4)->where('id_customer', $c->id)->first();
                  $pv->modified_by =auth()->user()->id;
                  $pv->save();
                }
              }
            }


         //proceoso de documentos
         if($data->imgCustomer->id != 0 && $data->imgDriver->id !=0 && $data->imgVehicle->id != 0){
           if($data->imgCustomer->url_dni_back != null && $data->imgCustomer->url_dni_front != null && $data->imgDriver->url_licen_front != null
           && $data->imgDriver->url_licen_back != null && $data->imgVehicle->url_tar_front!= null && $data->imgVehicle->url_tar_back!= null)
           {
             if(!ProcesoValCond::where('id_proceso_validacion',3)->where('id_customer', $c->id)->exists())
             {
               $pv = new ProcesoValCond();
               $pv->id_customer = $c->id;
               $pv->id_proceso_validacion = 3;
               $pv->id_file_driver = 23;
               $pv->modified_by = auth()->user()->id;
               $pv->created_by = auth()->user()->id;
               $pv->save();
             }else {
               $pv = ProcesoValCond::where('id_proceso_validacion',3)->where('id_customer', $c->id)->first();
               $pv->modified_by = auth()->user()->id;
               $pv->save();
             }
           }
         }

         //antecedente
         if($data->imgCustomer->id !=0)
         {
           if($data->imgCustomer->url_antecedentes != null)
           {
             if(!ProcesoValCond::where('id_proceso_validacion',5)->where('id_customer', $c->id)->exists())
             {
               $pv = new ProcesoValCond();
               $pv->id_customer = $c->id;
               $pv->id_proceso_validacion = 5;
               $pv->id_file_driver = 23;
               $pv->modified_by = auth()->user()->id;
               $pv->created_by = auth()->user()->id;
               $pv->save();
             }else {
               $pv = ProcesoValCond::where('id_proceso_validacion',5)->where('id_customer', $c->id)->first();
               $pv->modified_by = auth()->user()->id;
               $pv->save();
             }
           }
         }

         //FOTOS DEL AUTO
         if($data->imgVehicle->id !=0)
         {
           if($data->imgVehicle->url_image1 != null && $data->imgVehicle->url_image2 != null && $data->imgVehicle->url_image3 != null)
           {
             if(!ProcesoValCond::where('id_proceso_validacion',2)->where('id_customer', $c->id)->exists())
             {
               $pv = new ProcesoValCond();
               $pv->id_customer = $c->id;
               $pv->id_proceso_validacion = 2;
               $pv->id_file_driver = 23;
               $pv->modified_by = auth()->user()->id;
               $pv->created_by = auth()->user()->id;
               $pv->save();
             }else {
               $pv = ProcesoValCond::where('id_proceso_validacion',2)->where('id_customer', $c->id)->first();
               $pv->modified_by = auth()->user()->id;
               $pv->save();
             }
           }
         }
         if(count($data->papeletas)!=0)
         {
           if(!ProcesoValCond::where('id_proceso_validacion',6)->where('id_customer', $c->id)->exists())
           {
             $pv = new ProcesoValCond();
             $pv->id_customer = $c->id;
             $pv->id_proceso_validacion = 6;
             $pv->id_file_driver = 23;
             $pv->modified_by = auth()->user()->id;
             $pv->created_by = auth()->user()->id;
             $pv->save();
           }else {
             $pv = ProcesoValCond::where('id_proceso_validacion',6)->where('id_customer', $c->id)->first();
             $pv->modified_by = auth()->user()->id;
             $pv->save();
           }
         }


         if($data->vehicle->id != 0)
         {

           if($data->vehicle->model_year != null)
           {
             $diferencia = date("Y") - $data->vehicle->model_year;
             if($diferencia <= 4)
             {
               if(!ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->exists())
               {
                 $pv = new ProcesoValCond();
                 $pv->id_customer = $c->id;
                 $pv->id_proceso_validacion = 1;
                 $pv->id_file_driver = 23;
                 $pv->modified_by = auth()->user()->id;
                 $pv->created_by = auth()->user()->id;
               }else {
                 $pv = ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->first();
                 $pv->modified_by = auth()->user()->id;
               }
               $pv->approved = null;
               $pv->save();
             }elseif ($diferencia > 4 && $diferencia <= 6) {
               if(!ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->exists())
               {
                 $pv = new ProcesoValCond();
                 $pv->id_customer = $c->id;
                 $pv->id_proceso_validacion = 1;
                 $pv->id_file_driver = 23;
                 $pv->modified_by = auth()->user()->id;
                 $pv->created_by = auth()->user()->id;
               }else {
                 $pv = ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->first();
                 $pv->modified_by = auth()->user()->id;

               }
               $pv->approved = null;
               $pv->save();
             }elseif ($diferencia == 7) {
               if(!ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->exists())
               {
                 $pv = new ProcesoValCond();
                 $pv->id_customer = $c->id;
                 $pv->id_proceso_validacion = 1;
                 $pv->id_file_driver = 23;
                 $pv->modified_by = auth()->user()->id;
                 $pv->created_by = auth()->user()->id;

               }else {
                 $pv = ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->first();
                 $pv->modified_by = auth()->user()->id;
               }
               $pv->approved = null;
               $pv->save();

             }elseif ($diferencia >= 8) {
               if(!ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->exists())
               {
                 $pv = new ProcesoValCond();
                 $pv->id_customer = $c->id;
                 $pv->id_proceso_validacion = 1;
                 $pv->id_file_driver = 23;
                 $pv->modified_by = auth()->user()->id;
                 $pv->created_by = auth()->user()->id;

               }else {
                 $pv = ProcesoValCond::where('id_proceso_validacion',1)->where('id_customer', $c->id)->first();
                 $pv->modified_by = auth()->user()->id;

               }
               $pv->approved = null;
               $pv->save();
             }
           }
         }
      }

      function saveRecord()
      {
        $record = request()->data;
        $c = Customer::where('id_office',request()->id_office)->with('getTypeDocument')->first();
        $data = new stdClass();
        $data->customer = $c;
        $data->papeletas = $c->getRecord;
        $d = $data->papeletas;
        if(count($d) == 0)
        {
          if($record!= null)
          {
            foreach ($record as $key => $value) {
              $r = new Record_Driver();
              $r->id_customer = $c->id;
              $r->cod_falta = $value{'papeleta'};
              $r->papeleta = $value{'papeleta'};
              $r->entidad = $value{'entidad'};
              $r->points_saldo = $value{'puntosFirmes'};
              $r->points_firmes = $value{'putonSaldo'};
              $r->dinfranccion = $value['fechaFalta'];
              $r->estado = $value{'estado'};
              //$r->note = $c->id;
              $r->modified_by = auth()->user()->id;
              $r->created_by = auth()->user()->id;
              $r->save();
            }
          }
          else {
            $r = new Record_Driver();
            $r->id_customer = $c->id;
            $r->estado = "NO POSEE INFRACCIONES";
            $r->points_firmes = 0;
            $r->modified_by = auth()->user()->id;
            $r->created_by = auth()->user()->id;
            $r->save();
          }
        }else {
          // $r = new Record_Driver();
          // $r->id_customer = $c->id;
          // $r->estado = "NO POSEE INFRACCIONES";
          // //$r->note = $c->id;
          // $r->modified_by = auth()->user()->id;
          // $r->created_by = auth()->user()->id;
          // $r->save();
        }

        $this->processDriver($c->id_office);

        // if(ProcesoValCond::where('id_proceso_validacion',6)->where('id_customer', $c->id)->exists())
        // {
        //   $pv = ProcesoValCond::where('id_proceso_validacion',6)->where('id_customer', $c->id)->exists();
        //   $pv->modified_by = auth()->user()->id;
        //   $pv->created_by = auth()->user()->id;
        //   $pv->save();
        // }

        return response()->json([
            "object"=> "success",
            "menssage"=>"se registro correctamente."
        ]);

      }


      public function genererateCodeEmail()
      {
        $num = rand(100000,999999);
        if(!code_email::where('code_generate',$num)->where('use', 0)->exists())
        {
          $c = new code_email();
          $c->code_generate = $num;
          $c->token = request()->token_generado;
          $c->use = 0;
          $c->save();

          $a = array('num' =>$num);
          $s = request()->email;


          Mail::send('external.drivers.emailConfirmation',$a,function($message) use ($s)
          {
             $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
             $message->to($s)->subject('Correo de confirmacion');
          });

          return response()->json([
              "object"=> "success",
              "menssage"=>"se registro correctamente.",
              "data"=> $num
          ]);
        }else
        {
          return response()->json([
              "object"=> "error",
              "menssage"=>"Intentalo nuevamente."
          ]);
        }

      }

      public  function confirmEmail()
      {
        if(!code_email::where('code_generate',request()->$num)->where('token',request()->token_generado)->exists())
        {
          $c = code_email::where('code_generate',request()->$num)->where('token',request()->token_generado)->first();
          $c->use = 1;
          $c->save();
          return response()->json([
              "object"=> "success",
              "menssage"=>"Validado correctamente."]);

        }else
        {
          return response()->json([
              "object"=> "error",
              "menssage"=>"intentalo nuevamente."
          ]);
        }
      }

      function sendmsm($phone,$num){
        $curl = curl_init();

         curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.infobip.com/sms/1/text/single",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{ \"from\":\"BIENVENIDO A LA FAMILIA DE WIN\", \"to\":\"+51".$phone."\", \"text\":\" SU CODIGO DE VERIFICACION ES ".$num." }",
          CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
            "content-type: application/json"
          ),
         ));

         $response = curl_exec($curl);
         $err = curl_error($curl);

         curl_close($curl);

         if ($err) {
          return false;
         } else {
          return true;
         }
      }

      public function confirmPhone()
      {
        $num = rand(100000,999999);
        if(!code_email::where('code_generate',$num)->exists())
        {
          $c = new code_email();
          $c->code_generate = $num;
          $c->token = request()->token_generado;
          $c->use = 0;
          $c->save();

          $this->sendmsm(request()->phone,$num);

          return response()->json([
              "object"=> "success",
              "menssage"=>"se registro correctamente.",
              "data"=> $num
          ]);
        }else
        {
          return response()->json([
              "object"=> "error",
              "menssage"=>"intentalo nuevamente."
          ]);
        }
      }




}
