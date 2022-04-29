<?php

namespace App\Http\Controllers\api\policiales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \stdClass;
use App\Models\Customer\Customer;

class poicialesController extends Controller
{

    function getHeat($dni){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://rest.scrall.cc/v1/denuncias/encabezado",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "TAX",
        CURLOPT_POSTFIELDS =>"{\n    \"dni\": \"$dni\"\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        return $response;
    }

    function getAntecedentes($dni){
        $d = $this->getHeat($dni);
        $a = [];
	$u = Customer::where('dni',$dni)->first();
	//return response()->json($d->message);
        if($d->message == "found data"||$d->message == "not found data"){
            foreach ($d->result as $key => $value) {
                if($value->situacion != "DENUNCIANTE"){
                    $o = new \stdClass();
                    $o->datos = $value;
                    $o->atestado = $this->getBody($value->id_denuncia);
                    array_push($a,$o);
                }
            }
            

		if(true){
            $pdf = \PDF::loadView('driver.policiales.policiales',["data"=>$a,"dni"=>$dni,"customer"=>$u]);
            $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download($u->user.'.pdf');

		}
else return "no tiene denuncias.";
        }

        return "no se pudo obtener datos.";

    }

    function getBody($code){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://rest.scrall.cc/v1/denuncias/atestado",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "TAX",
        CURLOPT_POSTFIELDS =>"{\n    \"denuncia\": \"$code\"\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        return $response;
    }
}
