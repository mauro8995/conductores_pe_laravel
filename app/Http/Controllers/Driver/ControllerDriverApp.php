<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcesoValidacion;
use App\Models\External\DriverApi;
use App\Models\External\VwProcesosTotal;
use App\Models\External\DriverDocuments;
use App\Models\External\VehicleDocuments;
use App\Models\External\ServiceArea;
use App\Models\External\ServiceType;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use App\Models\Customer\Customer;
use App\Classes\MainClass;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\General\code_email;
use Mail;
use \PDF;
use \stdClass;
use Response;
use File;
use Illuminate\Support\Facades\Storage;
use App\Models\General\State;
use App\Models\General\City;

class ControllerDriverApp extends Controller
{
  public function __construct(){
		$this->middleware('auth');
    $this->url    = config('mywinrideshare.url');
    $this->secret = config('mywinrideshare.secret');
	}

  public function DriverappPermisos(){
    $a = new stdClass();

    $a->migrar = false;
    $a->superUsuario = false;

    return $a;
  }

  //CONEXION DE JS
  public function validDriverProcess() {
   $id          =  request(){'id_office'};
   $flag        = 'false';
   $mensaje     = null;
   $user_offices =  Customer::where('id_office',$id)->first();
   $cantpvc = 0;
   if(file_drivers::where('id_customer', $user_offices->id)->exists()){
      $file_driver = file_drivers::where('id_customer', $user_offices->id)->with('getCustomer','getStatusUser')->first();

      //TRAZA DE PROCESO
      $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
      $cantpv = count($proceso_validacion);


      foreach ($proceso_validacion as $key ) {
        $proceso_val_cond    = ProcesoValCond::where('id_proceso_validacion', $key{'id'})
        ->where('id_file_drivers',$file_driver->id)->where('approved', true)->first();
        if($proceso_val_cond){
          ++$cantpvc;
        }
      }
      if ($cantpv = $cantpvc){
        $valphone = code_email::where('token', strtoupper($user_offices->phone))->where('use',1)->exists();
        $valemails = code_email::where('token', strtoupper($user_offices->email))->where('use',1)->exists();



        if (!$valphone && !$valemails){
           $mensaje .= "Debe ser validado el telefono y correo\n";
        }else if (!$valemails){
          $mensaje .= "Debe ser validado el correo\n";
        }else if (!$valphone){
         $mensaje .= "Debe ser validado el telefono\n";
        }

        if(!$file_driver->soat_frontal){
          $mensaje .= "Debe contener los documentos del SOAT\n";
        }
        if (!$file_driver->tar_veh_frontal || !$file_driver->tar_veh_back){
          $mensaje .= "Debe contener los documentos de la TARJETA VEHICULAR\n";
        }
        if (!$file_driver->dni_frontal || !$file_driver->dni_back){
          $mensaje .= "Debe contener los documentos del DNI\n";
        }
        if (!$file_driver->lic_frontal || !$file_driver->lic_back){
          $mensaje .= "Debe contener los documentos de la LICENCIA\n";
        }
        if (!$file_driver->photo_perfil ){
          $mensaje .= "Debe contener la FOTO DE PERFIL\n";
        }
        if (!$file_driver->car_externa ){
          $mensaje .= "Debe contener la FOTO DEL AUTO \n";
        }
        if ($mensaje == null){
          $flag ='true';
        }

      }
   }
    return ['flag' =>  $flag, 'mensaje' => $mensaje];

  }

   //CONEXION DE JS
  public function getModalValidate() {
   return $this->getMetadataApi();
  }

  //CONEXION DE JS
  public function getDataSending(){

     $id_office   = request()->data{'id_file_drivers_send'};
     $data        = request()->data;
     $flag ='false';
     $mensaje = null;
     $data{'serviceAreaList'} =  is_array($data{'serviceAreaList'}) ? $data{'serviceAreaList'}  : $data{'serviceAreaList'} = [$data{'serviceAreaList'}];
     $data{'serviceTypeList'} =  is_array($data{'serviceTypeList'}) ? $data{'serviceTypeList'}  : $data{'serviceTypeList'} = [$data{'serviceTypeList'}];

     $user_offices     =  Customer::where('id_office',$id_office)->first();
     //VALIDAMOS SI EXISTE EL CODIGO
     if ($user_offices){
       $id_user_offices = $user_offices->id;
       $filedriver =  file_drivers::where('id_customer',$id_user_offices)->first();
         $vehicleId = $this->sendAppDataVehicle($filedriver->id,$id_office, $data);
         if($vehicleId != false){
           $driverId = $this->sendAppDataDriver($filedriver->id,$id_office, $data, $vehicleId);
           if($driverId != false){
             $datos =[
               'id_file_drivers'=>$filedriver->id,$id_office,
               'driverid'       =>$driverId,
               'vehicleid'      =>$vehicleId,
             ];
             DriverApi::create($datos);
             $flag = 'true';
             $mensaje =  'SE APROBO EXITOSAMENTE EL CONDUCTOR';

           }
         }
     }
     return ['mensaje' => $mensaje, 'flag'=> $flag];
   }


   //INTERNA

