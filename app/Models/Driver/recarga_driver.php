<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class recarga_driver extends Model
{
  protected $table      = 'recarga_drivers';
  protected $fillable   = ['id_driver_api' , 'money', 'amount'];

}
