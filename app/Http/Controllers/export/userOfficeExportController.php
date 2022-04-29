<?php

namespace App\Http\Controllers\export;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;

class userOfficeExportController extends Controller
{
    //

    function listShow()
    {
      $main = new MainClass();
      $main = $main->getMain();
      $rolid = 10;
      return view('importar.importarUsuarioOffice',compact('rolid','main'));
    }
    public function import(Request $request)
    {

      return response()->json([
        "objet"=> "df"
      ]);
        // $request->validate([
        //     'ufile' => 'required|mimes:xls,xlsx'
        // ]);
        //
        // $path = $request->file('ufile')->getRealPath();
        // $data = Excel::load($path)->get();
        // Log::info($data);
        // try {
        //    if ($data->count()) {
        //
        //     }
        //     return $data->count();
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     throw new HttpException(500, 'Sucedio un error importando la información favor intentar de nuevo');
        // }
    }

}
