<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\External\ProcesoValCond;

class Audits extends Model
{
  protected $table      = 'audits';
  protected $connection = 'pgsql';
  protected $fillable   = ['user_type','user_id','event','auditable_type','auditable_id','old_values', 'new_values', 'updated_at', 'created_at' ];
  public    $timestamps = true;

  function getUsers()
  {
    return $this->belongsTo(User::class, 'user_id','id')->withDefault([
      'id' => '0'
    ]);
  }

  function getProcesoval()
  {
    return $this->belongsTo(ProcesoValCond::class,  'auditable_id','id')->withDefault([
      'id' => '0'
    ]);
  }


}
