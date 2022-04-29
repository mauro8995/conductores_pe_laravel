<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\General\User;
use App\Models\External\User_office;
use Illuminate\Support\Facades\DB;

class UserInterno implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        //return User_office::where('id','<>',null)->get();
	DB::update('update "Ps855spol5".proceso_val_cond set approved2 =  (CASE  WHEN approved is null THEN 3 else approved::int end);');
        return view('external.drivers.report.reportGeneral', [
         'pendientes' => DB::select('select u.user, u.created_at,ci.description as city,us.username,u.email,u.phone,u.id_office,td.description ,u.dni ,u.last_name,u.first_name, u.address,'.
	'(select sum(points_firmes) from "Ps855spol5".record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
	'fd.*, '.
	'null as CONTROL_VEHI, '.
	'null as FOTOS_AUTO, '.
	'null as DOCUMENTOS, '.
	'null as FOTO_PERFIL_A, '.
	'null as ANTECEDENTES, '.
	'null as RECORD_CON  '.
  	'from "Ps855spol5".customers as u  '.
	'left join "Ps855spol5".file_drivers as fd on u.id = fd.id_customer '.
	'left join "Ps855spol5".users as us on us.id = u.created_by '.
	'left join "Ps855spol5".city as ci on ci.id = CAST (u.id_city AS INTEGER) '.
  'left join "Ps855spol5".type_document_identies as td on td.id = u.id_type_documents '.
	'where not exists (select pvc.id from "Ps855spol5".proceso_val_cond as pvc where pvc.id_file_drivers = fd.id) ')
	,
	'proceso' => DB::select('select u.user, u.created_at,ci.description as city,us.username,u.email,u.phone,u.id_office,td.description ,u.dni ,u.last_name,u.first_name, u.address,'.
	'(select sum(points_firmes) from "Ps855spol5".record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
	'fd.*, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 1 limit 1 '.
	') as CONTROL_VEHI, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 2 limit 1 '.
	')as FOTOS_AUTO, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 3 limit 1 '.
	') as DOCUMENTOS, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 4 limit 1 '.
	') as FOTO_PERFIL_A, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 5 limit 1 '.
	') as ANTECEDENTES, '.
	'( '.
	'select (approved2)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 6 limit 1 '.
	') as RECORD_CON, '.
	'(select (estatus_proceso)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 6 limit 1 '.
	') as RECORD_CON_VAL, '.
	'(select (estatus_proceso)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 1 limit 1 '.
	') as CONTROL_VEHI_VAL, '.
  '(select (estatus_proceso)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 5 limit 1 '.
	') as ANTECEDENTES_VAL, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 1 limit 1 '.
  ') as DESCRIP_CONTROL_VEHI_VAL, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 2 limit 1 '.
  ') as DESCRIP_FOTOS_AUTO, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 3 limit 1 '.
  ') as DESCRIP_DOCUMENTOS, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 4 limit 1 '.
  ') as DESCRIP_FOTO_PERFIL, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 5 limit 1 '.
  ') as DESCRIP_ANTECEDENTES, '.
  '(select (description)  from "Ps855spol5".proceso_val_cond as pvc3 where pvc3.id_file_drivers = fd.id  and pvc3.id_proceso_validacion = 6 limit 1 '.
  ') as DESCRIP_RECORD_CON '.
	'from "Ps855spol5".customers as u  '.
	'left join "Ps855spol5".file_drivers as fd on u.id = fd.id_customer '.
	'left join "Ps855spol5".users as us on us.id = u.created_by '.
	'left join "Ps855spol5".city as ci on ci.id = CAST (u.id_city AS INTEGER)  '.
  'left join "Ps855spol5".type_document_identies as td on td.id = u.id_type_documents '.
	'where exists (select pvc2.id from "Ps855spol5".proceso_val_cond as pvc2 where pvc2.id_file_drivers = fd.id) '.
	'and not exists(select da2.id from "Ps855spol5".driver_api as da2 where da2.id_file_drivers = fd.id and da2.migrado = true) ') ,

	'migrado' => DB::select('select u.user, u.created_at,ci.description as city,us.username,u.id_office,td.description ,u.email,u.phone,u.dni ,u.last_name,u.first_name, u.address,'.
	'(select sum(points_firmes) from "Ps855spol5".record_driver as rd2 where rd2.id_file_drivers = fd.id) as points, '.
	'fd.*, '.
	'1 as CONTROL_VEHI, '.
	'1 as FOTOS_AUTO, '.
	'1  as DOCUMENTOS, '.
	'1 as FOTO_PERFIL_A, '.
	'1 as ANTECEDENTES, '.
	'1 as RECORD_CON  '.
 	'from "Ps855spol5".customers as u  '.
	'left join "Ps855spol5".file_drivers as fd on u.id = fd.id_customer '.
	'left join "Ps855spol5".users as us on us.id = u.created_by '.
	'left join "Ps855spol5".city as ci on ci.id = CAST (u.id_city AS INTEGER)  '.
  'left join "Ps855spol5".type_document_identies as td on td.id = u.id_type_documents '.
	'where exists (select da.id from "Ps855spol5".driver_api as da where da.id_file_drivers = fd.id and da.migrado = true) ')
     ]);
    }
}
