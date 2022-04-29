<?php

namespace App\Http\Controllers\api\output\RegisterAtencion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RegisterAtencion\RegisterAtencion;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Validator;
use App\Models\General\Brands;
use App\Models\General\GroupsTicket;
use App\Models\General\Operators;
use App\Models\General\Notifications;
use App\Models\General\Status;
use App\Models\General\Priority;
use App\Models\General\Category;
use App\Models\Customer\dtCustomerType;
use App\Models\General\StatusT;
use App\Models\General\TypeRequirements;
use App\Models\General\User;
use App\Models\RegisterAtencion\Timeregisters;
use App\Models\RegisterAtencion\Conversations;

class RegisterAtencionController extends Controller
{
  function create(Request $request){
  $r=new  RegisterAtencion();
  $rc=new Customer();

  // $rc->validate([
  //       'last_name'=>'required',
  //       'first_name'=>'',
  //       'dni'=>'',
  //       'phone'=>'required',
  //       'email'=>'required',
  //       'id_country'=>'',
  //       'id_state'=>'',
  //       'id_city'=>'',
  //       'address'=>'',
  //       'admission_date'=>'',
  //       'invited_by'=>'',
  //       'invited_user'=>'',

  //       'modified_by'=>'',
  //       'status_system'=>'',
  //       'note'=>'',
  //       'status_user'=>'',
  //       'dni_frontal'=>'',
  //       'dni_back'=>''
  //
  // ]);

  $validator = Validator::make($request->all(),[

        'id_customer'=>'required|numeric|exists:customers,id',
        'date_register'=>'required|date',
        // 'type_requirements'=>'required|numeric|exists:type_requirements,id',
        'subject'=>'required',
        'description'=>'required',
        'nro_ticket'=>'required|numeric',
        // 'status'=>'required',
        // 'id_incidents'=>'required',
        'modified_by'=>'required|numeric|exists:users,id',
        'created_by'=>'required|numeric|exists:users,id',
        'status_system'=>'required|boolean',
        'due_by' => 'required',
        'fr_due_by' =>'required',
        'id_type_requirements'=>'required|numeric|exists:type_requirements,id',
        'id_status_ts'=>'required|numeric',
        'id_group' => 'required|numeric|exists:groups_tickets,id',
        'id_priorities'=>'required|numeric',
        'id_country'=>'required|numeric',
        'id_type_customer'=>'required|numeric'

      ]);
      if ($validator->fails()) {
            return response()->json([  "object"   => "error",
            'errors' => $validator->errors()]);
          }

          $r->id_customer=request()->id_customer;
            $r->date_register=request()->date_register;
            // $r->type_requirements=request()->type_requirements;
            $r->subject=request()->subject;
            $r->description=request()->description;
            $r->nro_ticket=request()->nro_ticket;
            // $r->status=request()->status;
            // $r->id_incidents=request()->id_incidents;
            $r->modified_by=request()->modified_by;
            $r->created_by=request()->created_by;
            $r->status_system=request()->status_system;
            $r->due_by=request()->due_by;
            $r->fr_due_by=request()->fr_due_by;
            $r->id_type_requirements=request()->id_type_requirements;
            $r->id_status_ts=request()->id_status_ts;
            $r->id_group=request()->id_group;
            $r->id_priorities=request()->id_priorities;
            $r->id_country=request()->id_country;
            $r->id_type_customer=request()->id_type_customer;
  $r->save();
  return response()->json([  "object"   => "success"]);

  //
  // $rc->last_name=$request{'last_name;
  // $rc->first_name=$request{'first_name;
  // $rc->dni=$request{'dni;
  // $rc->phone=$request{'phone;
  // $rc->email=$request{'email;
  // $rc->id_country=$request{'id_country;
  // $rc->id_state=$request{'id_state;
  // $rc->id_city=$request{'id_city;
  // $rc->address=$request{'address;
  // $rc->admission_date=$request{'admission_date;
  // $rc->invited_by=$request{'invited_by;
  // $rc->invited_user=$request{'invited_user;

  // $rc->modified_by=$request{'modified_by;
  // $rc->status_system=$request{'status_system;
  // $rc->note=$request{'note;
  // $rc->status_user=$request{'status_user;
  // $rc->dni_frontal=$request{'dni_frontal;
  // $rc->dni_back=$request{'dni_back;


  }

