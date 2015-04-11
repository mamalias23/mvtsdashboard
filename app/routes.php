<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('/backend/dashboard');
});

Route::get('/test', 'HomeController@showWelcome');

Route::group(array('prefix'=>'backend'), function() {

	Route::controller('dashboard', 'DashboardController');
	Route::controller('user', 'UserController');
	Route::controller('school-year', 'SchoolYearController');
	Route::controller('year-level', 'YearLevelController');

});
