<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Driver\Driver;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\Type_document_identy;
use App\Models\General\City;
use App\Models\Driver\Vehicle;
use App\Models\Driver\TypeBodywork;
use App\Classes\MainClass;
use App\Models\General\Pay;
use App\Models\General\Status;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Customer\dtCustomerType;
use Illuminate\Database\Eloquent\Builder;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\External\Record_Driver;
use App\Models\External\RangoRecord;
use App\Models\External\ProcessModel;
use App\Models\External\ProcessTrace;
use App\Models\General\User;
use App\Models\External\ProcesoValCond;
use App\Models\External\technical_review;
use App\Models\External\ProcesoValidacion;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\General\Main;
use App\Models\General\Rol_permissions;
use App\Models\External\Driver\eventoData;
use \PDF;
use \stdClass;
use Response;
use App\Models\Views\vw_user_offices;
use App\Models\General\code_email;
use Mail;
class ControllerDriver extends Controller
{
  public function __construct(){
	$this->middleware('auth');
    	$this->url    = config('mywinrideshare.url');
    	$this->secret = config('mywinrideshare.secret');
  }

  public function DriverPermisos(){
    $a = new stdClass();

    $a->antecedentes = false;
    $a->superUsuario = false;

    return $a;
  }

  public function index(){

    if(auth()->user()){
      $main = new MainClass();
      $main = $main->getMain();

       $title ='Conductores';

       $drivers = Driver::where('status_system', '=', 'TRUE')
       ->orderBy('created_at', 'asc')
       ->get();

      $pay           = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');


      $status        = Status::select(DB::raw("UPPER(description) AS description"), "id")->orderBy('description', 'ASC')->pluck('description', 'id');


      $customer       =  dtCustomerType::select(DB::raw("UPPER(CONCAT(dni, ' - ', last_name,'  ', first_name)) AS name"), "customers.id as id")
                        ->join('customers', 'dt_customer_types.id_customer', '=', 'customers.id')
                        ->where('dt_customer_types.id_customerType', '=' ,'4')
                        ->orderBy('name',  'ASC')
                        ->pluck( '(last_name||" " ||first_name)as name', 'customers.id as id');




      $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');
      $country  = Country::WHERE('status_user', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');


      return view('driver.index',compact('drivers','title', 'country','pay','status','customer','modified_by' , 'main'));
    }

  }

  public function getDataDriver(){
    $start_datec    = request()->start_datec ? request()->start_datec." 00:00:00.0000-05" : null;
    $end_datec      = request()->end_datec   ? request()->end_datec." 23:59:59.0000-05"   : null;

    $start_datep     = request()->start_datep ? request()->start_datep." 00:00:00.0000-05" : null;
    $end_datep       = request()->end_datep   ? request()->end_datep." 23:59:59.0000-05"   : null;
  }

  public function store(){
     $data = request()->validate([
       'dni'          => 'unique:drivers',
     ], [
       'dni.unique'     => 'Ya existe este dato en el registro',
     ]);

    //Driver::create($data);
    return  redirect()->route('driver.index');
  }

  public function show($driver){
    $main = new MainClass();
    $main = $main->getMain();
    $title = 'Detalle Conductor';


    $driver = Driver::
      where('status_system', '=', 'TRUE')
    ->where('id', '=', $driver)
    ->orderBy('created_at', 'asc')
    ->with('getCityDriver')
    ->with('getContryNationality')
    ->with('getContryAddress')
    ->with('getStateAddress')
    ->with('getCityAddress')
    ->with('getVehicle')
    ->first();

    if ($driver == null){
      return view('errors.404Null', compact('main', 'title'));

    }else{
      $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      $state          = State::where('id_country', '=', $driver->id_country_address)->orderBy('description', 'ASC')->pluck('description', 'id');
      $city           = City::where('id_state', '=',    $driver->id_state_address  )->orderBy('description', 'ASC')->pluck('description', 'id');
      return view('driver.show', compact('driver',  'country', 'state','city', 'main'));
    }
  }

  public function edit($driver){
    $main = new MainClass();
    $main = $main->getMain();

    $driver = Driver::
      where('status_system', '=', 'TRUE')
    ->where('id', '=', $driver)
    ->orderBy('created_at', 'asc')
    ->with('getVehicle')
    ->first();

    $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $state          = State::where('id_country', '=', $driver->id_country_address)->orderBy('description', 'ASC')->pluck('description', 'id');
    $city           = City::where('id_state', '=',    $driver->id_state_address  )->orderBy('description', 'ASC')->pluck('description', 'id');
    return view('driver.edit', compact('driver',  'country', 'state','city', 'main'));

  }

  public function update(Driver $driver){
    $data = request()->validate([
      'name'         => 'required',
      'lastname'     =>'',
      'email'        => 'required',
      'birthdate'    => '',
      'phone'        => '',
      'gender'       => '',
      'id_country_address'  => '',
      'id_state_address'    => '',
      'id_city_address'     => '',
      'id_city_driver'      => '',
      'address'             => '',
      'id_nationality'      => '',
      'model_year' => 'required',


    ], [
      'name.required'  => 'Este campo es obligatorio',
      'dni.unique'     => 'Ya existe este dato en el registro',
      'email.required' => 'Este campo es obligatorio',
    ]);
    $dataVehicle = request()->validate([
      'model_year' => '',
      'model'      => '',
      'color'      => '',
      'serial'     => '',
      'plate'      => '',
      'note'        => '',
    ], [
      'model_year.required'  => 'Este campo es obligatorio',
    ]);
    $driver->update($data);
    Vehicle::where('id_driver', '=', $driver->id)->update($dataVehicle);

    return  redirect()->route('driver.show', ['driver'=>$driver->id]);
  }

  public function storeVehicle(){
     $data = request()->validate([
       'model_year' => 'required',
       'model'      => 'required',
       'color'      => 'required',
       'serial'     => 'required',
       'plate'      => 'required',
       'note'        => '',
       'id_driver'  => 'required',
     ], [
       'model_year.required'  => 'Este campo es obligatorio',
     ]);
    Vehicle::create($data);

    return  redirect()->route('driver.index');
  }

  public function createDriverView()
  {
    $main = new MainClass();
    $main = $main->getMain();

      if (true){
        $t =  TypeBodywork::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
            $country        = Country::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
        return view('driver.create', compact('main','country',"t"));

      }else{
        return view('errors.403', compact('main'));
      }
  }

  public function createDriver()
  {

    $customer = request(){'customer'};
    $driver = request(){'driver'};
    $vehiculo = request(){'vehicle'};
    if(!Driver::where('id_customer',$customer{'id'})->exists())
    {
      return response()->json([
        'object'  => "error",
        'message' => "No esta registrado el cliente que estas ingrrsando"
      ]);
    }else
    {
     $id_customer =  $customer{'id'};

     $dr = new Driver();
     $dr->number_license=$driver{'number_license'};
     $dr->category=$driver{'category'};
     $dr->id_country_driving=$driver{'cod_country_driver'};
     $dr->date_expiration=$driver{'date_exp'};
     $dr->points_limit=100;
     $dr->id_customer=$id_customer;
     if(!Driver::where('id_customer',$id_customer)->exists())
     $dr->save();

     $cd = new dtCustomerType();
     $cd->id_customerType = 1;
     $cd->id_customer = $id_customer;
     $cd->create_by = auth()->user()->id;
     if(!dtCustomerType::where('id_customer',$id_customer)->exists())
     $id_driver = $cd->save()->id;
     else $id_driver = Driver::where('id_customer',$id_customer)->first()->id;

     $ve = new Vehicle();
     $ve->number_enrollment= $vehiculo{'matricula'};
     $ve->brand= $vehiculo{'brand'};
     $ve->model= $vehiculo{'model'};
     $ve->color= $vehiculo{'color'};
     $ve->nro_doors= $vehiculo{'nro_doors'};
     $ve->model_year= $vehiculo{'model_year'};
     $ve->id_typebodyworks = 1;
     $ve->id_driver= $id_driver;
     $ve->id_customer_owner= $id_customer;
     if(!vehicle::where('id_driver',$dr->id)->exists() || !vehicle::where('number_enrollment',$vehiculo{'matricula'})->exists())
     $ve->save();

     return response()->json([
       'object'  => "success",
       'message' => "creado."
     ]);

    }

  }

  public function getCustomer()
  {
    if(Customer::where('dni',request()->dni)->exists())
      return response()->json([
       'object'  => "success",
       'data'    => Customer::where('dni',request()->dni)->first()
     ]);
     else
     {
       $val  = $this->reniecPeruApi2(request()->dni);
       $val2 =  $this->reniecPeruApi1(request()->dni);

       if ($val->object == true){
         $data = $val;
       }else if ($val2->object == true){
         $data  = $val2;
       }else{
         $a = new stdClass();
         $a->first_name = null;
         $a->last_name  = null;
         $a->message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
         $data = $a;
       }

       return response()->json([
        'object'  => "error",
         'message' =>"No existe la persona por favor registra.<a href='/customer/new' target='_blank'> Registrar </a>. ",
         'data'   => $data
      ]);
     }
  }

  public function getCustomerValidate(){
    $typesearc = request()->search;
    if (Customer::where('dni',request()->dni)->where('id_type_documents',request()->type)->exists()){
        $data = Customer::where('dni',request()->dni)->where('id_type_documents',request()->type)->with('getDtTypeCustomer','getCountry','getState','getCity')->first();

        if ($typesearc == "Conductor"){
          if (file_drivers::where('id_customer',$data->id)->exists()){
            $datacond = file_drivers::where('id_customer',$data->id)->first();
            $message = 'CONDUCTOR ENCONTRADO CORRECTAMENTE';
            $object = 'success';
            $type = 2;
          }else{
            $message = 'NO SE ENCUENTRA REGISTRADO COMO CONDUCTOR';
            $object = 'error';
            $datacond = null;
            $type = $data->getDtTypeCustomer->id_customerType;
          }
        }else if($typesearc == "Accionista"){
          $datas    =  array(
                    "dni"                => "".request()->dni."",
                    "id_type_documents"  => 1);
          $string  = json_encode($datas);
          $datos   = json_decode($string);

          $ch = curl_init('https://wintecnologies.com/api/customer/getAPICustomer');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                );
            $cQ = curl_exec($ch);
            $datos  = json_decode($cQ);

          if ($datos->object == "success"){
            $object  = "success";
            $message = $datos->message;
            $datacond = null;
            $type = 3;
          }else{
            $message = $datos->message;
            $object = "error";
            $datacond = null;
            $type = $data->getDtTypeCustomer->id_customerType;
          }
        }else{
          $message  = 'CLIENTE ENCONTRADO CORRECTAMENTE';
          $datacond = null;
          $object   = 'success';
          if ($typesearc == "Pasajero"){
            $type = 3;
          }else{
            $type = 1;
          }
        }
        return response()->json([
         'object'   => $object,
         'data'     => $data,
         'datacond' => $datacond,
         'type'     => $type,
         'message'  => $message,
         'portal'   => 'interno'
        ]);
    }else{
      if ($typesearc == "Pasajero"){
        $data1    =  array(
                  "dni"                => "".request()->dni."",
                  "id_type_documents"  => request()->type);
        $string  = json_encode($data1);

        $ch = curl_init('https://pasajeros.wintecnologies.com/api/customer/getPassenger');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
                  'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
              );
          $cQ = curl_exec($ch);
          $datos  = json_decode($cQ);

          if ($datos->object == "error"){
          if (request()->type == 1){
             $val  = $this->reniecPeruApi2(request()->dni);
             $val2 =  $this->reniecPeruApi1(request()->dni);
             if ($val->object == true){
               $data = $val;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else if ($val2->object == true){
               $data  = $val2;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else{
               $a = new stdClass();
               $a->first_name = null;
               $a->last_name  = null;
               $a->date_birth = null;
               $data = $a;
               $object = "error";
               $message = "EL DNI NO SE ENCUENTRA";
             }
          }else{
            $a = new stdClass();
            $a->first_name = null;
            $a->last_name  = null;
            $a->date_birth = null;
            $data = $a;
            $object = "success";
            $message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          }

          return response()->json([
            'object'  => $object,
            'message' => $message,
            'type'    => 3,
            'data'    => $data,
            'portal'  => 'reniec'
         ]);
        }else{
          $data = $datos->data;
          $object  = $datos->object;
          $message = $datos->message;
          $type = 3;

           return response()->json([
            'object'  => $object,
            'message' => $message,
            'type'    => $type,
            'data'    => $datos->data,
            'portal'  => 'webpasajero'
          ]);
        }
      }

      if($typesearc == "Usuario" || $typesearc == "Embajador"){
          if (request()->type == 1){
             $val  = $this->reniecPeruApi2(request()->dni);
             $val2 =  $this->reniecPeruApi1(request()->dni);
             if ($val->object == true){
               $data = $val;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else if ($val2->object == true){
               $data  = $val2;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else{
               $a = new stdClass();
               $a->first_name = null;
               $a->last_name  = null;
               $a->date_birth = null;
               $a->dni = null;
               $data = $a;
               $object = "error";
               $message = "EL DNI NO SE ENCUENTRA";
             }
          }else{
            $a = new stdClass();
            $a->first_name = null;
            $a->last_name  = null;
            $a->date_birth = null;
            $a->dni = null;
            $data = $a;
            $object = "success";
            $message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          }

          if ($typesearc == "Usuario"){
            $tpe = 1;
          }else if ($typesearc == "Embajador"){
            $tpe = 5;
          }

          return response()->json([
              'object'  => $object,
              'message' => $message,
              'type'    => $tpe,
              'data'    => $data,
              'portal'  => 'reniec'
           ]);
       }

       if($typesearc == "Accionista"){
           $data    =  array(
                     "dni"                => "".request()->dni."",
                     "id_type_documents"  => 1);
           $string  = json_encode($data);
           $datos   = json_decode($string);

           $ch = curl_init('https://wintecnologies.com/api/customer/getAPICustomer');
                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                     'Content-Type: application/json',
                     'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                 );
             $cQ = curl_exec($ch);
             $datos  = json_decode($cQ);

           if ($datos->object == "success"){
             $data    = $datos->data;
             $object  = "success";
             $message = $datos->message;
             $type = 3;
           }else{
             $a = new stdClass();
             $a->first_name = null;
             $a->last_name  = null;
             $a->date_birth = null;
             $data = $a;
             $message = $datos->message;
             $object = "error";
             $type = 1;
           }

           return response()->json([
             'object'  => $object,
             'message' => $message,
             'type'    => $type,
             'data'    => $data,
             'portal'  => 'webpasajero'
          ]);
        }

        if ($typesearc == "Conductor"){
          $data = null;
          $message = 'NO SE ENCUENTRA REGISTRADO COMO CONDUCTOR';
          $datacond = null;
          $object = 'error';

          return response()->json([
           'object'   => $object,
           'data'     => $data,
           'datacond' => $datacond,
           'type'     => 1,
           'message'  => $message,
           'portal'   => 'valconductor'
          ]);
      }

  }
}

  public function reniecPeruApi2($dni)
  {
    $url = 'https://ww1.essalud.gob.pe/sisep/postulante/postulante/postulante_obtenerDatosPostulante.htm?strDni='.$dni;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close( $ch );

     $result = [
       'result'       => $result,
       'status'       => $httpStatus
     ];

     if($result{'status'}==200)
     {
       $validatedni = file_get_contents('https://ww1.essalud.gob.pe/sisep/postulante/postulante/postulante_obtenerDatosPostulante.htm?strDni='.$dni, true);
       $dnival = json_decode($validatedni);
       $a = new stdClass();
       if ($dnival->DatosPerson[0]->ApellidoPaterno != "")
       {
         $timestamp = strtotime(str_replace('/', '-', $dnival->DatosPerson[0]->FechaNacimiento));
         $a->first_name = $dnival->DatosPerson[0]->Nombres;
         $a->last_name  = $dnival->DatosPerson[0]->ApellidoPaterno.' '.$dnival->DatosPerson[0]->ApellidoMaterno;
         $a->date_birth  = date("Y-m-d", $timestamp);
         $a->message    = "CORRECTO DNI ENCONTRADO";
         $a->dni = $dni;
         $a->object = true;
       }else{
         $a->object = false;
         $a->first_name = null;
         $a->last_name = null;
         $a->date_birth = null;
         $a->dni = null;
         $a->message = "El DNI ES INVALIDO O ES MENOR DE EDAD";
       }
       return $a;
     }else {
       $a = new stdClass();
       $a->object = false;
       return $a;
     }
  }

  public function reniecPeruApi1($dni){
      $url = 'http://taxiwin.wsdatosperu.com/reniec_dni.php?dni='.$dni;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
      curl_close( $ch );

       $result = [
         'result'       => $result,
         'status'       => $httpStatus
       ];

      if($result{'status'}==200)
      {
        $validatedni = file_get_contents('http://taxiwin.wsdatosperu.com/reniec_dni.php?dni='.$dni, true);
        $dnival = json_decode($validatedni);

        $a = new stdClass();
        if (isset($dnival->listaAni[0]))
        {
          $timestamp = strtotime(str_replace('/', '-', $dnival->listaAni[0]->feNacimiento));
          $a->first_name = $dnival->listaAni[0]->preNombres;
          $a->last_name = $dnival->listaAni[0]->apePaterno.' '.$dnival->listaAni[0]->apeMaterno;
          $a->date_birth  = date("Y-m-d", $timestamp);
          $a->dni = $dni;
          $a->message    = "CORRECTO DNI ENCONTRADO";
          $a->object = true;
        }else{
          $a->object = false;
          $a->first_name = null;
          $a->last_name = null;
          $a->date_birth = null;
          $a->dni = null;
          $a->message = "El DNI ES INVALIDO O ES MENOR DE EDAD";
        }
      return $a;
    }else {
      $a = new stdClass();
      $a->object = false;
      return $a;
    }
  }

  function getReniecApi3(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/api/AfiliadoApi/GetNombresCiudadano');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"CODDNI\":\"46658592\"}");

    $headers = array();
    $headers[] = 'Requestverificationtoken: 30OB7qfO2MmL2Kcr1z4S0ttQcQpxH9pDUlZnkJPVgUhZOGBuSbGU4qM83JcSu7DZpZw-IIIfaDZgZ4vDbwE5-L9EPoBIHOOC1aSPi4FS_Sc1:clDOiaq7mKcLTK9YBVGt2R3spEU8LhtXEe_n5VG5VLPfG9UkAQfjL_WT9ZDmCCqtJypoTD26ikncynlMn8fPz_F_Y88WFufli38cUM-24PE1';
    $headers[] = 'Content-Type: application/json;chartset=utf-8';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
  }

  public function getnationality()
  {
     return Country::where('id',request()->id_country)->first();
   }

  public function listshow()
  {
     $main = new MainClass();
     $main = $main->getMain();

     $rol= Main::where('users.id', '=', auth()->user()->id)
       ->where('main.status_user', '=', 'TRUE')
       ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
       ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
       ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
       ->join('users',    'users.id',              '=',   'rol_user.id_user')
       ->select('roles.id')
       ->first();

      $rolid = $rol->id;

      $sponsors  = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "users.id")
                      ->where('note', '<>', '1')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

      //$statususeroffices  = vw_user_offices::distinct('form_status')->orderBy('form_status', 'ASC')->pluck('form_status', 'form_status');

       if (true){
         return view('external.drivers.list', compact('main','rolid','sponsors'));
       }else{
         return view('errors.403', compact('main'));
       }
   }

  public function getFile()
  {
     return file_drivers::where('status_system',1)->with('getUserOffice')->get();
       //return file_drivers::where('status_user',1)->with('getUserOffice');
   }

  public function getimgfile()
  {
   return file_drivers::where('id',2)->with('getUserOffice')->first();

     //return file_drivers::where('status_user',1)->with('getUserOffice');
 }

 public function detailshow()
 {


   $type_docs  = Type_document_identy::select(DB::raw("UPPER(description) AS description"), "id")->orderBy('description', 'ASC')->pluck('description', 'id');
   $editar ='false';

   $rol  = Main::where('users.id', '=', auth()->user()->id)
     ->where('main.status_user', '=', 'TRUE')
     ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
     ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
     ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
     ->join('users',    'users.id',              '=',   'rol_user.id_user')
     ->select('roles.id')
     ->first();
   $main = new MainClass();
   $main = $main->getMain();

    if ($rol->id == 7 || $rol->id == 10){
        return view('errors.403', compact('main'));
    }else{
       $id = request()->id;
       if(Customer::where('id_office',$id)->exists()){
         $u =  Customer::where('id_office',$id)->first();

         if(Record_Driver::where('id_customer', $u->id)->exists()) {
           $pg = Record_Driver::where('id_customer', $u->id)->get();
           $pun = 0;
           foreach ($pg as $key => $value) {
            $pun+= $value->points_firmes;
           }
           $statusrecord = true;
         } else{
           $pun = "-";
           $statusrecord = false;
         }

         if(file_drivers::where('id_customer', $u->id)->exists()) {

           $file = file_drivers::where('id_customer', $u->id)->first();

           $rol= Main::where('users.id', '=', auth()->user()->id)
           ->where('main.status_user', '=', 'TRUE')
           ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
           ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
           ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
           ->join('users',    'users.id',              '=',   'rol_user.id_user')
           ->select('roles.id')
           ->first();




        }

       }

       if ($rol->id == 7){
         $DriverQuery = file_drivers::where('id_customer', $u->id)
                        ->join('customers', 'customers.id', '=','file_drivers.id_customer')
                        ->where('customers.created_by', '=', auth()->user()->id)
                        ->with('getCustomer','getStatusUser','getTecnical','getDriverApi')
                        ->get();
       } else {
           $DriverQuery =  file_drivers::where('id_customer', $u->id)
                         ->with('getCustomer','getStatusUser','getTecnical', 'getDriverApi')
                         ->get();
           $editar = 'true';

       }

       $anioactual  = date('Y');
       $aniocar     = $file->year;
       $pun = 0;
       $statusrecord = true;
       $editar = 'true';
       $diferenciaYear = ($anioactual - $aniocar);

       $id  =  request()->id;
       $uo =  Customer::where('id_office',$id)->first();
       $iduser = file_drivers::where('id_customer', $uo->id)
                ->join('customers', 'customers.id', '=','file_drivers.id_customer')
                ->join('technical_reviews','technical_reviews.id_file_drivers', '=', 'file_drivers.id')->first();

       return view('external.drivers.detalle', compact('main','id', 'DriverQuery', 'pun','statusrecord', 'type_docs', 'editar','iduser','diferenciaYear'));
     }

 }

 public function deleteProcessValid(Request $request){
   $id_proceso_validacion =  $request->id;
   $ProcesoValidacion  = ProcesoValCond::find($id_proceso_validacion);
   $ProcesoValidacion->delete();

   return response()->json([
       "object"   => 'sucess',
       "mensaje"  => 'Se elimino correctamente',
   ]);

 }

 public function permisosProcessValid(){
  $id_proceso_validacion    =  request()->id;
  $estatus                  =  request()->estatus;
  $idfiledrivers            =  request()->idfiledrivers;
  $descrip                  =  request()->descri;

  $ProcesoValidacion  = ProcesoValidacion::find($id_proceso_validacion);
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
  $rol_permiso        = Rol_permissions::where('id_roluser', '=', $roluser)->where('id_permission', $permiso)->orWhere('id_permission',4)->first();

  if($rol_permiso){
    $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',$id_proceso_validacion)
    ->where('id_file_drivers', $idfiledrivers)->first();
    if ($id_proceso_validacion == 1){
      $file_divers = file_drivers::find($idfiledrivers);
      $tecnica     = technical_review::where('id_file_drivers', $idfiledrivers)->first();

      $anioactual  = date('Y');
      $aniocar     = $file_divers->year;
      $diferenciaYear = ($anioactual - $aniocar);

      $mescar = $resultado = substr($file_divers->placa, -1);
      $mesact = date('m');
      $diferenciames = ($mesact - $mescar);


      if (($diferenciaYear > 3 && $diferenciaYear <= 5 && $file_divers->type_soat == "TAXI") || ($diferenciaYear > 4 && $diferenciaYear <= 5 && $file_divers->type_soat != "TAXI")) {

        if (!$file_divers->revision_tecnica){
          $mensaje = "El vehiculo esta entre 3 y 4 años debe tener un documento tecnico cargado";
          $estatus = null;
        }else{
          $mensaje = "El vehiculo esta entre 3 y 4 años actualizado de forma satisfactoria";
        }

      } else if ($diferenciaYear > 5) {

        if (!$file_divers->revision_tecnica){
          $mensaje=  "El vehiculo es mayor a 6 años debe poseer un documento tecnico cargado";
          $estatus = null;
        }else{
          $mensaje=  "Actualizado de forma satisfactoria";
        }

      } else {

        $mensaje = "Actualizado de forma satisfactoria";

      }

      $u = file_drivers::where('id',$idfiledrivers)->with('getCustomer')->first();
      if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $u->getCustomer->first_name , "apellido"=> $u->getCustomer->last_name, "mensaje" => "que el veh�culo con el que se ha registrado no cumple con los par�metros F�sicos  internos establecidos por la empresa.");
        $s = $u->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });
      }else if ($estatus == null){
        $a = array("nombre" => $u->getCustomer->first_name." ".$u->getCustomer->last_name  , "mensaje" => $descrip);
        $s = $u->getCustomer->email;
        Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN RIDESHARE');
           $message->to($s)->subject('WIN RIDESHARE | Te notifica');
        });
      }
    }else if ($id_proceso_validacion == 3) {

      $userofs  = file_drivers::where('id', $idfiledrivers)->with('getCustomer')->first();

      if (code_email::where('token', $userofs->getCustomer->phone)->where('use',1)->exists()){
          $valphone = 1;
      }else{
          $valphone = 0;
      }


      if (code_email::where('token', strtoupper($userofs->getCustomer->email))->where('use',1)->exists()){
          $valemail = 1;
      }else{
          $valemail = 0;
      }


      if ($estatus == 1 && $valphone == 0 && $valemail == 0){
       $mensaje = "Debe ser validado el telefono y correo";
       $estatus = null;
      } else if ($estatus == 1 && $valemail == 0){
        $mensaje = "Debe ser validado el correo";
        $estatus = null;
      } else if ($estatus == 1 && $valphone == 0){
        $mensaje = "Debe ser validado el telefono";
        $estatus = null;
      } else if ($estatus == null){
          $a = array("nombre" => $userofs->getCustomer->first_name." ".$userofs->getCustomer->last_name  , "mensaje" => $descrip);
          $s = $userofs->getCustomer->email;
          Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
          {
             $message->from('no-reply@winhold.net','WIN RIDESHARE');
             $message->to($s)->subject('WIN RIDESHARE | Te notifica');
          });
          $mensaje = "Actualizado de forma satisfactoria";
          $estatus = null;
      }else if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $userofs->getCustomer->first_name , "apellido"=> $userofs->getCustomer->last_name, "mensaje" => "que  sus documentos registrados no cumplen con los par�metros internos establecidos por la empresa. En caso de regularizar las mismas puede comunicarse con el �rea de soporte a soporte@winhold.net.");
        $s = $userofs->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });

      }else{

          $mensaje = "Actualizado de forma satisfactoria";
      }
    }else if ($id_proceso_validacion == 5){
      $u = file_drivers::where('id',$idfiledrivers)->with('getCustomer')->first();
      if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $u->getCustomer->first_name , "apellido"=> $u->getCustomer->last_name, "mensaje" => "que usted no cumple con los parametros establecidos internamente.");
        $s = $u->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });
      }else if ($estatus == null){
        $a = array("nombre" => $u->getCustomer->first_name." ".$u->getCustomer->last_name  , "mensaje" => $descrip);
        $s = $u->getCustomer->email;
        Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN RIDESHARE');
           $message->to($s)->subject('WIN RIDESHARE | Te notifica');
        });

      }
      $mensaje = "Actualizado de forma satisfactoria";
    }else if ($id_proceso_validacion == 6){
      $u = file_drivers::where('id',$idfiledrivers)->with('getCustomer')->first();
      if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $u->getCustomer->first_name , "apellido"=> $u->getCustomer->last_name, "mensaje" => "que usted no cumple con los parametros establecidos internamente.");
        $s = $u->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });
      }else if ($estatus == null){
        $a = array("nombre" => $u->getCustomer->first_name." ".$u->getCustomer->last_name  , "mensaje" => $descrip);
        $s = $u->getCustomer->email;
        Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN RIDESHARE');
           $message->to($s)->subject('WIN RIDESHARE | Te notifica');
        });
      }
      $mensaje = "Actualizado de forma satisfactoria";

    }else if ($id_proceso_validacion == 2){
      $u = file_drivers::where('id',$idfiledrivers)->with('getCustomer')->first();
      if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $u->getCustomer->first_name , "apellido"=> $u->getCustomer->last_name, "mensaje" => "que el veh�culo con el que se ha registrado no cumple con los par�metros F�sicos  internos establecidos por la empresa.");
        $s = $u->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });
      }else if ($estatus == null){
        $a = array("nombre" => $u->getCustomer->first_name." ".$u->getCustomer->last_name  , "mensaje" => $descrip);
        $s = $u->getCustomer->email;
        Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN RIDESHARE');
           $message->to($s)->subject('WIN RIDESHARE | Te notifica');
        });
      }
      $mensaje = "Actualizado de forma satisfactoria";
    }else{
      $u = file_drivers::where('id',$idfiledrivers)->with('getCustomer')->first();
      if ($estatus != 1 && $estatus != null){
        $a = array("nombre" => $u->getCustomer->first_name , "apellido"=> $u->getCustomer->last_name, "mensaje" => "que usted no cumple con los parametros establecidos internamente.");
        $s = $u->getCustomer->email;
        Mail::send('external.drivers.sendDisapproved',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
           $message->to($s)->subject('WIN TECNOLOGIES INC | Respuesta a solicitud');
        });
      }else if ($estatus == null){
        $a = array("nombre" => $u->getCustomer->first_name." ".$u->getCustomer->last_name  , "mensaje" => $descrip);
        $s = $u->getCustomer->email;
        Mail::send('AtencionCliente.SendNotification',$a,function($message) use ($s)
        {
           $message->from('no-reply@winhold.net','WIN RIDESHARE');
           $message->to($s)->subject('WIN RIDESHARE | Te notifica');
        });
      }
      $mensaje = "Actualizado de forma satisfactoria";
    }

    $datos = ['id_file_drivers' => $idfiledrivers, 'id_proceso_validacion' => $id_proceso_validacion,
              'estatus_proceso' => 1, 'approved' => $estatus, 'created_by' =>  auth()->user()->id, 'description' => $descrip];
    if ($ProcesoValidacionCond){
      ProcesoValCond::find($ProcesoValidacionCond->id)->update($datos);
    }else {
      ProcesoValCond::create($datos);
    }


    if ($estatus == 1){
      $process_model =  ProcessTrace::where('id_file_drivers', $idfiledrivers)->where('id_process_model', $id_proceso_validacion)->first();
      $process_model->estatus = 1;
      $process_model->estatus = 1;
      $process_model->save();
    }else{
      $process_model =  ProcessTrace::where('id_file_drivers', $idfiledrivers)->where('id_process_model', $id_proceso_validacion)->first();
      $process_model->estatus = null;
      $process_model->estatus2 = 3;
      $process_model->save();
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

 public function updateDriver(){
   $form = request()->form;
   $id   = request()->id;
   $data = request()->data;
   $mensaje =null; $observaciones = null;
   $flag    ='false';

   if ($form == 'formPersonal') {
     $default = '172';

     if ($data{'provincia'} == '2825'){
       $city = 48357;
     }else if ($data{'provincia'} == '2815'){
       $city = 32009;
     }else if ($data{'provincia'} == '2822'){
       $city = 32087;
     }else if ($data{'provincia'} == '2824'){
       $city = 32110;
     }else if ($data{'provincia'} == '2823'){
       $city = 48413;
     }else if ($data{'provincia'} == '2818'){
       $city = 32045;
     }else if ($data{'provincia'} == '2833'){
       $city = 32206;
     }else if ($data{'provincia'} == '2821'){
       $city = 32066;
     }else if ($data{'provincia'} == '2831'){
       $city = 32200;
     }else if ($data{'provincia'} == '2828' && request()->city == '32145'){
       $city = 32145;
     }else if ($data{'provincia'} == '2828' && request()->city == '32146'){
       $city = 32146;
     }else{
       $city = 32058;
     }

    $old = Customer::find($id);
    $emailExiste = Customer::where('email',$data{'email'})->where('id', '!=', $id)->first();
    if ($emailExiste){     $observaciones  .="La direccion de CORREO esta asociado a otro conductor\n";    }

    $dniExiste = Customer::where('dni',$data{'dni'})->where('id_type_documents',$data{'id_type_documents'})->where('id', '!=', $id)->first();
    if ($dniExiste){  $observaciones      .= "El numero de DOCUMENTO DE IDENTIDAD esta asociado a otro conductor\n";  }
    else{

    }

    $userExiste = Customer::where('user',$data{'user'})->where('id', '!=', $id)->first();
    if ($userExiste){     $observaciones  .="El usuario esta asociado a otro conductor\n";    }

    $phoneExiste = Customer::where('phone',$data{'phone'})->where('id','!=', $id)->first();
    if ($phoneExiste){ $observaciones     .= "El numero de TELEFONO esta asociado a otro conductor\n";    }

    $datos =[
      'user'       => ($data{'user'}       == null || $data{'user'}      == ''  || $userExiste)? $old->user      :  $data{'user'},
      'first_name' => ($data{'first_name'} == null || $data{'first_name'} == '') ? $old->first_name :  mb_strtoupper($data{'first_name'}),
      'last_name'  => ($data{'last_name'}  == null || $data{'last_name'}  == '') ? $old->last_name  :  mb_strtoupper($data{'last_name'}),
      'email'      => ($data{'email'}      == null || $data{'email'}      == ''  || $emailExiste)? $old->email      :  $data{'email'},
      'dni'        => ($data{'dni'}        == null || $data{'dni'}        == ''  || $dniExiste  )? $old->dni        :  $data{'dni'},
      'phone'      => ($data{'phone'}      == null || $data{'phone'}      == ''  || $phoneExiste)? $old->phone      :  $data{'phone'},
      'id_type_documents' => ($data{'id_type_documents'}      == null || $data{'id_type_documents'}      == ''  || $dniExiste)? $old->id_type_documents      :  $data{'id_type_documents'},
      'id_country'    => $default,
      'id_city'       => $city,
      'id_state'      => $data{'provincia'}
    ];
    $old = Customer::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   if ($form == 'formConductor'){
    $old = file_drivers::find($id);
    $licenciaExiste = file_drivers::where('licencia',$data{'licencia'})->where('id', '!=', $id)->first();
    if ($licenciaExiste){      $observaciones = "El numero de LICENCIA esta asociado a otro conductor\n";    }

    $datos = [
      'licencia'        => ($data{'licencia'}        == null || $data{'licencia'}        == '' || $licenciaExiste )? $old->licencia     :   $data{'licencia'},
      'classcategoria'  => ($data{'classcategoria'}  == null || $data{'classcategoria'}  == '')? $old->classcategoria  :  mb_strtoupper($data{'classcategoria'}),
      'licfecemi'       => ($data{'licfecemi'}       == null || $data{'licfecemi'}       == '')? $old->licfecemi       :  $data{'licfecemi'},
      'licfecven'       => ($data{'licfecven'}       == null || $data{'licfecven'}       == '')? $old->licfecven       :  $data{'licfecven'},
    ];
    $old->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   if ($form == 'formVehiculo'){
    $old = file_drivers::find($id);
    $placaExiste = file_drivers::where('placa',$data{'placa'})->where('id', '!=', $id)->first();
    if ($placaExiste){
      $observaciones = "El numero de PLACA esta asociado a otro conductor\n";
      return ['flag' => 'false' , 'mensaje' => 'No se actualizo', 'observaciones' => $observaciones];
    }else{
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://rest.scrall.cc/v1/sunarp/boletainformativa",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "TAX",
      CURLOPT_POSTFIELDS => "{\n    \"placa\": \"".$data{'placa'}."\"\n}",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $myArray  = json_decode($response);

    if (isset($myArray->result->datosBoletaRPV)){
      $modelo = $myArray->result->datosBoletaRPV->modelo;
      $marca  = $myArray->result->datosBoletaRPV->marca;
      $color  = $myArray->result->datosBoletaRPV->color;
      $novin  = $myArray->result->datosBoletaRPV->numSerie;
      $nomtr  = $myArray->result->datosBoletaRPV->descTipoCarr;
      $estado = $myArray->result->datosBoletaRPV->estado;
      $year = $myArray->result->datosBoletaRPV->anoFab;

      $datos =[
        'placa'        => mb_strtoupper($data{'placa'}),
        'color_car'    => $color,
        'marca'        => $marca,
        'year'         => $data{'year'},
        'model'        => $modelo,
        'num_vin'      => $novin,
        'num_motor'    => $nomtr,
        'est_car'      => $estado,
      ];
    $old = file_drivers::find($id)->update($datos);

    $estatus = null;
    $descrip = null;

    $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',1)
    ->where('id_file_drivers', $id)->first();

    $datoss = ['id_file_drivers' => $id, 'id_proceso_validacion' => 1,
              'estatus_proceso' => 1, 'approved' => $estatus, 'created_by' =>  auth()->user()->id, 'description' => $descrip];

    if ($ProcesoValidacionCond){
      ProcesoValCond::find($ProcesoValidacionCond->id)->update($datoss);
    }else {
      ProcesoValCond::create($datoss);
    }
      $observaciones = "El numero de placa es valido";
      return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones' => $observaciones];
    }else{

      $datos1 = [
	'placa'        => mb_strtoupper($data{'placa'}),
        'color_car'    => $data{'color_car'},
        'marca'        => $data{'marca'},
        'year'         => $data{'year'},
        'model'        => $data{'model'},
        'num_vin'      => $data{'num_vin'},
        'num_motor'    => $data{'num_motor'},
        'est_car'      => $data{'est_car'},
      ];
       $old = file_drivers::find($id)->update($datos1);

    $estatus = null;
    $descrip = null;

    $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',1)
    ->where('id_file_drivers', $id)->first();

    $datoss1 = ['id_file_drivers' => $id, 'id_proceso_validacion' => 1,
              'estatus_proceso' => 1, 'approved' => $estatus, 'created_by' =>  auth()->user()->id, 'description' => $descrip];

    if ($ProcesoValidacionCond){
      ProcesoValCond::find($ProcesoValidacionCond->id)->update($datoss1);
    }else {
      ProcesoValCond::create($datoss1);
    }


      $observaciones = "El numero de PLACA por validar";
      return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones' => $observaciones];
    }
    }
   }

   if ($form == 'formSeguro'){
    $old = file_drivers::find($id);
    $datos =[
      'enterprisesoat'    => ($data{'enterprisesoat'}  == null || $data{'enterprisesoat'} == '')? $old->enterprisesoat :  mb_strtoupper($data{'enterprisesoat'}),
      'soatfecemi'        => ($data{'soatfecemi'}      == null || $data{'soatfecemi'}     == '')? $old->soatfecemi     :  $data{'soatfecemi'},
      'soatfecven'        => ($data{'soatfecven'}      == null || $data{'soatfecven'}     == '')? $old->marca          :  $data{'soatfecven'},
      'est_soat'          => ($data{'est_soat'}        == null || $data{'est_soat'}       == '')? $old->est_soat       :  $data{'est_soat'},
      'type_soat'         => ($data{'type_soat'}       == null || $data{'type_soat'}      == '')? $old->type_soat      :  $data{'type_soat'},
      'type_safe'         => ($data{'type_safe'}       == null || $data{'type_safe'}      == '')? $old->type_safe      :  $data{'type_safe'},
      'nro_poliza'         => ($data{'nro_poliza'}       == null || $data{'nro_poliza'}      == '')? $old->nro_poliza      :  $data{'nro_poliza'},
    ];
    $old = file_drivers::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   if ($form == 'formRevision'){
     $datos =[
       'revfecemi'    => ($data{'revfecemi'}  == null || $data{'revfecemi'} == '') ? $old->revfecemi : $data{'revfecemi'},
       'revfecven'    => ($data{'revfecven'}      == null || $data{'revfecven'}     == '')? $old->revfecven :  $data{'revfecven'},
     ];
     $old = file_drivers::find($id)->update($datos);
     return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }


   if ($form == 'formATU'){
     $old = file_drivers::find($id);

     $curl4 = curl_init();
     curl_setopt_array($curl4, array(
     CURLOPT_URL => "https://rest.scrall.cc/v1/atu/transporteurbano/verificacion",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "TAX",
     CURLOPT_POSTFIELDS => "{\n    \"placa\": \"".$old->placa."\"\n}",
     CURLOPT_HTTPHEADER => array(
       "Content-Type: application/json",
       "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
     ),
   ));

   $response4 = curl_exec($curl4);
   curl_close($curl4);
   $atuvals  = json_decode($response4);

  if(isset($atuvals->result)){
     $statusATU = $atuvals->result;
   }else{
     $statusATU = $data{'status_atu'};
   }


    $datos =[
      'atufecemi'    => ($data{'atufecemi'}  == null || $data{'atufecemi'} == '')? $old->atufecemi : $data{'atufecemi'},
      'atufecven'    => ($data{'atufecven'}      == null || $data{'atufecven'}     == '')? $old->atufecven     :  $data{'atufecven'},
      'status_atu'   => $statusATU,
    ];
    $old = file_drivers::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   return ['flag' => $flag , 'mensaje' => $mensaje, 'observaciones'=> $observaciones];
 }

 public function updFile() {
   $data     =  request()->data;
   $upd;
   $dato = [ $data{'name'} => $data{'url'}];
   $upd = file_drivers::find($data{'id'})->update($dato);

   return 'true';
 }

 public function uploadView()
 {
   $main = new MainClass();
   $main = $main->getMain();

   $rol= Main::where('users.id', '=', auth()->user()->id)
     ->where('main.status_user', '=', 'TRUE')
     ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
     ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
     ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
     ->join('users',    'users.id',              '=',   'rol_user.id_user')
     ->select('roles.id')
     ->first();

   $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

   $t = $this->PermisoDrivers();

   $superUsuario = $t->superUsuario;
   $antecedentes = $t->antecedentes;

    if ($antecedentes == true ||  $superUsuario == true){
       return view('external.drivers.uploadAntecedentes', compact('main','type_docs'));
     }else{
       return view('errors.403', compact('main'));
     }
 }

 public function getuserDri()
 {
   if(Customer::where(request(){'campo'},request(){'dar'})->exists())
   {
      $u =  Customer::where(request(){'campo'},request(){'dar'})->first();
//------------------------------------------------
$ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$u->dni);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$result = curl_exec($ch);
$httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
curl_close( $ch );

$result = [
'result'       => $result,
'status'       => $httpStatus
];


if($result{'status'}==200)
{
$valorDoc = explode("|", $result{'result'});
$a = new stdClass();
$a->first_name = $valorDoc[2];
$a->last_name = $valorDoc[0].' '.$valorDoc[1];

//----------------
   $u->first_name =  $a->first_name;
   $u->last_name = $a->last_name;


   if($u->first_name!=null || $u->first_name!="")
   {
     $u->save();


     return response()->json([
         "object"   => 'success',
         "data" =>$u
       ]);
    }
   else
   {
     return response()->json([
         "object"   => 'error',
         "message"=>"No Exsite El documento de identidad.",
       ]);
   }
}
//------------------------------------------------
   }else
   {
     return response()->json([
         "object"=> "error",
         "message"=>"No se encontro el ID"
     ]);
   }
 }

 public function saveAntecendetes()
 {
   $id = request()->id;
   $url = request()->voucherURL;
   $proceso = request()->proceso;
   $codigoproceso= request()->codigoproceso;
   $estatusproceso= request()->estatusproceso;
   $dni = request()->dni;
   $nombre = request()->first_name;
   $ape = request()->last_name;
   $tipodocs = request()->tipo_doc;

   $datauserfile = Customer::where('id',$id)->first();
   $datauserfile->dni = $dni;
   $datauserfile->first_name = $nombre;
   $datauserfile->last_name =  $ape;
   $datauserfile->id_type_documents = $tipodocs;
   $datauserfile->save();

   if ($estatusproceso == 1 || $estatusproceso == 3){
     $approved = 1;
     $description = "";
   }else{
     $approved = 0;
     $description = "EL CONDUCTOR NO CUMPLIO CON LOS PARAMETROS ESTABLECIDOS";
   }

   if(file_drivers::where('id_customer', $id)->exists())
   {
     $ddf = file_drivers::where('id_customer', $id)->first();
     $ddf->url_antecedentes = $url;
     $ddf->status_user = 9;
     $ddf->save();

      $process_model =  ProcessTrace::where('id_file_drivers', $ddf->id)->where('id_process_model', $proceso)->first();
      $process_model->estatus = (($estatusproceso == 1) ? 1 : 0);
      $process_model->estatus2 = (($estatusproceso == 1) ? 1 : 0);
      $process_model->save();

      if (ProcesoValCond::where('id_file_drivers', $ddf->id)
      ->where('id_proceso_validacion',$proceso)->exists()){

        $procevalconduc = ProcesoValCond::where('id_file_drivers', $ddf->id)
        ->where('id_proceso_validacion',$proceso)->first();

        $procevalconduc->estatus_proceso = (($estatusproceso == 1 || $estatusproceso == 0) ? 1 : 0);
        $procevalconduc->created_by = auth()->user()->id;
        $procevalconduc->approved = $approved;
        $procevalconduc->description = $description;
        $procevalconduc->save();

      }else{

        $procesoCond =[
         'id_file_drivers'        => $ddf->id,
         'id_proceso_validacion'  => $codigoproceso,
         'estatus_proceso'        => (($estatusproceso == 1 || $estatusproceso == 0) ? 1 : 0),
         'modified_by'            => auth()->user()->id,
         'approved'               => $approved,
         'created_by' 		        => auth()->user()->id,
         'description'            => $description
       ];
       ProcesoValCond::create($procesoCond);

      }
   }
   else {
     $d = new file_drivers();
     $d->id_customer = $id;
     $d->url_antecedentes = $url;
     $d->status_user = 9;
     $d->save();

     $process_model =  ProcessTrace::where('id_file_drivers', $d->id)->where('id_process_model', $proceso)->first();
     $process_model->estatus = (($estatusproceso == 1) ? 1 : 0);
     $process_model->estatus2 = (($estatusproceso == 1) ? 1 : 0);
     $process_model->save();


     if (ProcesoValCond::where('id_file_drivers', $d->id)
     ->where('id_proceso_validacion',$proceso)->exists()){

       $procevalconduc = ProcesoValCond::where('id_file_drivers', $d->id)
       ->where('id_proceso_validacion',$proceso)->first();

       $procevalconduc->estatus_proceso = (($estatusproceso == 1 || $estatusproceso == 0) ? 1 : 0);
       $procevalconduc->created_by = auth()->user()->id;
       $procevalconduc->approved = $approved;
       $procevalconduc->description = $description;
       $procevalconduc->save();

     }else{

       $procesoCond =[
         'id_file_drivers'        => $ddf->id,
         'id_proceso_validacion'  => $codigoproceso,
         'estatus_proceso'        => (($estatusproceso == 1 || $estatusproceso == 0) ? 1 : 0),
         'modified_by'            => auth()->user()->id,
         'approved'               => $approved,
         'created_by' 		        => auth()->user()->id,
         'description'            => $description
      ];
      ProcesoValCond::create($procesoCond);

     }

   }

   return response()->json([
       "object"=> "success",
       "message"=>"Se registro"
   ]);


 }



 public function reporteExcelRecord()
 {

   $id = request()->id;
   if(Customer::where('id_office',$id)->exists())
   {
     $u =  Customer::where('id_office',$id)->first();

     if(file_drivers::where('id_customer', $u->id)->exists())
     {

       $d = file_drivers::where('id_customer', $u->id)->with('getCustomer','getStatusUser')->first();
       $records = Record_Driver::where('id_customer', $u->id)->get();
       $dp = $d->getCustomer()->first();

       $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$dp->dni, true);
       $licenciavals = json_decode($licenciaval);

       $fechaemi = $licenciavals->fechaemision;
       $fechaven = $licenciavals->fecharevalidacion;

       $first_name = $dp->first_name;
       $last_name = $dp->last_name;
       $dni = $dp->dni;
       $licence = $licenciavals->nrolicencia;
       $clasecate = $licenciavals->clasecategoria;
       $estadolic = $licenciavals->estado;
       $licfecemi = date("Y-m-d", strtotime($fechaemi));
       $licfecven = date("Y-m-d", strtotime($fechaven));

       $pdf = PDF::loadView('external.drivers.reportRecordDriver',compact(
         'dni',
         'first_name',
         'last_name',
         'licence',
         'clasecate',
         'estadolic',
         'licfecemi',
         'licfecven',
         'records'
       ));
       return $pdf->stream('reporteRecord.pdf');
     }else {
       return response()->json([
           "object"=> "error",
           "message"=>"El id no tiene imagenes"
       ]);
     }
   }else {
     return response()->json([
         "object"=> "error",
         "message"=>"No se encontro el ID"
     ]);
  }
 }

public function reportePDFRecord(){
      $u =  Customer::where('id',request()->id)->first();
      if(Record_Driver::where('id_customer', $u->id)->exists())
      {

        $d = file_drivers::where('id_customer', $u->id)->with('getCustomer','getStatusUser')->first();
        $records = Record_Driver::where('id_customer', $u->id)->get();
        $dp = $d->getCustomer()->first();

        $point = 0;
        foreach ($records as $key => $value) {
          $point +=$value->points_firmes;
        }


        // $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$dp->dni, true);
        // $licenciavals = json_decode($licenciaval);

        // $fechaemi = $licenciavals->fechaemision;
        // $fechaven = $licenciavals->fecharevalidacion;

        $first_name = $dp->first_name;
        $last_name = $dp->last_name;
        $dni = $dp->dni;
        $licence = $d->licencia;
        $clasecate = $d->classcategoria;
        $estadolic = $d->est_licencia;
        $licfecemi = $d->licfecemi;
        $licfecven = $d->licfecven;

        $pdf = PDF::loadView('external.drivers.reportRecordDriver',compact(
          'dni',
          'first_name',
          'last_name',
          'licence',
          'clasecate',
          'estadolic',
          'licfecemi',
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




 function reportPDF()
 {


     if (true){

       $id = request()->id;
       if(Customer::where('id_office',$id)->exists())
       {
          $u =  Customer::where('id_office',$id)->first();

         if(file_drivers::where('id_customer', $u->id)->exists())
         {
           $d = file_drivers::where('id_customer', $u->id)->with('getCustomer','getStatusUser')->first();
           $rr = Record_Driver::where('id_customer', $u->id)->get();
           $point = 0;

           foreach ($rr as $key => $value) {
             $point += $value->points_firmes;
           }


           $dp= $d->getCustomer()->first();
           $dni = $dp->dni;
           $first_name = $dp->first_name;
           $last_name = $dp->last_name;
           $licencia = $d->licencia;
           $licfecemi = $d->licfecemi;
           $licfecven = $d->licfecven;
           $placa = $d->placa;
           $marca = $d->marca;
           $color = $d->color_car;
           $year = $d->year;
           $soatfecemi = $d->soatfecemi;
           $soatfecven = $d->soatfecven;
           $enterprisesoat = $d->enterprisesoat;
           $classcategoria = $d->classcategoria;
           $lic_frontal = $d->lic_frontal;
           $lic_back = $d->lic_back;
           $car_externa = $d->car_externa;
           $car_externa2 = $d->car_externa2;
           $car_externa3 = $d->car_externa3;
           $car_interna = $d->car_interna;
           $car_interna2 = $d->car_interna2;
           $tar_veh_back = $d->tar_veh_back;
           $tar_veh_frontal = $d->tar_veh_frontal;
           $dni_frontal = $d->dni_frontal;
           $dni_back = $d->dni_back;
           $photo_perfil = $d->photo_perfil;
           $soat_frontal = $d->soat_frontal;
           $soat_back= $d->soat_back;
           $recibo_luz = $d->recibo_luz;
           $revision_tecnica = $d->revision_tecnica;
           $revfecemi = $d->revfecemi;
           $revfecven = $d->revfecven;
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
               "message"=>"El id no tiene imagenes"
           ]);
         }


       }else
       {
         return response()->json([
             "object"=> "error",
             "message"=>"No se encontro el ID"
         ]);
       }


     }else{
       return view('errors.403', compact('main'));
 }
}
  //GET RECORD RANGO
  public function recordRango(){
    $recordSum   =  request(){'sum'};
    // var_dump($recordSum);
    $recordSum = (int)$recordSum;
    $sql = 'select * from "Ps855spol5".rango_record where '.$recordSum.'between rangoa and rangob';
    $evaluo =  DB::select($sql);
    return $evaluo;
  }

  //GESTION DE RECORD
  public function recordDriver($id){

    $dataArraySend =[];
    $datos =  file_drivers::where('id',$id)->with('getCustomer')->first();
    $first_name = $datos->getCustomer->first_name;
    $last_name  = $datos->getCustomer->last_name;
    $dni        = $datos->getCustomer->dni;
    $recordSum = null;    $evaluo= null;

    // $datos =  User_office::where('id_office',$id)->first();
    // $first_name = $datos->first_name;
    // $last_name  = $datos->last_name;
    // $dni        = $datos->dni;

	$curl2 = curl_init();
    curl_setopt_array($curl2, array(
    CURLOPT_URL => "https://rest.scrall.cc/v1/mtc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "TAX",
    CURLOPT_POSTFIELDS => "{\n    \"dni\": \"".$dni."\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
    ),
  ));

  $response2 = curl_exec($curl2);
  curl_close($curl2);
  $licenciavals  = json_decode($response2);

  if($licenciavals->message = "found data"){
      if($dni){
        if(isset($licenciavals->puntos->papeletas)){
          if (isset($licenciavals->puntos->papeletas->codigo_administrado)){
                  foreach ($licenciavals->puntos->papeletas as $key => $value) {
                    $datos =[
                      'aCod_Falta'        => $value->codigo_falta,
                      'aNro_Papeleta'     => $value->numero_papeleta,
                      'aEntidad'          => $value->entidad,
                      'aPuntos_Saldo'     => $value->puntos_saldo,
                      'aPuntos_Firmes'    => $value->puntos_firmes,
                      'aFecha_Infraccion' => $value->fecha,
                      'aEstado'           => $value->estado,
                    ];
                    $recordSum += $value->puntos_firmes;
                    array_push($dataArraySend, $datos);
                  }
           }
        }
        else{
          $datos =[
            'aCod_Falta'        =>  null,
            'aNro_Papeleta'     =>  null,
            'aEntidad'          =>  null,
            'aPuntos_Saldo'     => '0',
            'aPuntos_Firmes'    => '0',
            'aFecha_Infraccion' => null,
            'aEstado'           => 'NO POSEE INFRACCIONES',
          ];
          array_push($dataArraySend, $datos);
          $recordSum = 0;

        }
      }
    }else{
      return [
        'data'      => [],
        'recordSum' => 100,
        'evaluo'    => 100,
      ];
    }

      if (isset($recordSum) ) {
        //select * from "Ps855spol5".rango_record where 70 between rangoa and rangob
        //$sql = 'select * from "Ps855spol5".rango_record where '.$recordSum.'between rangoa and rangob';
        $evaluo =  100;//DB::select($sql);
        // $evaluo =  RangoRecord::whereBetween($recordSum, ['rangoa', 'rangob'])->first();
      }

      return [
        'data'      => $dataArraySend,
        'recordSum' => $recordSum,
        'evaluo'    => $evaluo,
      ];

    }

  //GUARDAR DATOS DE RECORD
  public function saveRecord(){
    $id          =  request(){'id'};
    $id_estado   =  request(){'id_estado'};
    $recordSum   =  request(){'recordSum'};
    $tipo        =  request(){'tipo'};
    $proceso     =  request(){'proceso'};
    $codigoproceso= request(){'codigoproceso'};
    $noinfraccion = request(){'noinfraccion'};

    $keys        = [];
    $datos       =  file_drivers::where('id',$id)->with('getCustomer')->first();
    //ESTATUS 6 ES APROBADO  //ESTATUS 7 ES REPROBAR
    //$sql = 'select * from "Ps855spol5".rango_record where '.$recordSum.'between rangoa and rangob';
    $evaluo =  100;//DB::select($sql);
    $record;

    if ($tipo == 'iframe'){
      if ($noinfraccion == 'false'){
        $records =  request(){'record'};
        $array2  =  json_decode($records,true);
	//return response()->json([]) ;

        if(true)
        {

	if(is_array($array2["aCod_Falta[]"])){

			$array = $array2["aCod_Falta[]"];

	}else{
	$array = [$array2["aCod_Falta[]"]];
	}

        //OBTIENDO LLAVES
        while($element = current($array)) {
          array_push($keys, key($array));
          next($array);
        }


        if (Record_Driver::where('id_file_drivers', '=', $datos->id)->exists()){
          $record = Record_Driver::where('id_file_drivers', '=', $datos->id)->delete();
        }

        //RECORRIENDO AAREGLO


        foreach($keys as $r => $valores)
        {
	//$valores = json_decode($valores,true);
          $changedDate = null;
          $record_driver = [
            'id_file_drivers'     =>  $datos->id,
            'id_customer'     =>  $datos->id_customer,
            'cod_falta'           =>  (is_array($array2['aCod_Falta[]'])? $array2['aCod_Falta[]'][$valores] : $array2['aCod_Falta[]']),//strtoupper($valores["aCod_Falta[]"]),
            'papeleta'            =>  (is_array($array2['aNro_Papeleta[]'])? $array2['aNro_Papeleta[]'][$valores] : $array2['aNro_Papeleta[]']),//$array2['aNro_Papeleta[]'][$r],
            'entidad'             =>  (is_array($array2['aEntidad[]'])? $array2['aEntidad[]'][$valores] : $array2['aEntidad[]']),//strtoupper($array2['aEntidad[]'][$r]),
            'points_saldo'        =>  0,
            'points_firmes'       =>  (is_array($array2['aPuntos_Firmes[]'])? $array2['aPuntos_Firmes[]'][$valores] : $array2['aPuntos_Firmes[]']),//$array2['aPuntos_Firmes[]'][$r],
            'dinfranccion'        =>  (is_array($array2['aNro_Papeleta[]'])? date("Y-m-d", strtotime($array2['aFecha_Infraccion[]'][$valores])) : date("Y-m-d", strtotime($array2['aFecha_Infraccion[]']))),//date("Y-m-d", strtotime($array2['aFecha_Infraccion[]'][$r])),
            'estado'              =>  'MANUAL',
            'modified_by'         =>  auth()->user()->id,
          ];
          $id_record = Record_Driver::create($record_driver)->id;
         }

      }else{

        if (Record_Driver::where('id_file_drivers', '=', $datos->id)->exists()){
          $record = Record_Driver::where('id_file_drivers', '=', $datos->id)->delete();
        }

        $record_driver = [
          'id_file_drivers'     =>  $datos->id,
          'id_customer'     =>  $datos->id_customer,
          'cod_falta'           =>  null,
          'papeleta'            =>  null,
          'entidad'             =>  null,
          'points_saldo'        =>  0,
          'points_firmes'       =>  0,
          'dinfranccion'        =>  null,
          'estado'              =>  'NO POSEE INFRACCIONES',
          'modified_by'         =>  auth()->user()->id,
        ];
        $id_record = Record_Driver::create($record_driver)->id;
      }
      }else{

        if (Record_Driver::where('id_file_drivers', '=', $datos->id)->exists()){
          $record = Record_Driver::where('id_file_drivers', '=', $datos->id)->delete();
        }

        $record_driver = [
          'id_file_drivers'     =>  $datos->id,
          'id_customer'     =>  $datos->id_customer,
          'cod_falta'           =>  null,
          'papeleta'            =>  null,
          'entidad'             =>  null,
          'points_saldo'        =>  0,
          'points_firmes'       =>  0,
          'dinfranccion'        =>  null,
          'estado'              =>  'NO POSEE INFRACCIONES',
          'modified_by'         =>  auth()->user()->id,
        ];

        $id_record = Record_Driver::create($record_driver)->id;
      }

    }
    else{
      $records =  request(){'record'};
      $array   =  json_decode($records, true);
      // if($id_estado == 6 && $evaluo[0]->baprobado == true){
      // $records =  request(){'record'};
      // $array   =  json_decode($records, true);


      if(count($array) != 0)
      {

        if (Record_Driver::where('id_file_drivers', '=', $datos->id)->exists()){
          $record = Record_Driver::where('id_file_drivers', '=', $datos->id)->delete();
        }

        foreach ($array as $r => $valores) {

          $changedDate = null;
          $date = $valores{'aFecha_Infraccion'};
          if ($date){
            $res  = explode("/", $date);
            $changedDate = $res[2]."-".$res[1]."-".$res[0];
          }

          $record_driver = [
            'id_file_drivers'     =>  $datos->id,
            'id_customer'     =>  $datos->id_customer,
            'cod_falta'           =>  $valores{'aCod_Falta'},
            'papeleta'            =>  $valores{'aNro_Papeleta'},
            'entidad'             =>  $valores{'aEntidad'},
            'points_saldo'        =>  $valores{'aPuntos_Saldo'},
            'points_firmes'       =>  $valores{'aPuntos_Firmes'},
            'dinfranccion'        =>  $changedDate, //date("Y-m-d", strtotime($valores{'aFecha_Infraccion'})),
            'estado'              =>  $valores{'aEstado'},
            'modified_by'         =>  auth()->user()->id,
          ];
          $id_record = Record_Driver::create($record_driver)->id;
        }
      }else{

        if (Record_Driver::where('id_file_drivers', '=', $datos->id)->exists()){
          $record = Record_Driver::where('id_file_drivers', '=', $datos->id)->delete();
        }

        $record_driver = [
          'id_file_drivers'     =>  $datos->id,
          'id_customer'     =>  $datos->id_customer,
          'cod_falta'           =>  null,
          'papeleta'            =>  null,
          'entidad'             =>  null,
          'points_saldo'        =>  0,
          'points_firmes'       =>  0,
          'dinfranccion'        =>  null,
          'estado'              =>  'NO POSEE INFRACCIONES',
          'modified_by'         =>  auth()->user()->id,
        ];

        $id_record = Record_Driver::create($record_driver)->id;
      }

      // }
      //
    }

    if ($id_estado == 5 || $id_estado == 8){
      $approved = 1;
      $description = "";
    }else{
      $approved = 0;
      $description = "EXCEDIO LIMITE DE PUNTOS EN INFRACCIONES";
    }

    file_drivers::find($id)->update(['status_user' => $id_estado]);
    $process_model =  ProcessTrace::where('id_file_drivers', $id)->where('id_process_model', $proceso)->first();
    $process_model->estatus  = (($id_estado == 5) ? 1 : 0);
    $process_model->estatus2  = (($id_estado == 5) ? 1 : 0);
    $process_model->save();

    if (ProcesoValCond::where('id_proceso_validacion', '=', $codigoproceso)->where('id_file_drivers', '=', $id)->exists()){
      $proces = ProcesoValCond::where('id_proceso_validacion', '=', $codigoproceso)->where('id_file_drivers', '=', $id)->first();
      $proces->created_by = auth()->user()->id;
      $proces->estatus_proceso = (($id_estado == 5 || $id_estado == 7) ? 1 : 0);
      $proces->approved = $approved;
      $proces->description = $description;
      $proces->save();
    }else{
      $procesoCond =[
         'id_file_drivers'        => $id,
         'id_proceso_validacion'  => $codigoproceso,
         'estatus_proceso'        => (($id_estado == 5 || $id_estado == 7) ? 1 : 0),
         'modified_by'            => auth()->user()->id,
         'created_by'             => auth()->user()->id,
         'approved'               => $approved,
         'description'            => $description
       ];
       ProcesoValCond::create($procesoCond);
     }

    return "ACTUALIZADO CORRECTAMENTE";

  }

  //VALIDANDO EL PROCESO COMPLETO
  public function validarProceso(){
    $id_office        =  request(){'id_office'};
    $id_process       =  request(){'idproceso'};
    $process_model    =  ProcessModel::where('id', $id_process)->first();
    $procees_secAnt   =  ($process_model->sec_actual == 0)? 0 : $process_model->sec_actual-1;
    $procesoAnterior  =  ProcessTrace::where('sec_actual',$procees_secAnt)->orderby('updated_at', 'desc')->first();
    $user_offices     =  Customer::where('user',$id_office)->first();
    //VALIDAMOS SI EXISTE EL CODIGO
    if ($user_offices){
      $id_user_offices = $user_offices->id;
      $filedriver =  file_drivers::where('id_customer',$id_user_offices)->first();
        //VALIDAMOS SI HAY REGISTROS DE EL EN LA BD DE FILE DRIVER
        if (isset($filedriver)){

              $id_file_drivers = $filedriver->id;
              $process_trace  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)->first();
              if ($process_trace){
                //PROCESOS > 0

                if ($process_model->sec_actual != 0){

                  $process_trace_all =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)->first();

                   $process_trace_true  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)
                  ->where('estatus', true)
                  ->first();

                    if ($process_trace_all == $process_trace_true){
                      return 'true';
                    }
                }
                //cuando es 0
                else if ($process_model->sec_actual == 0) {

                  $process_trace_valid  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                 ->where('sec_actual',$procees_secAnt)
                 ->where('id_process_model', $id_process)
                 ->orderBy('updated_at','desc')
                 ->first();
                 if ($process_trace_valid->estatus == null || $process_trace_valid->estatus == false){
                   return 'true';
                 }
                }


              }

              else{
                $respuesta =  $this->creandoTraza($id_file_drivers);
                if ($respuesta){
                  return "true";
                }
                //CREAMOS SU SESION EN FILE DRIVER
              }

        }
        //
        else{
          //CREAMOS SU FILE DRIVE Y LUEGO SESION EN FILE DRIVER
          $datos =[
            'id_customer'  => $id_user_offices,
          ];
          if ($procees_secAnt== 0){
            $id_file_drivers = file_drivers::create($datos)->id;
            $this->creandoTraza($id_file_drivers);
            return 'true';
          }
        }

    }else{
      return 'false';
    }
  }

  //VALIDANDO EL PROCESO COMPLETO
  public function validarProcesoIDOffice(){
    $id_office        =  request(){'id_office'};
    $id_process       =  request(){'idproceso'};
    $process_model    =  ProcessModel::where('id', $id_process)->first();
    $procees_secAnt   =  ($process_model->sec_actual == 0)? 0 : $process_model->sec_actual-1;
    $procesoAnterior  =  ProcessTrace::where('sec_actual',$procees_secAnt)->orderby('updated_at', 'desc')->first();
    $user_offices     =  Customer::where('id_office',$id_office)->first();
    //VALIDAMOS SI EXISTE EL CODIGO
    if ($user_offices){
      $id_user_offices = $user_offices->id;
      $filedriver =  file_drivers::where('id_customer',$id_user_offices)->first();
        //VALIDAMOS SI HAY REGISTROS DE EL EN LA BD DE FILE DRIVER
        if (isset($filedriver)){

              $id_file_drivers = $filedriver->id;
              $process_trace  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)->first();
              if ($process_trace){
                //PROCESOS > 0

                if ($process_model->sec_actual != 0){

                  $process_trace_all =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)->first();

                   $process_trace_true  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)
                  ->where('estatus', true)
                  ->first();

                    if ($process_trace_all == $process_trace_true){
                      return 'true';
                    }
                }
                //cuando es 0
                else if ($process_model->sec_actual == 0) {

                  $process_trace_valid  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                 ->where('sec_actual',$procees_secAnt)
                 ->where('id_process_model', $id_process)
                 ->orderBy('updated_at','desc')
                 ->first();
                 if ($process_trace_valid->estatus == null || $process_trace_valid->estatus == false){
                   return 'true';
                 }
                }


              }

              else{
                $respuesta =  $this->creandoTraza($id_file_drivers);
                if ($respuesta){
                  return "true";
                }
                //CREAMOS SU SESION EN FILE DRIVER
              }

        }
        //
        else{
          //CREAMOS SU FILE DRIVE Y LUEGO SESION EN FILE DRIVER
          $datos =[
            'id_customer'  => $id_user_offices,
          ];
          if ($procees_secAnt== 0){
            $id_file_drivers = file_drivers::create($datos)->id;
            $this->creandoTraza($id_file_drivers);
            return 'true';
          }
        }

    }else{
      return 'false';
    }
  }

  //GET DATOS
  public function getDataProceso() {
    $id          =  request(){'id'};
    $user_offices     =  Customer::where('id_office',$id)->first();
    //VALIDAMOS SI EXISTE EL CODIGO
    if ($user_offices){
      $id_user_offices = $user_offices->id;
      $filedriver        =  file_drivers::where('id_customer',$id_user_offices)->first();
      if($filedriver){
      $proceso_val_cond  = ProcesoValCond::where('id_file_drivers', $filedriver->id)->with('getProceso', 'getCreatedBy','getModifyBy')->get();
      if ($proceso_val_cond){
        return $proceso_val_cond;
      }
    }else{
      return null;
    }

    }
    return null;
    // code...
  }

  //creamos traza
  public function creandoTraza($id_file_drivers){
    $process_model =  ProcessModel::orderby('sec_actual', 'asc')->get();
    foreach ($process_model as $x) {
      $datos =[
        'id_file_drivers'  => $id_file_drivers,
        'id_process_model' => $x{'id'},
        'sec_actual'       => $x{'sec_actual'},
        'sec_sig'          => $x{'sec_sig'},
        'modified_by'      => auth()->user()->id,
        'estatus2'      => 3,
      ];
      ProcessTrace::create($datos)->id;
    }
    return true;
  }
  //CONVERTIR FECHA A MILISEGUNDOS

  public function convertMilisegundos($f){
    return strtotime($f) * 1000;
  }

  //GESTION DE API INSERT APLICATIVO
  public function sendAppDataVehicle($id){


     $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();

     $insureF  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        =>  $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->soat_frontal,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $insureP  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->soat_back,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $tarVehiF = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->tar_veh_frontal,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $tarVehiP = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->tar_veh_back,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];

     $vehicleDocuments[0] = $insureF;
     $vehicleDocuments[1] = $insureP;
     $vehicleDocuments[2] = $tarVehiF;
     $vehicleDocuments[3] = $tarVehiP;

     $vehicle = [
       'tenantId'              => 'tenantIdForWinRideShareDev000001', //VALIDAR
       'vehicleTypeId'         => '3a41f03e08484788baf35f0e74118e1d', //VALIDAR
       'makeModel'             => $datos->marca,
       'modelName'             => $datos->model,
       'vehicleNumber'         => $datos->placa,
       'modelYear'             => $datos->year,
       'vehicleDocumentInfo'   => $vehicleDocuments,
       'serviceAreaIds'        => [
           '780c138e4cc34ad9ac9052222327e1d7'
        ],
        'serviceTypeIds'        => [
            'tenantServiceTypes00000000000001',
         ],
     ];
     // var_dump(json_encode($vehicle, true));
     echo "Vehicle";
     echo('<pre>');
     var_dump ($vehicle);
     echo('</pre>');
   }


   public function sendAppDataDriver($id){

     $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();

     $dniF  = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->dni_frontal,
         'fileName'=> 'National card'
       ],
     ];
     $dniP  = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->dni_back,
         'fileName'=> 'National card'
       ],
     ];

     $licenciaF = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'Registration document',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->lic_frontal,
         'fileName'=> 'National card'
       ],
     ];
     $licenciaP = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'Registration document',
       'documentNumber'        => $datos->id_customer,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->lic_back,
         'fileName'=> 'National card'
       ],
     ];

     $driverDocuments[0] = $dniF;
     $driverDocuments[1] = $dniP;
     $driverDocuments[2] = $licenciaF;
     $driverDocuments[3] = $licenciaP;

     $driver = [
       'serviceAreaIds'        => [
           '780c138e4cc34ad9ac9052222327e1d7',
           '1641bcaaf8704b9486cff4f64209cdc7'
        ],
        'serviceTypeIds'        => [
          'tenantServiceTypes00000000000001',
          'tenantServiceTypes00000000000002'
        ],
        'vehicleTypeId'    => '3a41f03e08484788baf35f0e74118e1d', //VALIDAR
        'vehicleId'        => '58d9001882234ce197090e310e7d3569',
        'driverInfo'       => [
          'tenantId'       => 'tenantIdForWinRideShareDev000001', //VALIDAR
          'firstName'      => $datos->getUserOffice->first_name,
          'lastName'       => $datos->getUserOffice->last_name,
          'email'          => $datos->getUserOffice->email,
          'numCountryCode' => '+51',
          'phoneNum'       => $datos->getUserOffice->phone,
        ],
        'driverDocumentInfo' => $driverDocuments
     ];

       echo "Conductor";
       echo('<pre>');
       var_dump ($driver);
       echo('</pre>');
    }

    function viewEvento(){
      $main = new MainClass();
      $main = $main->getMain();
      return view('external.drivers.evento',compact('main'));
    }

    function viewAgregar(){
      $main = new MainClass();
      $main = $main->getMain();
      return view('external.drivers.eventoEdit',compact('main'));
    }

    function getDataEvento(){
      $id_office = request()->id_office;
      if(eventoData::where('id_office',$id_office)->exists())
      {
        $e  = eventoData::where('id_office',$id_office)->first();
        return response()->json([
            "object"=> "success",
            "data"=>$e
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"NO SE ENCONTRO EL ID"
        ]);
      }
    }

    function getDataEmail(){
      $email = request()->email;
      if(eventoData::where('email',$email)->exists())
      {
        $e  = eventoData::where('email',$email)->first();
        return response()->json([
            "object"=> "success",
            "data"=>$e
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"NO SE ENCONTRO EL CORREO"
        ]);
      }
    }

    function getDataDni(){
      $dni = request()->dni;
      if(eventoData::where('dni',$dni)->exists())
      {
        $e  = eventoData::where('dni',$dni)->first();
        return response()->json([
            "object"=> "success",
            "data"=>$e
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"NO SE ENCONTRO EL Dni"
        ]);
      }
    }

    function getDataPhone(){
      $phone = request()->phone;
      if(eventoData::where('phone',$phone)->exists())
      {
        $e  = eventoData::where('phone',$phone)->first();
        return response()->json([
            "object"=> "success",
            "data"=>$e
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"NO SE ENCONTRO EL CELULAR"
        ]);
      }
    }

    function createEvento()
    {
      if(!eventoData::where('id_office',request()->id_office)->exists())
      {
        $d = new eventoData();
        $d->id_office = request()->id_office;
        $d->first_name = request()->first_name;
        $d->last_name = request()->last_name;
        $d->dni = request()->dni;
        $d->id_type_documents = request()->id_type_documents;
        $d->phone = request()->phone;
        $d->email = request()->email;
        $d->id_viaje =  request()->id_viaje;
        $d->save();
        return response()->json([
            "object"=> "success",
            "menssage"=>"REGISTRO EXITOSO"
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"ese id ta esta UTILIZADO."
        ]);
      }
    }
    function updateEvento()
    {
      if(eventoData::where('id_office',request()->id_office)->exists())
      {
        $d = eventoData::where('id_office',request()->id_office)->first();
        $d->id_office = request()->id_office;
        $d->first_name = request()->first_name;
        $d->last_name = request()->last_name;
        $d->dni = request()->dni;
        $d->id_type_documents = request()->id_type_documents;
        $d->phone = request()->phone;
        $d->email = request()->email;
        $d->id_viaje =  request()->id_viaje;
        $d->save();
        return response()->json([
            "object"=> "success",
            "menssage"=>"SE Actualizado CON EXITO"
        ]);
      }else {
        return response()->json([
            "object"=> "error",
            "menssage"=>"No Existe el ID."
        ]);
      }
    }


    function getTypeDocument()
    {

      return response()->json([
          "object"=> "success",
          "data"=>Type_document_identy::all()
      ]);
    }

    function insertData()
    {
      $variable =
      [

      ];
      foreach ($variable as $key => $value) {
        $d = new eventoData();
        $d->id_office = $value{'ID OFICINA'};
        $d->first_name = $value{'NOMBRES'};
        $d->last_name = $value{'APELLIDOS'};
        $d->dni = $value{'DNI'};
        $d->id_type_documents = 1;
        $d->phone = $value{'TELEFONO'};
        $d->email = $value{'CORREO'};
        //$d->id_viaje =  $value->id_viaje;
        $d->save();
      }
    }

    public function PermisoDrivers(){
      $rol = Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id','rol_user.id as id_roluser')
        ->first();

        $roluser = $rol{'id_roluser'};

        $t = $this->DriverPermisos();

        $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                      ->select('id_permission')
                      ->get();

      foreach ($permissions as $rs) {
           if ($rs->id_permission == 4){
             $t->superUsuario = true;
           }else if ($rs->id_permission == 40){
             $t->antecedentes = true;
           }
      }

      $t->rolid = $rol{'id'};

      return $t;
    }



}
