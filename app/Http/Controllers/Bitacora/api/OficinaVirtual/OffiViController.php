<?php

namespace App\Http\Controllers\api\OficinaVirtual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \stdClass;
use App\Classes\MainClass;
use Flash;

class OffiViController extends Controller
{
    public function __construct()
    {

      $this->url    = config('mywinrideshare.url');
      $this->secret = config('mywinrideshare.secret');
    }

    // public function getOfficine()
    // {
    //     $cu = new stdClass();
    //     $cu->usuario = "mgomez";
    //     $cu->pass = md5('mypass');
    //     return response()->json(["object" => "success","data"=>$cu]);
    // }

    public function generateURLSignature($action) {
      $url    = $this->url.'/'.$action;
      $secret = $this->secret;
      $expired = time() + 300;
      $url .= '?expires=' . $expired;
      $signature = hash_hmac('sha256', $url, $secret, false);
      return $url . '&signature=' . $signature;
    }


    public function getByUsernameOV()
    {
        $query = 'prueba_user';
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
            'address'          => $myArray->data->posts->address->address_1,
            'sponsor_username' => $myArray->data->posts->sponsor->username,
            'passenger'        => $myArray->data->posts->details->passenger,
            'driver'           => $myArray->data->posts->details->driver,
            'ambassador'       => $myArray->data->posts->details->ambassador
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


  public function cambiarPaswordOvUser()
    {
      $main = new MainClass();
      $main = $main->getMain();

      return view('office_virtuals.cambiarPasswordOV')->with('main', $main);
    }

    public function getByUserOVConsulta($datobusqueda, $llave)
    {
       $data  =  array($llave => $datobusqueda);
       $data  = json_encode($data);

       $object  = 'error';
       $mensaje = 'USUARIO/ID se encuentran en la Oficina Virtual.';
       $datos   = null;
       $response;


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

       if($myArray->status == '200' &&  property_exists ( $myArray->data->posts, 'profile') ){

         $object  = 'success';
         $mensaje = 'USUARIO ENCONTRADO EXITOSAMENTE';

         $datos =[
           'id_office'         => $myArray->data->posts->profile->id,
           'site_name_office'  => $myArray->data->posts->profile->username,
           'first_name'        => mb_strtoupper($myArray->data->posts->profile->first_name),
           'last_name'         => mb_strtoupper($myArray->data->posts->profile->last_name),
           'country'           => mb_strtoupper($myArray->data->posts->address->country),
           'email'             => mb_strtolower($myArray->data->posts->profile->email),
           'phone'             => (property_exists ($myArray->data->posts->profile, 'phone_number'))? $myArray->data->posts->profile->phone_number : $myArray->data->posts->profile->public_phone,
           'sponsor_user'      => $myArray->data->posts->sponsor->username,
           'sponsor_email'     => $myArray->data->posts->sponsor->email,
           'sponsor_phone'     => (property_exists ($myArray->data->posts->sponsor, 'phone_number'))? $myArray->data->posts->sponsor->phone_number : (property_exists ($myArray->data->posts->sponsor, 'public_phone'))? $myArray->data->posts->sponsor->public_phone : '-',
           'status'            => true,
           // 'tp_migracion'      => 'Validado/Panel',
           // 'usermodify'        => auth()->user()->id
        ];
       }
       //INVALID USER NAME
       else if($myArray->status == '460'){
         $mensaje = 'USUARIO/ID no se encuentran en la Oficina Virtual.';
       }
       $response = [
         'data'    => $datos,
         'object'  => $object,
         'mensaje' => $mensaje
       ];
       return (object) $response;


     }

     public function updateOVExterno($datosUpd, $id)
    {
       $object;
       $datosUpd['userid']  = $id;
       $data  = json_encode($datosUpd);

       $urlComplete  = $this->generateURLSignature('user_update');

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

        if($myArray->status == '200' ){
          $object = 'success';
        }else {
          $object = 'error';
        }
        return $object;
     }

    public function saveContrasenaOV()
    {
     $input = request()->all();

     $data = $this->getByUserOVConsulta($input{'usuario'}, 'username');
     if($data->object == 'error'){
       Flash::error('<li>¡'.$data->mensaje.'!</li>');
       return redirect(route('officeVirtuals.cambiarPaswordOvUser'));
     }else{

      $datosUpd['userid']    = $data->data{'id_office'};
      $datosUpd['password']  = $input{'password'};
      $updEnvex   = $this->updateOVExterno($datosUpd, $data->data{'id_office'});
      if($updEnvex == 'success'){

       Flash::success('<li>¡Actualizamos de forma exitosa!</li>');
       return redirect(route('officeVirtuals.cambiarPaswordOvUser'));

      }else {
       Flash::error('<li>¡No hemos podido realizar la actualizacion en OV!</li>');
       return redirect(route('officeVirtuals.cambiarPaswordOvUser'));
      }
      }


     }

}
