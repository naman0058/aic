<?php

use Illuminate\Support\Facades\Route;

Route::get('/',function(){
	return redirect('login');
});

Auth::routes();
Route::group(['middleware'=>'auth'],function(){

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('/dashboard', function () {
	    return view('admin.dashboard.index');
	    })->name('dashboard');

	//staff	
	Route:: resource('staff','StaffController');
	Route::get('filter_staff', [
				'as' => 'filter_staff', 'uses' => 'StaffController@filter_staff'
	]);
	Route::post('staffStore', [
				'as' => 'staffStore', 'uses' => 'StaffController@store'
	]);
	Route::post('staffUpdate', [
				'as' => 'staffUpdate', 'uses' => 'StaffController@update'
	]);
	Route::post('staff/delete', [
				'as' => 'staff/delete', 'uses' => 'StaffController@destroy'
	]);
	Route::post('staffView', [
				'as' => 'staffView', 'uses' => 'StaffController@staffView'
	]);
	//style
	Route:: resource('inspection','InspectionController');
	Route::get('filter_inspection', [
				'as' => 'filter_inspection', 'uses' => 'InspectionController@filter_inspection'
	]);
	Route::get('download-inspection/{id}', [
				'as' => 'download-inspection', 'uses' => 'InspectionController@downloadInspection'
	]);
 
});
