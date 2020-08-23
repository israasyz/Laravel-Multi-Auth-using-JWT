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



Route::post('adminLogin', 'MyController@adminLogin');
Route::post('adminRegister', 'MyController@adminRegister');
Route::post('logout', 'MyController@logout');
	

Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admin', 'admin.auth.role:admin', 'jwt.auth']],function ()
{
	Route::get('/admindemo','MyController@demo_admin');
		
});

Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admin', 'admin.auth.role:lab', 'jwt.auth']],function ()
{
	Route::get('/labdemo','MyController@demo_lab');
		
});

Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admin','admin.auth.role:pharm','jwt.auth']],function ()
{
	Route::get('/pharmdemo','MyController@demo_pharm');
		
});


Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admin', 'admin.auth.role:reserve', 'jwt.auth']],function ()
{
	Route::get('/reservedemo','MyController@demo_reserve');
		
});
