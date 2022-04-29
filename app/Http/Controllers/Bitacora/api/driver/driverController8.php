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
class driverController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth.basic');
  // }


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

  function getDriverID(Request $request){
    $validator = Validator::make($request->all(),[
      'query' => 'required|string'
      ]);
      if ($validator->fails()) {
        return response()->json([  "object"   => "error",
        'errors' => $validator->errors()]);
      }

      if (Customer::where('user','=',$request{'query'})->orWhere('email','=',$request{'query'})->exists()){
          $custo = Customer::where('user','=',$request{'query'})->orWhere('email','=',$request{'query'})->first();
          if (dtCustomerType::where('id_customer', $custo->id)->where('id_customerType',2)->exists()){
              $datacond = file_drivers::where('id_customer',$custo->id)->first();
              if (DriverApi::where('id_file_drivers',$datacond->id)->exists()){
                $driverapp = DriverApi::where('id_file_drivers',$datacond->id)->first();
                return response()->json([
                  'id_country' => $custo->id_country,
                  'id_enlace'   =>  $datacond->id,
                  'driver_id' => $driverapp->driverid,
                  'status_driver' => $driverapp->estatusapi,
                  'first_name_driver' => $custo->first_name,
                  'last_name_driver' => $custo->last_name,
                  'id_office_driver' => $custo->id_office,
                  'country'          => $country->description
                ]);
              }else{
                return response()->json([
                  'object' => 'error',
                  'message' => 'EL CONDUCTOR NO ESTA MIGRADO APP'
                ]);
              }
          }else{
            return response()->json([
              'object' => 'error',
              'message' => 'NO ESTA REGISTRADO COMO CONDUCTOR'
            ]);
          }

        return response()->json(["object"=>"success"]);
      }else{
        return response()->json(["object"=>"error","message"=>"no se encuentra registrado el correo o el id oficina virtual"]);
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
    $custo = Customer::select('id_office','first_name','last_name','email','phone')->where('id','=',$datacond->id_customer)->first();
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
         $custo = Customer::select('id_office','id_country','first_name','last_name','email','phone')->where('id','=',$filedriver->id_customer)->first();
  
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
      	 'Location_emergency' => 'required'
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
          'comment_text' => "Una emergencia es reportada por el usuario ".$request{'Passenger_user'}." ".$nombre." para el viaje ".$request{'Booking_ID'}." para el pais ".$request{'Country'}." ",
          'comment_status' => 0,
          'comment_ip' => '0',
          'assigned_to' =>  3,
          'created_by' => 1,
          'modified_by' => $iddriver,
        ];
    $notickets = Notifications::create($dataticket);

    $curl = curl_init();
    $phone = 981623998;
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
                                            \"to\": \"+51".$phone."\",
                                            \"messageId\": \"MESSAGE-ID-123-xyz\"
                                          },
                                          {
                                            \"to\": \"+51".$phone."\"
                                          }
                                        ],
                                        \"text\": \"Su codigo es ".$uno.", repito su codigo es: ".$uno."\",
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

      return response()->json([
         'object'    => 'success'
      ]);
  }
}
