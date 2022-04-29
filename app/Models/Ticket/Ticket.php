<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\TicketDs;
use App\Models\Product\Product;
use App\Models\General\Money;
use App\Models\General\Pay;
use App\Models\GuestPayment\guestPayment;
use App\Models\Customer\Customer;
use App\Models\General\Country;
use App\Models\General\Status;

use App\User;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $fillable  = ['cod_ticket','id_customer','id_invited_by','id_pay','total','status_user', 'created_at',
  'modified_by','create_by','number_operation','id_country_invert','date_pay', 'note','donate','obser_int'];

  public function getTicketDs()  {
    return $this->hasOne(TicketDs::class, 'id_ticket');
  }

  public function getProduct()  {
    return $this->hasManyThrough(Product::class, TicketDs::class, 'id_ticket', 'id', 'id', 'id_product');
  }

  public function getStatus()  {
    return $this->belongsTo(Status::class, 'status_user')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getMoney()  {
    return $this->hasManyThrough(Money::class, TicketDs::class, 'id_ticket', 'id', 'id', 'id_money');
  }

  public function getCustomer() {
    return $this->belongsTo(Customer::class,     'id_customer')->withDefault([
      'id' => '0',
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'dni' => '0',
    ]);
  }
  public function getInvited() {
    return $this->belongsTo(Customer::class,     'id_invited_by')->withDefault([
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'dni' => '0',
    ]);
  }
  public function getModifyBy() {
    return $this->belongsTo(User::class,         'modified_by')->withDefault([
        'username' => 'Anónimo',
          ]);
  }
  public function getCreateBy() {
    return $this->belongsTo(User::class,         'create_by')->withDefault([
        'username' => 'Anónimo',
          ]);
  }
  public function getCountryInv() {
    return $this->belongsTo(Country::class,    'id_country_invert')->withDefault([
        'description' => 'Anónimo',
          ]);
  }
  public function getPay() {
    return $this->belongsTo(Pay::class,    'id_pay');
  }

  public function getGuestPayment(){
    return $this->hasOne(guestPayment::class, 'id_ticket');
  }

  public static function getTicketID($id) {
    return Ticket::where('status_system', '=', 'TRUE')->where('id_customer', '=', $id)->get();
  }
}
