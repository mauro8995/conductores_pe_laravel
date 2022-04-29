<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/test','api\reniec\reniecController@reniec');
Route::get('/generateExcel', 'api\driver\driverController@getGenerateExcel');



//ingresar customer -----------------------------------------------------------------
Route::get('/denied','api\reniec\reniecController@denied');// no borrar
Route::group(['middleware' => 'keyapi'], function () {
//api freshdesk
Route::post('/insert/freshdesk', 'api\output\RegisterAtencion\RegisterAtencionController@create');

Route::put('/insert/servicedesk', 'api\output\RegisterAtencion\RegisterAtencionController@store');
Route::put('/reply/servicedesk', 'api\output\RegisterAtencion\RegisterAtencionController@reply');


  Route::put('/saeg/insert/background','api\Saeg\saegController@insertDataAntecedente');
    Route::post('/custumer/peru/get', 'api\reniec\reniecController@customerPeruApi');
    Route::post('/custumer/update', 'Customer\ApiCustomerController@updateCustomerApi');
    Route::post('/freshdesk/support', 'api\freshdesk\freshdeskController@createTicketAPI');
    Route::post('/driver/sendcorreo', 'api\msm\msmController@enviarCorreo');
    //obtener vehículo
    Route::post('/vehicle/peru/get', 'api\MTC\MtcController@getVehiculoApi');

    //obtener la evaluacionFinal
    Route::post('/evaluar/final', 'validate\validateController@evaluacionFinal');

    //rutas para purevas
    Route::get('/inserttype','api\reniec\reniecController@type');


    Route::post('/get/user','api\OficinaVirtual\OffiViController@getOfficine');

    //----------------------------------------------------SAEG
    Route::post('/test/credenciales','api\Saeg\saegController@testGet');

    //----------------------------------------------------SAEG
    //api con el aplicativo
    Route::put('/driver/purse/subtract','api\output\appConductores\recargaSaldoController@restarSaldo');

    Route::get('/driver/get/saldo','api\output\appConductores\recargaSaldoController@getSaldo');

    //obtener Conductores
    Route::get('/driver/getDriverNrodoc','Customer\ApiCustomerController@getDriverNrodoc');
    Route::post('/Drivers/getDriver',     'api\driver\driverController@getDriverID');
    Route::get('/getTypeDocumentID',     'api\driver\driverController@getTypeDocumentID');
    Route::post('/Drivers/driver_get',    'api\driver\driverController@get_driver');
    Route::post('/Drivers/get_driverAPP', 'api\driver\driverController@get_driverAPP');

    //emergencia conductor
    Route::put('/driver/emergencyapp',       'api\driver\driverController@emergency_app');

    //ganancias ov user  
    Route::get('/getWinningsUser',    'api\OficinaVirtual\OffiViController@getWinningsUser');
});
