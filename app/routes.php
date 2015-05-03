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

	Route::get('school-year/{school_year}/activate', ['as' => 'backend.school-year.activate', 'uses' => 'SchoolYearController@activate']);
	Route::resource('school-year', 'SchoolYearController');
    Route::resource('school-year.year-level', 'YearLevelController');
    Route::post('school-year/{school_year}/personels/existing', ['as' => 'backend.school-year.personels.storeFromExisting', 'uses' => 'SchoolRecordsPersonelController@storeFromExisting']);
	Route::resource('school-year.personels', 'SchoolRecordsPersonelController');
	Route::resource('school-year.departments', 'DepartmentsController');
	Route::resource('school-year.sections', 'SectionsController');
	Route::resource('school-year.subjects', 'SubjectsController');

});
