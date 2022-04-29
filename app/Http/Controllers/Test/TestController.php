<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use App\Models\General\historical;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\External\User_office;
use App\Models\External\file_drivers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\UserInterno;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcessTrace;
use App\Models\External\technical_review;
use App\Models\External\Record_Driver;
use Mail;
use App\Models\General\code_email;
class TestController extends Controller
{

  public function __construct(){
      $this->middleware('auth');
      $this->url    = config('mywinrideshare.url');
      $this->secret = config('mywinrideshare.secret');
    }


 public function generateovaccesos()
 {
      $url    = 'https://mywinrideshare.com/api/win/tripComplete';
      $secret = '2XL2$0^aw$wo0eqPbz%lf9xIxx';
      $expired = time() + 300;
      $url .= '?expires=' . $expired;
      $signature = hash_hmac('sha256', $url, $secret, false);
      $url .= '&signature='.$signature;
   
      $userid = '44086';
      return $url;
 }


  public function customerDNI()
  {
    $customers = DB::table('customers')
    ->select(DB::raw('count(*) as contador'),'dni')
    ->where('status_system',true)
    ->groupBy('dni')
    ->get();
    return $customers;
  }

  public function actualizarTicket($idcustomer,$idticket){
        $ticket  =  Ticket::where('id',$idticket)->first();
        $ticket->id_customer  = $idcustomer;
        return $ticket->save();


  }

  public function deletecustomer($idcustomer){
    $deleCustomer = Customer::where('id', $idcustomer)->first();

      $deleCustomer->status_system = "false";
      $deleCustomer->save();



  }

  public function getTicketbyIdCustomer($id)
  {
    return  DB::table('tickets')
    ->select('id')
    ->where('id_customer', '=', $id)
    ->get();
  }

  public function getHistoricalbyIdCustomerAntes($id){
    return  DB::table('historicals')
    ->select('id')
    ->where('id_customer_ant', '=', $id)
    ->get();
  }


 public function actualizarHistoricalAnt($idcustomer,$id_ticket){
   $historical  =  historical::where('id',$id_ticket)->first();
   $historical->id_customer_ant  = $idcustomer;

   return response()->json([
       "mensaje"   => $historical->save()
     ]);
 }

 public function getHistoricalbyIdCustomerActu($id){
   return  DB::table('historicals')
    ->select('id')
    ->where('id_customer_act', '=', $id)
    ->get();
 }

 public function actualizarHistoricalACT($idcustomer,$id_ticket){
   $historical  =  historical::where('id',$id_ticket)->first();
   $historical->id_customer_act  = $idcustomer;
   $historical->save();

   return response()->json([
       "mensaje"   => 'exito'
     ]);
 }

 public function getGrupCustomerDNI($dni){
   $customersID = DB::table('customers')
   ->select('id')
   ->where('dni','=',$dni)
   ->get();
   return $customersID;
 }


 public function getTicketIDINVITEDBYbyIdCustomer($id)
 {
   return  DB::table('tickets')
   ->select('id')
   ->where('id_invited_by', '=', $id)
   ->get();
 }

 public function actualizarTicketidinvited($idinvited,$idticket){
       $ticket  =  Ticket::findOrFail($idticket);
       $ticket->id_invited_by  = $idinvited;
       $ticket->save();

       return response()->json([
           "mensaje"   => 'exito'
         ]);
 }






