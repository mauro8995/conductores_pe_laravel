<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\City;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\Status;
use App\Models\Customer\dtCustomerType;
use App\Models\General\Type_document_identy;
use App\Models\External\file_drivers;
use App\Models\External\Record_Driver;
use App\Models\Api\Saeg\antecedente;
use App\Models\Api\Saeg\Solicitud_saeg_details;
use App\Models\General\User;

class Customer extends Model
{
	protected $table = 'customers';
	protected $fillable  =	['id','last_name','first_name','dni','phone','email',
													 'id_country','id_state','id_city','address','admission_date','sponsor_id',
													 'status_user','dni_frontal','dni_back','id_office',
													 'date_birth','id_type_documents','user','created_by','modified_by',
													 'created_at','updated_at','status_system','note'];

	public function getNameAndDni()
	{
	    return $this->first_name . ' ' . $this->lastname;
	}



	public function getCustomer(){
			return $this->hasMany(Ticket::class, 'id');
	}

	//address
	public function getCountry()   {
		return $this->belongsTo(Country::class,     'id_country')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getState()    {
		return $this->belongsTo(State::class,       'id_state')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getCity()     {
		return $this->belongsTo(City::class,        'id_city')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}
	public function getStatus()  {
    return $this->belongsTo(Status::class, 'status_user')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
  }

	public function getDtTypeCustomer()
	{
		return $this->belongsTo(dtCustomerType::class, 'id','id_customer')->withDefault([
			'id' => '0',
			'id_customerType'=>'0',
			'id_customer'=>'0'
		]);
	}

	public function getTypeDocuments()  {
    return $this->belongsTo(Type_document_identy::class, 'id_type_documents')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
  }

	function getfile()
  {
    return $this->belongsTo(file_drivers::class,  'id','id_customer')->withDefault([
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

}
