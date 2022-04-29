<?php

namespace App\Http\Controllers\api\driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Validator;
use App\Models\Customer\Customer;
use App\Models\Customer\dtCustomerType;
use App\Models\External\file_drivers;
use App\Models\External\DriverApi;
use App\Models\General\Country;
use App\Models\General\Notifications;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcesoValidacion;
use App\Models\External\ProcessTrace;
use App\Models\External\ProcessModel;
use App\Models\General\Type_document_identy;
class driverController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth.basic');
  // }

  public function __construct(){
    $this->url    = config('mywinrideshare.url');
    $this->secret = config('mywinrideshare.secret');
  }

  public function created(){
    return view('driver.created');
  }

   public function createdapp(){
    return view('driver.createdapp');
  }


  function validateplacaexi(){
    $val = request()->value;
    if (file_drivers::where('placa', '=', $val)->exists()){
      return [ 'mensaje' => 'Esta placa ya esta registrada',
             'flag' => true];
      }else{
      return ['mensaje' => '', 'flag' => false];
      }
  }

  public function validateplaca(Request $r){
    $placa = request()->placa;

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
    CURLOPT_POSTFIELDS => "{\n\"placa\": \"".$placa."\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  $myArray  = json_decode($response);

  if (isset($myArray->result)){
        if (isset($myArray->result->datosBoletaRPV)){
          return response()->json([
            'object'   =>"success",
            "menssage" => "placa valida."
          ]);
        }else{
          return response()->json([
            'object'   =>"success",
            "menssage" => "placa por validar."
          ]);
        }
  }else{
      return response()->json([
        'object' => "success",
        "menssage" => "placa por validar."
      ]);
  }
}

function validatelicenceexi(){
  $val = request()->value;

  if (file_drivers::where('licencia', '=', $val)->exists()){
    $updatew = file_drivers::where('licencia', '=', $val)
              ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
              ->first();
    return [ 'mensaje' => 'Esta licencia ya esta registrada',
               'flag' => true];
 }else{
   return ['flag' => false];
 }

}