  //APROBACION DEL VEHICULO
  public function getDataSendingVehicle(){

     $id   = request()->data{'id_file_drivers_send'};
     $data = request()->data;

     $flag ='false';
     $mensaje = null;
     $data{'serviceAreaList'} =  is_array($data{'serviceAreaList'}) ? $data{'serviceAreaList'}  : $data{'serviceAreaList'} = [$data{'serviceAreaList'}];
     $data{'serviceTypeList'} =  is_array($data{'serviceTypeList'}) ? $data{'serviceTypeList'}  : $data{'serviceTypeList'} = [$data{'serviceTypeList'}];

     foreach ($data{'serviceAreaList'}  as $v) {
       if(ServiceArea::where('id_file_drivers',$id)->exists() ){
        ServiceArea::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_area' => $v];
        ServiceArea::create($datos);
     }

     foreach ($data{'serviceTypeList'}  as $v) {
       if(ServiceType::where('id_file_drivers',$id)->exists() ){
        ServiceType::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_type' => $v];
        ServiceType::create($datos);
     }

     $filedriver =  file_drivers::where('id',$id)->with('getCustomer')->first();
     $vehicleId  = $this->sendAppDataVehicle($id,$filedriver->getCustomer->id_office, $data);

    if($vehicleId != false){

         $datosapi = [
          'id_file_drivers' => $id,
          'vehicleTypeList' => $data{'vehicleTypeList'},
          'vehicleid'=> $vehicleId,
          'tenantid' => $data{'tenantId'}
        ];

         $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
         if($driveapi){
           $update =  DriverApi::find($driveapi->id);
           $update = $update->update((array)$datosapi);
         }
         else{
           DriverApi::create($datosapi);
         }

         $flag = 'true';
         $mensaje =  'SE APROBO EXITOSAMENTE EL VEHICULO';

       }

    return ['mensaje' => $mensaje, 'flag'=> $flag];
  }

  public function getDataSendingMigrateVehicle(){

     $id   = request()->data{'id_file_drivers_send'};
     $data = request()->data;
     $dt = new \DateTime();
     $fecha = $dt->format('Y-m-d');

     $flag ='false';
     $mensaje = null;
     $data{'serviceAreaList'} =  is_array($data{'serviceAreaList'}) ? $data{'serviceAreaList'}  : $data{'serviceAreaList'} = [$data{'serviceAreaList'}];
     $data{'serviceTypeList'} =  is_array($data{'serviceTypeList'}) ? $data{'serviceTypeList'}  : $data{'serviceTypeList'} = [$data{'serviceTypeList'}];

     foreach ($data{'serviceAreaList'}  as $v) {
       if(ServiceArea::where('id_file_drivers',$id)->exists() ){
        ServiceArea::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_area' => $v];
        ServiceArea::create($datos);
     }

     foreach ($data{'serviceTypeList'}  as $v) {
       if(ServiceType::where('id_file_drivers',$id)->exists() ){
        ServiceType::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_type' => $v];
        ServiceType::create($datos);
     }

     $filedriver =  file_drivers::where('id',$id)->with('getCustomer')->first();
     $vehicleId  = $this->sendAppDataMigrateVehicle($id,$filedriver->getCustomer->id_office, $data);

    if($vehicleId != false){

        $approbastatus = $this->sendAppAprovadstatusD($id);
        $approbastatusdriver = $this->sendAppDriverappAprovadstatus($id);

        $datosapi = [
           'id_file_drivers' => $id,
           'vehicleTypeList' => $data{'vehicleTypeList'},
           'vehicleid'=> $vehicleId,
           'tenantid' => $data{'tenantId'},
           'dvehicleat' => $fecha,
           'estatusapi' => TRUE
         ];

          $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
          if($driveapi){
            $update =  DriverApi::find($driveapi->id);
            $update = $update->update((array)$datosapi);
          }
          else{
            DriverApi::create($datosapi);
          }

          $flag = 'true';
          $mensaje =  "Se actualizo correctamente el vehiculo";

       }

    return ['mensaje' => $mensaje, 'flag'=> $flag];
  }

  public function sendAppAprovadstatusD($id){
    $driverapp = DriverApi::where('id_file_drivers',$id)->first()->driverid;

    $vehicle = [
       'activated'   => true
    ];
    $vehicle = json_encode($vehicle);

    $ch = curl_init($this->setUrlApi().'/drivers/status/'.$driverapp);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$vehicle);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                   $this->setToken()
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);
      if (isset($myArray->message)){
        return $myArray->message;
      }
      return false;
  }

  public function sendAppDriverappAprovadstatus($id){
    $driverapp = DriverApi::where('id_file_drivers',$id)->first()->driverid;

    $vehicle = [
       'driverId' => $driverapp,
       'approved'   => true
    ];
    $vehicle = json_encode($vehicle);

    $ch = curl_init($this->setUrlApi().'/driver/approval-status');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$vehicle);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                   $this->setToken()
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);
      if (isset($myArray->message)){
        return $myArray->message;
      }
      return false;
  }


