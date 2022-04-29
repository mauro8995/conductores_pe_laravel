<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class vw_user_offices extends Model
{
  protected $table = 'vw_user_offices';

  protected $fillable  =
  [
    'id',
    'id_office',
    'first_name',
    'last_name',
    'email',
    'dni',
    'user',
    'phone',
    'city',
    'country',
    'placa',
    'marca',
    'model',
    'created_by',
    'created_at',
    'username',
    'id_file_driver',
    'form_status'
  ];



}
