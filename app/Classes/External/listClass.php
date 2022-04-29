<?php

namespace App\Classes\External;
use Illuminate\Support\Facades\DB;

class listClass
{
  public function getAllDrivers($where = ';',$pendiente = true,$proceso = true,$migrado = true)
  {


    if($pendiente)
    {
      $p = DB::select('select u.user, u.created_at,us.username,u.email,u.phone,u.id_office,u.dni,u.last_name,u.first_name, '.
    //'(select sum(points_firmes) from Ps855spol5.record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
    'null as CONTROL_VEHI, '.
    'null as FOTOS_AUTO, '.
    'null as DOCUMENTOS, '.
    'null as FOTO_PERFIL, '.
    'null as ANTECEDENTES, '.
    'null as RECORD_CON,  '.
    'fd.* '.
    'from Ps855spol5.customers as u  '.
    'left join Ps855spol5.file_drivers as fd on u.id = fd.id_customer '.
    'left join Ps855spol5.users as us on us.id = u.created_by '.
    'where not exists (select pvc.id from Ps855spol5.proceso_val_cond as pvc where pvc.id_file_drivers = fd.id) limit 100'.$where);
    }
    else
    {
      $p = [];
    }

    if($proceso)
    {
      $pro = DB::select('select u.user, u.created_at,us.username,u.id_office,u.email,u.phone,u.dni as dni,u.last_name,u.first_name, '.
      //'(select sum(points_firmes) from Ps855spol5.record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
      'fd.*, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 1 limit 1 '.
      ') as CONTROL_VEHI, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 2 limit 1 '.
      ')as FOTOS_AUTO, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 3 limit 1 '.
      ') as DOCUMENTOS, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 4 limit 1 '.
      ') as FOTO_PERFIL, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 5 limit 1 '.
      ') as ANTECEDENTES, '.
      '( '.
      'select (approved2)  from Ps855spol5.proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 6 limit 1 '.
      ') as RECORD_CON '.
      // '(select (estatus2)  from Ps855spol5.process_trace as pt3 where pt3.id_file_drivers = fd.id  and pt3.id_process_model = 6 limit 1 '.
      // ') as RECORD_CON_VAL, '.
      // '(select (estatus2)  from Ps855spol5.process_trace as pt3 where pt3.id_file_drivers = fd.id  and pt3.id_process_model = 1 limit 1 '.
      // ') as CONTROL_VEHI_VAL '.
      'from Ps855spol5.customers as u  '.
      'left join Ps855spol5.file_drivers as fd on u.id = fd.id_customer '.
      'left join Ps855spol5.users as us on us.id = u.created_by '.
      'where exists (select pvc2.id from Ps855spol5.proceso_val_cond as pvc2 where pvc2.id_file_drivers = fd.id) '.
      'and not exists(select da2.id from Ps855spol5.driver_api as da2 where da2.id_file_drivers = fd.id and da2.migrado = true) limit 100' .$where);
    }else {
      $pro = [];
    }

    if($migrado)
    {
      $mi = DB::select('select u.user, u.created_at,us.username,u.id_office,u.email,u.phone,u.dni,u.last_name,u.first_name, '.
      //'(select sum(points_firmes) from Ps855spol5.record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
      '1 as CONTROL_VEHI, '.
      '1 as FOTOS_AUTO, '.
      '1  as DOCUMENTOS, '.
      '1 as FOTO_PERFIL, '.
      '1 as ANTECEDENTES, '.
      '1 as RECORD_CON,  '.
      'fd.* '.
      'from Ps855spol5.customers as u  '.
      'left join Ps855spol5.file_drivers as fd on u.id = fd.id_customer '.
      'left join Ps855spol5.users as us on us.id = u.created_by '.
      'where exists (select da.id from Ps855spol5.driver_api as da where da.id_file_drivers = fd.id and da.migrado = true) limit 100'.$where);
    }
    else {
      $mi = [];
    }


    return [
  'pendientes' => $p,
  'proceso' => $pro,
  'migrado' => $mi
  ];
  }
}
