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


//Route::group(['prefix' => 'admin','middleware' => ['emp_admin','role:admin']], function() {
Route::group(['prefix' => 'admin','middleware' => 'admin'], function() {
	/*Route::get('/', function() {
		 dd(
            'This is the Blog module index page.',
            session()->all()
        );
		//dd('This is the Employee module index page.');
		 return view('employee::admin.welcome');
	});*/
	Route::group(['prefix' => 'employee','middleware' => ['role:admin|manager|technician']], function() {
		
		Route::get('/', ['as'=>'admin.employee.index','middleware' => ['permission:list_employee'], 'uses' => 'EmployeeController@index']);
		Route::get('create',['as'=>'admin.employee.create','middleware' => ['permission:add_employee'], 'uses' => 'EmployeeController@create']);
		Route::post('/',['as'=>'admin.employee.store','middleware' => ['permission:add_employee'], 'uses' => 'EmployeeController@store']);
		Route::post('/ajax_update',['as'=>'admin.employee.ajax_store','middleware' => ['permission:add_employee'], 'uses' => 'EmployeeController@ajaxStore']);

		Route::get('/get_user/{id}', ['as'=>'admin.employee.get_ajax_user','middleware' => ['permission:list_employee'], 'uses' => 'EmployeeController@getById']);
		Route::get('edit/{id}',['as'=>'admin.employee.edit','middleware' => ['permission:edit_employee'], 'uses' => 'EmployeeController@edit']);
		Route::delete('delete',['as'=>'admin.employee.destroy','middleware' => ['permission:delete_employee'], 'uses' => 'EmployeeController@destroy']);
		Route::put('/{id}',['as'=>'admin.employee.update','middleware' => ['permission:edit_employee'], 'uses' => 'EmployeeController@update']);
	
		Route::group(['prefix' => 'leave'], function() {
		
			Route::get('/', ['as'=>'employee.leave.index','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@index']);
			Route::get('create', ['as'=>'employee.leave.create','middleware' => ['permission:post_leave'], 'uses' => 'LeaveController@create']);
			Route::delete('delete',['as'=>'employee.leave.destroy','middleware' => ['permission:delete_leave'], 'uses' => 'LeaveController@destroy']);
			Route::post('/',['as'=>'employee.leave.store','middleware' => ['permission:post_leave'], 'uses' => 'LeaveController@store']);

			Route::get('/pending_leaves', ['as'=>'admin.leave.pending','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@listPendingLeaves']);
			Route::get('/rejected_leaves', ['as'=>'admin.leave.rejected','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@listRejectedLeaves']);
			Route::get('/calendar', ['as'=>'admin.leave.calendar','middleware' => ['permission:list_leaves'], 'uses' => 'LeaveController@showCalendar']);

		});
		Route::group(['prefix' => 'leave'], function() {
			Route::post('/postToCalendar', ['as'=>'admin.leave.posttocalendar','middleware' => ['permission:approve_leave'], 'uses' => 'LeaveController@postCalander']);
			Route::post('/rejectLeave', ['as'=>'admin.leave.reject_leave','middleware' => ['permission:reject_leave'], 'uses' => 'LeaveController@rejectLeave']);
		});
	});


	//Route::resource('/employee','EmployeeController');
	Route::resource('/raise','RaiseController');

	Route::get('calander','EmployeeController@googleCalander');
});