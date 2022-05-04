<?php

namespace App\Http\Controllers\Driver\Externo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\External\technical_review;
use App\Models\External\ProcessTrace;
use App\Models\External\Record_Driver;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcesoValidacion;
use App\Models\External\PaySponsor;
use App\Classes\MainClass;
use App\Models\General\Main;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\City;
use App\Models\General\User;
use App\Models\General\Type_document_identy;
use App\Models\External\VwProcesosTotal;
use App\Models\External\Audits;
use App\Models\General\Rol_permissions;
use \stdClass;
use \PDF;
use Illuminate\Support\Facades\DB;
use App\Models\General\code_email;
use Mail;
use App\Models\Views\vw_user_offices;
use App\Models\External\DriverApi;
use App\Models\Customer\Customer;
use App\Models\Customer\dtCustomerType;

class ExternalDriverController extends Controller
{


    public function __construct(){
      $this->middleware('auth');
      $this->url    = config('mywinrideshare.url');
      $this->secret = config('mywinrideshare.secret');
    }

    public function DriversPermisos(){
      $a = new stdClass();

      $a->revisioncheck = false;
      $a->updateSponsor = false;
      $a->updateIDoficce = false;
      $a->superUsuario = false;
      $a->paySponsorL = false;

      return $a;
    }

    public function index(){
        if(auth()->user()){
            $main = new MainClass();
            $main = $main->getMain();
            $title ='Conductores';
            $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
            return view('external.drivers.drivers',compact('title', 'main','type_docs'));
        }
    }
    public function schedule(){
        if(auth()->user()){
            $main = new MainClass();
            $main = $main->getMain();

           $title ='Conductores';
           return view('external.drivers.schedule',compact('title', 'main'));
        }
    }

    public function schedulechecklist(){
        if(auth()->user()){
            $main = new MainClass();
            $main = $main->getMain();

           $title ='Conductores';
           return view('external.drivers.schedulechecklist',compact('title', 'main'));
        }
    }

    public function getUsers(Request $r){
      $idoffice = request()->id;

      $user = Customer::where("id_office",$idoffice)
      ->first();

      if(Customer::where('id_office', $idoffice)->exists()){
        $message = "success";
        $val = 1;

        $files = file_drivers::where("id_customer",$user->id)
        ->first();

         if (file_drivers::where("id_customer",$user->id)->exists()){
           $filesmessage = "success";
         }else{
           $filesmessage = "error";
         }
      }else{
        $val = 2;
        $message = "error";
        $files = "error";
        $filesmessage = "error";
      }

      return response()->json([
        "objet"=> $message,
        "data" => $user,
        "vali" => $val,
        "file" => $files,
        "filemsj" => $filesmessage
      ]);
    }

    public function getUsersvalidate(Request $r){
      $idoffice = request()->id;

      $user = Customer::where("user",$idoffice)->first();

      if(Customer::where('user', $idoffice)->exists()){
        if(file_drivers::where("id_customer",$user->id)->exists()){
          $message = "success";
          $val = 1;
          $files = file_drivers::where("id_customer",$user->id)
          ->first();

           if (file_drivers::where("id_customer",$user->id)->exists()){
             $filesmessage = "success";
           }else{
             $filesmessage = "error";
           }

           if (code_email::where('token', $user->phone)->where('use',1)->exists()){
               $valphone = 1;
            } else if (code_email::where('token', $user->phone)->where('use',0)->exists()) {
               $valphone = 0;
            }else{
               $valphone = "error";
            }

             if (code_email::where('token', strtoupper($user->email))->where('use',1)->exists()){
               $valemail = 1;
             } else if (code_email::where('token', strtoupper($user->email))->where('use',0)->exists()) {
               $valemail = 0;
             }else{
               $valemail = "error";
             }

        }else{
          $val = 3;
          $message = "error";
          $files = "error";
          $filesmessage = "error";
          $valphone = "error";
          $valemail = "error";
        }
      }else{
        $val = 2;
        $message = "error";
        $files = "error";
        $valemail = "error";
        $filesmessage = "error";
        $valphone = "error";
      }



      return response()->json([
        "objet"=> $message,
        "data" => $user,
        "vali" => $val,
        "file" => $files,
        "filemsj" => $filesmessage,
        "valphone" => $valphone,
        "valemail" => $valemail
      ]);

    }


    public function getUsersvalidateOffice(Request $r){
      $idoffice = request()->id;

      $user = Customer::where("id_office",$idoffice)->first();

      if(Customer::where('id_office', $idoffice)->exists()){
        if(file_drivers::where("id_customer",$user->id)->exists()){
          $message = "success";
          $val = 1;
          $files = file_drivers::where("id_customer",$user->id)
          ->first();

           if (file_drivers::where("id_customer",$user->id)->exists()){
             $filesmessage = "success";
           }else{
             $filesmessage = "error";
           }

           if (code_email::where('token', $user->phone)->where('use',0)->exists()){
               $valphone = 0;
            } else if (code_email::where('token', $user->phone)->where('use',1)->exists()) {
               $valphone = 1;
            }else{
               $valphone = "error";
            }

             if (code_email::where('token', strtoupper($user->email))->where('use',0)->exists()){
               $valemail = 0;
             } else if (code_email::where('token', strtoupper($user->email))->where('use',1)->exists()) {
               $valemail = 1;
             }else{
               $valemail = "error";
             }

        }else{
          $val = 3;
          $message = "error";
          $files = "error";
          $filesmessage = "error";
          $valphone = "error";
          $valemail = "error";
        }
      }else{
        $val = 2;
        $message = "error";
        $files = "error";
        $valemail = "error";
        $filesmessage = "error";
        $valphone = "error";
      }



      return response()->json([
        "objet"=> $message,
        "data" => $user,
        "vali" => $val,
        "file" => $files,
        "filemsj" => $filesmessage,
        "valphone" => $valphone,
        "valemail" => $valemail
      ]);

    }

    public function getUserofficesvalidate(Request $r){
      $idoffice = request()->id;

      $user = Customer::where("user",$idoffice)->orWhere('dni',$idoffice)
      ->first();

      if(Customer::where('user', $idoffice)->orWhere('dni',$idoffice)->exists()){
        $message = "success";
      }else{
        $message = "error";
      }

      return response()->json([
        "objet"=> $message,
        "data" => $user,
      ]);

    }

    public function getUservalidate(Request $r){
        $username = request()->user;

        $users = User::where("username",$username)
        ->first();


        if(User::where('username', $username)->exists()){
          $message = "success";
        }else{
          $message = "error";
        }

        return response()->json([
          "objet"=> $message,
          "data" => $users,
        ]);


    }



