<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Type_money extends Model
{

  protected $table      = 'type_moneys';
  protected $fillable   = ['id_country','ISO_3'];

}