  function store(Request $request){
    $dt = new \DateTime();
    $fecha = $dt->format('Y-m-d H:i:s');

    if(Customer::where('dni', '=',$request{'dni'})->where('id_type_documents', '=',$request{'type_docs'})->exists())
    {
        $DataCus = Customer::where('dni', '=',$request{'dni'})->where('id_type_documents', '=',$request{'type_docs'})->first();
        $idcustomer = $DataCus->id;
        $datacustomer =  Customer::findOrFail($idcustomer);
        $datacustomer->email = $request{'email'};
        $datacustomer->phone = $request{'phone'};
        $datacustomer->dni = $request{'dni'};
        $datacustomer->first_name = $request{'first_name'};
        $datacustomer->last_name = $request{'last_name'};
        $datacustomer->date_birth = $request{'datebirth'};
        $datacustomer->id_type_documents = $request{'type_docs'};
        $datacustomer->id_country = $request{'cod_country'};
        $datacustomer->id_state = $request{'cod_state'};
        $datacustomer->id_city = $request{'cod_city'};
        $datacustomer->address = $request{'district'};
        $datacustomer->modified_by  =  $request{'id_user'};
        $datacustomer->save();

        $datos = dtCustomerType::updateOrCreate(['id_customer' => $idcustomer, 'id_customerType' => $request{'typecustomer'}] , ['id_customer' => $idcustomer, 'id_customerType' => $request{'typecustomer'}] );
    }else{
      $data = [
        'first_name'      =>  $request{'first_name'},
        'last_name'       =>  $request{'last_name'},
        'date_birth'      =>  $request{'datebirth'},
        'dni'             =>  $request{'dni'},
        'phone'           =>  $request{'phone'},
        'email'           =>  $request{'email'},
        'id_country'      =>  $request{'cod_country'},
        'id_state'        =>  $request{'cod_state'},
        'id_city'         =>  $request{'cod_city'},
        'address'         =>  $request{'district'},
        'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
        'created_by'      =>  $request{'id_user'},
        'id_type_documents' => $request{'type_docs'}
      ];
      $idcustomer = Customer::create($data)->id;

      $datos = dtCustomerType::updateOrCreate(['id_customer' => $idcustomer, 'id_customerType' => $request{'typecustomer'}] , ['id_customer' => $idcustomer, 'id_customerType' => $request{'typecustomer'}] );
    }

    if ($request{'checkCustomerExt'} == "on"){
      if(Customer::where('dni', '=',$request{'dni_ext'})->where('id_type_documents', '=',$request{'type_docs_ext'})->exists())
      {
          $DataCustExt = Customer::where('dni', '=',$request{'dni_ext'})->where('id_type_documents', '=',$request{'type_docs_ext'})->first();
          $idcustomerExt = $DataCustExt->id;
          $datacustomerExt =  Customer::findOrFail($idcustomerExt);
          $datacustomer->email = $request{'email_ext'};
          $datacustomer->phone = $request{'phone_ext'};
          $datacustomer->dni = $request{'dni_ext'};
          $datacustomer->first_name = $request{'first_name_ext'};
          $datacustomer->last_name = $request{'last_name_ext'};
          $datacustomer->date_birth = $request{'datebirth_ext'};
          $datacustomer->id_type_documents = $request{'type_docs_ext'};
          $datacustomer->modified_by  =  $request{'id_user'};
          $datacustomer->save();
          $datosExt = dtCustomerType::updateOrCreate(['id_customer' => $idcustomerExt, 'id_customerType' => $request{'typecustomerext'}] , ['id_customer' => $idcustomerExt, 'id_customerType' => $request{'typecustomerext'}] );
      }else{
        $dataExt = [
          'first_name'      =>  $request{'first_name_ext'},
          'last_name'       =>  $request{'last_name_ext'},
          'date_birth'      =>  $request{'datebirth_ext'},
          'dni'             =>  $request{'dni_ext'},
          'phone'           =>  $request{'phone_ext'},
          'email'           =>  $request{'email_ext'},
          'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
          'created_by'      =>  $request{'id_user'},
          'id_type_documents' => $request{'type_docs_ext'}
        ];
        $idcustomerExt = Customer::create($dataExt)->id;
        $typecustomerext = $request{'typecustomerext'};
        $datosExt = dtCustomerType::updateOrCreate(['id_customer' => $idcustomerExt, 'id_customerType' => $request{'typecustomerext'}] , ['id_customer' => $idcustomerExt, 'id_customerType' => $request{'typecustomerext'}] );
        $cumpleanos2 = new \DateTime($request{'datebirth_ext'});
        $hoy2 = new \DateTime();
        $annos2 = $hoy2->diff($cumpleanos2);
        $yearold = $annos2->y;
      }

      $relationship = $request{'relationship'};
    }else{
      $idcustomerExt = null;
      $relationship = null;
      $typecustomerext = null;
      $yearold = null;
    }

    $correo = $request{'email'};
    $telefono = $request{'phone'};
    $nombre = $request{'first_name'};
    $apellido = $request{'last_name'};

    $type = $request{'status_user'};

    $description = $request{'description'};

    $allstatus = TypeRequirements::where('id', '=',$request{'status_user'})->first();

    $dataUser = User::where('id', '=',$request{'id_user'})->first();

    $correouser = $dataUser->email;
    $checkticket = $request{'checkticket'};

    $grupst = GroupsTicket::where('id', '=',$request{'group'})->first();

    if($type != 9 || $checkticket == "on"){
      $name =  $request{'file'};
      if(!empty($name)){
        $attachments = $request{'attachment_url'};
      }else{
        $attachments = null;
      }
      $nroticket = $request{'nro_ticket'};
    }else{
      $nroticket = 0;
      $attachments = null;
    }

    if ($request{'status_user'} == 2){
      $fechainci = $request{'fechven'};
      $horainci = $request{'hourven'}.":00.0000-05";
      $fechafina = $fechainci." ".$horainci;
    }else{
      $fechafina = null;
    }

    if ($type == 10){
      $subject = $request{'id_travel'}." - ".$request{'gestionado'};
      $category = $request{'category'};
    }else if ($type == 2){
      $subject = $nroticket." - ".$request{'subject'};
      $category = $request{'category'};
    }else{
      $subject = $nroticket." - ".$request{'subject'};
      $category = null;
    }

    $datcus = Customer::where('id', '=',$idcustomer)->first();

    $dateby = new \DateTime();
    $dateby->modify('+48 hours');
    $fr_due_by = $dateby->format('d-m-Y H:i:s');

    $date_due = new \DateTime();
    if($request{'id_priority'} == 1){
      $date_due->modify('+30 minute');
    }else if ($request{'id_priority'} == 2){
      $date_due->modify('+25 minute');
    }else if ($request{'id_priority'} == 3){
      $date_due->modify('+20 minute');
    }else{
      $date_due->modify('+15 minute');
    }

    if ($request{'typecustomer'} == 2){
      $placa = $request{'placa'};
      $marca = $request{'marca'};
      $modelo = $request{'modelo'};
      $color = $request{'color'};
      $year = $request{'year'};
      $typeSafe = $request{'typesafe'};
      $companyName = $request{'company'};
      $typeSoat = $request{'typesoat'};
      $fecEmi = $request{'soatemi'};
      $fecVen = $request{'soatven'};
    }

    $cumpleanos = new \DateTime($request{'datebirth'});
    $hoy = new \DateTime();
    $annos = $hoy->diff($cumpleanos);

    $dataregister = [
      'id_customer' => $idcustomer,
      'id_customer_ext' => $idcustomerExt,
      'relationship' => $relationship,
      'age' => $annos->y,
      'age_ext' => $yearold,
      'subject' => $subject,
      'description' => $description,
      'nro_ticket' => $nroticket,
      'date_register' => $fecha,
      'time_register' => $request{'timeregister'},
      'time_start_register' => $request{'timestaregister'},
      'due_by' => $request{'due_by'},
      'st_due_by' => false,
      'fr_due_by' => $request{'fr_due_by'},
      'st_fr_due_by' => false,
      'attachments' => $attachments,
      'id_type_requirements' => $request{'status_user'},
      'id_status_ts' => 2,
      'id_group' => $request{'group'},
      'ubication' => ($type == 2 && $category == 5) ? $request{'placeincident'} : $request{'ubication'},
      'id_travel' => $request{'id_travel'},
      'id_category'  => $category,
      'referenceubi' => $request{'referenceubi'},
      'id_priorities' => $request{'id_priority'},
      'id_country' => $datcus->id_country,
      'id_type_customer' => $request{'typecustomer'},
      'id_type_customer_ext' => $typecustomerext,
      'placa' => ($request{'typecustomer'} == 2) ? $placa : null,
      'marca' => ($request{'typecustomer'} == 2) ? $marca : null,
      'model' => ($request{'typecustomer'} == 2) ? $modelo : null,
      'color_car' => ($request{'typecustomer'} == 2) ? $color : null,
      'year' => ($request{'typecustomer'} == 2) ? $year  : null,
      'type_safe' => ($request{'typecustomer'} == 2) ? $typeSafe  : null,
      'enterprisesoat' => ($request{'typecustomer'} == 2) ? $companyName : null,
      'type_soat' => ($request{'typecustomer'} == 2) ? $typeSoat : null,
      'soatfecemi' => ($request{'typecustomer'} == 2) ? $fecEmi : null,
      'soatfecven' => ($request{'typecustomer'} == 2) ? $fecVen : null,
      'motive' => $request{'subject'},
      'id_operator' => $request{'operator'},
      'appwifi' => $request{'appred'},
      'id_brand' => $request{'brand'},
      'models' => $request{'model'},
      'OS' => $request{'OS'},
      'verOS'  => $request{'veros'},
      'date_time'  => $fechafina,
      'details' => $request{'description'},
      'created_by' => $request{'id_user'},
      'type_servicedesk' => $request{'typeTK'}
    ];
    $registerAtencion = RegisterAtencion::create($dataregister)->id;

    $dataUser = User::where('id','=',$request{'id_user'})->first();
    $dataticket = [
      'comment_subject' => $nroticket,
      'comment_text' => $dataUser->name." ".$dataUser->lastname." creó un nuevo ticket ".$subject,
      'comment_status' => 0,
      'comment_ip' => '0',
      'assigned_to' =>  $grupst->id_rol,
      'created_by' => $request{'id_user'},
      'modified_by' => $registerAtencion,
    ];
    $notickets = Notifications::create($dataticket);

    $dataregis = [
      'id_reg_att' => $registerAtencion,
      'dt_create_ticket_attention' => $fecha,
    ];
    $registime =  Timeregisters::create($dataregis);

    if ($registerAtencion > 0){
      return response()->json(["object" => "success", "message" => "creado"]);
    }else{
      return response()->json(["object" => "error", "message" => "no se creo"]);
    }
  }

