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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('createuser', 'ApiController@createuser');
Route::post('login', 'ApiController@login');


Route::post('patientLogin', 'MyController@patientLogin');
Route::post('doctorLogin', 'MYController@doctorLogin');
Route::post('patientRegister', 'MyController@patientRegister');
Route::post('doctorRegister', 'MyController@doctorRegister');
	

Route::group(['prefix' => 'patient','middleware' => ['assign.guard:patient','jwt.auth']],function ()
{
	Route::get('/demo','PatientController@demo');	
});

Route::group(['prefix' => 'doctor','middleware' => ['assign.guard:doctor','jwt.auth']],function ()
{
	Route::get('/demo','DoctorController@demo');	
});