  public function getDriverAproveds() {
    $main   = new MainClass();
    $main   = $main->getMain();

    $t = $this->PermisosDriversApp();
    $permiso = $t->migrar;
    $superUsuario = $t->superUsuario;

    if ($superUsuario == true || $permiso == true){
      return view('external.drivers.aprovedlist', compact('main'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  //CONDUCTORES VIEW UPDATE VEHICLE MIGRADOS
  public function getDriverMigrats() {
    $main   = new MainClass();
    $main   = $main->getMain();

    return view('external.drivers.migratelist', compact('main'));
  }

  //INTERNA CONSULTA
  public function getDriverAprovedsView() {
    if (request()->ajax( )){

      $drivers=[];
      //TRAZA DE PROCESO
      $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
      $cantpv = count($proceso_validacion);
      if (request()->id_office != ""){
        $uu = Customer::where('user',request()->id_office)->first();
        $ff = file_drivers::where('id_customer',$uu->id)->first();
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)
	->where('id_file_drivers',$ff->id)
	->get();
      }else if (request()->dni_e != ""){
        $uus = Customer::where('dni',request()->dni_e)->orWhere('email',strtoupper(request()->dni_e))->orWhere('phone',request()->dni_e)->first();
        $ffs = file_drivers::where('id_customer',$uus->id)->first();
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)
	->where('id_file_drivers',$ffs->id)
	->get();
      }else{
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->get();
      }

      $file_driver  = file_drivers::whereIn('id', $procesototal)->with('getCustomer')->get();

      foreach ($file_driver as $k) {
        $default    = '<i class="glyphicon glyphicon-ban-circle"></i>';
        $final      = '<i class="glyphicon glyphicon-ok-circle"></i>';
        $driverapi  = DriverApi::where('id_file_drivers', $k->id)->first();

	$ciudad = $k->getCustomer->getCity->description;
        $vehicleid  = null;   $driverid   = null;   $migrado    = null;   $estatusapi = null;
        $documents  =  '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-ban-circle"></i><a>';
        if ($driverapi){
	  if($driverapi->documents == true){
            $documents = ($driverapi->vehicleid == null)? '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-arrow-up"></i><a>' : $final;

            if ($driverapi->vehicleid == null){
              $vehicleid  = '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'vehiculos\')" ><i class="glyphicon glyphicon-ban-circle"></i><a>';
              $driverid = $default;
            }else{
              $vehicleid = $final;
              $driverid  = ($driverapi->driverid == null) ?  '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'driver\')" ><i class="glyphicon glyphicon-ban-circle"></i><a>' : $final;
            }
          }

          $migrado    = ($driverapi->migrado    == true)? $driverapi->dmigrado : $default ;
          $estatus    = ($driverapi->estatusapi == true)? 'ok': 'ban';
          $estatusapi = ($driverapi->dmigrado)? '<a onclick="estatusUpload('.$k->getCustomer->id_office.','.$k->id.')"><i class="glyphicon glyphicon-'.$estatus.'-circle"></i><a>' :  $default;
        }



        $datos =[
          'id'          => $k->id,
          'id_off'      => $k->getCustomer->id_office,
          'sponsor'     => $k->getCustomer->email,
          'id_office'   => $k->getCustomer->phone,
          'dni'         => $k->getCustomer->dni,
          'first_name'  => $k->getCustomer->first_name,
          'last_name'   => $k->getCustomer->last_name,
	        'city'   => $ciudad,
          'documentos'  => ($documents  == null) ?  $default : $documents,
          'vehiculo'    => ($vehicleid  == null) ?  $default : $vehicleid,
          'driver'      => ($driverid   == null) ?  $default : $driverid,
          'estatusapi'  => ($estatusapi == null) ?  $default : $estatusapi,
          'migrado'    =>  ($migrado    == null) ?  $default : $migrado,
        ];

        array_push($drivers, $datos);
      }
      return response()->json([
        'data' => $drivers,
      ]);
    }

  }

  public function getDriverMigratesView(){
    if (request()->ajax( )){

      $drivers=[];
      //TRAZA DE PROCESO
      $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
      $cantpv = count($proceso_validacion);
      if (request()->id_office != ""){
        $uu = Customer::where('user',request()->id_office)->first();
        $ff = file_drivers::where('id_customer',$uu->id)->first();
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->where('id_file_drivers',$ff->id)->get();
      }else if (request()->dni_e != ""){
        $uus = Customer::where('dni',request()->dni_e)->orWhere('email',strtoupper(request()->dni_e))->orWhere('phone',request()->dni_e)->first();
        $ffs = file_drivers::where('id_customer',$uus->id)->first();
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->where('id_file_drivers',$ffs->id)->get();
      }else{
      	$procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->get();
      }

      $file_driver  = file_drivers::whereIn('id', $procesototal)->with('getCustomer')->get();

      foreach ($file_driver as $k) {
        $default    = '<i class="glyphicon glyphicon-ban-circle"></i>';
        $final      = '<i class="glyphicon glyphicon-ok-circle"></i>';
        $driverapi  = DriverApi::where('id_file_drivers', $k->id)->first();

	      $ciudad = $k->getCustomer->getCity->description;
        $vehicleid  = null;
        $driverid   = null;
        $migrado    = null;
        $estatusapi = null;
        $documents  =  '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-ban-circle"></i><a>';

        if ($driverapi){
	         if($driverapi->documents == true){
            $documents = ($driverapi->dvehicle === false) ? '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-arrow-up"></i><a>' : $final;

           if ($driverapi->dvehicle === false){
             $vehicleid = $default;
             $driverid  = $default;
           }else if ($driverapi->dvehicle == true && $driverapi->dvehicleat == null){
              $vehicleid  = '<a onclick="validarDriverProceso('.$k->getCustomer->id_office.','.$k->id.',\'vehiculos\')" ><i class="glyphicon glyphicon-arrow-up"></i><a>';
              $driverid = $default;
            }else{
              $vehicleid = $final;
              $driverid  = $default;
            }
          }

          $migrado    = ($driverapi->migrado    == true)? $driverapi->dmigrado : $default ;
          $estatus    = ($driverapi->estatusapi == true)? 'ok': 'ban';
          $estatusapi = ($driverapi->dmigrado)? '<a onclick="estatusUpload('.$k->getCustomer->id_office.','.$k->id.')"><i class="glyphicon glyphicon-'.$estatus.'-circle"></i><a>' :  $default;
        }

        $datos =[
          'id'          => $k->id,
          'sponsor'     => $k->getCustomer->email,
          'id_office'   => $k->getCustomer->phone,
          'dni'         => $k->getCustomer->dni,
          'first_name'  => $k->getCustomer->first_name,
          'last_name'   => $k->getCustomer->last_name,
	        'city'        => $ciudad,
          'documentos'  => ($documents  == null) ?  $default : $documents,
          'vehiculo'    => ($vehicleid  == null) ?  $default : $vehicleid,
          'estatusapi'  => ($estatusapi == null) ?  $default : $estatusapi,
          'migrado'     => ($migrado    == null) ?  $default : $migrado
        ];

        array_push($drivers, $datos);
      }
      return response()->json([
        'data' => $drivers,
      ]);
    }
  }

  //BUTON UP DOCUMENTOS
  public function upDocumentos() {
    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $datos       =  file_drivers::where('id',$id)->with('getCustomer')->getQuery()->first();
    $array   = [];
    $array2  = [];
    $flag    = true;
    $mensaje = 'Registrado existosamente';

    $vehicledoc = array("soat_frontal", "tar_veh_frontal", "tar_veh_back" , "car_externa");
    $driverdoc  = array("lic_frontal", "lic_back","dni_frontal","dni_back", "photo_perfil");

    foreach ($vehicledoc as $values) {
      $url = $datos->$values;
      $array[$values] = $url;
    }
    foreach ($driverdoc as $values)  {
      $url = $datos->$values;
      $array2[$values] = $url;
    }


    foreach ($array  as $key => $value) {
      $datos =  ['id_file_drivers'=> $id, 'fileurl'=> $this->fileDocumentUpload($value, $key),    'tpdocument'=> ''.$key.''];
      if ($url){
        $valorExiste = VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', ''.$key.'')->first();
        if($valorExiste){
          $update =  VehicleDocuments::find($valorExiste->id);
          $update = $update->update((array)$datos);
        }else{
          VehicleDocuments::create($datos);
        }
      }
    }

    foreach ($array2 as $key => $value) {
      $datos =  ['id_file_drivers'=> $id, 'fileurl'=> $this->fileDocumentUpload($value,$key),    'tpdocument'=> ''.$key.''];
      if ($url){
        $valorExiste = DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', ''.$key.'')->first();
        if($valorExiste){
          $update =  DriverDocuments::find($valorExiste->id);
          $update = $update->update((array)$datos);
        }else{
          DriverDocuments::create($datos);
        }
      }
    }

    $datosapi = ['id_file_drivers' => $id, 'documents' => true];
    $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
    if($driveapi){
      $update =  DriverApi::find($driveapi->id);
      $update = $update->update((array)$datosapi);
    }else{
      DriverApi::create($datosapi);
    }


    return ['flag'=>$flag, 'mensaje'=>$mensaje];


  }


  public function upDocumentosVehicle() {
    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $datos       =  file_drivers::where('id',$id)->with('getCustomer')->getQuery()->first();
    $array   = [];
    $array2  = [];
    $flag    = true;
    $mensaje = 'Actualizado existosamente';

    $vehicledoc = array("soat_frontal", "tar_veh_frontal", "tar_veh_back" , "car_externa");


    foreach ($vehicledoc as $values) {
      $url = $datos->$values;
      $array[$values] = $url;
    }


    foreach ($array  as $key => $value) {
      $datos =  ['id_file_drivers'=> $id, 'fileurl'=> $this->fileDocumentUpload($value, $key),    'tpdocument'=> ''.$key.''];
      if ($url){
        $valorExiste = VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', ''.$key.'')->first();
        if($valorExiste){
          $update =  VehicleDocuments::find($valorExiste->id);
          $update = $update->update((array)$datos);
        }else{
          VehicleDocuments::create($datos);
        }
      }
    }

    $datosapi = ['id_file_drivers' => $id, 'dvehicle' => TRUE];
    $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
    if($driveapi){
      $update =  DriverApi::find($driveapi->id);
      $update = $update->update((array)$datosapi);
    }else{
      DriverApi::create($datosapi);
    }

    return ['flag'=>$flag, 'mensaje'=>$mensaje];
  }

  //BUTTON DE Driver
  public function upDriver(){
    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $flag = 'false';
    $mensaje =  'ERROR';
    $dt = new \DateTime();
    $fecha = $dt->format('Y-m-d');

    // return $this->sendAppDataDriver($id);
    $driverid =  json_decode($this->sendAppDataDriver($id));

     if (isset($driverid->general[0]->messageCode)){
       return ['flag' => $flag , 'mensaje'=> $driverid->general[0]->message];
     }
     else{

        $datosapi = [
          'id_file_drivers' => $id,
          'driverid'   => $driverid->driverId,
          'migrado'    => true,
          'estatusapi' => true,
          'dmigrado'   => $fecha,
        ];

         $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
         if($driveapi){
           $update =  DriverApi::find($driveapi->id);
           $update = $update->update((array)$datosapi);
         }
         else{
           DriverApi::create($datosapi);
         }

         $u = file_drivers::where('id',$id)->with('getCustomer')->first();

         $a = array("nombre" => $u->getCustomer->first_name , "apellido" => $u->getCustomer->last_name, "usuario" => $u->getCustomer->user);
         $s = $u->getCustomer->email;
         Mail::send('emails.migracionapp',$a,function($message) use ($s)
         {
            $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
            $message->to($s)->subject('Bienvenido a WIN');
         });
         $this->sendmsm($u->getCustomer->phone);


         $flag = 'true';
         $mensaje =  'SE APROBO EXITOSAMENTE EL CONDUCTOR';
      }

    return ['mensaje' => $mensaje, 'flag'=> $flag];
  }

  //  INTERNA SENDING
  public function  getMetadataApi() {

      $vehicleTypeList = [];     $vehicleDocumentTypeList = [];     $serviceAreaList = [];
      $serviceTypeList = [];     $driverDocumentTypeList  = [];

      $ch = curl_init($this->setUrlApi().'/metadata');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                    $this->setToken(),
                   'Accept-Language:en'
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);

      $tenantId = $myArray->tenantId;

      foreach ($myArray->vehicleTypeList         as $k) {
        $select = [
          'value' => $k->id,
          'name'  => strtoupper($k->name),
        ];
        array_push($vehicleTypeList, $select);
      }

      foreach ($myArray->vehicleDocumentTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($vehicleDocumentTypeList, $select);
      }

      foreach ($myArray->driverDocumentTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($driverDocumentTypeList, $select);
      }

      foreach ($myArray->serviceAreaList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($serviceAreaList, $select);
      }

      foreach ($myArray->serviceTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => strtoupper($k->serviceType),
        ];
        array_push($serviceTypeList, $select);
      }

      $datosSelect =[
        'tenantId'              => $tenantId,
        'vehicleTypeList'        => $vehicleTypeList,
        'vehicleDocumentTypeList'=> $vehicleDocumentTypeList,
        'serviceAreaList'        => $serviceAreaList,
        'serviceTypeList'        => $serviceTypeList,
      ];

      return $datosSelect;
  }
  //  INTERNA
  private function convertMilisegundos($f){
    return strtotime($f) * 1000;
  }
  //  INTERNA
  private function getCurlValue($filename, $contentType, $postname){
    if (function_exists('curl_file_create')) {
      return curl_file_create($filename, $contentType, $postname);
    }

    $value = "@{$filename};filename=" . $postname;
    if ($contentType) {    $value .= ';type=' . $contentType;     }

    return $value;
  }