  public function CustomerDNIduplicados(){
      $dnidupli = $this->customerDNI();
    $arrayTest = array();

    foreach ($dnidupli as $key => $value)
    {
      if($value->dni != null)
      {
        if($value->contador >= 2)
        {
           $goupIdCustomer =$this->getGrupCustomerDNI($value->dni);//retorna el id de los customer


           foreach ($goupIdCustomer as $key2 => $value2)
           {
              $idCustomerFist = $goupIdCustomer[0]->id;
              $grupoTicketsDniDuplicado = $this->getTicketbyIdCustomer($value2->id);//retorna el id de los tickets
              $grupoHistorialAct = $this->getHistoricalbyIdCustomerActu($value2->id);
              $grupoHistorialAnt = $this->getHistoricalbyIdCustomerAntes($value2->id);
              foreach ($grupoTicketsDniDuplicado as $key3 => $value3)
              {
                if($this->actualizarTicket($idCustomerFist,$value3->id))
                {

                }

                else
                {


                }
              }

              foreach ($grupoHistorialAct as $key4 => $value4)
              {
                $this->actualizarHistoricalACT( $idCustomerFist,$value4->id);
              }
              foreach ($grupoHistorialAnt as $key5 => $value5)
              {
                $this->actualizarHistoricalAnt($idCustomerFist,$value5->id);
              }

           }

        }

      }
    }

    return $arrayTest;




  }
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

  public function exportar()
  {

  // $d =  \Excel::load(public_path().'/data.xls', function($reader) {
  //
  //       // reader methods
  //
  //   })->get();
        $list = collect([
        [ 'id' => 1, 'name' => 'Jane' ],
        [ 'id' => 2, 'name' => 'John' ],
    ]);
//return (new FastExcel($list))->download('file.xlsx');
    $sheets = (new FastExcel)->importSheets('data.xls');
    return 5;
  }


  public function actualizarLicencia()
  {
    $customersID2 = file_drivers::where('placa', '<>',null)
    ->get();

    foreach ($customersID2 as $key => $value) {
      $valfechseguros = file_get_contents('http://18.228.228.200/taxiwin/soat.php?placa='.$value->placa, true);
      $segurosvals = json_decode($valfechseguros);
      if(!isset($segurosvals->Message))
      {


        $da = file_drivers::where('id',$value->id)->first();
        $da->type_safe = "SOAT";
        $da->nro_poliza = $segurosvals->NumeroPoliza;
        $da->type_soat = $segurosvals->NombreUsoVehiculo;
         $da->save();
      }
    }

    return response()->json([
        "mensaje"   => "sd"
      ]);
  }


 public function excelReportUser()
 {


    $export = new UserInterno();
    return Excel::download($export, 'invoices.xls');


 }

 public function actulizarRepetidos()
 {
    //80013
     $u = User_office::where('id_office','<>',null)
    ->with('getfile')
    ->get();

    $idoffice = [];
    $id_repetidos = [];
    $s = false;
    foreach ($u as $key => $value)
    {
      $arry = [];
      if($value->getfile->id != 0)
      {
        $d = ProcesoValCond::where('id_file_drivers', $value->getfile->id)->get();
        foreach ($d as $key_p => $value_p) {//procesval

          if(in_array($value_p->id_proceso_validacion, $arry ,false))
          {
            array_push($id_repetidos, $value_p->id);
            array_push($idoffice, $value->id_office);
          }else
          {
            array_push($arry,$value_p->id_proceso_validacion);
          }
        }
      }

    }

    foreach ($id_repetidos as $key => $value) {
      if(ProcesoValCond::where('id', $value)->where('approved', '=',null)->exists())
      ProcesoValCond::where('id', $value)->delete();
    }
    return response()->json([
        "mensaje"   => $idoffice
      ]);
 }

