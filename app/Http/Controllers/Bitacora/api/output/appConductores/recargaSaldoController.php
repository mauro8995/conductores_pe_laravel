<?php

namespace App\Http\Controllers\api\output\appConductores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\External\DriverApi;
use App\Models\Driver\recarga_driver;
use App\Models\External\file_drivers;
use App\Models\General\Type_money;
 use App\Models\General\banks;
use App\Models\External\User_office;
use App\Models\Customer\Customer;
class recargaSaldoController extends Controller
{
    function restarSaldo(Request $request)
    {
      //return $this->insertMoney();
      $validator = Validator::make($request->all(),[
        'id_driver' => 'required|exists:driver_api,driverid',
        'amount' => 'required|numeric',
        'type_money' => 'required|string|max:3|min:3|exists:type_moneys,ISO_3',
        ]);
        if ($validator->fails()) {
          return response()->json([  "object"   => "error",
          'errors' => $validator->errors()]);
        }

          $d = DriverApi::where('driverid',$request{'id_driver'})->first();

          $p = new recarga_driver();
          $p->id_driver_api = $d->id;
          $p->money = $request{'type_money'};
          $p->amount = $request{'amount'};
          $saldo = $d->saldo - $request{'amount'};
          $salmin = 7;
          if($d->saldo <= $salmin)
          {
            return response()->json([  "object"   => "error",
             'errors' => "the minimum balance is ".$salmin]);
          }else {
            if($d->saldo >= $request{'amount'})
            {

              $d->saldo = $d->saldo - $request{'amount'};
            }else {
               return response()->json([  "object"   => "error",
                'errors' => "insufficient balance"]);
            }
          }


          $p->save();
          $d->save();
          return response()->json([
              "object"   => "success",
              "data"  => [
                "menssage" =>"recharging done.",
                "saldo" =>$d->saldo,
              ]
          ]);

    }
    function getSaldo(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'id_driver' => 'required|exists:driver_api,driverid'
        ]);
        if ($validator->fails()) {
          return response()->json([  "object"   => "error",
          'errors' => $validator->errors()]);
        }

        $d = DriverApi::where('driverid',$request{'id_driver'})->first();
        return response()->json([
            "object"   => "success",
            "data"  => [
              "saldo" =>$d->saldo
            ]
        ]);
    }

    function showApp()
    {
        return view('external.app.infoRecarga');
    }

    function getBanck()
    {
      $b =banks::all();
         return response()->json([
              "object"   => "success",
              "data"  => $b
          ]);
    }

    function getDriver(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'id_conductor' => 'required|exists:customers,id_office',
        ]);
        if ($validator->fails()) {
          return response()->json([  "object"   => "error",
          'errors' => $validator->errors()]);
        }



        $dri = Customer::where('id_office',$request->id_conductor)->first();
        $file =$dri->getfile;
        $da = $file->getDriverApi;
        return response()->json([
            "object"   => "success",
            "data"  =>
            [
              "driver"=>$dri,
              "saldo" =>$da
            ]
        ]);
    }

    function insertMoney()
    {
      $t = new Type_money();
      $t->id_country = 174;
      $t->ISO_3 = "PEN";
      $t->save();
    }
}
