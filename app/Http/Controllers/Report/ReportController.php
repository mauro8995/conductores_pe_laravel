<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Classes\MainClass;
use App\Models\Customer\Customer;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcessTrace;
use App\Models\External\DriverApi;
use \stdClass;

class ReportController extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  public function ReportPermisos(){
    $a = new stdClass();

    $a->rTicket = false;
    $a->rClientes = false;
    $a->rProduct = false;

    return $a;
  }

    public function reportView()
    {
      $main = new MainClass();
      $main = $main->getMain();

      $t = $this->PermisosReports();
      $permisover = $t->rTicket;
      $rolid = $t->rolid;

      if ($permisover == true || $rolid == 4){
        return view('Report.report', compact('main'));
      }else{
        return view('errors.403', compact('main'));
      }
    }

//win is to getShareholder
public function orderWinIsToShareExcel()
  {
    $now = new \DateTime();
    $data = $this->orderWinIsToShare(){"sales"};
    $d = [];
    if($data == null)
    {
      $c = [
            'Dni' =>"No Hay Datos",
            'Nombre'=>"No Hay Datos",
            'Apellido' =>"No Hay Datos",
            'Correo'=>"No Hay Datos",
            'Celular'=>"No Hay Datos"
          ];
      array_push($d, $c);
      $list = collect($d);
    }
    else
    {
      foreach($data as $valor)
      {
          $c =
          [
            'Dni' =>$valor{'dni'},
            'Nombre'=>$valor{'first_name'},
            'Apellido' =>$valor{'last_name'},
            'Pais' =>$valor{'country'},
            'Estado' =>$valor{'state'},
            'Cuidad' =>$valor{'city'},
            'Direccion' =>$valor{'adreess_1'},
            'Correo'=>$valor{'email'},
            'Celular'=>$valor{'phone'},
            'Producto'=>$valor{'nameProduct'},
            'Sku'=>$valor{'sku'},
            'Total'=>$valor{'total'},
            'Moneda'=>$valor{'money'},
            'FechaPago'=>$valor{'DatePay'},
            'FechaPago'=>$valor{'statusOrder'},
            'post'=>$valor{'post'},
          ];
          array_push($d, $c);
      }
    }

    $list = collect($d);
     return  (new FastExcel($list))->download('reporteVentasWinIsToShare'.$now->format('Y-m-d').'.xlsx');
  }

  public function orderWinIsToShare()
   {
     $data = json_decode(file_get_contents('https://winistoshare.com/API/ConeccionwinIsToShare/Conexion/sales.php?key=1234&action=getOrdersComplete'), true);
     return  $data;
   }
//-------------------------------------------------------------------------------------------------------------------------------------------------- inicio taxi win
//vista -->Reportes
  public function customerTaxiwin(Request $r)
  {

    $DriverQuery = Customer::query();

    $fecha = $r->fecha;
    if ($fecha){
      $fechas = explode(" - ", $r->fecha);
      $start_datec = $fechas[0]." 00:00:00";
      $end_datec = $fechas[1]." 23:59:59";
    }
    $DriverQuery->whereBetween('created_at',array($start_datec, $end_datec));

    // $estado = request()->estado;
    // if ($estado) $DriverQuery->Where('dni' ,'=', $dni);

    $DriverQuery = $DriverQuery->where('status_system', 'true')->with('getfile','getCreate','getCity')->get();

    $drivers = [];
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
     $status = "EN EVALUACION";
   }else {
     $status = "INDEFINIDO";
   }
        // ------------------------------------------------------------------------------------------------------------------------

      $c = new stdClass();
      $c->date = "-";

      $b = new stdClass();
      $b->username = "-";

      $driver   = [
        'dni'            => $r->dni        ?  $r->dni  : '-',
        'id_office'      => $r->user       ?  $r->user : '-',
        'first_name'     => $r->first_name ?  $r->first_name : '-',
        'last_name'      => $r->last_name   ?  $r->last_name : '-',
        'phone'          => $r->phone      ?  $r->phone : '-',
        'correo'         => $r->email      ?  $r->email : '-',
        'city'		       => $r->getCity->description,
        'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
        'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
        'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
        'estado'         => $status,
        'date_create'    => $r->getfile->created_at                      ?  $r->getfile->created_at : $c,
        'created'        => $r->getCreate                      ?  $r->getCreate  : $b
      ];
      array_push($drivers, $driver);

    }
    return response()->json(["data"=>$drivers]);
  }
