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

Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {


	Route::group(['prefix' => 'assets','middleware' => ['role:admin|manager|technician']], function() {

		Route::get('/', ['as'=>'admin.assets.index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@index']);

		Route::get('/create', ['as'=>'admin.assets.create','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@create']);
		Route::post('/store', ['as'=>'admin.assets.store','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@store']);
		Route::post('/update', ['as'=>'admin.assets.update','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@update']);
		Route::get('/show/{id}', ['as'=>'admin.assets.show','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@show']);
		Route::get('/edit/{id}', ['as'=>'admin.assets.show','middleware' => ['permission:create_asset'], 'uses' => 'AssetsController@edit']);


		Route::get('/network_index', ['as'=>'admin.assets.network_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@networkIndex']);
		Route::get('/gateway_index', ['as'=>'admin.assets.gateway_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@gatewayIndex']);
		Route::get('/pbx_index', ['as'=>'admin.assets.pbx_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@pbxIndex']);
		Route::get('/server_index', ['as'=>'admin.assets.server_index','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@serverIndex']);

			Route::get('/network_index_bycustomer/{id}', ['as'=>'admin.assets.network_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@networkIndex']);

		Route::get('/gateway_index_bycustomer/{id}', ['as'=>'admin.assets.gateway_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@gatewayIndex']);

		Route::get('/pbx_index_bycustomer/{id}', ['as'=>'admin.assets.pbx_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@pbxIndex']);

		Route::get('/server_index_bycustomer/{id}', ['as'=>'admin.assets.server_index_by_cust','middleware' => ['permission:list_assets'], 'uses' => 'AssetsController@serverIndex']);



	});

	Route::group(['prefix' => 'knowledge','middleware' => ['role:admin|manager|technician']], function() {

		Route::get('/', ['as'=>'admin.knowledge.all','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@index']);

		Route::get('/passwords', ['as'=>'admin.knowledge.passwords','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@passwordsIndex']);



		Route::get('/passwords_bycustomer/{id}', ['as'=>'admin.knowledge.passwords_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@passwordsIndex']);


		Route::post('/password', ['as'=>'admin.knowledge.store.password','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storePassword']);
		Route::get('/edit/password/{id}', ['as'=>'admin.knowledge.edit.password','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editPassword']);

		Route::post('/update/password', ['as'=>'admin.knowledge.update.password','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updatePassword']);

		Route::get('/delete/password/{id}', ['as'=>'admin.knowledge.delete.password','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deletePassword']);



		Route::get('/procedures', ['as'=>'admin.knowledge.procedures','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@proceduresIndex']);

		Route::get('/procedures_bycustomer/{id}', ['as'=>'admin.knowledge.procedures_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@proceduresIndex']);

		Route::post('/procedure', ['as'=>'admin.knowledge.store.procedure','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storeProcedure']);
		Route::get('/edit/procedure/{id}', ['as'=>'admin.knowledge.edit.procedure','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editProcedure']);

		Route::post('/update/procedure', ['as'=>'admin.knowledge.update.procedure','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updateProcedure']);

		Route::get('/delete/procedure/{id}', ['as'=>'admin.knowledge.delete.procedure','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deleteProcedure']);



		Route::get('/serial_numbers', ['as'=>'admin.knowledge.serial_numbers','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@serialnumberIndex']);

		Route::get('/serial_numbers_bycustomer/{id}', ['as'=>'admin.knowledge.serial_numbers_by_cust','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@serialnumberIndex']);

		Route::post('/serial_number', ['as'=>'admin.knowledge.store.serial_number','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@storeSerialNumber']);
		Route::get('/edit/serial_number/{id}', ['as'=>'admin.knowledge.edit.serial_number','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@editSerialNumber']);

		Route::post('/update/serial_number', ['as'=>'admin.knowledge.update.serial_number','middleware' => ['permission:add_knowledge'], 'uses' => 'KnowledgeController@updateSerialNumber']);

		Route::get('/delete/serial_number/{id}', ['as'=>'admin.knowledge.delete.serial_number','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@deleteSerialNumber']);

		Route::get('/type/{type}/{id}', ['as'=>'admin.knowledge.show','middleware' => ['permission:view_knowledge'], 'uses' => 'KnowledgeController@show']);


		

	});
		/*Route::group(['prefix' => 'assets'], function() {
			Route::get('/', function() {
				dd('This is the Assets module index page.');
			});
		});*/
});
