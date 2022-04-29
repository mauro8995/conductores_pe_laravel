<?php

namespace App\Http\Controllers\api\Saeg;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Api\Saeg\antecedente;
use App\Models\Api\Saeg\antecedente_detail;
use App\Models\Api\Saeg\Type_antecedente;
use App\Models\Api\Saeg\Type_reference;
use App\Models\External\User_office;
use \stdClass;
use \PDF;
class saegController extends Controller
{
    //
    public function testGet()
    {
      return response()->json([
        'object'=>"success",
        "menssage" => "conección correcta"
      ]);
    }

    function getDataList()
    {
      $u =  User_office::where("id",'<>',null)->get();
      $b = [];
      foreach ($u as $key => $value) {
         $aa = $value->getAntedente()->get();
         $bb = $value->getSolicitudAntedentesDetalles()->first();
         $canti = count($aa);
          if($canti != 0)
          {
            $cc = 1;
          }else $cc = 0;
          $c =
          [
            "id" => $value->id,
            "dni" => $value->dni,
            "id_office"=> $value->id_office,
            "first_name"=> $value->first_name,
            "last_name"=> $value->last_name,
            "phone"=> $value->phone,
            "email"=> $value->email,
            "antecedentes"=> $cc,
            "status"=>$bb
          ];
          array_push($b, $c);
      }
      return response()->json([
        'object'=>"success",
        "data" =>$b
      ]);
    }

    function insertDataAntecedente()
    {
      // return $this->insertTypeAntecedente();
      //
      //
      //
      //
      if(User_office::where('dni',request(){'fuentes'}[0]{'informacion'}{'DNI'})->exists())
      $u = User_office::where('dni',request(){'fuentes'}[0]{'informacion'}{'DNI'})->first();
      else return response()->json([
        'object'=>"error",
        "menssage" =>"El dni no esta registrado."
      ]);
      // return request(){'fuentes'}[0]{'informacion'}{'DNI'};
      $antede = new antecedente();
      $antede->description = "test 2";
      $antede->id_user_offices = $u->id;
       $antede->save();
      // $variable = [1,2];
      foreach (request(){'tiposAntecedente'} as $key => $value) {
        if($value{'nombre'}  == "Antecedente")
        {
          $id_type_references = 1;
        }else {
          $id_type_references = 2;
        }
        foreach ($value{'tiposReferencia'} as $key_ => $value_) {
          //return $id_type_references;
          if($value_{'nombre'} == "ANTECEDENTES POLICIALES")
          {
            $id_type_reference = 1;
          }elseif ($value_{'nombre'} == "REQUISITORIAS (RQ)") {
            $id_type_reference = 2;
          }elseif ($value_{'nombre'} == "ANTECEDENTE POR TERRORISMO") {
            $id_type_reference = 3;
          }elseif ($value_{'nombre'} == "ANTECEDENTE POR TRÁFICO ILÍCITO DE DROGAS") {
            $id_type_reference = 4;
          }elseif ($value_{'nombre'} == "ANTECEDENTES PENALES") {
            $id_type_reference = 5;
          }elseif ($value_{'nombre'} == "DENUNCIAS POLICIALES (COMISARÍA)") {
            $id_type_reference = 6;
          }elseif ($value_{'nombre'} == "DETENCIONES POLICIALES (RENADESPPLE)") {
            $id_type_reference = 7;
          }elseif ($value_{'nombre'} == "DENUNCIAS ANTE EL MINISTERIO PÚBLICO - FISCALÍA")   {
            $id_type_reference = 8;
          }else {
            $id_type_reference = 9;
          }
          //return $id_type_reference;
          foreach ($value_{'informacion'} as $key_2 => $value_2) {
            $a = new antecedente_detail();
            $a->id_antecedente = $antede->id;
            $a->id_type_reference = $id_type_reference;
            $a->id_type_antecedente = $id_type_references;
            $a->crime = $value_2{'delito'};
            $a->dependence = $value_2{'dependencia'};
            $a->number_office = $value_2{'nroOficio'};
            $a->date_register = $value_2{'fechaIngresoReferencia'};
            $a->situation = $value_2{'situacion'};
            $a->part = $value_2{'parte'};
            $a->observation = $value_2{'observacion'};
            $a->save();
          }

        }

      }

      return response()->json([
        'object'=>"success",
        "data" =>"Datos Ingresados."
      ]);

    }

    function insertTypeAntecedente()
    {
      $antede = new Type_antecedente();
      $antede->description = "ANTECEDENTES POLICIALES";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "REQUISITORIAS (RQ)";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "ANTECEDENTE POR TERRORISMO";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "ANTECEDENTE POR TRÁFICO ILÍCITO DE DROGAS";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "ANTECEDENTES PENALES";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "DENUNCIAS POLICIALES (COMISARÍA)";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "DETENCIONES POLICIALES (RENADESPPLE)";
      $antede->save();

      $antede = new Type_antecedente();
      $antede->description = "DENUNCIAS ANTE EL MINISTERIO PÚBLICO - FISCALÍA";
      $antede->save();
      //
      $antede = new Type_antecedente();
      $antede->description = "ANTECEDENTES JUDICIALES";
      $antede->save();

      $antede = new Type_reference();
      $antede->description = "ANTECEDENTE";
      $antede->save();

      $antede = new Type_reference();
      $antede->description = "DENUNCIAS";
      $antede->save();


    }

    function pdfAntecedentes()
    {
      $u =  antecedente::where("id_user_offices",Request()->id)->get();

      $pdf = PDF::loadView('external.drivers.saeg.reportAntecedentes',compact(
        'u'
      ))->setPaper('a4', 'landscape');
      // $pdf->output();
      // $dom_pdf = $pdf->getDomPDF();
      //
      // $canvas = $dom_pdf->get_canvas();
      // $canvas->page_text(11, 11, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      // $canvas->page_text(522, 770, "Page {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(.5,.5,.5));
      return $pdf->stream('reporteAntecedentes.pdf');
    }

}