  //  INTERNA
  private function setUrlApi(){
    return config('mywinrideshare.enlaceapp');
  }

  //  INTERNA
  private function setToken(){
    return config('mywinrideshare.tokenapp');
  }

  //  INTERNA
  private function fileDocumentUpload($url, $key) {

      $info     = pathinfo($url);
      // $nameFile = $info['basename'];
      // $nameFile = explode('?', $nameFile);
      // $nameFile = explode('%', $nameFile[0]);
      $nameFile = $key.'.jpg';

      $contents = file_get_contents($url);
      $file = 'tmp/'.$key.'.jpg';

      // $image_resize  = Image::make($contents);
      // $image_resize->resize(600, 600);
      // $image_resize->save(public_path($file));
      file_put_contents($file, $contents);

      $uploaded_file = new File($file, $info['basename']);



      $public_path   = public_path();
      $rutaFile      = $public_path."/".$file;
      $cfile = $this->getCurlValue($rutaFile,'image/jpeg', $nameFile);
      $data = array('file[]' => $cfile);

      $ch = curl_init($this->setUrlApi().'/doc-upload');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'content-type:multipart/form-data',
              $this->setToken()
            ));

        $result   = curl_exec($ch);
        $myArray  = json_decode($result);
        if ($myArray->originalFileName){
          File::delete($rutaFile);
          return $myArray->fileId;
        }
   }

  //ESTATUS DEL CONDUSTOR
  public function driverStatusApi(){
     // return "hola";

    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $driverid    =  DriverApi::where('id_file_drivers',$id)->getQuery()->first()->driverid;
    $estatus     =  DriverApi::where('id_file_drivers',$id)->getQuery()->first()->estatusapi;
    $mensaje = null;
    $flag    = null;
    $llave   = 1;

    $statusDriver = [
       'driverId' => $driverid,
       'approved' => ($estatus == true ) ? false : true
     ];
     if ($statusDriver{'approved'} == false){
       $llave = 0;
     }


     $statusDriver = json_encode($statusDriver);

       $ch = curl_init($this->setUrlApi().'/driver/approval-status');
               curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_POSTFIELDS,$statusDriver);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'content-type:application/json',
                 $this->setToken(),
                 'Accept-Language:en'
              ));

       $result   = curl_exec($ch);
       $myArray  = json_decode($result);
       // return $result;
       if (isset($myArray->message)){

         $file_drivers   =  DriverApi::where('id_file_drivers',$id)->first();
         $estatus        =  DriverApi::find($file_drivers->id);
         $estatus->estatusapi = $llave;
         $estatus->save();

	 $customers   =	 Customer::where('id_office',request(){'id_office'})->first();
	 $customers->note = request(){'motivo'};
         $customers->save();

         $mensaje  =$myArray->message;
         $flag    = 'true';
         return ['mensaje' => $mensaje, 'flag'=> $flag];
       }

       $mensaje = 'Error al realizar actualización de estatus.';
       $flag    = 'false';
       return ['mensaje' => $mensaje, 'flag'=> $flag];

   }

  //  INTERNA SENDING
  private function sendAppDataVehicle($id, $id_office, $data){

      $tenantId         = $data{'tenantId'};
      $serviceAreaList  = $data{'serviceAreaList'};
      $serviceTypeList  = $data{'serviceTypeList'};
      $vehicleTypeList  = $data{'vehicleTypeList'};
      $id_office        = $id_office;

      $datos       =  file_drivers::where('id',$id)->with('getCustomer')->first();
      $insureF  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000002',
       'name'                  => 'Insurance Document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'soat_frontal')->first()->fileurl,
         'fileName'=>  'Insurance Document',
       ]],
      ];
      $tarVehiF = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_frontal')->first()->fileurl,
         'fileName'=> 'Registration document',
       ]],
      ];
      $tarVehiP = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_back')->first()->fileurl,
         'fileName'=> 'Registration document'
        ]]
      ];

      $vehicleDocuments[0] = $insureF;
      $vehicleDocuments[1] = $tarVehiF;
      $vehicleDocuments[2] = $tarVehiP;

      $vehicle = [
        'vehicleInfo' =>[
          'tenantId'              => $tenantId, //VALIDAR
          'vehicleTypeId'         => $vehicleTypeList, //VALIDAR
          'makeModel'             => $datos->marca,
          'modelName'             => $datos->model,
          'vehicleNumber'         => $datos->placa,
          'modelYear'             => $datos->year,
          'vehicleImage'          => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'car_externa')->first()->fileurl,
        ],
       'vehicleDocumentInfo'   => $vehicleDocuments,
       'serviceAreaIds'        => $serviceAreaList,
       'serviceTypeIds'        => $serviceTypeList
      ];
      $vehicle = json_encode($vehicle);

      $ch = curl_init($this->setUrlApi().'/add-vehicle');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$vehicle);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                   $this->setToken()
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);
      if (isset($myArray->vehicleId)){
        return $myArray->vehicleId;
      }
      return false;
  }

  //ACTUALIZAR VEHICULO
  private function sendAppDataMigrateVehicle($id, $id_office, $data){

      $tenantId         = $data{'tenantId'};
      $serviceAreaList  = $data{'serviceAreaList'};
      $serviceTypeList  = $data{'serviceTypeList'};
      $vehicleTypeList  = $data{'vehicleTypeList'};
      $id_office        = $id_office;

      $datos       =  file_drivers::where('id',$id)->with('getCustomer')->first();
      $insureF  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000002',
       'name'                  => 'Insurance Document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'soat_frontal')->first()->fileurl,
         'fileName'=>  'Insurance Document',
       ]],
      ];
      $tarVehiF = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_frontal')->first()->fileurl,
         'fileName'=> 'Registration document',
       ]],
      ];
      $tarVehiP = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_back')->first()->fileurl,
         'fileName'=> 'Registration document'
        ]]
      ];

      $vehicleDocuments[0] = $insureF;
      $vehicleDocuments[1] = $tarVehiF;
      $vehicleDocuments[2] = $tarVehiP;

      $vehicle = [
        'vehicleInfo' =>[
          'tenantId'              => $tenantId, //VALIDAR
          'vehicleTypeId'         => $vehicleTypeList, //VALIDAR
          'makeModel'             => $datos->marca,
          'modelName'             => $datos->model,
          'vehicleNumber'         => $datos->placa,
          'modelYear'             => $datos->year,
          'vehicleImage'          => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'car_externa')->first()->fileurl,
        ],
       'vehicleDocumentInfo'   => $vehicleDocuments,
       'serviceAreaIds'        => $serviceAreaList,
       'serviceTypeIds'        => $serviceTypeList
      ];
      $vehicle = json_encode($vehicle);


      $driverapp = DriverApi::where('id_file_drivers',$id)->first()->vehicleid;

      $ch = curl_init($this->setUrlApi().'/vehicles/'.$driverapp);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$vehicle);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                   $this->setToken()
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);
      if (isset($myArray->vehicleId)){
        return $myArray->vehicleId;
      }
      return false;
  }

  //  INTERNA SENDING
  private function sendAppDataDriver($id){
    $serviceAreaListQ =  ServiceArea::select(array('service_area'))->where('id_file_drivers',$id)->get()->toArray();
    $serviceTypeListQ =  ServiceType::select('service_type')->where('id_file_drivers',$id)->get()->toarray();
    $serviceTypeList =[];    $serviceAreaList =[];

    foreach ($serviceAreaListQ as $key) {
      array_push($serviceAreaList, $key{'service_area'});
    }

    foreach ($serviceTypeListQ as $key) {
      array_push($serviceTypeList, $key{'service_type'});
    }

     $datos =  file_drivers::where('id',$id)->with('getCustomer')->first();

     $dniF  = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000005',
       'name'                  => 'National card',
       'documentNumber'        => $datos->getCustomer->id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'dni_frontal')->first()->fileurl,
         'fileName'=> 'National card'
       ]],
     ];
     $dniP  = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000005',
       'name'                  => 'National card',
       'documentNumber'        => $datos->getCustomer->id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'dni_back')->first()->fileurl,
         'fileName'=> 'National card'
       ]],
     ];

     $licenciaF = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000001',
       'name'                  => 'Driving License - DL',
       'documentNumber'        => $datos->getCustomer->id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'lic_frontal')->first()->fileurl,
         'fileName'=> 'Driving License - DL'
       ]],
     ];
     $licenciaP = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000001',
       'name'                  => 'Driving License - DL',
       'documentNumber'        => $datos->getCustomer->id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'lic_back')->first()->fileurl,
         'fileName'=> 'Driving License - DL'
       ]],
     ];

     $driverDocuments[0] = $dniF;
     $driverDocuments[1] = $dniP;
     $driverDocuments[2] = $licenciaF;
     $driverDocuments[3] = $licenciaP;



     $driver = [
        'serviceAreaIds'   => $serviceAreaList,
        'serviceTypeIds'   => $serviceTypeList,
        'vehicleTypeId'    => DriverApi::where('id_file_drivers',$id)->first()->vehicleTypeList, //VALIDAR
        'vehicleId'        => DriverApi::where('id_file_drivers',$id)->first()->vehicleid,
        'driverInfo'       => [
          'tenantId'       => DriverApi::where('id_file_drivers',$id)->first()->tenantid, //VALIDAR
          'firstName'      => $datos->getCustomer->first_name,
          'lastName'       => $datos->getCustomer->last_name,
          'email'          => $datos->getCustomer->email,
          'username'        => $datos->getCustomer->user,
          'numCountryCode' => '+51',
          'phoneNum'       => $datos->getCustomer->phone,
          'userDetails'    => [
            "profileImage" => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'photo_perfil')->first()->fileurl,
            "xFlowFluidUserId" => $datos->getCustomer->id_office,
            "countryCode" => "PE",
            "stateCode" => State::where('id',$datos->getCustomer->id_state)->first()->code,
            "city" => City::where('id',$datos->getCustomer->id_city)->first()->description
          ],
         ],
        'driverDocumentInfo' => $driverDocuments,
        'approved'           => true
     ];
        //  return (($driver));
     $driver = json_encode($driver);


     $ch = curl_init($this->setUrlApi().'/add-driver');
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS,$driver);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'content-type:application/json',
                  $this->setToken()
                 ));

     $result   = curl_exec($ch);
     return $result;

    }

    public function PermisosDriversApp(){
      $rol = Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id','rol_user.id as id_roluser')
        ->first();

     $roluser = $rol{'id_roluser'};

      $t = $this->DriverappPermisos();

      $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                    ->select('id_permission')
                    ->get();

      foreach ($permissions as $rs) {
        if ($rs->id_permission == 4){
            $t->superUsuario = true;
        }else if ($rs->id_permission == 44){
             $t->migrar = true;
          }
      }

      $t->rolid = $rol{'id'};

      return $t;
    }

    function sendmsm($phone){
      $curl = curl_init();

       curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.infobip.com/sms/1/text/single",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{ \"from\":\"WIN RIDESHARE te da la bienvenida\", \"to\":\"+51".$phone."\", \"text\":\"BIENVENIDO A WIN ¡Felicitaciones, usted ha sido aprobado para conducir con WIN! ¿Esta listo para trabajar? Descargue la aplicacion e inicie sesion https://youtu.be/mBmZeuepG-o\ }",
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

function updateDatass($ids){
      	//cambiar el id
      	$u  = Customer::where('id_office',$ids)->first();
        $u_vehicle = file_drivers::where('id_customer',$u->id)->first();
        $dd = DriverApi::where('id_file_drivers',$u_vehicle->id)->first();
      	$id_app = $dd->driverid;

      	$this->updateStatusDriver_id_app($id_app);
      	$i = $this->getDriverupdate($id_app);

      	$id_api_photo_perfil = $this->fileDocumentUploads($u_vehicle->photo_perfil,$u_vehicle->id.'-'.$id_app);


      	$datosUpd['first_name'] = $u->first_name;
      	//$datosUpd['phone_number'] = '+519'.$u->phone;//-----cambiar el codigo de pais
      	//$datosUpd['email'] =  $u->email;
      	$datosUpd['last_name'] =  $u->last_name;
      	$datosUpd['public_name'] =  $u->first_name . ' ' .$u->last_name ;
        $datosUpd['public_email'] = $u->email;
      	$datosUpd['public_phone'] = '+51'.$u->phone;//-----cambiar el codigo de pais
      	$this->updateOVExterno($datosUpd, $i->driverInfo->userDetails->xFlowFluidUserId);

      	$driverDocumentInfo = [];
      	foreach ($i->driverDocumentInfo as $clave => $valor) {
              			$dri= [
                            "id"=> $valor->id,
                            "createdAt"=> $valor->createdAt,
                            "updatedAt"=> $valor->updatedAt,
                            "documentNumber"=> $valor->documentNumber,
                            "dateOfIssue"=> $valor->dateOfIssue,
                            "dateOfExpiry"=> $valor->dateOfExpiry,
                            "documentFileIds"=> [
                                                    [
                                                        "createdAt"=> 0,
                                                        "updatedAt"=> 0,
                                                        "fileUrl"=> $valor->documentFileIds[0]->fileUrl,
                                                        "bucketId"=> null,
                                                        "fileSize"=> 0
                                                    ]
                                                ],
                            "driverDocumentTypeId"=> $valor->driverDocumentTypeId,
                            "userId"=> $valor->userId,
                            "documentFile"=> $valor->documentFile,
                        ];
                	array_push($driverDocumentInfo,$dri);

                	}

              	$tenantServiceAreas = [];

              	foreach ($i->tenantServiceAreas as $clave => $valor) {
                      			$dri= [
                                          "id"=> $valor->serviceAreaId,
                                        ];
              	array_push($tenantServiceAreas,$dri);

              	}



	         $data = [
                "driverInfo"=>[
                    "tenantId"=> "T0001",//cambiar depende del pais
                    "email"=> $u->email,
                    "phoneNum"=> $u->phone,
                    "firstName"=> $u->first_name,
                    "middleName"=> "",
                    "lastName"=> $u->last_name,
                    "updatedAt"=> $i->driverInfo->updatedAt,
                    "numCountryCode"=> $i->driverInfo->numCountryCode,
                    "companyId"=> null,
                    "username"=>$i->driverInfo->username,
                    "userDetails"=> [
                        "addressLine1"=> "",
                        "addressLine2"=> "",
                        "countryCode"=> "",
                        "cityId"=> "",
                        "zipcode"=> "",
                        "poBox"=> "",
                        "profileImage"=> $id_api_photo_perfil['data']->fileId,
                        "transmissionType"=> "",
                        "referralCode"=> $i->driverInfo->userDetails->referralCode,
                        "xFlowFluidUserId"=>$i->driverInfo->userDetails->xFlowFluidUserId,
                    ]
                    ],
                    "driverDocumentInfo"=> $driverDocumentInfo ,
                   "tenantServiceAreas"=>$tenantServiceAreas ,
                    "serviceTypeIds"=> $i->serviceTypeIds,
                    "vehicleTypeId"=> $i->vehicleTypeId,
                    "vehicleId"=> $i->vehicleId
            ];


            $data  = json_encode($data);
            $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->setUrlApi()."/drivers/".$id_app,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                $this->setToken()
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        		//return $this->secret;
        		$this->updateactivate($id_app);
        		return response()->json(["object"=>"success","data"=>$response]);

}

public function updateStatusDriver_id_app($id){
    $data = [
        "driverId"=>$id,
        "approved" =>true
    ];
    $d = json_encode($data);

            $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $this->setUrlApi()."/driver/approval-status",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS =>$d,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        $this->setToken(),
        "Accept-Language: en"
    ),
    ));

    $response = curl_exec($curl);

        curl_close($curl);
        $myArray  = json_decode($response);
        if ( isset($myArray->message)){
            return response()->json(["object"=>"success","data"=>$myArray]);
        }
        return response()->json([
            "object"=>"error",
            "message"=>"Error Api OV."]);
}