    function docs(){
      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();

          $title ='Conductores';
          $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
          return view('external.drivers.documentos',compact('title', 'main','type_docs'));
      }
    }

    function perfil(){

      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();

         $title ='Conductores';
         return view('external.drivers.photoperfil',compact('title', 'main'));
      }
    }
    function perfil2(){

      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();

         $title ='Conductores';
         return view('external.drivers.photoperfil2',compact('title', 'main'));
      }
    }

    function userOffices(){
      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();
          $title ='Registro';
          $rol= Main::where('users.id', '=', auth()->user()->id)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id')
            ->first();

          $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
          return view('external.drivers.useroffices',compact('title', 'main','rol','type_docs'));
      }
    }

    public function generateURLSignature($action) {
      $url    = $this->url.'/'.$action;
      $secret = $this->secret;
      $expired = time() + 300;
      $url .= '?expires=' . $expired;
      $signature = hash_hmac('sha256', $url, $secret, false);
      return $url . '&signature=' . $signature;
    }

    public function getByUsernameOV($query)
    {
        //$query = 'prueba_user';
        $data  =  array("username" => $query);
        $data  = json_encode($data);

        $object  = 'error';
        $mensaje = '';
        $datos   = null;


        $urlComplete  = $this->generateURLSignature('user_get');

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

        if($myArray->status == '200'){
          $object  = 'success';
          $mensaje = 'USUARIO ENCONTRADO EXITOSAMENTE';

          $datos =[
            'userid'           => $myArray->data->posts->profile->id,
            'username'         => $myArray->data->posts->profile->username,
            'first_name'       => $myArray->data->posts->profile->first_name,
            'last_name'        => $myArray->data->posts->profile->last_name,
            'email'            => $myArray->data->posts->profile->email,
            'phone'            => $myArray->data->posts->profile->public_phone,
            'country'          => $myArray->data->posts->address->country,
            'city'             => $myArray->data->posts->address->city,
            'address'          => $myArray->data->posts->address->address_1
          ];
          $datos = (object) $datos;
        }
        //INVALID USER NAME
        else if($myArray->status == '460'){
          $mensaje = 'USUARIO NO ENCONTRADO';
        }

        return response()->json([
         'object'    => $object,
         'mensaje'   => $mensaje,
         'datos'     => $datos
        ]);

  }


    function validateoffice(){
      $val = request()->value;
      if (Customer::where('user', '=', $val)->exists()){
        $update = Customer::where('user', '=', $val)->first();
        return [ 'mensaje' => 'ESTE USUARIO ESTA REGISTRADO CON : '. $update->first_name.' '.$update->last_name,
              'flag' => true];
      }else{
        $validate  = $this->getByUsernameOV($val);
        $mensaje = $validate->original{'mensaje'};
        if ($validate->original{'object'} == "error"){
          $flag = true;
        }else{
          $flag = false;
        }
        //$mensaje = 'Completar los datos correctamente';
        //$flag = false;
        return ['flag' => $flag, 'oficinav' => $validate->original,'mensaje' => $mensaje];
      }
    }

    function validatedni(){
      $val = request()->value;
      $tipdoc = request()->tipdoc;

      if (Customer::where('dni', '=', $val)->where('id_type_documents', '=', $tipdoc)->exists()){
        $update = Customer::where('dni', '=', $val)->where('id_type_documents', '=', $tipdoc)->first();
        if (dtCustomerType::where('id_customer', '=', $update->id)->where('id_customerType','=',2)->exists()){
          return [ 'mensaje' => 'ESTE NUMERO DE DOCUMENTO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
                'flag' => true];
        }else{
          return ['flag' => false];
        }
      }else{
        return ['flag' => false];
      }
    }

    function validatephone(){
      $val = request()->value;

      if (Customer::where('phone', '=', $val)->exists()){
         $update = Customer::where('phone', '=', $val)->first();
         return [ 'mensaje' => 'ESTE TELEFONO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
             'flag' => true];
     }else{
       return ['flag' => false];
     }

    }

    function validateemail(){
      $val = request()->value;

      if (Customer::where('email', '=', $val)->exists()){
        $update = Customer::where('email', '=', $val)->first();
        return [ 'mensaje' => 'ESTE CORREO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => true];
     }else{
       return ['flag' => false];
     }
    }

    function validatelicenceexi(){
      $val = request()->value;

      if (file_drivers::where('licencia', '=', $val)->exists()){
        $updatew = file_drivers::where('licencia', '=', $val)
                  ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                  ->first();
        return [ 'mensaje' => 'ESTA LICENCIA ESTA REGISTRADA CON EL USUARIO: '. $updatew->first_name.' '.$updatew->last_name,
                   'flag' => true];
     }else{
       return ['flag' => false];
     }

    }

    function validateplacaexi(){
      $val = request()->value;
      if (file_drivers::where('placa', '=', $val)->exists()){
       $updates = file_drivers::where('placa', '=', $val)
                 ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                 ->first();
       return [ 'mensaje' => 'ESTA PLACA ESTA REGISTRADA CON EL USUARIO: '. $updates->first_name.' '.$updates->last_name,
               'flag' => true];
        }else{
        return ['flag' => false];
        }
    }
    function validatelicencia(){
      $val = request()->value;
      if (file_drivers::where('licencia', '=', $val)->exists()){
       $updates = file_drivers::where('licencia', '=', $val)
                 ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                 ->first();
       return [ 'mensaje' => 'ESTA LICENCIA ESTA REGISTRADA CON EL USUARIO: '. $updates->first_name.' '.$updates->last_name,
               'flag' => true];
        }else{
        return ['flag' => false];
        }
    }
    function validateplaca2(){
      $val = request()->value;
      if (file_drivers::where('placa', '=', strtoupper($val))->exists()){
          return [ 'mensaje' => 'ESTA PLACA YA ESTA REGISTRADA',
               'flag' => true];
      }else{
        return ['mensaje' => 'PLACA VALIDA', 'flag' => false];
      }
    }

    function userOfficesRegister(){
      // return request()->users;

      $rol= Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id')
        ->first();

      $user = Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('users.username')
        ->first();

      if ($rol->id == 7){
        $sponsor = $user->id;
      }else{
        $sponsor = 1;
      }

      if (request()->users{'provincia'} == '2825'){
        $city = 48357;
      }else if (request()->users{'provincia'} == '2815'){
        $city = 32009;
      }else if (request()->users{'provincia'} == '2822'){
        $city = 32087;
      }else if (request()->users{'provincia'} == '2824'){
        $city = 32110;
      }else if (request()->users{'provincia'} == '2823'){
        $city = 48413;
      }else if (request()->users{'provincia'} == '2813'){
        $city = 31995;
      }else if (request()->users{'provincia'} == '2818'){
        $city = 32045;
      }else if (request()->users{'provincia'} == '2833'){
        $city = 32206;
      }else if (request()->users{'provincia'} == '2821'){
        $city = 32066;
      }else if (request()->users{'provincia'} == '2831'){
        $city = 32200;
      }else if (request()->users{'provincia'} == '2828' && request()->city == '32145'){
        $city = 32145;
      }else if (request()->users{'provincia'} == '2828' && request()->city == '32146'){
        $city = 32146;
      }else{
        $city = 32058;
      }

      if (request()->id_office == 0){
	$idoffc = null;
      }else{
        $idoffc = request()->id_office;
      }

      $datos=[
        'user'   => request()->users{'idoffice'},
        'first_name'  => strtoupper(request()->users{'first_name'}),
        'last_name'   => strtoupper(request()->users{'last_name'}),
        'email'       => strtoupper(request()->users{'email'}),
        'dni'         => "".request()->users{'dni'}."",
        'phone'       => request()->users{'phone'},
        'id_country'  => 172,
        'id_city'     => $city,
        'id_state'    => request()->users{'provincia'},
        'sponsor_id'  => $sponsor,
        'address'     => request()->users{'district'},
        'date_birth'  => request()->users{'datebirth'},
        'created_by'  => auth()->user()->id,
        'id_type_documents' => request()->users{'tipdocid'},
        'id_office' => $idoffc
      ];


      if (Customer::where('dni', '=', "".request()->users{'dni'}."")->where('id_type_documents', '=', request()->users{'tipdocid'})->exists()){
        $update = Customer::where('dni', '=', "".request()->users{'dni'}."")->where('id_type_documents', '=', request()->users{'tipdocid'})->first();
        return [ 'mensaje' => 'ESTE DNI ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => 'false'];

      }else if (Customer::where('email', '=', request()->users{'email'})->exists()){
        $update = Customer::where('email', '=', request()->users{'email'})->first();
        return [ 'mensaje' => 'ESTE CORREO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => 'false'];

       }else if (Customer::where('phone', '=', request()->users{'phone'})->exists()){
          $update = Customer::where('phone', '=', request()->users{'phone'})->first();
          return [ 'mensaje' => 'ESTE TELEFONO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
                'flag' => 'false'];

       }else if (file_drivers::where('licencia', '=', request()->users{'licence'})->exists()){
         $updatew = file_drivers::where('licencia', '=', request()->users{'licence'})
                    ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                    ->first();
         return [ 'mensaje' => 'ESTA LICENCIA ESTA REGISTRADA CON EL USUARIO: '. $updatew->first_name.' '.$updatew->last_name,
                    'flag' => 'false'];

        }else if (file_drivers::where('placa', '=', request()->users{'placa'})->exists()){
          $updates = file_drivers::where('placa', '=', request()->users{'placa'})
                    ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                    ->first();
          return [ 'mensaje' => 'ESTA PLACA ESTA REGISTRADA CON EL USUARIO: '. $updates->first_name.' '.$updates->last_name,
                      'flag' => 'false'];
        }else {
          $user = Customer::create($datos)->id;
          $datos = dtCustomerType::updateOrCreate(['id_customer' => $user, 'id_customerType' => 2] , ['id_customer' => $user, 'id_customerType' => 2] );
          $data = [
              'placa' => strtoupper(request()->users{'placa'}),
              'licencia' => strtoupper(request()->users{'licence'}),
              'id_customer' => $user
           ];
           $filedriver = file_drivers::create($data)->id;
           return [ 'mensaje' => 'REGISTRO EXITOSO',
                 'flag' => 'true'];
        }
    }


    public function store(Request $r){
        $iduser = request()->iduser;
        $licencia = request()->users{'licencia'};

        $cc = Customer::where('id', '=', $iduser)->first();
        $cc->first_name = request()->users{'name-user'};
        $cc->last_name = request()->users{'ape-user'};
        $cc->phone = request()->users{'phone-user'};
        $cc->email = request()->users{'email-user'};
        $cc->dni = request()->users{'dni'};
        $cc->id_type_documents = request()->users{'tipdocid'};
        //$cc->date_birth = request()->users{'datebirth'};
        $cc->save();

        //licencias
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = request()->users{'licencia'};
          $classcategoria = null;
          $licestado      = null;
        //fin licencia

        //getVehiculoResult
          $modelo = null;
          $marca  = null;
          $color  = null;
          $novin  = null;
          $nomtr  = null;
          $estado = null;
          $year = request()->users{'year'};
        // fin getvehiculoResult



           //seguros
          $typesafe    =  null;
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          $estsoat     =  null;
          $nropoli     =  null;
          //fin seguros

	//verificacion ATU
        $statusATU = null;
      	//fin verificacion ATU


        if (file_drivers::where('id_customer', '=', $cc->id)->exists()){
            $file = file_drivers::where('id_customer', '=', $cc->id)->first();
            $file->tar_vehfecemi = request()->users{'tarj-vehi-fec-emi'};
            $file->tar_vehfecven = request()->users{'tarj-vehi-fec-emi'};
            $file->revfecemi = (request()->users{'rev-fec-emi'} != "") ? request()->users{'rev-fec-emi'} : null;
            $file->revfecven = (request()->users{'rev-fec-ven'} != "") ? request()->users{'rev-fec-ven'} : null;
            $file->status_user = 2;
            $file->placa = strtoupper(request()->users{'placa'});
            $file->model = $modelo;
            $file->marca = $marca;
            $file->licencia = $licencia;
            $file->year  = request()->users{'year'};
            $file->dnifecemi = date("Y-m-d");
            $file->dnifecven = date("Y-m-d");
            $file->licfecemi = $licenciafecemi;
            $file->licfecven = $licenciafecven;
            $file->soatfecemi = $soatfecemiv;
            $file->soatfecven = $soatfecvenv;
            $file->color_car =  $color;
            $file->num_vin = $novin;
            $file->num_motor = $nomtr;
            $file->est_car =   $estado;
            $file->licencia = $nrolicencia;
            $file->classcategoria = $classcategoria;
            $file->est_licencia = $licestado;
            $file->enterprisesoat = $namecompany;
            $file->type_soat = $typesoat;
            $file->est_soat = $estsoat;
            $file->nro_poliza = $nropoli;
            $file->type_safe = $typesafe;
            $file->status_atu = $statusATU;
            $file->atufecemi = request()->users{'atu-fec-emi'};
            $file->atufecven = request()->users{'atu-fec-ven'};
            $file->save();
            $idfile = $file->id;
        }else{

            $filesdata = [
              'status_user' => 2,
              'placa' => strtoupper(request()->data{'placa'}),
              'year' => request()->data{'year'},
              'id_customer' => $iduser,
              'licencia' => $licencia,
              'tar_vehfecemi' => request()->users{'tarj-vehi-fec-emi'},
              'tar_vehfecven' => request()->users{'tarj-vehi-fec-emi'},
              'revfecemi' => (request()->users{'rev-fec-emi'} != "") ? request()->users{'rev-fec-emi'} : null,
              'revfecven' => (request()->users{'rev-fec-ven'} != "") ? request()->users{'rev-fec-ven'} : null,
              'status_user'  => 1,
              'model' => $modelo,
              'marca' => $marca,
              'dnifecemi' => date("Y-m-d"),
              'dnifecven' => date("Y-m-d"),
              'licfecemi' => $licenciafecemi,
              'licfecven' => $licenciafecven,
              'soatfecemi' => $soatfecemiv,
              'soatfecven' => $soatfecvenv,
              'color_car' => $color,
              'num_vin' => $novin,
              'num_motor' => $no_motr,
              'est_car' => $estado,
              'classcategoria' => $classcategoria,
              'est_licencia' => $licestado,
              'enterprisesoat' => $namecompany,
              'type_soat' => $typesoat,
              'est_soat'  => $estsoat,
              'nro_poliza' => $nropoli,
              'type_safe'  => $typesafe,
	      'status_atu' => $statusATU,
              'atufecemi' => request()->users{'atu-fec-emi'},
              'atufecven' => request()->users{'atu-fec-ven'},
            ];


            $idfile = file_drivers::create($filesdata)->id;
        }

        return response()->json(["idfile" => $idfile]);
    }

    public function updateauto(){
      $idfile = request()->idfile;

      if (request()->users{'type-safe'} == 'SOAT'){
        $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->users{'placa'}, true);
        $segurosvals = json_decode($valfechseguros);

        if (isset($segurosvals->NombreCompania)){
          $soatfecemi = explode("/", $segurosvals->FechaInicio);
          $soatfecven = explode("/", $segurosvals->FechaFin);

          $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
          $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
          $namecompany =  $segurosvals->NombreCompania;
          $typesoat    =  $segurosvals->NombreUsoVehiculo;
          $estsoat     =  $segurosvals->Estado;
        }else{
          //seguros
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          //fin seguros
        }
      }else{
        $soatfecemiv =  request()->users{'safe-fec-emi'};
        $soatfecvenv =  request()->users{'safe-fec-ven'};
        $namecompany =  strtoupper(request()->users{'company'});
        $typesoat    =  strtoupper(request()->users{'type-use'});
        $estsoat     =  strtoupper(request()->users{'status-safe'});
      }


      $file = file_drivers::where('id', '=', $idfile)->first();
      $file->placa = strtoupper(request()->users{'placa'});
      $file->year  = request()->users{'year'};
      $file->color_car =  request()->users{'color'};
      $file->marca = request()->users{'brand'};
      $file->model = strtoupper(request()->users{'model'});
      $file->est_car = strtoupper(request()->users{'status'});
      $file->tar_vehfecemi = request()->users{'tarj-vehi-fec-emi'};
      $file->tar_vehfecven = request()->users{'tarj-vehi-fec-emi'};
      $file->type_safe = strtoupper(request()->users{'type-safe'});
      $file->enterprisesoat = $namecompany;
      $file->est_soat = $estsoat;
      $file->type_soat = $typesoat;
      $file->num_vin = null;
      $file->num_motor = null;
      $file->soatfecemi = $soatfecemiv;
      $file->soatfecven = $soatfecvenv;
      $file->revfecemi = (request()->users{'rev-fec-emi'} != "") ? request()->users{'rev-fec-emi'} : null;
      $file->revfecven = (request()->users{'rev-fec-ven'} != "") ? request()->users{'rev-fec-ven'} : null;
      $file->save();

      return response()->json(["idfile" => $idfile]);
    }

    public function storeperfil(Request $r){
      $iduser = request()->iduser;


      $cc = Customer::where('id', '=', $iduser)->first();

      if (isset(request()->users{'name-user'})){
        $cc->first_name = request()->users{'name-user'};
      }
      if (isset(request()->users{'ape-user'})){
        $cc->last_name = request()->users{'ape-user'};
      }

      if (isset(request()->users{'phone-user'})){
        $cc->phone = request()->users{'phone-user'};
      }

      if (isset(request()->users{'email-user'})){
        $cc->email = request()->users{'email-user'};
      }
      $cc->save();
      $filedrivers = file_drivers::where('id_customer', '=', $iduser)->first();
      return response()->json(["idfile" => $filedrivers->id]);
    }

    public function validateplaca(Request $r){
      $placa = request()->placa;

      $url = 'http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.$placa;
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

        $ficheros = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.$placa, true);
        $ds = json_decode($ficheros);

        if ($ds->getVehiculoPResult[0]->sede == null){
          return response()->json([
            'object' => "success",
            "menssage" => "placa por validar.",
            "data"     => null
          ]);
        }else if($ds->getVehiculoPResult[0]->estado == null && $ds->getVehiculoPResult[0]->sede != null){
          return response()->json([
            'object'=>"error",
            "menssage" => "No se encontró la placa.",
            "data"     => null
          ]);
        }else{
          return response()->json([
            'object'   =>"success",
            "menssage" => "placa valida.",
            "data"     => $ds->getVehiculoPResult[0]
          ]);
        }
      }else{
        return response()->json([
          'object'=>"success",
          "menssage" => "placa por validar.",
          "data"     => null

        ]);
      }

    }

    public function validatelicense(Request $r){
      $id = request()->iduser;
      $licence = request()->licval;
      $cc = Customer::where('id', '=', $id)->first();

      $ficheros = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.$cc->dni, true);
      $ds = json_decode($ficheros);

      if($ds){
         if ($ds->nrolicencia == $licence){
           return response()->json([
             'object'=>"success",
             "menssage" => "licencia valida."
           ]);
         }else{
           return response()->json([
             'object'=> "error",
             "menssage" => "No coincide la licencia."
             ]);
         }
      }else{
        return response()->json([
          'object'=>"error",
          "menssage" => "No se encontró licencia."
        ]);
      }
    }

    public function validatelic(){
      $val = request()->licencia;
      $tipodoc = request()->tipodoc;

      if ($tipodoc == 1){
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
          CURLOPT_POSTFIELDS => "{\n    \"dni\": \"".$val."\"\n}",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
          ),
        ));

        $response2 = curl_exec($curl2);
        curl_close($curl2);
        $licenciavals  = json_decode($response2);

        if(isset($licenciavals->result->general)){
	    return response()->json([
            'object' =>"success",
            "menssage" => "Licencia valida.",
            "data" => $licenciavals->result->general
          ]);
        }else{
           return response()->json([
            'object' =>"success",
        "menssage" => "Licencia por validar",
        "data" => null
          ]);
        }
    }else{
      return response()->json([
        'object' =>"success",
        "menssage" => "Licencia por validar",
        "data" => null
      ]);
    }

    }


    public function storedocs(Request $r){

        $iduser = request()->iduser;
        $placa = request()->users{'placa'};
        $dni = request()->users{'dni'};
        $year = request()->users{'year'};
        $tipdoc = request()->users{'tipdocid'};

        $user = Customer::where('id', '=', $iduser)->first();
        $user->first_name = strtoupper(request()->users{'name-user'});
        $user->last_name  = strtoupper(request()->users{'ape-user'});
        $user->phone = request()->users{'phone-user'};
        $user->email = request()->users{'email-user'};
        $user->dni = $dni;
        //$user->date_birth = request()->users{'datebirth'};
        $user->id_type_documents = $tipdoc;
        $user->save();

        //licencias
        $licenciafecemi = null;
        $licenciafecven = null;
        $nrolicencia    = null;
        $classcategoria = null;
        $licestado      = null;
        //fin licencia

        //getVehiculoResult
          $modelo = null;
          $marca  = null;
          $color  = null;
          $novin  = null;
          $nomtr  = null;
          $estado = null;
        // fin getvehiculoResult


        //seguros
          $typesafe    = "CAT";
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          $nropoli     =  null;
        //fin seguros


            if (file_drivers::where('id_customer', $iduser)->exists()){
                $file = file_drivers::where('id_customer', '=', $iduser)->first();
                $file->status_user = 3;
                $file->placa = strtoupper($placa);
                $file->model = $modelo;
                $file->marca = $marca;
                $file->year  = $year;
                $file->dnifecemi = date("Y-m-d");
                $file->dnifecven = date("Y-m-d");
                $file->licfecemi = $licenciafecemi;
                $file->licfecven = $licenciafecven;
                $file->soatfecemi = $soatfecemiv;
                $file->soatfecven = $soatfecvenv;
                $file->color_car =  $color;
                $file->num_vin = $novin;
                $file->num_motor = $nomtr;
                $file->est_car =   $estado;
                $file->id_customer = $iduser;
                $file->classcategoria = $classcategoria;
                $file->est_licencia = $licestado;
                $file->enterprisesoat = $namecompany;
                $file->type_soat = $typesoat;
                $file->est_soat = $estsoat;
                $file->type_safe  = $typesafe;
                $file->nro_poliza = $nropoli;
                $file->save();
                $id_filedrivers = $file->id;
            }else{
              $filedrivers = [
                'id_customer' =>  $iduser,
                'status_user' => 3,
                'placa' => strtoupper($placa),
                'model' => $modelo,
                'marca' => $marca,
                'year' => $year,
                'dnifecemi' => date("Y-m-d"),
                'dnifecven' => date("Y-m-d"),
                'licfecemi' => $licenciafecemi,
                'licfecven' => $licenciafecven,
                'soatfecemi' => $soatfecemiv,
                'soatfecven' => $soatfecvenv,
                'color_car' => $color,
                'num_vin' => $novin,
                'num_motor' => $no_motr,
                'est_car' => $estado,
                'classcategoria' => $classcategoria,
                'est_licencia' => $licestado,
                'enterprisesoat' => $namecompany,
                'type_soat' => $typesoat,
                'est_soat'  => $estsoat,
                'type_safe' => $typesafe,
                'nro_poliza' => $nropoli
              ];

              $id_filedrivers = file_drivers::create($filedrivers)->id;

            }

            return response()->json([
              'object'=>"success",
              "idfile" => $id_filedrivers
            ]);
    }



    public function filesaves(Request $r){

          $file = file_drivers::where('id', '=', $r->id_file)->first();
          if ($r->tipo == '1'){
            $file->lic_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '2'){
            $file->lic_back =  $r->voucherURL;
          }


          if ($r->tipo == '3'){
            $file->tar_veh_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '4'){
            $file->tar_veh_back =  $r->voucherURL;
          }

          if ($r->tipo == '5'){
            $file->soat_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '7'){
            $file->revision_tecnica =  $r->voucherURL;
          }

          if ($r->tipo == '8'){
            $file->car_interna =  $r->voucherURL;
          }

          if ($r->tipo == '9'){
            $file->car_interna2 =  $r->voucherURL;
          }

          if ($r->tipo == '10'){
            $file->car_externa =  $r->voucherURL;
          }

          if ($r->tipo == '17'){
            $file->car_externa2 =  $r->voucherURL;
          }

          if ($r->tipo == '18'){
            $file->car_externa3 =  $r->voucherURL;
          }

          if ($r->tipo == '19'){
            $file->car_externa4 =  $r->voucherURL;
          }

          if ($r->tipo == '20'){
            $file->atu =  $r->voucherURL;
          }

          if ($r->tipo == '12'){
            $file->dni_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '13'){
            $file->dni_back =  $r->voucherURL;
          }

          if ($r->tipo == '15'){
            $file->recibo_luz =  $r->voucherURL;
          }

          if ($r->tipo == '16'){
            $file->photo_perfil =  $r->voucherURL;
          }

          $file->save();

          $proceso  =  $r->proceso;
          $codigoproceso = $r->codigoproceso;
          $estatusproceso = $r->estatusproceso;

          if ($proceso == 3){

            $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',1)
            ->where('id_file_drivers', $r->id_file)->first();

            $datos = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 1,
                      'estatus_proceso' => 1, 'approved' => null,'approved2' => 3, 'modified_by' =>  auth()->user()->id, 'description' => null];

            if ($ProcesoValidacionCond){
              ProcesoValCond::find($ProcesoValidacionCond->id)->update($datos);
            }else {
              ProcesoValCond::create($datos);
            }


            if (file_drivers::where('id', $r->id_file)
              ->where('dni_frontal','<>',null)
              ->where('dni_back','<>',null)
              ->where('lic_frontal','<>',null)
              ->where('lic_back','<>',null)
              ->where('tar_veh_frontal','<>',null)
              ->where('tar_veh_back','<>',null)
              ->where('soat_frontal','<>',null)
              ->where('atu','<>',null)
              ->exists()){

              $estatus = null;
              $estatus2 = 3;
              $descrip = null;

             $ProcesoValidacionCond1  = ProcesoValCond::where('id_proceso_validacion',3)
              ->where('id_file_drivers', $r->id_file)->first();

              $datos1 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 3,
                       'estatus_proceso' => 1, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  auth()->user()->id, 'description' => $descrip];

              if ($ProcesoValidacionCond1){
                ProcesoValCond::find($ProcesoValidacionCond1->id)->update($datos1);
              }else {
                ProcesoValCond::create($datos1);
              }


            }else{
              $estatus = null;
              $estatus2 = 3;
              $descrip = "Faltan subir documentos";

              $ProcesoValidacionCond2  = ProcesoValCond::where('id_proceso_validacion',3)
              ->where('id_file_drivers', $r->id_file)->first();

              $datos2 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 3,
                        'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  auth()->user()->id, 'description' => $descrip];

              if ($ProcesoValidacionCond2){
                ProcesoValCond::find($ProcesoValidacionCond2->id)->update($datos2);
              }else {
                ProcesoValCond::create($datos2);
              }
            }
         }

         if ($proceso == 4){
           if (file_drivers::where('id', $r->id_file)
             ->where('photo_perfil','<>',null)
             ->exists()){

            $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
            $filedrivers->status_user = 4;
            $filedrivers->save();


            $estatuss = null;
            $descripp = null;
            $estatuss2 = 3;

            $ProcesoValidacionConds  = ProcesoValCond::where('id_proceso_validacion',$proceso)
            ->where('id_file_drivers', $r->id_file)->first();

            $datoss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => $proceso,
                      'estatus_proceso' => 1, 'approved' => $estatuss,'approved2' => $estatuss2, 'modified_by' =>  auth()->user()->id, 'description' => $descripp];

            if ($ProcesoValidacionConds){
              ProcesoValCond::find($ProcesoValidacionConds->id)->update($datoss);
            }else {
              ProcesoValCond::create($datoss);
            }

            }
         }

         if ($proceso == 2){
           $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
           $filedrivers->status_user = 3;
           $filedrivers->save();

           $anioactual  = date('Y');
           $aniocar     = $filedrivers->year;
           $diferenciaYear = ($anioactual - $aniocar);

           if ($diferenciaYear >= 6){
             if (file_drivers::where('id', $r->id_file)
               ->where('car_interna','<>',null)
               ->where('car_interna2','<>',null)
               ->where('car_externa','<>',null)
               ->where('car_externa2','<>',null)
               ->where('car_externa3','<>',null)
               ->where('car_externa4','<>',null)
               ->exists()){

              $estatusss = null;
              $estatusss2 = 3;
              $descrippp = null;

              $ProcesoValidacionCondss  = ProcesoValCond::where('id_proceso_validacion',$proceso)
              ->where('id_file_drivers', $r->id_file)->first();

              $datosss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => $proceso,
                        'estatus_proceso' => 1, 'approved' => $estatusss,'approved2' => $estatusss2, 'modified_by' =>  auth()->user()->id, 'description' => $descrippp];

              if ($ProcesoValidacionCondss){
                ProcesoValCond::find($ProcesoValidacionCondss->id)->update($datosss);
              }else {
                ProcesoValCond::create($datosss);
              }

            }else{
              $estatus = null;
              $estatus2 = 3;
              $descrip = "Faltan subir fotos del auto";

              $ProcesoValidacionCond4  = ProcesoValCond::where('id_proceso_validacion',2)
              ->where('id_file_drivers', $r->id_file)->first();

              $datos4 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2,
                        'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  auth()->user()->id, 'description' => $descrip];

              if ($ProcesoValidacionCond4){
                ProcesoValCond::find($ProcesoValidacionCond4->id)->update($datos4);
              }else {
                ProcesoValCond::create($datos4);
              }
            }
           }else{
             if (file_drivers::where('id', $r->id_file)
               ->where('car_interna','<>',null)
               ->where('car_interna2','<>',null)
               ->where('car_externa','<>',null)
               ->exists()){

              $estatusss = null;
              $estatusss2 = 3;
              $descrippp = null;

              $ProcesoValidacionCondss  = ProcesoValCond::where('id_proceso_validacion',$proceso)
              ->where('id_file_drivers', $r->id_file)->first();

              $datosss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => $proceso,
                        'estatus_proceso' => 1, 'approved' => $estatusss,'approved2' => $estatusss2, 'modified_by' =>  auth()->user()->id, 'description' => $descrippp];

              if ($ProcesoValidacionCondss){
                ProcesoValCond::find($ProcesoValidacionCondss->id)->update($datosss);
              }else {
                ProcesoValCond::create($datosss);
              }

            }else{
              $estatus = null;
              $estatus2 = 3;
              $descrip = "Faltan subir fotos del auto";

              $ProcesoValidacionCond4  = ProcesoValCond::where('id_proceso_validacion',2)
              ->where('id_file_drivers', $r->id_file)->first();

              $datos4 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2,
                        'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  auth()->user()->id, 'description' => $descrip];

              if ($ProcesoValidacionCond4){
                ProcesoValCond::find($ProcesoValidacionCond4->id)->update($datos4);
              }else {
                ProcesoValCond::create($datos4);
              }
            }
           }
         }

         if ($proceso == 6){

           $ProcesoValidacions  = ProcesoValCond::where('id_proceso_validacion',2)
           ->where('id_file_drivers', $r->id_file)->first();

           $datoVal = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2, 'created_by' =>  auth()->user()->id, 'description' => 'SE CAMBIO VEHICULO'];

           ProcesoValCond::find($ProcesoValidacions->id)->update($datoVal);

           $ProcesoValidacionsS  = ProcesoValCond::where('id_proceso_validacion',1)
           ->where('id_file_drivers', $r->id_file)->first();

           $datoValS = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 1, 'created_by' =>  auth()->user()->id, 'description' => 'SE CAMBIO VEHICULO'];

           ProcesoValCond::find($ProcesoValidacionsS->id)->update($datoValS);
         }

          return response()->json([
              "rol"=> "éxito"
          ]);
    }


    public function getDriverFile()
    {
      if(Customer::where(request(){'campo'},request(){'dar'})->exists())
      {
         $u =  Customer::where(request(){'campo'},request(){'dar'})->first();
         if(Record_Driver::where('id_customer', $u->id)->exists())
         {
           $pg = Record_Driver::where('id_customer', $u->id)->get();
           $pun = 0;
           foreach ($pg as $key => $value) {
            $pun+= $value->points_firmes;
           }
           $statusrecord = true;
         }else{
           $pun = '-';
           $statusrecord = false;
         }


        if(file_drivers::where('id_customer', $u->id)->exists())
        {

          // -------------------------------------------------------------------------
          $file = file_drivers::where('id_customer', $u->id)->first();

          $rol= Main::where('users.id', '=', auth()->user()->id)
          ->where('main.status_user', '=', 'TRUE')
          ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
          ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
          ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
          ->join('users',    'users.id',              '=',   'rol_user.id_user')
          ->select('roles.id')
          ->first();

         $drivers = [];

         if ($rol->id == 7){
           $DriverQuery = file_drivers::where('id_customer', $u->id)
                          ->join('customers', 'customers.id', '=','file_drivers.id_customer')
                          ->where('customers.created_by', '=', auth()->user()->id)
                          ->with('getCustomer','getStatusUser','getTecnical')
                          ->get();
         } else {
            $DriverQuery =  file_drivers::where('id_customer', $u->id)
                           ->with('getCustomer','getStatusUser','getTecnical')
                           ->get();
         }



          return response()->json([
              "object"=> "success",
              "data"=> $DriverQuery,
              "points" => $pun,
              "statusrecord" => $statusrecord
          ]);
        }else
        {
          return response()->json([
              "object"=> "error",
              "message"=>"El id no tiene imagenes"
          ]);
        }

// -------------------------------------------------------------------------
      }else
      {
        return response()->json([
            "object"=> "error",
            "message"=>"No se encontro el ID"
        ]);
      }

    }
