<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function(){
	Route::post('login', 'API\LoginController@login');
	Route::group(['middleware' => 'auth:api'], function(){
		Route::get('logout', 'API\LoginController@logout');
		Route::get('user', 'API\LoginController@user');
		//storeInspection
		Route::post('storeInspection', 'API\ApiController@storeInspection');
		Route::post('getInspection', 'API\ApiController@getInspection');
		//po
		Route::post('deletePo', 'API\ApiController@deletePo');
		Route::post('deletePoImage', 'API\ApiController@deletePoImage');
		//trim
		Route::post('deleteTrim', 'API\ApiController@deleteTrim');
		//packImage
		Route::post('deletePackImage', 'API\ApiController@deletePackImage');
		//deleteAdditionalImage
		Route::post('deleteAdditionalImage', 'API\ApiController@deleteAdditionalImage');
		Route::get('download-inspection/{id}', 'API\ApiController@downloadInspection');
        Route::get('get-history', 'API\ApiController@getHistory');
        Route::post('deleteDefect', 'API\ApiController@deleteDefect');

	});

});
Route::get('download-inspection/{id}', 'API\ApiController@downloadInspection');
