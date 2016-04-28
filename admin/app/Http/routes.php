<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('home', 'HomeController@index');
Route::controller('/partner', 'PartnerController');

//Route::post('auth', 'AuthController@autheticate');

Route::controller('/user', 'UserController');
Route::controller('/campaign', 'CampaignController');
Route::controller('/inventory', 'InventoryController');
Route::controller('/directory', 'DirectoryController');
Route::controller('/cron', 'CronController');
Route::controller('/redeemar', 'RedeemarController');

Route::group(['namespace'=> 'Admin' , 'middleware' => 'auth'] , function(){

	Route::controller('/admin/dashboard','DashboardController'); 
	
});