//vista -->Registrat tiquet
public function getRedTaxiWin(Request $r)
{
  $data = json_decode(file_get_contents('https://taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?data='.$r->data.'&action=getCustomerRed&key=1234'), true);

  $dni = $data[0]{'dni'};

  $dataRed = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$dni.''), true);

  $dataAccionista = json_decode(file_get_contents('http://winistoshare.com/API/ConeccionwinIsToShare/Conexion/customer.php?data='.$dni.'&key=1234'), true);

  $DatoCustomer =  Customer::where('status_system', '=', 'TRUE')
   ->where('dni', '=', $dni)
   ->first();

 if ($DatoCustomer == null){
   if (empty($dataAccionista)){
     if (empty($dataRed)){
         $datos = '';
         $resp = '';
     }else{
         $resp = 'taxiwin';
         $datos = $dataRed[0];
     }
   }else{
     $resp = 'winistoshare';
     $datos = $dataAccionista[0];
   }
 }else{
   $datos = $DatoCustomer;
   $resp = 'bdwin';
 }
 return response()->json(["mensaje"   => $datos, "data" => $resp ]);
}

public function customerWinIstoShareAndTaxiWin(Request $r)
{
  $DatoCustomer =  Customer::where('status_system', '=', 'TRUE')
   ->where('dni', '=', $r->data)
   ->first();

  if ($DatoCustomer == null){
    $dataAccionista = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$r->data.''), true);
    if (empty($dataAccionista)){
      $ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$r->data);
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
         $valorDoc = explode("|", $dataReniec);

         $a = new stdClass();
         $a->first_name = $valorDoc[2];
         $a->last_name = $valorDoc[0].' '.$valorDoc[1];
         $a->phone = '';

         $resp = 'reniec';
         $datos = $a;

       } else {


         $datos = null;
         $resp = 'error';
       }
    }else{
      $resp = 'taxiwin';
      $datos = $dataAccionista[0];
    }
  }else{
    $datos = $DatoCustomer;
    $resp = 'bdwin';
  }

  return response()->json(["mensaje" => $datos, "dato" => $resp]);

}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------- fin taxi win
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------inicio de win is to share

//vista -->Reportes
  public function customerWinistoshare(Request $r)
  {
    $data = json_decode(file_get_contents('https://winistoshare.com/API/ConeccionwinIsToShare/Conexion/reportSales.php?action='.$r->data.'&key=1234'), true);
    return response()->json([
        "mensaje"   => $data
      ]);
  }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------fin de win is to share

//permisosReports
public function PermisosReports(){

  $rol = Main::where('users.id', '=', auth()->user()->id)
    ->where('main.status_user', '=', 'TRUE')
    ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
    ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
    ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
    ->join('users',    'users.id',              '=',   'rol_user.id_user')
    ->select('roles.id','rol_user.id as id_roluser')
    ->first();

  $roluser = $rol{'id_roluser'};

  $t = $this->ReportPermisos();

  $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                ->select('id_permission')
                ->get();

  foreach ($permissions as $rs) {
      if ($rs->id_permission == 8){
         $t->rTicket = true;
      }else if ($rs->id_permission == 17){
         $t->rClientes = true;
      }else if ($rs->id_permission == 24){
         $t->rProduct = true;
      }
  }

  $t->rolid = $rol{'id'};

  return $t;
}



}
