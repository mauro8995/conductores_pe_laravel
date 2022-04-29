<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\General\Country;
use App\Models\General\Rol_User;
use App\Models\General\Roles;
use App\Models\External\User_office;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Model  implements Auditable
{
	use \OwenIt\Auditing\Auditable;

	protected $table      = 'users';
	protected $fillable   = ['name' , 'lastname','dni',	'address' , 'phone','email',
							   					'gender' , 'birthdate','username',	'password' ,'id_country','api_key','agent_id','status_disp','nro_modulo','note','created_at',
							   				 	'updated_at','modified_by', 'status_system', 'status_user'];

	public function getCountry()    {
		return $this->belongsTo(Country::class,       'id_country');
	}

	public function getModifyBy() {
    return $this->belongsTo(User::class,         'modified_by');
  }
	
	public function getRoles()  {
    return $this->hasManyThrough(Roles::class, Rol_User::class, 'id_user', 'id', 'id', 'id_role');
  }
	public function getSaldo()  {
		return $this->belongsTo(Driver_Saldo::class,         'modified_by');
	}
	public function user_order(){
			return $this->hasMany(Order::class, 'id');
	}

	function getOfficesUser()
  {
    return $this->hasMany(User_office::class ,'created_by');
  }

}
