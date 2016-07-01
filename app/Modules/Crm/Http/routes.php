<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::group(['prefix' => 'crm'], function() {
	Route::get('/', function() {
		dd('This is the Crm module index page.');
	});
});*/

Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {




	Route::group(['prefix' => 'crm','middleware' => ['role:admin|manager|technician']], function() {
		
		Route::get('/', ['as'=>'admin.crm.index','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@index']);
		Route::get('/data_index', ['as'=>'admin.crm.data_index','middleware' => ['permission:list_customer'], 'uses' => 'CrmController@ajaxDataIndex']);
		Route::get('create',['as'=>'admin.crm.create','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@create']);
		Route::post('/',['as'=>'admin.crm.store','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@store']);
		Route::get('edit/{id}',['as'=>'admin.crm.edit','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@edit']);
		Route::get('show/{id}',['as'=>'admin.crm.show','middleware' => ['permission:view_customer_detail'], 'uses' => 'CrmController@show']);
		Route::delete('delete',['as'=>'admin.crm.destroy','middleware' => ['permission:delete_customer'], 'uses' => 'CrmController@destroy']);
		Route::put('/{id}',['as'=>'admin.crm.update','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@update']);

		Route::post('/ajax_data_load',['as'=>'admin.crm.ajax.load_items','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxDataLoad']);
		//Route::post('/ajax_rate_save_temporary',['as'=>'admin.crm.ajax.save_temporary_rate','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxTemporaryRateSave']);
		
		Route::post('/ajax_load_location',['as'=>'admin.crm.ajax.load_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadLocation']);
		Route::post('/ajax_update_location',['as'=>'admin.crm.ajax.update_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateLocation']);
		//Route::get('/ajax_refresh_location/{id}',['as'=>'admin.crm.ajax.refresh_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxRefreshLocation']);
		
		Route::post('/ajax_load_contact',['as'=>'admin.crm.ajax.load_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadContact']);
		Route::post('/ajax_update_contact',['as'=>'admin.crm.ajax.update_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateContact']);
		Route::get('/ajax_refresh_contacts/{id}',['as'=>'admin.crm.ajax.refresh_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxRefreshContacts']);
		
		Route::get('/ajax_load_customer_info/{id}',['as'=>'admin.crm.ajax.load_customer_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadInfo']);
		Route::post('/ajax_update_customer_info',['as'=>'admin.crm.ajax.update_customer_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateInfo']);
		Route::get('/ajax_refresh_info/{id}',['as'=>'admin.crm.ajax.refresh_info','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxRefreshInfo']);


		Route::post('/ajax_add_location',['as'=>'admin.crm.ajax.add_location','middleware' => ['permission:add_customer'], 'uses' => 'CrmController@ajaxAddLocation']);


		Route::get('/ajax_get_locations_list/{id}',['as'=>'admin.crm.ajax.get_locations_list','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxGetLocationsList']);
		Route::post('/ajax_add_contact',['as'=>'admin.crm.ajax.add_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddContact']);


		Route::post('/ajax_load_service_item',['as'=>'admin.crm.ajax.load_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadServiceItem']);
		Route::post('/ajax_update_service_item',['as'=>'admin.crm.ajax.update_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateServiceItem']);
		
		Route::get('/ajax_load_rate/{id}',['as'=>'admin.crm.ajax.get_load_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadRate']);
		Route::post('/ajax_update_rate',['as'=>'admin.crm.ajax.update_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxUpdateRate']);
		Route::post('/ajax_add_rate',['as'=>'admin.crm.ajax.add_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddRate']);

		Route::get('/load_new_service_item/{id}',['as'=>'admin.crm.ajax.load_new_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxLoadNewServiceItem']);
		Route::post('/add_service_item',['as'=>'admin.crm.ajax.add_service_item','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxAddServiceItem']);


		Route::get('/ajax_del_contact/{id}',['as'=>'admin.crm.ajax.del_contact','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteContact']);
		Route::get('/ajax_del_location/{id}/{cid}',['as'=>'admin.crm.ajax.del_location','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteLocation']);
		Route::get('/ajax_del_rate/{id}/{sid}',['as'=>'admin.crm.ajax.del_rate','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteRate']);
		Route::get('/ajax_del_sitem/{id}/{cid}',['as'=>'admin.crm.ajax.del_sitem','middleware' => ['permission:edit_customer'], 'uses' => 'CrmController@ajaxDeleteServiceItem']);



		Route::get('/ajax_customer_export_zoho/{id}',['as'=>'admin.crm.ajax.customer_export_zoho','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@ajaxExportContact']);

		Route::get('/zoho_credentials',['as'=>'admin.crm.zoho_credentials','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getForm']);
		Route::post('/zoho_store',['as'=>'admin.crm.zoho_store','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@zohoStore']);

		Route::get('/zoho_reset_token/{id}',['as'=>'admin.crm.zoho_reset_token','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@resetAuthToken']);
		Route::get('/zoho_get_contacts',['as'=>'admin.crm.zoho_get_contacts','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getContacts']);
		Route::get('/zoho_get_expenses/{id}',['as'=>'admin.crm.zoho_get_expenses','middleware' => ['permission:edit_customer'], 'uses' => 'ZohoController@getExpense']);



		//default rates
		Route::get('/list_default_rates',['as'=>'admin.crm.default_rates','middleware' => ['permission:edit_customer'], 'uses' => 'DefaultRates@index']);
		Route::get('/add_default_rate',['as'=>'admin.crm.default_rate.add','middleware' => ['permission:edit_customer'], 'uses' => 'DefaultRates@create']);
		
		Route::post('/add_default_rate',['as'=>'admin.crm.default_rate.store','middleware' => ['permission:edit_customer'], 'uses' => 'DefaultRates@store']);
		Route::get('rate_delete/{id}',['as'=>'admin.crm.default_rate.destroy','middleware' => ['permission:delete_customer'], 'uses' => 'DefaultRates@destroy']);


		Route::group(['prefix' => 'ticket'], function() {
			Route::get('/', ['as'=>'admin.ticket.index','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@index']);



			Route::get('/data_index', ['as'=>'admin.ticket.data_index','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@ajaxDataIndex']);

			Route::get('/data_index_by_cust/{id}', ['as'=>'admin.ticket.data_index_by_cust','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@ajaxDataIndex']);


			Route::get('create', ['as'=>'admin.ticket.create','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@create']);
			Route::post('create', ['as'=>'admin.ticket.store','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@store']);
			Route::get('list_own', ['as'=>'admin.ticket.list_own','middleware' => ['permission:list_assigned_ticket'], 'uses' => 'TicketController@listOwn']);

			Route::get('show/{id}', ['as'=>'admin.ticket.show','middleware' => ['permission:list_ticket'], 'uses' => 'TicketController@show']);

			Route::get('ajax_get_service_items/{id}', ['as'=>'admin.ticket.ajax_get_service_items','middleware' => ['permission:create_ticket'], 'uses' => 'CrmController@ajaxGetServiceItems']);

			Route::post('upload', ['as'=>'admin.ticket.upload','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUploadImage']);
			Route::post('ajax_del_img', ['as'=>'admin.ticket.ajax_del_img','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxDeleteImage']);

			Route::post('add_response', ['as'=>'admin.ticket.add_response','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@addResponse']);

			Route::get('getEmails', ['as'=>'admin.ticket.get_emails','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@readGmail']);

			Route::delete('delete',['as'=>'admin.ticket.destroy','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@destroy']);
			//Route::post('/',['as'=>'admin.ticket.store','middleware' => ['permission:customer_service_type_add'], 'uses' => 'TicketController@store']);
			
			Route::post('assign_users', ['as'=>'admin.crm.ajax.ticket_assign_users','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxAssignUsers']);
			Route::get('delete_user_assigned/{uid}/{tid}',['as'=>'admin.crm.ajax.ticket_delete_assigned_user','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@ajaxDeleteAssignedUser']);
			Route::get('delete_customer_assigned/{tid}',['as'=>'admin.crm.ajax.ticket_delete_assigned_customer','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'TicketController@ajaxDeleteAssignedCustomer']);


			Route::post('status_priority', ['as'=>'admin.crm.ajax.ticket_priority_status','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxUpdateStatusPriority']);

			Route::post('assign_customer', ['as'=>'admin.crm.ajax.ticket_assign_customer','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@ajaxAssignCustomer']);

		});

	Route::group(['prefix' => 'ticketstatus'], function() {
			Route::get('/', ['as'=>'admin.ticket.status.index','middleware' => ['permission:list_ticket_status'], 'uses' => 'TicketsStatus@index']);

		Route::get('create', ['as'=>'admin.ticket.status.create','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@create']);
		Route::get('edit/{id}',['as'=>'admin.ticket.status.edit','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@edit']);

		//Route::post('create', ['as'=>'admin.ticket.store','middleware' => ['permission:create_ticket'], 'uses' => 'TicketController@store']);
		Route::post('store', ['as'=>'admin.ticket.status.store','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@store']);
		Route::post('/update', ['as'=>'admin.ticket.status.update','middleware' => ['permission:create_ticket_status'], 'uses' => 'TicketsStatus@update']);
		Route::get('/status_list', ['as'=>'admin.tickets.status.list', 'uses' => 'TicketsStatus@index']);	

		Route::get('delete_ticket_status/{id}', ['as'=>'admin.tickets.status.delete', 'middleware' => ['permission:delete_ticket_status'],'uses' => 'TicketsStatus@ajaxDelete']);	
	});

	

	Route::group(['prefix' => 'service'], function() {
					Route::get('/', ['as'=>'admin.service_item.index','middleware' => ['permission:customer_service_type_list'], 'uses' => 'ServiceItemsController@index']);
			Route::get('create', ['as'=>'admin.service_item.create','middleware' => ['permission:customer_service_type_add'], 'uses' => 'ServiceItemsController@create']);
			Route::get('delete/{id}',['as'=>'admin.service_item.destroy','middleware' => ['permission:customer_service_type_delete'], 'uses' => 'ServiceItemsController@destroy']);
			Route::post('/',['as'=>'admin.service_item.store','middleware' => ['permission:customer_service_type_add'], 'uses' => 'ServiceItemsController@store']);
		});

	Route::group(['prefix' => 'billing'], function() {
			Route::get('/', ['as'=>'admin.billing.index','middleware' => ['permission:customer_billing_list'], 'uses' => 'BillingPeriodsController@index']);
			//Route::get('create', ['as'=>'admin.billing.create','middleware' => ['permission:customer_billing_add'], 'uses' => 'BillingPeriodsController@create']);
			Route::get('delete/{id}',['as'=>'admin.billing.destroy','middleware' => ['permission:customer_billing_delete'], 'uses' => 'BillingPeriodsController@destroy']);
			Route::post('/',['as'=>'admin.billing.store','middleware' => ['permission:customer_billing_add'], 'uses' => 'BillingPeriodsController@store']);
		});
	});



	//Route::resource('/crm','EmployeeController');
	//Route::resource('/raise','RaiseController');

	//Route::get('calander','EmployeeController@googleCalander');
});