 public function actualizarRevTec(){
    $updateRevs = file_drivers::where('status_system',true)
    ->where('year','<>',null)
    ->get();

    foreach ($updateRevs as $updateRev) {
      if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
        $process_model =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
        $process_model->estatus = 1;
        $process_model->save();
      }

      if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
      ->where('id_proceso_validacion',1)->exists()){

        $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
        ->where('id_proceso_validacion',1)->delete();

      }


    }



    foreach ($updateRevs as $updateRev) {

      $tecnica     = technical_review::where('id_file_drivers', $updateRev->id)->first();

      $anioactual  = date('Y');
      $aniocar     = $updateRev->year;
      $diferenciaYear = ($anioactual - $aniocar);

      if ($diferenciaYear > 3 && $diferenciaYear <= 5) {
        if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
          $process_model =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
          $process_model->estatus = 1;
          $process_model->save();
        }

        if (!$updateRev->revision_tecnica){
          $mensaje = "El vehiculo esta entre 3 y 4 años debe poseer un documento tecnico cargado";

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = false;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => false
            ];
            ProcesoValCond::create($procesoConduc);
          }

        }else{

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = true;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => true
            ];
            ProcesoValCond::create($procesoConduc);
          }
        }
      } else if ($diferenciaYear > 5) {
        $mensaje=  "El vehiculo es mayor a 6 años debe poseer revision tecnica WIN y un documento tecnico cargado";
        if (!$tecnica && !$file_divers->revision_tecnica){
          if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
            $process_model3 =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
            $process_model3->estatus = 0;
            $process_model3->save();
          }

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = false;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => false
            ];
            ProcesoValCond::create($procesoConduc);
          }
        }else  if (!$tecnica && $updateRev->revision_tecnica){
          if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
            $process_model3 =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
            $process_model3->estatus = 0;
            $process_model3->save();
          }

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = false;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => false
            ];
            ProcesoValCond::create($procesoConduc);
          }
        } else if (!$updateRev->revision_tecnica && $tecnica) {
          if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
            $process_model3 =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
            $process_model3->estatus = 0;
            $process_model3->save();
          }

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = false;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => false
            ];
            ProcesoValCond::create($procesoConduc);
          }
        } else {
          $process_model4 =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
          $process_model4->estatus = 1;
          $process_model4->save();

          if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->exists()){

            $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
            ->where('id_proceso_validacion',1)->first();

            $procevalconduc->approved  = true;
            $procevalconduc->modified_by = 1;
            $procevalconduc->save();

          }else{
            $procesoConduc = [
              'id_file_drivers'        => $updateRev->id,
              'id_proceso_validacion'  => 1,
              'estatus_proceso'        => 1,
              'modified_by'            => 1,
              'approved'               => true
            ];
            ProcesoValCond::create($procesoConduc);
          }
        }
      } else {
        $mensaje = "Actualizado de forma satisfactoria";
        if(ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->exists()){
          $process_model5 =  ProcessTrace::where('id_file_drivers', $updateRev->id)->where('id_process_model', 1)->first();
          $process_model5->estatus = null;
          $process_model5->save();
        }

        if (ProcesoValCond::where('id_file_drivers', $updateRev->id)
        ->where('id_proceso_validacion',1)->exists()){

          $procevalconduc = ProcesoValCond::where('id_file_drivers', $updateRev->id)
          ->where('id_proceso_validacion',1)->first();

          $procevalconduc->approved  = true;
          $procevalconduc->modified_by = 1;
          $procevalconduc->save();

        }else{
          $procesoConduc = [
            'id_file_drivers'        => $updateRev->id,
            'id_proceso_validacion'  => 1,
            'estatus_proceso'        => 1,
            'modified_by'            => 1,
            'approved'               => true
          ];
          ProcesoValCond::create($procesoConduc);
        }
      }
    }

    return response()->json([
        "mensaje"   => $updateRevs
      ]);
 }

 function sendemail(){

   $a = array("nombre" => "brenda" , "apellido"=> "atto", "usuario" => "atto");
   $s = "brenda.bpam.12@gmail.com";
   Mail::send('emails.migracionapp',$a,function($message) use ($s)
   {
      $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
      $message->to($s)->subject('Bienvenido a WIN');
   });
 }

 function sendmsm(){
    //$idoffice = request()->number;
    //$user = User_office::where('id_office',$idoffice)->first();


    $numero = request()->number;
    $turno  = request()->turn;

    $curl = curl_init();

    if ($turno == 1){
    curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.infobip.com/sms/1/text/single",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => "{ \"from\":\"WIN\", \"to\":\"+51".$numero."\", \"text\":\"WIN RIDE SHARE le recuerda que el día de mañana tiene una cita en nuestro taller de control y verificacion vehicular, turno mañana. Mayor información al 932545988 <a href='conductores.wintecnologies.com'>val</a>\"}",
     CURLOPT_HTTPHEADER => array(
       "accept: application/json",
       "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
       "content-type: application/json"
     ),
    ));
  }else if ($turno == 2){
    curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.infobip.com/sms/1/text/single",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => "{ \"from\":\"WIN\", \"to\":\"+51".$numero."\", \"text\":\"WIN RIDE SHARE le recuerda que el día de mañana tiene una cita en nuestro taller de control y verificacion vehicular, turno tarde. Mayor información al 932545988.\" }",
     CURLOPT_HTTPHEADER => array(
       "accept: application/json",
       "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
       "content-type: application/json"
     ),
    ));
  }else{
    curl_setopt_array($curl, array(
     CURLOPT_URL => "https://api.infobip.com/sms/1/text/single",
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "POST",
     CURLOPT_POSTFIELDS => "{ \"from\":\"WIN\", \"to\":\"+51".$numero."\", \"text\":\"WIN RIDE SHARE le recuerda que el día de hoy tiene una cita en el taller de control y verificación vehícular. Lo esperamos! Mayor información 932545988.\" }",
     CURLOPT_HTTPHEADER => array(
       "accept: application/json",
       "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
       "content-type: application/json"
     ),
    ));
  }

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
     echo "cURL Error #:" . $err;
    } else {
     echo $response;
    }
 }

 function updateproceso(){
   $allfile = ProcesoValCond::where('approved', 1)->get();

   foreach ($allfile as $key) {
     $process_model5 =  ProcessTrace::where('id_file_drivers', $key->id_file_drivers)->where('id_process_model',$key->id_proceso_validacion)->first();
     $process_model5->estatus = 1;
     $process_model5->save();
   }

   return response()->json([
       "mensaje"   => "success"
   ]);
 }



 function eliminarRecort()
 {







   $u = User_office::where('id','<>',null)
   ->get();
   $b = [];
   foreach ($u as $key => $value) {
     $can = 0;
     foreach ($value->getRecord as $key_v => $value_v)
     {
       $can++;
     }


     $c = ProcessTrace::where('id_file_drivers', $value->getfile->id)->get();
     foreach ($c as $key__ => $value__) {
       if($can == 0)
       {
         if($value__->id_process_model == 6)
         {
           if($value__->estatus === null)
           {

           }elseif ($value__->estatu) {

              if(Record_Driver::where('id_file_drivers',$value->getfile->id)->exists())
              {

              }else
              {
                $dni = $value->dni;

                $url = 'http://18.228.228.200/taxiwin/mtc_papeletas.php?dni='.$dni.'&type=xml';
                $ch=curl_init();
                $timeout=5;

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $xml=curl_exec($ch);

                if ($error_number = curl_errno($ch)) {
                    if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
                        $m = "No existe";
                        curl_close($ch);
                    }
                }

                else {
                  curl_close($ch);
                  $xml  = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
                  $xml  = simplexml_load_string($xml);

                  $d = $xml->sBody->SelBuscarLisResponse->SelBuscarLisResult;
                  if($xml->sBody)
                  {
                    if($d->aLC_TM_Papeletas)
                    {
                      foreach ($d->aLC_TM_Papeletas as  $value_pa) {
                        $record_driver = [
                          'id_file_drivers'     =>  $value->getfile->id,
                          'id_user_offices'     =>  $value->id,
                          'cod_falta'           =>  $value_pa->aCod_Falta,
                          'papeleta'            =>  $value_pa->aNro_Papeleta,
                          'entidad'             =>  $value_pa->aEntidad,
                          'points_saldo'        =>  $value_pa->aPuntos_Saldo,
                          'points_firmes'       =>  $value_pa->aPuntos_Firmes,
                          'dinfranccion'        =>  $value_pa->aNum_Infraccion,
                          'estado'              =>  $value_pa->aEstado,
                          'modified_by'         =>  1,
                        ];
                        $id_record = Record_Driver::create($record_driver)->id;
                      }
                    }else{
                      $record_driver = [
                        'id_file_drivers'     =>  $value->getfile->id,
                        'id_user_offices'     =>  $value->id,
                        'cod_falta'           =>  null,
                        'papeleta'            =>  null,
                        'entidad'             =>  null,
                        'points_saldo'        =>  0,
                        'points_firmes'       =>  0,
                        'dinfranccion'        =>  null,
                        'estado'              =>  'NO POSEE INFRACCIONES',
                        'modified_by'         =>  1,
                      ];
                      $id_record = Record_Driver::create($record_driver)->id;
                    }
                    array_push($b, $value->id_office);
                  }else {
                    $m = "No existe";
                  }
                }
              }

           }



         }
       }
     }

   }
   return response()->json([
       "mensaje"   => $b
     ]);
 }


  function mensajeForVoz()
  {
    $curl = curl_init();
 $numero = 962888915;
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.infobip.com/tts/3/single",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"from\": \"442032864231\",\n  \"to\": \"+51".$numero."\",\n  \"text\": \" Hola, le saluda el Win su codigo de verificacion es : 5 4 8 9 6 3 repito  es 5 4 8 9 6 3 \",\n \"language\": \"es\",\n \"voice\": {\n \"name\": \"Miguel\",\n \"gender\": \"male\" }\n}",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Basic d2luaG9sZDpNYXVybzEyKg==",
    //"authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
  }

  function validarcorreo($id){
  $num = rand(1000,9999);

   $k = Customer::where('user', $id)->first();

   $k->email = strtoupper($k->email);
   $k->save();



     if (code_email::where('token',strtoupper($k->email))->where('use', 1)->exists()){
          return $k->email." El correo ya se valido.";
      }else if (code_email::where('token',strtoupper($k->email))->where('use', 0)->exists()){
          $codes = code_email::where('token',strtoupper($k->email))->where('use', 0)->first();
    return "Su codigo de confirmacion es: ".$codes->code_generate;
      }else{
   $c = new code_email();
     $c->code_generate = $num;
         $c->token = strtoupper($k->email);
         $c->use = 0;
         $c->save();
         return "Su codigo de confirmación es: ".$num;
      }

}

