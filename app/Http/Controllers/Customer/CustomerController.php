<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\dtCustomerType;
use App\Models\Customer\form;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Red\Red;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketDs;
use App\Models\Product\Product;
use App\Models\Product\Price;
use App\Models\General\Pay;
use App\Models\General\Banks;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\City;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use App\Models\GuestPayment\guestPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Classes\MainClass;
use App\Models\Book\Book;
use \PDF;
use Auth;
use \stdClass;


class CustomerController extends Controller{

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');
	}

  public function CustomerPermisos(){
    $a = new stdClass();

    $a->create = false;
    $a->view = false;
    $a->edit = false;
    $a->delete = false;
    $a->reporte = false;
    $a->crearticket = false;
    $a->viewticketgene = false;
    $a->viewticketper = false;
    $a->traspaso = false;
    $a->aprobarfile = false;
    $a->firmarbook = false;

    return $a;
  }

  public function index(){
    $main = new MainClass();
    $main = $main->getMain();


      $t = $this->PermisosCustomer();
      $permisocrear = $t->create;
      $permisoverdet = $t->view;

      $rolid = $t->rolid;

      $customers = Customer::where('status_system', '=', 'TRUE')
      //->whereIn('status_user', [1,2,3,6])
      ->with('getStatus')
      ->orderBy('created_at', 'asc')
      ->get();

      if ($permisoverdet == true || $rolid == 4){
          return view('customer.index', compact('customers','main', 'route','permisocrear','rolid','permisoverdet'));
      }else{
        return view('errors.403', compact('main'));
      }
  }

  public function show($id){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosCustomer();
    $permiso = $t->edit;
    $rolid = $t->rolid;
    $vergene = $t->viewticketgene;
    $verespe = $t->viewticketper;

    $customer = Customer::where('status_system', '=', 'TRUE')
    ->where('id', '=', $id)
    ->with('getCountry', 'getState', 'getCity')
    ->first();

    if ($vergene == true || $rolid == 4 || $verespe == true){
      return view('customer.show', compact('customer', 'main','permiso','rolid','vergene','verespe','id'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  public function getbookscustomerID($id){
    $booksQuery;
    $books = [];

    $url = request()->path();
    $url = explode("/",$url);
    $url = $url[0];

    $t = $this->PermisosCustomer();

    $booksQuery = Book::where('status_system', '=', 'TRUE')
                    ->where('id_customer', '=', $id)
                    ->get();


    foreach ($booksQuery as $r) {

      $ticket = Ticket::where('nro_book', '=', $r->nro_book)->first();

      $iconSt   = 'fa-check-square-o';

      $iconDelet = 'fa-trash-o';

      $action   = '<center>';

      $action  .= ($t->rolid == '4' || $t->traspaso == true) ?
                  '&nbsp;&nbsp;<a data-toggle="modal" data-target="#modal-book-update" data-id='.$r->id.' data-nro='.$r->nro_book.' title="Transferir accion" class="btn-book-update"><i class="fa fa-eye"></i></a>' : '';

      $action  .= ($r->sign_book == false && $t->rolid == '4' || $r->sign_book == false && $t->firmarbook == true)  ?
                  '&nbsp;&nbsp;<a statusbook="1"  data-id="'.$r->nro_book.'" id="signbook"><i class="fa '.$iconSt.'" title="Aprobar firmo libro"></i></a>' : '';

      $action  .= ($r->file_book == false && $t->rolid == '4' || $r->file_book == false && $t->aprobarfile == true)  ?
                  '&nbsp;&nbsp;<a statusbook="2"  data-id="'.$r->nro_book.'" id="signbook"><i class="fa '.$iconSt.'" title="Aprobar file"></i></a>' : '';

      $action  .= '</center>';

      $download  = ($r->print_book == false && $t->rolid == '4' || $r->print_book == false && $t->printCert == true) ?
                   '<center><a  onclick="openCertBook()"  data-id="'.$ticket->id.'" class="btn-certif"><i class="fa fa-download"></i></a></center>' : '';


      $book   = [
        'action'         => $action,
        'nro_book'       => $r->nro_book ?      $r->nro_book      : '-',
        'nro_acciones'   => $r->nro_acciones ?  $r->nro_acciones  : '-',
        'download'       => $download ?         $download         : '-',
        'cant_print_book'=> $r->cant_print_book ?  $r->cant_print_book  : '0',
        'sign_book'      => $r->sign_book ?     '<i class="fa fa-check" title="Si"></i>'     : '<i class="fa fa-remove" title="No"></i>',
        'file_book'      => $r->file_book ?     '<i class="fa fa-check" title="Si"></i>'     : '<i class="fa fa-remove" title="No"></i>',
      ];
      array_push($books, $book);
    }
    return response()->json(["data"=>$books]);
  }

  public function UpdateBook(){
   if (request()->ajax( )){

     $nro_libro = Book::where('nro_book', '=', request()->id)->first();
     $book     = Book::findOrFail($nro_libro->id);


     try{
       DB::beginTransaction();
         if (request()->status == 1){

           $book->modified_by = auth()->user()->id;
           $book->sign_book = true;
           $book->save();

         }else if (request()->status == 2) {
           $book->modified_by = auth()->user()->id;
           $book->file_book = true;
           $book->save();

         }
       DB::commit();
     }catch(\Exception $e){  dump($e);  DB::rollback(); }
     $mensaje;
     $mensaje = 'El N° de libro '.request()->id.' ha sido actualizado de forma satisfactoria';
     return response()->json([
         "mensaje"       => $mensaje
       ]);
     }
  }

  public function edit($customer){
    $main = new MainClass();
    $main = $main->getMain();

    $customer = Customer::
    where('status_system', '=', 'TRUE')
    ->where('id', '=', $customer)
    ->with('getStatus')
    ->first();

    $country        = Country::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
    $state          = State::where('id_country', '=', $customer->id_country)->orderBy('description', 'ASC')->pluck('description', 'id');
    $city           = City::where('id_state', '=',    $customer->id_state  )->orderBy('description', 'ASC')->pluck('description', 'id');

    return view('customer.edit', compact('customer',  'country', 'state','city', 'main'));

  }

  public function update(Customer $customer){
    $data = request()->validate([
      'first_name'   => 'required',
      'last_name'    => 'required',
      'dni'          => 'required',
      'phone'        => 'required',
      'email'        => 'required',
      'id_country'   => 'required',
      'id_state'     => 'required',
      'id_city'      => 'required',
      'address'      => 'required'
    ]);

    $customer->update($data);
    return  redirect()->route('customer.show', ['id'=>$customer->id]);
  }

  public function create(){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosCustomer();
    $permisocrear = $t->create;
    $rolid = $t->rolid;
    $crearticket = $t->crearticket;

    $country        = Country::WHERE ('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
    $pay            = Pay::WHERE     ('status_user', '=', 'TRUE')->orderBy('name_pay',    'ASC')->pluck('name_pay', 'id');
//    $customer       = Customer::select(DB::raw("UPPER(CONCAT(dni, ' - ', last_name,'  ', first_name)) AS name"), "id")->where('status_system', '=', 'TRUE')->whereIn('status_user', ['1', '6'])->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');
    $country_invs   = Country::WHERE ('status_user', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
    $banks          = Banks::WHERE ('status_system', '=', 'TRUE')->pluck('name', 'id');


    if ($crearticket == true || $rolid == 4){
      return view('customer.create', compact('country', 'pay', 'customer','products', 'invited', 'country_invs', 'main','banks'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  function createshow(){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosCustomer();
    $permisover = $t->view;
    $rolid = $t->rolid;

    $country = Country::WHERE ('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');


    if ($permisover == true || $rolid == 4){
      return view('customer.registro', compact('country', 'main'));
    }else{
      return view('errors.403', compact('main'));
    }


  }

  public function validUserDni(){
    $num = true;
    if (request()->ajax( )){
        $user = Customer::where('status_system', '=', 'TRUE')
        ->where('dni', '=', request()->dni)
        ->first();
        if ($user) {$num = false;}
        return response()->json($num);
      }
  }

  public function store(Request $r){
    $id_ticket;

    try{
      DB::beginTransaction();

      //REGISTRO DEL QUIEN INVITA
      $dniExistsInv = Customer::where('dni', '=', request()->customer{'dni_inv'})->exists();

      if (!$dniExistsInv){
          $invited = [
            'first_name'      =>  request()->customer{'name_inv'},
            'last_name'       =>  request()->customer{'lastname_inv'},
            'dni'             =>  request()->customer{'dni_inv'},
            'phone'           =>  request()->customer{'phone_inv'},
            'email'           =>  request()->customer{'email_inv'},
            'id_country'      =>  request()->customer{'cod_country_inv'},
            'id_state'        =>  request()->customer{'cod_state_inv'},
            'id_city'         =>  request()->customer{'cod_city_inv'},
            'address'         =>  request()->customer{'district_inv'},
            'admission_date'  =>  "12-12-12",
            'modified_by'     =>  auth()->user()->id,
            'invited_user'    =>  '',
            'status_user'     => '6'
          ];
        $id_invited_by = Customer::create($invited)->id;

      }else {
        $cc = Customer::where('dni', '=', request()->customer{'dni_inv'})->get()[0];
        $id_invited_by = $cc->id;
        if(request()->actualizarInvitado=="true")
        {
          $cc->first_name      =  request()->customer{'name_inv'};
          $cc->last_name       =  request()->customer{'lastname_inv'};
          $cc->phone           = request()->customer{'phone_inv'};
          $cc->email           =  request()->customer{'email_inv'};
          $cc->id_country = request()->customer{'cod_country_inv'} ;
          $cc->id_state = request()->customer{'cod_state_inv'};
          $cc->id_city =  request()->customer{'cod_city_inv'};
          $cc->address         =  request()->customer{'district_inv'};
          $cc->modified_by     =  auth()->user()->id;
          $cc->save();
        }

      }

      //REGISTRO DEL CLIENTE
      $dniExists = Customer::where('dni', '=', request()->customer{'dni'})->exists();
      if (!$dniExists){
        $customer =
        [
          'first_name'      =>  request()->customer{'first_name'},
          'last_name'       =>  request()->customer{'last_name'},
          'dni'             =>  request()->customer{'dni'},
          'phone'           =>  request()->customer{'phone'},
          'email'           =>  request()->customer{'email'},
          'id_country'      =>  request()->customer{'cod_country'},
          'id_state'        =>  request()->customer{'cod_state'},
          'id_city'         =>  request()->customer{'cod_city'},
          'address'         =>  request()->customer{'district'},
          'admission_date'  =>  "12-12-12",
          'modified_by'     =>  auth()->user()->id,
          'invited_user'    =>  '-',
          'invited_by'      =>  $id_invited_by
        ];
        if($this->validateCustomerDni(request()->customer{'dni'}))
        {
          $id_customer = $this->getCustomerDni(request()->customer{'dni'})->id;
        }else {
          $id_customer = Customer::create($customer)->id;
        }

      }
      else{
        $pp = Customer::where('dni', '=', request()->customer{'dni'})->get()[0];
        $id_customer = $pp->id;
        if(request()->actualizarCustomer=="true")
        {
          $pp->first_name      =  request()->customer{'first_name'};
          $pp->last_name       = request()->customer{'last_name'};
          $pp->phone           = request()->customer{'phone'};
          $pp->email           =  request()->customer{'email'};
          $pp->id_country = request()->customer{'cod_country'} ;
          $pp->id_state = request()->customer{'cod_state'};
          $pp->id_city =  request()->customer{'cod_city'};
          $pp->address         =  request()->customer{'district'};
          $pp->modified_by     =  auth()->user()->id;
          $pp->save();
        }
      }


      //Registro de Tickes
      $total = 0;



      $pro = Product::where('cod_product', '=', request()->customer{'cod_product'} )
      ->with('getProductAction')
      ->first();
      $total = $pro->getProductAction->sale_price;

      $priceee = Price::where('id', request()->id_price)->first();

      $ticket = [
        'cod_ticket'          => $this->getCodeGenerate(request()->codigoPais),
        'id_customer'         => $id_customer,
        'id_invited_by'       => $id_invited_by,
        'id_pay'              => request()->customer{'cod_pago'},
        'total'               => $priceee->price,
        'modified_by'         => auth()->user()->id,
        'create_by'         => auth()->user()->id,
        'number_operation'    => request()->customer{'number_operation'},
        'id_country_invert'   => request()->customer{'id_country_invs'},
        'date_pay'            => request()->customer{'date_pay'} ." ".request()->customer{'hour_pay'}.".0000-05",
        'note'                => request()->customer{'note'},
        'donate'              => request()->customer{'donate'},
        'status_user'         => '1',
        'id_banks'            => request()->customer{'id_banks'},
      ];
      $id_ticket = Ticket::create($ticket)->id;

        $ticketds = [
          'id_ticket'      =>  $id_ticket,
          'id_product'     =>  $pro->id,
          'cant'           =>  '1',
          'price'          =>  $priceee->price,
          'id_money'       =>  $priceee->id_money,
          'total'          =>  $priceee->price,
          'modified_by'    =>  auth()->user()->id,
          'create_by'      =>  auth()->user()->id
        ];

        $id_ticketDs = TicketDs::create($ticketds)->id;
        $respuesta = true;
        DB::commit();
        }catch(\Exception $e){
          DB::rollback();
          dump($e);
          $respuesta = false;
         }



    return response()->json([
        "answer"   => $respuesta,
        "id_ticket" => $id_ticket
      ]);

  }

  public function customerstore(Request $r){

    try{
      DB::beginTransaction();

      //REGISTRO DEL CLIENTE
       $customer = [
          'first_name'      =>  request()->customer{'first_name'},
          'last_name'       =>  request()->customer{'last_name'},
          'dni'             =>  request()->customer{'dni'},
          'phone'           =>  request()->customer{'phone'},
          'email'           =>  request()->customer{'email'},
          'id_country'      =>  request()->customer{'cod_country'},
          'id_state'        =>  request()->customer{'cod_state'},
          'id_city'         =>  request()->customer{'cod_city'},
          'address'         =>  request()->customer{'district'},
          'admission_date'  =>  "12-12-12",
          'modified_by'     =>  auth()->user()->id,
          'invited_by'      =>  null,
        ];
        $id_customer = Customer::create($customer)->id;
        $respuesta = true;
        DB::commit();
        }catch(\Exception $e){
          DB::rollback();
          $respuesta = false;
         }
    return response()->json([
        "answer"   => $respuesta
      ]);
  }

  public function getTicketforID(){
    $id = request()->all();
    $ticket = Ticket::where('id', '=', $id)
    ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
    ->first();

    $cabecera         = $this->getTicket_id($id);
    $pay              = $this->getPay($cabecera->id_pay);

    $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
    $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
    $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

    $countryinvert    = $this->getCountrys($cabecera->id_country_invert) ? $this->getCountrys($cabecera->id_country_invert)->description : '';

    $queryT = [
      'ticket' => $ticket,
      'cabecera' => $cabecera,
      'pay' => $pay,
      'city' => $city,
      'state' => $country,
      'countryinvert' => $countryinvert

    ];

    return  response()->json($queryT);
  }

  public function pdf($id){

    $ticket = Ticket::where('id', '=', $id)
    ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
    ->first();

    $cabecera         = $this->getTicket_id($id);
    $pay              = $this->getPay              ($cabecera->id_pay);

    $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
    $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
    $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

    $countryinvert    = $this->getCountrys($cabecera->id_country_invert) ? $this->getCountrys($cabecera->id_country_invert)->description : '';
    $detalleprod      = $this->getProduct($ticket->getProduct[0]->id);

    $tk = Ticket::where('id',$id)->first();
    $tk->total = 300;
    $tk->save();



    $pdf = PDF::loadView('customer.imprimir',compact('ticket', 'country', 'state', 'city', 'cabecera', 'pay','detalleprod'));
    return $pdf->download('ticket.pdf');
   }

   public function getTicket_id($id){
     return  DB::table('tickets')
      ->where('id', '=', $id)->first();
   }

   public function getPay($id)
   {
     return  DB::table('pays')
      ->where('id', '=', $id)->first();
   }

   public function getCustumer($id)
   {
     return  DB::table('customers')
      ->where('id', '=', $id)->first();
   }

   public function getCitys($id)
   {
     return  DB::table('city')
      ->where('id', '=', $id)->first();
   }

   public function getStates($id)
   {
     return  DB::table('state')
      ->where('id', '=', $id)->first();
   }


   public function getCountrys($id)
   {
     return  DB::table('country')
      ->where('id', '=', $id)->first();
   }

   public function getProducts_idTicket($id)
   {
     return  DB::table('ticket_ds')
               ->join('products','ticket_ds.id_product','=','products.id')
               ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
               ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
               ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
               'moneys.id','moneys.description as moneyName','product_actions.cant','product_actions.sale_price')
                ->where('ticket_ds.id_ticket', '=', $id)
               ->get();
   }

  public function getState(){
     return  DB::table('state')->where('id_country', '=', request()->id)->get();
   }

  public function getCity(){
     return  DB::table('city')->where('id_state', '=', request()->id )->get();
   }

  public function getCodeGenerate($r){
     $now = new \DateTime();
     return  "TK-".$r."-".$now->format('d').$now->format('m').$now->format('Y').'-'.$this->getCodigo();
   }

  public function getProductos(){
       return DB::table('products')
             ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
             ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
             ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
             'moneys.description','product_actions.cant','product_actions.sale_price')
             ->where('products.status_system', '=', 'TRUE')
             ->get();
   }

  public function getProduct($id){
     return  DB::table('products')
               ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
               ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
               ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
               'moneys.id as money','product_actions.cant','product_actions.sale_price')
                ->where('products.id', '=', $id)
               ->get();
   }

   public function getCodigo(){
     $now = new \DateTime();
     $fecha = $now->format('Y')."-".$now->format('m')."-".$now->format('d');
     $fi = $fecha." 00:00:00.0000-05";
     $ff = $fecha." 23:59:59.0000-05";
      return DB::table('tickets')->whereBetween('created_at', [$fi, $ff])->count()+1;
    }

  public function valiDateCodePay(Request $r){
     $respuesta =  DB::table('tickets')
     ->where('number_operation','=', $r->cod)
     ->Where('date_pay','=',$r->date ." ".$r->hour.".0000-05")
     ->exists();

     return response()->json([
         "mensaje"   => $respuesta,
         "test" => $r->date ." ".$r->hour.".0000-05"
       ]);
   }

  public function validateDNI(Request $r){
     $respuesta =  DB::table('customers')
     ->where('dni','=', $r->cod)
     ->exists();

     return response()->json([
         "mensaje"   => $respuesta
       ]);
   }


  public function getCustomerDni($dni)
  {
    return $p = Customer::where('dni', $dni)
    ->with('getCountry', 'getState', 'getCity')
    ->first();
  }

  public function saveDniFile()
  {
    $data     =  request()->data;
    $customer = Customer::where('id', $data{'id_customer'})->with('getCountry', 'getState', 'getCity')->first();
    if($data{'name'} == 'dni_frontal'){
      $customer->dni_frontal = $data{'url'};
    }else{
      $customer->dni_back = $data{'url'};
    }
    $customer->save();
    return 'true';
  }

  public function validateCustomerDni($dni)
  {
    return $p = Customer::where('dni', $dni)
    ->exists();
  }

  public function getCustomer()
  {
    $dni = request()->dni;
    if ($this->validateCustomerDni($dni))
    {
       $d = $this->getCustomerDni($dni);
       return response()->json([
         "objet"=>"success",
         "message"=> "winsystem",
         "data" => $d
       ]);
    }
    else
    {
      $dataAccionista = json_decode(file_get_contents('http://taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomerRedArray&data='.$dni), true);
      if($dataAccionista{'datos'})
      {
          $v = $dataAccionista{'datos'};
      }else
      $v = null;
      if(!empty($v))
      {
        $a= new stdClass();
        $a->first_name = $v{'first_name'};
        $a->last_name = $v{'last_name'};
        $a->dni = $v{'dni'};
        $a->email = $v{'email'};
        $a->phone = $v{'phone'};

        return response()->json([
          "objet"=>"success",
          "message"=> "taxiWin",
          "data" =>$a
        ]);
      }
      else
      {
        return response()->json([
          "objet"=>"warning",
          "message"=> "No esta registrado."
        ]);
      }
    }
  }



//actulizar ticket -----------------------------------------------
public function  updateTicket_id()
{
  $tk = Ticket::where('id',$id)->first();
  $tk->total = 300;
  $tk->id_pay = 4;
  $tk->id_country_invert = 1;
  $tk->modified_by = auth()->user()->id;
  $tk->note = "Algo";
  $tk->donate = false;
  $tk->status_user = 4;
  //edicion del comprador
  if(Customer::where('dni',$excel->dniC)->exists())
  {
    $cu = new stdClass();
    $cu->id_customer = Customer::where('dni',$excel->dniC)->first()->id;
    $cu->last_name = $excel->last_name;
    $cu->first_name = $excel->first_name;
    $cu->dni = $excel->dni;
    $cu->phone = $excel->phone;
    $cu->email = $excel->email;
    $cu->id_country = $excel->id_country;
    $cu->id_state = $excel->id_state;
    $cu->id_city = $excel->id_city;
    $cu->address = $$excelc->address;
    $this->updateCustomer($cu);
  }
  else
  {
      $cu = new Customer();
       $cu->first_name =  $tk->first_name;
       $cu->last_name = $c->last_name;
       $cu->dni = $c->dni;
       if($c->phone != null ||$c->phone != "")
       $cu->phone = $c->phone;
       if($c->email != null ||$c->email != "")
       $cu->email = $c->email;
       if($c->id_country != null ||$c->id_country != "")
       $cu->id_country = $c->id_country;
       if($c->id_state != null ||$c->id_state != "")
       $cu->id_state = $c->id_state;
       if($c->id_city != null ||$c->id_city != "")
       $cu->id_city = $c->id_city;
       if($c->address != null ||$c->address != "")
       $cu->address = $c->address;
       $cu->save();
  }
  //actulizar el invitado
  if(Customer::where('dni',$tk->dniI)->exists())
  {
    $cu = new stdClass();
    $cu->id_customer = Customer::where('dni',$tk->dniC)->first()->id;
    $cu->last_name = $c->last_name;
    $cu->first_name = $c->first_name;
    $cu->dni = $c->dni;
    $cu->phone = $c->phone;
    $cu->email = $c->email;
    $cu->id_country = $c->id_country;
    $cu->id_state = $c->id_state;
    $cu->id_city = $c->id_city;
    $cu->address = $c->address;
    $this->updateCustomer($cu);
  }
  else
  {
    $cu = new Customer();
     $cu->first_name =  $tk->first_name;
     $cu->last_name = $c->last_name;
     $cu->dni = $c->dni;
     if($c->phone != null ||$c->phone != "")
     $cu->phone = $c->phone;
     if($c->email != null ||$c->email != "")
     $cu->email = $c->email;
     if($c->id_country != null ||$c->id_country != "")
     $cu->id_country = $c->id_country;
     if($c->id_state != null ||$c->id_state != "")
     $cu->id_state = $c->id_state;
     if($c->id_city != null ||$c->id_city != "")
     $cu->id_city = $c->id_city;
     if($c->address != null ||$c->address != "")
     $cu->address = $c->address;
     $cu->save();
  }
  //actulizar bono
  if(guestPayment::where('id_ticket', $tk->id_ticket)->exists())
  {
    $gp =  new stdClass();
    $gp->observaciones = $tk->observaciones;
    $gp->modo_pago = $tk->tipoPago;
    $gp->tip_moneda =$tk->tipo_money;
    $this->updateBono($gp);
  }

  if(Product::where('id', $tk->id_product)->existe())
  {
    $td =  new stdClass();
    $td->id_product = $t->id_product;
    $td->price = $t->price;
    $td->id_money = $t->id_money;
    $td->total = $t->price;
    $this->updateProductTicket($td);
  }
  $tk->save();

}

public function updateBono($d)
{
  $b = guestPayment::where('id_ticket', $d->id_ticket)->first();
  $b->observaciones = $d->observaciones;
  $b->modo_pago = $d->id_pago;
  $b->tip_moneda = $d->id_money;
  $b->modified_by = auth()->user()->id;
  $b->save();
}

public function updateProductTicket($t)
{
  $ds = TicketDs::where('id_ticket', $t->id_ticket)-first();
  $ds->id_product = $t->id_product;
  $ds->price = $t->price;
  $ds->id_money = $t->id_money;
  $ds->total = $t->price;
  $ds->modified_by = auth()->user()->id;
  $ds->save();
}

public function updateCustomer($c)
{
  $cu = Customer::where('id', $c->id_customer)->first();
  $cu->last_name = $c->last_name;
  $cu->first_name = $c->first_name;
  $cu->dni = $c->dni;
  if($c->phone != null ||$c->phone != "")
  $cu->phone = $c->phone;
  if($c->email != null ||$c->email != "")
  $cu->email = $c->email;
  if($c->id_country != null ||$c->id_country != "")
  $cu->id_country = $c->id_country;
  if($c->id_state != null ||$c->id_state != "")
  $cu->id_state = $c->id_state;
  if($c->id_city != null ||$c->id_city != "")
  $cu->id_city = $c->id_city;
  if($c->address != null ||$c->address != "")
  $cu->address = $c->address;
  return $cu->save();
}

  //tessttt--------------------------------------------------------------------
  //
  public function viewTest()
  {
    $main = new MainClass();
    $main = $main->getMain();


    return view('customer.test',compact('customer', 'main'));
  }


  //
  public function viewFormulario()
  {
    $main = new MainClass();
    $main = $main->getMain();

    return view('customer.formTotacion',compact('main'));
  }

  public function getReniec(Request $r)
  {
    $dataReniec = file_get_contents('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$r->dni);

    $valorDoc = explode("|", $dataReniec);

    $a = new stdClass();
    $a->first_name = $valorDoc[2];
    $a->last_name = $valorDoc[0].' '.$valorDoc[1];

    return response()->json(["mensaje" => "s", "dato" => $a]);

  }

  public function getReniecB($r)
  {
    $dataReniec = file_get_contents('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$r);

    $valorDoc = explode("|", $dataReniec);

    $a = new stdClass();
    $a->first_name = $valorDoc[2];
    $a->last_name = $valorDoc[0].' '.$valorDoc[1];

    return  $a;

  }

  public function registerForm()
  {

    $dni = $this->getCustomerB(request()->dni);

    if(!form::where('dni', request()->dni)->exists())
    {
      $invited = [
        'first_name'      =>  $dni->first_name,
        'last_name'       =>  $dni->last_name,
        'dni'             =>  request()->dni,
        'q1'           =>  request()->p1,
        'q2'           =>  request()->p2,
        'q3'      =>  request()->p3,
        'q4'        =>  request()->p4
      ];
    $id_invited_by = form::create($invited)->id;
      return response()->json(["mensaje" => "success"]);
    }
    else {
      return response()->json(["mensaje" => "warning"]);
    }

  }


  function exporForm()
  {
    $da = form::all();
    $d = [];
    foreach ($da as $key => $value) {

      $c =
      [
        'Dni' =>$value{'dni'},
        'Nombre'=>$value{'first_name'},
        'Apellido' =>$value{'last_name'},
        'Pre1' =>$value{'q1'},
        'Pre2' =>$value{'q2'},
        'Pre3' =>$value{'q3'},
        'Pre4' =>$value{'q4'}

      ];
      array_push($d, $c);
    }
    $list = collect($d);
     return  (new FastExcel($list))->download('votaciones.xlsx');
  }

  public function getCustomerB($dni)
  {

    if ($this->validateCustomerDni($dni))
    {
       $d = $this->getCustomerDni($dni);
       return $d;
    }
    else
    {
      $dataAccionista = json_decode(file_get_contents('http://winistoshare.com/API/ConeccionwinIsToShare/Conexion/customer.php?data='.$dni.'&key=1234'), true);
      if(!empty($dataAccionista))
      {
        $a= new stdClass();
        $a->first_name = $dataAccionista[0]{'first_name'};
        $a->last_name = $dataAccionista[0]{'last_name'};
        $a->dni = $dataAccionista[0]{'dni'};
        $a->email = $dataAccionista[0]{'email'};
        $a->phone = $dataAccionista[0]{'phone'};

        return $a;
      }
      else
      {
        $a= new stdClass();
        $a->dni = null;
        return $a;
      }
    }
  }

  //-----------------cabmiar estado de customer a drive
  public function registerOrder(){
    return view('customer.formOrder');
  }

  //permisoscustomer
  public function PermisosCustomer(){

    $rol = Main::where('users.id', '=', auth()->user()->id)
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id','rol_user.id as id_roluser')
      ->first();

   $roluser = $rol{'id_roluser'};

    $t = $this->CustomerPermisos();

    $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                  ->select('id_permission')
                  ->get();

    foreach ($permissions as $rs) {
        if ($rs->id_permission == 12){
           $t->create = true;
        }else if ($rs->id_permission == 13){
           $t->edit = true;
        }else if ($rs->id_permission == 14){
           $t->view = true;
        }else if ($rs->id_permission == 15){
           $t->delete = true;
        }else if ($rs->id_permission == 17){
           $t->reporte = true;
        }else if ($rs->id_permission == 2){
           $t->crearticket = true;
        }else if ($rs->id_permission == 3){
           $t->viewticketgene = true;
        }else if ($rs->id_permission == 4){
           $t->viewticketper = true;
        }else if ($rs->id_permission == 18){
          $t->traspaso = true;
        }else if ($rs->id_permission == 36){
           $t->aprobarfile  = true;
        }else if ($rs->id_permission == 37){
          $t->firmarbook = true;
        }


    }

    $t->rolid = $rol{'id'};

    return $t;
  }


}
