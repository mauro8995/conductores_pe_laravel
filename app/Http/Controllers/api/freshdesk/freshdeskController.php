<?php

namespace App\Http\Controllers\api\freshdesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\General\Country;

class freshdeskController extends Controller
{

    public function getTicketsbygroup(){
        $api_key = "L9OmkOrBUfNRahkIK";
        $password = "x";
        $yourdomain = "wintecnologies";
        // Return the tickets that are new or opend & assigned to you
        // If you want to fetch all tickets remove the filter query param
        $url = 'https://wintecnologies.freshdesk.com/api/v2/search/tickets?query="group_id:43000447070"';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        if($info['http_code'] == 200) {
          return json_decode($response,true);
        } else {
          if($info['http_code'] == 404) {
            echo "Error, Please check the end point \n";
          } else {
            echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
            echo "Headers are ".$headers;
            echo "Response are ".$response;
          }
        }
        curl_close($ch);

    }

    public function getTicketsbyid(){
        $api_key = "L9OmkOrBUfNRahkIK";
        $password = "x";
        $yourdomain = "wintecnologies";
        $ticket_id = 14420;
        // Return the tickets that are new or opend & assigned to you
        // If you want to fetch all tickets remove the filter query param
        $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id?include=conversations";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        if($info['http_code'] == 200) {
          $res = json_decode($response,true);
          return $res;
        } else {
          if($info['http_code'] == 404) {
            echo "Error, Please check the end point \n";
          } else {
            echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
            echo "Headers are ".$headers;
            echo "Response are ".$response;
          }
        }
        curl_close($ch);

    }




    public function agregarrespuesta(){
      $api_key = "U2H7YQoww2UJsUykWAwh";
      $password = "x";
      $yourdomain = "wintecnologies";

      // Reply will be added to the ticket with the following id
      $ticket_id = 14420;
      $note_payload = array(
        "body" => "<div>We are working on this issue. Will keep you posted.</div>",
      );
      $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id/reply";
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $note_payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = curl_exec($ch);
      $info = curl_getinfo($ch);
      $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      $headers = substr($server_output, 0, $header_size);
      $response = substr($server_output, $header_size);
      if($info['http_code'] == 201) {
        echo "Note added to the ticket, the response is given below \n";
        echo "Response Headers are \n";
        echo $headers."\n";
        echo "Response Body \n";
        echo "$response \n";
      } else {
          if($info['http_code'] == 404) {
          echo "Error, Please check the end point \n";
        } else {
          echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
          echo "Headers are ".$headers."\n";
          echo "Response is ".$response;
        }
      }
      curl_close($ch);

      return response()->json([
          "data" => 12
      ]);
    }

    public function createTicket_file(Request $request){

          $api_key = "U2H7YQoww2UJsUykWAwh";
          $password = "";
          $yourdomain = "wintecnologies";
          $request->validate([
              'pais' => 'required',
              'tipo' => 'required',
              'nombre' => 'required',
              'motivo'=>'required',
              'email' => 'required|email',
              'telefono' => 'required|numeric',
              'descripcion' => 'required|max:3000',
              'codigo' => 'required',

          ]);

          return response()->json([
            'object'  => "success",
            'key' => $api_key,
            'dominio' => $yourdomain
          ]);

    }


    public function viewTicket(){
      $country = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      return view('external.inicio.bookRecla', compact('country'));
    }

    public function createTicketAPI(Request $r){
      return request()->all;


      // $api_key = "U2H7YQoww2UJsUykWAwh";
      // $password = "x";
      // $yourdomain = "wintecnologies";
      //
      // $name =  $_FILES["myFile"]['name'];
      // $type =  $_FILES["myFile"]['type'];
      // $mimetype = $_FILES["myFile"]['tmp_name'];
      //
      // $ticket_data = json_encode(array(
      //   'email' => request()->email,
      //   'subject' => request()->subject,
      //   'description' => request()->description,
      //   'priority' => 1,
      //   'status' => 2,
      //   'attachments[]' =>  curl_file_create($mimetype, $type, $name),
      //   'type' => request()->tipo,
      //   'source' => 2,
      //   'group_id' => request()->group_id,
      //   'phone' => request()->telefono,
      // ));
      //
      //   $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
      //   $ch = curl_init($url);
      //   $header[] = "Content-type: application/json";
      //   curl_setopt($ch, CURLOPT_POST, true);
      //   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      //   curl_setopt($ch, CURLOPT_HEADER, true);
      //   curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
      //   curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
      //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //   $server_output = curl_exec($ch);
      //   $info = curl_getinfo($ch);
      //   $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      //   $headers = substr($server_output, 0, $header_size);
      //   $response = substr($server_output, $header_size);
      //   if($info['http_code'] == 201) {
      //     return response()->json(["message" => "Ticket created successfully",
      //                              "rep" => "success"]);
      //   } else {
      //     if($info['http_code'] == 404) {
      //       return response()->json(["message" => "Error 404, Please check the end point",
      //                                "rep" => "error"]);
      //     } else {
      //       return response()->json(["message" => "Error, HTTP Status Code : " . $info['http_code']."",
      //                                "rep" => "error"]);
      //     }
      //   }
      //   curl_close($ch);
    }

    public function getGrupos(){
        $api_key = "U2H7YQoww2UJsUykWAwh";
        $password = "x";

        $url = "https://wintecnologies.freshdesk.com/api/v2/groups";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        return response()->json(["data" => json_decode($response)]);
    }

    public function index(){
      $c=Country::all();
      $country=[];
      foreach ($c  as $key => $value) {
       $v = $value->nationality.' +'.$value->cod;
       array_push($country,$v);
      }

      return view('Reclamaciones.reclamaciones',compact('country'));
    }

    public function sendpruebas(){
      return view('external.drivers.sendpruebas',compact(''));
    }

}
