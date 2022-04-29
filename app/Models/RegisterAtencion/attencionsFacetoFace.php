<?php

namespace App\Models\RegisterAtencion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\Customer;
use App\Models\General\TypeRequirements;
use App\Models\Customer\CustomerType;
use App\Models\General\StatusT;
use App\User;

class attencionsFacetoFace extends Model
{
  protected $table = 'attencions_faceto_faces';
  protected $fillable  =	['id','id_customer','id_type_requirements','nro_ticket','id_type_customer','date_attencions','date_resolve_attencions','asignated_to','nro_modulo','id_status_att','created_by', 'modified_by','created_at',
  'updated_at','status_system'];

  public function getCustomer() {
    return $this->belongsTo(Customer::class, 'id_customer')->withDefault([
      'id' => '0',
        'last_name' => 'Anónimo',
        'first_name' => 'Anónimo',
        'dni' => '0',
    ]);
  }

  public function getTypeRequirements()  {
    return $this->belongsTo(TypeRequirements::class, 'id_type_requirements')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getCustomerType()   {
		return $this->belongsTo(CustomerType::class, 'id_type_customer')->withDefault([
			'id' => '0',
			'description'=>'Anónimo'
		]);
	}

  public function getStatusT()  {
    return $this->belongsTo(StatusT::class, 'id_status_att')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getAssigned() {
    return $this->belongsTo(User::class,  'asignated_to')->withDefault([
        'name' => '--', 'lastname' => '--'
          ]);
  }

}
