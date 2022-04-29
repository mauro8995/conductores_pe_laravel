<?php

namespace App\Http\Controllers\api\reniec;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Customer\dtCustomerType;
use App\Models\Driver\TypeBodywork;
use \stdClass;

class reniecController extends Controller
{
    //consultar con el dni
    public function customerPeruApi()
    {


        $dni = request()->all(){'dni'};
        $country = request()->all(){'country'};

        if($country=="PE")
        {
          if(is_numeric($dni))
          {
            if(strlen($dni)==8)
            {
              if(Customer::where('dni',$dni)->exists())
              {
                $c = $this->getDriver($dni);
                return response()->json([
                    "resp"   => 'success',
                    "data" =>$c
                  ]);
              }
              else
              {
                  return $this->reniecPeruApi2($dni);
              }
            }
            else
            {
              return response()->json([
                  "resp"   => 'error',
                  "message" => "DNI. es un valor de 8 dígitos.",
                  "data" =>null
                ]);
            }

          }
          else
          {
            return response()->json([
                "resp"   => 'error',
                "message" => "DNI solo números",
              ]);
          }
        }//fin de peru
        else
        {
          return response()->json([
              "resp"   => 'error',
              "message" => "No hay validacion para su pais.",
            ]);
        }

    }

    public function reniecPeruValidate(){
        $dni  = request()->dni;
        $val  = $this->reniecPeruApi1($dni);
        
	if ($val->object == true){
	   $data = $val;
	}else{
       	  $a = new stdClass();
          $a->first_name = null;
          $a->last_name  = null;
          $a->date_birth  = null;
          $a->object = false;
          $a->message = "ESCRIBIR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          $data = $a;
        }
          
        
        return response()->json([
            "data" => $data
        ]);
    }

    public function reniecPeruApi1($dni){
    	$curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => "https://rest.scrall.cc/v1/reniec/dni",
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

        $response = curl_exec($curl);
        curl_close($curl);
        $myArray  = json_decode($response);

        if(isset($myArray->result->preNombres)){
          $a = new stdClass();
          if (isset($myArray->result->nuDni))
          {
            $timestamp = strtotime(str_replace('/', '-', $myArray->result->feNacimiento));
            $a->first_name = $myArray->result->preNombres;
            $a->last_name =  $myArray->result->apePaterno.' '.$myArray->result->apeMaterno;
            $a->date_birth = date("Y-m-d", $timestamp);
            $a->message    = "CORRECTO DNI ENCONTRADO";
            $a->object = true;
          }else{
            $a->object = true;
            $a->first_name = null;
            $a->last_name = null;
            $a->date_birth = null;
            $a->message = "ESCRIBIR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          }
          return $a;
      }else {
        $a = new stdClass();
        $a->object = false;
        return $a;
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
           $a->object = true;
         }else{
           $a->object = true;
           $a->first_name = null;
           $a->last_name = null;
           $a->date_birth = null;
           $a->message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
         }
         return $a;
       }else {
         $a = new stdClass();
         $a->object = false;
         return $a;
       }
    }


    public function reniecPeruApi3($dni)
    {

          $ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);
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
            $cu = new Customer();
             $cu->first_name =  $a->first_name;
             $cu->last_name = $a->last_name;
             $cu->dni = $dni;
             $cu->id_country = 172;
             $cu->id_state = 2825;
             $cu->id_city = 48357;
             $cu->admission_date = "12-12-12";


             if($cu->first_name!=null || $cu->first_name!="")
             {
               $cu->save();

               $c = $this->getDriver($dni);

                 $cudt = new dtCustomerType;
                 $cudt->id_customerType = 1;
                 $cudt->id_customer = $c->customer->id;
                 $cudt->save();
               return response()->json([
                   "resp"   => 'success',
                   "data" =>$c
                 ]);
              }
             else
             {
               return response()->json([
                   "resp"   => 'error',
                   "message"=>"No Exsite El documento de identidad.",
                 ]);
             }

       }
       else
       {
         return response()->json([
             "resp"   => 'error',
             "data" =>null
           ]);
       }

     }

     public function getDriver($dni)
     {
       $cu =  new stdClass();
       $u = Customer::where("dni",$dni)->first();
       $cudt = dtCustomerType::where('id_customer',$u->id)->first();
       if($cudt != null)
       {
         $cu->typeCustomer = $cudt->getTypeCustomer()->get();
         $cu->infoLicense = $cudt->getDriver()->first();
         if($cu->infoLicense!=null)
         $cu->countryLicense = $cudt->getDriver()->first()->getCountry()->first()->description;
       }

       $cu->getcountry  = $u->getCountry()->first()->description;
       $cu->getState  = $u->getState()->first()->description;
       $cu->getCity  = $u->getCity()->first()->description;
       $cu->customer = $u;
        return $cu;
     }

    //seguridad
    public function denied()
    {
      return "No tienes Acceso contacte al administrador.";
    }

    public function type()
    {
      $c = new TypeBodywork();
      $c->description = "Van";
      $c->save();
    }


}
