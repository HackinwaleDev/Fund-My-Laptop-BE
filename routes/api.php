<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Authentication
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api',  'prefix' => 'v1'], function () {
	/*Route::get('/user', function (Request $request) {
    	return $request->user();
	});*/
	///all other routes should be defined under this line using the format of line 25 (above)
	Route::get('recommendations', 'RecommendationController@index');
	Route::get('my-profile', 'UserController@getMyProfile');
	Route::get('user-details', 'UserController@getUserDetails');
	Route::get('/requests', 'RequestController@index');
});

Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail'); //For sending email link
Route::post('/password/reset', 'Api\ResetPasswordController@reset');  //For resetting the password

Route::fallback(function () {
	return response()->json(['message' => 'Not Found'], 404);
})->name('api.fallback.404');