  function reply (Request $request){
      $id_ticket = $request{'idti'};
      $descri =    $request{'desc'};
      $status =    $request{'type'};
      $registerData = RegisterAtencion::where('nro_ticket','=',$id_ticket)->first();
      $idregt =    $registerData->id;
      $dataUser = User::where('id','=',$request{'id_user'})->first();
      $data = [
                'description' => "<div>".$descri."</div>",
                'id_ticket' => $idregt,
                'created_by' => $request{'id_user'},
                'type_conversation' => 1
             ];
      $id = Conversations::create($data);

      $count = Conversations::where('id_ticket','=',$idregt)->count();
      if ($count == 1){
        $TicketsD = RegisterAtencion::where('id','=',$idregt)->first();
        $TicketsD->asignated_to = $request{'id_user'};
        $TicketsD->save();
      }

      $dataticket = [
            'comment_subject' => $id_ticket,
            'comment_text' => $dataUser->name." ".$dataUser->lastname." envio una respuesta al ticket ".$TicketsDet->subject,
            'comment_status' => 0,
            'comment_ip' => '0',
            'modified_by' => $idregt,
            'assigned_to' =>  $request{'rol_id'},
            'created_by' => $request{'id_user'}
             ];
      $notickets = Notifications::create($dataticket)->id;

      $dataupdate = RegisterAtencion::where('id','=',$idregt)->first();
      $dataupdate->id_status_ts = $status;
      $dataupdate->save();

      if ($notickets > 0){
            return response()->json(["message" => "creado"]);
      }else{
            return response()->json(["message" => "error"]);
      }
  }

}
