<?php

namespace App\Models\RegisterAtencion;

use Illuminate\Database\Eloquent\Model;

class Timeregisters extends Model
{
  protected $table = 'timeregisters';
  protected $fillable  =	['id','id_att_face','id_reg_att','dt_create_module_attention','dt_attended_module_attention','dt_finished_module_attention','module_agent_id','dt_create_ticket_attention','dt_attended_ticket_attention','dt_finished_ticket_attention','ticket_agent_id', 'created_by', 'modified_by','created_at','updated_at','status_system'];
}