function validartelefono($id){
  $num = rand(1000,9999);

  $k = Customer::where('user', $id)->first();

  $k->phone = $k->phone;
  $k->save();

      if (code_email::where('token',$k->phone)->where('use', 1)->exists()){
          return "El telefono ya se valido.";
      }else if (code_email::where('token',$k->phone)->where('use', 0)->exists()){
          $codes = code_email::where('token',$k->phone)->where('use', 0)->first();
    return "Su codigo de confirmacion es: ".$codes->code_generate;
      }else{

   $c = new code_email();
   $c->code_generate = $num;
   $c->token = $k->phone;
   $c->use = 0;
   $c->save();
   return "Su codigo de confirmación es: ".$num;
    }
}


function validarnuevocorreo($id){
     $num = rand(1000,9999);
     if (code_email::where('token',strtoupper($id))->where('use', 1)->exists()){
          return "El correo ya se valido.";
      }else if (code_email::where('token',strtoupper($id))->where('use', 0)->exists()){
          $codes = code_email::where('token',strtoupper($id))->where('use', 0)->first();
    return "Su codigo de confirmacion es: ".$codes->code_generate;
      }else{
   $c = new code_email();
     $c->code_generate = $num;
         $c->token = strtoupper($id);
         $c->use = 0;
         $c->save();
         return "Su codigo de confirmación es: ".$num;
      }
}

function validarnuevotelefono($id){
       $num = rand(1000,9999);

      if (code_email::where('token',$id)->where('use', 1)->exists()){
          return "El telefono ya se valido.";
      }else if (code_email::where('token',$id)->where('use', 0)->exists()){
          $codes = code_email::where('token',$id)->first();
    return "Su codigo de confirmacion es: ".$codes->code_generate;
      }else{
   $c = new code_email();
   $c->code_generate = $num;
   $c->token = $id;
   $c->use = 0;
   $c->save();
   return "Su codigo de confirmación es: ".$num;
      }
}



}
