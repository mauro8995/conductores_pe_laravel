<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\file_drivers;
use App\Models\External\Record_Driver;
use App\Models\General\Status_driver;
use App\Models\General\Type_document_identy;
use App\Models\Api\Saeg\antecedente;
use App\Models\Api\Saeg\Solicitud_saeg_details;
use App\Models\General\User;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\General\Country;
use App\Models\General\City;
use App\Models\General\State;

use \stdClass;
class User_office extends Model implements Auditable
{

  use \OwenIt\Auditing\Auditable;

  protected $table      = 'user_offices';
  protected $fillable   = ['id_office' , 'first_name','last_name', 'email','dni', 'user','sponsor', 'phone','address','city','state','country','date_birth','id_type_documents', 'created_at','updated_at','status_system','created_by'];


  function getfile()
  {
    return $this->belongsTo(file_drivers::class,  'id','id_user_offices')->withDefault([
      'id' => '0'
    ]);
  }

  function getAntedente()
  {
    return $this->hasMany(antecedente::class , 'id_user_offices','id');
  }
  function getSolicitudAntedentesDetalles()
  {
    return $this->hasMany(Solicitud_saeg_details::class , 'id_office','id_office');
  }

  public function typeDocuments()
  {
    return $this->belongsTo(Type_document_identy::class,         'id_type_documents');
  }

  function getCreate()
  {
    return $this->belongsTo(User::class,  'created_by')->withDefault([
      'id' => '0',
      'username'=>"Indefinido"
    ]);
  }

  function getRecord()
  {
    return $this->hasMany(Record_Driver::class,  'id_user_offices','id');
  }

  public function getCountry()   {
		return $this->belongsTo(Country::class,     'country')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getState()    {
		return $this->belongsTo(State::class,       'state')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getCity()     {
		return $this->belongsTo(City::class,        'city')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}



}