function getDriverupdate($d){
	$curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $this->setUrlApi()."/drivers/".$d,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      $this->setToken(),
      "content-type: application/json"
    ),
  ));


    $response = curl_exec($curl);
    curl_close($curl);
  	return json_decode($response);
}

function updateactivate($id_app){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->setUrlApi()."/drivers/status/".$id_app,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS =>"{    \n\"activated\":true\n} ",
      CURLOPT_HTTPHEADER => array(
        $this->setToken(),
        "Accept-Language: en",
        "Content-Type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return $response ;

}

function download_image_store($url,$key)
    {

        $image = file_get_contents($url);
        if ($image !== false){

            //return response()->json(Storage::disk('local')->put($key.'.jpg', $image));
            if(Storage::disk('local')->put($key.'.jpg', $image)){
                    Image::make(storage_path('app/'.$key.'.jpg'))->resize(500, 400)->save(storage_path('app/'.$key.'.jpg'));
                    return true;
            }
            return false;
        }
        return false;
    }


private function fileDocumentUploads($url, $key) {

        if($this->download_image_store($url, $key))  {
            $nameFile = $key.'.jpg';
            $rutaFile      = storage_path('app/'.$nameFile);
            $cfile = $this->getCurlValue($rutaFile,'image/jpeg', $nameFile);
            $data = array('file[]' => new \CURLFile(storage_path('app/'.$nameFile),'image/jpeg', $nameFile));

            $curl = curl_init();

            curl_setopt_array($curl, array(
                  CURLOPT_URL => $this->setUrlApi()."/doc-upload",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_POST, true,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $data ,
                  CURLOPT_HTTPHEADER => array(
                    "content-type: multipart/form-data",
                    $this->setToken()
                  ),
                ));

                $response = curl_exec($curl);

                File::delete($rutaFile);
                $myArray  = json_decode($response);
                if(isset($myArray->fileId)){
                  return ["object"=>true,"data"=>$myArray];
                } else {
                  return ["object"=>false,"data"=>$response ,"ds"=>curl_errno($curl),"ds1"=>curl_getinfo($curl),"ds2"=>curl_error($curl)];
                }

            }else{
              return ["object"=>false];
            }
  }

  public function updateOVExterno($datosUpd, $id)
      {
         $object;
         $datosUpd['userid']  = $id;
         $data  = json_encode($datosUpd);

         $urlComplete  = $this->generateURLSignature('user_update');

         $ch   = curl_init($urlComplete);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'content-type:application/json',
                 'secret: '.$this->secret
         ));
         $result         = curl_exec($ch);
         $myArray        = json_decode($result);

          if($myArray->status == '200' ){
            $object = 'success';
          }else {
            $object = 'error';
          }
          return $myArray        ;
       }

  public function generateURLSignature($action)
  {
        $url    = $this->url.'/'.$action;
        $secret = $this->secret;
        $expired = time() + 300;
        $url .= '?expires=' . $expired;
        $signature = hash_hmac('sha256', $url, $secret, false);
        return $url . '&signature=' . $signature;
  }

}
