<?php
  Route::get('/', function(){ return view('errors/mantenimiento'); });//'api\driver\driverController@created');
  Route::get('/mantenimientos', function(){ return view('errors/mantenimiento'); }); 
  Route::get('/acceder',  'Auth\LoginController@showLoginForm');
	Route::get('/home',     'Auth\LoginController@home')->name('home');
	Route::post('login',    'Auth\LoginController@login' )->name('login');
	Route::post('logout',   'Auth\LoginController@logout')->name('logout');
	Route::post('/red/valiteUsuario',   'Red\RedController@valitedUser');
	Route::post('/red/valitedDNI',   'Red\RedController@valitedDNI');
	Route::post('/customer/get',   'Customer\CustomerController@getCustomer');
	Route::post('/driver/externo/validarProceso',   'Driver\ControllerDriver@validarProceso');
	Route::post('/users/exeterno/id/validate', 	'Driver\Externo\ExternalDriverController@getUsersvalidate');
	Route::get('/driver/externo/rtpdf/{id}', 	'Driver\Externo\ExternalDriverController@checkpdf');
	Route::get('/driver/externo/rtpdf2/{id}', 	'Driver\Externo\ExternalDriverController@checkpdf2');
	Route::get('/conductores/oficina',   'Driver\Externo\ExternalDriverController@userOffices');
	Route::post('/conductores/oficinaRegister',   'Driver\Externo\ExternalDriverController@userOfficesRegister');
  Route::get('logs-data', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

	Route::post('/driver/externo/confir/email/new',         			        'Driver\Externo\validateContacController@genererateCodeEmail');
	Route::post('/driver/externo/confir/email/confirm',         			    'Driver\Externo\validateContacController@confirmEmail');
	Route::post('/driver/externo/confir/phone/new',         			        'Driver\Externo\validateContacController@genererateCodePhone');
	Route::post('/driver/externo/confir/phone/confirm',         			    'Driver\Externo\validateContacController@confirmPhone');
	Route::post('/users/update/driver/validate',         			    'Driver\Externo\validateContacController@saveConfirm');
  Route::post('/driver/externo/id/validate', 				     'Driver\Externo\validateContacController@getUsersvalidateext');
	Route::get('/actualizardatoscontacto',  'Driver\Externo\validateContacController@viewConfimation');

	Route::post('/driver/externo/phoneval', 	'Driver\Externo\validateContacController@validatephone');
	Route::post('/driver/externo/emailval', 	'Driver\Externo\validateContacController@validateemail');
	//Reclamaciones
	Route::get('/reclamaciones/register', 'api\freshdesk\freshdeskController@index');
	Route::post('/reclamaciones/create', 'api\freshdesk\freshdeskController@createTicket_file');




	//registro app
  Route::get('/registerapp',  'api\driver\driverController@createdapp');

  //app

  Route::get('/recargando/saldo', 'api\output\appConductores\recargaSaldoController@showApp');
  Route::post('/recargando/saldo/get/driver', 'api\output\appConductores\recargaSaldoController@getDriver');

  Route::post('/recargando/saldo/get/banks', 'api\output\appConductores\recargaSaldoController@getBanck');


  //REGISTRO CONDUCTOR LINK EXTERNO
	Route::get('/quieroserconductor',  'api\driver\driverController@created');
  Route::post('/validateoffice', 		 'api\driver\driverController@validateoffice');
	Route::post('/reniecValidate',     'api\reniec\reniecController@reniecPeruValidate');
	Route::post('/validatedni', 			 'api\driver\driverController@validatedni');
	Route::post('/validateexitsplaca', 'api\driver\driverController@validateplacaexi');
	Route::post('/validateplaca', 		 'api\driver\driverController@validateplaca');
	Route::post('/validateexitslicence', 'api\driver\driverController@validatelicenceexi');
	Route::post('/validatelicence', 		 'api\driver\driverController@validatelicencia');
	Route::post('/registerdriver', 		   'api\driver\driverController@userOfficesRegister');
  Route::post('/driverfileSave', 			 'api\driver\driverController@filesaves');
	Route::get('/terminosycondiciones/{email}', 'api\driver\driverController@aceptoterminosycondiciones');
  Route::post('/validateuserphoneemail', 		 'api\driver\driverController@validateuserphoneemail');
Route::get('/test/validarmigracionapp',  'Test\TestController@sendemail');

	Route::group(['middleware' => 'auth'], function(){
	//testDB
	Route::get('/test/update/licence',  'Test\TestController@actualizarLicencia');
	Route::get('/test/sms/voz',  'Test\TestController@mensajeForVoz');
	Route::get('/export/office/excel',  'Test\TestController@excelReportUser');
	Route::get('/test/update/repetidos',  'Test\TestController@actulizarRepetidos');
	Route::get('/test/update/record',  'Test\TestController@eliminarRecort');
	Route::get('/test/update/tecnicalreview',  'Test\TestController@actualizarRevTec');
	Route::get('/test/update/sendemail/{number}/{turn}',  'Test\TestController@sendmsm');
	Route::get('/test/updateprocess',  'Test\TestController@updateproceso');
  Route::get('/test/sendemail/{id}',  'Test\TestController@sendemail');
	Route::get('/test/validaremails',  'Test\TestController@validarcorreo');
	Route::get('/test/validaremail/{id}',  'Test\TestController@validarcorreo');
	Route::get('/test/validartelefono/{id}',  'Test\TestController@validartelefono');
  Route::get('/test/validarnuevoemail/{id}',  'Test\TestController@validarnuevocorreo');
	Route::get('/test/validarnuevotelefono/{id}',  'Test\TestController@validarnuevotelefono');
        Route::get('/test/generateovaccesos',  'Test\TestController@generateovaccesos');



  Route::get('/actualizaraplicacionconductor/{idoffice}', 'Driver\ControllerDriverApp@updateDatass');

	//importar
	Route::get('/list/office',  'export\userOfficeExportController@listShow');
	Route::post('/list/import/data/office', 'export\userOfficeExportController@listShow');

    //antecendete policiales
    Route::get('/driver/antecendetes-policiales/{dni}',  'api\policiales\poicialesController@getAntecedentes');

	//DRIVER
	Route::get('/drivers/create',         			  					 			   'Driver\ControllerDriver@createDriverView'       );
	Route::post('/customer/register/driver/get',         			  					 			   'Driver\ControllerDriver@getCustomer'       );
	Route::post('/customer/register/driver/store',         			  					 			   'Driver\ControllerDriver@createDriver'       );
	Route::post('/customer/register/driver/get/nationality',         			  					 			   'Driver\ControllerDriver@getnationality'       );
	Route::get('/drivers',         			  					 			   'Driver\ControllerDriver@index'       )->name('driver.index');
	Route::get('/drivers/{driver}', 								 			   'Driver\ControllerDriver@show'        )->name('driver.show' );
	Route::post('/drivers',         								 			   'Driver\ControllerDriver@store'       );
	Route::post('/vehicle',         								 			   'Driver\ControllerDriver@storeVehicle');
	Route::get('/drivers/{driver}/edit',  					 			   'Driver\ControllerDriver@edit'        )->name('driver.edit' );
	Route::put('/drivers/{driver}',       					 			   'Driver\ControllerDriver@update'      );
	Route::get ('/MTCencript',         			             		'api\MTC\MtcController@index'       );
	Route::post('/apiSoatPlaca',         			             	'api\MTC\MtcController@apiSoatPlaca');
	Route::get('/conductores/sponsor',         			        'Driver\Externo\ExternalDriverController@sponsorview');
  Route::post('/users/externo/updateSponsorDriver',       'Driver\Externo\ExternalDriverController@sponsorupdatedriver');
	Route::get('/conductores/idofficev',         			      'Driver\Externo\ExternalDriverController@idofficeview');
	Route::post('/users/externo/updateidofficeDriver',      'Driver\Externo\ExternalDriverController@idofficeupdatedriver');
	Route::get('/driver/changevehicle', 										'Driver\Externo\ExternalDriverController@changevehicle');
  Route::post('/driver/updateauto', 											'Driver\Externo\ExternalDriverController@updateauto');
	Route::post('/customer/register/driver/getVal',         'Driver\ControllerDriver@getCustomerValidate');


	Route::get('/conductores',   'Driver\Externo\ExternalDriverController@index');
	Route::get('/conductores/agenda',   'Driver\Externo\ExternalDriverController@schedule');
	Route::get('/conductores/agendachecklist',   'Driver\Externo\ExternalDriverController@schedulechecklist');
	Route::get('/conductores/documentos',   'Driver\Externo\ExternalDriverController@docs');
	Route::post('/conductores/documentos/validate/get/dni',   'Driver\Externo\ExternalDriverController@getDNIVaidar');
	Route::post('/conductores/documentos/validate/save/dni',   'Driver\Externo\ExternalDriverController@updateDni');
	Route::get('/conductores/perfil',   'Driver\Externo\ExternalDriverController@perfil');
	Route::get('/conductores/perfil2',   'Driver\Externo\ExternalDriverController@perfil2');
	Route::get('/conductores/technicalreview',   'Driver\Externo\ExternalDriverController@technicalreview');
	Route::post('/users/exeterno/id/validate', 	'Driver\Externo\ExternalDriverController@getUsersvalidate');
	Route::post('/users/exeterno/id/validateOffice', 	'Driver\Externo\ExternalDriverController@getUsersvalidateOffice');
	Route::get('/conductores/technicalreview2',   'Driver\Externo\ExternalDriverController@technicalreview2');
	Route::post('/users/exeterno/id/validateUserOffice', 	'Driver\Externo\ExternalDriverController@getUserofficesvalidate');
	Route::post('/users/exeterno/id/validateUser', 	'Driver\Externo\ExternalDriverController@getUservalidate');
	Route::post('/users/externo/savetechnicalreview', 	'Driver\Externo\ExternalDriverController@storetechnicalreview');
	Route::post('/users/externo/savetechnicalreview2', 	'Driver\Externo\ExternalDriverController@storetechnicalreview2');
	Route::post('/users/externo/savetechnicalreview3', 	'Driver\Externo\ExternalDriverController@storetechnicalreview3');
	Route::get('/users/reportaudits', 	'Driver\Externo\ExternalDriverController@auditoriaview');

	//USUARIO
	Route::get ('/users',         			             			   'User\UserController@index'           )->name('user.index');
	Route::get ('/user/add',         	               			   'User\UserController@create'          )->name('user.create');
	Route::post('/usernew',         	               			   'User\UserController@store'           );
	Route::match(['get', 'post'],'/usersAll',        			   'User\UserController@usersAll'        );
	Route::match(['get', 'post'],'/userDetails',     			   'User\UserController@userDetails'     );
	Route::match(['get', 'post'],'/user/rolDetails',         'User\UserController@rolDetails'      );
	Route::match(['get', 'post'],'/user/rolDetailsSelect',   'User\UserController@rolDetailsSelect');
	Route::match(['get', 'post'],'/user/updateRolUser',      'User\UserController@updateRolUser'   );
	Route::match(['get', 'post'],'/user/validUser',          'User\UserController@validUser'       );
	Route::match(['get', 'post'],'/user/updatePassword',     'User\UserController@updatePassword'  );
	Route::match(['get', 'post'],'/user/updateStatus',       'User\UserController@updateStatus'    );
	Route::match(['get', 'post'],'/user/validUserDni',       'User\UserController@validUser'       );
	Route::match(['get', 'post'],'/user/PermisosDetails',    'User\UserController@PermisosDetails' );
	Route::match(['get', 'post'],'/user/updatePermisoUser',      'User\UserController@updatePermisoUser'   );

	//atencion
	Route::get('/atencion/register',  'AtencionCliente\AtencionClienteController@index');
	Route::get('/atencion/listRegister',  'AtencionCliente\AtencionClienteController@listRegister');
	Route::get('/atencion/registerservice/{id}',  'AtencionCliente\AtencionClienteController@registerservice');
	Route::post('/atencion/store',  'AtencionCliente\AtencionClienteController@store');
	Route::get('/atencion/getDataregister',  'AtencionCliente\AtencionClienteController@allservice');
	Route::get('/freshdesk/listgroups',  'api\freshdesk\freshdeskController@getGrupos');
	Route::get('atencion/tickets/download/{id}',  'AtencionCliente\AtencionClienteController@dowloadserviceticket');
	Route::get('/atencion/notifications', 	'AtencionCliente\AtencionClienteController@notificationsview');
	Route::get('/atencion/notificationsget', 	'AtencionCliente\AtencionClienteController@getNotifications');
	Route::get('atencion/tickets/views/{idt}/{id}', 				'AtencionCliente\AtencionClienteController@getTicketDetails');
	Route::get('/tickets/answer', 				'api\freshdesk\freshdeskController@agregarrespuesta');
	Route::get('/getTicketsbyid', 				'api\freshdesk\freshdeskController@getTicketsbyid');
	Route::post('/atencion/freshdesk/reply',  'AtencionCliente\AtencionClienteController@reply');
	Route::post('/atencion/getCategoryForType',  'AtencionCliente\AtencionClienteController@getCategoryForTypes');
	Route::post('/atencion/getDescCategory',  'AtencionCliente\AtencionClienteController@getCategoryDesc');
	Route::get('/atencion/sumarhoras',  'AtencionCliente\AtencionClienteController@sumarhoras');
	Route::get('/atencion/updateTicket/{status}/{id_ticket}',  'AtencionCliente\AtencionClienteController@updateTicket');
	Route::post('/atencion/freshdesk/update',  'AtencionCliente\AtencionClienteController@updateRegTick');
	Route::get('/getReniecApi3',  'Driver\ControllerDriver@getReniecApi3');
	Route::post('/atencion/freshdesk/GetAgentsByGroupID',  'AtencionCliente\AtencionClienteController@GetAgentsByGroupID');
	Route::post('/atencion/freshdesk/replyNote',  'AtencionCliente\AtencionClienteController@replyNote');
	Route::get('/atencion/search/{id}/{key}',  'AtencionCliente\AtencionClienteController@searchsubject');


	//reportatencion
	Route::get('/report/servicedesk',  'Report\ReportServicedeskController@reportView');
	Route::get('/report/GetReportGeneral',  'Report\ReportServicedeskController@GetReportGeneral');
	Route::get('/report/servicedeskemergency',  'Report\ReportServicedeskController@servicedeskemergency');
	Route::get('/report/GetReportemergency',  'Report\ReportServicedeskController@GetReportemergency');
	Route::get('/report/servicedeskgeneral',  'Report\ReportServicedeskController@servicedeskgeneral');
	Route::get('/report/GetReportRequirements',  'Report\ReportServicedeskController@GetReportRequirements');
	Route::get('/report/getResolutionTickets',  'Report\ReportServicedeskController@getResolutionTickets');


/////////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/capitalDriver/index',                         'CapitalDriver\CapitalDriverController@index'      );//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/indexApp',                      'CapitalDriver\CapitalDriverController@indexApp'      );//Correcta: Super Admin - Sistemas - Finanzas

	Route::get('/capitalDriver/recargarLote',                  'CapitalDriver\CapitalDriverController@indexLote'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/pendients',                     'CapitalDriver\CapitalDriverController@indexPendients'  );//Correcta: Super Admin - Sistemas - Finanzas

	Route::get('/capitalDriver/edit',                          'CapitalDriver\CapitalDriverController@edit'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'], '/capitalDriver/updateRecarga','CapitalDriver\CapitalDriverController@updateRecarga');//Correcta: Super Admin - Sistemas

	Route::get('/capitalDriver/create',                         'CapitalDriver\CapitalDriverController@create'     )->name('capitaldriver.create');//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/getDriver',                      'CapitalDriver\CapitalDriverController@getDriver'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::post('/capitalDriver/addSaldo',          			      'CapitalDriver\CapitalDriverController@addSaldo'   );
	Route::get('/capitalDriver/getRecargas',                    'CapitalDriver\CapitalDriverController@getRecargas');      //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/getRecargasApp',                 'CapitalDriver\CapitalDriverController@getRecargasApp');      //Correcta: Super Admin - Sistemas - Finanzas

	Route::match(['get', 'post'], '/capitalDriver/updateStatus','CapitalDriver\CapitalDriverController@updateStatus');//Correcta: Super Admin - Sistemas
	Route::match(['get', 'post'],'/capitalDriver/recargando',   'CapitalDriver\CapitalDriverController@recargando'   );//Correcta: Super Admin - Sistemas - Finanzas

	Route::post('/capitalDriver/validaNumber',          'CapitalDriver\CapitalDriverController@validaNumber'   );
	Route::post('/capitalDriver/validaDni',            	'CapitalDriver\CapitalDriverController@validaDni'   );

	//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------driver pay
	Route::get('/cobranza/pay/{id}','Cobranza\PayDriverController@viewPay');
	Route::post('/cobranza/career','Cobranza\PayDriverController@career');
	Route::post('/cobranza/cereer/save','Cobranza\PayDriverController@saveOrder');

	Route::get('/cobranza/pay','Cobranza\PayDriverController@viewPayBlock');
	Route::post('/cobranza/career/blocks','Cobranza\PayDriverController@driverPending');
	//----------------------------------------------------------------------------------

	//CUSTOMER
	Route::get ('/customers', 										          'Customer\CustomerController@index' )->name('customer.index');     //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/admin/customers', 						              'Customer\CustomerController@index' )->name('customers');			     //Correcta: Administracion
	Route::get('/atencion/customers', 						          'Customer\CustomerController@index' )->name('customers');          //Correcta: Soporte

	Route::get('/customers/edit/{customer}', 				        'Customer\CustomerController@edit' )->name('customer.edit');       //Correcta: Super Admin - Sistemas - Finanzas
	Route::put('/customers/{customer}',       					 	  'Customer\CustomerController@update');													   //Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'],'/customers/validUserDni', 'Customer\CustomerController@validateDNI');												 //Correcta: Super Admin - Sistemas - Finanzas


	Route::get ('/customers/{id}',       					          'Customer\CustomerController@show'  )->name('customer.show'   );   //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/admin/customers/{id}',                     'Customer\CustomerController@show'  )->name('customerAd.show' );   //Correcta: Administracion
	Route::get('/atencion/customers/{id}',       	          'Customer\CustomerController@show'  )->name('customerAt.show' );   //Correcta: Soporte

	Route::get ('/tickets/pdf/{id}', 						 	          'Customer\CustomerController@pdf'  )->name('ticket');	             //Correcta Super Admin - Sistemas - Finanzas
	Route::get ('/admin/pdf/{id}', 						 	            'Customer\CustomerController@pdf'  )->name('admin.ticket');	       //Correcta: Administracion
	Route::get ('/atencion/pdf/{id}', 						 	        'Customer\CustomerController@pdf'  )->name('atencion.ticket');     //Correcta: Soporte
	Route::get('/tickets/getTicketforID',                	  'Customer\CustomerController@getTicketforID');
	Route::get('/admin/getTicketforID',                	    'Customer\CustomerController@getTicketforID');
	Route::get('/atencion/getTicketforID',                	'Customer\CustomerController@getTicketforID');
	Route::get('/customers/pdfTicket/{id}',                 'Ticket\TicketController@pdfTicket');
	Route::get('/customer/new',                 						'Customer\CustomerController@createshow');
	Route::POST('/customer/savecustomer',                 	'Customer\CustomerController@customerstore');
	Route::POST('/customer/transferir/',                 		'Ticket\TicketController@customerTransferir');

	Route::POST('/customer/saveDniFile',                 		'Customer\CustomerController@saveDniFile');
	Route::match(['get', 'post'], '/customers/updateBooks',  'Customer\CustomerController@UpdateBook');
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------

	//RED
	Route::get ('/net/users', 										          'Red\NetUsersController@index' );     //Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'],'/net/UsersAjax',    		  'Red\NetUsersController@netUsersAjax');

	//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	Route::post('/customer/store', 					 		            'Customer\CustomerController@store');
	Route::get ('/customer/add',                            'Customer\CustomerController@create')->name('customer.create');
	Route::post('/customer/valiteOperation', 			          'Customer\CustomerController@valiDateCodePay');
	Route::post('/customer/valiteDNI', 						          'Customer\CustomerController@validateDNI');
	Route::get('/customer/valiteDocumento', 						    'Customer\CustomerController@valiteDocumento');
	Route::post('/customer/externo/reniecPeruValidate',     'api\reniec\reniecController@reniecPeruValidate');


	//config imprimir
	Route::get ('/customers/imprimir/block',  'config\prints\printController@printBlock');
	Route::get ('/customers/print/blocks/{obj}/{date}/{city}',  'config\prints\printController@pdfBlock');
	//fin de imprimir reportes


	//Reportes
	// ---------------------------------------------------------------------------------- Inicio de Reportes
	//reporte ventas winIstoShare // Win ventas
	//--vista reporte
	Route::get('/report/reportView','Report\ReportController@reportView');
	//Execel
	Route::get('/report/orderWinIsToShareExcel','Report\ReportController@orderWinIsToShareExcel');
	//--vista register Ticket
	Route::post('/report/customerRedTaxiWin','Report\ReportController@getRedTaxiWin');
	Route::post('/report/customerWinIstoShareAndTaxiWin','Report\ReportController@customerWinIstoShareAndTaxiWin');

	//reporte ventas taxiwin // Win ventas --vista reporte
	Route::post('/report/customerTaxiwin','Report\ReportController@customerTaxiwin');
	//reporte ventas winistoshare // Win isto share --vista reporte
	Route::post('/report/customerWinistoshare','Report\ReportController@customerWinistoshare');

	// ---------------------------------------------------------------------------------- fin de  Reportes
	Route::get('/report/finanzas/usuario','Report\ReportFinanzasController@reportTicketGenerate');

	//---------------------------------------------------------------------------------------------Finansas customer

	//Vista de red Arbol
	Route::get('/customer/viewFinance','Customer\FinanceCustomerController@viewFinanceCustomer');
	Route::post('/customer/tree','Customer\FinanceCustomerController@tree');

	//reporte excel
	Route::get('/customer/reportRedExcel','Customer\FinanceCustomerController@reportRedExcel');

	//---------------------------------------------------------------------------------------------Finansas customer
	//enviar msm
	Route::post('/customer/mensaje','api\msm\msmController@enviarMsm');
	Route::get('/customer/msm/','api\msm\msmController@msmView');

	//api culqi
	Route::post('/customer/api/culqi/save', 'CapitalDriver\CapitalDriverController@saveCharge');
	Route::post('/customer/order', 'Customer\CustomerController@saveOrder');

	// AJAX
	Route::get('/states/{id}',          'General\ControllerGeneral@getStates');
	Route::get('/cities/{id}',          'General\ControllerGeneral@getCities');
	Route::get('/districts/{id}',       'General\ControllerGeneral@getDistricts');
	Route::post('/customer/getState', 	'Customer\CustomerController@getState');
	Route::post('/customer/getCity', 	  'Customer\CustomerController@getCity');


	Route::get('/viewCustomersDup',  'Test\TestController@CustomerDNIduplicados');


	Route::get('/customer/test',  'Customer\CustomerController@viewTest');
	Route::get('/customer/form',  'Customer\CustomerController@viewFormulario');
	Route::post('/customer/testDB',  'Customer\CustomerController@getCustomer');
	Route::post('/customer/form/register',  'Customer\CustomerController@registerForm');
	Route::get('/customer/form/votaciones',  'Customer\CustomerController@exporForm');

	Route::get('/freshdesk/listgroups',  'api\freshdesk\freshdeskController@getGrupos');
	Route::get('/dataoff',  'test\testController@exportar');

	Route::post('/users/exeterno/perfilSave', 	'Driver\Externo\ExternalDriverController@storeperfil');
	Route::post('/users/exeterno/register', 	'Driver\Externo\ExternalDriverController@store');
	Route::post('/users/exeterno/fileSave', 	'Driver\Externo\ExternalDriverController@filesaves');

	Route::get('/driver/driverlist',          'Driver\Externo\ExternalDriverController@getDrivers');
	Route::get('/driver/driverlist/usuario/{user}',          'Driver\Externo\ExternalDriverController@listDriver_id');
	Route::post('/driver/externo/placaval', 	'Driver\Externo\ExternalDriverController@validateplaca2');

	//saeg---------------------------------------------
	Route::get('/driver/saeg/list',          'Driver\Externo\ExternalDriverController@showLis');
	Route::post('/driver/saeg/list/drivers',          'Api\Saeg\saegController@getDataList');
	Route::get('/driver/saeg/get/antecedente',          'Api\Saeg\saegController@getData');
	Route::get('/driver/saeg/pdf/antecedente/{id}',          'Api\Saeg\saegController@pdfAntecedentes');
	////saeg---------------------------------------------

	Route::post('/driver/externo/officeval', 	'Driver\Externo\ExternalDriverController@validateoffice');
	Route::post('/driver/externo/dnival', 	'Driver\Externo\ExternalDriverController@validatedni');
	Route::post('/driver/externo/licencevalexi', 	'Driver\Externo\ExternalDriverController@validatelicenceexi');
	Route::post('/driver/externo/placavalexi', 	'Driver\Externo\ExternalDriverController@validateplacaexi');
	Route::post('/driver/externo/validatelice', 	'Driver\Externo\ExternalDriverController@validatelic');
	Route::post('/driver/externo/licenciaval', 	'Driver\Externo\ExternalDriverController@validatelicencia');
	Route::get('/driver/pays', 	'Driver\Externo\ExternalDriverController@viewpays');
	Route::match(['get', 'post'],'/getDriverAprovedListView','Driver\Externo\ExternalDriverController@getDriverAprovedListView');
  Route::match(['get', 'post'],'/driverStatusPay','Driver\Externo\ExternalDriverController@updatedriverStatusPay');
	Route::get('/getDriverAprovedListViewbyCreated/{iduser}',  'Driver\Externo\ExternalDriverController@getDriverAprovedListViewByID');
	Route::post('/driver/externo/getAuditsbyID', 	'Driver\Externo\ExternalDriverController@getAuditsbyID');
	Route::get('/driver/externo/getAudits', 	'Driver\Externo\ExternalDriverController@getAudits');


// Route::get('/eventowin/buscar', 	'Driver\ControllerDriver@viewEvento');
// Route::get('/eventowin/agregar', 	'Driver\ControllerDriver@viewAgregar');
// Route::POST('/evento/get/documento', 	'Driver\ControllerDriver@getTypeDocument');
// Route::POST('/evento/create', 	'Driver\ControllerDriver@createEvento');
// Route::POST('/evento/get/id', 	'Driver\ControllerDriver@getDataEvento');
// Route::POST('/evento/get/dni', 	'Driver\ControllerDriver@getDataDni');
// Route::POST('/evento/get/email', 	'Driver\ControllerDriver@getDataEmail');
// Route::POST('/evento/get/phone', 	'Driver\ControllerDriver@getDataPhone');
// Route::POST('/evento/update', 	'Driver\ControllerDriver@updateEvento');
//
// Route::get('/eventowin/agregar/data', 	'Driver\ControllerDriver@insertData');

//oficina virtual
Route::get('/getValidateOV', 'api\OficinaVirtual\OffiViController@getByUsernameOV');
Route::get('/cambiar-contrasena-ov-user', 'api\OficinaVirtual\OffiViController@cambiarPaswordOvUser' )->name('officeVirtuals.cambiarPaswordOvUser');
Route::post('/saveContrasenaOV', 			'api\OficinaVirtual\OffiViController@saveContrasenaOV')->name('officeVirtuals.saveContrasenaOV');
Route::get('/oficinavirtual', 'api\OficinaVirtual\OffiViController@viewOficinaVirtual');
Route::get('/ov/getuserslist', 'api\OficinaVirtual\OffiViController@getuserslist');

});

  //API UPDATE
  Route::match(['get', 'post'],'/conductor/migratedlist','Driver\ControllerDriverApp@getDriverMigrats');
  Route::match(['get', 'post'],'/getDriverMigratesView','Driver\ControllerDriverApp@getDriverMigratesView');
	Route::match(['get', 'post'],'/upDocumentosVehicle',         'Driver\ControllerDriverApp@upDocumentosVehicle');
  Route::match(['get', 'post'],'/getDataSendingMigrateVehicle','Driver\ControllerDriverApp@getDataSendingMigrateVehicle');

	//API VALIDACION
	Route::match(['get', 'post'],'/validarDriverProceso', 'Driver\ControllerDriverApp@validDriverProcess');
	Route::match(['get', 'post'],'/metadataApi',          'Driver\ControllerDriverApp@getMetadataApi');
	Route::match(['get', 'post'],'/getModalValidate',     'Driver\ControllerDriverApp@getModalValidate');
	Route::match(['get', 'post'],'/getDataSending',       'Driver\ControllerDriverApp@getDataSending');
	Route::match(['get', 'post'],'/getDriverAprovedsView','Driver\ControllerDriverApp@getDriverAprovedsView');
	Route::match(['get', 'post'],'/upDocumentos',         'Driver\ControllerDriverApp@upDocumentos');
	Route::match(['get', 'post'],'/upDriver',             'Driver\ControllerDriverApp@upDriver');
	Route::match(['get', 'post'],'/driverStatusApi',      'Driver\ControllerDriverApp@driverStatusApi');
	Route::match(['get', 'post'],'/getDataSendingVehicle','Driver\ControllerDriverApp@getDataSendingVehicle');
	Route::match(['get', 'post'],'/conductores/aprobados','Driver\ControllerDriverApp@getDriverAproveds');




	//GET ROL
	Route::match(['get', 'post'], '/getRolValid','User\UserController@getRolValid'    );											 //



//------------------------ registrar ticket Externo
	Route::get('/gtcn9XvGi5', 	  'Auth\LoginController@showLoginForm');
	//lista de PRODUCTOS
	Route::get('/productos/acciones', 	  'Customer\ApiCustomerController@showCompras');
	Route::get('/lista/productos/acciones/pruduct', 	  'Customer\ApiCustomerController@listProductsTienda');
	Route::get('/producto/registro-pago/{id}', 	  'Customer\ApiCustomerController@showShopping');
	Route::post('/customer/register/exeterno', 	  'Customer\ApiCustomerController@store');
	Route::get('/checkout/ticket/{id}', 	  'Customer\ApiCustomerController@viewcheckout');
	Route::get('/checkout/ticket/view/{id}', 	  'Customer\ApiCustomerController@checkoutpdf');
	Route::post('/customer/register/exeterno/actualizarti', 	'Customer\ApiCustomerController@actualizarticket');

	//
	Route::post('/customer/getCustomerByApi', 'Customer\ApiCustomerController@getCustomerByApi');
	//

	Route::get('/customer/register/add', 	  'Customer\ApiCustomerController@showCustomerExterno');
	Route::post('/customer/register/get',   'Customer\ApiCustomerController@getCustomer');
	Route::post('/customer/register/getState', 	'Customer\ApiCustomerController@getState');
	Route::post('/customer/register/getCity', 	  'Customer\ApiCustomerController@getCity');
	Route::post('/customer/register/valiteDNI', 	'Customer\ApiCustomerController@validateDNI');
	Route::post('/customer/register/exeterno/keyPrivate', 	'api\Culqi\CulqiController@keyPrivate');
	Route::post('/customer/register/exeterno/order', 	'api\Culqi\CulqiController@order');
	Route::post('/customer/register/exeterno/tarjeta', 	'api\Culqi\CulqiController@pay');

///COnductor externo
	Route::post('/users/exeterno/id', 	'Driver\Externo\ExternalDriverController@getUsers');

	//agregue
	Route::post('/updateFormDriver', 	'Driver\ControllerDriver@updateDriver');
	Route::POST('/driver/saveFile',  	'Driver\ControllerDriver@updFile');

	Route::POST('/permisosProcessValid',  	'Driver\ControllerDriver@permisosProcessValid');
  Route::get ('/API/getDriver/{dni}',     'Test\TestController@returnDriversID');

  Route::post('/deleteProcessValid',  	'Driver\ControllerDriver@deleteProcessValid');



	Route::get ('/record/driver/{id}',       		    'Driver\ControllerDriver@recordDriver');
	Route::post('/record/driver/getRecordRango',    'Driver\ControllerDriver@recordRango');
	Route::post('/driver/externo/saveRecord', 	    'Driver\ControllerDriver@saveRecord');
	Route::post('/driver/externo/validarProceso',   'Driver\ControllerDriver@validarProceso');
  Route::post('/driver/externo/validarProcesoIDOffice',   'Driver\ControllerDriver@validarProcesoIDOffice');

	Route::get('/driver/externo/sendAppDataVehicle/{id}', 	'Driver\ControllerDriver@sendAppDataVehicle');
	Route::get('/driver/externo/sendAppDataDriver/{id}', 	'Driver\ControllerDriver@sendAppDataDriver');

	Route::get('/driver/externo/list', 	'Driver\ControllerDriver@listshow');
	Route::post('/driver/externo/get', 	'Driver\Externo\ExternalDriverController@getDriverFile');
	Route::post('/driver/externo/get2', 	'Driver\Externo\ExternalDriverController@getDrivers2');

	Route::post('/driver/externo/getDataProceso', 	'Driver\ControllerDriver@getDataProceso');

	Route::post('/users/exeterno/register/docs', 	'Driver\Externo\ExternalDriverController@storedocs');
	Route::post('/driver/externo/get/img', 	'Driver\Externo\ExternalDriverController@getimgfile');
	Route::post('/driver/externo/updateObse', 	'Driver\Externo\ExternalDriverController@updateObserva');
	Route::get('/driver/externo/details/{id}', 	'Driver\ControllerDriver@detailshow');
	Route::get('/driver/externo/details/reporte/{id}', 	'Driver\ControllerDriver@reportPDF');
	Route::get('/driver/externo/rtpdf/{id}', 	'Driver\Externo\ExternalDriverController@checkpdf');
	Route::post('/driver/externo/licenceval', 	'Driver\Externo\ExternalDriverController@validatelicense');
	Route::get('/driver/externo/subir', 	'Driver\ControllerDriver@uploadView');
	Route::post('/driver/externo/upload', 	'Driver\ControllerDriver@saveAntecendetes');
	Route::post('/driver/externo/getdad', 	'Driver\ControllerDriver@getuserDri');
	Route::get('/driver/externo/report/record/{id}', 	'Driver\ControllerDriver@reportePDFRecord');
	Route::get('/actualizardocumentos', 	  'Driver\Externo\validateContacController@updatedocs');
	Route::post('/driver/externo/validate/getbylicence', 	  'Driver\Externo\validateContacController@getbylicence');
	Route::post('/driver/update/documents', 	  'Driver\Externo\validateContacController@updatedocuments');
	Route::post('/driver/externo/filesupdate', 	  'Driver\Externo\validateContacController@filesupdate');
	Route::get('/actualizardocumentos', 	  'Driver\Externo\validateContacController@updatedocs');
	Route::get('/cambiarvehiculo', 	  'Driver\Externo\validateContacController@changevehiclext');
	Route::post('/driver/externo/validate/getDriver', 	  'Driver\Externo\validateContacController@getDriver');
	Route::post('/driver/externo/validate/placavalexi', 	'Driver\Externo\validateContacController@validateplacaexi');
	Route::post('/driver/validate/updateauto', 	'Driver\Externo\validateContacController@updateauto');
	Route::get('/validardatos',  'Driver\Externo\validateContacController@viewConfimation');

	//attentions Face to Face
	Route::get('/atencion/attentionsIndex',  'AtencionCliente\AtencionClienteController@attentionsIndex');
	Route::get('/atencion/customer/driver/getVal',         		'Driver\ControllerDriver@getCustomerValidate');
	Route::post('/atencion/facetoface/store',         	'AtencionCliente\AtencionClienteController@facetofacestore');
	Route::get('/atencion/viewatencions',         							'AtencionCliente\AtencionClienteController@viewatencions');
	Route::get('/atencion/facetofacegetatencions', 	'AtencionCliente\AtencionClienteController@facetofacegetatencions');
	Route::get('/atencion/atentionsadmin', 	'AtencionCliente\AtencionClienteController@atentionsadmin');
	Route::post('/atencion/availability',         	'AtencionCliente\AtencionClienteController@updateavailability');
	Route::get('/atencion/listatentionmoduls',  'AtencionCliente\AtencionClienteController@listatentionmoduls');
	Route::get('/atencion/listatentionsopen',  'AtencionCliente\AtencionClienteController@listatentionsopen');
	Route::post('/atencion/updateStatusT',     'AtencionCliente\AtencionClienteController@updateStatusT');
	Route::post('/atencion/getNextAtention',     'AtencionCliente\AtencionClienteController@getNextAtention');
	Route::get('/atencion/registerserviced',  'AtencionCliente\AtencionClienteController@registerserviced');
	Route::post('/atencion/getReportAtention',     'AtencionCliente\AtencionClienteController@getReportAtention');
	Route::post('/atencion/updateTicketStatus',     'AtencionCliente\AtencionClienteController@updateTicketStatus');
	//
