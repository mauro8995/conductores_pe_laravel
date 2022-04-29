<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class code_email extends Model
{
  protected $table      = 'code_emails';
  protected $fillable   = ['code_generate' , 'token', 'use', 'description', 'created_at', 'updated_at'];
  public    $timestamps = true;
}
