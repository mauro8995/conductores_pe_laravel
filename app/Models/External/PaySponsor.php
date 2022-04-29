<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\User_office;
use App\User;

class PaySponsor extends Model
{
  protected $table      = 'pay_sponsors';
  protected $connection = 'pgsql';
  protected $fillable   = ['cod_pay','id_customer','date_pay','status_pay','created_by','modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;

  public function getCustomer()
  {
    return $this->belongsTo(Customer::class,'id_customer','id')->withDefault([
      'id' => '0'
    ]);
  }



}
