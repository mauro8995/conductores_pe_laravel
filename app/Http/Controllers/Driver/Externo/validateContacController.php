<?php

namespace App\Http\Controllers\Driver\Externo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\General\code_email;
use Mail;
use App\Models\External\DriverApi;
use App\Models\Customer\Customer;
use App\Models\External\ProcesoValCond;
use App\Models\RegisterAtencion\RegisterAtencion;
use App\Models\General\Notifications;
use App\Models\RegisterAtencion\Timeregisters;
class validateContacController extends Controller
{
public function getUsersvalidate(Request $r){
      $idoffice = request()->id;
$user = Customer::where("id_office",$idoffice)
      ->first();
	$valphone = "error";
	$valemail = "error";
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
        "filemsj" => $filesmessage,
        "valphone" => $valphone,
        "valemail" => $valemail
      ]);

    }



    public function genererateCodeEmail()
      {
        $num = rand(999,9999);
        if (code_email::where('token',strtoupper(request()->email))->where('use', 1)->exists()){

          return response()->json([
              "object"=> "success",
              "menssage"=>"El correo ya se valido.",
              "data"=> 1
          ]);

       }else{
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

      function sendvoicemsm($phone,$num){
       $curl = curl_init();
       $matriz1 = str_split($num);
       $uno = $matriz1[0].", ".$matriz1[1].", ".$matriz1[2].", ".$matriz1[3];

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

          if ($err) {
            return false;
          } else {
            return true;
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

        $num = rand(1000,9999);
        $var = request()->var;

        if (code_email::where('token',request()->phone)->where('use', 1)->exists()){
          return response()->json([
              "object"=> "success",
              "menssage"=>"El telefono ya se valido.",
              "data"=> 1
          ]);
       }else if (code_email::where('token',request()->phone)->where('use', 0)->exists()){
         $c = code_email::where('token',request()->phone)->where('use', 0)->first();
         if ($var == 1){
             $this->sendmsm(request()->phone,$c->code_generate);
             $message = "Se reenvio un codigo de verificacion a su telefono por favor verifique e ingrese el codigo.";
           }else{
             $this->sendvoicemsm(request()->phone,$c->code_generate);
             $message = "Se le llamara en unos momentos";
           }
           return response()->json([
               "object"=> "success",
               "menssage"=> $message,
               "data"=> 0
           ]);


       }else{
         $c = new code_email();
         $c->code_generate = $num;
         $c->token = request()->phone;
         $c->use = 0;
         $c->save();

         if ($var == 1){
           $this->sendmsm(request()->phone,$num);
           $message = "Se reenvio un codigo de verificacion a su telefono por favor verifique e ingrese el codigo.";
         }else{
           $this->sendvoicemsm(request()->phone,$num);
           $message = "Se le llamara en unos momentos";
         }


         return response()->json([
             "object"=> "success",
             "menssage"=> $message,
             "data"=> 0
         ]);
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
                "menssage"=>"Validado correctamente." , 'data'=>$c]);
          }
        } else {
          return response()->json([
              "object"=> "error",
              "menssage"=>"ERROR, Ingrese un telefono y codigo valido, verificar."
          ]);
        }
      }


	public function viewConfimation()
	{


           return view('external.drivers.confirm',compact('title', 'main'));

	}

	public function saveConfirm(Request $r)
	{
		$idoffice = request()->id;

		if(Customer::where('user',$idoffice)->exists())
		{
			 $u = Customer::where('user', request()->id)->first();
			if(Customer::where('email', '=', strtoupper(request()->email))->where('user', '<>', request()->id)->exists())
			{
			return response()->json([
                	"object"=> "error",
                	"menssage"=>"El correo ya existe."]);


			}else
			{
				$u->email = strtoupper(request()->email);
			}
			if(Customer::where('phone', '=', request()->phone)->where('user', '<>', request()->id)->exists())
			{
				return response()->json([
                		"object"=> "error",
                		"menssage"=>"El número ya existe."]);


			}else
			{
				$u->phone = request()->phone;
			}

			if(file_drivers::where("id_customer",$u->id)->exists())
			{
				$files = file_drivers::where("id_customer",$u->id)
			          ->first();

				if(DriverApi::where('id_file_drivers',$files->id)->exists())
				{
					return response()->json([
                		"object"=> "error",
                		"menssage"=>"El usuario ya esta migrado al aplicativo. por favor envie un correo a soporte@winhold.net ."]);

				}else
				{
					 $u->save();
				}

			}




			return response()->json([
                "object"=> "success",
                "menssage"=>"datos actualizados."]);

		}
else{
	return response()->json([
                "object"=> "error",
                "menssage"=>"No se actualizo."]);

}
	}


  function validatephone(){
      $val = request()->value;
      $id_office =  request()->id_office;
      if (Customer::where('phone', '=', $val)->where('user', '<>', $id_office)->exists()){
         $update = Customer::where('phone', '=', $val)->first();
         return [ 'mensaje' => 'Este telefono ya esta registrado',
             'flag' => true,'data' => $id_office];
     }else{
       return ['flag' => false,"data"=>$val];
     }

    }

    function validateemail(){
      $val = request()->value;
      $id_office =  request()->id_office;

      if (Customer::where('email', '=', $val)->where('user', '<>', $id_office)->exists()){
        $update = Customer::where('email', '=', $val)->first();
        return [ 'mensaje' => 'Este correo ya esta registrado',
              'flag' => true];
     }else{
       return ['flag' => false];
     }
    }


    function updatedocs(){
      return view('external.drivers.updateDocs',compact(''));
    }

    function changevehiclext(){
      return view('external.drivers.changevehiclext',compact(''));
    }

    function getbylicence(){
      $val = request()->value;
      if (file_drivers::where('licencia', '=', $val)->exists()){
        $filedri = file_drivers::where('licencia', '=', $val)->with('getCustomer')->first();
        $fecha = strtotime(date("Y-m-d"));
        $fecvensoat = strtotime($filedri->soatfecven);
        $fecvenrevtec = strtotime($filedri->revfecven);

        if ($filedri->soatfecven != ""){
            if ($fecvensoat < $fecha){
               $valisoat = true;
            }else{
               $valisoat = false;
            }
        }else{
               $valisoat = false;
        }


        $anioactual  = date('Y');
	$aniocar  = $filedri->year;
        $diferenciaYear = ($anioactual - $aniocar);

        if ($diferenciaYear >= 4){
	   if ($filedri->revfecven == ""){
	      $valirevtec = true;
           }else{
	     if ($fecvenrevtec < $fecha){
               $valirevtec = true;
             }else{
               $valirevtec = false;
             }
	   }
        }else{
	  if ($filedri->revfecven != ""){
             if ($fecvenrevtec < $fecha){
               $valirevtec = true;
             }else{
               $valirevtec = false;
             }
          }else{
            $valirevtec = false;
          }
        }

        if ($valisoat == false && $valirevtec == false){
          $flag = true;
          $mensaje = "USUARIO NO TIENE DOCUMENTOS VENCIDOS";
        }else{
          $flag = false;
          $mensaje = "USUARIO ENCONTRADO CORRECTAMENTE";
        }

        return [ 'mensaje' => $mensaje,
              'flag' => $flag, 'customer' => $filedri->getCustomer,'valisoat' => $valisoat,'valirevtec' => $valirevtec];
      }else{
        return ['flag' => true, 'customer' => '','mensaje' => 'NO SE ENCUENTRA REGISTRADO','valisoat' => false,'valirevtec' => false];
      }
    }

    function getDriver(){
      $val = request()->value;
      if (file_drivers::where('licencia', '=', $val)->exists()){
        $filedri = file_drivers::where('licencia', '=', $val)->with('getCustomer')->first();
        return [ 'mensaje' => 'USUARIO ENCONTRADO CORRECTAMENTE',
              'flag' => false, 'customer' => $filedri->getCustomer];
      }else{
        return ['flag' => true, 'customer' => '','mensaje' => 'NO SE ENCUENTRA REGISTRADO'];
      }
    }

    function validateplacaexi(){
      $val = request()->value;
      if (file_drivers::where('placa', '=', $val)->exists()){
       $updates = file_drivers::where('placa', '=', $val)
                 ->join('customers', 'customers.id', '=', 'file_drivers.id_customer')
                 ->first();
       return [ 'mensaje' => 'Esta placa ya esta registrada',
               'flag' => true];
        }else{
        return ['flag' => false];
        }
    }

    function updatedocuments(){
      $idcustomer = request()->iduser;
      $typesafe = request()->users{'type_safe'};

      $filedrivers = file_drivers::where('id_customer', '=', $idcustomer)->first();

         //seguros
          $soatfecemiv =  request()->users{'fec_emi_soat'};
          $soatfecvenv =  request()->users{'fec_ven_soat'};
          $namecompany =  request()->users{'company'};
          $typesoat    =  request()->users{'type_soat'};
          $estsoat     =  "VIGENTE";
          $nropoli     =  null;
        //fin seguros


      $filedrivers->revfecemi = (request()->users{'fec_emi_rev'} != "") ? request()->users{'fec_emi_rev'} : $filedrivers->revfecemi;
      $filedrivers->revfecven = (request()->users{'fec_ven_rev'} != "") ? request()->users{'fec_ven_rev'} : $filedrivers->revfecven;
      $filedrivers->soatfecemi = (request()->users{'fec_emi_soat'} != "") ? $soatfecemiv : $filedrivers->soatfecemi;
      $filedrivers->soatfecven = (request()->users{'fec_emi_soat'} != "") ? $soatfecvenv : $filedrivers->soatfecven;
      $filedrivers->enterprisesoat = (request()->users{'fec_emi_soat'} != "") ? $namecompany : $filedrivers->enterprisesoat;
      $filedrivers->type_soat = (request()->users{'fec_emi_soat'} != "") ? $typesoat : $filedrivers->type_soat;
      $filedrivers->est_soat = (request()->users{'fec_emi_soat'} != "") ? $estsoat : $filedrivers->est_soat;
      $filedrivers->type_safe = (request()->users{'type_safe'} != "") ? $typesafe : $filedrivers->type_safe ;
      $filedrivers->save();


      $filedriver = file_drivers::where('id_customer', '=', $idcustomer)->with('getCustomer')->first();

      $dt = new \DateTime();
      $fecha = $dt->format('Y-m-d');
      $correo = $filedriver->getCustomer->email;
      $nombre = $filedriver->getCustomer->first_name;
      $apellido = $filedriver->getCustomer->last_name;
      $subject = "Actualización de documento";

      if (request()->users{'fec_emi_soat'} != "" && request()->users{'fec_emi_rev'} == ""){
        $tipodocumento = "SEGURO";
      }else if (request()->users{'fec_emi_rev'} != "" && request()->users{'fec_emi_soat'} == ""){
        $tipodocumento = "REVISION TECNICA";
      }else{
        $tipodocumento = "REVISION TECNICA Y SOAT";
      }

      $descriptions = "Hola <br> El usuario ".$filedriver->getCustomer->user." perteneciente a ".$nombre." ".$apellido.
      " con documento de identidad ".$filedriver->getCustomer->dni." acaba de registrar una solicitud de actualizacion del siguiente documento por motivo de vencimiento <br>".
      " Tipo de documento: ".$tipodocumento." <br> Link del detalle del conductor: <a target='_blank' href='/driver/externo/details/".$filedriver->getCustomer->id_office."'>detalle</a>";

      $ticket_payload = array(
        'email' => $correo,
        'subject' => $subject,
        'cc_emails[]' => "soporte@winhold.net",
        'description' => $descriptions,
        'priority' => 3,
        'status' => 2,
        'type' => 'Solicitud del area',
        'source' => 2,
        'group_id' => 43000603562
      );

      $api_key = 'U2H7YQoww2UJsUykWAwh';
      $password = "x";
      $yourdomain = "wintecnologies";

      $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = curl_exec($ch);
      $info = curl_getinfo($ch);
      $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $headers = substr($server_output, 0, $header_size);
      $response = substr($server_output, $header_size);
      curl_close($ch);
      $res =  json_decode($response);

      $nroticket = $res->id;
      $attachments = null;

      $subject = $nroticket." - ".$subject;

      $dateby = new \DateTime();
      $dateby->modify('+48 hours');
      $fr_due_by = $dateby->format('Y-m-d H:i:s');

      $date_due = new \DateTime();
      $date_due->modify('+20 minute');
      $fr_date_due = $date_due->format('Y-m-d H:i:s');

      $dataregister = [
        'id_customer' => $idcustomer,
        'subject' => $subject,
        'description' => $descriptions,
        'nro_ticket' => $nroticket,
        'date_register' => $fecha,
        'due_by' => $fr_date_due,
        'st_due_by' => false,
        'fr_due_by' => $fr_due_by,
        'st_fr_due_by' => false,
        'id_type_requirements' => 4,
        'id_status_ts' => 2,
        'id_group' => 9,
        'id_priorities' => 3,
        'id_country' => $filedriver->getCustomer->id_country,
        'id_type_customer' => 2,
        'motive' => $subject,
        'details' => $descriptions,
        'created_by' => 1,
        'type_servicedesk' => 4
      ];
      $registerAtencion = RegisterAtencion::create($dataregister)->id;

       $dataregis = [
        'id_reg_att' => $registerAtencion,
        'dt_create_ticket_attention' => $fecha
      ];
      $registime =  Timeregisters::create($dataregis);

      $dataticket = [
        'comment_subject' => $nroticket,
        'comment_text' => $nombre." ".$apellido." creó un nuevo ticket ".$subject,
        'comment_status' => 0,
        'comment_ip' => '0',
        'assigned_to' =>  5,
        'created_by' => 1,
        'modified_by' => $registerAtencion,
      ];
      $notickets = Notifications::create($dataticket);

      return response()->json(["idfile" => $filedrivers->id]);
    }

    public function updateauto(){
      $idcustomer = request()->idcustomer;

      $soatfecemiv =  request()->users{'fec_emi_soat'};
      $soatfecvenv =  request()->users{'fec_ven_soat'};
      $namecompany =  strtoupper(request()->users{'company'});
      $typesoat    =  strtoupper(request()->users{'type_soat'});
      $estsoat     =  'VIGENTE';

      $file = file_drivers::where('id_customer', '=', $idcustomer)->first();
      $file->placa = strtoupper(request()->users{'placa'});
      $file->year  = request()->users{'year'};
      $file->color_car =  request()->users{'color'};
      $file->marca = request()->users{'brand'};
      $file->model = strtoupper(request()->users{'model'});
      $file->est_car = "EN CIRCULACION";
      $file->tar_vehfecemi = request()->users{'tarj-vehi-fec-emi'};
      $file->tar_vehfecven = request()->users{'tarj-vehi-fec-emi'};
      $file->type_safe = strtoupper(request()->users{'type_safe'});
      $file->enterprisesoat = $namecompany;
      $file->est_soat = $estsoat;
      $file->type_soat = $typesoat;
      $file->num_vin = null;
      $file->num_motor = null;
      $file->soatfecemi = $soatfecemiv;
      $file->soatfecven = $soatfecvenv;
      $file->revfecemi = (request()->users{'fec_emi_rev'} != "") ? request()->users{'fec_emi_rev'} : null;
      $file->revfecven = (request()->users{'fec_ven_rev'} != "") ? request()->users{'fec_ven_rev'} : null;
      $file->save();

      $filedriver = file_drivers::where('id_customer', '=', $idcustomer)->with('getCustomer')->first();


      $datosapi1 = ['description' => 'El conductor hizo cambio de vehiculo', 'approved' => null];
      $driveapi1  = ProcesoValCond::where('id_file_drivers',$filedriver->id)->where('id_proceso_validacion',2)->first();
      if($driveapi1){
        $update1 =  ProcesoValCond::find($driveapi1->id);
        $update1 = $update1->update((array)$datosapi1);
      }


      $datosapi2 = ['description' => 'El conductor hizo cambio de vehiculo', 'approved' => null];
      $driveapi2  = ProcesoValCond::where('id_file_drivers',$filedriver->id)->where('id_proceso_validacion',1)->first();
      if($driveapi2){
        $update2 =  ProcesoValCond::find($driveapi2->id);
        $update2 = $update2->update((array)$datosapi2);
      }

      $datosapi3 = ['description' => 'El conductor hizo cambio de vehiculo', 'approved' => null];
      $driveapi3  = ProcesoValCond::where('id_file_drivers',$filedriver->id)->where('id_proceso_validacion',3)->first();
      if($driveapi3){
        $update3 =  ProcesoValCond::find($driveapi3->id);
        $update3 = $update3->update((array)$datosapi3);
      }

      $datosapi = ['id_file_drivers' => $filedriver->id, 'dvehicle' => false, 'dvehicleat' => null, 'estatusapi' => false];
      $driveapi  = DriverApi::where('id_file_drivers',$filedriver->id)->first();
      if($driveapi){
        $update =  DriverApi::find($driveapi->id);
        $update = $update->update((array)$datosapi);

        $approbastatus = $this->sendAppAprovadstatusD($driveapi->driverid);
      }

      $customs = Customer::where('id',$idcustomer)->first();
      $customs->note = 'Cambio de vehiculo';
      $customs->save();

      $dt = new \DateTime();
      $fecha = $dt->format('Y-m-d');
      $correo = $filedriver->getCustomer->email;
      $nombre = $filedriver->getCustomer->first_name;
      $apellido = $filedriver->getCustomer->last_name;
      $subject = "Cambio de vehiculo";

      $descriptions = "Hola <br> El usuario ".$filedriver->getCustomer->user." perteneciente a ".$nombre." ".$apellido.
      " con documento de identidad ".$filedriver->getCustomer->dni." acaba de registrar una solicitud de cambio de vehiculo <br>".
      " <br> Link del detalle del conductor: <a target='_blank' href='/driver/externo/details/".$filedriver->getCustomer->id_office."'>detalle</a>";

      $ticket_payload = array(
        'email' => $correo,
        'subject' => $subject,
        'cc_emails[]' => "soporte@winhold.net",
        'description' => $descriptions,
        'priority' => 3,
        'status' => 2,
        'type' => 'Solicitud del area',
        'source' => 2,
        'group_id' => 43000603562
      );

      $api_key = 'L9OmkOrBUfNRahkIK';
      $password = "x";
      $yourdomain = "wintecnologies";

      $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = curl_exec($ch);
      $info = curl_getinfo($ch);
      $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $headers = substr($server_output, 0, $header_size);
      $response = substr($server_output, $header_size);
      curl_close($ch);
      $res =  json_decode($response);

      $nroticket = $res->id;
      $attachments = null;

      $subject = $nroticket." - ".$subject;

      $dateby = new \DateTime();
      $dateby->modify('+48 hours');
      $fr_due_by = $dateby->format('Y-m-d H:i:s');

      $date_due = new \DateTime();
      $date_due->modify('+20 minute');
      $fr_date_due = $date_due->format('Y-m-d H:i:s');

      $dataregister = [
        'id_customer' => $idcustomer,
        'subject' => $subject,
        'description' => $descriptions,
        'nro_ticket' => $nroticket,
        'date_register' => $fecha,
        'due_by' => $fr_date_due,
        'st_due_by' => false,
        'fr_due_by' => $fr_due_by,
        'st_fr_due_by' => false,
        'id_type_requirements' => 4,
        'id_status_ts' => 2,
        'id_group' => 9,
        'id_priorities' => 3,
        'id_country' => $filedriver->getCustomer->id_country,
        'id_type_customer' => 2,
        'motive' => $subject,
        'details' => $descriptions,
        'created_by' => 1,
        'type_servicedesk' => 4
      ];
      $registerAtencion = RegisterAtencion::create($dataregister)->id;

      $dataregis = [
        'id_reg_att' => $registerAtencion,
        'dt_create_ticket_attention' => $fecha,
      ];
      $registime =  Timeregisters::create($dataregis);

      $dataticket = [
        'comment_subject' => $nroticket,
        'comment_text' => $nombre." ".$apellido." creó un nuevo ticket ".$subject,
        'comment_status' => 0,
        'comment_ip' => '0',
        'assigned_to' =>  4,
        'created_by' => 1,
        'modified_by' => $registerAtencion,
      ];
      $notickets = Notifications::create($dataticket);


      return response()->json(["idfile" => $filedriver->id]);
    }

    //  INTERNA
    private function setUrlApi(){
      //return 'https://perudemoapi.winrideshare.com/api/tenantIdForWinRideSharePeruDemo1';
      return 'https://api.winrideshare.com/api/T0001/';
    }

    //  INTERNA
    private function setToken(){
      //return 'secret-token:V98FAUABNV22XK9S28PUEERRFLEE8HC4';
      return 'secret-token:BDCH349C98FED3EA8336FBC69647D7CEA169C98FED3EA8336FBCKJ45HJ';
    }

    public function sendAppAprovadstatusD($id){
      $vehicle = [
         'driverId' => $id,
         'approved'   => false
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

    public function filesupdate(Request $r){

          $file = file_drivers::where('id', '=', $r->id_file)->first();

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
          }else{
            $file->car_externa2 =  null;
          }

          if ($r->tipo == '18'){
            $file->car_externa3 =  $r->voucherURL;
          }else{
            $file->car_externa3 =  null;
          }

          if ($r->tipo == '19'){
            $file->car_externa4 =  $r->voucherURL;
          }else{
            $file->car_externa4 =  null;
          }

          $file->save();

          $proceso  =  $r->proceso;
          $codigoproceso = $r->codigoproceso;
          $estatusproceso = $r->estatusproceso;

          if ($proceso == 2){
            if (file_drivers::where('id', $r->id_file)
              ->where('car_interna','<>',null)
              ->where('car_interna2','<>',null)
              ->where('car_externa','<>',null)
              ->where('tar_veh_frontal','<>',null)
              ->where('tar_veh_back','<>',null)
              ->where('soat_frontal','<>',null)
              ->exists()){

             $estatusss = null;
             $estatusss2 = 3;
             $descrippp = null;

             $ProcesoValidacionCondss  = ProcesoValCond::where('id_proceso_validacion',2)
             ->where('id_file_drivers', $r->id_file)->first();

             $datosss = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2,
                       'estatus_proceso' => 1, 'approved' => $estatusss,'approved2' => $estatusss2, 'description' => 'SE HIZO CAMBIO DE VEHICULO'];

             if ($ProcesoValidacionCondss){
               ProcesoValCond::find($ProcesoValidacionCondss->id)->update($datosss);
             }

             $ProcesoValidacionsS  = ProcesoValCond::where('id_proceso_validacion',1)
             ->where('id_file_drivers', $r->id_file)->first();

             $datoValS = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 1, 'approved' => $estatus,'approved2' => $estatus2, 'description' => 'SE CAMBIO VEHICULO'];

             if ($ProcesoValidacionsS){
               ProcesoValCond::find($ProcesoValidacionsS->id)->update($datoValS);
             }else {
               ProcesoValCond::create($datoValS);
             }

           }else{
             $estatus = null;
             $estatus2 = 3;
             $descrip = "Faltan subir fotos";

             $ProcesoValidacionCond4  = ProcesoValCond::where('id_proceso_validacion',2)
             ->where('id_file_drivers', $r->id_file)->first();

             $datos4 = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 2,
                       'estatus_proceso' => 0, 'approved' => $estatus,'approved2' => $estatus2, 'description' => 'SE HIZO CAMBIO DE VEHICULO'];

             if ($ProcesoValidacionCond4){
               ProcesoValCond::find($ProcesoValidacionCond4->id)->update($datos4);
             }

             $ProcesoValidacionsS  = ProcesoValCond::where('id_proceso_validacion',1)
             ->where('id_file_drivers', $r->id_file)->first();

             $datoValS = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 1, 'approved' => $estatus,'approved2' => $estatus2,'description' => 'SE CAMBIO VEHICULO'];

             if ($ProcesoValidacionsS){
               ProcesoValCond::find($ProcesoValidacionsS->id)->update($datoValS);
             }else {
               ProcesoValCond::create($datoValS);
             }
           }
        }

         if ($proceso == 7){
           $ProcesoValidacions  = ProcesoValCond::where('id_proceso_validacion',3)->where('id_file_drivers', $r->id_file)->first();

           $datoVal = ['id_file_drivers' => $r->id_file, 'id_proceso_validacion' => 3,'approved' => null,'approved2' => null, 'description' => 'SE ACTUALIZO DOCUMENTOS VENCIDOS'];

           ProcesoValCond::find($ProcesoValidacions->id)->update($datoVal);
         }

          return response()->json([
              "rol"=> "éxito"
          ]);
    }

     public function getUsersvalidateext(Request $r){
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

}
