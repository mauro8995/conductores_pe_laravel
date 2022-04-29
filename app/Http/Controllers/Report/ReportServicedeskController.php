<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use App\Models\RegisterAtencion\RegisterAtencion;
use App\Models\General\GroupsTicket;
use App\Models\General\User;
use Illuminate\Support\Facades\DB;
use App\Models\General\Category;
use \stdClass;
use App\Models\General\TypeRequirements;

class ReportServicedeskController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }

    public function ReportPermisos(){
      $a = new stdClass();
      $a->rSuperUser = false;
      $a->rAdmin = false;
      return $a;
    }

    function reportView(){
      $main = new MainClass();
      $main = $main->getMain();

      $open     = RegisterAtencion::Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $waiting  = RegisterAtencion::Where('id_status_ts','=',3)->Where('status_system','=',TRUE)->count();
      $unsolved = $open + $waiting;
      $notassigned = RegisterAtencion::Where('asignated_to','=',null)->Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $assigned = RegisterAtencion::Where('asignated_to','<>',null)->Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $closed  = RegisterAtencion::Where('id_status_ts','=',5)->Where('status_system','=',TRUE)->count();
      $groups       = GroupsTicket::orderBy('description', 'ASC')->pluck('description', 'id');
      $modified_by  = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "users.id")
                      ->where('note', '=', '1')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');
      $solved = RegisterAtencion::Where('id_status_ts','=',4)->Where('status_system','=',TRUE)->count();
      $total = $open + $waiting + $solved + $closed;

      return view('Report.servicedesk', compact('main','unsolved','open','waiting','notassigned','closed','groups', 'modified_by','solved','total','assigned'));
    }

    function servicedeskemergency(){
      $main = new MainClass();
      $main = $main->getMain();

      $categories = Category::where('id_type_requeriments', '=', 10)->orderBy('name', 'ASC')->pluck('name', 'id');

      return view('Report.servicedeskemergency', compact('main','categories'));
    }

    function servicedeskgeneral(){
      $main = new MainClass();
      $main = $main->getMain();

      return view('Report.servicedeskgeneral', compact('main'));
    }

    function GetReportemergency(){
      $emergency = RegisterAtencion::query();
      $emergency_dates = RegisterAtencion::query();
      $monthly_post_count = RegisterAtencion::query();

      if (isset(request()->categories)){
        $categories     = request()->categories;
        $emergency->Where('id_category','=',$categories);
        $emergency_dates->Where('id_category','=',$categories);
        $monthly_post_count->Where('id_category','=',$categories);
      }else{
        $emergency->Where('status_system','=',TRUE);
        $emergency_dates->Where('status_system','=',TRUE);
        $monthly_post_count->Where('status_system','=',TRUE);
      }

      if (isset(request()->typegestion)){
        $typegestion     = request()->typegestion;
        $emergency->Where('id_type_customer','=',$typegestion);
        $emergency_dates->Where('id_type_customer','=',$typegestion);
        $monthly_post_count->Where('id_category','=',$categories);
      }else{
        $emergency->Where('status_system','=',TRUE);
        $emergency_dates->Where('status_system','=',TRUE);
        $monthly_post_count->Where('status_system','=',TRUE);
      }


      if (isset(request()->dates)){
        $fechas = explode(" / ", request()->dates);
        $datestar = $fechas[0]." 00:00:00";
        $datelast = $fechas[1]." 00:00:00";
        $dates          = request()->dates;
        if ($dates){
          $emergency->whereBetween('date_register', [$datestar, $datelast]);
          $emergency_dates->whereBetween('date_register', [$datestar, $datelast]);
          $monthly_post_count->whereBetween('date_register', [$datestar, $datelast]);
        }else{
          $emergency->Where('status_system','=',TRUE);
          $emergency_dates->Where('status_system','=',TRUE);
          $monthly_post_count->Where('status_system','=',TRUE);
        }
      }

      $emergency = $emergency->Where('id_type_requirements','=',10)->Where('status_system','=',TRUE)->get();


      //todos los meses
      $month_array = array();
  		$emergency_dates = $emergency_dates->Where('id_type_requirements','=',10)->orderBy('created_at', 'ASC')->pluck('created_at');
  		$emergency_dates = json_decode($emergency_dates);

  		if (!empty($emergency_dates)) {
  			foreach ($emergency_dates as $unformatted_date) {
  				$dates = new \DateTime($unformatted_date->date);
  				$month_no = $dates->format('m');
  				$month_name = $dates->format('M');
  				$month_array[$month_no] = $month_name;
  			}
  		}

      //obtener la data de los meses
      $monthly_post_count_array = array();
  		$month_name_array = array();
  		if (!empty($month_array)) {
  			foreach ($month_array as $month_nos => $month_names){
          $monthly_post_count = $monthly_post_count->Where('id_type_requirements','=',10)->whereMonth('created_at',$month_nos)->get()->count();
  				array_push( $monthly_post_count_array, $monthly_post_count );
  				array_push( $month_name_array, $month_names );
  			}
  		}

      if (!empty($monthly_post_count_array)) {
    		$max_no = max($monthly_post_count_array);
    		$max = round(( $max_no + 10/2 ) / 10 ) * 10;
    		$monthly_post_data_array = array(
    			'months' => $month_name_array,
    			'post_count_data' => $monthly_post_count_array,
    			'max' => $max,
    		);
      }else{
        $monthly_post_data_array = array(
    			'months' => '',
    			'post_count_data' => '',
    			'max' => '',
    		);
      }

      return response()->json([
        'data'     =>  $emergency,
        'filter' => $monthly_post_data_array
      ]);
    }

    function GetReportRequirements(){
      $typerequeri = RegisterAtencion::query();
      $requeri_count = RegisterAtencion::query();
      $assigned = RegisterAtencion::query();
      if (isset(request()->dates)){
        $fechas = explode(" / ", request()->dates);
        $datestar = $fechas[0]." 00:00:00";
        $datelast = $fechas[1]." 00:00:00";
        $dates          = request()->dates;
        if ($dates){
          $typerequeri->whereBetween('date_register', [$datestar, $datelast]);
          //$requeri_count->whereBetween('date_register', [$datestar, $datelast]);
          $assigned->whereBetween('date_register', [$datestar, $datelast]);
        }else{
          $typerequeri->Where('status_system','=',TRUE);
          //$requeri_count->Where('status_system','=',TRUE);
          $assigned->Where('status_system','=',TRUE);
        }
      }

      //todos los requerimientos
      $requeri_array = array();
      $typerequeri = $typerequeri->Where('status_system','=',TRUE)->distinct('id_type_requirements')->orderBy('id_type_requirements', 'ASC')->pluck('id_type_requirements');
      $typerequeri = json_decode($typerequeri);

      if (!empty($typerequeri)){
        foreach ($typerequeri as $typerequeris) {
  				$reque_no = $typerequeris;
          $reque = TypeRequirements::where('id', '=', $reque_no)->first();
  				$reque_name = $reque->description;
  				$requeri_array[$reque_no] = $reque_name;
  			}
      }

      $requeri_count_array = array();
      $requeri_name_array = array();
      if (!empty($requeri_array)) {
        foreach ($requeri_array as $reque_nos => $reque_names) {
          $requeri_count = RegisterAtencion::whereBetween('date_register', [$datestar, $datelast])->Where('id_type_requirements','=',$reque_nos)->count();
          array_push($requeri_count_array, $requeri_count);
  				array_push($requeri_name_array, $reque_names);
        }
      }

      $requeri_post_data_array = array(
        'requeriments' => $requeri_name_array,
        'post_count_data' => $requeri_count_array
      );


      $assigned_array = array();
      $assigned = $assigned->Where('status_system','=',TRUE)->Where('asignated_to','<>',null)->distinct('asignated_to')->orderBy('asignated_to', 'ASC')->pluck('asignated_to');
      $assigned = json_decode($assigned);

      if (!empty($assigned)){
        foreach ($assigned as $assigneds) {
  				$asig_no = $assigneds;
          $asig = User::where('id', '=',$asig_no)->first();
  				$asig_name = $asig->name.' '.$asig->lastname;
  				$assigned_array[$asig_no] = $asig_name;
  			}
      }


      $asig_count_array = array();
      $asig_name_array = array();
      if (!empty($assigned_array)) {
        foreach ($assigned_array as $asig_nos => $asig_names) {
          $register = RegisterAtencion::select('created_at','updated_at')->whereBetween('date_register', [$datestar, $datelast])->Where('asignated_to','=',$asig_nos)->Where('id_status_ts','=',4)->orWhere('id_status_ts','=',5)->Where('status_system','=',TRUE)->get();
          $resultado = 0;

          foreach ($register as $valor){
            $fechcreado = strtotime($valor->created_at);
            $fechresuel = strtotime($valor->updated_at);
            $resultado  = $resultado + ($fechresuel - $fechcreado);
          }
          $total = count($register);
          $promedio = $resultado / $total;

          $seg = $promedio;

          //$d = floor($seg / 86400);
          $h = floor($seg / 3600);
          $m = floor($seg / 60);
          $s = $seg % 60;
          $times = '';

          // if ($d > 0){
          //   $times =  ($d == 1) ? $d." Dia " : $d." Dias ";
          // }

          if ($h > 0){
            $times = $h;
          }else if ($m > 0){
            $times = $m;
          }else{
            $times = $s;
          }

          array_push($asig_count_array, $times);
  				array_push($asig_name_array, $asig_names);
        }
      }

      $agent_post_data_array = array(
        'agent' => $asig_name_array,
        'time_resolve' => $asig_count_array
      );

      return response()->json([
        'data'     =>  $requeri_post_data_array,
        'data2'    => $agent_post_data_array
      ]);
    }

    function GetReportGeneral(){
      $solved = RegisterAtencion::query();
      $open     = RegisterAtencion::query();
      $waiting  = RegisterAtencion::query();
      $notassigned  = RegisterAtencion::query();
      $closed = RegisterAtencion::query();
      $assigned = RegisterAtencion::query();
      $opentimetrue  = RegisterAtencion::query();
      $opentimefalse = RegisterAtencion::query();
      $closevenctrue   = RegisterAtencion::query();
      $closevencfalse  = RegisterAtencion::query();

      if (isset(request()->agent)){
        $agent     = request()->agent;
        if ($agent){
          $solved->Where('asignated_to','=',$agent);
          $open->Where('asignated_to','=',$agent);
          $waiting->Where('asignated_to','=',$agent);
          $notassigned->Where('asignated_to','=',$agent);
          $closed->Where('asignated_to','=',$agent);
          $assigned->Where('asignated_to','=',$agent);
          $opentimetrue->Where('asignated_to','=',$agent);
          $opentimefalse->Where('asignated_to','=',$agent);
          $closevenctrue->Where('asignated_to','=',$agent);
          $closevencfalse->Where('asignated_to','=',$agent);
        }else{
          $solved->Where('status_system','=',TRUE);
          $open->Where('status_system','=',TRUE);
          $waiting->Where('status_system','=',TRUE);
          $notassigned->Where('status_system','=',TRUE);
          $closed->Where('status_system','=',TRUE);
          $assigned->Where('status_system','=',TRUE);
          $opentimetrue->Where('status_system','=',TRUE);
          $opentimefalse->Where('status_system','=',TRUE);
          $closevenctrue->Where('status_system','=',TRUE);
          $closevencfalse->Where('status_system','=',TRUE);
        }
      }

      if (isset(request()->group)){
        $Groups          = request()->group;
        if ($Groups){
          $open->Where('id_group','=',$Groups);
          $waiting->Where('id_group','=',$Groups);
          $notassigned->Where('id_group','=',$Groups);
          $closed->Where('id_group','=',$Groups);
          $solved->Where('id_group','=',$Groups);
          $assigned->Where('id_group','=',$Groups);
          $opentimetrue->Where('id_group','=',$Groups);
          $opentimefalse->Where('id_group','=',$Groups);
          $closevenctrue->Where('id_group','=',$Groups);
          $closevencfalse->Where('id_group','=',$Groups);
        }else{
          $open->Where('status_system','=',TRUE);
          $waiting->Where('status_system','=',TRUE);
          $notassigned->Where('status_system','=',TRUE);
          $closed->Where('status_system','=',TRUE);
          $solved->Where('status_system','=',TRUE);
          $assigned->Where('status_system','=',TRUE);
          $opentimetrue->Where('status_system','=',TRUE);
          $opentimefalse->Where('status_system','=',TRUE);
          $closevenctrue->Where('status_system','=',TRUE);
          $closevencfalse->Where('status_system','=',TRUE);
        }
      }

      if (isset(request()->dates)){
        $fechas = explode(" / ", request()->dates);
        $datestar = $fechas[0]." 00:00:00";
        $datelast = $fechas[1]." 00:00:00";
        $dates          = request()->dates;
        if ($dates){
          $open->whereBetween('date_register', [$datestar, $datelast]);
          $waiting->whereBetween('date_register', [$datestar, $datelast]);
          $notassigned->whereBetween('date_register', [$datestar, $datelast]);
          $closed->whereBetween('date_register', [$datestar, $datelast]);
          $solved->whereBetween('date_register', [$datestar, $datelast]);
          $assigned->whereBetween('date_register', [$datestar, $datelast]);
          $opentimetrue->whereBetween('date_register', [$datestar, $datelast]);
          $opentimefalse->whereBetween('date_register', [$datestar, $datelast]);
          $closevenctrue->whereBetween('date_register', [$datestar, $datelast]);
          $closevencfalse->whereBetween('date_register', [$datestar, $datelast]);
        }else{
          $open->Where('status_system','=',TRUE);
          $waiting->Where('status_system','=',TRUE);
          $notassigned->Where('status_system','=',TRUE);
          $assigned->Where('status_system','=',TRUE);
          $closed->Where('status_system','=',TRUE);
          $solved->Where('status_system','=',TRUE);
          $opentimetrue->Where('status_system','=',TRUE);
          $opentimefalse->Where('status_system','=',TRUE);
          $closevenctrue->Where('status_system','=',TRUE);
          $closevencfalse->Where('status_system','=',TRUE);
        }
      }


      $open = $open->Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $opentimetrue = $opentimetrue->Where('id_status_ts','=',3)->where('st_due_by','=',FALSE)->Where('status_system','=',TRUE)->count();
      $opentimefalse = $opentimefalse->Where('id_status_ts','=',3)->where('st_due_by','=',TRUE)->Where('status_system','=',TRUE)->count();
      $waiting = $waiting->Where('id_status_ts','=',3)->Where('status_system','=',TRUE)->count();
      $unsolved = $open + $waiting;
      $notassigned = $notassigned->Where('asignated_to','=',null)->Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $assigned = $assigned->Where('asignated_to','<>',null)->Where('id_status_ts','=',2)->Where('status_system','=',TRUE)->count();
      $closed = $closed->Where('id_status_ts','=',5)->Where('status_system','=',TRUE)->count();
      $solved = $solved->Where('id_status_ts','=',4)->Where('status_system','=',TRUE)->count();
      $closevenctrue = $closevenctrue->Where('id_status_ts','=',4)->where('st_fr_due_by','=',FALSE)->Where('status_system','=',TRUE)->count();
      $closevencfalse = $closevencfalse->Where('id_status_ts','=',4)->where('st_fr_due_by','=',TRUE)->Where('status_system','=',TRUE)->count();
      $total = $open + $waiting + $solved + $closed;

      $registeratesAll = [];
      $data = [
        'unsolved' => $unsolved,
        'open'  => $open,
        'waiting'  => $waiting,
        'notassigned'  => $notassigned,
        'closed'  => $closed,
        'total' => $total,
        'assigned'  => $assigned,
        'solved' => $solved,
        'opentimetrue' => $opentimetrue,
        'opentimefalse' => $opentimefalse,
        'closevenctrue' => $closevenctrue,
        'closevencfalse' => $closevencfalse
      ];
      array_push($registeratesAll, $data);

      return response()->json([
        'data'     =>  $registeratesAll,
      ]);
    }

    public function getResolutionTickets(){
      $assigned = RegisterAtencion::query();
      $assigned_array = array();
      $assigned = $assigned->Where('status_system','=',TRUE)->Where('asignated_to','<>',null)->distinct('asignated_to')->orderBy('asignated_to', 'ASC')->pluck('asignated_to');
      $assigned = json_decode($assigned);

      if (!empty($assigned)){
        foreach ($assigned as $assigneds) {
  				$asig_no = $assigneds;
          $asig = User::where('id', '=',$asig_no)->first();
  				$asig_name = $asig->name.' '.$asig->lastname;
  				$assigned_array[$asig_no] = $asig_name;
  			}
      }


      $asig_count_array = array();
      $asig_name_array = array();
      if (!empty($assigned_array)) {
        foreach ($assigned_array as $asig_nos => $asig_names) {
          $register = RegisterAtencion::select('created_at','updated_at')->Where('asignated_to','=',$asig_nos)->Where('id_status_ts','=',4)->orWhere('id_status_ts','=',5)->Where('status_system','=',TRUE)->get();
          $resultado = 0;

          foreach ($register as $valor){
            $fechcreado = strtotime($valor->created_at);
            $fechresuel = strtotime($valor->updated_at);
            $resultado  = $resultado + ($fechresuel - $fechcreado);
          }
          $total = count($register);
          $promedio = $resultado / $total;

          $seg = $promedio;

          $d = floor($seg / 86400);
          $h = floor(($seg - ($d * 86400)) / 3600);
          $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
          $s = $seg % 60;
          $times = '';

          if ($d > 0){
            $times =  ($d == 1) ? $d." Dia " : $d." Dias ";
          }

          if ($h > 0){
            $times .= ($h == 1) ? $h." hora " : $h." horas ";
          }

          if ($m > 0){
            $times .= ($m == 1) ? $m." minuto " : $m." minutos ";
          }

          if ($s > 0){
            $times .= ($s == 1) ? $s." segundo " : $s." segundos ";
          }
          array_push($asig_count_array, $times);
  				array_push($asig_name_array, $asig_names);
        }
      }

      $agent_post_data_array = array(
        'agent' => $asig_name_array,
        'time_resolve' => $asig_count_array
      );
      return $agent_post_data_array;
    }

}
