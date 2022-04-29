<?php

namespace App\Models\External\Driver;

use Illuminate\Database\Eloquent\Model;

class eventoData extends Model
{
  protected $table      = 'evento_datas';
  protected $fillable   = ['id_office','first_name','last_name','id_type_documents','dni','phone', 'email','id_viaje', 'updated_at', 'created_at' ];
}
