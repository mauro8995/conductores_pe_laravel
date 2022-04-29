<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\Status_driver;
use App\Models\External\technical_review;
use App\Models\External\DriverApi;
use App\Models\External\ProcesoValCond;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Customer\dtCustomerType;
use App\Models\Customer\Customer;

class file_drivers extends Model implements Auditable
{

  use \OwenIt\Auditing\Auditable;

  protected $table      = 'file_drivers';
  protected $fillable   = ['id_customer' , 'car_interna', 'car_interna2', 'car_externa','car_externa2', 'car_externa3','car_externa4', 'dni_frontal','obs_vehi','dni_back','dni','dnifecemi','dnifecven',
  'licencia','licfecemi','licfecven','placa','revision_tecnica','revfecemi','revfecven','atu','status_atu','atufecemi','atufecven','lic_frontal','lic_back','soat_frontal','soat_back','soatfecemi','soatfecven',
  'tar_veh_frontal','tar_vehfecemi','url_antecedentes','tar_vehfecven','model','marca','year','tar_veh_back','recibo_luz','color_car','num_vin','num_motor','est_car','classcategoria','est_licencia','enterprisesoat','status_user', 'est_soat','type_soat','type_safe' ,'photo_perfil','nro_poliza','created_at','updated_at','status_system'];


  public function getCustomer()
  {
    return $this->belongsTo(Customer::class,     'id_customer')->withDefault([
      'id' => '0'
    ]);
  }

  public function getStatusUser()
  {
    return $this->belongsTo(Status_driver::class,     'status_user')->withDefault([
      'id' => '0',
      'description'=>'Anónimo'
    ]);
  }

  public function getTecnical()
  {
    return $this->belongsTo(technical_review::class,     'id','id_file_drivers')->withDefault([
      'id' => '0'
    ]);
  }
  public function getDriverApi()
  {
    return $this->belongsTo(DriverApi::class,     'id','id_file_drivers')->withDefault([
      'id' => '0'
    ]);
  }

  function getProcess()
  {
    return $this->hasMany(ProcesoValCond::class , 'id_file_drivers','id');
  }

}
