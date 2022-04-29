<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class ManagementChannel extends Model
{
  protected $table      = 'management_channels';
  protected $fillable   = ['description','modified_by', 'created_by' ,'created_at', 'updated_at','status_system'];
  public    $timestamps = true;
}