public function validatelicencia(){
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

  if(isset($licenciavals->result)){
     if(isset($licenciavals->result->general->nrolicencia)){
        return response()->json([
          'object' =>"success",
          "menssage" => "Licencia valida.",
          "data" => $licenciavals->result->general->nrolicencia
        ]);
      }else{
        return response()->json([
          'object' =>"success",
          "menssage" => "Licencia por validar.",
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
}else{
  return response()->json([
    'object' =>"success",
    "menssage" => "Licencia por validar",
    "data" => null
  ]);
}

}

  function validatedni(){
    $val = request()->value;
    $tipdoc = request()->tipdoc;

    if (Customer::where('dni', '=', $val)->where('id_type_documents', '=', $tipdoc)->exists()){
      $update = Customer::where('dni', '=', $val)->where('id_type_documents', '=', $tipdoc)->first();
      if (dtCustomerType::where('id_customer', '=', $update->id)->where('id_customerType','=',2)->exists()){
        return [ 'mensaje' => 'Este numero de documento ya esta registrado',
              'flag' => true];
      }else{
        return ['flag' => false];
      }
    }else{
      return ['flag' => false];
    }
  }

  public function generateURLSignature($action) {
    $url    = 'https://mywinrideshare.com/api/xflow/'.$action;
    $secret = $this->secret;
    $expired = time() + 300;
    $url .= '?expires=' . $expired;
    $signature = hash_hmac('sha256', $url, $secret, false);
    return $url . '&signature=' . $signature;
  }

  public function getByUsernameOV($query,$type)
  {
      //$query = 'prueba_user';
      $data  =  array($type => $query);
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
          'phone'            => $myArray->data->posts->profile->phone_number,
          'country'          => $myArray->data->posts->address->country,
          'city'             => $myArray->data->posts->address->city,
          'address'          => $myArray->data->posts->address->address_1
        ];
        $datos = (object) $datos;
      }
      //INVALID USER NAME
      else if($myArray->status == '460'){
        $mensaje = 'Este usuario no existe, verifique que este escrito correctamente.';
      }

      return response()->json([
       'object'    => $object,
       'mensaje'   => $mensaje,
       'datos'     => $datos
      ]);

}

 public function getByPhoneEmailOV($query,$type){
   $data  =  array($type => $query);
   $data  = json_encode($data);

   $object  = 'error';
   $mensaje = '';
   $datos   = null;
   $urlComplete  = $this->generateURLSignature('user_lookup');

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
       'userid'           => $myArray->data->posts->userid,
       'username'         => $myArray->data->posts->username
     ];
     $datos = (object) $datos;
   }
   //INVALID USER NAME
   else if($myArray->status == '460'){
     $mensaje = 'Este usuario no existe, verifique que este escrito correctamente.';
   }

   return response()->json([
    'object'    => $object,
    'mensaje'   => $mensaje,
    'datos'     => $datos
   ]);
 }

  public function validateoffice(){
    $val = request()->value;
    $type = "username";
    if (Customer::where('user', '=', $val)->exists()){
      $update = Customer::where('user', '=', $val)->first();
      if (file_drivers::where('id_customer', '=', $update->id)->where('photo_perfil','=',null)->exists()){
        $files = file_drivers::where('id_customer', '=', $update->id)->where('photo_perfil','=',null)->first();
        return [ 'mensaje' => 'Este usuario ya se encuentra registrado',
              'flag' => true, 'oficinav' => true, 'id' => $files->id];
      }else{
        return [ 'mensaje' => 'Este usuario ya se encuentra registrado',
              'flag' => true, 'oficinav' => false];
      }
    }else{
      $validate  = $this->getByUsernameOV($val,$type);
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


  public function validateuserphoneemail(){
    $val = request()->value;
    $cantval = strlen($val);
    if ($cantval == 9){
      $valu = "+51".$val;
      $type = "phone_number";
    }else{
      $valu = $val;
      $type = "email_address";
    }
    $validate  = $this->getByPhoneEmailOV($valu,$type);

    if ($validate->original{'datos'}->userid == null){
      $flag = true;
      $mensaje = "No existe un usuario con esos datos, verifique que este escrito correctamente.";
      $od = null;
    }else{
      $flag = false;
      $user = $validate->original{'datos'}->username;
      $types = "username";
      $users = $this->getByUsernameOV($user,$types);
      $od = $users->original;
      $mensaje = $validate->original{'mensaje'};
    }

    return ['flag' => $flag, 'oficinavss' => $od, 'oficinav' => $validate->original{'datos'}, 'mensaje' => $mensaje];
  }


  public function getGenerateExcel()
  {


    $ch = curl_init('https://taxi-win.app/wp-json/api/v1/registrados');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
      );
      $result = curl_exec($ch);
      $myArray = json_decode($result);
      $a = [];
    foreach ($myArray as $key => $value) {
      $v =	[
        "dni" => $value->dni,
        "Nombres"=>$value->first_name,
        "Apellidos"=>$value->last_name,
        "Celular"=>$value->phone,
        "Correo"=>$value->billing_email,
        "Sponsor"=>$value->sponsor,
        "Pais"=>$value->pais,
        "Marca"=>$value->Marca,
        "Modelo"=>$value->Modelo,
        "Color"=>$value->Color,
        "Anio"=>$value->Anio,
        "Placa"=>$value->Placa,
      ];
				array_push($a,$v);

    }

     $list = collect($a);
     return  (new FastExcel($list))->download('generado'.date("Y-m-d H:i:s").'.xlsx');

  }

  public function getTypeDocumentID(){
    $type = Type_document_identy::where('status_system','=',TRUE)->get();
    return response()->json([ "data" => $type]);
  }

  function getDriverID(Request $request){
    $validator = Validator::make($request->all(),[
        'id_type_document' => 'required',
        'nro_document' => 'required'
      ]);
      if ($validator->fails()) {
        return response()->json([  "object"   => "error",
        'errors' => $validator->errors()]);
      }

      if (Customer::where('id_type_documents','=',$request{'id_type_document'})->Where('dni','=',$request{'nro_document'})->exists()){
          $custo = Customer::where('id_type_documents','=',$request{'id_type_document'})->Where('dni','=',$request{'nro_document'})->with('getTypeDocuments','getState')->first();
          $datacond = file_drivers::where('id_customer',$custo->id)->first();
          if (DriverApi::where('id_file_drivers',$datacond->id)->exists()){
                $driverapp = DriverApi::where('id_file_drivers',$datacond->id)->first();
                $country = Country::where('id',$custo->id_country)->first();
                $data = [
                  'iso_ciudad' => $custo->getState->code,
                  'id_country' => $custo->id_country,
                  'id_enlace'   =>  $datacond->id,
                  'driver_id' => $driverapp->driverid,
                  'status_driver' => $driverapp->estatusapi,
                  'first_name_driver' => $custo->first_name,
                  'last_name_driver' => $custo->last_name,
                  'id_office_driver' => $custo->id_office,
                  'country'          => $country->description,
                  'username'         => $custo->user,
                  'email'            => $custo->email,
                  'phone'            => $custo->phone,
                  'typedocument'     => $custo->getTypeDocuments->description
                ]; 
                return response()->json([
                  'object' => 'success',
                  'data' => $data,
                  'message' => 'éxito'
                ]);
              }else{
                return response()->json([
                  'object' => 'error',
                  'message' => 'EL CONDUCTOR NO ESTA MIGRADO APP'
                ]);
              }
        return response()->json(["object"=>"success"]);
      }else{
        return response()->json(["object"=>"error","message"=>"no se encuentra registrado ese documento."]);
      }

  }

  function get_driver(Request $request){
    $validator = Validator::make($request->all(),[
      'id_enlace' => 'required|exists:file_drivers,id'
      ]);

    if ($validator->fails()) {
        return response()->json([  "object"   => "error",
        'errors' => $validator->errors()]);
    }

    $datacond = file_drivers::where('id',$request{'id_enlace'})->first();
    $custo = Customer::select('id_office','first_name','last_name','email','phone','user')->where('id','=',$datacond->id_customer)->first();
    if (DriverApi::where('id_file_drivers',$datacond->id)->exists()){
      return response()->json([
        'data' => $custo,
        'object' => 'success',
        'message' => 'EL CONDUCTOR ESTA MIGRADO APP'
      ]);
    }else{
      return response()->json([
        'data' => null,
        "object"   => "error",
        'message' => 'EL CONDUCTOR NO ESTA MIGRADO APP'
      ]);
    }
  }

  function aceptoterminosycondiciones($email){
    if (Customer::Where('email','=',$email)->exists()){
        $custo = Customer::Where('email','=',$email)->first();
        if (dtCustomerType::where('id_customer', $custo->id)->where('id_customerType',2)->exists()){
            $datacond = file_drivers::where('id_customer',$custo->id)->first();
            if (DriverApi::where('id_file_drivers',$datacond->id)->exists()){
              $driverapp = DriverApi::where('id_file_drivers',$datacond->id)->first();
              //conductor migrado
              $custo->status = true;
              $custo->save();
              return view('AtencionCliente.sendTerminos',compact(''));
            }else{
              return redirect()->away('https://winescompartir.com/');
            }
        }else{
          return redirect()->away('https://winescompartir.com/');
        }
    }else{
      return redirect()->away('https://winescompartir.com/');
    }
  }

  function get_driverAPP(Request $request){
    $validator = Validator::make($request->all(),[
      'id_driver' => 'required|exists:driver_api,driverid'
      ]);

    if ($validator->fails()) {
        return response()->json([  "object"   => "error",
        'errors' => $validator->errors()]);
    }

    if (DriverApi::where('driverid',$request{'id_driver'})->exists()){
	 $driveapi  = DriverApi::where('driverid',$request{'id_driver'})->first();
       	 $filedriver =  file_drivers::where('id',$driveapi->id_file_drivers)->first();
         $custo = Customer::select('id_office','user','id_country','id_city','id_state','first_name','last_name','email','phone','dni','id_type_documents')->where('id','=',$filedriver->id_customer)->first();

      return response()->json([
        'data' => $custo,
        'object' => 'success',
        'message' => 'EL CONDUCTOR ESTA MIGRADO APP'
      ]);
    }else{
      return response()->json([
        'data' => null,
        "object"   => "error",
        'message' => 'EL CONDUCTOR NO ESTA MIGRADO APP'
      ]);
    }
  }


  function emergency_app(Request $request){
     $validator = Validator::make($request->all(),[
         'User_Type' => 'required',
         'ID_driver' => 'required',
      	 'Booking_ID' => 'required',
      	 'Passenger_name' => 'required',
      	 'Passenger_email' => 'required',
      	 'Passenger_phone' => 'required',
      	 'Emergency_date' => 'required',
      	 'Location_emergency' => 'required',
         'Country' => 'required'
     ]);

    if ($validator->fails()) {
        return response()->json([  "object"   => "error",
        'errors' => $validator->errors()]);
    }

    if (DriverApi::where('driverid',$request{'ID_driver'})->exists()){
	$driveapi  = DriverApi::where('driverid',$request{'ID_driver'})->first();
        $filedriver =  file_drivers::where('id',$driveapi->id_file_drivers)->first();
        $iddriver = $filedriver->id_customer;

    }else{
    	$iddriver = 145;
    }

    if ($request{'User_Type'} == "Passenger"){
	$tipouser = "pasajero";
        $nombre = $request{'Passenger_name'};
    }else{
	$tipouser = "conductor";
        $customer = Customer::where('id',$iddriver)->first();
        $nombre = $customer->first_name." ".$customer->last_name;
    }


    $dataticket = [
          'comment_subject' => "-",
          'comment_text' => "Una emergencia es reportada por el usuario ".$nombre." para el viaje ".$request{'Booking_ID'}." para el pais ".$request{'Country'}." ",
          'comment_status' => 0,
          'comment_ip' => '0',
          'assigned_to' =>  3,
          'created_by' => 1,
          'modified_by' => $iddriver,
        ];
    $notickets = Notifications::create($dataticket);

    $curl = curl_init();
    $phone2 = 984771665;
    $phone3 = 925717512;
    $phone4 = 917006087;
    $phone5 = 925518836;
    $uno = "EMERGENCIA";


            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.infobip.com/tts/3/advanced",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{
                                    \"bulkId\": \"BULK-ID-123-xyz\",
                                    \"messages\": [
                                      {
                                        \"from\": \"41793026700\",
                                        \"destinations\": [
                                          {
                                            \"to\": \"+51".$phone2."\"
                                          },
                                          {
                                            \"to\": \"+51".$phone3."\"
                                          },
                                          {
                                            \"to\": \"+51".$phone4."\"
                                          },
                                          {
                                            \"to\": \"+51".$phone5."\"
                                          }
                                        ],
                                        \"text\": \"Su codigo es ".$uno." presionada por el Pais ".$request{'Country'}."  , repito su codigo es: ".$uno."\",
                                        \"language\": \"es\",
                                        \"voice\": {
                                            \"name\": \"Juana\",
                                            \"gender\": \"female\"
                                        },
                                        \"speechRate\": 0.8,
                                        \"pause\": 3
                                      }
                                    ]
                                  }",
            CURLOPT_HTTPHEADER => array(
              "accept: application/json",
              "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
              "content-type: application/json"
            ),
          ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

     $dataD  =   array(
         "ID_driver" => $request{'ID_driver'},
      	 "Booking_ID" => $request{'Booking_ID'},
      	 "Passenger_name" => $request{'Passenger_name'},
      	 "Passenger_email" => $request{'Passenger_email'},
      	 "Passenger_phone" => $request{'Passenger_phone'},
      	 "Emergency_date" => $request{'Emergency_date'},
      	 "Location_emergency" => $request{'Location_emergency'},
         "Country" => $request{'Country'},
         "User_Type" => $request{'User_Type'}
     );


     $dataD  =   json_encode($dataD);
     $ch     =   curl_init('https://servicedesk.wintecnologies.com/api/driver/emergencyapp');
                      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_POSTFIELDS,$dataD);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'content-type: application/json',
                        'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt'
          ));
      $result         = curl_exec($ch);
      $myArray        = json_decode($result);
      curl_close($ch);


      return response()->json([
         'object'    => 'success'
      ]);
  }


  public function userOfficesRegister(){
    $sponsor = 1;

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
    }else if (request()->users{'provincia'} == '2818'){
      $city = 32045;
    }else if (request()->users{'provincia'} == '2833'){
      $city = 32206;
    }else if (request()->users{'provincia'} == '2813'){
      $city = 31995;
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

    $datos=[
      'user'        => request()->user,
      'first_name'  => strtoupper(request()->users{'first_name'}),
      'last_name'   => strtoupper(request()->users{'last_name'}),
      'email'       => strtoupper(request()->email),
      'dni'         => "".request()->users{'num_doc'}."",
      'phone'       => request()->phone,
      'id_country'  => 172,
      'id_city'     => $city,
      'id_state'    => request()->users{'provincia'},
      'sponsor_id'  => $sponsor,
      'created_by'  => 1,
      'id_type_documents' => request()->users{'type_docs'},
      'id_office'   => request()->id_office,
      'status' => true
    ];

    if (request()->id_office == 1){
      $idoffice = null;
    }else{
      $idoffice = request()->id_office;
    }

    if (Customer::where('dni', '=', "".request()->users{'num_doc'}."")->where('id_type_documents', '=', request()->users{'type_docs'})->exists()){
      $update = Customer::where('dni', '=', "".request()->users{'num_doc'}."")->where('id_type_documents', '=', request()->users{'type_docs'})->first();
      return [ 'mensaje' => 'ESTE NUMERO DE DOCUMENTO YA ESTA REGISTRADO',
            'flag' => 'false'];
    }else if (Customer::where('email', '=', strtoupper(request()->email))->exists()){
      $update = Customer::where('email', '=', strtoupper(request()->email))->first();
      return [ 'mensaje' => 'ESTE CORREO YA ESTA REGISTRADO',
            'flag' => 'false'];

     }else if (Customer::where('phone', '=', request()->phone)->exists()){
        $update = Customer::where('phone', '=', request()->phone)->first();
        return [ 'mensaje' => 'ESTE TELEFONO YA ESTA REGISTRADO',
              'flag' => 'false'];

     }else if (file_drivers::where('licencia', '=', request()->users{'licencia'})->exists()){
       $updatew = file_drivers::where('licencia', '=', request()->users{'licencia'})
                  ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                  ->first();
       return [ 'mensaje' => 'ESTA LICENCIA YA ESTA REGISTRADA',
                  'flag' => 'false'];

      }else if (file_drivers::where('placa', '=', request()->users{'placa'})->exists()){
        $updates = file_drivers::where('placa', '=', request()->users{'placa'})
                  ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                  ->first();
        return [ 'mensaje' => 'ESTA PLACA YA ESTA REGISTRADA',
                    'flag' => 'false'];
      }else {
        $user = Customer::create($datos)->id;
        $datos = dtCustomerType::updateOrCreate(['id_customer' => $user, 'id_customerType' => 2] , ['id_customer' => $user, 'id_customerType' => 2] );
        $data = [
            'placa' => strtoupper(request()->users{'placa'}),
            'licencia' => strtoupper(request()->users{'licencia'}),
            'id_customer' => $user
         ];
         $filedriver = file_drivers::create($data)->id;

         $process_model =  ProcessModel::orderby('sec_actual', 'asc')->get();
         foreach ($process_model as $x) {
           $datos =[
             'id_file_drivers'  => $filedriver,
             'id_process_model' => $x{'id'},
             'sec_actual'       => $x{'sec_actual'},
             'sec_sig'          => $x{'sec_sig'},
             'modified_by'      => 1,
             'estatus2'      => 3,
           ];
           ProcessTrace::create($datos)->id;
         }

         return [ 'mensaje' => 'REGISTRO EXITOSO',
               'flag' => 'true', 'id' => $filedriver];
      }
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


          $datos = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 1,
                    'estatus_proceso' => 1, 'approved' => null,'approved2' => 3, 'modified_by' =>  1, 'description' => null];

	  if (ProcesoValCond::where('id_proceso_validacion',1)->where('id_file_drivers', $r->id_file)->exists()){
	      $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',1)->where('id_file_drivers', $r->id_file)->first();
              ProcesoValCond::find($ProcesoValidacionCond->id)->update($datos);
          }else{
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



            $datos1 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 3,
                     'estatus_proceso' => 1, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  1, 'description' => $descrip];

            if (ProcesoValCond::where('id_proceso_validacion',3)->where('id_file_drivers', $r->id_file)->exists()){
		$ProcesoValidacionCond1  = ProcesoValCond::where('id_proceso_validacion',3)->where('id_file_drivers', $r->id_file)->first();
                ProcesoValCond::find($ProcesoValidacionCond1->id)->update($datos1);
	    }else{
		ProcesoValCond::create($datos1);
            }

          }else{
            $estatus = null;
            $estatus2 = 3;
            $descrip = "Faltan subir documentos";

            $datos2 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 3,
                      'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  1, 'description' => $descrip];


	    if (ProcesoValCond::where('id_proceso_validacion',3)->where('id_file_drivers', $r->id_file)->exists()){
          	$ProcesoValidacionCond2  = ProcesoValCond::where('id_proceso_validacion',3)->where('id_file_drivers', $r->id_file)->first();
		ProcesoValCond::find($ProcesoValidacionCond2->id)->update($datos2);
            }else{
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



          $datoss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => $proceso,
                    'estatus_proceso' => 1, 'approved' => $estatuss,'approved2' => $estatuss2, 'modified_by' =>  1, 'description' => $descripp];



	  if (ProcesoValCond::where('id_proceso_validacion',$proceso)->where('id_file_drivers', $r->id_file)->exists()){
	      $ProcesoValidacionConds  = ProcesoValCond::where('id_proceso_validacion',$proceso)->where('id_file_drivers', $r->id_file)->first();
              ProcesoValCond::find($ProcesoValidacionConds->id)->update($datoss);
          }else{
	      ProcesoValCond::create($datoss);
          }


          }
       }

       if ($proceso == 2){
         $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
         $filedrivers->status_user = 3;
         $filedrivers->save();

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



            $datosss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => $proceso,
                      'estatus_proceso' => 1, 'approved' => $estatusss,'approved2' => $estatusss2, 'modified_by' =>  1, 'description' => $descrippp];


 	    if (ProcesoValCond::where('id_proceso_validacion',$proceso)->where('id_file_drivers', $r->id_file)->exists()){
		$ProcesoValidacionCondss  = ProcesoValCond::where('id_proceso_validacion',$proceso)->where('id_file_drivers', $r->id_file)->first();
 		ProcesoValCond::find($ProcesoValidacionCondss->id)->update($datosss);
            }else{
		ProcesoValCond::create($datosss);
            }

          }else{
            $estatus = null;
            $estatus2 = 3;
            $descrip = "Faltan subir fotos del auto";



            $datos4 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2,
                      'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'modified_by' =>  1, 'description' => $descrip];


	    if (ProcesoValCond::where('id_proceso_validacion',2)->where('id_file_drivers', $r->id_file)->exists()){
		$ProcesoValidacionCond4  = ProcesoValCond::where('id_proceso_validacion',2)->where('id_file_drivers', $r->id_file)->first();
		ProcesoValCond::find($ProcesoValidacionCond4->id)->update($datos4);
	    }else{
		ProcesoValCond::create($datos4);
	    }

          }
       }

       if (file_drivers::where('id', $r->id_file)
         ->where('car_interna','<>',null)
         ->where('car_interna2','<>',null)
         ->where('car_externa','<>',null)
         ->where('dni_frontal','<>',null)
         ->where('dni_back','<>',null)
         ->where('lic_frontal','<>',null)
         ->where('lic_back','<>',null)
         ->where('tar_veh_frontal','<>',null)
         ->where('tar_veh_back','<>',null)
         ->where('soat_frontal','<>',null)
         ->where('photo_perfil','<>',null)
         ->exists()){
         $filedrivers1 = file_drivers::where('id', '=', $r->id_file)->with('getCustomer')->first();
         $dataticket = [
             'comment_subject' => "Registro Completo",
             'comment_text'    => $filedrivers1->getCustomer->first_name." ".$filedrivers1->getCustomer->last_name." completo un registro exitosamente",
             'comment_status'  => 0,
             'comment_ip'      => '0',
             'assigned_to'     => 5,
             'created_by'      => 1,
             'modified_by'     => $r->id_file,
        ];
        $notickets = Notifications::create($dataticket);
       }

        return response()->json([
            "rol"=> "éxito"
        ]);
  }

}
