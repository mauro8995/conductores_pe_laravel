<?php

namespace App\Http\Controllers\api\MTC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Driver\Vehicle;
use \stdClass;

class MtcController extends Controller
{

  function getVehiculo($p)
  {
    if(Vehicle::where('number_enrollment',$p)->exists())
    {
      $v = Vehicle::where('number_enrollment',$p)->first();
      $d = $v->getDriver()->first();
      $c = $d->getCountry()->first();
      $a = new stdClass();
      $a->Vehicle = $v;
      $a->driver = $d;
      $a->CountryDriver = $c;
      return $a;
    }
    else
    {
      $a = new stdClass();
      $a->objet = "error";
      return $a;
    }
  }
  public function getVehiculoApi()
  {
    $p = request()->placa;
    $v=  $this->getVehiculo($p);
    if(true)
    {
      return response()->json([
        'object'  => "success",
         'data' =>$v
      ]);
    }
    else {
      return response()->json([
        'object'  => "alert",
        'message' => "No existe el vehicle"
      ]);
    }
  }
  public function apiSoatPlaca()
  {
    $p = request()->placa;


    $curl1 = curl_init();
        curl_setopt_array($curl1, array(
        CURLOPT_URL => "https://rest.scrall.cc/v1/soat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "TAX",
        CURLOPT_POSTFIELDS => "{\n    \"placa\": \"".$p."\"\n}",
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
        ),
      ));

      $response1 = curl_exec($curl1);
      curl_close($curl1);
      $segurosvals  = json_decode($response1);

      if(isset($segurosvals->result->nombrecompania)){
        return response()->json([
          'object'  => "sucesss",
          'message' => "Seguro validado con exito.",
          'data'    => $segurosvals->result
        ]);	
      }else{
        return response()->json([
          'object'  => "error",
          'message' => "No hemos podido validar su información",
          'data'    => null
        ]);
  
      }
  }




}