//-----------------------------saeg
    function showLis()
    {
      $main = new MainClass();
      $main = $main->getMain();
      return view('external.drivers.saeg.listSaeg',compact('main'));
    }

    function getDriversSaeg()
    {
      $drives = file_drivers::where('url_antecedentes','<>',null)
      ->with('getUserOffice','getStatusUser')->get();
      return response()->json([
          "object"=> "success",
          "data"=>$drives
      ]);
    }

//-----------------------------saeg
    function updateObserva()
    {
      $file = file_drivers::where('id', '=', request(){'id'})->first();
      $file->obs_vehi = request(){'obs'};
      $file->status_user =request(){'id_stado'};
      $file->save();

      return $file;
    }

    function technicalreview(){
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

       $rolid = $rol->id;

        if ($rolid != 7){
          return view('external.drivers.technicalreview', compact('main','type_docs'));
        }else{
          return view('errors.403', compact('main'));
        }
    }
    function technicalreview2(){
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

         $rolid = $rol->id;


         $t = $this->PermisosDrivers();
         $permiso = $t->revisioncheck;
         $superUsuario = $t->superUsuario;

          if ($superUsuario == true || $permiso == true){
            return view('external.drivers.technicalreview2', compact('main','type_docs'));
          }else{
            return view('errors.403', compact('main'));
          }
      }

      function storetechnicalreview(Request $r){
        $iduser  = request()->iduser;
        $status  = request()->status;
        $proceso = request()->proceso;
        $codigoproceso = request()->codigoproceso;

        $cc = Customer::where('id', '=', $iduser)->first();
        if (isset(request()->data{'phone-user'})){
          $cc->phone = request()->data{'phone-user'};
        }
        if (isset(request()->data{'email-user'})){
          $cc->email = request()->data{'email-user'};
        }
        $cc->first_name = request()->data{'name-user'};
        $cc->last_name  = request()->data{'ape-user'};
        $cc->dni        = request()->data{'dni'};
        $cc->id_type_documents = request()->data{'tipdocid'};
        $cc->save();

        if ($status == 2){
        	$statusdriver = 1;
        }else{
        	$statusdriver = 7;
        }

        if (request()->data{'tipdocid'} == 1){

          $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.request()->data{'dni'}, true);
          $licenciavals = json_decode($licenciaval);

          if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
            $words = explode(" ", $licenciavals->fechaemision);
            $date1 = explode("/", $words[0]);
            $words2 = explode(" ", $licenciavals->fecharevalidacion);
            $date2 = explode("/", $words2[0]);

            $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
            $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
            $nrolicencia    = $licenciavals->nrolicencia;
            $classcategoria = $licenciavals->clasecategoria;
            $licestado      = $licenciavals->estado;
          }else{
            $licenciafecemi = null;
            $licenciafecven = null;
            $nrolicencia    = null;
            $classcategoria = null;
            $licestado      = null;
          }
        }else{
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = null;
          $classcategoria = null;
          $licestado      = null;
        }


        //registrar datos del auto
        $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.request()->data{'placa'}, true);
        $d = json_decode($fichero);
        $a = $d->getVehiculoPResult[0];

        if ($a->nu_plac_vige != null){
          $modelo = $a->modelo;
          $marca  = $a->marca;
          $color  = $a->color;
          $novin  = $a->no_vin;
          $nomtr  = $a->no_motr;
          $estado = $a->estado;
        }else{
          $modelo = null;
          $marca  = null;
          $color  = null;
          $novin  = null;
          $nomtr  = null;
          $estado = null;
        }
        // fin getvehiculoResult


        //seguros
        $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->data{'placa'}, true);
        $segurosvals = json_decode($valfechseguros);

        if (isset($segurosvals->NombreCompania)){
          $soatfecemi = explode("/", $segurosvals->FechaInicio);
          $soatfecven = explode("/", $segurosvals->FechaFin);

          $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
          $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
          $namecompany =  $segurosvals->NombreCompania;
          $typesoat    =  $segurosvals->NombreUsoVehiculo;
          $estsoat     =  $segurosvals->Estado;
        }else{
          //seguros
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          //fin seguros
        }
        //fin seguros

        if (file_drivers::where('id_customer', '=', $cc->id)->exists()){
            $file = file_drivers::where('id_customer', '=', $cc->id)->first();
            $file->status_user = $statusdriver;
            $file->placa = request()->data{'placa'};
            $file->model = $modelo;
            $file->marca = $marca;
            $file->year  = request()->data{'year'};
            $file->dnifecemi = date("Y-m-d");
            $file->dnifecven = date("Y-m-d");
            $file->licfecemi = $licenciafecemi;
            $file->licfecven = $licenciafecven;
            $file->soatfecemi = $soatfecemiv;
            $file->soatfecven = $soatfecvenv;
            $file->color_car =  $color;
            $file->num_vin = $novin;
            $file->num_motor = $nomtr;
            $file->est_car =   $estado;
            $file->licencia = $nrolicencia;
            $file->classcategoria = $classcategoria;
            $file->est_licencia = $licestado;
            $file->enterprisesoat = $namecompany;
            $file->type_soat = $typesoat;
            $file->est_soat = $estsoat;
            $file->save();
            $idfile = $file->id;
        } else {

            $filesdata = [
              'status_user' => $statusdriver,
              'placa' => strtoupper(request()->data{'placa'}),
              'model' => $modelo,
              'marca' => $marca,
              'year' => request()->data{'year'},
              'dnifecemi' => date("Y-m-d"),
              'dnifecven' => date("Y-m-d"),
              'licfecemi' => $licenciafecemi,
              'licfecven' => $licenciafecven,
              'soatfecemi' => $soatfecemiv,
              'soatfecven' => $soatfecvenv,
              'licencia' => $nrolicencia,
              'color_car' => $color,
              'num_vin' => $novin,
              'num_motor' => $no_motr,
              'est_car' => $estado,
              'id_customer' => $iduser,
              'classcategoria' => $classcategoria,
              'est_licencia' => $licestado,
              'enterprisesoat' => $namecompany,
              'type_soat' => $typesoat,
              'est_soat'  => $estsoat
            ];

            $idfile = file_drivers::create($filesdata)->id;
        }



        $tdata = [
          'id_file_drivers' =>  $idfile,
          'luz_baja' => request()->data{'light_low'},
          'luz_alta' => request()->data{'light_high'},
          'luz_freno' => request()->data{'light_brake'},
          'luz_emergencia' => request()->data{'light_emergency'},
          'luz_retroceso' => request()->data{'light_recoil'},
          'luz_intermitente' => request()->data{'light_intermittent'},
          'luz_antiniebla' => request()->data{'light_fog'},
          'luz_placa' => request()->data{'light_plate'},
          'arrancador' => request()->data{'engine_start'},
          'alternador' => request()->data{'alternator'},
          'bujias' => request()->data{'plugs'},
          'cable_bujias' => request()->data{'cable_plugs'},
          'bobinas' => request()->data{'coils'},
          'inyectores' => request()->data{'injectors'},
          'bateria' => request()->data{'drums'},
          'past_del' => request()->data{'front_pads'},
          'past_tras' => request()->data{'rear_pads'},
          'disc_del' => request()->data{'front_discs'},
          'disc_tras' => request()->data{'rear_discs'},
          'tamb_tras' => request()->data{'rear_drums'},
          'zapatas_tras' => request()->data{'rear_shoes'},
          'freno_emerg' => request()->data{'emergency_break'},
          'liq_freno' => request()->data{'brake_fluid'},
          'est_neumaticos' => request()->data{'tire_status'},
          'rev_tuercas' => request()->data{'nut_revision'},
          'pres_neumat' => request()->data{'tire_pressure'},
          'llanta_resp' => request()->data{'spare_tire'},
          // 'aros' => request()->data{'hoops'},
          // 'paracho_del' => request()->data{'front_bumper'},
          // 'paracho_post'  => request()->data{'rear_bumper'},
          // 'puert_del_izq'  => request()->data{'left_front_door'},
          // 'puert_del_der' => request()->data{'right_front_door'},
          // 'puert_post_izq' => request()->data{'left_rear_door'},
          // 'puert_post_der' => request()->data{'right_rear_door'},
          // 'guardafango_izq' => request()->data{'left_fender'},
          // 'guardafango_der' => request()->data{'right_fender'},
          // 'capota' => request()->data{'soft_top'},
          // 'vid_del_izq' => request()->data{'left_front_glass'},
          // 'vid_del_der' => request()->data{'right_front_glass'},
          // 'vid_post_izq' => request()->data{'left_rear_glass'},
          // 'vid_post_der' => request()->data{'right_rear_glass'},
          // 'parab_del' => request()->data{'front_windshield'},
          // 'parab_tras' => request()->data{'rear_windshield'},
          // 'maletero' => request()->data{'trunk'},
          // 'techo' => request()->data{'ceiling'},
          'fuga_aceite' => request()->data{'oil_leak'},
          'fuga_refrig' => request()->data{'refrigerant_leak'},
          'fuga_combust' => request()->data{'fuel_leak'},
          'filt_aceite' => request()->data{'oil_filter'},
          'filt_aire' => request()->data{'air_filter'},
          'filt_combus' => request()->data{'fuel_filter'},
          'filt_cabina' => request()->data{'cabin_filter'},
          'bomba_direc' => request()->data{'steering_pump'},
          'amorti_del' => request()->data{'front_shock_absorbers'},
          'amorti_post' => request()->data{'rear_shock_absorbers'},
          'palieres' => request()->data{'pallets'},
          'rotulas' => request()->data{'pads'},
          'termin_direc' => request()->data{'terminal_blocks'},
          'trapezios' => request()->data{'trapezios'},
          'resortes' => request()->data{'springs'},
          'aceite_caja' => request()->data{'box_oil'},
          'filtro_caja' => request()->data{'case_filter'},
          'caja_transf' => request()->data{'transfer_case'},
          'cardan' => request()->data{'cardan'},
          'diferencial' => request()->data{'differential'},
          'disco_embrague' => request()->data{'clutch_disc'},
          'collarin' => request()->data{'collarin'},
          'cruzetas' => request()->data{'crossbows'},
          'radiador' => request()->data{'radiator'},
          'ventiladores' => request()->data{'ventilators'},
          'correa_vent' =>  request()->data{'fan_belt'},
          'mangueras_agua' => request()->data{'water_hoses'},
          // 'tablero' => request()->data{'board'},
          'luz_tablero' => request()->data{'dash_light'},
          'luz_saloom' => request()->data{'saloon_light'},
          // 'asiento_piloto' => request()->data{'pilot_seat'},
          // 'asiento_copiloto' => request()->data{'passenger_seat'},
          // 'asientos_tras' => request()->data{'rear_seats'},
          // 'claxon' => request()->data{'horn'},
          'gata' => request()->data{'gata'},
          'llave_ruedas' => request()->data{'wheel_wrench'},
          'estuche_herra' => request()->data{'tool_kit'},
          'triangulo_seg' => request()->data{'safety_triangle'},
          'extintor' => request()->data{'extinguisher'},
          'note' => request()->data{'observacion'},
        ];

        $revistecn  = technical_review::where('id_file_drivers', $idfile)->first();

        if ($revistecn){
          technical_review::find($revistecn->id)->update($tdata);
          $id_tec = $revistecn->id;
        }else {
          $id_tec = technical_review::create($tdata)->id;
        }

        if ($id_tec >= 1){
              $object = "success";
              $mensaje = "Se registro correctamente";
        }else{
              $object =  "error";
              $mensaje = "hubo un error en el registro";
        }


        if ($status == 2){
          $estadoact = 1;
        }else{
          $estadoact = 0;
        }

        $filedriversby = file_drivers::where('id', '=', $idfile)->first();

        if ($status == 2 && !$filedriversby->revision_tecnica){
           $statusrev = null;
           $statusrev2 = 3;
        }else if ($status == 2 && $filedriversby->revision_tecnica){
           $statusrev = 1;
          $statusrev2 = 1;
        }else{
           $statusrev = 0;
           $statusrev2 = 0;
        }



        $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', $proceso)->first();
        $process_model->estatus = 1;
        $process_model->estatus2 = 1;
        $process_model->save();

        if (ProcesoValCond::where('id_file_drivers', $idfile)
        ->where('id_proceso_validacion',$codigoproceso)->exists()){

          $procevalconduc = ProcesoValCond::where('id_file_drivers', $idfile)
          ->where('id_proceso_validacion',$codigoproceso)->first();

          $procevalconduc->description = null;
          $revistecn  = technical_review::where('id_file_drivers', $idfile)->first();
          $procevalconduc->description = $revistecn->note;
	        $procevalconduc->approved = $statusrev;
          $procevalconduc->approved2 = $statusrev2;
	        $procevalconduc->estatus_proceso = 1;
          $procevalconduc->modified_by = auth()->user()->id;
          $procevalconduc->save();

        }else{
          $procevalconduc = ProcesoValCond::where('id_file_drivers', $idfile)->where('id_proceso_validacion',$codigoproceso)->first();
          $revistecn  = technical_review::where('id_file_drivers', $idfile)->first();

          $procesoCond =[
            'id_file_drivers'        => $idfile,
            'id_proceso_validacion'  => $codigoproceso,
            'modified_by'            => auth()->user()->id,
	          'approved'               => $statusrev,
            'approved2'               => $statusrev2,
            'description'            => $revistecn->note,
            'estatus_proceso'        => 1
          ];
          ProcesoValCond::create($procesoCond);
        }



        return response()->json([
            "object"=> $object,
            "message" => $mensaje,
            "idtec" => $id_tec
        ]);

      }

    function storetechnicalreview2(Request $r){
      $iduser  = request()->iduser;
      $status  = request()->status;
      $proceso = request()->proceso;
      $codigoproceso = request()->codigoproceso;

      $cc = Customer::where('id', '=', $iduser)->first();
      if (isset(request()->data{'phone-user'})){
        $cc->phone = request()->data{'phone-user'};
      }
      if (isset(request()->data{'email-user'})){
        $cc->email = request()->data{'email-user'};
      }
      $cc->first_name = request()->data{'name-user'};
      $cc->last_name  = request()->data{'ape-user'};
      $cc->dni        = request()->data{'dni'};
      $cc->id_type_documents = request()->data{'tipdocid'};
      $cc->save();


      if (request()->data{'tipdocid'} == 1){

        $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.request()->data{'dni'}, true);
        $licenciavals = json_decode($licenciaval);

        if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
          $words = explode(" ", $licenciavals->fechaemision);
          $date1 = explode("/", $words[0]);
          $words2 = explode(" ", $licenciavals->fecharevalidacion);
          $date2 = explode("/", $words2[0]);

          $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
          $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
          $nrolicencia    = $licenciavals->nrolicencia;
          $classcategoria = $licenciavals->clasecategoria;
          $licestado      = $licenciavals->estado;
        }else{
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = null;
          $classcategoria = null;
          $licestado      = null;
        }
      }else{
        $licenciafecemi = null;
        $licenciafecven = null;
        $nrolicencia    = null;
        $classcategoria = null;
        $licestado      = null;
      }


      //registrar datos del auto
      $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.request()->data{'placa'}, true);
      $d = json_decode($fichero);
      $a = $d->getVehiculoPResult[0];

      if ($a->nu_plac_vige != null){
        $modelo = $a->modelo;
        $marca  = $a->marca;
        $color  = $a->color;
        $novin  = $a->no_vin;
        $nomtr  = $a->no_motr;
        $estado = $a->estado;
      }else{
        $modelo = null;
        $marca  = null;
        $color  = null;
        $novin  = null;
        $nomtr  = null;
        $estado = null;
      }
      // fin getvehiculoResult


      //seguros
      $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->data{'placa'}, true);
      $segurosvals = json_decode($valfechseguros);

      if (isset($segurosvals->NombreCompania)){
        $soatfecemi = explode("/", $segurosvals->FechaInicio);
        $soatfecven = explode("/", $segurosvals->FechaFin);

        $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
        $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
        $namecompany =  $segurosvals->NombreCompania;
        $typesoat    =  $segurosvals->NombreUsoVehiculo;
        $estsoat     =  $segurosvals->Estado;
      }else{
        //seguros
        $soatfecemiv =  null;
        $soatfecvenv =  null;
        $namecompany =  null;
        $typesoat    =  null;
        $estsoat     =  null;
        //fin seguros
      }
      //fin seguros

      if (file_drivers::where('id_customer', '=', $cc->id)->exists()){
          $file = file_drivers::where('id_customer', '=', $cc->id)->first();
          $file->dni = request()->data{'dni'};
          $file->placa = request()->data{'placa'};
          $file->model = $modelo;
          $file->marca = $marca;
          $file->year  = request()->data{'year'};
          $file->dnifecemi = date("Y-m-d");
          $file->dnifecven = date("Y-m-d");
          $file->licfecemi = $licenciafecemi;
          $file->licfecven = $licenciafecven;
          $file->soatfecemi = $soatfecemiv;
          $file->soatfecven = $soatfecvenv;
          $file->color_car =  $color;
          $file->num_vin = $novin;
          $file->num_motor = $nomtr;
          $file->est_car =   $estado;
          $file->licencia = $nrolicencia;
          $file->classcategoria = $classcategoria;
          $file->est_licencia = $licestado;
          $file->enterprisesoat = $namecompany;
          $file->type_soat = $typesoat;
          $file->est_soat = $estsoat;
          $file->save();
          $idfile = $file->id;
      } else {

          $filesdata = [
            'dni'   => request()->data{'dni'},
            'placa' => strtoupper(request()->data{'placa'}),
            'model' => $modelo,
            'marca' => $marca,
            'year' => request()->data{'year'},
            'dnifecemi' => date("Y-m-d"),
            'dnifecven' => date("Y-m-d"),
            'licfecemi' => $licenciafecemi,
            'licfecven' => $licenciafecven,
            'soatfecemi' => $soatfecemiv,
            'soatfecven' => $soatfecvenv,
            'licencia' => $nrolicencia,
            'color_car' => $color,
            'num_vin' => $novin,
            'num_motor' => $no_motr,
            'est_car' => $estado,
            'id_customer' => $iduser,
            'classcategoria' => $classcategoria,
            'est_licencia' => $licestado,
            'enterprisesoat' => $namecompany,
            'type_soat' => $typesoat,
            'est_soat'  => $estsoat
          ];

          $idfile = file_drivers::create($filesdata)->id;
      }

      $tdata = [
        'id_file_drivers' =>  $idfile,
        //Luces
        'luz_baja' => request()->data{'light_low'},
        'luz_alta' => request()->data{'light_high'},
        'luz_freno' => request()->data{'light_brake'},
        'luz_retroceso' => request()->data{'light_recoil'},
        'obser_luces' => request()->data{'observacion1'},
        //Carroceria
        'puert_del_izq'  => request()->data{'left_front_door'},
        'vid_del_izq' => request()->data{'left_front_glass'},
        'parab_del' => request()->data{'front_windshield'},
        'capota' => request()->data{'soft_top'},
        'maletero' => request()->data{'trunk'},
        'est_neumaticos' => request()->data{'tire_status'},
        'obser_carroceria' => request()->data{'observacion2'},
        //Interior
        'asiento_piloto' => request()->data{'pilot_seat'},
        'luz_saloom' => request()->data{'saloon_light'},
        'luz_tablero' => request()->data{'dash_light'},
        'claxon' => request()->data{'horn'},
        'cinturon' => request()->data{'belt'},
        'obser_interior' => request()->data{'observacion3'},
        //herramientas
        'gata' => request()->data{'gata'},
        'llanta_resp' => request()->data{'spare_tire'},
        'estuche_herra' => request()->data{'tool_kit'},
        'triangulo_seg' => request()->data{'safety_triangle'},
        'extintor' => request()->data{'extinguisher'},
        'botiquin' => request()->data{'kit'},
        'obser_herramienta' => request()->data{'observacion4'},
      ];

    $revistecn  = technical_review::where('id_file_drivers', $idfile)->first();

    if ($revistecn){
      technical_review::find($revistecn->id)->update($tdata);
      $id_tec = $revistecn->id;
    }else {
      $id_tec = technical_review::create($tdata)->id;
    }



    if ($id_tec >= 1){
          $object = "success";
          $mensaje = "Se registro correctamente";
    }else{
          $object =  "error";
          $mensaje = "hubo un error en el registro";
    }

    if ($status == 2){
      $statusrev = true;
      $statustrace = true;
      $statustrace2 = 1;
    }else if ($status == 1){
      $statusrev = false;
      $statustrace = true;
      $statustrace2 = 1;
    }else{
      $statustrace = null;
      $statustrace2 = 3;
      $statusrev = null;
    }

    $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', 1)->first();
    $process_model->estatus = $statustrace;
    $process_model->estatus2 = $statustrace2;
    $process_model->save();

    $anioactual  = date('Y');
    $aniocar     = request()->data{'year'};
    $diferenciaYear = ($anioactual - $aniocar);

    $file_divers = file_drivers::find($idfile);

    if (($diferenciaYear > 3 && $diferenciaYear <= 5 && $file_divers->type_soat == "TAXI") || ($diferenciaYear > 4 && $diferenciaYear <= 5 && $file_divers->type_soat != "TAXI")) {

      if (!$file_divers->revision_tecnica && $statusrev == TRUE){
          $estadoval = null;
      }else if ($file_divers->revision_tecnica && $statusrev == TRUE){
          $estadoval = true;
      }else{
          $estadoval = false;
      }

    } else if ($diferenciaYear > 5) {

      if (!$file_divers->revision_tecnica && $statusrev == TRUE){
          $estadoval = null;
      }else if ($file_divers->revision_tecnica && $statusrev == TRUE){
          $estadoval = true;
      }else{
          $estadoval = false;
      }

    } else {
          $estadoval = $statusrev;
    }


    if($estadoval == false){
            $descrip = "Debe dirigirse a la oficina para completar su proceso";
            $estadoval = null;
    }else{
            $descrip = null;
    }



    $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',$proceso)
    ->where('id_file_drivers', $idfile)->first();

    $datoss = ['id_file_drivers' => $idfile, 'id_proceso_validacion' => $proceso,
                'estatus_proceso' => 1, 'approved' => $estadoval, 'modified_by' =>  auth()->user()->id, 'description' => $descrip];

    if ($ProcesoValidacionCond){
        ProcesoValCond::find($ProcesoValidacionCond->id)->update($datoss);
    }else {
        ProcesoValCond::create($datoss);
    }

    return response()->json([
        "object"=> $object,
        "message" => $mensaje,
        "idtec" => $id_tec
    ]);

  }
   /////// finde la funcion storetechnicalreview2




  function storetechnicalreview3(Request $r){
    $iduser  = request()->iduser;
    $status  = request()->status;
    $proceso = request()->proceso;
    $codigoproceso = request()->codigoproceso;

    $cc = Customer::where('id', '=', $iduser)->first();
    if (isset(request()->data{'phone-user'})){
      $cc->phone = request()->data{'phone-user'};
    }
    if (isset(request()->data{'email-user'})){
      $cc->email = request()->data{'email-user'};
    }
    $cc->first_name = request()->data{'name-user'};
    $cc->last_name  = request()->data{'ape-user'};
    $cc->dni        = request()->data{'dni'};
    $cc->id_type_documents = request()->data{'tipdocid'};
    $cc->save();


    if (request()->data{'tipdocid'} == 1){

      $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.request()->data{'dni'}, true);
      $licenciavals = json_decode($licenciaval);

      if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
        $words = explode(" ", $licenciavals->fechaemision);
        $date1 = explode("/", $words[0]);
        $words2 = explode(" ", $licenciavals->fecharevalidacion);
        $date2 = explode("/", $words2[0]);

        $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
        $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
        $nrolicencia    = $licenciavals->nrolicencia;
        $classcategoria = $licenciavals->clasecategoria;
        $licestado      = $licenciavals->estado;
      }else{
        $licenciafecemi = null;
        $licenciafecven = null;
        $nrolicencia    = null;
        $classcategoria = null;
        $licestado      = null;
      }
    }else{
      $licenciafecemi = null;
      $licenciafecven = null;
      $nrolicencia    = null;
      $classcategoria = null;
      $licestado      = null;
    }


    //registrar datos del auto
    $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.request()->data{'placa'}, true);
    $d = json_decode($fichero);
    $a = $d->getVehiculoPResult[0];

    if ($a->nu_plac_vige != null){
      $modelo = $a->modelo;
      $marca  = $a->marca;
      $color  = $a->color;
      $novin  = $a->no_vin;
      $nomtr  = $a->no_motr;
      $estado = $a->estado;
    }else{
      $modelo = null;
      $marca  = null;
      $color  = null;
      $novin  = null;
      $nomtr  = null;
      $estado = null;
    }
    // fin getvehiculoResult


    //seguros
    $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->data{'placa'}, true);
    $segurosvals = json_decode($valfechseguros);

    if (isset($segurosvals->NombreCompania)){
      $soatfecemi = explode("/", $segurosvals->FechaInicio);
      $soatfecven = explode("/", $segurosvals->FechaFin);

      $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
      $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
      $namecompany =  $segurosvals->NombreCompania;
      $typesoat    =  $segurosvals->NombreUsoVehiculo;
      $estsoat     =  $segurosvals->Estado;
    }else{
      //seguros
      $soatfecemiv =  null;
      $soatfecvenv =  null;
      $namecompany =  null;
      $typesoat    =  null;
      $estsoat     =  null;
      //fin seguros
    }
    //fin seguros

    if (file_drivers::where('id_customer', '=', $cc->id)->exists()){
        $file = file_drivers::where('id_customer', '=', $cc->id)->first();
        $file->dni = request()->data{'dni'};
        $file->placa = request()->data{'placa'};
        $file->model = $modelo;
        $file->marca = $marca;
        $file->year  = request()->data{'year'};
        $file->dnifecemi = date("Y-m-d");
        $file->dnifecven = date("Y-m-d");
        $file->licfecemi = $licenciafecemi;
        $file->licfecven = $licenciafecven;
        $file->soatfecemi = $soatfecemiv;
        $file->soatfecven = $soatfecvenv;
        $file->color_car =  $color;
        $file->num_vin = $novin;
        $file->num_motor = $nomtr;
        $file->est_car =   $estado;
        $file->licencia = $nrolicencia;
        $file->classcategoria = $classcategoria;
        $file->est_licencia = $licestado;
        $file->enterprisesoat = $namecompany;
        $file->type_soat = $typesoat;
        $file->est_soat = $estsoat;
        $file->save();
        $idfile = $file->id;
    } else {

        $filesdata = [
          'dni'   => request()->data{'dni'},
          'placa' => strtoupper(request()->data{'placa'}),
          'model' => $modelo,
          'marca' => $marca,
          'year' => request()->data{'year'},
          'dnifecemi' => date("Y-m-d"),
          'dnifecven' => date("Y-m-d"),
          'licfecemi' => $licenciafecemi,
          'licfecven' => $licenciafecven,
          'soatfecemi' => $soatfecemiv,
          'soatfecven' => $soatfecvenv,
          'licencia' => $nrolicencia,
          'color_car' => $color,
          'num_vin' => $novin,
          'num_motor' => $no_motr,
          'est_car' => $estado,
          'id_customer' => $iduser,
          'classcategoria' => $classcategoria,
          'est_licencia' => $licestado,
          'enterprisesoat' => $namecompany,
          'type_soat' => $typesoat,
          'est_soat'  => $estsoat
        ];

        $idfile = file_drivers::create($filesdata)->id;
    }

    $tdata = [
      'id_file_drivers' =>  $idfile,
      'note' => request()->data{'observacion'},
    ];


  $id_tec = technical_review::create($tdata)->id;

  if ($id_tec >= 1){
        $object = "success";
        $mensaje = "Se ha remitido al taller (PRETEL)";
  }else{
        $object =  "error";
        $mensaje = "hubo un error en el registro";
  }

  if ($status == 3){
    $statusrev = null;
    $statusrev2 = 3;
  }

  $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', $proceso)->first();
  $process_model->estatus = $statusrev;
  $process_model->estatus = $statusrev2;
  $process_model->save();

  $revistecn  = technical_review::where('id_file_drivers', $idfile)->first();


  $descrip = "Debe dirigirse al taller (PRETEL) Porque ".$revistecn->note;
  $estadoval = null;
  $estadoval2 = 3;

  $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',$proceso)
  ->where('id_file_drivers', $idfile)->first();

  $datoss = ['id_file_drivers' => $idfile, 'id_proceso_validacion' => $proceso,
              'estatus_proceso' => 1, 'approved' => $estadoval,'approved2' => $estadoval2,'modified_by' =>  auth()->user()->id, 'description' => $descrip];

  if ($ProcesoValidacionCond){
      ProcesoValCond::find($ProcesoValidacionCond->id)->update($datoss);
  }else {
      ProcesoValCond::create($datoss);
  }


  return response()->json([
      "object"=> $object,
      "message" => $mensaje
  ]);

}////////////////////// fin del storetechnicalreview3 ////////////////////////////


      // $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', $proceso)->first();
      // $process_model->estatus = 1;
      // $process_model->save();

      // $filedriversby = file_drivers::where('id', '=', $idfile)->first();
      //
      // if ($status == 2 && !$filedriversby->revision_tecnica){
      //    $statusrev = null;
      // }else if ($status == 2 && $filedriversby->revision_tecnica){
      //    $statusrev = 1;
      // }else{
      //    $statusrev = 0;
      // }
      //
      //
      //   if (ProcesoValCond::where('id_file_drivers', $idfile)
      //   ->where('id_proceso_validacion',$codigoproceso)->exists()){
      //
      //     $procevalconduc = ProcesoValCond::where('id_file_drivers', $idfile)
      //     ->where('id_proceso_validacion',$codigoproceso)->first();
      //     $procevalconduc->approved = $statusrev;
      //     $procevalconduc->estatus_proceso = 1;
      //     $procevalconduc->modified_by = auth()->user()->id;
      //     $procevalconduc->save();
      //
      //   }else{
      //
      //     $procesoCond =[
      //       'id_file_drivers'        => $idfile,
      //       'id_proceso_validacion'  => $codigoproceso,
      //       'modified_by'            => auth()->user()->id,
      //       'approved'               => $statusrev,
      //       'estatus_proceso'        => 1
      //     ];
      //     ProcesoValCond::create($procesoCond);
      //   }
      // return response()->json([
      //     "object"=> $object,
      //     "message" => $mensaje,
      //     "idtec" => $id_tec
      // ]);



    function checkpdf($idtec){
      $tecnicalreview = technical_review::where('id', '=', $idtec)->first();
      $filedrivers = file_drivers::where('id', '=', $tecnicalreview->id_file_drivers)->first();
      $id = $filedrivers->id_customer;

      if (true){
          if(file_drivers::where('id_customer', $id)->exists())
          {
            $d = file_drivers::where('id_customer',$id)->with('getCustomer','getStatusUser')->first();
            $rt = technical_review::where('id_file_drivers', $filedrivers->id)->first();

            $dp= $d->getCustomer()->first();
            $first_name = $dp->first_name;
            $last_name = $dp->last_name;
            $dni = $dp->dni;
            $placa = $d->placa;
            $marca = $d->marca;
            $modelo = $d->model;
            $year = $d->year;
            $color = $d->color_car;
            $nro_vin = $d->num_vin;
            $nro_vin = $d->num_vin;
            $nro_motor = $d->num_motor;
            $luz_baja = $rt->luz_baja;
            $luz_alta = $rt->luz_alta;
            $luz_freno = $rt->luz_freno;
            $luz_emergencia = $rt->luz_emergencia;
            $luz_retroceso = $rt->luz_retroceso;
            $luz_intermitente = $rt->luz_intermitente;
            $luz_antiniebla = $rt->luz_antiniebla;
            $luz_placa = $rt->luz_placa;
            $arrancador = $rt->arrancador;
            $alternador = $rt->alternador;
            $bujias = $rt->bujias;
            $cable_bujias = $rt->cable_bujias;
            $bobinas = $rt->bobinas;
            $inyectores = $rt->inyectores;
            $bateria = $rt->bateria;
            $past_del = $rt->past_del;
            $past_tras = $rt->past_tras;
            $disc_del = $rt->disc_del;
            $disc_tras = $rt->disc_tras;
            $tamb_tras = $rt->tamb_tras;
            $zapatas_tras = $rt->zapatas_tras;
            $freno_emerg = $rt->freno_emerg;
            $liq_freno = $rt->liq_freno;
            $est_neumaticos = $rt->est_neumaticos;
            $rev_tuercas = $rt->rev_tuercas;
            $pres_neumat = $rt->pres_neumat;
            $llanta_resp = $rt->llanta_resp;
            // $aros = $rt->aros;
            // $paracho_del = $rt->paracho_del;
            // $paracho_post  = $rt->paracho_post;
            // $puert_del_izq  = $rt->puert_del_izq;
            // $puert_del_der = $rt->puert_del_der;
            // $puert_post_izq = $rt->puert_post_izq;
            // $puert_post_der = $rt->puert_post_der;
            // $guardafango_izq = $rt->guardafango_izq;
            // $guardafango_der = $rt->guardafango_der;
            // $capota = $rt->capota;
            // $vid_del_izq = $rt->vid_del_izq;
            // $vid_del_der = $rt->vid_del_der;
            // $vid_post_izq = $rt->vid_post_izq;
            // $vid_post_der = $rt->vid_post_der;
            // $parab_del = $rt->parab_del;
            // $parab_tras = $rt->parab_tras;
            // $maletero = $rt->maletero;
            // $techo = $rt->techo;
            $fuga_aceite = $rt->fuga_aceite;
            $fuga_refrig = $rt->fuga_refrig;
            $fuga_combust = $rt->fuga_combust;
            $filt_aceite = $rt->filt_aceite;
            $filt_aire = $rt->filt_aire;
            $filt_combus = $rt->filt_combus;
            $filt_cabina = $rt->filt_cabina;
            $bomba_direc = $rt->bomba_direc;
            $amorti_del = $rt->amorti_del;
            $amorti_post = $rt->amorti_post;
            $palieres = $rt->palieres;
            $rotulas = $rt->rotulas;
            $termin_direc = $rt->termin_direc;
            $trapezios = $rt->trapezios;
            $resortes = $rt->resortes;
            $aceite_caja = $rt->aceite_caja;
            $filtro_caja = $rt->filtro_caja;
            $caja_transf = $rt->caja_transf ;
            $cardan = $rt->cardan;
            $diferencial = $rt->diferencial;
            $disco_embrague = $rt->disco_embrague;
            $collarin = $rt->collarin;
            $cruzetas = $rt->cruzetas;
            $radiador = $rt->radiador;
            $ventiladores = $rt->ventiladores;
            $correa_vent =  $rt->correa_vent;
            $mangueras_agua = $rt->mangueras_agua;
            // $tablero = $rt->tablero;
            $luz_tablero = $rt->luz_tablero;
            $luz_saloom = $rt->luz_saloom ;
            // $asiento_piloto = $rt->asiento_piloto;
            $cinturon = $rt->cinturon;
            // $asiento_copiloto = $rt->asiento_copiloto;
            // $asientos_tras = $rt->asientos_tras;
            // $claxon = $rt->claxon;
            $gata = $rt->gata;
            $llave_ruedas = $rt->llave_ruedas;
            $estuche_herra = $rt->estuche_herra;
            $triangulo_seg = $rt->triangulo_seg;
            $extintor = $rt->extintor;
            $botiquin = $rt->botiquin;
            $note = $rt->note;
            $obser_luces = $rt->obser_luces;
            $obser_carroceria = $rt->obser_carroceria;
            $obser_interior = $rt->obser_interior;
            $obser_herramienta = $rt->obser_herramienta;


            $fecha = date("Y-m-d", strtotime($rt->created_at));

            $pdf = PDF::loadView('external.drivers.trimprimir',compact(
              'dni',
              'first_name',
              'last_name',
              'color',
              'placa',
              'marca',
              'year',
              'modelo',
              'nro_vin',
              'nro_motor',
              'luz_baja',
              'luz_alta',
              'luz_freno',
              'luz_emergencia',
              'luz_retroceso',
              'luz_intermitente',
              'luz_antiniebla',
              'luz_placa',
              'arrancador',
              'alternador',
              'bujias',
              'cable_bujias',
              'bobinas',
              'inyectores',
              'bateria',
              'past_del',
              'past_tras',
              'disc_del',
              'disc_tras',
              'tamb_tras',
              'zapatas_tras',
              'freno_emerg',
              'liq_freno',
              'est_neumaticos',
              'rev_tuercas',
              'pres_neumat',
              'llanta_resp',
              // 'aros',
              // 'paracho_del',
              // 'paracho_post' ,
              // 'puert_del_izq' ,
              // 'puert_del_der',
              // 'puert_post_izq',
              // 'puert_post_der',
              // 'guardafango_izq',
              // 'guardafango_der',
              // 'capota',
              // 'vid_del_izq',
              // 'vid_del_der',
              // 'vid_post_izq',
              // 'vid_post_der',
              // 'parab_del',
              // 'parab_tras',
              // 'maletero',
              // 'techo',
              'fuga_aceite',
              'fuga_refrig',
              'fuga_combust',
              'filt_aceite',
              'filt_aire',
              'filt_combus',
              'filt_cabina',
              'bomba_direc',
              'amorti_del',
              'amorti_post',
              'palieres',
              'rotulas',
              'termin_direc',
              'trapezios',
              'resortes',
              'aceite_caja',
              'filtro_caja',
              'caja_transf',
              'cardan',
              'diferencial',
              'disco_embrague',
              'collarin',
              'cruzetas',
              'radiador',
              'ventiladores',
              'correa_vent',
              'mangueras_agua',
              // 'tablero',
              'luz_tablero',
              'luz_saloom',
              // 'asiento_piloto',
              // 'asiento_copiloto',
              // 'asientos_tras',
              // 'claxon',
              'gata',
              'llave_ruedas',
              'estuche_herra',
              'triangulo_seg',
              'extintor',
              'botiquin',
              'note',
              'fecha'



            ));
            return $pdf->download('control-y-analisis-vehicular.pdf');
          }else
          {
            return response()->json([
                "object"=> "error",
                "message"=>"El id no tiene imagenes"
            ]);
          }


      }else{
        return view('errors.403', compact('main'));
  }
  }

  // --------------------------------------------

  function checkpdf2($idtec){
    $tecnicalreview = technical_review::where('id', '=', $idtec)->first();
    $filedrivers = file_drivers::where('id', '=', $tecnicalreview->id_file_drivers)->first();
    $id = $filedrivers->id_customer;

    if (true){
        if(file_drivers::where('id_customer', $id)->exists())
        {
          $d = file_drivers::where('id_customer',$id)->with('getCustomer','getStatusUser')->first();
          $rt = technical_review::where('id_file_drivers', $filedrivers->id)->first();

          $dp= $d->getCustomer()->first();
          $first_name = $dp->first_name;
          $last_name = $dp->last_name;
          $dni = $dp->dni;
          $placa = $d->placa;
          $marca = $d->marca;
          $modelo = $d->model;
          $year = $d->year;
          $color = $d->color_car;
          $nro_vin = $d->num_vin;
          $nro_vin = $d->num_vin;
          $nro_motor = $d->num_motor;
          $licencia = $d->licencia;
          //Luces
          $luz_baja = $rt->luz_baja;
          $luz_alta = $rt->luz_alta;
          $luz_freno = $rt->luz_freno;
          $luz_retroceso = $rt->luz_retroceso;
          $obser_luces = $rt->obser_luces;
          //Carroceria
          $puert_del_izq = $rt->puert_del_izq;
          $vid_del_izq = $rt->vid_del_izq;
          $parab_del = $rt->parab_del;
          $capota = $rt->capota;
          $maletero = $rt->maletero;
          $est_neumaticos = $rt->est_neumaticos;
          $obser_carroceria = $rt->obser_carroceria;
          //Interior
          $asiento_piloto = $rt->asiento_piloto;
          $luz_saloom = $rt->luz_saloom ;
          $luz_tablero = $rt->luz_tablero;
          $claxon = $rt->claxon;
          $cinturon = $rt->cinturon;
          $obser_interior = $rt->obser_interior;
          //Herramientas
          $gata = $rt->gata;
          $llanta_resp = $rt->llanta_resp;
          $estuche_herra = $rt->estuche_herra;
          $triangulo_seg = $rt->triangulo_seg;
          $extintor = $rt->extintor;
          $botiquin = $rt->botiquin;
          $obser_herramienta = $rt->obser_herramienta;

          $fecha = date("Y-m-d", strtotime($rt->created_at));

          $pdf = PDF::loadView('external.drivers.trimprimir2',compact(
            'dni',
            'first_name',
            'last_name',
            'color',
            'placa',
            'marca',
            'year',
            'modelo',
            'nro_vin',
            'nro_motor',
            'licencia',
            //luces
            'luz_baja',
            'luz_alta',
            'luz_freno',
            'luz_retroceso',
            'obser_luces',
            //carroceria
            'puert_del_izq' ,
            'vid_del_izq',
            'parab_del',
            'capota',
            'maletero',
            'est_neumaticos',
            'obser_carroceria',
            //Interior
            'asiento_piloto',
            'luz_saloom',
            'luz_tablero',
            'claxon',
            'cinturon',
            'obser_interior',
            //HERRAMIENTAS
            'gata',
            'llanta_resp',
            'estuche_herra',
            'triangulo_seg',
            'extintor',
            'botiquin',
            'obser_herramienta',

            'fecha'

          ));
          return $pdf->download('revision-checklist.pdf');
        }else
        {
          return response()->json([
              "object"=> "error",
              "message"=>"El id no tiene imagenes"
          ]);
        }


    }else{
      return view('errors.403', compact('main'));
}
}
//---------------------------------------------------
  function getDrivers2(){
    if(Customer::where(request(){'campo'},request(){'dar'})->exists())
    {
      //$u =  User_office::where(request(){'campo'},request(){'dar'})->first();


   $rol= Main::where('users.id', '=', auth()->user()->id)
     ->where('main.status_user', '=', 'TRUE')
     ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
     ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
     ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
     ->join('users',    'users.id',              '=',   'rol_user.id_user')
     ->select('roles.id')
     ->first();

    $drivers = [];

    if ($rol->id == 7){
      $DriverQuery =  Customer::where('status_system', 'true')
                      ->Where('created_by', '=', auth()->user()->id)
                      ->where(request(){'campo'},request(){'dar'})
                      ->with('getfile','getCreate')
                      ->get();
    } else {

       $DriverQuery =   Customer::where('status_system', 'true')
                        ->where(request(){'campo'},request(){'dar'})
                        ->with('getfile','getCreate')
                        ->get();
    }

   foreach ($DriverQuery as $r) {

     $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


     $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

     $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';



       $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
       $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)->get();
       $status = "";

       // -----------------------------------------------------------------------------------------------------------------------
$canti = 0;
       if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
  {
    $contador = 0;
    $cantidad_obli = 0;

    $arr = [];

    foreach ($proces_proce as $key => $value) {

      if($value->getProcesModel->obligatorio)//si es obligatorio
      {
        $cantidad_obli++;
        foreach ($proces_val as $key_v => $value_v) {

          if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
          {
            if($value_v->approved === null)
            {

              $contador++;
              continue;
            }
            elseif($value_v->approved)//si paso en  aprobado
            {
                $contador++;
                $canti++;
                continue;
            }
            else{
              $canti = -1;
              break ;
            }




          }
          else{
            continue;
          }
        }


      }
      else {
        $contador++;
        continue;
      }

      if($canti == -1)
      {
        break;
      }

    }


  }else {
    $contador = 0;
  }




  if($canti == -1)
  {
      $status = "DESAPROBADO";
  }elseif ($contador==0) {
    $status = "PENDIENTE";
  }
  elseif ($cantidad_obli == $canti) {
    $status = "APROBADO";
  }elseif ($contador>0) {
    $status = "EN EVALUACIÓN";
  }else {
      $status = "INDEFINIDO";
  }
       // ------------------------------------------------------------------------------------------------------------------------

     $c = new stdClass();
     $c->date = "-";

     $b = new stdClass();
     $b->username = "-";

     $driver   = [
       'accion'         => $action,
       'resumen'        => $resumen,
       'reporte'        => $reporte,
       'dni'            => $r->dni        ?  $r->dni  : '-',
       'id_office'      => $r->id_office  ?  $r->id_office : '-',
       'first_name'     => $r->first_name ?  $r->first_name : '-',
       'last_name'      => $r->last_name  ?  $r->last_name : '-',
       'phone'          => $r->phone      ?  $r->phone : '-',
       'correo'         => $r->email      ?  $r->email : '-',
       'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
       'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
       'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
       'estado'         => $status,
       'date_create'    => $r->created_at                      ?  $r->created_at : $c,
       'created'    => $r->getCreate                      ?  $r->getCreate  : $b
     ];
     array_push($drivers, $driver);

   }
   return response()->json([
       "object"=> "success",
       "data"=> $drivers
   ]);
    }


  }
  // ------------------------------------------

  function getDrivers(){
    $rol= Main::where('users.id', '=', auth()->user()->id) 
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id')
      ->first();

    $DriverQuery = Customer::query();
    
    $id_office = request()->off_e;
    if ($id_office){
      $DriverQuery->Where('user' ,'=', $id_office);
    } 

    $dni = request()->dni;
    // return $dni;
    if ($dni)  $DriverQuery->Where('dni' ,'=', $dni);

    if (isset(request()->phone)){
      $telephone = request()->phone;
      if ($telephone) $DriverQuery->Where('phone' ,'=', $telephone);
    }


    if (isset(request()->email)){
      $email = strtoupper(request()->email);
      if ($email) $DriverQuery->Where('email' ,'=', $email);
    }

    $names = request()->name;
    if ($names) $DriverQuery->Where('first_name' , 'like', '%'.strtoupper($names).'%');

    $lastname =  request()->lastname;
    if ($lastname) $DriverQuery->Where('last_name' , 'like', '%'.strtoupper($lastname).'%');

    if (isset(request()->search)){
      $user_sponsor = request()->search;
      if ($user_sponsor) $DriverQuery->Where('sponsor_id' , '=', $user_sponsor);
    }


    if (isset(request()->placa)){
      $placa = strtoupper(request()->placa);
      if ($placa){
        if(file_drivers::where('placa','=', strtoupper($placa))->exists()){
          $ff = file_drivers::where('placa','=', strtoupper($placa))->first();
          $DriverQuery =  $DriverQuery->where('id','=',$ff->id_customer);
        }else{
          $DriverQuery =  $DriverQuery->where('id','=',0);
        }
      }
    }

    if ($rol->id == 7){
       $DriverQuery =  $DriverQuery->where('status_system', 'true')
                      //  ->Where('created_by', '=', auth()->user()->id)
                       ->with('getfile','getCreate','getCity')
                       ->get();
     } else {
       $DriverQuery = $DriverQuery->where('status_system', 'true')->with('getfile','getCreate','getCity')->get();
     }

    $drivers = [];
    // return response()->json($DriverQuery->get()); 
    foreach ($DriverQuery as $r) {
      $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


      $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

      $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';



        $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
        $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)
        ->with('getProcesModel')
        ->get();
        $status = "";

        // -----------------------------------------------------------------------------------------------------------------------
         $canti = 0;
        if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
   {
     $contador = 0;
     $cantidad_obli = 0;

     $arr = [];

     foreach ($proces_proce as $key => $value) {
if(DriverApi::where('id_file_drivers', $r->getfile->id)->exists())
{
if(DriverApi::where('id_file_drivers', $r->getfile->id)->first()->migrado)
{

     if(DriverApi::where('id_file_drivers', $r->getfile->id)->first()->estatusapi=== false){
        $canti = -3;
         break ;
    }
    else{
        $canti = -2;
         break ;
    }
  }
}

       if($value->getProcesModel->obligatorio)//si es obligatorio
       {
         $cantidad_obli++;
         foreach ($proces_val as $key_v => $value_v) {

           if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
           {
             if($value_v->approved === null)
             {

               $contador++;
               continue;
             }
             elseif($value_v->approved)//si paso en  aprobado
             {
                 $contador++;
                 $canti++;
                 continue;
             }
             else{
               $canti = -1;
               break ;
             }




           }
           else{
             continue;
           }
         }


       }
       else {
         $contador++;
         continue;
       }

       if($canti == -1)
       {
         break;
       }

     }


   }else {
     $contador = 0;
   }




   if($canti == -1)
   {
       $status = "DESAPROBADO";
   }elseif ($canti ==-2) {
     $status = "MIGRADO";
   }elseif ($canti ==-3) {
    $status = "INHABILITADO";
  }elseif ($contador==0) {
     $status = "PENDIENTE";
   }
   elseif ($cantidad_obli == $canti) {
     $status = "APROBADO";
   }elseif ($contador>0) {
     $status = "EN EVALUACIÃ“N";
   }else {
       $status = "INDEFINIDO";
   }
        // ------------------------------------------------------------------------------------------------------------------------

      $c = new stdClass();
      $c->date = "-";

      $b = new stdClass();
      $b->username = "-";

      $driver   = [
        'accion'         => $action,
        'resumen'        => $resumen,
        'reporte'        => $reporte,
        'dni'            => $r->dni        ?  $r->dni  : '-',
        'id_office'      => $r->user       ?  $r->user : '-',
        'first_name'     => $r->first_name ?  $r->first_name : '-',
        'last_name'      => $r->last_name   ?  $r->last_name : '-',
        'phone'          => $r->phone      ?  $r->phone : '-',
        'correo'         => $r->email      ?  $r->email : '-',
        'city'		 => $r->getCity->description,
        'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
        'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
        'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
        'estado'         => $status,
        'date_create'    => $r->getfile->created_at                      ?  $r->getfile->created_at : $c,
        'created'    => $r->getCreate                      ?  $r->getCreate  : $b
      ];
      array_push($drivers, $driver);

    }
    return response()->json(["data"=>$drivers]);
  }

  function listDriver_id()
  {
        if(!User::where('username', request()->user)->exists())
        {
          return response()->json([
            "object"=>"error",
            "message"=>"No existe el usuario"
          ]);
        }
        $user = User::where('username', request()->user)->first();

        $DriverQuery =   Customer::where('created_by',$user->id )
                        ->with('getfile','getCreate')
                        ->get();


    $drivers = [];

    foreach ($DriverQuery as $r) {

      $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


      $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

      $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';




  $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
  $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)->get();
  $status = "";

  // -----------------------------------------------------------------------------------------------------------------------
$canti = 0;
  if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
  {
  $contador = 0;
  $cantidad_obli = 0;
  $arr = [];

  foreach ($proces_proce as $key => $value) {

  if($value->getProcesModel->obligatorio)//si es obligatorio
  {
   $cantidad_obli++;
   foreach ($proces_val as $key_v => $value_v) {

     if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
     {
       if($value_v->approved === null)
       {

         $contador++;
         continue;
       }
       elseif($value_v->approved)//si paso en  aprobado
       {
           $contador++;
           $canti++;
           continue;
       }
       else{
         $canti = -1;
         break ;
       }

     }
     else{
       continue;
     }
   }


  }
  else {
   $contador++;
   continue;
  }

  if($canti == -1)
  {
   break;
  }

  }


  }else {
  $contador = 0;
  }




  if($canti == -1)
  {
  $status = "DESAPROBADO";
  }elseif ($contador==0) {
  $status = "PENDIENTE";
  }
  elseif ($cantidad_obli == $canti) {
  $status = "APROBADO";
  }elseif ($contador>0) {
  $status = "EN EVALUACIÓN";
  }else {
  $status = "INDEFINIDO";
  }
  // ------------------------------------------------------------------------------------------------------------------------




      $c = new stdClass();
      $c->date = "-";

      $b = new stdClass();
      $b->username = "-";

      $driver   = [
        'accion'         => $action,
        'resumen'        => $resumen,
        'reporte'        => $reporte,
        'dni'            => $r->dni        ?  $r->dni  : '-',
        'id_office'      => $r->id_office  ?  $r->id_office : '-',
        'first_name'     => $r->first_name ?  $r->first_name : '-',
        'last_name'      => $r->last_name  ?  $r->last_name : '-',
        'phone'          => $r->phone      ?  $r->phone : '-',
        'correo'         => $r->email      ?  $r->email : '-',
        'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
        'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
        'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
        'estado'         => $status,
        'date_create'    => $r->created_at                      ?  $r->created_at : $c,
        'created'    => $r->getCreate                      ?  $r->getCreate  : $b
      ];
      array_push($drivers, $driver);

    }
    return response()->json([
      "object"=>"success",
      "data"=>$drivers
    ]);
  }


   function updateDni()
   {
     if(Customer::where('dni',request()->dni)->exists())
     {
       return response()->json([
           "object"=> "WARNING",
           "message"=>"EL dni ya existe."
       ]);
     }else{
       $c = Customer::where('id',request()->id)->first();
       $c->first_name = request()->first_name;
       $c->last_name = request()->last_name;
       $c->dni = request()->dni;
       $c->save();
       return response()->json([
           "object"=> "success",
           "message"=>"El usuario fue actualizado."
       ]);
     }

   }

   public function sponsorview(){
     if(auth()->user()){
           $main = new MainClass();
           $main = $main->getMain();

          $title ='Conductores';
          $t = $this->PermisosDrivers();
          $superUsuario = $t->superUsuario;
          $updateSponsor = $t->updateSponsor;

          if ($updateSponsor == true || $superUsuario == true){
              return view('external.drivers.sponsorview',compact('title', 'main'));
          }else{
              return view('errors.403', compact('main'));
          }
     }
   }

   public function sponsorupdatedriver(Request $r){
     $iduser    = request()->iduser;
     $idoffice  = request()->idoffice;

     $sponsor = User::where('id',$iduser)->first();

     $file = Customer::where('id',$idoffice)->first();
     $file->created_by = $iduser;
     $file->save();

     return response()->json([
         "object"=> "success",
         "message"=>"El usuario fue actualizado."
     ]);
   }

   public function idofficeview(){
     if(auth()->user()){
         $main = new MainClass();
         $main = $main->getMain();

         $title ='Conductores';


         $t = $this->PermisosDrivers();
         $superUsuario = $t->superUsuario;
         $updateIDoficce = $t->updateIDoficce;

          if ($updateIDoficce == true || $superUsuario == true){
            return view('external.drivers.idofficev',compact('title', 'main'));
          }else{
            return view('errors.403', compact('main'));
          }


     }
   }

   public function idofficeupdatedriver(Request $r){
     $idofficenew  = request()->idofficenew;
     $idofficeact  = request()->idofficeact;


     $data  =  array("username" => $idofficenew);
     $data  = json_encode($data);


     $object  = '';
     $mensaje = '';

      $urlComplete  = $this->generateURLSignature('user_get');

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

     if($myArray->status == '200'){
       $file = Customer::where('id',$idofficeact)->first();
       $file->user = $idofficenew;
       $file->id_office = $myArray->data->posts->profile->id;
       $file->save();

       $object  = 'success';
       $mensaje = 'USUARIO ACTUALIZADO CORRECTAMENTE';
     }
     //INVALID USER NAME
     else if($myArray->status == '460'){
       $object  = 'error';
       $mensaje = 'USUARIO NO SE ENCUENTRA REGISTRADO';
     }

     return response()->json([
         "object"=> $object,
         "message"=> $mensaje
     ]);

   }

   public function viewpays(){
     if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();
          $title = 'Conductores';

          $users = Main::where('roles.id', '=', '7')
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->orderBy('users.username', 'ASC')->pluck('users.username', 'users.id');

            $t = $this->PermisosDrivers();
            $superUsuario = $t->superUsuario;
            $paySponsorL = $t->paySponsorL;

             if ($paySponsorL == true || $superUsuario == true){
               return view('external.drivers.viewpays',compact('title', 'main','users'));
             }else{
               return view('errors.403', compact('main'));
             }
     }
   }

   public function getDriverAprovedListViewByID() {
     if (request()->ajax( )){

       $usuario = request()->iduser;

       $drivers=[];
       //TRAZA DE PROCESO
       $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
       $cantpv = count($proceso_validacion);

       $procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->get();
       $file_driver  = file_drivers::whereIn('file_drivers.id', $procesototal)
       ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
	     ->where('customers.created_by', $usuario)
       ->with('getCustomer')->get();

       foreach ($file_driver as $k) {


          if(PaySponsor::where('id_user_offices',$k->getCustomer->id)->exists())
          {
            $ListDrivers = PaySponsor::where('id_user_offices',$k->getCustomer->id)->first();
            $action  =  '<a onclick="#"><i class="glyphicon glyphicon-ok-circle"></i><a>';
            $status  = "PAGADO";
            $fechapago = $ListDrivers->date_pay;
          }else{
            $action  =  '<a onclick="#"><i class="glyphicon glyphicon-ban-circle"></i><a>';
            $status  = "PENDIENTE";
            $fechapago = "";
          }


        $default    = '<i class="glyphicon glyphicon-ban-circle"></i>';
        $final      = '<i class="glyphicon glyphicon-ok-circle"></i>';

        $creador = User::where('id',$k->getCustomer->created_by)->first();



        $datos =[
          'action'         => $action,
          'id'             =>  $k->getCustomer->id,
          'sponsor'        => $creador->username,
          'firstnamespon'  => $creador->name,
          'lastnamespon'   => $creador->lastname,
          'phonespon'      => $creador->phone,
          'id_office'      => $k->getCustomer->id_office,
          'dni'            => $k->getCustomer->dni,
          'first_name'     => $k->getCustomer->first_name,
          'last_name'      => $k->getCustomer->last_name,
          'status'         => $status,
          'date_pay'       => $fechapago,
         ];

         array_push($drivers, $datos);
       }
       return response()->json([
         'data' => $drivers,
       ]);
     }

   }


   public function getDriverAprovedListView() {
     if (request()->ajax( )){

       $drivers=[];
       //TRAZA DE PROCESO
       $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
       $cantpv = count($proceso_validacion);

       $procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->get();
       $file_driver  = file_drivers::whereIn('id', $procesototal)->with('getCustomer')->get();

       foreach ($file_driver as $k) {


          if(PaySponsor::where('id_user_offices',$k->getCustomer->id)->exists())
          {
            $ListDrivers = PaySponsor::where('id_user_offices',$k->getCustomer->id)->first();
            $action  =  '<a onclick="#"><i class="glyphicon glyphicon-ok-circle"></i><a>';
            $status  = "PAGADO";
            $fechapago = $ListDrivers->date_pay;
          }else{
            $action  =  '<a onclick="#"><i class="glyphicon glyphicon-ban-circle"></i><a>';
            $status  = "PENDIENTE";
            $fechapago = "";
          }


        $default    = '<i class="glyphicon glyphicon-ban-circle"></i>';
        $final      = '<i class="glyphicon glyphicon-ok-circle"></i>';

        $creador = User::where('id',$k->getCustomer->created_by)->first();



        $datos =[
          'action'         => $action,
          'id'             => $k->getCustomer->id,
          'sponsor'        => $creador->username,
          'firstnamespon'  => $creador->name,
          'lastnamespon'   => $creador->lastname,
          'phonespon'      => $creador->phone,
          'id_office'      => $k->getCustomer->id_office,
          'dni'            => $k->getCustomer->dni,
          'first_name'     => $k->getCustomer->first_name,
          'last_name'      => $k->getCustomer->last_name,
          'status'         => $status,
          'date_pay'       => $fechapago,
         ];

         array_push($drivers, $datos);
       }
       return response()->json([
         'data' => $drivers,
       ]);
     }

   }

   public function updatedriverStatusPay(){
     $arr = [];
     $fecha = date("Y-m-d");
     $dia = date("d");
     $mes = date("m");

     if (request()->cant > 1){
       foreach (request()->id_offices as $idoffice) {
          array_push($arr,$idoffice{'id'});
          //$filedrivers = file_drivers::where('id',$idoffice{'id'})->first();
          $pays = PaySponsor::where('status_system','TRUE')->count();
          $conta = $pays + 1;

          $paySponsor = [
            'cod_pay' => "COD-".$dia."-".$mes."-".$conta,
            'id_customer' => $idoffice{'id'},
            'date_pay' => $fecha,
            'status_pay' => 1,
            'created_by' => auth()->user()->id,
          ];

          $res = PaySponsor::create($paySponsor);
      }
   }else{
      $id = request()->id_offices[0]{'id'};
      $pays = PaySponsor::where('status_system','TRUE')->count();
      $conta = $pays + 1;

      $paySponsor = [
        'cod_pay' => "COD-".$dia."-".$mes."-".$conta,
        'id_customer' => $id,
        'date_pay' => $fecha,
        'status_pay' => 1,
        'created_by' => auth()->user()->id,
      ];
      $res = PaySponsor::create($paySponsor);

   }

     return response()->json([
       'data' => 'success',
     ]);
   }

   public function auditoriaview(){
     if(auth()->user()){
         $main = new MainClass();
         $main = $main->getMain();
         $title ='Conductores';
         return view('external.drivers.audits',compact('title', 'main'));
     }
   }

   public function getAudits(){
     $auditss  = Audits::WHERE('auditable_type','App\Models\External\ProcesoValCond')
                      ->where('new_values', 'like', '%approved%')
                      ->where('user_id', 28)
                      ->with('getProcesoval')->get();
     $audits = [];

     foreach ($auditss as $value) {

       if ($value->getProcesoval->id_file_drivers > 0){
         $filedr = file_drivers::where('id', $value->getProcesoval->id_file_drivers)->with('getUserOffice')->first();
       }else{
         $filedr = 0;
       }


       if ($value->getProcesoval->id_proceso_validacion > 0){
         $procesos = ProcesoValidacion::where('id', $value->getProcesoval->id_proceso_validacion)->first();
       }else{
         $procesos = "ELIMINADO";
       }

       $estado = $value->new_values;
       $obj = json_decode($estado);

       if ($obj->{'approved'} == null){
         $estadoc = "EN EVALUACION";
       }else if ($obj->{'approved'} == 1 || $obj->{'approved'} == true){
         $estadoc = "APROBADO";
       }else if ($obj->{'approved'} == 0 || $obj->{'approved'} == false){
         $estadoc = "DESAPROBADO";
       }



       $action = '<button type="button" class="btn btn-primary fa fa-search" onclick="viewAudits('.$value->id.')"></button>';

        $datos =[
                'action'         => $action,
                'usuario'        => $value->getUsers->username,
                'idmodif'        => $value->auditable_id,
                'estado'         => $estadoc,
                'accion'         => $value->event,
                'proceso'        => (isset($procesos->nombre)) ? $procesos->nombre : $procesos,
                'id_office'      => (isset($filedr->getUserOffice->id_office)) ? $filedr->getUserOffice->id_office : $filedr,
                'datecreated'    => ph
                ];
        array_push($audits, $datos);
    }

    return response()->json([
      'data' => $audits,
    ]);

   }

   public function getAuditsbyID(){
     $id = request()->id;

     $auditss  = Audits::WHERE('id',$id)
                      ->with('getProcesoval')->first();
     $audits = [];

       if ($auditss->getProcesoval->id_file_drivers > 0){
         $filedr = file_drivers::where('id', $auditss->getProcesoval->id_file_drivers)->with('getUserOffice')->first();
       }else{
         $filedr = 0;
       }


       if ($auditss->getProcesoval->id_proceso_validacion > 0){
         $procesos = ProcesoValidacion::where('id', $auditss->getProcesoval->id_proceso_validacion)->first();
       }else{
         $procesos = "ELIMINADO";
       }

        $datos =[
                'usuario'        => $auditss->getUsers->username,
                'new_values'     => $auditss->new_values,
                'old_values'     => $auditss->old_values,
                'event'          => $auditss->event,
                'proceso'        => (isset($procesos->nombre)) ? $procesos->nombre : $procesos,
                'id_office'      => (isset($filedr->getUserOffice->id_office)) ? $filedr->getUserOffice->id_office : $filedr,
                'datecreated'    => date_format($auditss->created_at, "d/m/Y H:i:s"),
                ];
       array_push($audits, $datos);


     return response()->json([
       'data' => $audits
     ]);
   }

   public function PermisosDrivers(){
     $rol = Main::where('users.id', '=', auth()->user()->id)
       ->where('main.status_user', '=', 'TRUE')
       ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
       ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
       ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
       ->join('users',    'users.id',              '=',   'rol_user.id_user')
       ->select('roles.id','rol_user.id as id_roluser')
       ->first();

      $roluser = $rol{'id_roluser'};

     $t = $this->DriversPermisos();

     $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                   ->select('id_permission')
                   ->get();

     foreach ($permissions as $rs) {
          if ($rs->id_permission == 4){
            $t->superUsuario = true;
          }else if ($rs->id_permission == 45){
            $t->revisioncheck = true;
          }else if ($rs->id_permission == 49){
            $t->updateSponsor = true;
          }else if ($rs->id_permission == 50){
            $t->updateIDoficce = true;
          }else if ($rs->id_permission == 51){
            $t->paySponsorL = true;
          }
     }

     $t->rolid = $rol{'id'};

     return $t;
   }

   public function genererateCodeEmail()
      {
        $num = rand(999,9999);
        if (code_email::where('token',strtoupper(request()->email))->where('use', 0)->exists()){
         return response()->json([
             "object"=> "success",
             "menssage"=>"Ya se envio un codigo de verificacion a su correo por favor verifique e ingrese el codigo.",
             "data"=> 2
         ]);
        }else if (code_email::where('token',strtoupper(request()->email))->where('use', 1)->exists()){
         return response()->json([
             "object"=> "success",
             "menssage"=>"El correo ya se valido.",
             "data"=> 1
         ]);
        }else{
          if(!code_email::where('code_generate',$num)->where('use', 0)->exists())
          {

           $c = new code_email();
           $c->code_generate = $num;
           $c->token = strtoupper(request()->email);
           $c->use = 0;
           $c->save();

           $a = array('num' =>$num);
           $s = request()->email;


           Mail::send('external.drivers.emailConfirmation',$a,function($message) use ($s)
           {
              $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
              $message->to($s)->subject('WIN RIDE SHARE - CORREO DE CONFIRMACION');
           });

           return response()->json([
               "object"=> "success",
               "menssage"=>"Se envio un codigo de verificacion a su correo por favor verifique e ingrese el codigo.",
               "data"=> 0
           ]);
          }  else {
            return response()->json([
                "object"=> "error",
                "menssage"=>"Intentalo nuevamente.",
		"data"=> -1

            ]);
          }

         }
      }

      public  function confirmEmail()
      {
        if(code_email::where('code_generate',request()->num)->where('token',strtoupper(request()->token_generado))->exists())
        {
          $c = code_email::where('code_generate',request()->num)->where('token',strtoupper(request()->token_generado))->first();

          if ($c->use == 1){
            return response()->json([
                "object"=> "error",
                "menssage"=>"ERROR, EL CODIGO YA HA SIDO UTILIZADO ANTERIORMENTE."
            ]);
          }else{
            $c->use = 1;
            $c->save();
            return response()->json([
                "object"=> "success",
                "menssage"=>"Validado correctamente."]);
          }
        } else {
          return response()->json([
              "object"=> "error",
              "menssage"=>"ERROR, Ingrese un correo y codigo valido, verificar."
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
          CURLOPT_POSTFIELDS => "{ \"from\":\"TAXI WIN\", \"to\":\"+51".$phone."\", \"text\":\" SU CODIGO DE VERIFICACIÓN ES: ".$num."\"}",
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

      public function genererateCodePhone()
      {
        $num = rand(100000,999999);
        if (code_email::where('token',request()->phone)->where('use', 0)->exists()){
         return response()->json([
             "object"=> "success",
             "menssage"=>"Ya se envio un codigo de verificacion a su telefono por favor verifique e ingrese el codigo.",
             "data"=> 2
         ]);
       }else if (code_email::where('token',request()->phone)->where('use', 1)->exists()){
         return response()->json([
             "object"=> "success",
             "menssage"=>"El telefono ya se valido.",
             "data"=> 1
         ]);
       }else{

         if(!code_email::where('code_generate',$num)->exists())
        {
           $c = new code_email();
           $c->code_generate = $num;
           $c->token = request()->phone;
           $c->use = 0;
           $c->save();

           $this->sendmsm(request()->phone,$num);

           return response()->json([
               "object"=> "success",
               "menssage"=>"Se envio un codigo de verificacion a su telefono por favor verifique e ingrese el codigo.",
               "data"=> 0
           ]);
         } else {
            return response()->json([
                "object"=> "error",
                "menssage"=>"intentalo nuevamente."
            ]);
         }
       }
      }

      public  function confirmPhone()
      {
        if(code_email::where('code_generate',request()->num)->where('token',request()->token_generado)->exists())
        {
          $c = code_email::where('code_generate',request()->num)->where('token',request()->token_generado)->first();

          if ($c->use == 1){
            return response()->json([
                "object"=> "error",
                "menssage"=>"ERROR, EL CODIGO YA HA SIDO UTILIZADO ANTERIORMENTE."
            ]);
          }else{
            $c->use = 1;
            $c->save();
            return response()->json([
                "object"=> "success",
                "menssage"=>"Validado correctamente."]);
          }
        } else {
          return response()->json([
              "object"=> "error",
              "menssage"=>"ERROR, Ingrese un numero de telefono y codigo valido, verificar."
          ]);
        }
      }

      public function changevehicle(){
        $main = new MainClass();
        $main = $main->getMain();

        $title = 'Cambiar vehiculo';

        return view('external.drivers.changevehicle',compact('title', 'main'));
      }



}
